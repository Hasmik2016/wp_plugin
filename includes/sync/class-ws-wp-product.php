<?php

class WsWpProductImporter {

	public static $product_mappings;
	public static $product_defaults;
	public static $log = "";
	public static $soap = null;
	public static $has_error = 0;

	public static function wc_get_product_id_by_recordId( $RecordId ) {
		global $wpdb;
		$product_id = $wpdb->get_var( $wpdb->prepare( "
		SELECT posts.ID
		FROM $wpdb->posts AS posts
		LEFT JOIN $wpdb->postmeta AS postmeta ON ( posts.ID = postmeta.post_id )
		WHERE posts.post_type IN ( 'product', 'product_variation' )
		AND postmeta.meta_key = '_ws_wp_record_id' AND postmeta.meta_value = '%s'
		LIMIT 1
	 ", $RecordId ) );
		$product_id = ( $product_id ) ? intval( $product_id ) : 0;
		if ( $product_id ) {
			return $product_id;
		} else {
			$sync_with_sku = get_option( 'ws_wp_product_sync_with_sku', 1 );
			if ( $sync_with_sku ) {
				$product_id = $wpdb->get_var( $wpdb->prepare( "
		SELECT posts.ID
		FROM $wpdb->posts AS posts
		LEFT JOIN $wpdb->postmeta AS postmeta ON ( posts.ID = postmeta.post_id )
		WHERE posts.post_type IN ( 'product', 'product_variation' )
		AND postmeta.meta_key = '_sku' AND postmeta.meta_value = '%s'
		LIMIT 1
	 ", $RecordId ) );
				$product_id = ( $product_id ) ? intval( $product_id ) : 0;

				return $product_id;
			}
		}
	}

	public static function product_id( $sku ) {
		return self::wc_get_product_id_by_recordId( $sku );
	}

	public static function current_date() {
		return date( 'd/m/y H:i:s' );
	}

	public static function create_product_from_item( $item ) {
		global $WsWp_i18n;
		$sku = self::get_selected_option( 'sku' );
		if ( isset( $item->ShowItemInWebShop ) && $item->ShowItemInWebShop ) {
			$title = self::get_selected_option( 'name' );
			if ( $item->$title ) {
				$status_default  = self::get_default_option( 'status' );
				$attachments     = self::get_selected_option( 'attachments' );
				$skip_attachment = self::get_setting( 'attachments', 'skip' );
				/*$set_pending_if_has_image = self::get_setting('attachments', 'pending_if_image_synced');
				if (!$skip_attachment) {
					$attachments = $item->$attachments;
					if (count($attachments) > 0) {
						if ($set_pending_if_has_image)
							$status_default = 'draft';
					}
				}
				*/
				$enable_reviews = self::get_default_option( 'enable_reviews' );
				if ( $enable_reviews == 'on' ) {
					$comment_status = 'open';
				} else {
					$comment_status = 'closed';
				}
				$post        = array(
					'post_title'     => $item->$title,
					'post_status'    => $status_default,
					'post_type'      => "product",
					'comment_status' => $comment_status
				);
				$new_post_id = wp_insert_post( $post );
				update_post_meta( $new_post_id, '_sku', $item->$sku );
				update_post_meta( $new_post_id, '_ws_wp_record_id', $item->RecordId );
				$manage_stock = self::get_default_option( 'manage_stock' );
				if ( $manage_stock == 'on' ) {
					update_post_meta( $new_post_id, '_manage_stock', 'yes' );
				} else {
					update_post_meta( $new_post_id, '_manage_stock', 'no' );
				}
				$backorder = self::get_default_option( 'backorders' );
				update_post_meta( $new_post_id, '_backorders', $backorder );
				$virtual = self::get_default_option( 'virtual' );
				update_post_meta( $new_post_id, '_virtual', $virtual );
				$show = self::get_default_option( 'visibility' );
				update_post_meta( $new_post_id, '_visibility', $show );
				WsWpLogger::append_product_log( __( "Inserting new product with the Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku );
				WsWpLogger::append_dev( __( "Inserting new product with the Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku );
				self::update_product_data( $item, $new_post_id );

				return 1;
			} else {
				WsWpLogger::append_product_log( __( "Error inserting new product with the Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . PHP_EOL . 'The title is not set. ' );
				WsWpLogger::append_item_sync_error( __( "Error inserting new product with the Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . PHP_EOL . 'The title is not set. ' );
				WsWpLogger::append_dev( __( "Error inserting new product with the Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . PHP_EOL . 'The title is not set. ' );
				WsWpLogger::writeLogs();

				return - 1;
			}
		} else {
			WsWpLogger::append_product_log( __( "Skipped product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . __( ' /The api marked it as not showable in the webshop. ', $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( "Skipped product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . __( ' /The api marked it as not showable in the webshop. ', $WsWp_i18n->get_domain() ) );
			WsWpLogger::writeLogs();

			return - 1;
		}
	}

	public static function get_record_id( $prod_id ) {
		return get_post_meta( $prod_id, '_ws_wp_record_id', true );
	}


	public static function add_attachment( $dkAttachment, $new_post_id ) {
		global $WsWp_i18n;
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
			require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
			require_once( ABSPATH . "wp-admin" . '/includes/media.php' );
		}
		$tmp  = self::$soap->get_attachment( $dkAttachment->ID );
		$file = plugin_dir_path( __FILE__ ) . 'tmp/' . $dkAttachment->Name;
		if ( ! is_dir( plugin_dir_path( __FILE__ ) . 'tmp' ) ) {
			// dir doesn't exist, make it
			mkdir( plugin_dir_path( __FILE__ ) . 'tmp' );
		}
		file_put_contents( $file, $tmp );
		preg_match( '/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $file, $matches );
		if ( empty( $matches ) ) {
			@unlink( $file );

			return 0;
		}
		$file_array['name']     = $dkAttachment->Name;
		$file_array['tmp_name'] = $file;
		// If error storing temporarily, unlink
		if ( is_wp_error( $file ) ) {
			@unlink( $file_array['tmp_name'] );
			$file_array['tmp_name'] = '';
			WsWpLogger::append_product_log( __( "Error: Image couldn't be saved: ", $WsWp_i18n->get_domain() ) . "$file" );
			WsWpLogger::append_dev( __( "Error: Image couldn't be saved: ", $WsWp_i18n->get_domain() ) . "$file" );

		}
		//use media_handle_sideload to upload img:
		$thumbid = media_handle_sideload( $file_array, $new_post_id );
		// If error storing permanently, unlink
		if ( is_wp_error( $thumbid ) ) {
			@unlink( $file_array['tmp_name'] );
			WsWpLogger::append_product_log( __( " Error: Image couldn't be saved:", $WsWp_i18n->get_domain() ) . $file_array['name'] );
			WsWpLogger::append_dev( __( " Error: Image couldn't be saved:", $WsWp_i18n->get_domain() ) . $file_array['name'] );

			return 0;
		} else {
			WsWpLogger::append_product_log( __( "Image", $WsWp_i18n->get_domain() ) . $file . __( " succesfully added to the product.", $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( "Image", $WsWp_i18n->get_domain() ) . $file . __( " succesfully  added to the product" ), $WsWp_i18n->get_domain() );
		}

		return $thumbid;


	}

	public static function appendLog() {
		$upload_dir = wp_upload_dir();
		$dir        = $upload_dir['basedir'] . '/ws-wp-sync/log/product_import_log/';
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
			Ws_Wp_Sync_Admin::email_error( self::$log, 'item' );
		}
		file_put_contents( $dir . '/' . $today . '.txt', self::$log, FILE_APPEND );
	}

	public static function sync_product_with_item( $pid, $item ) {
		global $WsWp_i18n, $WsWp_admin;
		$title = self::get_selected_option( 'name' );
		$sku   = self::get_selected_option( 'sku' );
		if ( $item->$title ) {
			self::update_product_data( $item, $pid, 1 );
		} else {
			WsWpLogger::append_product_log( __( "Error updating product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . PHP_EOL . __( 'The title is not set.', $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_item_sync_error( __( "Error updating product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . PHP_EOL . __( 'The title is not set.', $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( "Error updating product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . PHP_EOL . __( 'The title is not set.', $WsWp_i18n->get_domain() ) );
		}
	}


	public static function update_product_data( $item, $post_id, $update = 0 ) {
		global $WsWp_i18n;
		$post = array(
			'ID' => $post_id
		);
		$sku   = self::get_selected_option( 'sku' );
		$title = self::get_selected_option( 'name' );
		if ( self::should_overwrite_post_attr( 'name', 'post_title', $post_id ) ) {
			$post['post_title'] = $item->$title;
			if ( ! $update ) {
				WsWpLogger::append_product_log( __( "/Product name: ", $WsWp_i18n->get_domain() ) . $post['post_title'] );

			} else {
				$old_title = get_the_title( $post_id );
				$new_title = $item->$title;
				if ( $old_title != $new_title ) {
					WsWpLogger::append_product_log( __( "/Product name updated: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() ) );
				} else {
					WsWpLogger::append_product_log( __( "/Product name updated: ", $WsWp_i18n->get_domain() ) . __( 'No', $WsWp_i18n->get_domain() ) );
				}

			}

		} elseif ( $update ) {
			WsWpLogger::append_product_log( __( "/Product name updated: ", $WsWp_i18n->get_domain() ) . __( 'Skipped', $WsWp_i18n->get_domain() ) );
		}
		if ( isset( $item->ShowItemInWebShop ) && $item->ShowItemInWebShop ) {
			wp_untrash_post( $post_id );
		} else {
			WsWpLogger::append_product_log( __( "Trashed product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . __( ' /The api marked it as not showable in the webshop. ', $WsWp_i18n->get_domain() ) );
			WsWpLogger::append_dev( __( "Trashed product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku . __( ' /The api marked it as not showable in the webshop. ', $WsWp_i18n->get_domain() ) );
			WsWpLogger::writeLogs();
			wp_trash_post( $post_id );
		}
		$description      = self::get_selected_option( 'description' );
		$skip_description = self::get_setting( 'description', 'skip' );
		if ( ! $skip_description ) {
			if ( self::should_overwrite_post_attr( 'description', 'post_content', $post_id ) ) {
				$post['post_content'] = $item->$description;
				if ( $update ) {
					$old_content = get_post_field( 'post_content', $post_id );
					$new_content = $item->$description;
					if ( $old_content != $new_content ) {
						WsWpLogger::append_product_log( __( "/Product description updated: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() ) );
					} else {
						WsWpLogger::append_product_log( __( "/Product description updated: ", $WsWp_i18n->get_domain() ) . __( 'No', $WsWp_i18n->get_domain() ) );
					}
				}
			} elseif ( $update ) {
				WsWpLogger::append_product_log( __( "/Product description updated: ", $WsWp_i18n->get_domain() ) . __( 'Skipped', $WsWp_i18n->get_domain() ) );
			}
		}
		$short_description      = self::get_selected_option( 'short_description' );
		$skip_short_description = self::get_setting( 'short_description', 'skip' );
		if ( ! $skip_short_description ) {
			if ( self::should_overwrite_post_attr( 'short_description', 'post_excerpt', $post_id ) ) {
				$post['post_excerpt'] = $item->$short_description;
			}
		}
		wp_update_post( $post );
		$categories      = self::get_selected_option( 'categories' );
		$overwrite       = self::get_setting( 'categories', 'overwrite' );
		$skip_categories = self::get_setting( 'categories', 'skip' );
		if ( ! $skip_categories ) {
			if ( isset( $item->$categories ) ) {
				if ( count( $item->$categories ) > 0 ) {
					$terms     = $item->$categories;
					$term_ids  = array();
					$term_list = wp_get_post_terms( $post_id, 'product_cat', array( "fields" => "ids" ) );
					if ( ! $term_list || $overwrite ) {
						if ( $term_list ) {
							wp_remove_object_terms( $post_id, $term_list, 'product_cat' );
						}

					}
					foreach ( $terms as $term ) {
						$existent_term = get_term_by( 'name', $term->ID, 'product_cat' );
						if ( $existent_term ) {
							$parent_term_id = $existent_term->term_id;
						} else {
							$parent_term    = wp_insert_term(
								$term->ID,   // the term
								'product_cat', // the taxonomy
								array(
									'description' => $term->Description,
								)
							);
							$parent_term_id = $parent_term['term_id'];
						}
						$term_ids[] = $parent_term_id;
						if ( $term->SubGroups ) {
							$child_terms = $term->SubGroups;
							foreach ( $child_terms as $term ) {
								$existent_term = get_term_by( 'name', $term->ID, 'product_cat' );
								if ( $existent_term ) {
									$child_id = $existent_term->term_id;
								} else {
									$child    = wp_insert_term(
										$term->ID,   // the term
										'product_cat', // the taxonomy
										array(
											'description' => $term->Description,
											'parent'      => $parent_term_id
										)
									);
									$child_id = $child['term_id'];
								}
								$term_ids[] = $child_id;
							}
						}

					}
					wp_add_object_terms( $post_id, $term_ids, 'product_cat' );

				}
			}
		}
		$stock = self::get_selected_option( 'stockQty' );
		if ( self::should_overwrite( 'stockQty', '_stock', $post_id ) ) {
			if ( $item->$stock != "" ) {
				update_post_meta( $post_id, '_stock', wc_stock_amount( $item->$stock ) );
				if ( ! $update ) {
					WsWpLogger::append_product_log( __( "/Qty: ", $WsWp_i18n->get_domain() ) . $item->$stock );
				} else {
					$old_stock = get_post_meta( $post_id, '_stock', true );
					$new_stock = $item->$stock;
					if ( $old_stock != $new_stock ) {
						WsWpLogger::append_product_log( __( "/Product Qty updated: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() ) );
					} else {
						WsWpLogger::append_product_log( __( "/Product Qty updated: ", $WsWp_i18n->get_domain() ) . __( 'No', $WsWp_i18n->get_domain() ) );
					}

				}
			}
		} elseif ( $update ) {
			WsWpLogger::append_product_log( __( "/Product Qty updated: ", $WsWp_i18n->get_domain() ) . __( 'Skipped', $WsWp_i18n->get_domain() ) );
		}
		$regular_price = self::get_selected_option( 'regular_price' );
		if ( self::should_overwrite( 'regular_price', '_regular_price', $post_id ) ) {
			if ( $item->$regular_price != "" ) {
				$rounding = self::get_rounding( 'regular_price' );
				$price    = $item->$regular_price;
				if ( $rounding == 'up' ) {
					$price = ceil( $price );
				} elseif ( $rounding == 'down' ) {
					$price = floor( $price );
				}
				update_post_meta( $post_id, '_regular_price', $price );
				if ( ! $update ) {
					WsWpLogger::append_product_log( __( "/Price: ", $WsWp_i18n->get_domain() ) . $price );
				} else {
					$old_price = get_post_meta( $post_id, '_regular_price', true );
					$new_price = $item->$regular_price;
					if ( $old_price != $new_price ) {
						WsWpLogger::append_product_log( __( "/Product Price updated: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() ) );
					} else {
						WsWpLogger::append_product_log( __( "/Product Price updated: ", $WsWp_i18n->get_domain() ) . __( 'No', $WsWp_i18n->get_domain() ) );
					}

				}

			}
		} elseif ( $update ) {
			WsWpLogger::append_product_log( __( "/Product Price updated: ", $WsWp_i18n->get_domain() ) . __( 'Skipped', $WsWp_i18n->get_domain() ) );
		}
		$sale_price      = self::get_selected_option( 'sale_price' );
		$skip_sale_price = self::get_setting( 'sale_price', 'skip' );
		if ( ! $skip_sale_price ) {
			if ( self::should_overwrite( 'sale_price', '_sale_price', $post_id ) ) {
				if ( $item->$sale_price != "" ) {
					$rounding = self::get_rounding( 'sale_price' );
					$price    = $item->$sale_price;
					if ( $rounding == 'up' ) {
						$price = ceil( $price );
					} elseif ( $rounding == 'down' ) {
						$price = floor( $price );
					}
					if ( $item->PropositionDateTo ) {
						$to = new DateTime( $item->PropositionDateTo );
						update_post_meta( $post_id, '_sale_price_dates_from', strtotime( 'now' ) );
						update_post_meta( $post_id, '_sale_price_dates_to', $to->getTimestamp() );
					}
					update_post_meta( $post_id, '_sale_price', $price );
					if ( ! $update ) {
						WsWpLogger::append_product_log( __( "/Sale Price: ", $WsWp_i18n->get_domain() ) . $price );
					} else {
						$old_price = get_post_meta( $post_id, '_sale_price', true );
						$new_price = $item->$sale_price;
						if ( $old_price != $new_price ) {
							self::$log .= __( "/Product Sale Price updated: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() );
							WsWpLogger::append_product_log( __( "/Product Sale Price updated: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() ) );
						} else {
							WsWpLogger::append_product_log( __( "/Product Sale Price updated: ", $WsWp_i18n->get_domain() ) . __( 'No', $WsWp_i18n->get_domain() ) );
						}


					}

				}
			} elseif ( $update ) {
				WsWpLogger::append_product_log( __( "/Product Sale Price updated: ", $WsWp_i18n->get_domain() ) . __( 'Skipped', $WsWp_i18n->get_domain() ) );
			}
		}
		$sale_price    = get_post_meta( $post_id, '_sale_price', true );
		$regular_price = get_post_meta( $post_id, '_regular_price', true );
		if ( $sale_price != '' && $regular_price != '' ) {
			$price = ( $sale_price <= $regular_price ) ? $sale_price : $regular_price;
		} elseif ( $sale_price != '' ) {
			$price = $sale_price;
		} else {
			$price = $regular_price;
		}
		update_post_meta( $post_id, '_price', $price );
		$attachments           = self::get_selected_option( 'attachments' );
		$skip_attachment       = self::get_setting( 'attachments', 'skip' );
		$overwrite_attachments = self::get_setting( 'attachments', 'overwrite' );
		if ( ! $skip_attachment ) {
			$attachments = $item->$attachments;
			$attach_ids  = array();
			if ( isset( $attachments[0] ) ) {
				$media = get_children( array(
					'post_parent' => $post_id,
					'post_type'   => 'attachment'
				) );
				if ( $overwrite_attachments || empty( $media ) ) {
					if ( ! empty( $media ) ) {
						foreach ( $media as $file ) {
							// pick what you want to do
							wp_delete_attachment( $file->ID );
							@unlink( get_attached_file( $file->ID ) );
						}
					}
					$i         = 0;
					$has_image = 0;
					foreach ( $attachments as $key => $attachment ) {
						$thumbid = self::add_attachment( $attachment, $post_id );
						if ( $thumbid ) {
							if ( $i == 0 ) {
								set_post_thumbnail( $post_id, $thumbid );
								$has_image = 1;
								$i ++;
							} else {
								$attach_ids[] = $thumbid;
							}
						}
					}
					if ( ! $update ) {
						if ( $has_image ) {
							WsWpLogger::append_product_log( __( " /Image: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() ) );
						} else {
							WsWpLogger::append_product_log( __( " /Image: ", $WsWp_i18n->get_domain() ) . __( 'No', $WsWp_i18n->get_domain() ) );
						}
					} else {
						if ( $has_image ) {
							WsWpLogger::append_product_log( __( " /Image updated: ", $WsWp_i18n->get_domain() ) . __( 'Yes', $WsWp_i18n->get_domain() ) );
						} else {
							WsWpLogger::append_product_log( __( " /Image updated: ", $WsWp_i18n->get_domain() ) . __( 'No', $WsWp_i18n->get_domain() ) );
						}
					}
					$meta_value = implode( ',', $attach_ids );
					update_post_meta( $post_id, '_product_image_gallery', $meta_value );
				} else {
					if ( $update ) {
						WsWpLogger::append_product_log( __( " /Image updated: ", $WsWp_i18n->get_domain() ) . __( 'Skipped', $WsWp_i18n->get_domain() ) );
					}
				}

			}
		} else {
			self::$log .= __( " /Image: ", $WsWp_i18n->get_domain() ) . __( 'Skipped', $WsWp_i18n->get_domain() );
		}
		update_post_meta( $post_id, '_last_sync_date', self::current_date() );
	}

	public static function get_last_sync_id_product() {
		$product_id = get_option( 'ws_wp_last_sync_id_product', 0 );

		return $product_id;
	}

	public static function get_last_sync_timestamp() {
		$last_sync    = get_option( 'ws_wp_last_sync_date', 0 );
		$current_time = strtotime( 'now' );
		$difference   = $current_time - $last_sync;
		$max_diff     = 60 * 60 * 24 * 5; //5 days
		if ( $difference > $max_diff ) {
			if ( $last_sync )// if this has been set before we reset the chunk
			{
				self::update_last_sync_id_product( 0 );
			}
			$last_sync = $current_time - $max_diff;
		}

		return $last_sync;
	}

	public static function update_last_sync_timestamp() {
		update_option( 'ws_wp_last_sync_date', strtotime( 'now' ) );
	}

	public static function update_last_sync_id_product( $id ) {
		update_option( 'ws_wp_last_sync_id_product', $id );
	}

	public static function set_mappings() {
		self::set_product_mappings();
	}

	public static function get_product_mappings() {
		return self::$product_mappings;
	}

	public static function get_product_defaults() {
		return self::$product_defaults;
	}

	public static function set_product_mappings() {
		global $WsWp_i18n;
		self::$product_mappings = array(
			'recordId'          => array(
				'name'        => __( 'Unique item id', $WsWp_i18n->get_domain() ),
				'hide'        => 1,
				'options'     => array(
					'RecordId' => 1
				),
				'overwrite'   => 1,
				'd_overwrite' => 0,
			),
			'sku'               => array(
				'name'    => __( 'Product Sku', $WsWp_i18n->get_domain() ),
				'options' => array(
					'ItemCode'      => 1,
					'AliasItemCode' => 0,
				)
			),
			'name'              => array(
				'name'        => __( 'Product Name', $WsWp_i18n->get_domain() ),
				'options'     => array(
					'Description'  => 1,
					'Description2' => 0,
					'ExtraDesc1'   => 0,
					'ExtraDesc2'   => 0
				),
				'overwrite'   => 0,
				'd_overwrite' => 1,
			),
			'description'       => array(
				'name'        => __( 'Product Description', $WsWp_i18n->get_domain() ),
				'options'     => array(
					'Description'  => 0,
					'Description2' => 1,
					'ExtraDesc1'   => 0,
					'ExtraDesc2'   => 0
				),
				'overwrite'   => 1,
				'd_overwrite' => 0,
				'skip'        => 0
			),
			'short_description' => array(
				'name'        => __( 'Product Short description', $WsWp_i18n->get_domain() ),
				'options'     => array(
					'Description'  => 0,
					'Description2' => 0,
					'ExtraDesc1'   => 1,
					'ExtraDesc2'   => 0
				),
				'overwrite'   => 1,
				'd_overwrite' => 0,
				'skip'        => 0
			),
			'sale_price'        => array(
				'name'        => __( 'Product sale price', $WsWp_i18n->get_domain() ),
				'options'     => array(
					//'UnitPrice1' => 0,
					'PropositionPrice' => 1,
					//'UnitPrice3' => 0,
					//'UnitPrice1WithTax' => 0,
					//'UnitPrice2WithTax' => 0,
					//'UnitPrice3WithTax' => 0,
				),
				'rounding'    => array(
					'up'   => 1,
					'down' => 0,
					'none' => 0
				),
				'skip'        => 0,
				'd_overwrite' => 0,
				'overwrite'   => 1
			),
			'regular_price'     => array(
				'name'        => __( 'Product regular price', $WsWp_i18n->get_domain() ),
				'options'     => array(
					'UnitPrice1'        => 1,
					'UnitPrice2'        => 0,
					'UnitPrice3'        => 0,
					'UnitPrice1WithTax' => 0,
					'UnitPrice2WithTax' => 0,
					'UnitPrice3WithTax' => 0,
				),
				'rounding'    => array(
					'up'   => 1,
					'down' => 0,
					'none' => 0
				),
				'overwrite'   => 1,
				'd_overwrite' => 0,
			),
			'stockQty'          => array(
				'name'        => __( 'Stock Qty', $WsWp_i18n->get_domain() ),
				'hide'        => 1,
				'options'     => array(
					'TotalQuantityInWarehouse' => 1
				),
				'overwrite'   => 1,
				'd_overwrite' => 0,
			),
			'attachments'       => array(
				'name'        => __( 'Attachments', $WsWp_i18n->get_domain() ),
				'options'     => array(
					'Attachments' => 1
				),
				'overwrite'   => 0,
				'd_overwrite' => 0,
				'skip'        => 1,
				//'pending_if_image_synced' => 0
			),
			'categories'        => array(
				'name'        => __( 'Categories', $WsWp_i18n->get_domain() ),
				'options'     => array(
					'ItemCategories' => 0,
				),
				'overwrite'   => 0,
				'd_overwrite' => 0,
				'skip'        => 1,
			),
		);
		if ( self::$product_mappings ) {
			foreach ( self::$product_mappings as $key => $item ) {
				if ( isset( $item['hide'] ) && ( $item['hide'] == 1 ) ) {
					continue;
				}
				$option = get_option( 'ws_wp_product_mappings_' . $key );
				if ( $option ) {
					$opt = self::$product_mappings[ $key ];
					foreach ( $option as $k => $value ) {
						if ( isset( $opt[ $k ] ) ) {
							if ( is_array( $value ) ) {
								if ( $value ) {
									foreach ( $value as $sk => $svalue ) {
										if ( isset( $opt[ $k ][ $sk ] ) ) {
											$opt[ $k ][ $sk ] = $svalue;
										}
									}
								}
							} else {
								$opt[ $k ] = $value;
							}
						}
					}
					self::$product_mappings[ $key ] = $opt;
				}
			}
		}

	}

	public static function set_product_defaults() {
		global $WsWp_i18n;
		self::$product_defaults = array(
			'manage_stock'   => array(
				'name'    => __( 'Manage Stock', $WsWp_i18n->get_domain() ),
				'options' => array(
					'on'  => 1,
					'off' => 0
				),
				'names'   => array(
					'on'  => __( 'Enabled', $WsWp_i18n->get_domain() ),
					'off' => __( 'Disabled', $WsWp_i18n->get_domain() )
				)
			),
			'enable_reviews' => array(
				'name'    => __( 'Enable Reviews', $WsWp_i18n->get_domain() ),
				'options' => array(
					'on'  => 1,
					'off' => 0
				),
				'names'   => array(
					'on'  => __( 'Enabled', $WsWp_i18n->get_domain() ),
					'off' => __( 'Disabled', $WsWp_i18n->get_domain() )
				)
			),
			'status'         => array(
				'name'    => __( 'Product Status', $WsWp_i18n->get_domain() ),
				'options' => array(
					'publish' => 1,
					'pending' => 0,
				),
				'names'   => array(
					'publish' => __( 'Published', $WsWp_i18n->get_domain() ),
					'pending' => __( 'To be reviewed', $WsWp_i18n->get_domain() )
				)
			),
			'virtual'        => array(
				'name'    => __( 'Virtual', $WsWp_i18n->get_domain() ),
				'options' => array(
					'yes' => 0,
					'no'  => 1,
				),
				'names'   => array(
					'yes' => __( 'Yes', $WsWp_i18n->get_domain() ),
					'no'  => __( 'No', $WsWp_i18n->get_domain() )
				)
			),
			'visibility'     => array(
				'name'    => __( 'Product Visibility', $WsWp_i18n->get_domain() ),
				'options' => array(
					'visible' => 1,
					'hidden'  => 0,
				),
				'names'   => array(
					'visible' => __( 'Visible', $WsWp_i18n->get_domain() ),
					'hidden'  => __( 'Hidden', $WsWp_i18n->get_domain() )
				)
			),
			'backorders'     => array(
				'name'    => __( 'Backorders', $WsWp_i18n->get_domain() ),
				'options' => array(
					'no'     => 0,
					'notify' => 1,
					'yes'    => 0,
				),
				'names'   => array(
					'no'     => __( 'Do not allow', $WsWp_i18n->get_domain() ),
					'notify' => __( 'Allow but notify customer', $WsWp_i18n->get_domain() ),
					'yes'    => __( 'Allow', $WsWp_i18n->get_domain() ),
				)
			),
		);
		if ( self::$product_defaults ) {
			foreach ( self::$product_defaults as $key => $item ) {
				if ( isset( $item['hide'] ) && ( $item['hide'] == 1 ) ) {
					continue;
				}
				$option = get_option( 'ws_wp_product_defaults_' . $key );
				if ( $option ) {
					$opt = self::$product_defaults[ $key ];
					foreach ( $option as $k => $value ) {
						if ( isset( $opt[ $k ] ) ) {
							if ( is_array( $value ) ) {
								if ( $value ) {
									foreach ( $value as $sk => $svalue ) {
										if ( isset( $opt[ $k ][ $sk ] ) ) {
											$opt[ $k ][ $sk ] = $svalue;
										}
									}
								}
							} else {
								$opt[ $k ] = $value;
							}
						}
					}
					self::$product_defaults[ $key ] = $opt;
				}
			}
		}

	}

	public static function sync_item( $item ) {
		global $WsWp_i18n;
		self::set_product_defaults();
		self::set_product_mappings();
		$sku = self::get_selected_option( 'sku' );
		if ( $item->RecordId ) {
			$pid = self::product_id( $item->RecordId );
			if ( ! $pid ) {
				$sync_with_sku = get_option( 'ws_wp_product_sync_with_sku', 1 );
				if ( $sync_with_sku ) {
					if ( $item->$sku ) {
						$pid = self::product_id( $item->$sku );
					}
					if ( $pid ) {
						update_post_meta( $pid, '_ws_wp_record_id', $item->RecordId );
					}
				}
			}
			if ( $pid ) {
				WsWpLogger::append_product_log( __( "Updating product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku );
				WsWpLogger::append_dev( __( "Updating product with Sku: ", $WsWp_i18n->get_domain() ) . $item->$sku );
				self::sync_product_with_item( $pid, $item );

				return 2;
			} else {
				if ( self::create_product_from_item( $item ) != - 1 ) {
					return 1;
				} else {
					return 0;
				}
			}
		}
	}


	public static function get_setting( $name, $setting ) {
		$product_mappings = self::$product_mappings;
		if ( $product_mappings ) {
			if ( isset( $product_mappings[ $name ] ) ) {
				if ( isset( $product_mappings[ $name ][ $setting ] ) ) {
					return $product_mappings[ $name ][ $setting ];

				}
			}
		}

		return null;
	}

	public static function get_selected_option( $name ) {
		$product_mappings = self::$product_mappings;
		if ( $product_mappings ) {
			if ( isset( $product_mappings[ $name ] ) ) {
				if ( isset( $product_mappings[ $name ]['options'] ) ) {
					foreach ( $product_mappings[ $name ]['options'] as $key => $checked ) {
						if ( $checked ) {
							return $key;
						}
					}
				}
			}
		}

		return null;

	}

	protected static function get_default_option( $name ) {
		$product_defaults = self::$product_defaults;
		if ( $product_defaults ) {
			if ( isset( $product_defaults[ $name ] ) ) {
				if ( isset( $product_defaults[ $name ]['options'] ) ) {
					foreach ( $product_defaults[ $name ]['options'] as $key => $checked ) {
						if ( $checked ) {
							return $key;
						}
					}
				}
			}
		}

		return null;

	}

	protected static function should_overwrite( $name, $m_name, $post_id ) {
		$product_mappings = self::$product_mappings;
		if ( $product_mappings ) {
			if ( isset( $product_mappings[ $name ] ) ) {
				if ( isset( $product_mappings[ $name ]['overwrite'] ) && 1 == $product_mappings[ $name ]['overwrite'] ) {
					return 1;
				} elseif ( isset( $product_mappings[ $name ]['overwrite'] ) && 0 == $product_mappings[ $name ]['overwrite'] ) {
					$current_value = get_post_meta( $post_id, $m_name );
					if ( $current_value ) {
						return 0;
					} else {
						return 1;
					}
				}
			}
		}

		return null;
	}

	protected static function should_overwrite_post_attr( $name, $attr, $post_id ) {
		$product_mappings = self::$product_mappings;
		if ( $product_mappings ) {
			if ( isset( $product_mappings[ $name ] ) ) {
				if ( isset( $product_mappings[ $name ]['overwrite'] ) && 1 == $product_mappings[ $name ]['overwrite'] ) {
					return 1;
				} elseif ( isset( $product_mappings[ $name ]['overwrite'] ) && 0 == $product_mappings[ $name ]['overwrite'] ) {
					$current_value = get_post_field( $attr, $post_id );
					if ( $current_value ) {
						return 0;
					} else {
						return 1;
					}
				}
			}
		}

		return null;
	}

	protected static function get_rounding( $name ) {
		$product_mappings = self::$product_mappings;
		if ( $product_mappings ) {
			if ( isset( $product_mappings[ $name ] ) ) {
				if ( isset( $product_mappings[ $name ]['rounding'] ) ) {
					foreach ( $product_mappings[ $name ]['rounding'] as $key => $checked ) {
						if ( $checked ) {
							return $key;
						}
					}
				}
			}
		}

		return null;
	}


}