<?php

/**
 * Fired during plugin activation
 *
 * @link       https://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/includes
 * @author     AmaLinks Pro <support@amalinkspro.com>
 */
class Amalinks_Pro_Tables_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	    $amalinkspro_tables_license = get_option( 'amalinkspro_tables_license' );
	    // Are our options saved in the DB?
	    if ( false === $amalinkspro_tables_license ) {
	        // If not, we'll save our default options
	        add_option( 'amalinkspro_tables_license', '' );
	        add_option( 'amalinkspro_tables_license_status', 'deactivated' );
	    }

	    set_transient( '_amalinkspro_tb_welcome_screen_activation_redirect', true, 30 );

	}

}
