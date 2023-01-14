<?php
/*
Stand: 27.12.2022
Check, ob Plugins aktiv sind
*/
// Plugin "WP H-Happyforms Tools" inaktiv?
if (!function_exists('is_plugin_inactive')) {
require_once ABSPATH . '/wp-admin/includes/plugin.php';
}
// Plugin "Happyforms" inaktiv?
if (is_plugin_active('happyforms/happyforms.php')) { 
if (is_plugin_inactive('wp-h-happyforms-tools/wphhft.php')) {
function wphhft_notice() { ?>
<div class="notice notice-error">
<p><?php _e('Bitte das Plugin <a href="https://herbrand.org/wordpress/eigene-plugins/wp-h-happyforms-tools/" target="_blank">
        <b>"WP H-Happyforms Tools"</b></a> herunterladen, installieren und aktivieren!');?></p>

</div>
<?php
}
add_action( 'load-index.php',
function(){
add_action( 'admin_notices', 'wphhft_notice' );
}
);
}
}
?>