<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blocksy
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <?php do_action('blocksy:head:start') ?>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
    <?php do_action('blocksy:head:end') ?>
</head>

<body <?php body_class(); ?> <?php echo blocksy_body_attr() ?>>

<a class="skip-link show-on-focus" href="<?php echo apply_filters('blocksy:head:skip-to-content:href', '#main') ?>">
    <?php echo __('Skip to content', 'blocksy'); ?>
</a>

<?php
    ob_start();
    blocksy_output_header();
    $global_header = ob_get_clean();

    if (function_exists('wp_body_open')) {
        wp_body_open();
    }
?>

<div id="main-container">
    <?php
        do_action('blocksy:header:before');

        echo $global_header;

        do_action('blocksy:header:after');
        do_action('blocksy:content:before');
    ?>

    <main <?php echo blocksy_main_attr() ?>>
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
        <?php
do_action('blocksy:content:top');
blocksy_before_current_template();
?>