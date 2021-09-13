<?php
/**
 * The header for start page
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blocksy
 */

?>

<!doctype html>
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

<a class="skip-link show-on-focus" href="#main">
	<?php echo __('Skip to content', 'blocksy'); ?>
</a>

<?php
	if (function_exists('wp_body_open')) {
		wp_body_open();
	}
?>

<div id="main-container">
	<?php
		do_action('blocksy:header:before');

		blocksy_output_header();

		do_action('blocksy:header:after');
		do_action('blocksy:content:before');
	?>

	<main <?php echo blocksy_main_attr() ?>>
<?php
// Headerbild für Startseite
if ( is_front_page() ) {
?>
<div style="text-align: center;">
<img class="size-full" src="/wp-content/themes/sbr-theme-2/images/sbr_banner.jpg" alt="" width="2335" height="329"/>
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
