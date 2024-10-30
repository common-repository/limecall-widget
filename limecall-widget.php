<?php
/**
 * This file is read by WordPress to generate the plugin information in the plugin admin area. This file also includes all of the dependencies used by the plugin, registers the activation and deactivation functions, and defines a function that starts the plugin.
 *
 * @link              https://limecall.com
 * @since             1.0.0
 * @package           Limecall_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Limecall
 * Plugin URI:        https://limecall.com
 * Description:       LimeCall widget for Wordpress.
 * Version:           1.0
 * Author:            Limecall
 * Author URI:        https://limecall.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       LimeCall
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if(!defined('WPINC')){
    die;
}

/**
 * The code that runs during plugin activation.
 */

function activate_limecall_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-limecall-widget-activator.php';
	Limecall_Widget_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 */
function deactivate_limecall_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-limecall-widget-deactivator.php';
	Limecall_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_limecall_widget' );
register_deactivation_hook( __FILE__, 'deactivate_limecall_widget' );

/**
 * The core plugin class that is used to define internationalization, admin-specific hooks, and public facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-limecall-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off the plugin from this point in the file does not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_limecall_widget() {
	$plugin = new Limecall_Widget();
	$plugin->run();
}
run_limecall_widget();
