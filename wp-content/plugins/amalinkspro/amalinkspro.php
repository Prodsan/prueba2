<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://amalinkspro.com
 * @since             1.0.0
 * @package           Ama_Links_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       AmaLinks Pro
 * Plugin URI:        https://amalinkspro.com
 * Description:       Build Different Types of Amazing Amazon Associate Links Fast & Easy.
 * Version:           1.5.7
 * Author:            AmaLinks Pro
 * Author URI:        https://amalinkspro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       amalinkspro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
//define( 'Ama_Links_Pro_VERSION', '0.0.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-amalinkspro-activator.php
 */
function activate_Ama_Links_Pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amalinkspro-activator.php';
	Ama_Links_Pro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-amalinkspro-deactivator.php
 */
function deactivate_Ama_Links_Pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amalinkspro-deactivator.php';
	Ama_Links_Pro_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Ama_Links_Pro' );
register_deactivation_hook( __FILE__, 'deactivate_Ama_Links_Pro' );


// remove_filter( 'the_content', 'wpautop' );
// add_filter( 'the_content', 'wpautop' , 99);

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-amalinkspro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Ama_Links_Pro() {

	$plugin = new Ama_Links_Pro();
	$plugin->run();

}
run_Ama_Links_Pro();



