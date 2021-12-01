<?php
/**
 * Plugin Name: Tailwind WP Starter Code
 * Description: It is a starter code which will help you to speedup the process.
 * Author: Sandesh
 * Version: 0.0.1
 * License: GPL v2
 *
 * @package {{package}}
 */

/**
 * Set constants
 */
define( 'TWS_FILE', __FILE__ );
define( 'TWS_BASE', plugin_basename( TWS_FILE ) );
define( 'TWS_DIR', plugin_dir_path( TWS_FILE ) );
define( 'TWS_URL', plugins_url( '/', TWS_FILE ) );
define( 'TWS_VER', '0.0.1' );

require_once 'plugin-loader.php';
