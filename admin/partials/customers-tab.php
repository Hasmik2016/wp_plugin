
<!--<small>-->
<!--    --><?php
//    _e('Default settings for customers created from DK.', $WsWp_i18n->get_domain())
//    ?>
<!--</small>-->
<!---->
<!--<form method="post" action="--><?php //echo admin_url('admin-post.php'); ?><!--">-->
<!--    <input type="hidden" name="action" value="ws_wp_customers_default_update">-->
<!--    <input type="submit" class="button button-primary" value="--><?php //_e('Update', $WsWp_i18n->get_domain()) ?><!--">-->
<!--</form>-->


<?php global $WsWp_plugin, $WsWp_i18n; ?>
<h3><?php _e( 'Customer Field mapping', $WsWp_i18n->get_domain() ); ?></h3>
<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
    <table class="form-table custom-tr-border">
        <tbody>
        <?php
        $customer_mappings = WsWpCustomerExporter::get_customer_mappings();
//       printr($customer_mappings);exit;
        if ( $customer_mappings ) {
            foreach ( $customer_mappings as $key => $item ) {
                if ( isset( $item['hide'] ) && ( $item['hide'] == 1 ) ) {
                    continue;
                }
                $disabled = '';
                if ( isset( $item['skip'] ) && $item['skip'] == 1 ) {
                    $disabled = 'disabled';
                }
                ?>
                <tr>
                    <th scope="row"><?php echo $item['name']; ?></th>
                    <td>
                        <fieldset>
                            <?php $options = $item['options'];
                            echo '<input type="hidden" value="1" name="ws_wp_customer_attribute[' . $key . ']"/>';
                            if ( count( $options ) > 1 ) {
                                ?>
                                <label for="ws_wp_customer_mapping[<?php echo $key; ?>]">
                                    <select class="mapping-select disable-on-skip" <?php echo $disabled; ?> required
                                            name="ws_wp_customer_mapping[<?php echo $key; ?>]">
                                        <?php

                                        if ( $options ) {
                                            foreach ( $options as $name => $checked ) {
                                                $selected = ( $checked == 1 ) ? "selected" : "";
                                                echo '<option value="' . $name . '" ' . $selected . '>' . $name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </label><br/>
                            <?php } else {
                                foreach ( $options as $name => $checked ) {
                                    echo '<input type="hidden" value="' . $name . '" name="ws_wp_customer_mapping[' . $key . ']"/>';
                                }
                                ?>
                                <?php
                            }
                            if ( isset( $item['overwrite'] ) && isset( $item['d_overwrite'] ) && isset( $item['skip'] ) ) {
                                ?>
                                <label for="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]">
                                    <?php
                                    $chk = '';
                                    if ( isset( $item['skip'] ) ) {
                                        $chk = ( $item['skip'] == 1 ) ? 'checked' : '';
                                    } ?>
                                    <input class="skip-radio" value="2" type="radio"
                                           name="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'Skip', $WsWp_i18n->get_domain() ); ?>
                                </label><br/>
                                <label for="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]">
                                    <?php
                                    if ( isset( $item['d_overwrite'] ) ) {
                                        $chk = ( $item['d_overwrite'] == 1 ) ? 'checked' : '';
                                    }
                                    ?>
                                    <input class="skip-radio" value="3" type="radio"
                                           name="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'Don\'t Overwrite if data exists', $WsWp_i18n->get_domain() ); ?>
                                </label><br/>
                                <label for="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]">
                                    <?php
                                    if ( isset( $item['overwrite'] ) ) {
                                        $chk = ( $item['overwrite'] == 1 ) ? 'checked' : '';
                                    }
                                    ?>
                                    <input class="skip-radio" value="1" type="radio"
                                           name="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'Overwrite if data exists', $WsWp_i18n->get_domain() ); ?>
                                </label>
                                <?php
                            } else {
                                if ( isset( $item['overwrite'] )&&isset( $item['d_overwrite'] )) {
                                    ?>
                                    <label for="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]">
                                        <?php
                                        if ( isset( $item['d_overwrite'] ) ) {
                                            $chk = ( $item['d_overwrite'] == 1 ) ? 'checked' : '';
                                        }
                                        ?>
                                        <input class="skip-radio" value="3" type="radio"
                                               name="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'Don\'t Overwrite if data exists', $WsWp_i18n->get_domain() ); ?>
                                    </label><br/>
                                    <label for="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]">
                                        <?php
                                        if ( isset( $item['overwrite'] ) ) {
                                            $chk = ( $item['overwrite'] == 1 ) ? 'checked' : '';
                                        }
                                        ?>
                                        <input class="skip-radio" value="1" type="radio"
                                               name="ws_wp_customer_skip_overwrite[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'Overwrite if data exists', $WsWp_i18n->get_domain() ); ?>
                                    </label>
                                <?php } elseif ( isset( $item['overwrite'] ) ) {
                                    ?>
                                    <label for="ws_wp_customer_overwrite[<?php echo $key; ?>]">
                                        <?php
                                        $chk = '';
                                        if ( isset( $item['overwrite'] ) ) {
                                            $chk = ( $item['overwrite'] == 1 ) ? 'checked' : '';
                                        } ?>
                                        <input class="overwrite-checkbox" type="checkbox"
                                               name="ws_wp_customer_overwrite[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'Overwrite if data exists', $WsWp_i18n->get_domain() ); ?>
                                    </label>
                                <?php } ?>
                                <?php
                                if ( isset( $item['skip'] ) ) {
                                    ?>
                                    <br/>
                                    <label for="ws_wp_customer_skip[<?php echo $key; ?>]">
                                        <?php
                                        $chk = '';
                                        if ( isset( $item['skip'] ) ) {
                                            $chk = ( $item['skip'] == 1 ) ? 'checked' : '';
                                        } ?>
                                        <input class="skip-checkbox" type="checkbox"
                                               name="ws_wp_customer_skip[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'Skip', $WsWp_i18n->get_domain() ); ?>
                                    </label>
                                <?php }

                            }
                            ?>
                            <?php
                            if ( isset( $item['pending_if_image_synced'] ) ) {
                                ?>
                                <br/>
                                <label for="ws_wp_customer_pending_if_image_synced[<?php echo $key; ?>]">
                                    <?php
                                    $chk = '';
                                    if ( isset( $item['pending_if_image_synced'] ) ) {
                                        $chk = ( $item['pending_if_image_synced'] == 1 ) ? 'checked' : '';
                                    } ?>
                                    <input type="checkbox"
                                           name="ws_wp_customer_pending_if_image_synced[<?php echo $key; ?>]" <?php echo $chk; ?>/><?php _e( 'If customer synced an image make it pending', $WsWp_i18n->get_domain() ); ?>
                                </label>
                            <?php } ?>
                            <?php
                            if ( isset( $item['rounding'] ) ) {
                                echo '<br/>';
                                $rounding = $item['rounding'];
                                if ( $rounding ) {
                                    foreach ( $rounding as $how => $checked ) {
                                        $chk = ( $checked == 1 ) ? 'checked' : '';
                                        echo '<input class="rounding disable-on-skip" ' . $disabled . ' type="radio" value="' . $how . '" name="ws_wp_customer_rounding[' . $key . ']" ' . $chk . '/>';
                                        switch ( $how ) {
                                            case 'up':
                                                _e( 'Round Up ', $WsWp_i18n->get_domain() );
                                                break;
                                            case 'down':
                                                _e( 'Round Down ', $WsWp_i18n->get_domain() );
                                                break;
                                            default:
                                                _e( 'No rounding ', $WsWp_i18n->get_domain() );
                                                break;
                                        }
                                    }
                                }
                            }
                            ?>
                        </fieldset>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <input type="hidden" name="action" value="ws_wp_customer_mapping">
    <input type="submit" class="button button-primary"
           value="<?php _e( 'Update', $WsWp_i18n->get_domain() ) ?>">
    <br/>
</form>
<br/>
<hr/>
<br/>


<h3><?php _e( 'Update record id from where the customer sync should continue', $WsWp_i18n->get_domain() ); ?></h3>
<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
    <table class="form-table custom-tr-border">
        <tbody>
        <?php
        $last_id = WsWpCustomerExporter::get_last_sync_id_customer();
        ?>
        <tr>
            <th scope="row"><?php _e( 'Last synced record id', $WsWp_i18n->get_domain() ); ?></th>
            <td>
                <fieldset>
                    <input type="number" name="ws_wp_last_sync_id_customer" value="<?php echo $last_id ?>">
                </fieldset>
            </td>
        </tr>
        </tbody>
    </table>
    <input type="hidden" name="action" value="ws_wp_update_customer_record_id"><br/>
    <input type="submit" class="button button-primary"
           value="<?php _e( 'Update record id', $WsWp_i18n->get_domain() ) ?>">
    <br/>
    <small>
        <?php
        _e( 'Do not use this unless advised. This is provided so that you can reset the initial import.', $WsWp_i18n->get_domain() )
        ?>
    </small>
    </table>
</form>
<br/>
<hr/>
<br/>
<h3><?php _e( 'Manually start customer daily sync cron', $WsWp_i18n->get_domain() ); ?></h3>
<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
    <input type="hidden" name="action" value="ws_wp_start_customer_daily_sync_cron"><br/>
    <input type="submit" class="button button-primary"
           value="<?php _e( 'Start', $WsWp_i18n->get_domain() ) ?>">
</form>
<br/>
<hr/>
<br/>
<h3><?php _e( 'Manually start chunk customer sync ', $WsWp_i18n->get_domain() ); ?></h3>
<p>
    <?php
    $last_id = WsWpCustomerExporter::get_last_sync_id_customer();
    printf( esc_html__( 'Import %1$s customers, starting with recordId %2$s.', $WsWp_i18n->get_domain() ), get_option( 'ws_wp_customers_chunk_count', 30 ), $last_id );
    ?>
</p>
<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
    <input type="hidden" name="action" value="ws_wp_start_customer_chunk_sync_cron"><br/>
    <input type="submit" class="button button-primary"
           value="<?php _e( 'Start', $WsWp_i18n->get_domain() ) ?>">
</form>
<br/>
<hr/>
<br/>
<p>
    <b><?php _e( "Daily customer import log files", $WsWp_i18n->get_domain() ) ?> :</b>
    <?php
    $upload_dir = wp_upload_dir();
    $dir        = $upload_dir['basedir'] . '/ws-wp-sync/log/customer_daily_import_log/';
    $uri        = $upload_dir['baseurl'] . '/ws-wp-sync/log/customer_daily_import_log/';
    $files      = glob( $dir . '/*' ); // get all file names
    $weeks      = get_option( 'ws_wp_import_log_weeks', 2 );
    if ( $files ) {
        foreach ( $files as $filename ) { // iterate files
            $file_date_created = strtotime( str_replace( '_', '/', str_replace( '.txt', '', basename( $filename ) ) ) );
            $week_expires      = strtotime( "- $weeks week" );
            if ( is_file( $filename ) && $file_date_created <= $week_expires ) {
                @unlink( $filename );
            } // delete file
            else {
                echo '<br/><a target="_blank" href="' . $uri . basename( $filename ) . '">' . $uri . basename( $filename ) . '</a>';
            }

        }
    } else {
        _e( "No log has been generated yet", $WsWp_i18n->get_domain() );
    } ?>
</p>
<br/>
<hr/>
<br/>
<p>
    <b><?php _e( "Chunk customer import log files", $WsWp_i18n->get_domain() ) ?> :</b>
    <?php
    $upload_dir = wp_upload_dir();
    $dir        = $upload_dir['basedir'] . '/ws-wp-sync/log/customer_chunk_import_log/';
    $uri        = $upload_dir['baseurl'] . '/ws-wp-sync/log/customer_chunk_import_log/';
    $files      = glob( $dir . '/*' ); // get all file names
    $weeks      = get_option( 'ws_wp_import_log_weeks', 2 );
    if ( $files ) {
        foreach ( $files as $filename ) { // iterate files
            $file_date_created = strtotime( str_replace( '_', '/', str_replace( '.txt', '', basename( $filename ) ) ) );
            $week_expires      = strtotime( "- $weeks week" );
            if ( is_file( $filename ) && $file_date_created <= $week_expires ) {
                @unlink( $filename );
            } // delete file
            else {
                echo '<br/><a target="_blank" href="' . $uri . basename( $filename ) . '">' . $uri . basename( $filename ) . '</a>';
            }

        }
    } else {
        _e( "No log has been generated yet", $WsWp_i18n->get_domain() );
    } ?>
</p>
<br/>
<hr/>
<br/>
<p>
    <b><?php _e( "Single customer import log files", $WsWp_i18n->get_domain() ) ?> :</b>
    <?php
    $upload_dir = wp_upload_dir();
    $dir        = $upload_dir['basedir'] . '/ws-wp-sync/log/general_log/';
    $uri        = $upload_dir['baseurl'] . '/ws-wp-sync/log/general_log/';
    $files      = glob( $dir . '/*' ); // get all file names
    $weeks      = get_option( 'ws_wp_import_log_weeks', 2 );
    if ( $files ) {
        foreach ( $files as $filename ) { // iterate files
            $file_date_created = strtotime( str_replace( '_', '/', str_replace( '.txt', '', basename( $filename ) ) ) );
            $week_expires      = strtotime( "- $weeks week" );
            if ( is_file( $filename ) && $file_date_created <= $week_expires ) {
                @unlink( $filename );
            } // delete file
            else {
                echo '<br/><a target="_blank" href="' . $uri . basename( $filename ) . '">' . $uri . basename( $filename ) . '</a>';
            }

        }
    } else {
        _e( "No log has been generated yet", $WsWp_i18n->get_domain() );
    } ?>
</p>
<br/>
<hr/>
<br/>

