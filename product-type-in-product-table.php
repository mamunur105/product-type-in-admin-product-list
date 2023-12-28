<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Show product type within the product table
 * Plugin URI:        https://wordpress.org/plugins/product-type-in-product-table
 * Description:       The name of the product type is written after the name of the product in the admin area where you can see all the products.
 * Version:           0.0.1
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
 * Define cptwooint Constant.
 */

const PTIPLT_VERSION = '0.0.1';

const PTIPLT_FILE = __FILE__;

define( 'PTIPLT_BASENAME', plugin_basename( PTIPLT_FILE ) );

define( 'PTIPLT_URL', plugins_url( '', PTIPLT_FILE ) );

define( 'PTIPLT_ABSPATH', dirname( PTIPLT_FILE ) );

define( 'PTIPLT_PATH', plugin_dir_path( PTIPLT_FILE ) );

/**
 * App Init.
 */
require_once 'TinyApp/app.php';

