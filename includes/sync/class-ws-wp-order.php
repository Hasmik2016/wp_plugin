<?php

class WsWpOrderExporter {

	public static $log = "";
	public static $soap = null;
	public static $has_error = 0;


	public static function current_date() {
		return date( 'd/m/y H:i:s' );
	}


	public static function appendLog() {
		$upload_dir = wp_upload_dir();
		$dir        = $upload_dir['basedir'] . '/ws-wp-sync/log/order_export_log/';
		wp_mkdir_p( $dir );
		$files        = glob( $dir . '/*' ); // get all file names
		$weeks        = get_option( 'ws_wp_import_log_weeks', 2 );
		$week_expires = strtotime( "- $weeks week" );
		if ( $files ) {
			foreach ( $files as $filename ) { // iterate files
				$file_date_created = strtotime( str_replace( '_', '/', str_replace( '.txt', '', basename( $filename ) ) ) );
				if ( is_file( $filename ) && $file_date_created <= $week_expires ) {
					unlink( $filename );
				} // delete file
			}
		}
		$today = strtotime( 'today' );
		$today = date( 'Y_m_d', $today );
		if ( self::$has_error ) {
			Ws_Wp_Sync_Admin::email_error( self::$log, 'order' );
		}
		file_put_contents( $dir . '/' . $today . '.txt', self::$log, FILE_APPEND );
	}

	public static function get_sales_customer_id() {
		$customer_id = get_option( 'ws_wp_sales_customer_id', 0 );

		return $customer_id;
	}

	public static function get_sales_person() {
		$sales_person = get_option( 'ws_wp_sales_person', "" );

		return $sales_person;
	}

	public static function get_shipping_product_id() {
		$shipping_product_id = get_option( 'ws_wp_shipping_product_id', "" );

		return $shipping_product_id;
	}


	public static function update_customer_id( $id ) {
		update_option( 'ws_wp_sales_customer_id', $id );
	}

	public static function update_sales_person( $name ) {
		update_option( 'ws_wp_sales_person', $name );
	}


	public static function update_shipping_product_id( $id ) {
		update_option( 'ws_wp_shipping_product_id', $id );
	}

	public static function get_active_gateways() {
		$active_gateways = array();
		if ( function_exists( 'WC' ) ) {
			$gateways = WC()->payment_gateways->payment_gateways();
			foreach ( $gateways as $id => $gateway ) {
				if ( isset( $gateway->enabled ) && $gateway->enabled == 'yes' ) {
					$active_gateways[ $id ] = array( 'title' => $gateway->title, 'supports' => $gateway->supports );
				}
			}
		}

		return $active_gateways;
	}

