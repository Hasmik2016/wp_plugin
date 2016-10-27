<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://tactica.is
 * @since      1.0.0
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/admin
 *
 */
class Ws_Wp_Sync_Admin {

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
     * The soap handle
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The soap handle of the plugin
     */
    private $soap;

    /**
     * The soap handle
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The soap handle of the plugin
     */
    private $sproxy;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string $name The name of this plugin.
     * @var      string $version The version of this plugin.
     */
    public function __construct( $name, $version ) {
        $this->name    = $name;
        $this->version = $version;

    }

    public static function email_error( $text, $type ) {
        global $WsWp_i18n;
        $recipient = get_option( 'ws_wp_errors_log_recipient', get_option( 'admin_email' ) );
        if ( $type == "auth" ) {
            $email_auth_errors = get_option( 'ws_wp_admin_email_auth_errors', 0 );
            if ( $email_auth_errors ) {
                wp_mail( $recipient, __( "Auth errors on ", $WsWp_i18n->get_domain() ) . get_bloginfo( 'name' ), $text );
            }
        } elseif ( $type == "item" ) {
            $email_item_errors = get_option( 'ws_wp_admin_email_item_errors', 0 );
            if ( $email_item_errors ) {
                wp_mail( $recipient, __( "Item errors on ", $WsWp_i18n->get_domain() ) . get_bloginfo( 'name' ), $text );
            }
        } elseif ( $type == "order" ) {
            $email_orders_errors = get_option( 'ws_wp_admin_email_orders_errors', 0 );
            if ( $email_orders_errors ) {
                wp_mail( $recipient, __( "Orders errors on ", $WsWp_i18n->get_domain() ) . get_bloginfo( 'name' ), $text );
            }
        }
    }

    public static function get_order_sync_status( $order_id ) {
        $order_has_been_synced = get_post_meta( $order_id, '_ws_wp_has_order_synced', true );
        if ( $order_has_been_synced == "" ) {
            $order_has_been_synced = get_post_meta( $order_id, 'ws_wp_has_order_synced', true );
        }

        return $order_has_been_synced;
    }

    public function soap( $call ) {
    }

    public function fetch_credentials() {
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
        $url         = $this->get_wb_url() . '/?user=' . $this->get_wb_username() . '&pass=' . $this->get_wb_password() . '&site=' . urlencode( get_home_url() ) . '&plugin_version=' . WS_WP_VERSION . '&product_count=' . $total_products;
        $json        = wp_remote_fopen( $url );
        $json_config = json_decode( $json );
        set_transient( 'ws_wp_dk_api_json_config', $json_config, 24 * HOUR_IN_SECONDS );
        return $json_config;
    }

    public function get_config_settings() {
        global $WsWp_i18n;
        if ( false === ( $json_config = get_transient( 'ws_wp_dk_api_json_config' ) ) ) {
            WsWpLogger::append_dev( __( 'Trying to fetch auth credentials', $WsWp_i18n->get_domain() ) );
            WsWpLogger::append_dev( __( 'Credentials not found in cache, fetching from server.', $WsWp_i18n->get_domain() ) );
            $json_config = $this->fetch_credentials();
        }

        return $json_config;
    }

