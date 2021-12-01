<?php
/**
 * Admin Menu.
 *
 * @package {{package}}
 */

namespace TWS\Inc;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin_Menu.
 */
class Admin_Menu {

	/**
	 * Instance
	 *
	 * @access private
	 * @var object Class object.
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object initialized object of class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Instance
	 *
	 * @access private
	 * @var string Class object.
	 * @since 1.0.0
	 */
	private $menu_slug = TWS_PREFIX;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->initialize_hooks();
	}

	/**
	 * Init Hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function initialize_hooks() {
		add_action( 'admin_menu', array( $this, 'setup_menu' ) );
		add_action( 'admin_init', array( $this, 'settings_admin_scripts' ) );
	}

	/**
	 *  Initialize after Cartflows pro get loaded.
	 */
	public function settings_admin_scripts() {
		// Enqueue admin scripts.
		if ( ! empty( $_GET['page'] ) && ( $this->menu_slug === $_GET['page'] || false !== strpos( $_GET['page'], $this->menu_slug . '_' ) ) ) { //phpcs:ignore

			add_action( 'admin_enqueue_scripts', array( $this, 'styles_scripts' ) );
		}
	}

	/**
	 * Add submenu to admin menu.
	 *
	 * @since 1.0.0
	 */
	public function setup_menu() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$menu_slug  = $this->menu_slug;
		$capability = 'manage_options';

		add_menu_page(
			'Tailwind Admin',
			'Tailwind Admin',
			$capability,
			$menu_slug,
			array( $this, 'render' ),
			'',
			40
		);
	}

	/**
	 * Renders the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function render() {

		echo '<div id="tws-settings-app" class="tws-settings-app">';
	}

	/**
	 * Enqueues the needed CSS/JS for the builder's admin settings page.
	 *
	 * @since 1.0.0
	 */
	public function styles_scripts() {

		$localize = array(
			'current_user'   => ! empty( wp_get_current_user()->user_firstname ) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name,
			'admin_base_url' => admin_url(),
			'plugin_dir'     => TWS_URL,
			'plugin_ver'     => TWS_VER,
			'logo_url'       => TWS_URL,
			'admin_url'      => admin_url( 'admin.php' ),
			'ajax_url'       => admin_url( 'admin-ajax.php' ),
			'home_slug'      => $this->menu_slug,
		);

		$this->settings_app_scripts( $localize );
	}

	/**
	 * Settings app scripts
	 *
	 * @param array $localize Variable names.
	 */
	public function settings_app_scripts( $localize ) {
		$handle            = 'tws-admin';
		$build_path        = TWS_DIR . 'build/';
		$build_url         = TWS_URL . 'build/';
		$script_asset_path = $build_path . 'app.asset.php';
		$script_info       = file_exists( $script_asset_path )
			? include $script_asset_path
			: array(
				'dependencies' => array(),
				'version'      => TWS_VER,
			);

		$script_dep = array_merge( $script_info['dependencies'], array( 'updates' ) );

		wp_register_script(
			$handle,
			$build_url . 'app.js',
			$script_dep,
			$script_info['version'],
			true
		);

		wp_register_style(
			$handle,
			$build_url . 'app.css',
			array(),
			TWS_VER
		);

		wp_enqueue_style( $handle );
		wp_style_add_data( $handle, 'rtl', 'replace' );

		wp_enqueue_script( $handle );
		wp_localize_script( $handle, 'tws_admin', $localize );

	}
}

Admin_Menu::get_instance();
