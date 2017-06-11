<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package ishop
 */

get_header(); ?>

<?php 

if (class_exists('woocommerce') and is_account_page() || is_checkout() || is_cart() || is_woocommerce()){
    get_template_part('page-custom');
}
elseif ( class_exists('bbPress') and is_bbpress() ) {
    get_template_part('page-custom');
}

	else {get_template_part('page-default');}


