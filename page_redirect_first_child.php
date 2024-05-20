<?php
/*
Template Name: Auf erste Unterseite weiterleiten
Template URI: https://herbrand.org/wordpress/templates/auf-erste-unterseite-weiterleiten/
Quelle: https://pixelbar.be/blog/wordpress-automatische-weiterleitung-von-eltern-zu-kind-seite/

Description:
Das Template wird zur Weiterleitung auf die erste Unterseite verwendet.

Installation:
Diese Datei muss in das Root des verwendeten Themes hochgeladen werden.
Auf der Elternseite als Template "Auf erste Unterseite weiterleiten" auswählen.
Bitte beachten:
Beim Wechsel des Themes ist die Datei in das neue Theme wieder einzufügen!

Author: Hans-M. Herbrand
Version: 1.5
Datum: 18.05.2021
Author URI: http://herbrand.org/
*/
$unterseiten = get_pages("child_of=".$post->ID."&sort_column=menu_order");
if ($unterseiten) {
$ersteunterseite = $unterseiten[0];
wp_redirect(get_permalink($ersteunterseite->ID));
}
?>