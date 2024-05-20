<?php
/*
Stand: 25.01.2024
Check, ob Plugins aktiv/inaktiv sind
*/
// Plugin "Comment Blacklist Updater" aktiv?
if (!function_exists('is_plugin_active')) {
require_once ABSPATH . '/wp-admin/includes/plugin.php';
}
if (is_plugin_active('comment-blacklist-updater/comment-blacklist-updater.php')) {
function wphhft_notice() { ?>
<div class="notice notice-error">
<p><?php _e('Bitte das Plugin <b>"Comment Blacklist Updater"</b></a> deaktivieren und l&ouml;schen!');?></p>

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