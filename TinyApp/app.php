<?php
/**
 * @param $column
 * @param $postid
 *
 * @return void
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

require_once PTIPLT_PATH . 'vendor/autoload.php';

use PTIPLT\Traits\SingletonTrait;
use PTIPLT\Controllers\Dependencies;
use PTIPLT\Hooks\FilterHooks;

if ( ! class_exists( Ptiplt::class ) ) {
	/**
	 * Main initialization class.
	 */
	final class Ptiplt {
		/**
		 * Singleton
		 */
		use SingletonTrait;

		/**
		 * Class Constructor
		 */
		private function __construct() {
			add_action( 'init', [ $this, 'init' ] );
			add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ], 11 );
			// HPOS.
			add_action(
				'before_woocommerce_init',
				function () {
					if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
						\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', PTIPLT_FILE, true );
					}
				}
			);
			$this->init_controller();
		}

		/**
		 * Load Text Domain
		 */
		public function init() {
			load_plugin_textdomain( 'ptiplt', false, PTIPLT_ABSPATH . '/languages/' );
		}

		/**
		 * Load Text Domain
		 */
		public function plugins_loaded() {}

		/**
		 * Init
		 *
		 * @return void
		 */
		public function init_controller() {
			if ( ! Dependencies::instance()->check() ) {
				return;
			}
			do_action( 'ptiplt/before_loaded' );
			FilterHooks::instance();
			do_action( 'ptiplt/after_loaded' );
		}
	}

	/**
	 * @return ptiplt
	 */
	function ptiplt() {
		return Ptiplt::instance();
	}

	ptiplt();
}
