<?php
/**
 * Main FilterHooks class.
 *
 * @package PTIPLT\WM
 */

namespace PTIPLT\Hooks;

defined( 'ABSPATH' ) || exit();

use PTIPLT\Traits\SingletonTrait;

/**
 * Main FilterHooks class.
 */
class FilterHooks {
	/**
	 * Singleton
	 */
	use SingletonTrait;

	/**
	 * Init Hooks.
	 *
	 * @return void
	 */
	private function __construct() {
		// Plugins Setting Page.
		add_action( 'manage_product_posts_custom_column', [ __CLASS__, 'manage_product_custom_column' ], 20, 2 );
	}

	/**
	 * Manage Product Column.
	 *
	 * @param string $column column.
	 * @param int    $post_id product id.
	 *
	 * @return void
	 */
	public static function manage_product_custom_column( $column, $post_id ) {
		if ( 'name' === $column ) {
			$product = wc_get_product( $post_id );
			// Get type.
			$product_type = $product->get_type();
			// Output.
			?>
				<span> &ndash; <strong><?php echo esc_html( ucfirst( $product_type ) ); ?> </strong></span>
			<?php
		}
	}
}
