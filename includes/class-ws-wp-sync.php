<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://tactica.is
 * @since      1.0.0
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 *
 */
class Ws_Wp_Sync
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Ws_Wp_Sync_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $ws_wp_sync The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the Dashboard and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = 'ws-wp-sync';
        $this->version = '1.0.0';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }


    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Ws_Wp_Sync_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Ws_Wp_Sync_Loader. Orchestrates the hooks of the plugin.
     * - Ws_Wp_Sync_i18n. Defines internationalization functionality.
     * - Ws_Wp_Sync_Admin. Defines all hooks for the dashboard.
     * - Ws_Wp_Sync_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        //soap classes
        /**
         * Composer autoload
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/external/vendor/autoload.php';
        /**
         * mainly reusable functions that help development
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/helpers.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/wsdl/IItemServiceservice.php';


		/**
		*  Class that handles progress and error logging.
		*/
	    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ws-wp-logger.php';

        /**
         * Product sync wrapper
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/sync/class-ws-wp-product.php';

        /**
         * Order sync wrapper
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/sync/class-ws-wp-order.php';
        /**
         * Order sync wrapper
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/sync/class-ws-wp-customer.php';
        /**
         * Soap wrapper
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ws-wp-soap-wrapper.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-ws-wp-sync-public.php';
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ws-wp-sync-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ws-wp-sync-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the Dashboard.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ws-wp-sync-admin.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-ws-wp-sync-public.php';
        $this->loader = new Ws_Wp_Sync_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Ws_Wp_Sync_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        global $WsWp_i18n;
        $WsWp_i18n = new Ws_Wp_Sync_i18n();
        $WsWp_i18n->set_domain($this->get_plugin_name());
        $this->loader->add_action('plugins_loaded', $WsWp_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        global $WsWp_admin;
        $WsWp_admin = new Ws_Wp_Sync_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $WsWp_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $WsWp_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $WsWp_admin, 'add_settings_page');
        $this->loader->add_action('admin_init', $WsWp_admin, 'display_settings_fields');
        $this->loader->add_action('admin_init', $WsWp_admin, 'handle_post_submit');
        $this->loader->add_action('add_meta_boxes', $WsWp_admin, 'add_custom_meta_box');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_api_credentials_not_ok_notice');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_api_soap_not_ok_notice');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_api_url_not_ok_notice');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_dk_api_url_not_ok_notice');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_api_customer_id_not_ok_notice');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_api_customer_id_not_found_notice');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_api_payment_not_mapped');
        $this->loader->add_action('admin_notices', $WsWp_admin, 'ws_wp_api_too_many_products');
	    $this->loader->add_filter('cron_schedules', $WsWp_admin, 'ws_wp_add_intervals');
        $this->loader->add_filter('plugin_action_links_' . plugin_basename(__FILE__), $WsWp_admin, 'add_action_links');
        $this->loader->add_filter('plugin_action_links', $WsWp_admin, 'add_action_links', 20, 2);
        $this->loader->add_action('init', $WsWp_admin, 'daily_cron');
        $this->loader->add_action('init', $WsWp_admin, 'twice_a_day_cron');
        $this->loader->add_action('init', $WsWp_admin, 'every_6_hours_cron');
        $this->loader->add_action('init', $WsWp_admin, 'every_2_hours_cron');
        $this->loader->add_action('init', $WsWp_admin, 'hourly_cron');
        $this->loader->add_action('init', $WsWp_admin, 'half_hour_cron');
        $this->loader->add_action('update_option_ws_wp_webservice_password', $WsWp_admin, 'update_field_password',10,2);
        $this->loader->add_action('manage_product_posts_columns', $WsWp_admin, 'sync_custom_column',10,1);
        $this->loader->add_action('manage_shop_order_posts_columns', $WsWp_admin, 'sync_order_custom_column',30,1);
        $this->loader->add_action('manage_product_posts_custom_column', $WsWp_admin, 'sync_custom_column_value',20,2);
        $this->loader->add_action('manage_shop_order_posts_custom_column', $WsWp_admin, 'sync_order_custom_column_value',5,2);
        $this->loader->add_action('woocommerce_order_status_completed', $WsWp_admin, 'order_completed');

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        global $WsWp_public,$wp_rewrite;
        $WsWp_public = new Ws_Wp_Sync_Public($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('init', $WsWp_public, 'add_endpoint');
        $this->loader->add_action('wp_enqueue_scripts', $WsWp_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $WsWp_public, 'enqueue_scripts');
        $this->loader->add_filter('query_vars', $WsWp_public, 'add_query_vars');
        //$this->loader->add_action('template_redirect', $WsWp_public, 'send_order');
        $this->loader->add_action('parse_request', $WsWp_public, 'sniff_requests');
	    $interval=get_option('ws_wp_fetch_interval', 'daily');
	    switch($interval) {
		    case 'daily':
			    $this->loader->add_action('ws_wp_daily_import', $WsWp_public, 'do_regular_import_product');
			    break;
		    case 'half_an_hour':
			    $this->loader->add_action('ws_wp_half_hour_import', $WsWp_public, 'do_regular_import_product');
			    break;
		    case 'hourly':
			    $this->loader->add_action('ws_wp_hourly_import', $WsWp_public, 'do_regular_import_product');
			    break;
		    case 'two_hours':
			    $this->loader->add_action('ws_wp_two_hours_import', $WsWp_public, 'do_regular_import_product');
			    break;
		    case 'six_hours':
			    $this->loader->add_action('ws_wp_six_hours_import', $WsWp_public, 'do_regular_import_product');
			    break;
		    case 'twicedaily':
			    $this->loader->add_action('ws_wp_twice_a_day_import', $WsWp_public, 'do_regular_import_product');
			    break;
	    }

        $this->loader->add_action('ws_wp_hourly_import', $WsWp_public, 'do_chunk_import_product');


    }

}
