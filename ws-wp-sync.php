<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * this starts the plugin.
 *
 * @link              http://tactica.is
 * @since             1.0.0
 * @package           Ws_Wp_Sync
 *
 * @wordpress-plugin
 * Plugin Name:       DK Sync
 * Plugin URI:        http://tactica.is
 * Description:       DK - Woocommerce sync plugin
 * Version:           2.2
 * Author URI:        http://tactica.is
 * Text Domain:       ws-wp-sync
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
if ( ! defined( 'WS_WP_VERSION' ) ) {
    define( 'WS_WP_VERSION', 2.1 );
}
/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ws-wp-sync-activator.php';
/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ws-wp-sync-deactivator.php';
/** This action is documented in includes/class-ws-wp-sync-activator.php */
register_activation_hook( __FILE__, array( 'Ws_Wp_Sync_Activator', 'activate' ) );
/** This action is documented in includes/class-ws-wp-sync-deactivator.php */
register_activation_hook( __FILE__, array( 'Ws_Wp_Sync_Deactivator', 'deactivate' ) );
//plugin updates
/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ws-wp-sync.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ws_wp_sync() {
    global $WsWp_plugin, $wp_rewrite, $WsWp_public, $WsWp_admin;
    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', 'ws_wp_activate_wc_notice' );
    } else {
        $WsWp_plugin = new Ws_Wp_Sync();
        $WsWp_plugin->run();
        if ( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            $config = $WsWp_admin->get_config_settings();
        }
    }
    require_once plugin_dir_path( __FILE__ ) . 'includes/plugin-update-checker/plugin-update-checker.php';
    $config = get_transient( 'ws_wp_dk_api_json_config' );
    if ( isset( $config->message ) ) {
        $config = $config->message;
    }
    if ( isset( $config->update_url ) ) {
        $ws_wp_sync_update = PucFactory::buildUpdateChecker(
            $config->update_url,
            __FILE__
        );
    }

}

function ws_wp_activate_wc_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'Woocommerce has to be installed and activated for the Ws Wp Sync plugin to work!', 'ws-wp-sync' ); ?></p>
    </div>
    <?php
}

function ws_wp_setup_plugin_options() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'Please setup the plugin options to allow the sync ws wp sync to work!', 'ws-wp-sync' ); ?></p>
        <a href="<?php echo admin_url( '/options-general.php?page=dk-sync-settings' ); ?>"><?php _e( "Options", "ws-wp-sync" ); ?></a>
    </div>
    <?php
}

run_ws_wp_sync();
