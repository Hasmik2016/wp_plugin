<?php
/**
 * Fired during plugin activation
 *
 * @link       http://tactica.is
 * @since      1.0.0
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 *
 */
class Ws_Wp_Sync_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wp_rewrite, $WsWp_public;
        if ( class_exists( 'WooCommerce' ) ) {
            flush_rewrite_rules();
            // create a scheduled event (if it does not exist already)
            $WsWp_public->add_endpoint();
            $wp_rewrite->flush_rules();
// and make sure it's called whenever WordPress loads
        }
        add_action('wp', 'cronstarter_activation');

    }

}
