<?php
/*
Widget Name:   SBR-Widget
Widget URI:
Description:   Support für SBR-Websites
Author:        Hans M. Herbrand
Author URI:    https://herbrand.org
Version:       1.0
Date:          2021-09-01
License:       GNU General Public License v2 or later
License URI:   http://www.gnu.org/licenses/gpl-2.0.html
Credits:       https://pressengers.de/tipps/individuelle-wordpress-dashboard-widgets/
*/

function sbr_widget() {
global $wp_meta_boxes;
add_meta_box( 'dashboard_sbr_infobox_widget', 'SBR-Widget', 'sbr_infobox', 'dashboard', 'normal', 'high' );
}
add_action('wp_dashboard_setup', 'sbr_widget');
function sbr_infobox() {
echo '
<div class="custom-dash-box">
<p>
<h2><b>Hinweise für SBR-Websites</b></h2><br />
<ul style="overflow-y:scroll; height:200px; resize: none;">
<ul style="list-style-type: square; margin-left: 14px;">
<li>Der Einbau des SBR-Themes 2 wird noch beschrieben</li>
Headerbild und BeW-Logo liegen im Ordner "sbr-theme-2/images"<br><br>
<li>Import in den LWS oder Internet</li>
Nach dem Importieren in den LWS ist das Plugin "Post SMTP" wie hier beschrieben zu konfigurieren:
<a href="https://herbrand.org/software/lokaler-webserver-lws/wordpress-mail-versand-ueber-smtp/" target="_blank">LWS E-Mail-Versand</a>
<br>
Beim Umzug einer Website ins Internet muss nach dem Umzug auf der Zielwebsite das Plugin "Post SMTP" gelöscht werden!
</ul>
</p>
</div>
';
}