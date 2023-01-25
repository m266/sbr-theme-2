<?php
/* Headerbild für die Startseite
 * Eigenes Headerbild in die Mediathek hochladen
 * Bildlink im Format "/wp-content/..." als Wert im Benutzerdefiniertes Feld eingefügen
 * Ohne Eingabe eines Wertes wird das Standardbild dargestellt
 */
$sbr_headerbild = get_post_meta($post->ID, 'headerbild', true);
if (is_front_page()) {
    ?>
<div style="text-align: center;">
<img class="size-full" src="
<?php
if ($sbr_headerbild == true) {
        echo $sbr_headerbild;
    } else {
        echo "/wp-content/themes/sbr-theme-2/images/sbr_banner.jpg"; /* Default-Bild */
    }
    ?>"
alt="" width="1920" height="690"/>
<br>
</div>
<?php
;
}
?>