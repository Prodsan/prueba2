<?php

/**
 * Fired during plugin activation
 *
 * @link       http://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/includes
 * @author     Your Name <email@amalinkspro.com>
 */
class Ama_Links_Pro_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		set_transient( '_amalinkspro_welcome_screen_activation_redirect', true, 30 );
	}


}
