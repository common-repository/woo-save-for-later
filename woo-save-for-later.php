<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.multidots.com/
 * @since             1.0.0
 * @package           Woo_Save_For_Later
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Save For Later Cart Enhancement
 * Plugin URI:        http://www.multidots.com/
 * Description:       Allows customers to save products and keeps them saved for later purchase. This tool can be handy if they are not sure to purchase any item which is in cart.
 * Version:           1.0.9
 * Author:            Multidots
 * Author URI:        http://www.multidots.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-save-for-later
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!defined('WSFL_PLUGIN_PATH')) {
    define('WSFL_PLUGIN_PATH', plugin_dir_url(__FILE__));
}
if (!defined('WSFL_PLUGIN_VERSION')) {
    define('WSFL_PLUGIN_VERSION', '1.0.9');
}
if (!defined('WSFL_PLUGIN_URL'))
    define('WSFL_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('WSFL_PLUGIN_DIR'))
    define('WSFL_PLUGIN_DIR', dirname(__FILE__));

if (!defined('WSFL_PLUGIN_DIR_PATH')) {
    define('WSFL_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('WCPFC_SLUG')) {
    define('WSFL_SLUG', 'woo-conditional-product-fees-for-checkout');
}
if (!defined('WSFL_PLUGIN_BASENAME')) {
    define('WSFL_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-save-for-later-activator.php
 */
function activate_woo_save_for_later() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-save-for-later-activator.php';
	Woo_Save_For_Later_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-save-for-later-deactivator.php
 */
function deactivate_woo_save_for_later() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-save-for-later-deactivator.php';
	Woo_Save_For_Later_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_save_for_later' );
register_deactivation_hook( __FILE__, 'deactivate_woo_save_for_later' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-save-for-later.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/woo-save-for-later-constant.php';

require plugin_dir_path(__FILE__) . 'includes/constant.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_save_for_later() {

	$plugin = new Woo_Save_For_Later();
	$plugin->run();

}

run_woo_save_for_later();