	public static function order_completed( $order_id ) {
		global $WsWp_public, $WsWp_i18n;
		// order object (optional but handy)
		$order  = new WC_Order( $order_id );
		$server = $WsWp_public->get_soap_connection();
		WsWpProductImporter::set_product_mappings();
		WsWpProductImporter::set_product_defaults();
		if ( $server->is_valid() ) {
			if ( $server->do_orders ) {
				$invoice          = new TInvoice();
				$invoiceOptions   = new TInvoiceOptions();
				$customer         = new TCustomer();
				$payment          = new TPayment();
				$invoiceLines     = array();
				$customer->Number = WsWpOrderExporter::get_sales_customer_id();
				WsWpLogger::append_order_export( __( 'Starting order export to dk.', $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( "Starting order export to dk.", $WsWp_i18n->get_domain() ) );
				/*try {
					$customers = $server->soap()->GetCustomersEx(1, 2);
				} catch (SoapFault $fault) {
					self::$log .= self::current_date() . __(" Error: Export threw error:  ", $WsWp_i18n->get_domain()) . PHP_EOL . __("Fault code: ", $WsWp_i18n->get_domain()) . $fault->faultcode . PHP_EOL . __("Fault string: ", $WsWp_i18n->get_domain()) . $fault->faultstring . PHP_EOL;
					self::$has_error = 1;
					self::appendLog();
					return 0;
				}
				*/
				if ( ! $customer->Number ) {
					set_transient( 'ws_wp_api_customer_id_not_ok', true );
					WsWpLogger::append_order_export( __( 'Error: Order couldn\'t be exported because the customer id is not set.', $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_order_sync_error( __( 'Error: Order couldn\'t be exported because the customer id is not set.', $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( "Error: Order couldn't be exported because the customer id is not set.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::writeLogs();
					return 0;
				}
				$cOptions = new TCustomerOptions();
				try {
					$customer = $server->soap()->GetCustomer( $customer->Number, $cOptions );
				} catch ( SoapFault $fault ) {
					WsWpLogger::append_order_export( __( 'Error: Order export stopped unexpectedly.', $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_order_sync_error( __( 'Error: Order export stopped unexpectedly.', $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error:Order Export threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL );
					WsWpLogger::writeLogs();
					return 0;
				}
				if ( ! $customer->RecordID ) {
					set_transient( 'ws_wp_api_customer_id_not_found', true );
					WsWpOrderExporter::appendLog();
					WsWpLogger::append_order_export( __( 'Error: Order couldn\'t be exported because the customer id was not found.', $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_order_sync_error( __( 'Error: Order couldn\'t be exported because the customer id was not found..', $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Order couldn't be exported because the customer id was not found.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::writeLogs();
					return 0;
				}
				$payment_method_key     = $order->payment_method;
				$payment->PaymentTypeId = WsWpOrderExporter::get_payment_mapped_id( $payment_method_key );
				if ( ! $payment->PaymentTypeId ) {
					set_transient( 'ws_wp_api_payment_not_mapped', true );
					WsWpOrderExporter::$log .= WsWpOrderExporter::current_date() . __( " Error: Order couldn't be exported because the payment method is not mapped to an id.", $WsWp_i18n->get_domain() ) . PHP_EOL;
					self::$has_error = 1;
					WsWpOrderExporter::appendLog();
					WsWpOrderExporter::appendLog();
					WsWpLogger::append_order_export( __( "Error: Order couldn't be exported because the payment method is not mapped to an id.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_order_sync_error( __( "Error: Order couldn't be exported because the payment method is not mapped to an id.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Order couldn't be exported because the payment method is not mapped to an id. ".PHP_EOL."Payment id: $payment_method_key", $WsWp_i18n->get_domain() ) );
					WsWpLogger::writeLogs();

					return 0;
				}
				$option           = new TItemOptions();
				$skip_attachments = WsWpProductImporter::get_setting( 'attachments', 'skip' );
				if ( ! $skip_attachments ) {
					$option->ShowAllAttachments = true;
					$option->IncludeAttachments = true;
				}
				$skip_categories = WsWpProductImporter::get_setting( 'categories', 'skip' );
				if ( ! $skip_categories ) {
					$option->IncludeItemCategories = true;
				}
				$items = $order->get_items();
				//printr($items);
				foreach ( $items as $item ) {
					$invoiceLine          = New TInvoiceLine();
					$product_variation_id = $item['variation_id'];
					// Check if product has variation.
					if ( $product_variation_id ) {
						$product = new WC_Product( $item['variation_id'] );
					} else {
						$product = new WC_Product( $item['product_id'] );
					}
					$record_id = WsWpProductImporter::get_record_id( $product->id );
					if ( $record_id ) {
						try {
							$response = $server->soap()->GetItemFromRecordID( $record_id, $option );
						} catch ( SoapFault $fault ) {

							WsWpLogger::append_order_export( __( "Error: Order export stopped unexpectedly.", $WsWp_i18n->get_domain() ) );
							WsWpLogger::append_order_sync_error( __( "Error: Order export stopped unexpectedly.", $WsWp_i18n->get_domain() ) );
							WsWpLogger::append_dev( __( " Error: Product Sync threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . "Fault string: " . $fault->faultstring . PHP_EOL . PHP_EOL . "Error:" . $fault->getMessage() . PHP_EOL );
							WsWpLogger::writeLogs();

							return - 1;
						}
					} else {
						WsWpLogger::append_order_export( __( "Error: Order export couldn't be completed because a product from it is does not have a corresponding match on dk.", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_order_sync_error( __( "Error: Order export couldn't be completed because a product from it is does not have a corresponding match on dk.", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_dev( __( "Error: Order export couldn't be completed because a product from it is does not have a corresponding match on dk. ".PHP_EOL."Product sku:".$product->sku));
						WsWpLogger::writeLogs();


						return - 1;
					}
					// Get SKU
					$sku                           = $product->get_sku();
					$invoiceLine->ItemCode         = $sku;
					$invoiceLine->Quantity         = $item['qty'];
					$use_woo_price = get_option('ws_wp_use_woo_price', 1);
					if($use_woo_price) {
						$invoiceLine->UnitPrice        = $item['line_total'];
						$invoiceLine->UnitPriceWithTax = $item['line_tax'] + $item['line_total'];
					}
					$invoiceLines[]                = $invoiceLine;
				}
				$shipping_record_id = self::get_shipping_product_id();
				if ( $shipping_record_id ) {
					try {
						$shipping_product              = $server->soap()->GetItemFromRecordID( $shipping_record_id, $option );
						$invoiceLine                   = New TInvoiceLine();
						$sku                           = WsWpProductImporter::get_selected_option( 'sku' );
						$invoiceLine->ItemCode         = $shipping_product->$sku;
						$invoiceLine->Quantity         = 1;
						$invoiceLine->UnitPrice        = $order->get_total_shipping();
						$invoiceLine->UnitPriceWithTax = $order->get_total_shipping();
						$invoiceLines[]                = $invoiceLine;
					} catch ( SoapFault $fault ) {
						WsWpLogger::append_order_export( __( "Error: Order export couldn't be completed because the shipping id from options does not match any product on dk.", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_order_sync_error( __( "Error: Order export couldn't be completed because the shipping id from options does not match any product on dk.", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_dev( __( "Error: Order export couldn't be completed because a product from it is does not have a corresponding match on dk. ".PHP_EOL."Sipping id:".$shipping_record_id));
						WsWpLogger::writeLogs();

						return - 1;
					}

				}
				$invoice->Lines = $invoiceLines;
				/*$invoice->Text1 =
					__("Customer Name: ", $WsWp_i18n->get_domain()) . $order->billing_last_name . ' ' . $order->billing_first_name . PHP_EOL .
					__("Address: ", $WsWp_i18n->get_domain()) . $order->billing_address_1 . PHP_EOL . $order->billing_address_2 . PHP_EOL . $order->billing_city . PHP_EOL . $order->billing_country . PHP_EOL .
					__("PostCode: ", $WsWp_i18n->get_domain()) . $order->billing_postcode . PHP_EOL .
					__("Customer Phone: ", $WsWp_i18n->get_domain()) . $order->billing_phone . PHP_EOL .
					__("Payment Method: ", $WsWp_i18n->get_domain()) . $order->payment_method_title . PHP_EOL;*/
				$receiver              = new TItemReceiver();
				$receiver->Name        = $order->billing_first_name . ' ' . $order->billing_last_name;
				$receiver->Address1    = $order->billing_address_1;
				$receiver->Address2    = $order->billing_address_2;
				$receiver->City        = $order->billing_city;
				$receiver->CountryCode = $order->billing_country;
				$receiver->ZipCode     = $order->billing_postcode;
				$receiver->Email       = $order->billing_email;
				$receiver->Phone       = $order->billing_phone;
				$invoice->ItemReceiver = $receiver;
				//$invoice->Text2 = $order->customer_note;
				$invoice->Text1          = $order->customer_note;
				$payment->Amount         = $order->order_total;
				$invoice->CustomerNumber = $customer->Number;
				$invoice->Payments       = array( $payment );
				$invoice->SalePerson     = WsWpOrderExporter::get_sales_person();
				/*printr($invoice);
				printr($order);
				die();
				*/
				// we can add shipping here as a line just like above but with a certain sku
				try {
					$response = $server->soap()->CreateInvoice( $invoice, false );
				} catch ( SoapFault $fault ) {
					self::$log .= self::current_date() . __( " Error: Export threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL . __( "Error:", $WsWp_i18n->get_domain() ) . $fault->getMessage();
					self::$has_error = 1;
					self::appendLog();

					WsWpLogger::append_order_export( __( "Error: Order export stopped unexpectedly.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_order_sync_error( __( "Error: Order export stopped unexpectedly.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Export threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL . __( "Error:", $WsWp_i18n->get_domain() ) . $fault->getMessage());
					WsWpLogger::writeLogs();
					return 0;
				}
				WsWpLogger::append_order_export(__( " Successfully exported order no: ", $WsWp_i18n->get_domain() ) . $order_id . PHP_EOL );
				WsWpLogger::append_dev(__( " Successfully exported order no: ", $WsWp_i18n->get_domain() ) . $order_id . PHP_EOL);
				WsWpLogger::writeLogs();
				return 1;
			} else {
				WsWpLogger::append_order_export(__( " Successfully exported order no: ", $WsWp_i18n->get_domain() ) . $order_id . PHP_EOL );
				WsWpLogger::append_dev(__( " Successfully exported order no: ", $WsWp_i18n->get_domain() ) . $order_id . PHP_EOL);
				WsWpLogger::writeLogs();
				return 0;
			}
		} else {
			WsWpLogger::append_order_export(__( " Error: Order export couldn't be started. Order id:", $WsWp_i18n->get_domain() ) . $order_id . PHP_EOL );
			WsWpLogger::append_dev(__( " Error: Order export couldn't be started. ", $WsWp_i18n->get_domain() ) . $order_id.' '.__('Server couldn\'t be contacted, check auth data.',$WsWp_i18n->get_domain()) . PHP_EOL);
			WsWpLogger::writeLogs();
			return 0;
		}
	}

	public static function get_payment_mapped_id( $key ) {
		$mapped_id = get_option( 'ws_wp_order_payment_id_' . $key, 0 );

		return $mapped_id;
	}

	public static function update_payment_mapped_id( $key, $id ) {
		update_option( 'ws_wp_order_payment_id_' . $key, $id );
	}

}