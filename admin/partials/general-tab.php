<?php global $WsWp_plugin, $WsWp_i18n; ?>
<h3><?php _e('Cron Helper ', $WsWp_i18n->get_domain()); ?></h3>
<p>
    <?php _e('This plugin relies on the wp cron which needs someone to access the site in ordered to get the functionality triggered.<br/> That can be a problem if the site is not accessed for an hour,<br/> so if cron can be added you can use the following line to make the plugin work without the aid of visitors : ');
    echo '<br/>' . '<i>0 * * * * wget -O /dev/null -o /dev/null ' . get_bloginfo('url') . ' >/dev/null 2>&1</i>';
    ?>
</p>
<br/>
<hr/>
<br/>
