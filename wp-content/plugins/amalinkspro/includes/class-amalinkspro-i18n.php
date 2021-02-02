<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/includes
 * @author     Your Name <email@amalinkspro.com>
 */
class Ama_Links_Pro_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'amalinkspro',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
