<?php global $WsWp_plugin, $WsWp_i18n; ?>
<h3><?php _e('Update configuration', $WsWp_i18n->get_domain()); ?></h3>

<?php
$config_valid = false;
$config = $this->get_config_settings();
if (isset($config->message)) {
    $config = $config->message;
    if (isset($config->api_user) && isset($config->api_password) && isset($config->api_user)) {
        $config_valid = true;
    }
}
if($config_valid)
{
    $hide_products="";
    $hide_orders="";
    if(!$config->products_active)
    {
        $hide_products='style="display:none;"';
    }
    if(!$config->orders_active)
    {
        $hide_orders='style="display:none;"';
    }
}
?>
<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
    <table class="form-table custom-tr-border">
        <tbody>
        <tr <?php echo $hide_products ?>>
            <th scope="row"><?php _e('How many products should be synced in one go ?', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <label for="ws_wp_products_chunk_count">
                        <input type="number" name="ws_wp_products_chunk_count"
                               value="<?php echo get_option('ws_wp_products_chunk_count', 30) ?>">
                    </label></fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e('How many weeks should the log be kept ?', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <label for="ws_wp_import_log_weeks">
                        <input type="number" name="ws_wp_import_log_weeks"
                               value="<?php echo get_option('ws_wp_import_log_weeks', 2) ?>">
                    </label></fieldset>
            </td>
        </tr>
        <tr <?php echo $hide_products ?>>
            <th scope="row"><?php _e('Sync products not created with the dk sync plugin (based on sku)', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <label for="ws_wp_product_sync_with_sku">
                        <?php
                        $chk = '';
                        $sync_with_sku = get_option('ws_wp_product_sync_with_sku', 1);
                        $chk = ($sync_with_sku == 1) ? 'checked' : ''; ?>
                        <input type="checkbox"
                               name="ws_wp_product_sync_with_sku" <?php echo $chk; ?>/>
                    </label></fieldset>
            </td>
        </tr>
        <tr <?php echo $hide_products ?>>
            <th scope="row"><?php _e('Automatically sync products with DK', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <label for="ws_wp_product_sync_auto">
                        <?php
                        $chk = '';
                        $sync_auto = get_option('ws_wp_product_sync_auto', 1);
                        $chk = ($sync_auto == 1) ? 'checked' : ''; ?>
                        <input type="checkbox"
                               name="ws_wp_product_sync_auto" <?php echo $chk; ?>/>
                    </label></fieldset>
            </td>
        </tr>
        <tr <?php echo $hide_products ?>>
            <th scope="row"><?php _e('Automatically send orders to DK', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <label for="ws_wp_order_sync_auto">
                        <?php
                        $chk = '';
                        $sync_auto_orders = get_option('ws_wp_order_sync_auto', 1);
                        $chk = ($sync_auto_orders == 1) ? 'checked' : ''; ?>
                        <input type="checkbox"
                               name="ws_wp_order_sync_auto" <?php echo $chk; ?>/>
                    </label></fieldset>
            </td>
        </tr>
        <tr <?php echo $hide_orders ?>>
	        <th scope="row"><?php _e('Fetch new product and product changes interval', $WsWp_i18n->get_domain()); ?></th>
	        <td>
		        <fieldset>
			        <label for="ws_wp_fetch_interval">
				        <select required name="ws_wp_fetch_interval">
					        <?php
					        $selected_interval=get_option('ws_wp_fetch_interval', 'daily');

					        $options=array('half_an_hour'=>__('Every 30 minutes',$WsWp_i18n->get_domain()),'hourly'=>__('Hourly',$WsWp_i18n->get_domain()),'two_hours'=>__('Every 2 hours',$WsWp_i18n->get_domain()),'six_hours'=>__('Every 6 hours',$WsWp_i18n->get_domain()),'twicedaily'=>__('Every 12 hours',$WsWp_i18n->get_domain()),'daily'=>__('Daily',$WsWp_i18n->get_domain()));
					        if ($options)
						        foreach ($options as $k => $name) {
							        $selected = ($k == $selected_interval) ? "selected" : "";
							        echo '<option value="' . $k . '" ' . $selected . '>' . $name . '</option>';
						        }
					        ?>
				        </select>
			        </label></fieldset>
	        </td>
        </tr>
        <tr <?php echo $hide_orders ?>>
	        <th scope="row"><?php _e('Use woocommerce price when sending orders', $WsWp_i18n->get_domain()); ?></th>
	        <td>
		        <fieldset>
			        <label for="ws_wp_use_woo_price">
				        <label for="ws_wp_use_woo_price">
					        <?php
					        $chk = '';
					        $use_woo_price = get_option('ws_wp_use_woo_price', 1);
					        $chk = ($use_woo_price == 1) ? 'checked' : ''; ?>
					        <input type="checkbox"
					               name="ws_wp_order_sync_auto" <?php echo $chk; ?>/>
				        </label></fieldset>
	        </td>
        </tr>

        </tbody>
    </table>
    <input type="hidden" name="action" value="ws_wp_update_configuration"><br/>
    <input type="submit" class="button button-primary"
           value="<?php _e('Update configuration', $WsWp_i18n->get_domain()) ?>">
    <br/>
</form>
<br/>
<hr/>
<br/>
<h3><?php _e('Update error email', $WsWp_i18n->get_domain()); ?></h3>
<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
    <table class="form-table custom-tr-border">
        <tbody>
        <tr>
            <th scope="row"><?php _e('What errors should you receive ?', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <label for="ws_wp_webservice_active_admin_connect_errors">
                        <?php
                        $email_auth_errors = get_option('ws_wp_admin_email_auth_errors', 0)
                        ?>
                        <input type="checkbox" name="ws_wp_admin_email_auth_errors"
                               id="ws_wp_admin_email_auth_errors"
                               value="1" <?php if ($email_auth_errors) echo 'checked'; ?>/>
                        <?php _e("Auth errors", $WsWp_i18n->get_domain()); ?>
                    </label>
                    <label <?php echo $hide_products ?> for="ws_wp_admin_email_item_errors">
                        <?php
                        $email_item_errors = get_option('ws_wp_admin_email_item_errors', 0)
                        ?>
                        <input type="checkbox" name="ws_wp_admin_email_item_errors"
                               id="ws_wp_admin_email_item_errors"
                               value="1" <?php if ($email_item_errors) echo 'checked'; ?>/>
                        <?php _e("Item sync errors", $WsWp_i18n->get_domain()); ?>
                    </label>
                    <label <?php echo $hide_orders ?> for="ws_wp_admin_email_orders_errors">
                        <?php
                        $email_orders_errors = get_option('ws_wp_admin_email_orders_errors', 0)
                        ?>
                        <input type="checkbox" name="ws_wp_admin_email_orders_errors"
                               id="ws_wp_admin_email_orders_errors"
                               value="1" <?php if ($email_orders_errors) echo 'checked'; ?>/>
                        <?php _e("Order sync errors", $WsWp_i18n->get_domain()); ?>
                    </label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e('Email recipient', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <label for="ws_wp_errors_log_recipient">
                        <input type="email" name="ws_wp_errors_log_recipient"
                               value="<?php echo get_option('ws_wp_errors_log_recipient', get_option('admin_email')) ?>">
                    </label></fieldset>
            </td>
        </tr>
        </tbody>
    </table>
    <input type="hidden" name="action" value="ws_wp_update_error_log_configuration"><br/>
    <input type="submit" class="button button-primary"
           value="<?php _e('Update', $WsWp_i18n->get_domain()) ?>">
    <br/>
</form>
<br/>
<hr/>
<br/>
<p>
	<b><?php _e("Log files", $WsWp_i18n->get_domain()) ?> :</b>
	<?php
	$upload_dir = wp_upload_dir();
	$dir = $upload_dir['basedir'] . '/ws-wp-sync/log/dev_log/';
	$uri= $upload_dir['baseurl'] . '/ws-wp-sync/log/dev_log/';
	$files = glob($dir.'/*'); // get all file names
	$weeks = get_option('ws_wp_import_log_weeks', 2);
	if ($files)
		foreach ($files as $filename) { // iterate files
			$file_date_created = strtotime(str_replace('_', '/', str_replace('.txt', '', basename($filename))));
			$week_expires = strtotime("- $weeks week");
			if (is_file($filename) && $file_date_created <= $week_expires)
				@unlink($filename); // delete file
			else echo '<br/><a target="_blank" href="'.$uri . basename($filename) . '">' . $uri . basename($filename) . '</a>';

		} else
		_e("No log has been generated yet", $WsWp_i18n->get_domain()); ?>
</p>
<br/>
<hr/>
<br/>
