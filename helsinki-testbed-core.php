<?php
/**
	* Plugin Name: Helsinki Testbed Core
	* Description: Site specific features
	* Requires at least: 6.0
	* Requires PHP: 7.4
	* Version: 3.2.0
	* Author: ArtCloud
	* Author URI: https://www.artcloud.fi
	* License: MIT License
	* License URI: https://www.gnu.org/licenses/gpl-2.0.html
	* Text Domain: helsinki-testbed-core
	* Domain Path: /languages
	*/

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Setup
  */
require_once plugin_dir_path( __FILE__ ) . 'constants.php';
define_constants( __FILE__ );

require_once plugin_dir_path( __FILE__ ) . 'functions.php';
load_includes();

spl_autoload_register( __NAMESPACE__ . '\\class_loader' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\loaded' );

/**
  * Init
  */
add_action( 'init', __NAMESPACE__ . '\\init', 100 );
add_action( 'helsinki_testbed_core_init', __NAMESPACE__ . '\\textdomain' );

/**
  * Activation
  */
// register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate' );

/**
  * Deactivation
  */
// register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate' );

/**
  * Uninstall
  */
// register_uninstall_hook( __FILE__, __NAMESPACE__ . '\\uninstall' );
