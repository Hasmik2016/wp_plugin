<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://tactica.is
 * @since      1.0.0
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/admin/partials
 */
global $WsWp_plugin, $WsWp_i18n;
/* populate field array */
WsWpProductImporter::set_mappings();
WsWpProductImporter::set_product_defaults();
WsWpCustomerExporter::set_mappings();
$current_user = wp_get_current_user();
?>
<div class="wrap">
    <?php
    ?>
    <h2><?php _e( 'Ws Wp Options', 'ws-wp-sync' ) ?></h2>
    <?php
    global $WsWp_admin;
    $config_valid = false;
    $config       = $WsWp_admin->get_config_settings();
    if ( isset( $config->message ) ) {
        $config = $config->message;
        if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
            $config_valid = true;
        }
    }
    if ( $config_valid ) {
        if ( ! ( $WsWp_admin->get_wb_hide() && ! isset( $_COOKIE[ "you_can_pass_" . $current_user->user_login ] ) ) ) {
            ?>
            <h2 class="nav-tab-wrapper">
                <a href="?page=dk-sync-settings&tab=general"
                   class="nav-tab <?php if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == 'general' ) || ! isset( $_GET['tab'] ) ) {
                       echo 'nav-tab-active';
                   } ?>"><?php _e( 'General', $WsWp_i18n->get_domain() ); ?></a>
                <?php if ( $config->products_active ) {
                    ?>
                    <a href="?page=dk-sync-settings&tab=products"
                       class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'products' ) {
                           echo 'nav-tab-active';
                       } ?>"><?php _e( 'Products', $WsWp_i18n->get_domain() ); ?></a>
                <?php } ?>
                <?php if ( $config->orders_active ) { ?>
                    <a href="?page=dk-sync-settings&tab=orders"
                       class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'orders' ) {
                           echo 'nav-tab-active';
                       } ?>"><?php _e( 'Orders', $WsWp_i18n->get_domain() ); ?></a>
                <?php } ?>
                <a href="?page=dk-sync-settings&tab=customers"
                   class="nav-tab <?php if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == 'customers' )) {
                       echo 'nav-tab-active';
                   } ?>"><?php _e( 'Customers', $WsWp_i18n->get_domain() ); ?></a>
                <a href="?page=dk-sync-settings&tab=settings"
                   class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'settings' ) {
                       echo 'nav-tab-active';
                   } ?>"><?php _e( 'Settings', $WsWp_i18n->get_domain() ); ?></a>
            </h2>
        <?php }
    } ?>
    <?php if ( isset( $_GET['cUpdated'] ) && $_GET['cUpdated'] == 0  ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php _e( "There are no new customers for synchronization", $WsWp_i18n->get_domain() ); ?></p>
        </div>
    <?php } ?>
    <?php if ( isset( $_GET['cUpdated'] ) && $_GET['cUpdated'] == 1  ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( "Update was successful", $WsWp_i18n->get_domain() ); ?></p>
        </div>
    <?php } ?>
    <?php if ( isset( $_GET['cUpdated'] ) && $_GET['cUpdated'] == 2  ) {
        ?>
        <div class="notice notice-danger is-dismissible">
            <p><?php _e( "Error during synchronization", $WsWp_i18n->get_domain() ); ?></p>
        </div>
    <?php } ?>

    <?php if ( isset( $_GET['success'] ) && $_GET['success'] == 1 ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( "Config fetched successfully", $WsWp_i18n->get_domain() ); ?></p>
        </div>
    <?php } ?>
    <?php if ( isset( $_GET['pUpdated'] ) && $_GET['pUpdated'] == 1 ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( "Update was successful", $WsWp_i18n->get_domain() ); ?></p>
        </div>
    <?php } ?>
    <?php if ( isset( $_GET['cStarted'] ) && $_GET['cStarted'] == 1 ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( "Cron was started. Check the log to see if there everything worked", $WsWp_i18n->get_domain() ); ?></p>
        </div>
    <?php } ?>
    <?php if ( isset( $_GET['error'] ) && $_GET['error'] == 1 ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php _e( "Config was not returned, please check credentials.", $WsWp_i18n->get_domain() ); ?></p>
        </div>
    <?php } ?>
    <?php if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == 'general' ) || ! isset( $_GET['tab'] ) ) { ?>
        <form method="post" id="ws-wp-settings-api-table"
              action="options-general.php?page=dk-sync-settings">
            <?php
            settings_fields( "ws-wp-section" );
            if ( ! ( $WsWp_admin->get_wb_hide() && ! isset( $_COOKIE[ "you_can_pass_" . $current_user->user_login ] ) ) ) {
                do_settings_sections( "dk-sync-settings" );
            } else {
                ?>
                <h2>Your Password:</h2>
                <input id="block_password" class="large-text" type="password" value="" name="block_password">
                <?php
            }
            submit_button();
            ?>
        </form>
        <br/>
        <hr/>
        <br/>
        <h3><?php _e( 'Force fetch dk api credentials', $WsWp_i18n->get_domain() ); ?></h3>
        <form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
            <input type="hidden" name="action" value="ws_wp_fetch_credentials_again">
            <input type="submit" class="button button-primary"
                   value="<?php _e( 'Force Fetch config', $WsWp_i18n->get_domain() ) ?>">
            <br/>
            <small>
                <?php
                _e( 'Do not use this unless advised. This is provided so that you do not wait an entire day if a request failed.', $WsWp_i18n->get_domain() )
                ?>
            </small>
        </form>
        <br/>
        <hr/>
        <br/>
    <?php } ?>
    <?php if ( $config_valid ) { ?>
        <?php if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == 'general' ) || ! isset( $_GET['tab'] ) ) {
            include( 'general-tab.php' );
        } ?>
        <?php
        /*
        * end general
        */
        /*
         * Start products
         */
        if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'products' ) {
            include( 'product-tab.php' );
        }
        /*
         * End products tab
         */
        /*
        * Start customers
        */
        if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'customers' ) {
            include( 'customers-tab.php' );
        }
        /*
         * End customers tab
         */
        /*
         * Start orders tab
         */
        if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'orders' ) {
            include( 'orders-tab.php' );
        }
        /*
         * End orders tab
         */
        if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'settings' ) {
            include( 'settings-tab.php' );
        }
    }
    ?>
</div>
