<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://amalinkspro.com
 * @since             1.0.0
 * @package           Amalinks_Pro_Tables
 *
 * @wordpress-plugin
 * Plugin Name:       AmaLinks Pro - Table Builder
 * Plugin URI:        http://amalinkspro.com/
 * Description:       This plugin makes it extremely fast and easy to add product comparison tables to your website running AmaLinks Pro. AmaLinks Pro core plugin required..
 * Version:           1.3.4
 * Author:            AmaLinks Pro
 * Author URI:        https://amalinkspro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       amalinkspro-tables
 * Requires at least: 4.9
 * Tested up to: 5.2.2
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
//define( 'Amalinks_Pro_Tables_VERSION', '1.0.0' );


define( 'MY_PLUGIN_PATH', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-amalinkspro-tables-activator.php
 */
function activate_Amalinks_Pro_Tables() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amalinkspro-tables-activator.php';
	Amalinks_Pro_Tables_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-amalinkspro-tables-deactivator.php
 */
function deactivate_Amalinks_Pro_Tables() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amalinkspro-tables-deactivator.php';
	Amalinks_Pro_Tables_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Amalinks_Pro_Tables' );
register_deactivation_hook( __FILE__, 'deactivate_Amalinks_Pro_Tables' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-amalinkspro-tables.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Amalinks_Pro_Tables() {

	$plugin = new Amalinks_Pro_Tables();
	$plugin->run();

}
run_Amalinks_Pro_Tables();
