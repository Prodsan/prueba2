<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/includes
 * @author     AmaLinks Pro <support@amalinkspro.com>
 */
class Amalinks_Pro_Tables_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'amalinkspro-tables',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
