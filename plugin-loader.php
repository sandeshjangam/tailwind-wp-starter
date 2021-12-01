<?php
/**
 * Plugin Loader.
 *
 * @package {{package}}
 * @since {{since}}
 */

namespace TWS;

use TWS\Inc\Admin_Menu;

/**
 * Plugin_Loader
 *
 * @since 0.0.1
 */
class Plugin_Loader {

	/**
	 * Instance
	 *
	 * @access private
	 * @var object Class Instance.
	 * @since 0.0.1
	 */
	private static $instance;

	/**
	 * Initiator
	 *
	 * @since 0.0.1
	 * @return object initialized object of class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Autoload classes.
	 *
	 * @param string $class class name.
	 */
	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$class_to_load = $class;

		$filename = strtolower(
			preg_replace(
				[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
				[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
				$class_to_load
			)
		);

		$file = TWS_DIR . $filename . '.php';

		// if the file redable, include it.
		if ( is_readable( $file ) ) {
			require_once $file;
		}
	}

	/**
	 * Constructor
	 *
	 * @since 0.0.1
	 */
	public function __construct() {

		spl_autoload_register( [ $this, 'autoload' ] );

		if ( is_admin() ) {
			Admin_Menu::get_instance();
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Plugin_Loader::get_instance();
