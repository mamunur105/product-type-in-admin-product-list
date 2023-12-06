<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Show Product type in product table
 * Plugin URI:        https://wordpress.org/plugins/product-type-in-product-table
 * Description:       The name of the product type is written after the name of the product in the admin area where you can see all the products.
 * Version:           1.0.0
 * Author:            Mamunur Rashid
 * Author URI:        https://profiles.wordpress.org/mamunur105/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to:      6.4
 * Text Domain:       ptiplt
 * Domain Path:       /languages
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
/**
 * @param $column
 * @param $postid
 *
 * @return void
 */
function ptiplt_action_manage_product_custom_column( $column, $post_id ) {
	if ( $column == 'name' ) {
		// Get product
		$product = wc_get_product( $post_id );
		// Get type
		$product_type = $product->get_type();
		// Output
		echo '&nbsp;<span> &ndash; <strong>' .  ucfirst( $product_type ) . '</strong></span>';
	}
}

// Initiate Class when plugin is loaded
add_action( 'plugins_loaded', function (){
	add_action( 'manage_product_posts_custom_column', 'ptiplt_action_manage_product_custom_column', 20, 2 );
} );
