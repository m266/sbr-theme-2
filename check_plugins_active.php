<?php
/*
Stand: 25.01.2024
Check, ob Plugins aktiv/inaktiv sind
*/
// Plugin "WP H-Happyforms Tools" aktiv?
if (!function_exists('is_plugin_active')) {
require_once ABSPATH . '/wp-admin/includes/plugin.php';
}
if (is_plugin_active('wp-h-happyforms-tools/wphhft.php')) {
function wphhft_notice() { ?>
<div class="notice notice-error">
<p><?php _e('Bitte das Plugin <b>"WP H-Happyforms Tools"</b></a> deaktivieren und l&ouml;schen!');?></p>

</div>
<?php
}
add_action( 'load-index.php',
function(){
add_action( 'admin_notices', 'wphhft_notice' );
}
);
}
?>