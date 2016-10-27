<?php

/**
 * Created by PhpStorm.
 * User: ionut
 * Date: 19-Sep-16
 * Time: 2:13 PM
 */
class WsWpLogger {

	public static $dev_log = "";
	public static $product_daily_log = "";
	public static $customer_daily_log = "";
	public static $product_chunk_log = "";
	public static $order_export_log = "";
	public static $general_log = "";
	public static $auth_error = "";
	public static $item_sync_error = "";
	public static $order_sync_error = "";
	public static $customer_sync_error = "";
	public static $product_import_type = 0;
	public static $customer_import_type = 0;


	public static function current_date() {
		return date( 'd.m.Y H:i:s' );
	}

	public static function writeLogs( $append_endline = 0 ) {
		$upload_dir  = wp_upload_dir();
		$directories = array(
			'product_daily_import_log' => self::$product_daily_log,
			'customer_daily_import_log' => self::$customer_daily_log,
			'product_chunk_import_log' => self::$product_chunk_log,
			'order_export_log'         => self::$order_export_log,
			'general_log'              => self::$general_log,
			'dev_log'                  => self::$dev_log,
		);
		if ( $directories ) {
			foreach ( $directories as $directory => $log ) {
				if ( $append_endline ) {
					$log .= PHP_EOL;
				}
				$dir = $upload_dir['basedir'] . '/ws-wp-sync/log/' . $directory . '/';
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
				file_put_contents( $dir . '/' . $today . '.txt', $log, FILE_APPEND );
			}

		}
		if ( self::$auth_error != "" ) {
			Ws_Wp_Sync_Admin::email_error( self::$auth_error, 'auth' );
		}
		if ( self::$order_sync_error != "" ) {
			Ws_Wp_Sync_Admin::email_error( self::$order_sync_error, 'order' );
		}
		if ( self::$item_sync_error != "" ) {
			Ws_Wp_Sync_Admin::email_error( self::$item_sync_error, 'item' );
		}
		self::clean_logs();
	}

	public static function clean_logs() {
		self::$product_daily_log = "";
		self::$customer_daily_log = "";
		self::$product_chunk_log = "";
		self::$order_export_log  = "";
		self::$general_log       = "";
		self::$dev_log           = "";
		self::$auth_error        = "";
		self::$order_sync_error  = "";
		self::$customer_sync_error  = "";
		self::$item_sync_error   = "";
	}

	public static function append_auth_error( $error ) {
		if ( $error[0] == '/' ) {
			self::$auth_error = rtrim( self::$auth_error, PHP_EOL );
			self::$auth_error .= " ";
			self::$auth_error .= $error . PHP_EOL;
		} else {
			self::$auth_error .= self::current_date() . '--> ' . $error . PHP_EOL;
		}

	}

	public static function append_item_sync_error( $error ) {
		if ( $error[0] == '/' ) {
			self::$item_sync_error = rtrim( self::$item_sync_error, PHP_EOL );
			self::$item_sync_error .= " ";
			self::$item_sync_error .= $error . PHP_EOL;
		} else {
			self::$item_sync_error .= self::current_date() . '--> ' . $error . PHP_EOL;
		}

	}

	public static function append_order_sync_error( $error ) {
		if ( $error[0] == '/' ) {
			self::$product_chunk_log = rtrim( self::$product_chunk_log, PHP_EOL );
			self::$product_chunk_log .= " ";
			self::$order_sync_error .= $error . PHP_EOL;
		} else {
			self::$order_sync_error .= self::current_date() . '--> ' . $error . PHP_EOL;
		}
	}

	public static function append_dev( $message ) {
		if ( $message[0] == '/' ) {
			self::$dev_log = rtrim( self::$dev_log, PHP_EOL );
			self::$dev_log .= " ";
			self::$dev_log .= $message . PHP_EOL;
		} else {
			self::$dev_log .= self::current_date() . '--> ' . $message . PHP_EOL;
		}

	}

	public static function append_customer_daily( $message ) {
		if ( $message[0] == '/' ) {
			self::$customer_daily_log = rtrim( self::$customer_daily_log, PHP_EOL );
			self::$customer_daily_log .= " ";
			self::$customer_daily_log .= $message . PHP_EOL;
		} else {
			self::$customer_daily_log .= self::current_date() . '--> ' . $message . PHP_EOL;
		}

	}

	public static function append_product_daily( $message ) {
		if ( $message[0] == '/' ) {
			self::$product_daily_log = rtrim( self::$product_daily_log, PHP_EOL );
			self::$product_daily_log .= " ";
			self::$product_daily_log .= $message . PHP_EOL;
		} else {
			self::$product_daily_log .= self::current_date() . '--> ' . $message . PHP_EOL;
		}

	}

	public static function append_product_chunk( $message ) {
		if ( $message[0] == '/' ) {
			self::$product_chunk_log = rtrim( self::$product_chunk_log, PHP_EOL );
			self::$product_chunk_log .= " ";
			self::$product_chunk_log .= $message . PHP_EOL;
		} else {
			self::$product_chunk_log .= self::current_date() . '--> ' . $message . PHP_EOL;
		}
	}

	public static function append_order_export( $message ) {
		if ( $message[0] == '/' ) {
			self::$order_export_log = rtrim( self::$order_export_log, PHP_EOL );
			self::$order_export_log .= " ";
			self::$order_export_log .= $message . PHP_EOL;
		} else {
			self::$order_export_log .= self::current_date() . '--> ' . $message . PHP_EOL;
		}
	}

	public static function append_general_log( $message ) {
		if ( $message[0] == '/' ) {
			self::$general_log = rtrim( self::$general_log, PHP_EOL );
			self::$general_log .= " ";
			self::$general_log .= $message . PHP_EOL;
		} else {
			self::$general_log .= self::current_date() . '--> ' . $message . PHP_EOL;
		}
	}

	public static function append_product_log( $message ) {
		if ( self::$product_import_type == 0 ) {
			self::append_product_chunk( $message );
		} elseif ( self::$product_import_type == 1 ) {
			self::append_product_daily( $message );
		} elseif ( self::$product_import_type == 2 ) {
			self::append_general_log( $message );
		}
	}

	public static function append_customer_log( $message ) {
		if ( self::$customer_import_type == 0 ) {
			self::append_customer_daily( $message );
		} elseif ( self::$customer_import_type == 1 ) {
			self::append_general_log( $message );
		}
	}


}