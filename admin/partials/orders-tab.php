<?php global $WsWp_plugin, $WsWp_i18n; ?>
<h3><?php _e('Order Sync ', $WsWp_i18n->get_domain()); ?></h3>
<small>
    <?php
    _e('Configured values must match those from DK.', $WsWp_i18n->get_domain())
    ?>
</small>
<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
    <table class="form-table custom-tr-border">
        <tbody>
        <?php
        $customer_id = WsWpOrderExporter::get_sales_customer_id();
        ?>
        <tr>
            <th scope="row"><?php _e('Customer id for the orders export', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <input type="number" name="ws_wp_sales_customer_id" value="<?php echo $customer_id ?>">
                </fieldset>
            </td>
        </tr>
        <?php
        $sales_person = WsWpOrderExporter::get_sales_person();
        ?>
        <tr>
            <th scope="row"><?php _e('Sales person name for the orders export', $WsWp_i18n->get_domain()); ?></th>
            <td>
                <fieldset>
                    <input type="text" name="ws_wp_sales_person" value="<?php echo $sales_person ?>">
                </fieldset>
            </td>
        </tr>
        <?php
        $shipping_product_id = WsWpOrderExporter::get_shipping_product_id();
        ?>
        <tr>
	        <th scope="row"><?php _e('Shipping product id for the orders export', $WsWp_i18n->get_domain()); ?></th>
	        <td>
		        <fieldset>
			        <input type="text" name="ws_wp_shipping_product_id" value="<?php echo $shipping_product_id ?>">
		        </fieldset>
	        </td>
        </tr>
        <?php
        $active_gateways = WsWpOrderExporter::get_active_gateways();
        echo '<tr><th><i>' . __('Map payment gateways', $WsWp_i18n->get_domain()) . '</i><th></tr>';
        if ($active_gateways) {
            foreach ($active_gateways as $key => $val) {
                $id = WsWpOrderExporter::get_payment_mapped_id($key);
                ?>
                <tr>
                    <th scope="row"><?php echo $val['title'];
                        _e(' dk id', $WsWp_i18n->get_domain()); ?></th>
                    <td>
                        <fieldset>
                            <input type="number" name="ws_wp_orders_payment_id[<?php echo $key ?>]"
                                   value="<?php echo $id ?>">
                        </fieldset>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <input type="hidden" name="action" value="ws_wp_update_sales_customer_id"><br/>
    <input type="submit" class="button button-primary"
           value="<?php _e('Update Order export config', $WsWp_i18n->get_domain()) ?>">
    <br/>
    <small>
        <?php
        _e('Orders will not be synced if this is not set.', $WsWp_i18n->get_domain())
        ?>
    </small>
</form>
<p>
    <b><?php _e("Log files", $WsWp_i18n->get_domain()) ?> :</b>
    <?php
    $upload_dir = wp_upload_dir();
    $dir = $upload_dir['basedir'] . '/ws-wp-sync/log/order_export_log/';
    $uri= $upload_dir['baseurl'] . '/ws-wp-sync/log/order_export_log/';
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