    public function check_for_updates() {

    }

    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ws_Wp_Sync_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ws_Wp_Sync_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/ws-wp-sync-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ws_Wp_Sync_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ws_Wp_Sync_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/ws-wp-sync-admin.js', array( 'jquery' ), $this->version, false );

    }

    /**
     * Function used to add the main page
     */
    public function add_settings_page() {
        add_options_page(
            'DK Sync',
            'DK Sync',
            'manage_options',
            'dk-sync-settings',
            array( $this, 'settings_page' )
        );


    }

    /**
     * Function to add the settings links
     */
    public function add_action_links( $actions, $plugin_file ) {
        global $WsWp_i18n;
        if ( $plugin_file == 'ws-wp-sync/ws-wp-sync.php' ) {
            $action_links = array(
                'settings' => '<a href="' . admin_url( 'admin.php?page=dk-sync-settings' ) . '" title="' . esc_attr( __( 'View Ws Wp Sync Settings', $WsWp_i18n->get_domain() ) ) . '">' . __( 'Settings', $WsWp_i18n->get_domain() ) . '</a>',
            );

            return array_merge( $actions, $action_links );

        }

        return $actions;
    }

    /**
     * Function used to include the elements on the settings page.
     */
    public function settings_page() {
        require_once( plugin_dir_path( __FILE__ ) . 'partials/ws-wp-admin-display.php' );
    }

    function is_valid_url( $url ) {
        // Must start with http:// or https://
        if ( 0 !== strpos( $url, 'http://' ) && 0 !== strpos( $url, 'https://' ) ) {
            return false;
        }
        // Must pass validation
        if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
            return false;
        }

        return true;
    }

    function is_valid_username( $username ) {
        if ( $username == "" ) {
            return false;
        }

        return true;

    }

    function is_valid_password( $password ) {
        if ( $password == "" ) {
            return false;
        }

        return true;

    }

    function update_field_password( $new_value, $old_value ) {
        global $WsWp_plugin, $WsWp_i18n, $WsWp_public;
        $json = $this->fetch_credentials();
        if ( isset( $json->message ) ) {
            $config = $json->message;
            delete_transient( 'ws_wp_api_not_return' );
            if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                delete_transient( 'ws_wp_api_not_return_credentials' );
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&success=1&tab=general' ) );
                exit();
            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                set_transient( 'ws_wp_api_not_return_credentials', true );
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }

        } else {
            WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
            WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
            WsWpLogger::writeLogs();
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
            exit();
        }

    }

    public function handle_post_submit() {
        global $WsWp_plugin, $WsWp_i18n, $WsWp_public;
        if ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_fetch_credentials_again' ) {
            $json = $this->fetch_credentials();
            if ( isset( $json->message ) ) {
                $config = $json->message;
                delete_transient( 'ws_wp_api_not_return' );
                if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                    delete_transient( 'ws_wp_api_not_return_credentials' );
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&success=1&tab=general' ) );
                    exit();
                } else {
                    WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                    WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                    WsWpLogger::writeLogs();
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                    exit();
                }

            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }

        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_customer_mapping' ) {
            //$result = WsWpCustomerExporter::getCustomers();
            $WsWp_public->getCustomers();

            WsWpCustomerExporter::set_customer_mappings();
            $customer_mappings = WsWpCustomerExporter::get_customer_mappings();


            foreach ( $customer_mappings as $key => $item ) {
                if ( isset( $_POST['ws_wp_customer_attribute'][ $key ] ) ) {
                    if ( isset( $item['hide'] ) && $item['hide'] == 1 ) {
                        continue;
                    }
                    $options = $item['options'];
                    if ( $options ) {
                        foreach ( $options as $name => $checked ) {
                            if ( $_POST['ws_wp_customer_mapping'][ $key ] == $name ) {
                                $item['options'][ $name ] = 1;
                            } else {
                                $item['options'][ $name ] = 0;
                            }
                        }
                    }
                    if ( isset( $_POST['ws_wp_customer_overwrite'][ $key ] ) ) {
                        if ( $_POST['ws_wp_customer_skip_overwrite'][ $key ] == 1 ) {
                            $item['overwrite']   = 1;
                            $item['d_overwrite'] = 0;
                        } else {
                            $item['overwrite']   = 0;
                            $item['d_overwrite'] = 1;
                        }
                    } else {
                        $item['overwrite']   = 0;
                        $item['d_overwrite'] = 1;
                    }
                    if ( isset( $_POST['ws_wp_customer_skip'][ $key ] ) ) {
                        $item['skip'] = 1;
                    } else {
                        $item['skip'] = 0;
                    }
                    if ( isset( $_POST['ws_wp_customer_skip_overwrite'][ $key ] ) ) {
                        if ( $_POST['ws_wp_customer_skip_overwrite'][ $key ] == 1 ) {
                            $item['skip']        = 0;
                            $item['overwrite']   = 1;
                            $item['d_overwrite'] = 0;
                        } elseif ( $_POST['ws_wp_customer_skip_overwrite'][ $key ] == 2 ) {
                            $item['skip']        = 1;
                            $item['overwrite']   = 0;
                            $item['d_overwrite'] = 0;
                        } elseif ( $_POST['ws_wp_customer_skip_overwrite'][ $key ] == 3 ) {
                            $item['skip']        = 0;
                            $item['overwrite']   = 0;
                            $item['d_overwrite'] = 1;
                        }
                    }

                    update_option( 'ws_wp_customer_mappings_' . $key, $item );


                }
            }





            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&tab=customers' ) );

        }elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_update_customer_record_id' ) {
            $last_id = intval( $_POST['ws_wp_last_sync_id_customer'] );
            WsWpCustomerExporter::update_last_sync_id_customer( $last_id );
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&tab=customers' ) );
        }elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_product_mapping' ) {
            $json = $this->fetch_credentials();
            if ( isset( $json->message ) ) {
                $config = $json->message;
                delete_transient( 'ws_wp_api_not_return' );
                if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                    delete_transient( 'ws_wp_api_not_return_credentials' );

                } else {
                    WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                    WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                    WsWpLogger::writeLogs();
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                    exit();
                }

            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }
            WsWpProductImporter::set_product_mappings();
            $product_mappings = WsWpProductImporter::get_product_mappings();
            foreach ( $product_mappings as $key => $item ) {
                if ( isset( $_POST['ws_wp_product_attribute'][ $key ] ) ) {
                    if ( isset( $item['hide'] ) && $item['hide'] == 1 ) {
                        continue;
                    }
                    $options = $item['options'];
                    if ( $options ) {
                        foreach ( $options as $name => $checked ) {
                            if ( $_POST['ws_wp_product_mapping'][ $key ] == $name ) {
                                $item['options'][ $name ] = 1;
                            } else {
                                $item['options'][ $name ] = 0;
                            }
                        }
                    }
                    if ( isset( $_POST['ws_wp_product_overwrite'][ $key ] ) ) {
                        if ( $_POST['ws_wp_product_skip_overwrite'][ $key ] == 1 ) {
                            $item['overwrite']   = 1;
                            $item['d_overwrite'] = 0;
                        } else {
                            $item['overwrite']   = 0;
                            $item['d_overwrite'] = 1;
                        }
                    } else {
                        $item['overwrite']   = 0;
                        $item['d_overwrite'] = 1;
                    }
                    if ( isset( $_POST['ws_wp_product_skip'][ $key ] ) ) {
                        $item['skip'] = 1;
                    } else {
                        $item['skip'] = 0;
                    }
                    if ( isset( $_POST['ws_wp_product_skip_overwrite'][ $key ] ) ) {
                        if ( $_POST['ws_wp_product_skip_overwrite'][ $key ] == 1 ) {
                            $item['skip']        = 0;
                            $item['overwrite']   = 1;
                            $item['d_overwrite'] = 0;
                        } elseif ( $_POST['ws_wp_product_skip_overwrite'][ $key ] == 2 ) {
                            $item['skip']        = 1;
                            $item['overwrite']   = 0;
                            $item['d_overwrite'] = 0;
                        } elseif ( $_POST['ws_wp_product_skip_overwrite'][ $key ] == 3 ) {
                            $item['skip']        = 0;
                            $item['overwrite']   = 0;
                            $item['d_overwrite'] = 1;
                        }
                    }
                    if ( isset( $_POST['ws_wp_product_pending_if_image_synced'][ $key ] ) ) {
                        $item['pending_if_image_synced'] = 1;
                    } else {
                        $item['pending_if_image_synced'] = 0;
                    }
                    if ( isset( $_POST['ws_wp_product_rounding'][ $key ] ) ) {
                        $rounding = $item['rounding'];
                        if ( $rounding ) {
                            foreach ( $rounding as $how => $checked ) {
                                if ( $_POST['ws_wp_product_rounding'][ $key ] == $how ) {
                                    $item['rounding'][ $how ] = 1;
                                } else {
                                    $item['rounding'][ $how ] = 0;
                                }
                            }
                        }

                    }
                    update_option( 'ws_wp_product_mappings_' . $key, $item );


                }
            }
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&pUpdated=1&tab=products' ) );
            exit();
        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_product_default_update' ) {
            $json = $this->fetch_credentials();
            if ( isset( $json->message ) ) {
                $config = $json->message;
                delete_transient( 'ws_wp_api_not_return' );
                if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                    delete_transient( 'ws_wp_api_not_return_credentials' );

                } else {
                    WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                    WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                    WsWpLogger::writeLogs();
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                    exit();
                }

            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }
            WsWpProductImporter::set_product_defaults();
            $product_defaults = WsWpProductImporter::get_product_defaults();
            foreach ( $product_defaults as $key => $item ) {
                if ( isset( $_POST['ws_wp_product_defaults'][ $key ] ) ) {
                    if ( isset( $item['hide'] ) && $item['hide'] == 1 ) {
                        continue;
                    }
                    $options = $item['options'];
                    if ( $options ) {
                        foreach ( $options as $name => $checked ) {
                            if ( $_POST['ws_wp_product_defaults'][ $key ] == $name ) {
                                $item['options'][ $name ] = 1;
                            } else {
                                $item['options'][ $name ] = 0;
                            }
                        }
                    }
                    update_option( 'ws_wp_product_defaults_' . $key, $item );

                }
            }
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&pUpdated=1&tab=products' ) );
            exit();
        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_update_sales_customer_id' ) {
            $json        = $this->fetch_credentials();
            $customer_id = $_POST['ws_wp_sales_customer_id'];
            WsWpOrderExporter::update_customer_id( $customer_id );
            $salesperson = $_POST['ws_wp_sales_person'];
            WsWpOrderExporter::update_sales_person( $salesperson );
            $shipping_product_id = $_POST['ws_wp_shipping_product_id'];
            WsWpOrderExporter::update_shipping_product_id( $shipping_product_id );
            $active_gateways = WsWpOrderExporter::get_active_gateways();
            if ( $active_gateways ) {
                foreach ( $active_gateways as $key => $val ) {
                    $new_val = intval( $_POST['ws_wp_orders_payment_id'][ $key ] );
                    WsWpOrderExporter::update_payment_mapped_id( $key, $new_val );
                }
            }
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&pUpdated=1&tab=orders' ) );
            exit();
        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_update_product_record_id' ) {
            $json = $this->fetch_credentials();
            if ( isset( $json->message ) ) {
                $config = $json->message;
                delete_transient( 'ws_wp_api_not_return' );
                if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                    delete_transient( 'ws_wp_api_not_return_credentials' );

                } else {
                    WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                    WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                    WsWpLogger::writeLogs();
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                    exit();
                }

            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }
            $last_id = intval( $_POST['ws_wp_last_sync_id_product'] );
            WsWpProductImporter::update_last_sync_id_product( $last_id );
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&pUpdated=1&tab=products' ) );
            exit();

        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_start_product_chunk_sync_cron' ) {
            $json = $this->fetch_credentials();
            if ( isset( $json->message ) ) {
                $config = $json->message;
                delete_transient( 'ws_wp_api_not_return' );
                if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                    delete_transient( 'ws_wp_api_not_return_credentials' );

                } else {
                    WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                    WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                    WsWpLogger::writeLogs();
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                    exit();
                }

            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }
            ob_start();
            $WsWp_public->do_chunk_import_product();
            $output = ob_get_clean();
            WsWpLogger::writeLogs();
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&cStarted=1&tab=products' ) );
            exit();
        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_start_product_daily_sync_cron' ) {
            $json = $this->fetch_credentials();
            ob_start();
            $WsWp_public->do_regular_import_product();
            $output = ob_get_clean();
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&cStarted=1&tab=products' ) );
            WsWpLogger::writeLogs();
            exit();
        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_update_configuration' ) {
            $json = $this->fetch_credentials();
            if ( isset( $json->message ) ) {
                $config = $json->message;
                delete_transient( 'ws_wp_api_not_return' );
                if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                    delete_transient( 'ws_wp_api_not_return_credentials' );

                } else {
                    WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                    WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                    WsWpLogger::writeLogs();
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                    exit();
                }

            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }
            update_option( 'ws_wp_products_chunk_count', $_POST['ws_wp_products_chunk_count'] );
            update_option( 'ws_wp_import_log_weeks', $_POST['ws_wp_import_log_weeks'] );
            update_option( 'ws_wp_fetch_interval', $_POST['ws_wp_fetch_interval'] );
            if ( isset( $_POST['ws_wp_product_sync_with_sku'] ) ) {
                update_option( 'ws_wp_product_sync_with_sku', 1 );
            } else {
                update_option( 'ws_wp_product_sync_with_sku', 0 );
            }
            if ( isset( $_POST['ws_wp_product_sync_auto'] ) ) {
                update_option( 'ws_wp_product_sync_auto', 1 );
            } else {
                update_option( 'ws_wp_product_sync_auto', 0 );
            }
            if ( isset( $_POST['ws_wp_order_sync_auto'] ) ) {
                update_option( 'ws_wp_order_sync_auto', 1 );
            } else {
                update_option( 'ws_wp_order_sync_auto', 0 );
            }
            if ( isset( $_POST['ws_wp_use_woo_price'] ) ) {
                update_option( 'ws_wp_use_woo_price', 1 );
            } else {
                update_option( 'ws_wp_use_woo_price', 0 );
            }
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&pUpdated=1&tab=settings' ) );
            WsWpLogger::writeLogs();
            exit();
        } elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'ws_wp_update_error_log_configuration' ) {
            $json = $this->fetch_credentials();
            if ( isset( $json->message ) ) {
                $config = $json->message;
                delete_transient( 'ws_wp_api_not_return' );
                if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                    delete_transient( 'ws_wp_api_not_return_credentials' );

                } else {
                    WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                    WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                    WsWpLogger::writeLogs();
                    wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                    exit();
                }

            } else {
                WsWpLogger::append_auth_error( __( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
                WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
                WsWpLogger::writeLogs();
                wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&error=1&tab=general' ) );
                exit();
            }
            update_option( 'ws_wp_admin_email_orders_errors', isset( $_POST['ws_wp_admin_email_orders_errors'] ) ? 1 : 0 );
            update_option( 'ws_wp_admin_email_item_errors', isset( $_POST['ws_wp_admin_email_item_errors'] ) ? 1 : 0 );
            update_option( 'ws_wp_admin_email_auth_errors', isset( $_POST['ws_wp_admin_email_auth_errors'] ) ? 1 : 0 );
            update_option( 'ws_wp_errors_log_recipient', $_POST['ws_wp_errors_log_recipient'] );
            WsWpLogger::writeLogs();
            wp_redirect( admin_url( 'options-general.php?page=dk-sync-settings&pUpdated=1&tab=settings' ) );
            exit();
        }
    }

    public function ws_wp_add_intervals( $schedules ) {
        // add a 'weekly' interval
        $schedules['half_an_hour'] = array(
            'interval' => 30 * 60,
            'display'  => __( 'Every half an hour' )
        );
        $schedules['two_hours']    = array(
            'interval' => 2 * 60 * 60,
            'display'  => __( 'Every 2 hours' )
        );
        $schedules['six_hours']    = array(
            'interval' => 6 * 60 * 60,
            'display'  => __( 'Every six hours' )
        );

        return $schedules;
    }

    function daily_cron() {
        if ( ! wp_next_scheduled( 'ws_wp_daily_import' ) ) {
            wp_schedule_event( time(), 'daily', 'ws_wp_daily_import' );
        }
    }

    function twice_a_day_cron() {
        if ( ! wp_next_scheduled( 'ws_wp_twice_a_day_import' ) ) {
            wp_schedule_event( time(), 'twicedaily', 'ws_wp_twice_a_day_import' );
        }
    }

    function every_6_hours_cron() {
        if ( ! wp_next_scheduled( 'ws_wp_six_hours_import' ) ) {
            wp_schedule_event( time(), 'six_hours', 'ws_wp_six_hours_import' );
        }
    }

    function every_2_hours_cron() {
        if ( ! wp_next_scheduled( 'ws_wp_two_hours_import' ) ) {
            wp_schedule_event( time(), 'two_hours', 'ws_wp_two_hours_import' );
        }
    }

    function hourly_cron() {
        if ( ! wp_next_scheduled( 'ws_wp_hourly_import' ) ) {
            wp_schedule_event( time(), 'hourly', 'ws_wp_hourly_import' );
        }
    }

    function half_hour_cron() {
        if ( ! wp_next_scheduled( 'ws_wp_half_hour_import' ) ) {
            wp_schedule_event( time(), 'half_an_hour', 'ws_wp_half_hour_import' );
        }
    }

    function order_completed( $order_id ) {
        global $WsWp_i18n;
        $sync_auto_orders = get_option( 'ws_wp_order_sync_auto', 1 );
        if ( ! $sync_auto_orders ) {
            WsWpLogger::append_order_export( __( 'Order was completed, but automatic order is disabled, so no export was done.', $WsWp_i18n->get_domain() ) );
            WsWpLogger::append_dev( __( "Order was completed, but automatic order is disabled, so no export was done.", $WsWp_i18n->get_domain() ) );
            WsWpLogger::writeLogs();
            update_post_meta( $order_id, '_ws_wp_has_order_synced', - 2 );
        } else {
            $order = WsWpOrderExporter::order_completed( $order_id );
            if ( $order != - 1 && $order != 0 ) {
                update_post_meta( $order_id, '_ws_wp_has_order_synced', 1 );
            } else {
                update_post_meta( $order_id, '_ws_wp_has_order_synced', - 1 );
            }
        }

    }

    function order_status_box( $post ) {
        global $WsWp_i18n;
        $order_has_been_synced = self::get_order_sync_status( $post->ID );
        $ws_key_match          = get_option( 'ws_wp_api_key_hash', '00236a2ae558018ed13b5222ef1bd987' );
        $sync_auto_orders      = get_option( 'ws_wp_order_sync_auto', 1 );
        if ( $order_has_been_synced == 1 ) {
            echo '<p>';
            _e( 'Order has been succesfully synced', $WsWp_i18n->get_domain() );
            echo '</p>';
        } elseif ( $order_has_been_synced == - 1 ) {
            echo '<p>';
            _e( 'A sync was attempted but there were errors. Try again with the button bellow. After the sync is done the page will be refreshed.', $WsWp_i18n->get_domain() );
            echo '</p>';
            echo '<a class="button button-primary" onclick="window.open(\'' . get_bloginfo( 'url' ) . '/ws-wp-api/operations/4/' . $ws_key_match . '/?order_id=' . $post->ID . '\', \'newwindow\', \'width=300, height=250\');setTimeout(location.reload.bind(location),5000); return false;" href="">' . __( 'Resend', $WsWp_i18n->get_domain() ) . '</a>';
        } elseif ( $order_has_been_synced == - 2 ) {
            echo '<p>';
            _e( 'A sync was attempted but the automatic export for orders is disabled, use the button bellow to manually sync the order.', $WsWp_i18n->get_domain() );
            echo '</p>';
            echo '<a class="button button-primary" onclick="window.open(\'' . get_bloginfo( 'url' ) . '/ws-wp-api/operations/4/' . $ws_key_match . '/?order_id=' . $post->ID . '\', \'newwindow\', \'width=300, height=250\');setTimeout(location.reload.bind(location),5000); return false;" href="">' . __( 'Resend', $WsWp_i18n->get_domain() ) . '</a>';
        } else {
            if ( ! $sync_auto_orders ) {
                echo '<p>';
                _e( 'Automatic export for orders is disabled, use the button bellow to manually sync the order.', $WsWp_i18n->get_domain() );
                echo '</p>';
                echo '<a class="button button-primary" onclick="window.open(\'' . get_bloginfo( 'url' ) . '/ws-wp-api/operations/4/' . $ws_key_match . '/?order_id=' . $post->ID . '\', \'newwindow\', \'width=300, height=250\');setTimeout(location.reload.bind(location),5000); return false;" href="">' . __( 'Send', $WsWp_i18n->get_domain() ) . '</a>';
            } else {
                _e( 'A sync was not yet done for this order. This gets done automatically if you change the status of the order to completed', $WsWp_i18n->get_domain() );
            }
        }
    }

    function product_sync_box( $post ) {
        global $WsWp_i18n;
        $record_id               = WsWpProductImporter::get_record_id( $post->ID );
        $ws_key_match            = get_option( 'ws_wp_api_key_hash', '00236a2ae558018ed13b5222ef1bd987' );
        $product_has_been_synced = get_post_meta( $post->ID, '_ws_wp_has_product_synced', true );
        $last_sync_date          = get_post_meta( $post->ID, '_last_sync_date', true );
        if ( $record_id ) {
            if ( $product_has_been_synced == 1 ) {
                echo '<p>';
                _e( 'Product has been succesfully synced', $WsWp_i18n->get_domain() );
                echo '</p>';
            } elseif ( $product_has_been_synced == - 1 ) {
                echo '<p>';
                _e( 'The sync failed.', $WsWp_i18n->get_domain() );
                echo '</p>';
            }
            echo '<a data-recordId="' . $record_id . '" class="button button-primary" onclick="window.open(\'' . get_bloginfo( 'url' ) . '/ws-wp-api/operations/5/' . $ws_key_match . '/?product_id=' . $post->ID . '\', \'newwindow\', \'width=300, height=250\');setTimeout(location.reload.bind(location),5000); return false;" href="">' . __( 'Sync product', $WsWp_i18n->get_domain() ) . '</a>';
            update_post_meta( $post->ID, '_ws_wp_has_product_synced', 0 );
            if ( $last_sync_date ) {
                echo '<p>';
                _e( 'Product has been sync last on:', $WsWp_i18n->get_domain() );
                echo '<br/><b>' . $last_sync_date . '</b>';
                echo '</p>';
            }

        } else {
            $sync_with_sku = get_option( 'ws_wp_product_sync_with_sku', 1 );
            if ( $sync_with_sku ) {
                $sku = get_post_meta( $post->ID, '_sku', true );
                if ( $sku ) {
                    if ( $product_has_been_synced == 1 ) {
                        echo '<p>';
                        _e( 'Product has been succesfully synced', $WsWp_i18n->get_domain() );
                        echo '</p>';
                    } elseif ( $product_has_been_synced == - 1 ) {
                        echo '<p>';
                        _e( 'The sync failed.', $WsWp_i18n->get_domain() );
                        echo '</p>';
                    }
                    echo '<a data-recordId="' . $record_id . '" class="button button-primary" onclick="window.open(\'' . get_bloginfo( 'url' ) . '/ws-wp-api/operations/5/' . $ws_key_match . '/?product_id=' . $post->ID . '\', \'newwindow\', \'width=300, height=250\');setTimeout(location.reload.bind(location),5000); return false;" href="">' . __( 'Sync product', $WsWp_i18n->get_domain() ) . '</a>';
                    update_post_meta( $post->ID, '_ws_wp_has_product_synced', 0 );
                } else {
                    _e( 'Fill in the sku for the product to fetch it from dk, save the product and then you will be able to sync it.', $WsWp_i18n->get_domain() );
                }
            } else {
                _e( 'Not allowed for this product, it was not fetched from DK.', $WsWp_i18n->get_domain() );
            }
        }

    }

    function add_custom_meta_box() {
        global $WsWp_i18n;
        $config_valid = false;
        $config       = $this->get_config_settings();
        if ( isset( $config->message ) ) {
            $config = $config->message;
            if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
                $config_valid = true;
            }
        }
        if ( $config_valid ) {
            if ( $config->orders_active ) {
                add_meta_box( "ws_wp_order_status_box", __( 'Order sync status', $WsWp_i18n->get_domain() ), array(
                    $this,
                    'order_status_box'
                ), "shop_order", "side", "high", null );
            }
            if ( $config->products_active ) {
                add_meta_box( "ws_wp_product_sync_box", __( 'Manual sync product', $WsWp_i18n->get_domain() ), array(
                    $this,
                    'product_sync_box'
                ), "product", "side", "high", null );
            }
        }
    }


    /**
     * Function adding the settings used for the plugin.
     */
    function display_settings_fields() {
        $current_user = wp_get_current_user();
        add_settings_section( "ws-wp-section", __( "Plugin Settings", "ws-wp-sync" ), null, "dk-sync-settings" );
        if ( ! ( $this->get_wb_hide() && ! isset( $_COOKIE[ "you_can_pass_" . $current_user->user_login ] ) ) ) {
            add_settings_field( "ws_wp_webservice_url", __( "Webservice Url", "ws-wp-sync" ), array(
                $this,
                "display_webservice_url_field"
            ), "dk-sync-settings", "ws-wp-section" );
            add_settings_field( "ws_wp_webservice_username", __( "Webservice Username", "ws-wp-sync" ), array(
                $this,
                "display_webservice_username_field"
            ), "dk-sync-settings", "ws-wp-section" );
            add_settings_field( "ws_wp_webservice_password", __( "Webservice Password", "ws-wp-sync" ), array(
                $this,
                "display_webservice_password_field"
            ), "dk-sync-settings", "ws-wp-section" );
        }
        if ( ! isset( $_POST['block_password'] ) ) {
            register_setting( "ws-wp-section", "ws_wp_webservice_url", array(
                $this,
                "validate_webservice_url_field"
            ) );
            register_setting( "ws-wp-section", "ws_wp_webservice_username", array(
                $this,
                "validate_webservice_username_field"
            ) );
            register_setting( "ws-wp-section", "ws_wp_webservice_password", array(
                $this,
                "validate_webservice_password_field"
            ) );
        }
        if ( isset( $_POST['block_password'] ) && ! empty( $_POST['block_password'] ) ) {
            $pass = $_POST['block_password'];
            if ( $this->get_wb_hide() == $pass ) {
                setcookie( "you_can_pass_" . $current_user->user_login, '/', time() + 60 * 60 * 24 );
                add_settings_error( 'block_password', esc_attr( 'block_password' ), 'Access has succesfully been granted', 'success' );
                wp_redirect( 'options-general.php?page=dk-sync-settings' );
            } else {
                add_settings_error( 'block_password', esc_attr( 'block_password' ), 'Incorrect password please try again..', 'error' );
            }
        }
    }

    function display_webservice_url_field() {
        ?>
        <input required type="text" class="large-text"
               placeholder="http://sandbox.dev/wswp/ws-wp-server-api/operations/1/00236a2ae558018ed13b5222ef1bd987"
               name="ws_wp_webservice_url" id="ws_wp_webservice_url"
               value="<?php echo $this->get_wb_url(); ?>"/>
        <?php
    }

    function get_wb_url() {
        return get_option( 'ws_wp_webservice_url' );
    }


    function validate_webservice_url_field( $input ) {
        global $WsWp_i18n;
        $output = $this->get_wb_url();
        if ( $this->is_valid_url( $input ) ) {
            $output = $input;
        } else {
            add_settings_error( 'ws-wp-section', 'invalid-url', __( 'The entered url is not valid.', $WsWp_i18n->get_domain() ) );
        }

        return $output;
    }

    function display_webservice_username_field() {
        global $WsWp_i18n;
        ?>
        <input required type="text" class="large-text" name="ws_wp_webservice_username" id="ws_wp_webservice_username"
               value="<?php echo $this->get_wb_username(); ?>"/>
        <?php
    }

    function get_wb_username() {
        return get_option( 'ws_wp_webservice_username' );
    }

    function validate_webservice_username_field( $input ) {
        global $WsWp_i18n;
        $output = $this->get_wb_username();
        if ( $this->is_valid_username( $input ) ) {
            $output = $input;
        } else {
            add_settings_error( 'ws-wp-section', 'invalid-username', __( 'The entered username is not valid.', $WsWp_i18n->get_domain() ) );
        }

        return $output;
    }

    function display_webservice_password_field() {
        ?>
        <input required class="large-text" type="password" name="ws_wp_webservice_password"
               id="ws_wp_webservice_password" value="<?php echo $this->get_wb_password() ?>"/>
        <?php
    }


    function get_wb_password() {
        return get_option( 'ws_wp_webservice_password' );
    }


    function get_wb_hide() {
        $config = $this->get_config_settings();
        if ( isset( $config->message ) ) {
            $config = $config->message;
            if ( isset( $config->admin_pass )&&$config->admin_pass!='' ) {
                return $config->admin_pass;
            } else {
                return false;
            }
        }

        return false;

    }


    function validate_webservice_password_field( $input ) {
        global $WsWp_i18n;
        $output = $this->get_wb_password();
        if ( $this->is_valid_username( $input ) ) {
            $output = $input;
        } else {
            add_settings_error( 'ws-wp-section', 'invalid-password', __( 'The entered password is not valid.', $WsWp_i18n->get_domain() ) );
        }

        return $output;
    }

    /**
     * Function that alerts the user of error in the api when the url is correct but the credentials are not returned
     */
    function ws_wp_api_credentials_not_ok_notice() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_api_not_return_credentials' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'The api needed by the ws-wp-sync plugin didn\'t return any credentials. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ); ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_api_not_return_credentials' );
        }
    }

    /**
     * Function that alerts the user that soap is disabled
     */
    function ws_wp_api_soap_not_ok_notice() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_api_soap_disabled' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'It seems soap is disabled on the server so the ws-wp api plugin cannot work. Please enable the Soap extension.', $WsWp_i18n->get_domain() ); ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_api_soap_disabled' );
        }
    }


    /**
     * Function that alerts the user of error in the api when the url is not correct
     */
    function ws_wp_api_url_not_ok_notice() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_api_not_return' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'The api needed by the ws-wp-sync plugin didn\'t return anything useful, most likely the url is wrong. Please check the <a href="' . admin_url( 'admin.php?page=dk-sync-settings' ) . '">settings</a>. If everything is correct, try to force fetch the credentials. If that doesn\'t work try to contact the service provider.', $WsWp_i18n->get_domain() ); ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_api_not_return' );
        }
    }

    /**
     * Function that alerts the user of error in the dk api when something is wrong with the connection
     */
    function ws_wp_dk_api_url_not_ok_notice() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_dk_api_not_return' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'The api used by the ws-wp-sync plugin didn\'t work. It may be a temporary failure. If this message keeps showing up, you may want to contact the administrator.<br/> Api Error:<br/>', $WsWp_i18n->get_domain() );
                    echo '<i>' . get_transient( 'ws_wp_dk_api_error' ) . '</i>'; ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_dk_api_not_return' );
            delete_transient( 'ws_wp_dk_api_error' );
        }
    }

    /**
     * Function that alerts the user of error in the order api
     */
    function ws_wp_api_customer_id_not_ok_notice() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_api_customer_id_not_ok' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'The customer id required by the orders sync is not set.', $WsWp_i18n->get_domain() ); ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_api_customer_id_not_ok' );
        }
    }

    /**
     * Function that alerts the user of error in the order api
     */
    function ws_wp_api_customer_id_not_found_notice() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_api_customer_id_not_found' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'The customer id required by the orders sync doesn\'t match any customer from the dk api.', $WsWp_i18n->get_domain() ); ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_api_customer_id_not_found' );
        }
    }

    /**
     * Function that alerts the user of error in the order api because the payment id is not mapped
     */
    function ws_wp_api_payment_not_mapped() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_api_payment_not_mapped' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'The payment method used in one order has no mapping . Unless you map all the payment methods in the ws wp plugin order export will fail', $WsWp_i18n->get_domain() ); ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_api_payment_not_mapped' );
        }
    }

    /**
     * Function that alerts the user that there are too many products
     */
    function ws_wp_api_too_many_products() {
        global $WsWp_i18n;
        ?>
        <?php
        if ( get_transient( 'ws_wp_api_too_many_products' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( 'There are too many products at the moment, you are exceeding the allowed limit so no sync is allowed.', $WsWp_i18n->get_domain() ); ?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'ws_wp_api_too_many_products' );
        }
    }

    function sync_custom_column( $columns ) {
        global $WsWp_i18n;
        $new = array();
        foreach ( $columns as $key => $value ) {
            if ( $key == 'date' ) {
                // Put the Auction column after the Date column
                $new['l_synced'] = __( 'Last Synced', $WsWp_i18n->get_domain() );
            }
            $new[ $key ] = $value;
        }

        return $new;
    }

    function sync_custom_column_value( $column, $post_id ) {
        global $WsWp_i18n;
        if ( $column === 'l_synced' ) {
            $last_sync_date = get_post_meta( $post_id, '_last_sync_date', true );
            if ( $last_sync_date ) {
                echo $last_sync_date;
            } else {
                _e( 'Never Synced', $WsWp_i18n->get_domain() );
            }
        }
    }

    function sync_order_custom_column( $columns ) {
        global $WsWp_i18n;
        $new = array();
        foreach ( $columns as $key => $value ) {
            if ( $key == 'order_date' ) {
                // Put the Auction column after the Date column
                $new['l_synced'] = __( 'Last Synced', $WsWp_i18n->get_domain() );
            }
            $new[ $key ] = $value;
        }

        return $new;
    }

    function sync_order_custom_column_value( $column, $post_id ) {
        global $WsWp_i18n;
        if ( $column === 'l_synced' ) {
            $order_has_been_synced = self::get_order_sync_status( $post_id );
            $sync_auto_orders      = get_option( 'ws_wp_order_sync_auto', 1 );
            if ( $order_has_been_synced == 1 ) {
                echo '<p style="color:#5d944a">';
                _e( 'Order has been succesfully synced', $WsWp_i18n->get_domain() );
                echo '</p>';
            } elseif ( $order_has_been_synced == - 1 ) {
                echo '<p style="color:#ff2222">';
                _e( 'A sync was attempted but there were errors. ', $WsWp_i18n->get_domain() );
                echo '</p>';
            } elseif ( $order_has_been_synced == - 2 ) {
                echo '<p style="color:#ff9300">';
                _e( 'A sync was attempted but the automatic export for orders is disabled.', $WsWp_i18n->get_domain() );
                echo '</p>';
            } else {
                if ( ! $sync_auto_orders ) {
                    echo '<p style="color:#ff9300">';
                    _e( 'Automatic export for orders is disabled.', $WsWp_i18n->get_domain() );
                    echo '</p>';
                } else {
                    echo '<p style="color:#ff9300">';
                    _e( 'A sync was not yet done for this order.', $WsWp_i18n->get_domain() );
                    echo '</p>';
                }
            }
        }
    }


}
