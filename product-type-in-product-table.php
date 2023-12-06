<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Show Product type in product list table
 * Plugin URI:        https://wordpress.org/plugins/product-type-in-product-table
 * Description:       Integrate custom post type with woocommerce. Sell Any Kind Of Custom Post
 * Version:           1.0.0
 * Author:            Tiny Solutions
 * Author URI:        https://www.wptinysolutions.com/
 * Tested up to:      6.4
 * WC requires at least:3.2
 * WC tested up to:     8.3.0
 * Text Domain:       ptiplt
 * Domain Path:       /languages
 *
 * @package TinySolutions\ptiplt
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

function action_manage_product_custom_column( $column, $postid ) {
	if ( $column == 'name' ) {
		// Get product
		$product = wc_get_product( $postid );
		// Get type
		$product_type = $product->get_type();
		// Output
		echo '&nbsp;<span> &ndash; <strong>' .  ucfirst( $product_type ) . '</strong></span>';
	}
}
add_action( 'manage_product_posts_custom_column', 'action_manage_product_custom_column', 20, 2 );