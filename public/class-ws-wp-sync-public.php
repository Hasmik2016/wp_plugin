<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://tactica.is
 * @since      1.0.0
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/admin
 *
 */
class Ws_WP_Sync_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $name The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string $name The name of the plugin.
	 * @var      string $version The version of this plugin.
	 */
	public function __construct( $name, $version ) {
		$this->name    = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ws_Wp_Sync_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ws_Wp_Sync_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/ws-wp-sync-public.css', array(), $this->version, 'all' );

	}

	/** Add public query vars
	 *
	 * @param array $vars List of current public query vars
	 *
	 * @return array $vars
	 */
	public function add_query_vars( $vars ) {
		$vars[] = '__ws-wp-api';
		$vars[] = 'operation';
		$vars[] = 'ws_key';

		return $vars;
	}

	/** Add API Endpoint
	 *    This is where we add the endpoint for the operations
	 * @return void
	 */
	public function add_endpoint() {
		add_rewrite_rule( '^ws-wp-api\/operations\/?([0-9]+)\/?([a-f0-9]{32})?', 'index.php?__ws-wp-api=1&operation=$matches[1]&ws_key=$matches[2]', 'top' );
	}

	/**    Sniff Requests
	 *    This is where catch api requests
	 *    If $_GET['__api'] is set, we try to handle the request
	 * @return die if API request
	 */
	public function sniff_requests() {
		global $wp;
		if ( isset( $wp->query_vars['__ws-wp-api'] ) ) {
			$this->handle_request();
			exit;
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */




	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ws_Wp_Sync_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ws_Wp_Sync_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/ws-wp-sync-public.js', array( 'jquery' ), $this->version, false );

	}


	public static function getCustomers() {
		return self::loadCusomers();
	}

	public static function loadCusomers() {
		global $WsWp_public;
		$server   = $WsWp_public->get_soap_connection();
		$interval = 100;
		while ( true ) {
			$s         = get_option( 'ws_wp_last_sync_id_customer', 0 ) + 1;
			$customers = $server->soap()->GetCustomersEx( $s, $s + $interval );
			if ( empty( $customers ) ) {

				wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&tab=customers&cUpdated=0' ) );
				exit();
			}

			foreach ( $customers as $customer ) {
				$email_address = $customer->Email;
				if ( ! empty( $email_address ) && null == username_exists( $email_address ) ) {
//

					$created = WsWpCustomerExporter::sync_item( $customer );

				}
			}

			update_option( 'ws_wp_last_sync_id_customer', $customer->RecordID );
			if($created){
				wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&cUpdated=1&tab=customers' ) );
				exit();
			}else{
				wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&cUpdated=2&tab=customers' ) );
				exit();
			}

		}

	}


	public function do_regular_import_product() {
		global $WsWp_i18n, $WsWp_admin;
		$sync_auto = get_option('ws_wp_product_sync_auto', 1 );
		WsWpLogger::$product_import_type = 1;
		if ( ! $sync_auto ) {
			WsWpLogger::append_product_log( __( "Automatic import is disabled: ", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_item_sync_error( __( "Automatic import is disabled: ", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( "Automatic import is disabled: ", $WsWp_i18n->get_domain() ) );
			WsWpLogger::writeLogs();

			return 0;
		}
		$config = $WsWp_admin->get_config_settings();
		if ( isset( $config->message ) ) {
			$config = $config->message;
		}
		$limit = 0;
		if ( isset( $config->products_active_count ) ) {
			$limit = $config->products_active_count;
		}
		$count_posts    = wp_count_posts( 'product' );
		$total_products = 0;
		if ( isset( $count_posts->published ) ) {
			$total_products += $count_posts->published;
		}
		if ( isset( $count_posts->draft ) ) {
			$total_products += $count_posts->draft;
		}
		if ( isset( $count_posts->pending ) ) {
			$total_products += $count_posts->pending;
		}
		if ( isset( $count_posts->pending ) ) {
			$total_products += $count_posts->pending;
		}
		if ( isset( $count_posts->trash ) ) {
			$total_products += $count_posts->trash;
		}
		$server = $this->get_soap_connection();
		WsWpProductImporter::set_product_mappings();
		if ( $server->is_valid() ) {
			if ( $server->do_products ) {
				$date = new DateTime();
				$last_sync_timestamp = WsWpProductImporter::get_last_sync_timestamp();
				$date->setTimestamp( $last_sync_timestamp );
				$date = $date->format( 'c' );
				WsWpLogger::append_product_log( __( "Starting daily import for products. ", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( "Starting daily import for products.", $WsWp_i18n->get_domain() ) );
				try {
					$response = $server->soap()->GetItems( $date );
				} catch ( SoapFault $fault ) {
					WsWpLogger::append_product_log( __( "Daily import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_item_sync_error( __( "Daily import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Import threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL . PHP_EOL . "Error:" . $fault->getMessage() . PHP_EOL );
					WsWpLogger::writeLogs();

					return - 1;
				}
				WsWpProductImporter::update_last_sync_timestamp();
				if ( $response ) {
					foreach ( $response as $item ) {
						if ( $limit > 0 && $limit < $total_products ) {
							set_transient( 'ws_wp_api_too_many_products', true );
							WsWpLogger::append_product_log( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit . PHP_EOL );
							WsWpLogger::append_item_sync_error( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit . PHP_EOL );
							WsWpLogger::append_dev( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit . PHP_EOL );
							WsWpLogger::writeLogs();

							return 0;
						} else {
							$created = WsWpProductImporter::sync_item( $item );
							if ( $created === 1 ) {
								$total_products ++;
							}
						}
					}
					delete_transient( 'ws_wp_api_too_many_products' );
				}
				WsWpLogger::append_product_log( __( "Import finished.", $WsWp_i18n->get_domain() ).PHP_EOL );
				WsWpLogger::append_dev( __( "Import finished.", $WsWp_i18n->get_domain() ).PHP_EOL  );
				WsWpLogger::writeLogs();

				return 1;
			} else {
				WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( " Error: Import couldn't be started. The api response disabled the products import feature.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::writeLogs();

				return 0;
			}
		} else {
			WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( " Error: Import couldn't be started. The soap server couldn't be contacted.", $WsWp_i18n->get_domain() ) );
			WsWpLogger::writeLogs();

			return 0;
		}
	}

	public function fetch_shipping_product( $record_id ) {
		global $WsWp_admin, $WsWp_i18n;
		$server = $this->get_soap_connection();
		$config = $WsWp_admin->get_config_settings();
		if ( isset( $config->message ) ) {
			$config = $config->message;
		}
		WsWpProductImporter::$soap = $server;
		WsWpProductImporter::set_product_mappings();
		if ( $record_id ) {
			if ( $server->is_valid() ) {
				$option = new TItemOptions();
				try {
					$response = $server->soap()->GetItemFromRecordID( $record_id, $option );
				} catch ( SoapFault $fault ) {
					WsWpLogger::append_order_sync_error( __( " Error: Shipping Item couldn't be found.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_order_export( __( " Error: Shipping Item couldn't be found.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Shipping Item couldn't be found. Error thrown:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . "Fault string: " . $fault->faultstring . PHP_EOL . PHP_EOL . "Error:" . $fault->getMessage() . PHP_EOL );
					WsWpLogger::writeLogs();

					return - 1;
				}
				if ( $response ) {
					return $response;

				}
			} else {
				WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( " Error: Import couldn't be started. The soap server couldn't be contacted.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::writeLogs();

				return 0;
			}
		}

	}

	public function sync_product( $product_id ) {
		global $WsWp_i18n, $WsWp_admin;
		//handle large amount of items,
		WsWpLogger::$product_import_type = 2;
		$server                          = $this->get_soap_connection();
		$config                          = $WsWp_admin->get_config_settings();
		if ( isset( $config->message ) ) {
			$config = $config->message;
		}
		$limit = 0;
		if ( isset( $config->products_active_count ) ) {
			$limit = $config->products_active_count;
		}
		$count_posts    = wp_count_posts( 'product' );
		$total_products = 0;
		if ( isset( $count_posts->published ) ) {
			$total_products += $count_posts->published;
		}
		if ( isset( $count_posts->pending ) ) {
			$total_products += $count_posts->pending;
		}
		if ( isset( $count_posts->draft ) ) {
			$total_products += $count_posts->draft;
		}
		if ( isset( $count_posts->trash ) ) {
			$total_products += $count_posts->trash;
		}
		if ( $limit > 0 && $limit < $total_products ) {
			set_transient( 'ws_wp_api_too_many_products', true );
			WsWpLogger::append_product_log( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit );
			WsWpLogger::append_item_sync_error( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit );
			WsWpLogger::append_dev( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit );
			WsWpLogger::writeLogs();

			return 0;
		}
		delete_transient( 'ws_wp_api_too_many_products' );
		WsWpProductImporter::$soap = $server;
		WsWpProductImporter::set_product_mappings();
		$record_id = WsWpProductImporter::get_record_id( $product_id );
		if ( $record_id ) {
			WsWpLogger::append_product_log( __( " Starting sync process for product:", $WsWp_i18n->get_domain() ) . get_the_title( $product_id ) . __( '- Record id:' ) . $record_id );
			WsWpLogger::append_dev( __( " Starting sync process for product:", $WsWp_i18n->get_domain() ) . get_the_title( $product_id ) . __( '- Record id:' ) . $record_id );
			if ( $server->is_valid() ) {
				if ( $server->do_products ) {
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
					try {
						$response = $server->soap()->GetItemFromRecordID( $record_id, $option );
						//printr($response);
					} catch ( SoapFault $fault ) {
						WsWpLogger::append_product_log( __( "Product import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_item_sync_error( __( "Product import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_dev( __( " Error: Product Import threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL . PHP_EOL . "Error:" . $fault->getMessage() . PHP_EOL );
						WsWpLogger::writeLogs();

						return - 1;
					}
					if ( $response ) {
						WsWpProductImporter::sync_item( $response );

					}
					WsWpLogger::append_product_log( __( "Import finished.", $WsWp_i18n->get_domain() ).PHP_EOL  );
					WsWpLogger::append_dev( __( "Import finished.", $WsWp_i18n->get_domain() ).PHP_EOL  );
					WsWpLogger::writeLogs();

					return 1;
				} else {
					WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Import couldn't be started. The api response disabled the products import feature.", $WsWp_i18n->get_domain() ) );
					WsWpLogger::writeLogs();

					return 0;
				}
			} else {
				WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( " Error: Import couldn't be started. The soap server couldn't be contacted.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::writeLogs();

				return 0;
			}
		} else {
			$sync_with_sku = get_option( 'ws_wp_product_sync_with_sku', 1 );
			if ( $sync_with_sku ) {
				$sku = get_post_meta( $product_id, '_sku', true );
				if ( $sku ) {
					WsWpLogger::append_product_log( __( " Starting sync process for product:", $WsWp_i18n->get_domain() ) . get_the_title( $product_id ) . __( '- Sku:' ) . $sku );
					WsWpLogger::append_dev( __( " Starting sync process for product:", $WsWp_i18n->get_domain() ) . get_the_title( $product_id ) . __( '- Sku:' ) . $sku );
					if ( $server->is_valid() ) {
						if ( $server->do_products ) {
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
							try {
								$response = $server->soap()->GetItem( $sku, $option );
							} catch ( SoapFault $fault ) {
								WsWpLogger::append_product_log( __( "Product import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
								WsWpLogger::append_item_sync_error( __( "Product import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
								WsWpLogger::append_dev( __( " Error: Product Import threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL . PHP_EOL . "Error:" . $fault->getMessage() . PHP_EOL );
								WsWpLogger::writeLogs(1);

								return - 1;
							}
							if ( $response ) {
								WsWpProductImporter::sync_item( $response );

							}
							WsWpLogger::append_product_log( __( "Product sync finished.", $WsWp_i18n->get_domain() ).PHP_EOL  );
							WsWpLogger::append_dev( __( "Product sync finished.", $WsWp_i18n->get_domain() ).PHP_EOL  );
							WsWpLogger::writeLogs();

							return 1;
						} else {
							WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
							WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
							WsWpLogger::append_dev( __( " Error: Import couldn't be started. The api response disabled the products import feature.", $WsWp_i18n->get_domain() ) );
							WsWpLogger::writeLogs();

							return 0;
						}
					} else {
						WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_dev( __( " Error: Import couldn't be started. The soap server couldn't be contacted.", $WsWp_i18n->get_domain() ) );
						WsWpLogger::writeLogs();

						return 0;
					}
				} else {
					WsWpLogger::append_product_log( __( " Error: Product Sync couldn't be started. There is no sku record id for the product in our database. ", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_item_sync_error( __( " Error: Product Sync couldn't be started. There is no sku record id for the product in our database. ", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Product Sync couldn't be started. There is no sku record id for the product in our database. ", $WsWp_i18n->get_domain() ) );
					WsWpLogger::writeLogs();

					return 0;
				}
			} else {
				WsWpLogger::append_product_log( __( "Error: Product Sync based on sku is disabled.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_item_sync_error( __( "Error: Product Sync based on sku is disabled.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( "Error: Product Sync based on sku is disabled.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::writeLogs();

				return 0;
			}
		}
	}

	public function do_chunk_import_product() {
		global $WsWp_i18n, $WsWp_admin;
		//handle large amount of items,
		WsWpLogger::$product_import_type = 0;
		$sync_auto                       = get_option( 'ws_wp_product_sync_auto', 1 );
		if ( ! $sync_auto ) {
			WsWpLogger::append_product_log( __( "Automatic import is disabled: ", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_item_sync_error( __( "Automatic import is disabled: ", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( "Automatic import is disabled: ", $WsWp_i18n->get_domain() ) );
			WsWpLogger::writeLogs();

			return 0;
		}
		$config = $WsWp_admin->get_config_settings();
		if ( isset( $config->message ) ) {
			$config = $config->message;
		}
		$limit = 0;
		if ( isset( $config->products_active_count ) ) {
			$limit = $config->products_active_count;
		}
		$count_posts    = wp_count_posts( 'product' );
		$total_products = 0;
		if ( isset( $count_posts->published ) ) {
			$total_products += $count_posts->published;
		}
		if ( isset( $count_posts->draft ) ) {
			$total_products += $count_posts->draft;
		}
		if ( isset( $count_posts->pending ) ) {
			$total_products += $count_posts->pending;
		}
		if ( isset( $count_posts->trash ) ) {
			$total_products += $count_posts->trash;
		}
		$server                    = $this->get_soap_connection();
		WsWpProductImporter::$soap = $server;
		WsWpProductImporter::set_product_mappings();
		WsWpLogger::append_product_log( __( "Starting chunk import for products.", $WsWp_i18n->get_domain() ) );
		WsWpLogger::append_dev( __( "Starting chunk import for products.", $WsWp_i18n->get_domain() ) );
		if ( $server->is_valid() ) {
			if ( $server->do_products ) {
				$last_id = WsWpProductImporter::get_last_sync_id_product();
				//$last_id = 9847;
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
				try {
					$response = $server->soap()->GetItemsEx( $last_id + 1, get_option( 'ws_wp_products_chunk_count', 30 ), $option );
				} catch ( SoapFault $fault ) {
					WsWpLogger::append_product_log( __( "Product import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_item_sync_error( __( "Product import failed to start. This is a temporary error, if it persists please contact the administrator. ", $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( " Error: Product Import threw error:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL . PHP_EOL . "Error:" . $fault->getMessage() . PHP_EOL );

					return - 1;
				}
				$products_synced = 0;
				if ( $response ) {
					foreach ( $response as $item ) {
						$products_synced ++;
						if ( $limit > 0 && $limit < $total_products ) {
							WsWpLogger::append_product_log( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit );
							WsWpLogger::append_item_sync_error( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit );
							WsWpLogger::append_dev( __( " Error: The total amount of products in your shop exceeds the number of products allowed by dk. Number of products in shop:", $WsWp_i18n->get_domain() ) . $total_products . __( ' - Number of product allowed:' ) . $limit );
							WsWpLogger::writeLogs();
							set_transient( 'ws_wp_api_too_many_products', true );

							return 0;

						} else {
							$created = WsWpProductImporter::sync_item( $item );
							$last_id = $item->RecordId;
							if ( $created === 1 ) {
								$total_products ++;
							}

						}

					}
					delete_transient( 'ws_wp_api_too_many_products' );
					WsWpProductImporter::update_last_sync_id_product( $last_id );
				} else {

				}
				WsWpLogger::append_product_log( __( "Product sync finished.", $WsWp_i18n->get_domain() ).PHP_EOL  );
				WsWpLogger::append_dev( __( "Product sync finished.", $WsWp_i18n->get_domain() ).PHP_EOL  );
				if ( $products_synced ) {
					WsWpLogger::writeLogs();
				} else {
					WsWpLogger::clean_logs();
				}

				return $last_id;
			} else {
				WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( " Error: Import couldn't be started. The api response disabled the products import feature.", $WsWp_i18n->get_domain() ) );
				WsWpLogger::writeLogs();

				return 0;
			}
		} else {
			WsWpLogger::append_product_log( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_item_sync_error( __( " Error: Import couldn't be started.", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( " Error: Import couldn't be started. The soap server couldn't be contacted.", $WsWp_i18n->get_domain() ) );
			WsWpLogger::writeLogs();

			return 0;
		}
	}

	public function get_soap_connection() {
		return new Ws_Wp_SoapWrapper();
	}

	protected function handle_daily_item_sync() {
		global $WsWp_i18n;
		//handle large amount of members,
		$import = $this->do_regular_import_product();
		if ( $import !== 0 && $import !== - 1 ) {
			$this->send_response( __( 'Import has been finished.', $WsWp_i18n->get_domain() ).PHP_EOL);
		} elseif ( $import === 0 ) {
			$this->send_response( __( 'Error:Connection could not be established.', $WsWp_i18n->get_domain() ) );
		} elseif ( $import === - 1 ) {
			$this->send_response( __( 'Error:Soap threw an error.', $WsWp_i18n->get_domain() ) );
		}
	}

	protected function handle_hourly_chunk_sync() {
		global $WsWp_i18n;
		$import = $this->do_chunk_import_product();
		if ( $import !== 0 && $import !== - 1 ) {
			$this->send_response( __( 'Import was successful. Last recordId:', $WsWp_i18n->get_domain() ) . $import );
		} elseif ( $import === 0 ) {
			$this->send_response( __( 'Error:Connection could not be established.', $WsWp_i18n->get_domain() ) );
		} elseif ( $import === - 1 ) {
			$this->send_response( __( 'Error:Soap threw an error.', $WsWp_i18n->get_domain() ) );
		}

	}

	/** Handle Requests
	 *    This is where we handle requests
	 * @return void
	 */
	protected function handle_request() {
		global $wp, $WsWp_i18n;
		$operationId  = $wp->query_vars['operation'];
		$ws_key_match = get_option( 'ws_wp_api_key_hash', '00236a2ae558018ed13b5222ef1bd987' );
		if ( ! $operationId ) {
			$this->send_response( __( 'Please set the operation id.', $WsWp_i18n->get_domain() ) );
		}
		$ws_key = $wp->query_vars['ws_key'];
		if ( ! $ws_key ) {
			$this->send_response( __( 'Please set key', $WsWp_i18n->get_domain() ) );
		}
		if ( $operationId && $ws_key ) {
			if ( $ws_key == $ws_key_match ) {
				switch ( $operationId ) {
					case 1:
						$this->handle_hourly_chunk_sync();
						break;
					case 2:
						$this->handle_daily_item_sync();
						break;
					case 3:
						$this->handle_hourly_customer_chunk_sync();
						break;
					case 4:
						$this->handle_order_sync();
						break;
					case 5:
						$this->handle_product_sync();
						break;
				}
			} else {
				$this->send_response( __( 'Key not authorized', $WsWp_i18n->get_domain() ) );
			}
		}
	}

	protected function handle_hourly_customer_chunk_sync() {
		global $WsWp_i18n;
		//handle large amount of items,
		/*$server = $this->get_soap_connection();
		WsWpCustomerImporter::$soap = $server;
		if ($server->is_valid()) {
			$last_id = WsWpCustomerImporter::get_last_sync_id_product();
			//$last_id = 9847;
			$option = new TItemOptions();
			$response = $server->soap()->GetCustomersEx($last_id, 30);
			//$response = $server->soap()->GetItem(4512010045,$option);
			if ($response) {
				foreach ($response as $item) {
					WsWpProductImporter::sync_item($item);
					$last_id = $item->RecordId;
				}
				WsWpProductImporter::update_last_sync_id_product($last_id);
				WsWpProductImporter::appendLog();
			}
			WsWpProductImporter::$log .= WsWpProductImporter::current_date() . "Import finished. \n";
			$this->send_response('Import was successful. Last recordId:' . $last_id);

		}
		else
		{
			WsWpProductImporter::$log .= WsWpProductImporter::current_date() . " Error: Import couldn't be started. ".PHP_EOL;
			WsWpProductImporter::appendLog();
			$this->send_response('Error:Connection could not be established.');
		}
		*/
		$this->send_response( __( 'Error:Functionality pending.', $WsWp_i18n->get_domain() ) );
	}

	protected function handle_order_sync() {
		global $WsWp_i18n, $WsWp_admin;
		if ( isset( $_GET['order_id'] ) ) {
			if ( function_exists( 'wc_get_order' ) ) {
				$order = WsWpOrderExporter::order_completed( $_GET['order_id'] );
				if ( $order != - 1 && $order != 0 ) {
					update_post_meta( $_GET['order_id'], '_ws_wp_has_order_synced', 1 );
					$this->send_response( __( "Order successfully synced.", $WsWp_i18n->get_domain() ) );
				} else {
					update_post_meta( $_GET['order_id'], '_ws_wp_has_order_synced', - 1 );
					$this->send_response( __( "Order sync was not succesfully, check the log file.", $WsWp_i18n->get_domain() ) );
				}

			}
		}
	}

	protected function handle_product_sync() {
		global $WsWp_i18n, $WsWp_admin;
		if ( isset( $_GET['product_id'] ) ) {
			if ( function_exists( 'wc_get_product' ) ) {
				$sync = self::sync_product( $_GET['product_id'] );
				if ( $sync == 1 ) {
					update_post_meta( $_GET['product_id'], '_ws_wp_has_product_synced', 1 );
					$this->send_response( __( "Product successfully synced.", $WsWp_i18n->get_domain() ) );
				} else {
					update_post_meta( $_GET['product_id'], '_ws_wp_has_product_synced', - 1 );
					$this->send_response( __( "Product sync was not succesfully, check the log file.", $WsWp_i18n->get_domain() ) );
				}
			}
		}
	}

	/** Response Handler
	 *    This sends a JSON response to the browser
	 */
	protected function send_response( $msg ) {
		$response['message'] = $msg;
		header( "Cache-Control: no-cache, no-store, must-revalidate" ); // HTTP 1.1.
		header( "Pragma: no-cache" ); // HTTP 1.0.
		header( "Expires: 0" ); // Proxies.
		header( 'content-type: application/json; charset=utf-8' );
		echo json_encode( $response ) . "\n";
		exit;
	}

}
