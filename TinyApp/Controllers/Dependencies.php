<?php

namespace PTIPLT\Controllers;

use PTIPLT\Traits\SingletonTrait;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Dependencies
 */
class Dependencies {
	/**
	 * Singleton
	 */
	use SingletonTrait;

	const PLUGIN_NAME = 'Product type in the product table';
	/**
	 * PHP Version
	 */
	const MINIMUM_PHP_VERSION = '7.4';
	/**
	 * Missing Dependencies.
	 *
	 * @var array
	 */
	private $missing = [];
	/**
	 * @var bool
	 */
	private $allOk = true;

	/**
	 * @return bool
	 */
	public function check() {
		/**
		 * Notice.
		 */
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'minimum_php_version' ] );
			$this->allOk = false;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( ! is_multisite() && ! function_exists( 'wp_create_nonce' ) ) {
			require_once ABSPATH . 'wp-includes/pluggable.php';
		}

		// Check WooCommerce.
		$woocommerce = 'woocommerce/woocommerce.php';

		if ( ! is_plugin_active( $woocommerce ) ) {
			$activation_url               = is_multisite() ? '' : wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
			$message                      = sprintf(
				'<strong>%s</strong> %s <strong>%s</strong> %s',
				esc_html( self::PLUGIN_NAME ),
				esc_html__( 'requires', 'ptiplt' ),
				esc_html__( 'WooCommerce', 'ptiplt' ),
				esc_html__( 'plugin to be installed and activated. Please install WooCommerce to continue.', 'ptiplt' )
			);
			$button_text                  = esc_html__( 'Install WooCommerce', 'ptiplt' );
			$this->missing['woocommerce'] = [
				'name'       => 'WooCommerce',
				'slug'       => 'woocommerce',
				'file_name'  => $woocommerce,
				'url'        => $activation_url,
				'message'    => $message,
				'button_txt' => $button_text,
			];

		}

		if ( ! empty( $this->missing ) ) {
			 add_action( 'admin_notices', [ $this, 'missing_plugins_warning' ] );

			$this->allOk = false;
		}

		return $this->allOk;
	}

	/**
	 * Admin Notice For Required PHP Version
	 */
	public function minimum_php_version() {
		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ptiplt' ),
			'<strong>' . esc_html( self::PLUGIN_NAME ) . '</strong>',
			'<strong>PHP</strong>',
			self::MINIMUM_PHP_VERSION
		);
		?>
		<div class="notice notice-warning error notice_error"><p> <?php echo wp_kses_post( $message ); ?> </p></div>
		<?php
	}

	/**
	 * Adds admin notice.
	 */
	public function missing_plugins_warning() {
		$missingPlugins = '';
		$counter        = 0;
		foreach ( $this->missing as $plugin ) {
			$counter++;
			if ( count( $this->missing ) === $counter ) {
				$sep = '';
			} elseif ( count( $this->missing ) - 1 === $counter ) {
				$sep = ' ' . esc_html__( 'and', 'ptiplt' ) . ' ';
			} else {
				$sep = ', ';
			}
			?>
			<div class="ptiplt-wrapper error notice_error">
				<p>
					<?php echo wp_kses_post( $plugin['message'] ); ?>
				</p>
			</div>
			<?php
		}
	}
}
