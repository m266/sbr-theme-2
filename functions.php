<?php
if (!defined('WP_DEBUG')) {
    die('Direct access forbidden.');
}

// Child-Theme style.css nach dem Parent-Theme style.css laden
function sbr_enqueue_styles() {
wp_enqueue_style( 'child-main', get_stylesheet_directory_uri
()."/style.css" );
}
add_action( 'wp_enqueue_scripts', 'sbr_enqueue_styles',999);

// Anpassungen fuer SBR-Websites
//////////////////////////////////////////////////////////////////////////////////////////
// Restoring the classic Widgets Editor
function cancel_theme_support()
{
    remove_theme_support('widgets-block-editor');
}
add_action('after_setup_theme', 'cancel_theme_support');

//////////////////////////////////////////////////////////////////////////////////////////
// Copyright-Block Widget
function copyright_shortcode () {
$copyright = date_i18n ('Y')."<br>".get_option('blogname')."<br>"
.get_option('blogdescription')."<br>Alle Rechte vorbehalten";
return $copyright;
}
add_shortcode ('copyright', 'copyright_shortcode');

//////////////////////////////////////////////////////////////////////////////////////////
/*
Remove query strings from static ressources
Dieser Shortcode entfernt die Datenbank-Strings von statischen Ressourcen und verbessert
damit die Performance der Website.
Quelle: https://kinsta.com/de/wissensdatenbank/entfernst-du-abfragezeichenfolgen-
aus-statischen-ressourcen/
 */
if (!function_exists('remove_query_strings')) { // Prüfung, ob Funktion bereits vorhanden
    function remove_query_strings()
    {
        if (!is_admin()) {
            add_filter('script_loader_src', 'remove_query_strings_split', 15);
            add_filter('style_loader_src', 'remove_query_strings_split', 15);
        }
    }
    function remove_query_strings_split($src)
    {
        $output = preg_split("/(&ver|\?ver)/", $src);
        return $output[0];
    }
    add_action('init', 'remove_query_strings');
}

//////////////////////////////////////////////////////////////////////////////////////////
//Eigene Blacklist von GitHub einfuegen
add_filter('cblm_sources', 'rkv_cblm_replace_blacklist_sources');
function rkv_cblm_replace_blacklist_sources($list)
{
    return array(
        'https://raw.githubusercontent.com/m266/wordpress-comment-blacklist/master/blacklist.txt'
    );
}

//////////////////////////////////////////////////////////////////////////////////////////
/* Erlaubt Links in Mehrfachauswahl-Feldern von Happyforms
Credits/Special thanks: Ignazio Setti https://thethemefoundry.com/
*/
add_shortcode( 'happyforms_link', function( $atts, $content = '' ) {
    $atts = shortcode_atts( array( 'href' => '#' ), $atts );
    $atts['href'] = str_replace( '&quot;', '', $atts['href'] );
    $link = "<a href=\"{$atts['href']}\" target=\"_blank\">{$content}</a>";

    return $link;
}, 10, 2 );

add_action( 'happyforms_part_before', function( $part ) {
    if ( 'checkbox' !== $part['type'] ) {
        return;
    }

    ob_start();
} );

add_action( 'happyforms_part_after', function( $part ) {
    if ( 'checkbox' !== $part['type'] ) {
        return;
    }

    echo do_shortcode( ob_get_clean() );
} );

//////////////////////////////////////////////////////////////////////////////////////////
// Verbesserung Bestätigungs-E-Mail von Happyforms (Block der Zustimmung wird ausgeblendet)
// Der Inhalt der Variable "$label" muss exakt dem Text im Formular entsprechen; bei Bedarf in Zeile 196 anpassen.
add_filter('happyforms_email_part_visible', function ($visible, $part, $form) {
    $label = 'Das Formular kann nur mit der Zustimmung zur Datenschutzerklärung gesendet werden*';
    if (isset($part['label']) && $label === $part['label']) {
        $visible = false;
    }

    return $visible;
}, 10, 3);

//////////////////////////////////////////////////////////////////////////////////////////
/*
Feld "Nachricht" von Happyforms wird mit Kommentar-Blacklist abgeglichen
Credits/Special thanks: Ignazio Setti https://thethemefoundry.com/
 */
add_filter('happyforms_validate_submission', function ($is_valid, $request, $form) {
    $mod_keys = trim(get_option('disallowed_keys'));

    if ('' === $mod_keys) {
        return $is_valid;
    }

    foreach ($form['parts'] as $part) {
        if ($part['type'] === 'multi_line_text') {
            $part_name = happyforms_get_part_name($part, $form);
            $part_value = $request[$part_name];

            foreach (explode("\n", $mod_keys) as $word) {
                $word = trim($word);
                $length = strlen($word);

                if ($length < 2 or 256 < $length) {
                    continue;
                }

                $pattern = sprintf('#%s#i', preg_quote($word, '#'));

                if (preg_match($pattern, $part_value)) {
                    $is_valid = false;
                }
            }
        }
    }

    return $is_valid;
}, 10, 3);

//////////////////////////////////////////////////////////////////////////////////////////
/*
Happyforms-Formulare exportieren
Credits/Special thanks: Ignazio Setti https://thethemefoundry.com/
*/
add_filter( 'happyforms_happyform_post_type_args', function( $args ) {
    $args['can_export'] = true;

    return $args;
} );

//////////////////////////////////////////////////////////////////////////////////////////
// Beiträge in Seiten einfügen
// Quelle: https://ostrich.de/wordpress-beitraege-auf-seite-anzeigen/
// Version 1.0
// 09.03.2021
// Tag [posts] in der Start-Seite einfügen
function shortcode_posts_function()
{
    //Parameter für Posts
    $args = array(
        'category' => 'news', // Kategorie
        'numberposts' => 5// Anzahl der Beiträge
    );
    //Posts holen
    $posts = get_posts($args);
    //Inhalte sammeln
    $content = '<div class="posts">';
    $content .= '<hr>
    <h3 class="page-title">Letzte &Auml;nderungen:</h3>';
    foreach ($posts as $post) {
        $content .= '<div class="post">';
        $content .= '<b><a href="' . get_permalink($post->ID) . '"><div class="title">' . $post->post_title . '</div></b></a>';
        $content .= '<div class="post-date">' . mysql2date('d. F Y', $post->post_date) . '</div>';
        $content .= '<div class="post-entry">' . wp_trim_words($post->post_content) . '</div>';
        $content .= '<a href="' . get_permalink($post->ID) . '"><div class="post-entry">' . "Weiterlesen..." . '<hr></div></a>';
        $content .= '</div>';
    }
    $content .= '</div>';
    //Inhalte übergeben
    return $content;
}
add_shortcode('posts', 'shortcode_posts_function');

//////////////////////////////////////////////////////////////////////////////////////////
/* Externe HTML-Seite einfügen
 * Shortcode [wpiec]URL[/wpiec] in Seite/Beitrag einfügen
 */
function wpiec_shortcode($atts = array(), $content = null)
{
    $content = file_get_contents($content);
    return $content;
}
add_shortcode('wpiec', 'wpiec_shortcode');

//////////////////////////////////////////////////////////////////////////////////////////
/*
Google-Fonts in MailPoet deaktivieren
Credits: https://kb.mailpoet.com/article/332-how-to-disable-google-fonts
*/
add_filter('mailpoet_display_custom_fonts', function () {return false;});