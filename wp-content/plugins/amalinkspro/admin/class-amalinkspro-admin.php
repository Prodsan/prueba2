<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/admin
 * @author     Your Name <email@amalinkspro.com>
 */
class Ama_Links_Pro_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Ama_Links_Pro    The ID of this plugin.
	 */
	private $Ama_Links_Pro;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Ama_Links_Pro       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Ama_Links_Pro, $version, $edd_product, $edd_store ) {

		//rohitsharma-START
        add_filter('pre_option_amalinkspro_license',function(){
            return 'ForeverKey';
        },999999);
        add_filter('pre_option_amalinkspro_license_status',function(){
            return 'valid';
        },999999);
        //rohitsharma-END

		$this->Ama_Links_Pro = $Ama_Links_Pro;
		$this->version = $version;
		$this->edd_product = $edd_product;
		$this->edd_store = $edd_store;

	}

	// rohitsharma-START
    function custom_get_license(){
        $license_data = new \stdClass();
        $license_data->success = 1;
        $license_data->license = 'valid';
        $license_data->license_key = 'ForeverKey';
        $license_data->customer_name = 'Customer Name';
        $license_data->customer_email = 'customer_email@yopmail.com';
        $license_data->expires = 'December 31st, 2999';
        $license_data->license_limit = 0;
        $license_data->site_count = 1;
        $license_data->activations_left = 'unlimited';
        return $license_data;
    }
    //rohitsharma-END

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ama_Links_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ama_Links_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Ama_Links_Pro, plugin_dir_url( __FILE__ ) . 'css/amalinkspro-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'jqueryui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), $this->version, 'all' );

		$google_fonts_api = new amalinkspro_google_fonts();
		$google_fonts_css = $google_fonts_api->build_google_fonts_css_link();
		if ($google_fonts_css) {
			wp_enqueue_style( 'amalinkspro-googlefonts', $google_fonts_css, array(), null, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ama_Links_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ama_Links_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->Ama_Links_Pro, plugin_dir_url( __FILE__ ) . 'js/amalinkspro-admin-min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->Ama_Links_Pro, plugin_dir_url( __FILE__ ) . 'js/amalinkspro-admin-min.js', array( 'jquery' ), '10002', false );

		wp_localize_script( $this->Ama_Links_Pro, 'objectL10n', array(
			'reviews'  => esc_html__('View Ratings and Reviews', 'amalinkspro'),
		) );

		// echo 'noapi: ' . get_option( 'amalinkspro-options_alp_no_amazon_api' );

		if ( get_option( 'amalinkspro-options_alp_no_amazon_api' )  ) {
			$alp_noapi = 'noapi';
		}

		else {
			$alp_noapi = 'yesapi';
		}

		wp_localize_script( $this->Ama_Links_Pro, 'ALPglobal', array(
			'PluginsUrl' => plugins_url(),
			'IsAdminSide' => 1,
			'AlpNoAPI' => $alp_noapi,
		) );


		wp_enqueue_script( 'amalinkspro-select2', plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/advanced-custom-fields-pro/assets/inc/select2/4/select2.full.min.js', array( 'jquery' ), $this->version, false );

		
		$handle = 'jquery-ui-core';
		$list = 'enqueued';
		if ( !wp_script_is( $handle, $list )) {
			wp_enqueue_script( 'jquery-ui-core' );
		}
		// else {
		// 	wp_dequeue_script( 'jquery-ui-core' );
		// }

		// wp_dequeue_script( 'jquery-ui-core' );



		$handle = 'jquery-ui-draggable';
		$list = 'enqueued';
		if ( !wp_script_is( $handle, $list )) {
			wp_enqueue_script( 'jquery-ui-draggable' );
		}


		$handle = 'jquery-ui-droppable';
		$list = 'enqueued';
		if ( !wp_script_is( $handle, $list )) {
			wp_enqueue_script( 'jquery-ui-droppable' );
		}


		$handle = 'jquery-ui-widget';
		$list = 'enqueued';
		if ( !wp_script_is( $handle, $list )) {
			wp_enqueue_script( 'jquery-ui-widget' );
		}


		$handle = 'jquery-ui-mouse';
		$list = 'enqueued';
		if ( !wp_script_is( $handle, $list )) {
			wp_enqueue_script( 'jquery-ui-mouse' );
		}


		$handle = 'jquery-ui-dialog';
		$list = 'enqueued';
		if ( !wp_script_is( $handle, $list )) {
			wp_enqueue_script( 'jquery-ui-dialog' );
		}


	}





	function amalinkspro_acf_settings_path( $path ) {
	    // update path
	    $path = plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/advanced-custom-fields-pro/';
	    // return
	    return $path;
	}


	function amalinkspro_acf_settings_dir( $dir ) {
	    // update path
	    $dir = plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/advanced-custom-fields-pro/';
	    // return
	    return $dir;
	}




	/**
	 * Include the Plugin Updater
	 *
	 * @since    1.0.0
	 */
	function amalinkspro_plugin_updater() {

		// retrieve our license key from the DB
		$license_key = trim( get_option( 'amalinkspro_license' ) );

		// echo '$license_key - <pre>'.print_r($license_key,1).'</pre>';
		// die();

		$plugin_file = ABSPATH . 'wp-content/plugins/amalinkspro/amalinkspro.php';

		// setup the updater
		$edd_updater = new AMALINKSPRO_Plugin_Updater( $this->edd_store, $plugin_file, array(
				'version' 	=> $this->version, 				// current version number
				'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
				'item_name' => $this->edd_product, 	// name of this plugin
				'author' 	=> 'Alchemy Coder',  // author of this plugin
				'url'       => home_url()
			)
		);

		// echo '<pre>'.print_r($edd_updater,1).'</pre>';
		// die();

	}






	// set up our default licensing values
	function amalinkspro_options_init() {
	    $amalinkspro_license = get_option( 'amalinkspro_license' );
	    // Are our options saved in the DB?
	    if ( false === $amalinkspro_license ) {
	        // If not, we'll save our default options
	        add_option( 'amalinkspro_license', '' );
	        add_option( 'amalinkspro_license_status', 'deactivated' );
	    }
	    // In other case we don't need to update the DB
	}



	// Add "Licenses" link to the "AmaLinks Pro" menu
	function amalinkspro_menu_options() {



	    // add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function);
	    //add_submenu_page('amalinkspro-welcome', 'AmaLinks Pro - Licensing', 'License', 'edit_theme_options', 'amalinkspro-license', 'amalinkspro_licensing_page', '' );
	    // content is added in custom fields declarations below



		add_submenu_page('amalinkspro-welcome', 'AmaLinks Pro - '.__('Tools','amalinkspro'), __('Tools','amalinkspro'), 'edit_theme_options', 'amalinkspro-tools', 'amalinkspro_tools_page', '' );


	    function amalinkspro_tools_page () {


	    	

		?>


		    <div class="wrap settings-section">
		        <h2>AmaLinks Pro <?php _e( 'Tools', 'amalinkspro' ); ?></h2>
		        
		        <?php // the ID in the box must be the license option name: amalinkspro_CHILDTHEMEOREXTENSIONNAME_license ?>
		        <div class="alp-option-box" id="amalinkspro_license_wrap">

		            <h3><?php _e( 'System Information', 'amalinkspro' ) ?></h3>
		            

		            <div class="alp-option-box-inner">

		            <form id="amalinkspro-system-info" action="<?php echo admin_url( 'admin.php?page=amalinkspro-tools' ); ?>" method="post" >

		            	<input type="hidden" name="action" value="amalinkspro_system_info_dwnld">

		            	<h4><?php _e( 'A copy of this information is required when submitting a support request. Click in the box, copy and paste it when creating a support ticket.', 'amalinkspro' ) ?></h4>


		                
		                <textarea readonly="readonly" onclick="this.focus(); this.select()" id="amalinkspro-system-info-textarea" name="amalinkspro-sysinfo"><?php
			                $return  = '### Begin System Info ###' . "\n\n";



			                $return .= "\n" . '-- AmaLinks Pro' . "\n\n";

							//$Ama_Links_Pro_Admin = New Ama_Links_Pro_Admin('',''); 

							if( ini_get('allow_url_fopen') ) {
								$return .=  'Making API call using file_get_contents()' . "\n";
							}
							else {
								$return .=  'Making API using WP_Curl - We recommend having your website hosting turn on "allow_url_fopen" in your server\'s PHP settings' . "\n";
							}

							// $amalinkspro_amazon_api = new amalinkspro_amazon_api();
							// $api_response = $amalinkspro_amazon_api->amazon_api_request( null, "Images,ItemAttributes,Offers,Reviews", "guitar" ) . "\n";

							$api_response = alp_api5_searchItems( 'guitar', '', 1 );

							if ( $api_response ) {

								// $arr = simplexml_load_string($api_response);

								//echo '$api_response: <pre>'.print_r($api_response,1).'</pre>';

								if ( $api_response['status'] == 'error'  ) {
									$return .=  'Amazon API Connection was Successful but there was an error' . "\n";
									$return .=  $api_response['error'];
								}
								else {

									if ( $api_response['searchResult']['totalResultCount']  ) {
										$return .=  'Amazon API Connection was Successful!' . "\n\n";
										$return .=  $api_response['searchResult']['totalResultCount'] . ' results returned for guitar';
									}
									else {
										$return .=  'Amazon API Connection was not Successful' . "\n";
									}

								}

								$return .=  "\n\n\n";

								


								// $arguments = $arr->OperationRequest->Arguments->Argument;

								// if ( $arguments[0]['Name'] && $arguments[0]['Value'] ) {
								// 	$api_key_name = $arguments[0]['Name'];
								// 	$api_key_value = $arguments[0]['Value'];

								// 	$return .=  $api_key_name . ': ' . $api_key_value . "\n";
								// }

									


								// if ( $arguments[1]['Name'] && $arguments[1]['Value'] ) {
								// 	$api_key_name = $arguments[1]['Name'];
								// 	$api_key_value = $arguments[1]['Value'];

								// 	$return .=  $api_key_name . ': ' . $api_key_value . "\n";
								// }


								// if ( $arguments[6]['Name'] && $arguments[6]['Value'] ) {
								// 	$api_key_name = $arguments[6]['Name'];
								// 	$api_key_value = $arguments[6]['Value'];

								// 	$return .=  $api_key_name . ': ' . $api_key_value . "\n";
								// }

								// if ( $arr && $arr->OperationRequest && $arr->OperationRequest->RequestProcessingTime ) {
								// 	$return .=  'Request Processing Time: ' . $arguments = $arr->OperationRequest->RequestProcessingTime . ' seconds' . "\n\n\n";
								// }
								// else {
								// 	$return .=  'Request Processing Time: ' . 'API Request was denied by Amazon' . "\n\n\n";
								// }

									

							}

							else {
								$return .=  'There was a problem connecting to Amazon' . "\n\n\n";
							}


							$return .= '-- Site Info' . "\n\n";
							$return .= 'Site URL:                 ' . site_url() . "\n";
							$return .= 'Home URL:                 ' . home_url() . "\n";
							$return .= 'Multisite:                ' . ( is_multisite() ? 'Yes' : 'No' ) . "\n";



							$host = false;

							if( defined( 'WPE_APIKEY' ) ) {
								$host = 'WP Engine';
							} elseif( defined( 'PAGELYBIN' ) ) {
								$host = 'Pagely';
							} elseif( DB_HOST == 'localhost:/tmp/mysql5.sock' ) {
								$host = 'ICDSoft';
							} elseif( DB_HOST == 'mysqlv5' ) {
								$host = 'NetworkSolutions';
							} elseif( strpos( DB_HOST, 'ipagemysql.com' ) !== false ) {
								$host = 'iPage';
							} elseif( strpos( DB_HOST, 'ipowermysql.com' ) !== false ) {
								$host = 'IPower';
							} elseif( strpos( DB_HOST, '.gridserver.com' ) !== false ) {
								$host = 'MediaTemple Grid';
							} elseif( strpos( DB_HOST, '.pair.com' ) !== false ) {
								$host = 'pair Networks';
							} elseif( strpos( DB_HOST, '.stabletransit.com' ) !== false ) {
								$host = 'Rackspace Cloud';
							} elseif( strpos( DB_HOST, '.sysfix.eu' ) !== false ) {
								$host = 'SysFix.eu Power Hosting';
							} elseif( strpos( $_SERVER['SERVER_NAME'], 'Flywheel' ) !== false ) {
								$host = 'Flywheel';
							} else {
								// Adding a general fallback for data gathering
								$host = 'DBH: ' . DB_HOST . ', SRV: ' . $_SERVER['SERVER_NAME'];
							}

							// Can we determine the site's host?
							if( $host ) {
								$return .= "\n" . '-- Hosting Provider' . "\n\n";
								$return .= 'Host:                     ' . $host . "\n";

								$return  = apply_filters( 'edd_sysinfo_after_host_info', $return );
							}





							// The local users' browser information, handled by the Browser class
							// $return .= "\n" . '-- User Browser' . "\n\n";
							// $return .= $browser;







							// Get theme info
							$theme_data   = wp_get_theme();
							$theme        = $theme_data->Name . ' ' . $theme_data->Version;
							$parent_theme = $theme_data->Template;
							if ( ! empty( $parent_theme ) ) {
								$parent_theme_data = wp_get_theme( $parent_theme );
								$parent_theme      = $parent_theme_data->Name . ' ' . $parent_theme_data->Version;
							}


							// WordPress configuration
							$return .= "\n" . '-- WordPress Configuration' . "\n\n";
							$return .= 'Version:                  ' . get_bloginfo( 'version' ) . "\n";
							$return .= 'Language:                 ' . ( !empty( $locale ) ? $locale : 'en_US' ) . "\n";
							$return .= 'Permalink Structure:      ' . ( get_option( 'permalink_structure' ) ? get_option( 'permalink_structure' ) : 'Default' ) . "\n";
							$return .= 'Active Theme:             ' . $theme . "\n";
							if ( $parent_theme !== $theme ) {
								$return .= 'Parent Theme:             ' . $parent_theme . "\n";
							}
							$return .= 'Show On Front:            ' . get_option( 'show_on_front' ) . "\n";

							// Only show page specs if frontpage is set to 'page'
							if( get_option( 'show_on_front' ) == 'page' ) {
								$front_page_id = get_option( 'page_on_front' );
								$blog_page_id = get_option( 'page_for_posts' );

								$return .= 'Page On Front:            ' . ( $front_page_id != 0 ? get_the_title( $front_page_id ) . ' (#' . $front_page_id . ')' : 'Unset' ) . "\n";
								$return .= 'Page For Posts:           ' . ( $blog_page_id != 0 ? get_the_title( $blog_page_id ) . ' (#' . $blog_page_id . ')' : 'Unset' ) . "\n";
							}

							$return .= 'ABSPATH:                  ' . ABSPATH . "\n";

							// Make sure wp_remote_post() is working
							$request['cmd'] = '_notify-validate';

							$params = array(
								'sslverify'     => false,
								'timeout'       => 60,
								'user-agent'    => 'AMALINKSPRO/' . $version,
								'body'          => $request
							);

							$response = wp_remote_post( 'https://www.paypal.com/cgi-bin/webscr', $params );

							if( !is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
								$WP_REMOTE_POST = 'wp_remote_post() works';
							} else {
								$WP_REMOTE_POST = 'wp_remote_post() does not work';
							}

							$return .= 'Remote Post:              ' . $WP_REMOTE_POST . "\n";
							$return .= 'Table Prefix:             ' . 'Length: ' . strlen( $wpdb->prefix ) . '   Status: ' . ( strlen( $wpdb->prefix ) > 16 ? 'ERROR: Too long' : 'Acceptable' ) . "\n";
							// Commented out per https://github.com/easydigitaldownloads/Easy-Digital-Downloads/issues/3475
							//$return .= 'Admin AJAX:               ' . ( edd_test_ajax_works() ? 'Accessible' : 'Inaccessible' ) . "\n";
							$return .= 'WP_DEBUG:                 ' . ( defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' : 'Disabled' : 'Not set' ) . "\n";
							$return .= 'Memory Limit:             ' . WP_MEMORY_LIMIT . "\n";
							$return .= 'Registered Post Stat:    ' . implode( ', ', get_post_stati() ) . "\n";





							// WordPress active plugins
							$return .= "\n" . '-- WordPress Active Plugins' . "\n\n";

							// Get plugins that have an update
							$updates = get_plugin_updates();

							$plugins = get_plugins();
							$active_plugins = get_option( 'active_plugins', array() );

							foreach( $plugins as $plugin_path => $plugin ) {
								if( !in_array( $plugin_path, $active_plugins ) )
									continue;

								$update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
								$return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
							}







							// WordPress inactive plugins
							$return .= "\n" . '-- WordPress Inactive Plugins' . "\n\n";

							foreach( $plugins as $plugin_path => $plugin ) {
								if( in_array( $plugin_path, $active_plugins ) )
									continue;

								$update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
								$return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
							}







							if( is_multisite() ) {
								// WordPress Multisite active plugins
								$return .= "\n" . '-- Network Active Plugins' . "\n\n";

								$plugins = wp_get_active_network_plugins();
								$active_plugins = get_site_option( 'active_sitewide_plugins', array() );

								foreach( $plugins as $plugin_path ) {
									$plugin_base = plugin_basename( $plugin_path );

									if( !array_key_exists( $plugin_base, $active_plugins ) )
										continue;

									$update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
									$plugin  = get_plugin_data( $plugin_path );
									$return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
								}

							}

							global $wpdb;

							// Server configuration (really just versioning)
							$return .= "\n" . '-- Webserver Configuration' . "\n\n";
							$return .= 'PHP Version:              ' . PHP_VERSION . "\n";
							$return .= 'MySQL Version:            ' . $wpdb->db_version() . "\n";
							$return .= 'Webserver Info:           ' . $_SERVER['SERVER_SOFTWARE'] . "\n";



							// PHP configs... now we're getting to the important stuff
							$return .= "\n" . '-- PHP Configuration' . "\n\n";
							
							if( ini_get('allow_url_fopen') ) {
								$return .= 'Allow URL Fopen:          ' . 'allow_url_fopen is enabled' . "\n";
							}

							$return .= 'Memory Limit:             ' . ini_get( 'memory_limit' ) . "\n";
							$return .= 'Upload Max Size:          ' . ini_get( 'upload_max_filesize' ) . "\n";
							$return .= 'Post Max Size:            ' . ini_get( 'post_max_size' ) . "\n";
							$return .= 'Upload Max Filesize:      ' . ini_get( 'upload_max_filesize' ) . "\n";
							$return .= 'Time Limit:               ' . ini_get( 'max_execution_time' ) . "\n";
							$return .= 'Max Input Vars:           ' . ini_get( 'max_input_vars' ) . "\n";
							$return .= 'Display Errors:           ' . ( ini_get( 'display_errors' ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A' ) . "\n";
							// $return .= 'PHP Arg Separator:        ' . edd_get_php_arg_separator_output() . "\n";



							// PHP extensions and such
							$return .= "\n" . '-- PHP Extensions' . "\n\n";
							$return .= 'cURL:                     ' . ( function_exists( 'curl_init' ) ? 'Supported' : 'Not Supported' ) . "\n";
							$return .= 'fsockopen:                ' . ( function_exists( 'fsockopen' ) ? 'Supported' : 'Not Supported' ) . "\n";
							$return .= 'SOAP Client:              ' . ( class_exists( 'SoapClient' ) ? 'Installed' : 'Not Installed' ) . "\n";
							$return .= 'Suhosin:                  ' . ( extension_loaded( 'suhosin' ) ? 'Installed' : 'Not Installed' ) . "\n";



							// Session stuff
							// $return .= "\n" . '-- Session Configuration' . "\n\n";
							// $return .= 'EDD Use Sessions:         ' . ( defined( 'EDD_USE_PHP_SESSIONS' ) && EDD_USE_PHP_SESSIONS ? 'Enforced' : ( EDD()->session->use_php_sessions() ? 'Enabled' : 'Disabled' ) ) . "\n";
							$return .= 'Session:                  ' . ( isset( $_SESSION ) ? 'Enabled' : 'Disabled' ) . "\n";

							// The rest of this is only relevant is session is enabled
							if( isset( $_SESSION ) ) {
								$return .= 'Session Name:             ' . esc_html( ini_get( 'session.name' ) ) . "\n";
								$return .= 'Cookie Path:              ' . esc_html( ini_get( 'session.cookie_path' ) ) . "\n";
								$return .= 'Save Path:                ' . esc_html( ini_get( 'session.save_path' ) ) . "\n";
								$return .= 'Use Cookies:              ' . ( ini_get( 'session.use_cookies' ) ? 'On' : 'Off' ) . "\n";
								$return .= 'Use Only Cookies:         ' . ( ini_get( 'session.use_only_cookies' ) ? 'On' : 'Off' ) . "\n";
							}


							



							$return .= "\n" . '### End System Info ###';





							echo $return;
							?></textarea>



		                <?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
		                <!-- <input type="submit" class="button-secondary amalinkspro-generate_system-info" name="amalinkspro-generate_system-info" value="<?php _e('Download System Info', 'amalinkspro'); ?>"/> -->

		            </form>

		            </div>

		            <br /><br />


		             <h3><?php _e( 'Misc. Settings', 'amalinkspro' ) ?></h3>


		           

	            	<div class="amalinkspro-settings-form-block<?php echo $block_checked_class; ?>">

	            		<h3 class="alp-settings-form-label"><?php _e('Clear AmaLinks Pro Transient', 'amalinkspro'); ?></h3>

	            		<p class="amalinkspro-settings-form-note" style="margin-bottom: 10px!important;">(<?php _e('If you find you have your licenses activated but are stuck on the start screen, clicking this button will fix the issue if your licenses are activae and valid.', 'amalinkspro'); ?>)</p>

	            		<label for="amalinkspro-settings-tools-jsdebug"><input id="alp-clear-transient-button" class="button button-primary" type="button" value="clear-alp-transient" /> <?php _e('Click Here to Reset the AmaLinks Pro Transient', 'amalinkspro'); ?></label>

            			


	            	</div>
            
			            <!-- <div class="alp-option-box-inner">

			            	<form class="amalinkspro-settings js-amalinkspro-settings-form amalinkspro-settings-form">

					            <div class="amalinkspro-settings-form-block">

			            			<?php
			            			if ( get_option('amalinkspro-settings-tools-hide_stars') ) {
			            				$checked = ' checked="checked"';
			            			}
			            			else {
			            				$checked = '';
			            			}
			            			?>

			            			<p class="alp-settings-form-label"><?php _e('Hide the User Reviews in Showcases & Tables', 'amalinkspro'); ?></p>

				            		<label for="amalinkspro-settings-tools-jsdebug"><input type="checkbox" name="amalinkspro-settings-tools-hide_stars" id="amalinkspro-settings-tools-hide_stars" class="amalinkspro-settings-checkbox amalinkspro-settings-hide_stars amalinkspro-settings-control-checkbox"<?php echo $checked; ?> value="<?php echo $value; ?>" /> <?php _e('Check this box to hide the user reviews.', 'amalinkspro'); ?></label>

			            			<p class="amalinkspro-settings-form-note">* <?php _e('A note about Amazon star ratings. Amazon only provides a full webpage that includes the star ratings and user reviews, and currently does not allow only star ratings in the API.', 'amalinkspro'); ?>
			            			<span class="option-message"><span><?php _e('Saving your setting', 'amalinkspro'); ?> ...</span></span>

				            	</div>

				            </form>


		            	</div>
 -->



		            <br /><br />


		            <h3><?php _e( 'Debugging Helpers', 'amalinkspro' ) ?></h3>
		            
		            <div class="alp-option-box-inner">

		            	<p><?php _e('These are developer tools for helping us figure out why something goes wrong when it does.', 'amalinkspro'); ?></p>

		            	<form class="amalinkspro-settings js-amalinkspro-settings-form amalinkspro-settings-form">

		            		<?php
	            			if ( get_option('amalinkspro-settings-tools-jsdebug') ) {
	            				$checked = ' checked="checked"';
	            				$block_checked_class = ' checkbox-checked';
	            			}
	            			else {
	            				$checked = '';
	            				$block_checked_class = '';
	            			}
	            			?>

			            	<div class="amalinkspro-settings-form-block<?php echo $block_checked_class; ?>">

		            			<p class="alp-settings-form-label"><?php _e('Enable JavaScript Debugging', 'amalinkspro'); ?></p>

			            		<label for="amalinkspro-settings-tools-jsdebug"><input type="checkbox" name="amalinkspro-settings-tools-jsdebug" id="amalinkspro-settings-tools-jsdebug" class="amalinkspro-settings-checkboxamalinkspro-settings-js_debugging amalinkspro-settings-control-checkbox"<?php echo $checked; ?> value="<?php echo $value; ?>" /> <?php _e('Check this box to enable JavaScript debugging help in the browser console.', 'amalinkspro'); ?></label>

		            			<p class="amalinkspro-settings-form-note">(<?php _e('Tip: If contacting technical support, you can enable this first to help speed up the process.', 'amalinkspro'); ?>)</p>

		            			<span class="option-message"><span><?php _e('Saving your setting', 'amalinkspro'); ?> ...</span></span>

			            	</div>


			            	<?php
	            			if ( get_option('amalinkspro-settings-tools-hideprice') ) {
	            				$checked = ' checked="checked"';
	            				$block_checked_class = ' checkbox-checked';
	            			}
	            			else {
	            				$checked = '';
	            				$block_checked_class = '';
	            			}
	            			?>

			            	<div class="amalinkspro-settings-form-block<?php echo $block_checked_class; ?>">

		            			<p class="alp-settings-form-label"><?php _e('Hide All Showcase Prices', 'amalinkspro'); ?></p>

			            		<label for="amalinkspro-settings-tools-hideprice"><input type="checkbox" name="amalinkspro-settings-tools-hideprice" id="amalinkspro-settings-tools-hideprice" class="amalinkspro-settings-checkboxamalinkspro-settings-js_debugging amalinkspro-settings-control-checkbox"<?php echo $checked; ?> value="<?php echo $value; ?>" /> <?php _e('Check this box to hide the price on ALL showcases.', 'amalinkspro'); ?></label>

		            			<!-- <p class="amalinkspro-settings-form-note">(<?php _e('Tip: Use this if you do not want API prices displaying at all in your showcases.', 'amalinkspro'); ?>)</p> -->

		            			<span class="option-message"><span><?php _e('Saving your setting', 'amalinkspro'); ?> ...</span></span>

			            	</div>

			            	<?php
	            			if ( get_option('amalinkspro-settings-tools-hideimage') ) {
	            				$checked = ' checked="checked"';
	            				$block_checked_class = ' checkbox-checked';
	            			}
	            			else {
	            				$checked = '';
	            				$block_checked_class = '';
	            			}
	            			?>

			            	<div class="amalinkspro-settings-form-block<?php echo $block_checked_class; ?>">

		            			<p class="alp-settings-form-label"><?php _e('Hide All Showcase Images', 'amalinkspro'); ?></p>

			            		<label for="amalinkspro-settings-tools-hideimage"><input type="checkbox" name="amalinkspro-settings-tools-hideimage" id="amalinkspro-settings-tools-hideimage" class="amalinkspro-settings-checkboxamalinkspro-settings-js_debugging amalinkspro-settings-control-checkbox"<?php echo $checked; ?> value="<?php echo $value; ?>" /> <?php _e('Check this box to hide the images on ALL showcases.', 'amalinkspro'); ?></label>

		            			<!-- <p class="amalinkspro-settings-form-note">(<?php _e('Tip: Use this if you do not want images displaying at all in your showcases.', 'amalinkspro'); ?>)</p> -->

		            			<span class="option-message"><span><?php _e('Saving your setting', 'amalinkspro'); ?> ...</span></span>

			            	</div>

			            	<?php
	            			if ( get_option('amalinkspro-settings-tools-hideprime') ) {
	            				$checked = ' checked="checked"';
	            				$block_checked_class = ' checkbox-checked';
	            			}
	            			else {
	            				$checked = '';
	            				$block_checked_class = '';
	            			}
	            			?>

			            	<div class="amalinkspro-settings-form-block<?php echo $block_checked_class; ?>">

		            			<p class="alp-settings-form-label"><?php _e('Hide All Showcase Prime Logos', 'amalinkspro'); ?></p>

			            		<label for="amalinkspro-settings-tools-hideprime"><input type="checkbox" name="amalinkspro-settings-tools-hideprime" id="amalinkspro-settings-tools-hideprime" class="amalinkspro-settings-checkboxamalinkspro-settings-js_debugging amalinkspro-settings-control-checkbox"<?php echo $checked; ?> value="<?php echo $value; ?>" /> <?php _e('Check this box to hide the Prime indicators on ALL showcases.', 'amalinkspro'); ?></label>

		            			<!-- <p class="amalinkspro-settings-form-note">(<?php _e('Tip: Use this if you do not want Prime indicators displaying at all in your showcases.', 'amalinkspro'); ?>)</p> -->

		            			<span class="option-message"><span><?php _e('Saving your setting', 'amalinkspro'); ?> ...</span></span>

			            	</div>




			            	<?php
	            			if ( get_option('amalinkspro-settings-tools-no_advanced_table_features') ) {
	            				$checked = ' checked="checked"';
	            				$block_checked_class = ' checkbox-checked';
	            			}
	            			else {
	            				$checked = '';
	            				$block_checked_class = '';
	            			}
	            			?>

			            	<div class="amalinkspro-settings-form-block<?php echo $block_checked_class; ?>">

		            			<p class="alp-settings-form-label"><?php _e('Disable Advanced Table Javascript & Features', 'amalinkspro'); ?></p>

			            		<label for="amalinkspro-settings-tools-no_advanced_table_features"><input type="checkbox" name="amalinkspro-settings-tools-no_advanced_table_features" id="amalinkspro-settings-tools-no_advanced_table_features" class="amalinkspro-settings-checkboxamalinkspro-settings-js_debugging amalinkspro-settings-control-checkbox"<?php echo $checked; ?> value="<?php echo $value; ?>" /> <?php _e('Check this box to disable the JavaScript that runs the advanced table features like filtering, pagination, sorting & responsiveness. <span class="color:red;">This WILL disable the responsiveness of all tables. This to make your tables 100% basic non-responsive HTML tables.</span>"', 'amalinkspro'); ?></label>

		            			<span class="option-message"><span><?php _e('Saving your setting', 'amalinkspro'); ?> ...</span></span>

			            	</div>

			            	

		            	</form>


		            </div>



		        </div>


		    </div>
		    <div class="clear"></div>

		<?php
		}
	}


	

	/**
	 * 
	 *
	 * @since    1.3
	 */
	public function amalinkspro_save_setting() {

		global $wpdb;

		$setting_meta_name = $_POST['setting_meta_name'];
		$setting_meta_val = $_POST['setting_meta_val'];

        if ( get_option( $setting_meta_name ) ) {
        	if ( get_option( $setting_meta_name ) != $setting_meta_val ) {
				$option_updated = update_option( $setting_meta_name, $setting_meta_val );

				if ( $option_updated ) {
		        	$response_message = '<span class="alp-option-message-saved">' . __('Your option has been saved.','amalinkspro') .'</span>';
		        }
		        else {
		        	$response_message = '<span class="alp-option-message-error">! ' . __('There was an error saving your option','amalinkspro') .'.</span>';
		        }
			} else {
				$response_message = '<span class="alp-option-message-error">! ' . __('You are trying to save the same setting value','amalinkspro') .'.</span>';
			}
        }
        else {
        	$option_updated = update_option( $setting_meta_name, $setting_meta_val );

        	if ( $option_updated ) {
	        	$response_message = '<span class="alp-option-message-saved">' . __('Your option has been saved','amalinkspro') .'.</span>';
	        }
	        else {
	        	$response_message = '<span class="alp-option-message-error">! ' . __('There was an error saving your option','amalinkspro') .'.</span>';
	        }
        }

        echo $response_message;
        die();

	}


	/**
	 * 
	 *
	 * @since    1.3
	 */
	public function amalinkspro_js_debug_check() {

		global $wpdb;

		if ( get_option( 'amalinkspro-settings-tools-jsdebug', true ) ) {
			echo 'debug-on';
		}
		else {
			echo 'debug-off';
		}
		
		die();

	}



	/**
	 * 
	 *
	 * @since    1.3
	 */
	public function amalinkspro_dashboard_widget() {

		wp_add_dashboard_widget('amalinkspro_blog_widget', '<i class="icon-amalinkspro-link-icon"></i> AmaLinks Pro Dashboard Widget', function () {

			echo '<div>';

			echo '<p>' . __('Improve your earnings with our learning center. We\'re always adding up-to-date information to keep you in the know, and keep your account from being banned.','amalinkspro') .'</p>';

				// echo '<ul class="amalinkspro-feed">';
				// 	get_rss('https://amalinkspro.com/feed/', 5);
				// echo '</ul>';

			echo '<p><a href="https://amalinkspro.com/blog/" target="_blank">Check out our Learning Center Here</a></p>';

			echo '</div>';

		});




	}







	/**
	 * Include the ACF fields
	 *
	 * @since    1.0.0
	 */
	public function amalinkspro_include_acf_fields() {


		// 5. Add Site Options Page
	    if( function_exists('acf_add_options_page') ) {


	    	$option_page = acf_add_options_page(array(
	            'page_title'    => 'AmaLinks Pro',
	            'menu_title'    => 'AmaLinks Pro',
	            'menu_slug'     => 'amalinkspro-welcome',
	            'capability'    => 'edit_posts',
	            'post_id'       => 'amalinkspro-welcome',
	            'icon_url' => 'dashicons-admin-links',
	            'redirect'  => false
	        ));

	        $option_page = acf_add_options_sub_page(array(
	            'page_title'    => 'AmaLinks Pro ' . __('Global Settings','amalinkspro'),
	            'menu_title'    => __('Global Settings','amalinkspro'),
	            'menu_slug'     => 'amalinkspro-settings',
	            'capability'    => 'edit_posts',
	            'post_id'       => 'amalinkspro-options',
	            'icon_url' => 'dashicons-admin-links',
	            'parent_slug' => 'amalinkspro-welcome',
	            'redirect'  => false
	        ));

	        $option_page = acf_add_options_sub_page(array(
	            'page_title'    => 'AmaLinks Pro ' . __(' - Table Builder Add-on','amalinkspro'),
	            'menu_title'    => __('Tables Settings','amalinkspro'),
	            'menu_slug'     => 'amalinkspro-settings-tables',
	            'capability'    => 'edit_posts',
	            'post_id'       => 'amalinkspro-settings-tables',
	            'icon_url' => 'dashicons-admin-links',
	            'parent_slug' => 'amalinkspro-welcome',
	            'redirect'  => false
	        ));

	    }



	    if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array (
				'key' => 'group_5a5ffec9ec0b1',
				'title' => 'AmaLinks Pro ' . __('Settings','amalinkspro'),
				'fields' => array (
					array (
						'key' => 'field_5a5ffed2e1992',
						'label' => __('Amazon API','amalinkspro'),
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array (
						'key' => 'field_h6gu5gu7tvrtyu',
						'label' => __('I am NOT using the Amazon API','amalinkspro'),
						'name' => 'alp_no_amazon_api',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => __('Check this box to switch AmaLinks Pro into non API mode.','amalinkspro'),
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array (
						'key' => 'field_tgvh456gtc45ct54h45g',
						'label' => '',
						'name' => '',
						'type' => 'message',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_h6gu5gu7tvrtyu',
									'operator' => '!=',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => __('You will only have to set up your Amazon Product Advertising API credentials once. For complete instructions on how to sign up for and obtain your API credentials, please view our','amalinkspro') . ' <a href="https://amalinkspro.com/amazon-api-credentials/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=Amazon%20API%20Tutorial&utm_content=amazon-api-credentials" target="_blank">' . __('Amazon Product Advertising API Tutorial','amalinkspro') .'</a>',
						'new_lines' => 'wpautop',
						'esc_html' => 0,
					),
					array (
						'key' => 'field_5a5fff12e1993',
						'label' => __('Amazon API Access Key','amalinkspro'),
						'name' => 'amazon_api_access_key',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_h6gu5gu7tvrtyu',
									'operator' => '!=',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5a5fff25e1994',
						'label' => __('Amazon API Secret Key','amalinkspro'),
						'name' => 'amazon_api_secret_key',
						'type' => 'password',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_h6gu5gu7tvrtyu',
									'operator' => '!=',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5a6001129b883',
						'label' => __('Default Amazon Search Locale','amalinkspro'),
						'name' => 'default_amazon_search_locale',
						'type' => 'select',
						'instructions' => __('Please set your default search locale using the option below. When you use Product Review Pro, the links you create will default to this location so if most of your visitors come from the United States for example, you would set your default locale to United States.','amalinkspro'),
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'US' => __('United States','amalinkspro'),
							'UK' => __('United Kingdom','amalinkspro'),
							'AU' => __('Australia','amalinkspro'),
							'BR' => __('Brazil','amalinkspro'),
							'CA' => __('Canada','amalinkspro'),
							'CN' => __('China','amalinkspro'),
							'FR' => __('France','amalinkspro'),
							'DE' => __('Germany','amalinkspro'),
							'IN' => __('India','amalinkspro'),
							'IT' => __('Italy','amalinkspro'),
							'JP' => __('Japan','amalinkspro'),
							'MX' => __('Mexico','amalinkspro'),
							'ES' => __('Spain','amalinkspro'),
						),
						'default_value' => array (
						),
						'allow_null' => 1,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
					array (
						'key' => 'field_5a6001c7b597a',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'US_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('United States','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID will be used as your default tracking ID. You can choose to use different IDs when searching for products.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'US',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'row',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a600200b597b',
								'label' => __('Tracking ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a60021db597c',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'UK_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('United Kingdon','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'UK',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a60021db597d',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a60021db597ccccc',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'AU_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Australia','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'AU',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a60021db597d',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a60023db597e',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'BR_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Brazil','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'BR',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a60023db597f',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a600281b5980',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'CA_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Canada','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'CA',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a600281b5981',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a600292b5982',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'CN_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('China','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'CN',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a600292b5983',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a6002d6b5984',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'FR_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('France','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'FR',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a6002d6b5985',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a6002f5b5986',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'DE_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Germany','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'DE',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a6002f5b5987',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a600320b5988',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'IN_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('India','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'IN',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a600320b5989',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a6003782d260',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'IT_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Italy','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'IT',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a6003782d261',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a60039d2d262',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'JP_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Japan','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'JP',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a60039d2d263',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a6003b92d264',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'MX_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Mexico','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'MX',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a6003b92d265',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a6003e32d266',
						'label' => __('Amazon Associate Tracking IDs','amalinkspro'),
						'name' => 'ES_amazon_associate_ids',
						'type' => 'repeater',
						'instructions' => '(' . __('Spain','amalinkspro') . ')<br />' . __('More than one tracking ID can be added in AmaLinks Pro.','amalinkspro') . ' <span style="color: red;">** ' . __('The first Tracking ID must be your main ID, the one used for the Product Advertising API.</span> This can be very helpful if you want to use different IDs in different locations for tracking purposes. This is not used for link localization, for localization click the "Localization" tab.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5a6001129b883',
									'operator' => '==',
									'value' => 'ES',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => __('Add Tracking ID','amalinkspro'),
						'sub_fields' => array (
							array (
								'key' => 'field_5a6003e32d267',
								'label' => __('Associate ID','amalinkspro'),
								'name' => 'associate_id',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array (
						'key' => 'field_5a6009b5acae5',
						'label' => __('Test Amazon API Connection','amalinkspro'),
						'name' => '',
						'type' => 'message',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_h6gu5gu7tvrtyu',
									'operator' => '!=',
									'value' => '1',
								),
								array (
									'field' => 'field_h6gu5gu7tvrtyu',
									'operator' => '!=',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => '<p>'.__('You must save your Amazon credentials with the "Save Changes" button at the top or bottom, before testing your connection here.','amalinkspro') .'</p><p>'.__('Click the button below to test your connection to the Amazon API. You must see a success message to use this plugin with the API.','amalinkspro') .'</p>
						<p style="color: red;font-style: italic;">'.__('Important! If you changed any settings above, you must click the "Save Changes" button at the top or bottom before testing your Amazon API connection.','amalinkspro') .'</p>
							<input type="button" class="js-amalinkspro-test-api button button-primary button-large" id="test-amazon-api-connection" value="'.__('Test Amazon API Connection','amalinkspro') .'" /> <img class="amalinkspro-apitest-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" />
							<p class="amazon-api-test-message"></p>',
						'new_lines' => 'wpautop',
						'esc_html' => 0,
					),
					array (
						'key' => 'field_5a61769eaeb54',
						'label' => __('Global Link Settings','amalinkspro'),
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array (
						'key' => 'field_5a617e59aeb55',
						'label' => __('Open Links in a New Window','amalinkspro'),
						'name' => 'open_links_in_a_new_window',
						'type' => 'true_false',
						'instructions' => __('This setting can be overridden when creating links in the editor. (Does not work for Non-API mode.)','amalinkspro'),
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => __('Check this box to open all AmaLinks Pro links in a new window','amalinkspro'),
						'default_value' => 1,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array (
						'key' => 'field_5a617ea0aeb56',
						'label' => __('NoFollow Links','amalinkspro'),
						'name' => 'nofollow_links',
						'type' => 'true_false',
						'instructions' => __('This setting can be overridden when creating links in the editor. (Does not work for Non-API mode.)','amalinkspro'),
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => __('Check this box to open add a rel="nofollow" tag to all AmaLinks Pro links.','amalinkspro'),
						'default_value' => 1,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array (
						'key' => 'field_5a617f1db3445',
						'label' => __('Add to Cart','amalinkspro'),
						'name' => 'add_to_cart',
						'type' => 'true_false',
						'instructions' => __('By enabling this feature, all AmaLinks Pro links will become Amazon "Add to Cart" links. When a visitor adds an item to their cart after clicking your link, you get an extra 89 day cookie set on the visitor\'s browser, giving you 3 extra months to get the commission. IMPORTANT: This feature does not currently work in Non-API mode.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => __('I want AmalInks Pro to have my links add a product to a visitor\'s Amazon cart','amalinkspro'),
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array (
						'key' => 'field_5a6219c4c40e3',
						'label' => __('Localization','amalinkspro'),
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array (
						'key' => 'field_5a6219d5c40e4',
						'label' => __('Link Localization Code','amalinkspro'),
						'name' => 'amazon_onelink_script',
						'type' => 'textarea',
						'instructions' => '<p>'.__('Insert your','amalinkspro').' <a href="https://amalinkspro.com/genius-link" target="_blank">'.__('Genius Link','amalinkspro').'</a> '.__('code here. (Amazon has discoutinued their OneLink Localization script. Remove the Amazon OneLink script if you have it entered below.)','amalinkspro').'</p>',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => __('Paste your localization code here, then hit the "Save Changes" button at the top or bottom of the page.','amalinkspro'),
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),

					array (
						'key' => 'field_5ae14379ab3e5iygygugyuy',
						'label' => '',
						'name' => '',
						'type' => 'message',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => '<p style="font-style:italic;color:#dc5454; margin: -15px 0 30px 0;"><strong>' . __('Note','amalinkspro') . ':</strong> ' . __('If you already have your Genius Link code inserted elsewhere on your site and it is working - you do not need to enter it again here. All new links created by AmaLinks Pro will convert with your existing code.','amalinkspro') . '</p><p>' . __('To learn more about using Genius Link - please read our full post about it here.','amalinkspro') . ' - <a href="https://amalinkspro.com/amazon-link-localization/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=Link%Localization&utm_content=localization-article-link" target="_blank">https://amalinkspro.com/amazon-link-localization/</a></p>',
						'new_lines' => 'wpautop',
						'esc_html' => 0,
					),
					

					array (
						'key' => 'field_5a61769eaeb5433',
						'label' => __('General','amalinkspro'),
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array (
						'key' => 'field_yg76vt87ibyi7vt8b7iyty',
						'label' => 'Google Fonts API Key',
						'name' => 'google_fonts_api_key',
						'type' => 'text',
						'instructions' => __('In order to use Google Fonts with AmaLinks Pro, you must get a free API key and save it here. To obtain your Google Fonts API Key, visit','amalinkspro') . ' <a href="https://developers.google.com/fonts/docs/developer_api#identifying_your_application_to_google" target="_blank">' . __('this page','amalinkspro') . '</a>. ' . __('You must be signed in to Google to get your API key. Once you get it from Google, paste it here and save your options.','amalinkspro') . '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array (
						'key' => 'field_bb78by87bt6in7',
						'label' => __('Enable Auto Google Analytics Event Tracking','amalinkspro'),
						'name' => 'enable_event_tracking',
						'type' => 'true_false',
						'instructions' => __('By enabling this feature, Information about what links are clicked will be sent to Google Analytics for data analyzation. Having Google Analytics installed on your website is REQUIRED.','amalinkspro'),
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => __('Enable Google Analytics Auto Event Tracking','amalinkspro'),
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array (
						'key' => 'field_uytrc65rtg87ybytdf',
						'label' => __('Showcase Settings','amalinkspro'),
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array (
						'key' => 'field_gf5g678htg76grt',
						'label' => __('Showcase Button Default Text','amalinkspro'),
						'name' => 'showcase_btn_default_text',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Buy on Amazon',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d374ruhrdg1887',
						'label' => 'Enable Showcase Custom CTA Button Styles',
						'name' => 'enable_custom_cta_color_showcase',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => '',
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array(
						'key' => 'field_5d7g4gh45g4h888',
						'label' => 'Choose Showcase Button Background Color',
						'name' => 'choose_button_color_showcase',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '#ffe04b',
					),
					array(
						'key' => 'field_5ethrytgfwrgetg8',
						'label' => 'Choose Showcase Button Text Color',
						'name' => 'choose_button_text_color_showcase',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '#000',
					),
					array(
						'key' => 'field_wregrhrgertheg8',
						'label' => 'Choose Showcase Button Border Color',
						'name' => 'choose_button_border_color_showcase',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '#9c7e31',
					),
					array(
						'key' => 'field_fgherujherwtgtyrg',
						'label' => 'Choose Showcase Button Background Color - Hover',
						'name' => 'choose_button_color_hover_showcase',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '#ffc800',
					),
					array(
						'key' => 'field_efgfhjnbtrtfergh',
						'label' => 'Choose Showcase Button Text Color - Hover',
						'name' => 'choose_button_text_color_hover_showcase',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '#000',
					),
					array(
						'key' => 'field_rfyghiujjkhntr8',
						'label' => 'Choose Showcase Button Border Color - Hover',
						'name' => 'choose_button_border_color_hover_showcase',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '#9c7e31',
					),



					array (
						'key' => 'field_6hgu6ftgy7iooiucx64xz54',
						'label' => __('Showcase Button Font Size', 'amalinkspro'),
						'name' => 'showcase_btn_font_size',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								)
							),
						),
						'wrapper' => array (
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => 14,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'px',
						'min' => '',
						'max' => '',
						'step' => '',
					),

					array (
						'key' => 'field_rtvfdefeferfreik7iuy',
						'label' => __('Showcase Button Font Style', 'amalinkspro-tables'),
						'name' => 'showcase_button_font_style',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								)
							),
						),
						'wrapper' => array (
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'normal' => __('Normal', 'amalinkspro'),
							'bold' => __('Bold', 'amalinkspro'),
							'italic' => __('Italic', 'amalinkspro'),
							'bold-italic' => __('Bold Italic', 'amalinkspro'),
						),
						'default_value' => array (
							0 => 'normal',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),

					array (
						'key' => 'field_bcrfgetdgctgtgw4x',
						'label' => __('Showcase Button Padding Top', 'amalinkspro-tables'),
						'name' => 'showcase_btn_padding_top',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => 10,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'px',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array (
						'key' => 'field_bchvghugvhgufw4x',
						'label' => __('Showcase Button Padding Right', 'amalinkspro-tables'),
						'name' => 'showcase_btn_padding_right',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => 20,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'px',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array (
						'key' => 'field_bcrcfcrcrcdssss4x',
						'label' => __('Showcase Button Padding Bottom', 'amalinkspro-tables'),
						'name' => 'showcase_btn_padding_bottom',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => 10,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'px',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array (
						'key' => 'field_bctyg76gy8tfg5dt4x',
						'label' => __('Showcase Button Padding Left', 'amalinkspro-tables'),
						'name' => 'showcase_btn_padding_left',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_5d374ruhrdg1887',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array (
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => 20,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'px',
						'min' => '',
						'max' => '',
						'step' => '',
					),


					array (
						'key' => 'field_hg76f5ergt7fr6tdd',
						'label' => __('CTA Button Settings','amalinkspro'),
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array (
						'key' => 'field_gfut6rgfg67tyrgrt',
						'label' => __('CTA Button Default Text','amalinkspro'),
						'name' => 'cta_btn_default_text',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Buy on Amazon',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					)

				),
				'location' => array (
					array (
						array (
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'amalinkspro-settings',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

		endif;



		acf_add_local_field_group(array (
			'key' => 'group_5ae1420199b67',
			'title' => __('Welcome to','amalinkspro') .' AmaLinks Pro',
			'fields' => array (
				array (
					'key' => 'field_5ae1421c1ab82',
					'label' => __('Get Started','amalinkspro'),
					'name' => '',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'top',
					'endpoint' => 0,
				),
				array (
					'key' => 'field_5ae14379ab3e5',
					'label' => __('Get Started','amalinkspro'),
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => $this->get_welcome_tab_content(),
					'new_lines' => 'wpautop',
					'esc_html' => 0,
				),
				array (
					'key' => 'field_5ae142661ab85',
					'label' => __('FAQ','amalinkspro'),
					'name' => '',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'top',
					'endpoint' => 0,
				),
				array (
					'key' => 'field_5ae14379ab3e5bytg76fr7tg8yh',
					'label' => __('Frequently Asked Questions','amalinkspro'),
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => __('Please visit our most up to date FAQ at','amalinkspro') . ' <a href="https://amalinkspro.com/frequently-asked-questions/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=FAQ%20Tab&utm_content=faq-link" target="_blank">https://amalinkspro.com/frequently-asked-questions/</a>',
					'new_lines' => 'wpautop',
					'esc_html' => 0,
				),
				array (
					'key' => 'field_jgdchtdvfjbgjkh',
					'label' => __('FAQs','amalinkspro'),
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => $this->get_faq_tab_content(),
					'new_lines' => 'wpautop',
					'esc_html' => 0,
				),
				array (
					'key' => 'field_5ae142591ab84',
					'label' => __('Support','amalinkspro'),
					'name' => '',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'top',
					'endpoint' => 0,
				),
				array (
					'key' => 'field_jsfgwgwevwetgvrt3',
					'label' => __('Support','amalinkspro'),
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => $this->get_support_tab_content(),
					'new_lines' => 'wpautop',
					'esc_html' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'amalinkspro-welcome',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));






	}


	function get_welcome_tab_content() {

		ob_start();
		?>

		<div class="wrap settings-section">

			<?php 
			$response_body = $this->simple_license_check(); 

			$response_body = unserialize($response_body);

			// echo '$response_body<pre>'.print_r($response_body,1).'</pre>';

			$license_status = $response_body->license;
        	$customer_name = $response_body->customer_name;
        	$customer_email = $response_body->customer_email;
        	$expires = $response_body->expires;


        	if ($expires=='lifetime') {
				$expires_date = __('Never - it\'s Lifetime!','amalinkspro');
        	}
        	else {
        		$expires_date = date_create($expires);
        		$expires_date = date_format($expires_date,"F j, Y");
        	}

        	//echo '$license<pre>'.print_r($license,1).'</pre>';
        	$license    = get_option('amalinkspro_license');
            $status     = get_option('amalinkspro_license_status');
            ?>

			<?php if ( ($license_status == 'valid' || $license_status == 'site_inactive') && $status=='valid' ) : ?>

				<h2 class="welcome-heading-primary"><?php echo __( 'Your', 'amalinkspro' ) . ' AmaLinks Pro ' . __( 'license is Active', 'amalinkspro' ); ?></h2>
				<p class="welcome-heading-note"><?php echo $customer_name . ', ' . __('your license renews automatically on','amalinkspro') .' <span>' . $expires_date . '</span><br />' . __('Your current links will not stop working if your license expires, but you will not be able to create new Amazon links using AmaLinks Pro.','amalinkspro') .'</p>'; ?>

			<?php elseif ( ($license_status == 'valid' || $license_status == 'site_inactive') && $status=='deactivated' ) : ?>

				<h2 class="welcome-heading-primary"><?php echo __( 'Your','amalinkspro' ) . ' AmaLinks Pro ' . __( 'license is Deactivated', 'amalinkspro' ); ?></h2>
				<p class="welcome-heading-note"><?php echo $customer_name . ', ' . __('your license renews on ', 'amalinkspro' ) .' <span>' . $expires_date . '</span><br />' . __( 'Your current links will not stop working if your license expires, but you will not be able to create new Amazon links using AmaLinks Pro','amalinkspro' ) . '.</p>'; ?>

				

			<?php elseif ( $license_status == 'expired') : ?>

				<h2 class="welcome-heading-primary"><?php echo __( 'Your', 'amalinkspro' ) . ' AmaLinks Pro ' . __( 'license has Expired!', 'amalinkspro' ); ?></h2>
				<p class="welcome-heading-note"><?php echo __('Your license expired on','amalinkspro') .' <span>' . $expires_date . '</span>.<br />' . __('Please log into','amalinkspro') .' <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=License%20Expired&utm_content=my-account" target="_blank">' . __('My Account','amalinkspro') .'</a> ' . __('and renew your license to continue using AmaLinks Pro. Your current links will not stop working.','amalinkspro') .'</p>'; ?>

			<?php elseif ( $status == 'invalid') : ?>

				<h2 class="welcome-heading-primary"><?php echo __( 'The', 'amalinkspro' ) . ' AmaLinks Pro ' . __( 'license Entered is Not Valid', 'amalinkspro' ); ?></h2>
				<p class="welcome-heading-note"><?php echo __('Please log into','amalinkspro') . ' <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=License%20Not%20Valid&utm_content=my-account" target="_blank">' . __('My Account','amalinkspro') .'</a> ' . __('to retrieve your license key for AmaLinkd Pro.','amalinkspro') . '</p>'; ?>

			<?php else: ?>

				<h2 class="welcome-heading-primary"><strong><?php _e( 'STEP 1: ', 'amalinkspro' ); ?></strong><?php _e( 'Activate your AmaLinks Pro License!', 'amalinkspro' ); ?></h2>
				<p class="welcome-heading-note empty-license"><?php echo __('You must enter and activate your license key provided upon purchase to use this plugin. You can find your AmaLinks Pro software license in your email receipt, or by logging into','amalinkspro') . ' <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=No%20License%20Entered&utm_content=my-account" target="_blank">' . __( 'My Account','amalinkspro') .'</a>.</p>'; ?>

				 <div class="license-message-note">

                	<?php 
                	echo '<p><span style="color: #dc5454;margin-bottom: 10px;display: block;">'.__('* This is not where you put your Amazon API Keys','amalinkspro') . '.</span></p>';
                	?>

            	</div>


			<?php endif; ?>
		        
		        <?php // the ID in the box must be the license option name: amalinkspro_CHILDTHEMEOREXTENSIONNAME_license ?>
		        <div class="alp-option-box" id="amalinkspro_license_wrap">


		            <div class="alp-option-box-inner">


		                <?php

		                //echo '$status<pre>'.print_r($status,1).'</pre>';

		                if($status=='deactivated'):
		                echo '<div class="license-message amalinkspro-license-deactivated">';
		                //endif;

		                elseif($status=='invalid'):
		                echo '<div class="license-message amalinkspro-license-invalid">';
		                //endif;


		                elseif($status=='valid'):
		                echo '<div class="license-message amalinkspro-license-valid">';

		           		else:
		           			 echo '<div class="license-message">';
		                endif;
		                ?>



			                <div class="license-form">

			                    <?php // the ID & name attributes must be the option name stored in the DB. It should follow this format:   amalinkspro_CHILDorEXTENSIONTITLE_license ?>
			                    <input id="amalinkspro_license" type="password" class="amalinkspro-license" name="amalinkspro_license" value="<?php echo $license; ?>" />

			                    <?php // the ID and name attributes must be "amalinkspro_product" and the value must be the name of the product in the amalinkspro.com store. The input type must be "hidden" ?>
			                    <input id="amalinkspro_product" type="hidden" class="amalinkspro-product" name="amalinkspro_product" value="AmaLinks Pro" />

			                    <?php if ( $license != '' && $status == 'valid' ) : ?>

			                        <?php // The deactivate button must have  amalinkspro-deactivate  as a class ?>
			                        <?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
			                            <input type="button" class="button button-primary button-large amalinkspro-deactivate" name="amalinksprodeactivate" value="<?php _e('Deactivate', 'amalinkspro'); ?>"/>

			                    <?php else: ?>

			                        <?php // The activate button must have  amalinkspro-activate  as a class ?>
			                        <?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
			                            <input type="button" class="button button-primary button-large amalinkspro-activate" name="amalinksproactivate" value="<?php _e('Activate', 'amalinkspro'); ?>"/>

			                    <?php endif; ?>

			                    <a href="#" class="alp-js-clear-license"><?php _e('Clear', 'amalinkspro'); ?></a>

			                </div>

			                <img class="amalinkspro-license-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" />

			            </div>

		            </div>

	        	</div>


	    </div>

	    <div class="alp-addon-licenses">
        	<?php do_action('alp_addon_licenses'); ?>
        </div>

    
	    

	    <?php

	    $tab_welcome = ob_get_contents();
		ob_end_clean();

		return $tab_welcome;
	}


	function get_faq_tab_content() {

		ob_start();
		?>

		<!-- <h2 class="welcome-heading-primary"><?php _e( 'Frequently Asked Questions', 'amalinkspro' ); ?></h2> -->

		<?php

	    $tab_welcome = ob_get_contents();
		ob_end_clean();

		return $tab_welcome;
	}

	function get_support_tab_content() {

		ob_start();
		?>

		<h2 class="welcome-heading-primary"><?php _e( 'Help & Support', 'amalinkspro' ); ?></h2>

		<p><?php echo __('To view the AmaLinks Pro documentation, please visit','amalinkspro') . ' <a href="https://amalinkspro.com/documentation/?utm_source=Plugin&utm_medium=Support%20Tab&utm_campaign=Documentation%20URL&utm_content=documentation" target="_blank">https://amalinkspro.com/documentation/</a>.'; ?><p>
		<p><?php echo __('For support, please visit ','amalinkspro') . '<a href="https://amalinkspro.com/support/?utm_source=Plugin&utm_medium=Support%20Tab&utm_campaign=Support%20URL&utm_content=support" target="_blank">https://amalinkspro.com/support/</a>.'; ?></p>
		<p>AmaLinks Pro <?php echo __('is developed and maintained by','amalinkspro') . ' <a href="https://dumbpassiveincome.com/?utm_source=Plugin&utm_medium=Support%20Tab&utm_campaign=Developed%20and%20Maintained%20By&utm_content=dumbpassiveincome%20URL" target="_blank">Matthew Allen</a> '. __('and', 'amalinkspro') . ' <a href="http://alchemycoder.com/?utm_source=Plugin&utm_medium=Support%20Tab&utm_campaign=Developed%20and%20Maintained%20By&utm_content=alchemycoder%20URL" target="_blank">Alchemy Coder</a>.'; ?></p>

		<br /><br />

		<h2 class="welcome-heading-primary"><?php _e( 'Join our Family of Successful Affiliates', 'amalinkspro' ); ?></h2>

		<p><?php _e( 'Learn why AmaLinks Pro was','amalinkspro'); ?> <a href="https://amalinkspro.com/built-for-us/?utm_source=Plugin&utm_medium=Main%20Page&utm_campaign=Support%Tab&utm_content=text-link" target="_blank"><?php _e( 'Built for Us', 'amalinkspro' ); ?></a></p>

		<?php

	    $tab_welcome = ob_get_contents();
		ob_end_clean();

		return $tab_welcome;
	}





	// function for activating AmaLinks Pro themes and plugins licenses
	function activate_amalinkspro_license() {

	    global $wpdb;

	    $license        = $_POST['license'];
	    $plugin_license = $_POST['plugin'];
	    $edd_name = $_POST['edd_name'];

	    $old_license    = get_option( $plugin_license );
	    $plugin_license_status = $plugin_license . '_status';
	    $old_status     = get_option( $plugin_license_status );

	    // if the license in the db is empty or matches the new valaue and is all numbers and letters
	    if ( ( $license != '' ) && ctype_alnum($license) ) {

	        // this is a fix to remove http from url to make api resonse not result in a 403 error
	        // It also removes he www because EDD said: We strip out ://www but you are stripping out http:// before sending in the activation, which means www will still be there. We can't strip out www by itself because that could be part of a domain name. 
	        $full_home_url = get_home_url();
	        // $find = array( 'http://www.', 'https://www.', 'http://', 'https://' );
	        // $replace = '';
	        // $short_home_url = str_replace( $find, $replace, $full_home_url );

	        $short_home_url = $full_home_url;

	        // data to send in our API request
	        $api_params = array( 
	            'edd_action'=> 'activate_license', 
	            'license'   => $license, 
	            'item_name' => urlencode( $edd_name ), // the name of our product in EDD,
	            'url'       => $short_home_url
	        );
	        
	        // Call the custom API.
	        $response = wp_remote_get( add_query_arg( $api_params, 'https://amalinkspro.com' ) );

	        //echo '$response<pre>'.print_r($response,1).'</pre>';

	        // make sure the response came back okay
	        if ( is_wp_error( $response ) ) {
	            $result = __('Sorry, there has been a connection error.','amalinkspro');
	        }

	        else {

	            // decode the license data
	            $license_data = json_decode( wp_remote_retrieve_body( $response ) );

	            if ( $license_data->license == 'valid' ) {
	                // $license_data->license will be either "valid" or "invalid"
	                delete_option( $plugin_license_status );
	                update_option( $plugin_license_status, $license_data->license );

	                if ( $license != $old_license ) {
	                    delete_option( $plugin_license );
	                    update_option( $plugin_license, $license );
	                }
	            }
	            $result = $license_data->license;
	        }

	    }
	    else {
	        $result = __('Sorry, there has been a connection error.','amalinkspro');
	    }

	    echo $result;
	    die(1);
	}


	// function for deactivating AmaLinks Pro themes and plugins licenses
	function deactivate_amalinkspro_license() {

	    global $wpdb;

	    $license        = $_POST['license'];
	    $plugin_license = $_POST['plugin'];
	    $edd_name       = $_POST['edd_name'];


	    $old_license    = get_option( $plugin_license );
	    $plugin_license_status = $plugin_license.'_status';
	    $old_status     = get_option( $plugin_license_status );

	    if ( $license == $old_license ) {

	        // this is a fix to remove http from url to make api resonse not result in a 403 error
	        $full_home_url = get_home_url();
	        // $find = array( 'http://www.', 'https://www.', 'http://', 'https://' );
	        // $replace = '';
	        // $short_home_url = str_replace( $find, $replace, $full_home_url );

	        $short_home_url = $full_home_url;


	        // data to send in our API request
	        $api_params = array( 
	            'edd_action'=> 'deactivate_license', 
	            'license'   => $license, 
	            'item_name' => urlencode( $edd_name ), // the name of our product in EDD,
	            'url'       => $short_home_url
	        );

	        
	        // Call the custom API.
	        $response = wp_remote_get( add_query_arg( $api_params, 'http://amalinkspro.com' ) );

	        // make sure the response came back okay
	        if ( is_wp_error( $response ) ) {
	            $result = __('Sorry, there has been a connection error.','amalinkspro');
	        }

	        else {

	            // decode the license data
	            $license_data = json_decode( wp_remote_retrieve_body( $response ) );

	            // $license_data->license will be either "deactivated" or "failed"
	            if( $license_data->license == 'deactivated' ) {
	                delete_option( $plugin_license_status );
	                update_option( $plugin_license_status, $license_data->license );
	            }

	            $result = $license_data->license;

	        }


	    }

	    else {
	        $result = __('Sorry, there has been a connection error.','amalinkspro');
	    }

	    echo $result;
	    //str_replace("\u0022","\\\\\"",json_encode( $results,JSON_HEX_QUOT));
	    die(1);

	}


	public function alp_clear_license() {

		global $wpdb;

		$plugin  = $_POST['plugin'];

		delete_option($plugin);
		$status = $plugin.'_status';
		delete_option($status);

		die(1);

	}



	public function simple_license_check() {
		global $wpdb;

		/*  Returns

		This is a full propewr EDD license_check response

		stdClass Object
		(
		    [success] => 1
		    [license] => valid
		    [item_id] => 
		    [item_name] => AmaLinks Pro
		    [checksum] => 23c5dc441880648e763e3ea68e3fd9cf
		    [expires] => lifetime
		    [payment_id] => 2755
		    [customer_name] => Matt AffiliateTest
		    [customer_email] => matt76allen@gmail.com
		    [license_limit] => 0
		    [site_count] => 11
		    [activations_left] => unlimited
		    [price_id] => 10
		)

		or ...

		if license field is empty - you get back        'empty'
		if license is badly formatted - you get back    'invalid'

		*/


		// our transient name
		$transient = 'amalinkspro_license_check_transient_arr_2';
		// check for our transient
		$transient_check = get_transient( $transient );

		if ($transient_check ) {
			$license_check_response = $transient_check;
			return $license_check_response;
		}

		else {

			$license = get_option('amalinkspro_license');

			// check if the license is completely empty, if so retun proper error message
			if ( $license == '' ) {
				$license_check_response = 'empty';
				return $license_check_response;
			}

			// check if license is alphanumeric, if not give proper error message
			if ( !ctype_alnum($license) ) {
				$license_check_response = 'invalid';
				return $license_check_response;
			}

			// this is a fix to remove http from url to make api resonse not result in a 403 error
	        $full_home_url = get_home_url();
	        // $find = array( 'http://www.', 'https://www.', 'http://', 'https://' );
	        // $replace = '';
	        // $short_home_url = str_replace( $find, $replace, $full_home_url );

	        $short_home_url = $full_home_url;

	        // data to send in our API request
	        $api_params = array( 
	            'edd_action'=> 'check_license', 
	            'license'   => $license, 
	            'item_name' => urlencode( $this->edd_product ), // the name of our product in EDD,
	            'url'       => $short_home_url
	        );

	        
	        // Call the custom API.
	        $response = wp_remote_get( add_query_arg( $api_params, 'https://amalinkspro.com' ) );

	        if ( $response ) {

	        	// make sure the response came back okay
	        	//rohitsharma-START
	        	$response_body = $this->custom_get_license();
	        	// if ( is_wp_error( $response ) ) {
		        //     $license_check_response = 'error';
		        //     return $license_check_response;
		        // }

	        	// $response_body = json_decode( $response['body'] );
	        	//rohitsharma-END
	        	$license_check_response = $response_body;

	        	$value = serialize($license_check_response);

	        	$expiration = 60 * 60 * 168;
				set_transient( $transient, $value, $expiration );

	        }

	        return $license_check_response;


		}

        // return $license_check_response;

	}



	// 
	public function check_amalinkspro_license() {

		global $wpdb;


		// our transient name
		$transient = 'amalinkspro_license_check_transient_arr_2';
		// check for our transient
		$transient_check = get_transient( $transient );

		if ( $transient_check ) {
			$license_check_response = $transient_check;
			return $license_check_response;
		}

		else {

			$license = get_option('amalinkspro_license');

			// check if the license is completely empty, if so retun proper error message
			if ( $license == '' ) {
				$license_check_response = 'empty';
				return $license_check_response;
			}

			// check if license is alphanumeric, if not give proper error message
			if ( !ctype_alnum($license) ) {
				$license_check_response = 'invalid';
				return $license_check_response;
			}



			// this is a fix to remove http from url to make api resonse not result in a 403 error
	        $full_home_url = get_home_url();
	        // $find = array( 'http://www.', 'https://www.', 'http://', 'https://' );
	        // $replace = '';
	        // $short_home_url = str_replace( $find, $replace, $full_home_url );

	        $short_home_url = $full_home_url;

	        // data to send in our API request
	        $api_params = array( 
	            'edd_action'=> 'check_license', 
	            'license'   => $license, 
	            'item_name' => urlencode( $this->edd_product ), // the name of our product in EDD,
	            'url'       => $short_home_url
	        );


	        // Call the custom API.
	        $response = wp_remote_get( add_query_arg( $api_params, 'https://amalinkspro.com' ) );

	        //return $response;

		        


	        if ( $response ) {

	        	// make sure the response came back okay
		        if ( is_wp_error( $response ) ) {
		            $license_check_response = __('There was a problem connecting to the AmaLinks Pro API. Please try again in a few minutes. This is usually due to slower internet connections or Amazon throttling the API.','amalinkpro');
		            return $license_check_response;
		        }

	        	$response_body = json_decode( $response['body'] );

	        	$value = serialize($license_check_response);

	        	$expiration = 60 * 60 * 168;
				set_transient( $transient, $value, $expiration );

	        	$license = $response_body->license;
	        	$customer_name = $response_body->customer_name;
	        	$customer_email = $response_body->customer_email;
	        	$expires = $response_body->expires;

	        	if ( $expires ) {

	        		$date = DateTime::createFromFormat('Y-m-d H:i:s', $expires);
		        	if ( $date ) {
		        		$date_formatted = $date->format('F d, Y');
		        	}
					else {
						$date_formatted = 'Unknown';
					}

	        	}
	        	else {
					$date_formatted = 'Unknown';
				}


	        	if ( $license == 'valid' ) {
	        		$license_check_response = 'valid';
	        	}
	        	else if ( $license == 'expired' ) {

	        		$license_check_response = 'expired';
	        		

	        	}

	        }

	        return $license_check_response;

		}


	}




	function add_amalinkspro_media_button() {
	    echo '<a id="insert-amalinkspro-media" data-alp-block="none" class="button amalinkspro-insert-media-btn" title="' . __('Insert Amazon Affiliate Links','amalinkspro') .'" href="#TB_inline&inlineId=amalinkspro-media-window&width=753&height=185"><img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/AmaLinks-Pro-Logo.png" alt="' . __('AmaLinks Pro - The Best Amazon Associate WordPress Plugin','amalinkspro') .'" /></a>';
	}



	function alp_cta_generator_input_slider($title, $class) {
		$html = '<h4>'.$title.'</h4>';
		$html .= '<div class="amalinkspro-slider-wrap">';
		$html .= '<div class="'.$class.'"></div>';
		$html .= '</div>';

		return $html;
	}






	function amalinkspro_add_inline_popup_content() {


		echo '<div id="amalinkspro-close-modal" style="display: none;"></div>';

		$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
		?>


		<div id="amalinkspro-media-window" style="display: none;">

			<div id="dialog-confirm-update-btn" title="<?php _e('Overwrite Current CTA Button Settings?','amalinkspro'); ?>">
				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span><?php _e('The current button styles will be permanently written over. Are you sure?','amalinkspro'); ?></p>
			</div>

			<div class="alp-hidden-img-chooser">
				<span class="amalinkspro-close-showcase-img-chooser"></span>
				<div class="alp-hidden-img-chooser-inner">

					<?php if ( !get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>
						<h2><?php _e('Choose your Showcase Image','amalinkspro'); ?></h2>
						<!-- <a class="alp-showcase-select-img button button-primary" href="#"><?php _e('Select','amalinkspro'); ?></a> -->
					<?php endif; ?>

					<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

						<div id="alp-noapi-showcaseimage" class="amalinkspro-popup-form">

							<h2>Amazon Affiliate SiteStripe Image Code for Showcase</h2>
							
							<p><a href="https://amalinkspro.com/no-api/" target="_blank">Click here</a> for instructions on how to use AmaLinks Pro without an API connection.</p>

							<textarea id="alp-noapi-showcaseimage-code-field" placeholder="Enter your Amazon Affiliate Site Stripe Image Code Here."></textarea>

							<a class="alp-insert-sitestripe-showcase" href="#">Insert into Showcase</a>

						</div>

					<?php else: ?>

						<div id="alp-hidden-img-choices-showcase-3" class="alp-hidden-img-choices">
							<p><?php _e('choices go here.','amalinkspro'); ?></p>
						</div>

					<?php endif; ?>

				</div>
			</div>


			<div id="dialog-btn-saved" title="<?php _e('Your CTA Button Has Been Saved!','amalinkspro'); ?>">
				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span><?php _e('You can use this button, or continue editing.','amalinkspro'); ?></p>
			</div>
 

			<div class="amalinkspro-loading-overlay"><span class="alp-spinner"></span></div>

			<div class="amalinkspro-media-window-title">
				<span class="amalinkspro-close-modal"></span>
				<h1><a href="https://amalinkspro.com/?utm_source=Plugin&utm_medium=Wizard%20Logo&utm_campaign=Logo%20Link&utm_content=homepage" target="_blank"><?php echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/AmaLinks-Pro-Logo.png" alt="' . __('AmaLinks Pro - The Best Amazon Associate WordPress Plugin','amalinkspro') . '" />'; ?></a></h1>
			</div>

			<div id="alp-btn-generator-preview" class="alp-btn-generator-preview">

				<span class="amalinkspro-close-ctabuilder"></span>

				<?php 
				$user_meta = wp_get_current_user(); 
				$user_nicename = $user_meta->user_nicename;
				if ( !$user_nicename ) {
					$user_nicename = $user_meta->user_login;
				}
				?>

				<a class="amalinkspro-css-button alp-css-button-generator-preview" href="#"><?php _e('Hey','amalinkspro'); ?> <?php echo $user_meta->user_nicename; ?>, <?php _e('Here\'s Your Button!','amalinkspro'); ?></a>

				<div class="amalinkspro-cta-btn-manage">
					<a class="save-cta-btn js-amalinkspro-save-cta-btn new-btn" href="#" title="<?php _e('Update the current Button','amalinkspro'); ?>"><?php _e('Save New','amalinkspro'); ?></a>
					<a class="save-cta-btn js-amalinkspro-update-cta-btn update-btn" href="#" title="<?php _e('Update the current Button','amalinkspro'); ?>"><?php _e('Update','amalinkspro'); ?></a>
					<a class="save-cta-btn js-amalinkspro-save-cta-btn save-btn" href="#" title="<?php _e('Save as a New Button','amalinkspro'); ?>"><?php _e('Save New','amalinkspro'); ?></a>
				</div>

				<div id="alp_load_editor_cta_buttons" class="alp_load_editor_cta_buttons"></div>


			</div>
		

			<div class="alp-steps-counter">
				<span class="alp-step alp-step-1 alp-step-active" data-alp-step="alp-step-1" title="<?php _e('Search Amazon and Choose your Product','amalinkspro'); ?>"><i class="icon-amalinkspro-search"></i> <?php _e('Step 1','amalinkspro'); ?></span>
				<span class="alp-step alp-step-2 alp-step-disabled" data-alp-step="alp-step-2" title="<?php _e('Choose your Link Type and Configure your Link Options','amalinkspro'); ?>"><i class="icon-amalinkspro-edit"></i> <?php _e('Step 2','amalinkspro'); ?></span>
				<span class="alp-step alp-step-3 alp-step-disabled" data-alp-step="alp-step-3" title="<?php _e('Review your Final Amazon Link, Adjust Additional Settings, and Insert your Amazon Affiliate Link','amalinkspro'); ?>"><i class="icon-amalinkspro-rocket"></i> <?php _e('Step 3','amalinkspro'); ?></span>
				<div class="amalinkspro-clear"></div>
			</div>




			<div id="amalinkspro-media-window-content" class="amalinkspro-media-window-content">


				<div class="alp-btn-generator">
				<div class="alp-btn-generator-inner">


					<!-- preview goes here -->


					<div class="alp-btn-generator-controls">

						<div class="alp-btn-generator-controls-section controls-text">
							<span class="toggle-indicator" aria-hidden="true"></span>
							<h3><?php _e('Customize Text','amalinkspro'); ?> <span class="title-hover-label">(<?php _e('Hover State','amalinkspro'); ?>)</span> <i class="icon-amalinkspro-up-circle"></i></h3>

							<div class="alp-btn-generator-controls-section-body">

								<div class="alp-edit-hv">
									<span class="fh-switch amalinkspro-hover-trigger">
										<input type="checkbox" name="myswitch" class="hv-panel-switch">
										<label for="switch-id">(<?php _e('Edit Hover State','amalinkspro'); ?>)</label>
										<span class="fh-switch-knob"></span>
									</span>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-33">


									<?php
									if ( get_option('amalinkspro_cta_buttons') ) {
										$cta_btn_count = get_option('amalinkspro_cta_buttons');
										$cta_btn_count_next = $cta_btn_count + 1;
									}
									else {
										$cta_btn_count = '0';
										$cta_btn_count_next = '0';
									}
									?>

									<input type="hidden" name="alp-button-id" class="alp-button-id" value="<?php echo $cta_btn_count; ?>" />

									<input type="hidden" name="alp-button-id-next" class="alp-button-id-next" value="<?php echo $cta_btn_count_next; ?>" />
								
									<h4><?php _e('Font Family','amalinkspro'); ?></h4>

									<div class="system-select-wrapper">

										<select class="alp-control-font-family alp-control-font-family-system">
											<option></option>
											<option value="Helvetica">Helvetica</option>
											<option value="Arial" selected="selected">Arial</option>
											<option value="Times">Times</option>
											<option value="Times New Roman">Times New Roman</option>
											<option value="Courier">Courier</option>
											<option value="Courier New">Courier New</option>
											<option value="Verdana">Verdana</option>
											<option value="Tahoma">Tahoma</option>
										</select>

									</div>


									<?php if ( get_option('amalinkspro-options_google_fonts_api_key') != '' ) : ?>

										<div class="google-select-wrapper">

											<?php
											$amalinkspro_google_fonts = new amalinkspro_google_fonts();
											$build_google_fonts_select = $amalinkspro_google_fonts->build_google_fonts_select();

											echo $build_google_fonts_select;
											?>

										</div>

									<?php endif; ?>

								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-66 alp-btn-generator-col-gray">
								
									<h4><?php _e('Google Fonts','amalinkspro'); ?></h4>

									<?php 
									if ( get_option('amalinkspro-options_google_fonts_api_key') == '' ) {
										$disabled = ' disabled';
									}
									else {
										$disabled = '';
									}
									?>

									<input name="alp-control-enable-googlefonts" class="alp-control-enable-googlefonts" type="checkbox"<?php echo $disabled; ?> value="1" /> <label><?php _e('Enable Google Fonts','amalinkspro'); ?></label> <div class="amalinkspro-tooltip-wrap"><i class="amalinkspro-js-googlefont-info icon-amalinkspro-help"></i>
									<div class="amalinkspro-tooltip"><?php _e('To use Google Fonts in your CTA Buttons, you must have a Google Fonts API key.','amalinkspro'); ?> <a href="<?php echo admin_url( 'admin.php?page=amalinkspro-settings' ); ?>" target="_blank"><?php _e('Click Here','amalinkspro'); ?></a> <?php _e('and view the "Styles" tab for instructions on setting up your API key. You must refresh this page after saving your API key to use Google Fonts.','amalinkspro'); ?><span class="amalinkspro-close-tooltip"></span></div></div>

								</div>


							

								<div class="alp-btn-generator-col alp-btn-generator-col-clear alp-btn-generator-col-33">
									<?php echo $this->alp_cta_generator_input_slider('Font Size', 'alp-control-font-size'); ?>
								</div>


								<div class="alp-btn-generator-col alp-btn-generator-col-66">
								
									<h4><?php _e('Font Color','amalinkspro'); ?></h4>
									<div class="amalinkspro-slider-wrap">
										<input type="text" class="alp-control-font-color" value="#FFFFFF" />
									</div>

								</div>


								<div class="alp-btn-generator-controls-section-body-bottom">


									<div class="alp-btn-generator-col alp-btn-generator-col-clear alp-btn-generator-col-33">
									
										<h4><?php _e('Text Shadow','amalinkspro'); ?></h4>
										<label><input class="alp-control-textshadow-enable" name="alp-control-textshadow-enable" type="checkbox" checked="checked" /> <?php _e('Check to Enable Text Shadow','amalinkspro'); ?></label>

									</div>


									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-66">
									
										<h4><?php _e('Text Shadow Color','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<input type="text" class="alp-control-textshadow-color" value="#000000" />
										</div>

									</div>


									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
										<?php echo $this->alp_cta_generator_input_slider( __('X Axis Offset','amalinkspro'), 'alp-control-textshadow-x'); ?>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
										<?php echo $this->alp_cta_generator_input_slider( __('Y Axis Offset','amalinkspro'), 'alp-control-textshadow-y'); ?>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
										<?php echo $this->alp_cta_generator_input_slider( __('Blur','amalinkspro'), 'alp-control-textshadow-blur'); ?>
									</div>

									<div class="amalinkspro-clear"></div>

								</div>

								<div class="alp-btn-generator-controls-section-body-hover">

									<div class="alp-btn-generator-col alp-btn-generator-col-clear alp-btn-generator-col-33">
										<h4><?php _e('Hover Styles','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											&nbsp;
										</div>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-66">
										<h4>&nbsp;</h4>
										<div class="amalinkspro-slider-wrap">
											&nbsp;
										</div>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-clear alp-btn-generator-col-33">
										<?php echo $this->alp_cta_generator_input_slider( __('Font Size (Hover)', 'amalinkspro'), 'alp-control-font-size-hover'); ?>
									</div>


									<div class="alp-btn-generator-col alp-btn-generator-col-66">
									
										<h4><?php _e('Font Color (Hover)','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<input type="text" class="alp-control-font-color-hover" value="#FFFFFF" />
										</div>

									</div>

									<div class="alp-btn-generator-controls-section-body-hover-bottom">


										<div class="alp-btn-generator-col alp-btn-generator-col-clear alp-btn-generator-col-33">
										
											<h4>&nbsp;</h4>
											&nbsp;

										</div>


										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-66">
										
											<h4><?php _e('Text Shadow Color (Hover)','amalinkspro'); ?></h4>
											<div class="amalinkspro-slider-wrap">
												<input type="text" class="alp-control-textshadow-color-hover" value="#000000" />
											</div>

										</div>


										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
											<?php echo $this->alp_cta_generator_input_slider( __('X Axis Offset (Hover)','amalinkspro'), 'alp-control-textshadow-x-hover'); ?>
										</div>

										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
											<?php echo $this->alp_cta_generator_input_slider( __('Y Axis Offset (Hover)','amalinkspro'), 'alp-control-textshadow-y-hover'); ?>
										</div>

										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
											<?php echo $this->alp_cta_generator_input_slider( __('Blur (Hover)','amalinkspro'), 'alp-control-textshadow-blur-hover'); ?>
										</div>

										<div class="amalinkspro-clear"></div>

									</div>

								</div>

								<div class="amalinkspro-clear"></div>


							</div>

						</div>







						<div class="alp-btn-generator-controls-section controls-box">

							<span class="toggle-indicator" aria-hidden="true"></span>
							<h3><?php _e('Customize Box','amalinkspro'); ?> <span class="title-hover-label">(<?php _e('Hover State','amalinkspro'); ?>)</span> <i class="icon-amalinkspro-up-circle"></i></h3>

							<div class="alp-btn-generator-controls-section-body">

								<div class="alp-edit-hv">
									<span class="fh-switch amalinkspro-hover-trigger">
										<input type="checkbox" name="myswitch" class="hv-panel-switch">
										<label for="switch-id">(<?php _e('Edit Hover State','amalinkspro'); ?>)</label>
										<span class="fh-switch-knob"></span>
									</span>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-25">
									<?php echo $this->alp_cta_generator_input_slider( __('Padding Top','amalinkspro'), 'alp-control-padding-top'); ?>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-25">
									<?php echo $this->alp_cta_generator_input_slider( __('Padding Right','amalinkspro'), 'alp-control-padding-right'); ?>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-25">
									<?php echo $this->alp_cta_generator_input_slider( __('Padding Bottom','amalinkspro'), 'alp-control-padding-bottom'); ?>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-25">
									<?php echo $this->alp_cta_generator_input_slider( __('Padding Left','amalinkspro'), 'alp-control-padding-left'); ?>
								</div>


								<div class="alp-btn-generator-controls-section-body-bottom">

									<div class="alp-btn-generator-col alp-btn-generator-col-clear alp-btn-generator-col-33">
									
										<h4><?php _e('Box Shadow','amalinkspro'); ?></h4>
										<input class="alp-control-boxshadow-enable" name="alp-control-boxshadow-enable" type="checkbox" checked="checked" /> <label><?php _e('Check to Enable Box Shadow','amalinkspro'); ?></label>

									</div>


									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-66">
									
										<h4><?php _e('Box Shadow Color','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<input type="text" class="alp-control-boxshadow-color" value="#000000" />
										</div>

									</div>


									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
										<?php echo $this->alp_cta_generator_input_slider( __('X Axis Offset','amalinkspro'), 'alp-control-boxshadow-x'); ?>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
										<?php echo $this->alp_cta_generator_input_slider( __('Y Axis Offset','amalinkspro'), 'alp-control-boxshadow-y'); ?>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
										<?php echo $this->alp_cta_generator_input_slider( __('Blur','amalinkspro'), 'alp-control-boxshadow-blur'); ?>
									</div>

									<div class="amalinkspro-clear"></div>

								</div>


								<div class="alp-btn-generator-controls-section-body-hover">


									<div class="alp-btn-generator-col alp-btn-generator-col-25">
										<?php echo $this->alp_cta_generator_input_slider( __('Padding Top (Hover)','amalinkspro'), 'alp-control-padding-top-hover'); ?>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-25">
										<?php echo $this->alp_cta_generator_input_slider( __('Padding Right (Hover)','amalinkspro'), 'alp-control-padding-right-hover'); ?>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-25">
										<?php echo $this->alp_cta_generator_input_slider( __('Padding Bottom (Hover)','amalinkspro'), 'alp-control-padding-bottom-hover'); ?>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-25">
										<?php echo $this->alp_cta_generator_input_slider( __('Padding Left (Hover)','amalinkspro'), 'alp-control-padding-left-hover'); ?>
									</div>


									<div class="alp-btn-generator-controls-section-body-bottom">


										<div class="alp-btn-generator-col alp-btn-generator-col-clear alp-btn-generator-col-33">
											<h4>&nbsp;</h4>
											&nbsp;
										</div>


										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-66">
										
											<h4><?php _e('Box Shadow Color (Hover)','amalinkspro'); ?></h4>
											<div class="amalinkspro-slider-wrap">
												<input type="text" class="alp-control-boxshadow-color-hover" value="#000000" />
											</div>

										</div>


										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
											<?php echo $this->alp_cta_generator_input_slider( __('X Axis Offset (Hover)','amalinkspro'), 'alp-control-boxshadow-x-hover'); ?>
										</div>

										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
											<?php echo $this->alp_cta_generator_input_slider( __('Y Axis Offset (Hover)','amalinkspro'), 'alp-control-boxshadow-y-hover'); ?>
										</div>

										<div class="alp-btn-generator-col alp-btn-generator-col-hidden alp-btn-generator-col-33">
											<?php echo $this->alp_cta_generator_input_slider( __('Blur (Hover)','amalinkspro'), 'alp-control-boxshadow-blur-hover'); ?>
										</div>

										<div class="amalinkspro-clear"></div>

									</div>

									<div class="amalinkspro-clear"></div>

								</div>


							</div>

						</div>






						<div class="alp-btn-generator-controls-section controls-border">

							<h3><?php _e('Customize Border','amalinkspro'); ?> <span class="title-hover-label">(<?php _e('Hover State','amalinkspro'); ?>)</span> <i class="icon-amalinkspro-up-circle"></i></h3>

							<div class="alp-btn-generator-controls-section-body">

								<div class="alp-edit-hv">
									<span class="fh-switch amalinkspro-hover-trigger">
										<input type="checkbox" name="myswitch" class="hv-panel-switch">
										<label for="switch-id">(<?php _e('Edit Hover State','amalinkspro'); ?>)</label>
										<span class="fh-switch-knob"></span>
									</span>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-33">
									<h4><?php _e('Border Radius','amalinkspro'); ?></h4>
									<div class="amalinkspro-slider-wrap">
										<div class="alp-control-border-radius"></div>
									</div>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-33">
									<h4><?php _e('Border Width','amalinkspro'); ?></h4>
									<div class="amalinkspro-slider-wrap">
										<div class="alp-control-border-width"></div>
									</div>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-33">
									<h4><?php _e('Border Color','amalinkspro'); ?></h4>
									<div class="amalinkspro-slider-wrap">
										<input type="text" class='alp-control-border-color' value="#0073aa" />
									</div>
								</div>

								<div class="amalinkspro-clear"></div>

								<div class="alp-btn-generator-controls-section-body-hover">

									<div class="alp-btn-generator-col alp-btn-generator-col-33">
										<h4><?php _e('Border Radius (Hover)','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<div class="alp-control-border-radius-hover"></div>
										</div>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-33">
										<h4><?php _e('Border Width (Hover)','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<div class="alp-control-border-width-hover"></div>
										</div>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-33">
										<h4><?php _e('Border Color (Hover)','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<input type="text" class='alp-control-border-color-hover' value="#0073aa" />
										</div>
									</div>

									<div class="amalinkspro-clear"></div>

								</div>

							</div>




						</div>








						<div class="alp-btn-generator-controls-section controls-background">
							<span class="toggle-indicator" aria-hidden="true"></span>
							<h3><?php _e('Customize Background','amalinkspro'); ?> <span class="title-hover-label">(<?php _e('Hover State','amalinkspro'); ?>)</span> <i class="icon-amalinkspro-up-circle"></i></h3>

							<div class="alp-btn-generator-controls-section-body">

								<div class="alp-edit-hv">
									<span class="fh-switch amalinkspro-hover-trigger">
										<input type="checkbox" name="myswitch" class="hv-panel-switch">
										<label for="switch-id">(<?php _e('Edit Hover State','amalinkspro'); ?>)</label>
										<span class="fh-switch-knob"></span>
									</span>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-33">
									<h4><?php _e('Background Type','amalinkspro'); ?></h4>
									<label>
										<input name="alp-control-background-type" class='alp-control-background-type' type="radio" value="bg-solid" /> <?php _e('Solid','amalinkspro'); ?>
									</label> 
									<label>
										<input name="alp-control-background-type" class='alp-control-background-type' type="radio" value="bg-gradient" checked="checked" /> <?php _e('Gradient','amalinkspro'); ?>
									</label>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-33">
									<h4><?php _e('Solid / Bottom Color','amalinkspro'); ?></h4>
									<div class="amalinkspro-slider-wrap">
										<input type="text" class='alp-control-bg-solid' value="#1E5799" />
									</div>
								</div>

								<div class="alp-btn-generator-col alp-btn-generator-col-bg-top  alp-btn-generator-col-33">
									<h4><?php _e('Top Color','amalinkspro'); ?></h4>
									<div class="amalinkspro-slider-wrap">
										<input type="text" class='alp-control-bg-top' value="#7db9e8" />
									</div>
								</div>

								<div class="amalinkspro-clear"></div>

								<div class="alp-btn-generator-controls-section-body-hover">

									<div class="alp-btn-generator-col alp-btn-generator-col-33">
										<h4><?php _e('Background Type (Hover)','amalinkspro'); ?></h4>
										<label><input name="alp-control-background-type-hover" class='alp-control-background-type-hover' type="radio" value="bg-solid" /> <?php _e('Solid','amalinkspro'); ?> </label> <label><input name="alp-control-background-type-hover" class='alp-control-background-type-hover' type="radio" value="bg-gradient" checked="checked" /> <?php _e('Gradient','amalinkspro'); ?></label>

									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-33">
										<h4><?php _e('Solid / Bottom Color (Hover)','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<input type="text" class='alp-control-bg-solid-hover' value="#7db9e8" />
										</div>
									</div>

									<div class="alp-btn-generator-col alp-btn-generator-col-bg-top  alp-btn-generator-col-33">
										<h4><?php _e('Top Color (Hover)','amalinkspro'); ?></h4>
										<div class="amalinkspro-slider-wrap">
											<input type="text" class='alp-control-bg-top-hover' value="#1E5799" />
										</div>
									</div>

									<div class="amalinkspro-clear"></div>

								</div>


							</div>

						</div>








					</div>

				</div>
				</div>





				<div id="alp-noapi-image-gut" class="alp-step-wrap alp-noapi">

					<?php 
					$license_check = $this->check_amalinkspro_license(); 
					$license_check = unserialize($license_check);
					//echo '$license_check: <pre>'.print_r($license_check,1).'</pre>';

					$status = get_option('amalinkspro_license_status');
					// echo '$status: <pre>'.print_r($status,1).'</pre>';
					?>

					<?php if ( $license_check->license == 'valid' && $status == 'valid' ) : ?>

				    	<form class="amalinkspro-popup-form">

				    		<h2><?php _e('Find Products by Keyword or ASIN','amalinkspro'); ?></h2>

				    		

				    			<p class="note alp-note alp-note-red">With no Amazon API Connection, if searching you will be redirected to the Amazon search results page in a new tab. After choosing your product on Amazon, paste your Site Stripe image code into the field below and click INSERT:

				    				<span class="alp-note-under"><a href="https://amalinkspro.com/no-api/" target="_blank">Click Here</a> to learn how to use AmaLinks Pro without the API.</span>

				    			</p>

				    		<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

				    			<?php $no_api_class = ' alp-no-api'; ?>

				    		<?php else: ?>

				    			<?php $no_api_class = ''; ?>

				    		<?php endif; ?>

				    		<?php
				    		$amazon_store_url = alp_paapi5_get_amazon_url_for_region();
				    		?>


				    			<input id="amalinkspro-search-keyword-noapi" name="amalinkspro-search-keyword" value="" type="text" placeholder="Enter your search term or ASIN here" />
				    			<input id="amalinkspro-search-locale-noapi" type="hidden" name="amalinkspro-search-locale" value="<?php echo $locale; ?>">
				    			<input id="amalinkspro-store-by-locale-noapi" type="hidden" name="amalinkspro-store-by-locale" value="<?php echo $amazon_store_url; ?>">


						    	<a class="button button-primary button-large js-amalinkspro-mediamodal-search amalinkspro-next-action alp-no-api alp-gut-search"><?php _e('Search','amalinkspro'); ?></a>

				    			
				    	</form>


				    	<h2>Place Amazon Affiliate SiteStripe Image Code Here</h2>
						<textarea id="alp-noapi-image-code-field-gut" placeholder="Enter your Amazon Affiliate Site Stripe Image Code Here."></textarea>

						<a class="button button-primary button-large js-alp-insert-img-html-block"><?php _e('Insert Image','amalinkspro'); ?></a>


						<div class="amalinkspro-goto-step3">
			    			<a class="js-amalinkspro-final-step final-step-noapi-image amalinkspro-final-step-btn" href="#"><?php _e('Go to Step 3','amalinkspro'); ?></a>
			    		</div>

				    <?php else : ?>

				    	<div class="amalinkspro-invalid-license-box">
				    		<?php echo '<h2>' . __('Getting Started','amalinkspro') . '</h2><p>' . __('You must activate your license on this website to create Amazon affiliate links AmaLinks Pro. If your license is expired, your current links will not stop working.','amalinkspro') . '</p><h3>' . __('Step 1','amalinkspro') . '</h3><p><a href="/wp-admin/admin.php?page=amalinkspro-welcome" target="_blank">' . __('Click Here','amalinkspro') . '</a> ' . __('to enter your Amalinks Pro software license that you received in your email receipt upon purchase. You may also find this license key by logging in to your account at','amalinkspro') . ' <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Wizard&utm_campaign=Search%20-%20No%20Valid%20License&utm_content=my-account" target="_blank">https://amalinkspro.com/my-account/</a> ' . __('and clicking the "Licenses" tab','amalinkspro') . '.</p>
								<h3>Getting Started Guide</h3>
							<iframe src="https://player.vimeo.com/video/277882173?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'; ?>
				    	</div>

				    <?php endif; ?>


				</div>





				<div id="alp-noapi-2" class="alp-step-wrap alp-noapi">

					<div id="alp-noapi-image" class="amalinkspro-popup-form">
						
						<h2>No API: Insert an Amazon Image Link</h2>
						
						<p><a href="https://amalinkspro.com/no-api/" target="_blank">Click here</a> for instructions on how to use AmaLinks Pro without an API connection.</p>

						<h3>Amazon Affiliate Image Code</h3>
						<textarea id="alp-noapi-image-code-field" placeholder="Enter your Amazon Affiliate Site Stripe Image Code Here."></textarea>


						<div class="amalinkspro-goto-step3">
			    			<a class="js-amalinkspro-final-step final-step-noapi-image amalinkspro-final-step-btn" href="#"><?php _e('Go to Step 3','amalinkspro'); ?></a>
			    		</div>


					</div>


				</div>


				<div id="alp-noapi-3" class="alp-step-wrap alp-noapi">

				
					<h2>Final Preview & Insert Link</h2>

					<div class="amalinkspro-insert-final-link">
			    		<a class="button button-primary js-amalinkspro-insert-noapi-html"><i class="icon-amalinkspro-rocket"></i>  <?php _e('Insert Image Link','amalinkspro'); ?></a>
			    	</div>


					<div id="alp-noapi-image-preview-step3" class="alp-noapi-image-preview alp-noapi-image-preview-step3 alp-step3-setting-wrap">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						<div class="amalinkspro-clear"></div>
					</div>


	    			<div class="alp-step3-setting-wrap">
		    			<h3><?php _e('Choose Alignment','amalinkspro'); ?></h3>
		    			<p><?php _e('Because of how the WordPress Editor works, sometimes the CTA buttons and showcases may not align how you want them automatically. You can control it here.','amalinkspro'); ?></p>
						<label><input name="alp-showcase-alignment-noapi" type="radio" value="alignleft"  /> <?php _e('Check this box to Align Left.','amalinkspro'); ?></label><br />
						<label><input name="alp-showcase-alignment-noapi" type="radio" value="aligncenter" /> <?php _e('Check this box to Align Center.','amalinkspro'); ?></label><br />
						<label><input name="alp-showcase-alignment-noapi" type="radio" value="alignright" /> <?php _e('Check this box to Align Right.','amalinkspro'); ?></label><br />
						<label><input name="alp-showcase-alignment-noapi" type="radio" checked=checked value="alignnone" /> <?php _e('Check this box to disable this custom alignment.','amalinkspro'); ?></label>
					</div>

			


		    		<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Link Settings','amalinkspro'); ?></h2>

		    		<p><?php _e('Your Global Link Settings have been automatically loaded. You can override them here. Your final link will be built using these options.','amalinkspro'); ?></p>

		    		<form class="amalinkspro-associate-ids-form">


			    		<div class="alp-step3-setting-wrap">
			    			<h3><?php _e('Open Links in a New Window','amalinkspro'); ?></h3>
			    			<?php 
			    			$new_window = get_option('amalinkspro-options_open_links_in_a_new_window', true);
			    			if ( $new_window ) {
			    				$checked = ' checked="checked"';
			    			} else {
			    				$checked = '';
			    			}
			    			?>
							<input id="alp-new-window-noapi" type="checkbox" value=""<?php echo $checked; ?> /><label><?php _e('Check this box to open all AmaLinks Pro links in a new window','amalinkspro'); ?></label>
						</div>

						<div class="alp-step3-setting-wrap">
			    			<h3>NoFollow Links</h3>
			    			<?php 
			    			$new_window = get_option('amalinkspro-options_nofollow_links', true);
			    			if ( $new_window ) {
			    				$checked = ' checked="checked"';
			    			} else {
			    				$checked = '';
			    			}
			    			?>
							<input id="alp-nofollow-noapi" type="checkbox" value=""<?php echo $checked; ?> /><label><?php _e('Check this box to open add a re="nofollow" tag to all AmaLinks Pro links','amalinkspro'); ?></label>
						</div>



					</form>


					<div class="amalinkspro-insert-final-link">
			    		<a class="button button-primary js-amalinkspro-insert-noapi-html"><i class="icon-amalinkspro-rocket"></i>  <?php _e('Insert Image Link','amalinkspro'); ?></a>
			    	</div>




				</div>
						



				<div id="alp-step-1" class="alp-step-wrap alp-step-wrap-active">


					<?php 
					$license_check = $this->check_amalinkspro_license(); 
					$license_check = unserialize($license_check);
					// echo '$license_check: <pre>'.print_r($license_check,1).'</pre>';

					$status = get_option('amalinkspro_license_status');
					?>

					<?php if ( $license_check->license == 'valid' && $status == 'valid' ) : ?>

				    	<form class="amalinkspro-popup-form">

				    		<?php 
				    		// need to trun this into an ajax call for the search. the new API5 function will parse the data or call the function that does
				    		$alp_api5_searchItems = alp_api5_searchItems( 'guitar', '', '1' ); 

				    		// echo alp_parse_searchItems( $alp_api5_searchItems );

				    		?>


				    		

				    		<?php 
				    		if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) {
				    			$no_api_class = ' alp-no-api';
				    			echo '<h2>STEP 1: Search Amazon (opens in new tab)</h2>';

				    			?>

				    			<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>
				    				<p class="note alp-note alp-note-red">With no Amazon API Connection, if searching you will be redirected to the Amazon search results page in a new tab. After choosing your product on Amazon, continue to step 2. <span style="font-size: 12px;font-style: italic;display: block;margin-top: 10px;"><a href="https://amalinkspro.com/no-api/" target="_blank">Click Here</a> to learn how to use AmaLinks Pro without the API.</spsan></p>
				    			<?php endif; ?>

				    			<?php
				    		} 
				    		else {
				    			$no_api_class = '';

								$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
								$associate_ids_field = 'amalinkspro-options_'.$locale.'_amazon_associate_ids';
								$associate_ids = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids' );

								//echo '<p>' . __('Your chosen Locale is','amalinkspro') . ': <strong>'.$locale.'</strong>. ' . __( 'You have associated these Amazon Associate Tracking IDs with this locale.','amalinkspro') .'</p>';

								echo '<div class="api5-choose-id">';
								echo '<h3>* Choose your Amazon Tracking ID</h3>';
								if( $associate_ids ) {
								  echo '<select id="alp-api5-select-id">';
								  for( $i = 0; $i < $associate_ids; $i++ ) {
								    $id = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_'.$i.'_associate_id' );
								    if ($i==0) {
								      echo '<option value="'.$id.'" selected="selected">'.$id.'</option>';
								    }
								    else {
								      echo '<option value="'.$id.'">'.$id.'</option>';
								    }
								  }
								  echo '</select>';
								}
								echo '</div>';



				    			echo '<h2>Find Products by Keyword or ASIN</h2>';
				    		}

				    		$amazon_store_url = alp_paapi5_get_amazon_url_for_region();

				    		?>



				    		<p>
				    			<input id="amalinkspro-search-keyword" name="amalinkspro-search-keyword" value="" type="text" placeholder="Enter your search term or ASIN here" />
				    			<input id="amalinkspro-search-locale" type="hidden" name="amalinkspro-search-locale" value="<?php echo $locale; ?>">
				    			<input id="amalinkspro-store-by-locale" type="hidden" name="amalinkspro-store-by-locale" value="<?php echo $amazon_store_url; ?>">


				    			<a class="button button-primary button-large js-amalinkspro-mediamodal-search amalinkspro-next-action<?php echo $no_api_class; ?>"><?php _e('Search','amalinkspro'); ?></a>

				    			<img class="amalinkspro-search-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" />
				    		</p>


				    		<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

				    			<h2 class="noapi-h2">STEP 2: Choose a Non-API Link Type</h2>

				    			<div class="note alp-note" style="background: #f1f1f1;position: relative;"><div class="alp-note-buttons"><a href="#" class="alp-js-noapi-image"><i class="icon-amalinkspro-image-link"></i> Product Image</a><a href="#" class="alp-js-noapi-showcase"><i class="icon-amalinkspro-info-block"></i> Product Showcase </a><a href="#" class="alp-js-noapi-ctabutton"><i class="icon-amalinkspro-cta-link"></i>CTA Button </a></div><span class="alp-clear"></span><?php echo '<img class="non-api-beta" src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/amalinks-pro-table-builder-add-on-beta-flag.png" alt="AmaLinks Pro - Non-API Features - BETA" />'; ?></div>

				    			<?php $no_api_class = ' alp-no-api'; ?>

				    		<?php endif; ?>

				    		<?php 
				    		// if ( !get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) {
					    		do_action('alp_addon_tablebuilder_start'); 
					    	// }
				    		?>
				    			
				    	</form>

				    	<div class="amalinkspro-search-results">

				    		<h2><?php _e('Your Amazon Search Results','amalinkspro'); ?></h2>

				    		<div class="amalinkspro-search-pagination">
								<span class="alp-search-page current" data-api-page="1" data-api-term="guitar" data-api-locale="US"><?php _e('Page','amalinkspro'); ?> 1</span>
								<span class="alp-search-page" data-api-page="2" data-api-term="guitar" data-api-locale="US">2</span>
								<span class="alp-search-page" data-api-page="3" data-api-term="guitar" data-api-locale="US">3</span>
								<span class="alp-search-page" data-api-page="4" data-api-term="guitar" data-api-locale="US">4</span>
								<span class="alp-search-page" data-api-page="5" data-api-term="guitar" data-api-locale="US">5</span>
							</div>

				    		<div class="amalinkspro-search-results-list" data-alp-search-page=""></div>

				    		<div class="amalinkspro-search-pagination">
								<span class="alp-search-page current" data-api-page="1" data-api-term="guitar" data-api-locale="US"><?php _e('Page','amalinkspro'); ?> 1</span>
								<span class="alp-search-page" data-api-page="2" data-api-term="guitar" data-api-locale="US">2</span>
								<span class="alp-search-page" data-api-page="3" data-api-term="guitar" data-api-locale="US">3</span>
								<span class="alp-search-page" data-api-page="4" data-api-term="guitar" data-api-locale="US">4</span>
								<span class="alp-search-page" data-api-page="5" data-api-term="guitar" data-api-locale="US">5</span>
							</div>

				    		
				    	</div>

				    <?php else : ?>

				    	<div class="amalinkspro-invalid-license-box">
				    		<?php echo '<h2>' . __('Getting Started','amalinkspro') . '</h2><p>' . __('You must activate your license on this website to create Amazon affiliate links AmaLinks Pro. If your license is expired, your current links will not stop working.','amalinkspro') . '</p><h3>' . __('Step 1','amalinkspro') . '</h3><p><a href="/wp-admin/admin.php?page=amalinkspro-welcome" target="_blank">' . __('Click Here','amalinkspro') . '</a> ' . __('to enter your Amalinks Pro software license that you received in your email receipt upon purchase. You may also find this license key by logging in to your account at','amalinkspro') . ' <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Wizard&utm_campaign=Search%20-%20No%20Valid%20License&utm_content=my-account" target="_blank">https://amalinkspro.com/my-account/</a> ' . __('and clicking the "Licenses" tab','amalinkspro') . '.</p>
								<h3>Getting Started Guide</h3>
							<iframe src="https://player.vimeo.com/video/277882173?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'; ?>
				    	</div>

				    <?php endif; ?>

			    </div>



			    <div id="alp-step-2" class="alp-step-wrap">


			    	


		    		<?php $amalinkspro_modal = new amalinkspro_modal_content(); ?>


		    		<?php // Get our chosen Amazon product preview
			    	echo $amalinkspro_modal->alp_get_chosen_prod_prev(); ?>
		    		

		    		<div class="amalinkspro-choose-link-type-wrap">
		    			<?php // Get out link type choices
			    		echo $amalinkspro_modal->alp_get_link_type_btns(); ?>
			    	</div>


			    	<div class="amalinkspro-clear"></div>


			    	<div class="amalinkspro-linktype-preview-boxes">
			    	
			    		<?php // Our step 2 preview of the plain text link
			    		echo $amalinkspro_modal->alp_get_text_link_preview(); ?>

			    		<?php // Our step 2 preview of the image link
			    		echo $amalinkspro_modal->alp_get_img_link_preview(); ?>

			    		<?php // Our step 2 preview of the CTA button 
			    		echo $amalinkspro_modal->alp_get_cta_btn_preview(); ?>
						
						<?php 
						// Our step 2 preview of the showcase link
						echo $amalinkspro_modal->alp_get_showcase_previewbox(); ?>

			    	</div>




		    		<div class="amalinkspro-goto-step3">
		    			<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Are you happy with your AmaLink Configuration?','amalinkspro'); ?></h2>
		    			<a class="js-amalinkspro-final-step amalinkspro-final-step-btn" href="#"><?php _e('Go to Step 3','amalinkspro'); ?></a>
		    		</div>
			    	

			    </div>
			    <?php // END #alp-step-2 ?>






			    <div id="alp-step-3" class="alp-step-wrap">

			    	<div class="amalinkspro-insert-final-link">

			    		<a class="button button-primary js-amalinkspro-insert-final-link-shortcode"><i class="icon-amalinkspro-rocket"></i> <?php _e('Insert Shortcode','amalinkspro'); ?></a>
			    		<a class="button button-secondary js-amalinkspro-insert-final-link-html"><?php _e('Insert Link','amalinkspro'); ?></a>

			    	</div>


				    <div class="alp-step3-final-preview"></div>


				    <div class="alp-showcase-settings">
				    	
				    	<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Showcase Settings','amalinkspro'); ?></h2>

		    			<p><?php _e('Here are a few extra showcase settings.','amalinkspro'); ?></p>

		    			<div class="alp-step3-setting-wrap">
			    			<h3><?php _e('Showcase Width','amalinkspro'); ?></h3>
			    			<p><?php _e('Choose a width between 280px and 1200px. Default is 750px.','amalinkspro'); ?></p>
							<input id="alp-showcase-width" type="number" value="750" min="280" max="1200"  /> <label><strong>px</strong></label>
						</div>


				    </div>

				    <div class="alp-textlink-settings">
				    	
				    	<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Text Link Settings','amalinkspro'); ?></h2>

		    			<p><?php _e('Here are a few extra text link settings.','amalinkspro'); ?></p>

		    			<div class="alp-step3-setting-wrap">
			    			<h3><?php _e('Wrap in Paragraph','amalinkspro'); ?></h3>
			    			<p><?php _e('Because of how the WordPress Editor works, you must check this box to have your link on it\'s own line.','amalinkspro'); ?></p>
							<input id="alp-showcase-textlink-p" type="checkbox" value="" /><label><?php _e('Check this box to wrap a paragraph tag around your affiliate link.','amalinkspro'); ?></label>
						</div>

				    </div>

				    <div class="alp-alignment-settings">
				    	
				    	<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Alignment Settings','amalinkspro'); ?></h2>

		    			<p><?php _e('Here are a few extra alignment settings for the Image Links, CTA Buttons and the Showcases.','amalinkspro'); ?></p>

		    			<div class="alp-step3-setting-wrap">
			    			<h3><?php _e('Choose Alignment','amalinkspro'); ?></h3>
			    			<p><?php _e('Because of how the WordPress Editor works, sometimes the CTA buttons and showcases may not align how you want them automatically. You can control it here.','amalinkspro'); ?></p>
							<label><input name="alp-showcase-alignment" type="radio" value="alignleft"  /> <?php _e('Check this box to Align Left.','amalinkspro'); ?></label><br />
							<label><input name="alp-showcase-alignment" type="radio" value="aligncenter" /> <?php _e('Check this box to Align Center.','amalinkspro'); ?></label><br />
							<label><input name="alp-showcase-alignment" type="radio" value="alignright" /> <?php _e('Check this box to Align Right.','amalinkspro'); ?></label><br />
							<label><input name="alp-showcase-alignment" type="radio" value="alignnone" /> <?php _e('Check this box to disable this custom alignment.','amalinkspro'); ?></label>
						</div>

				    </div>


		    		<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Link Settings','amalinkspro'); ?></h2>

		    		<p><?php _e('Your Global Link Settings have been automatically loaded. You can override them here. Your final link will be built using these options.','amalinkspro'); ?></p>

		    		<form class="amalinkspro-associate-ids-form">


		    			<div class="alp-step3-setting-wrap amalinkspro-choose-associate-id-wrap" style="display: none;">

		    				<h3 style="display: none;"><?php _e('Choose Your Affiliate ID','amalinkspro'); ?></h3>

		    				<?php 
		    				$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
		    				$associate_ids_field = 'amalinkspro-options_'.$locale.'_amazon_associate_ids';
		    				$associate_ids = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids' );

		    				//echo '<p>' . __('Your chosen Locale is','amalinkspro') . ': <strong>'.$locale.'</strong>. ' . __( 'You have associated these Amazon Associate Tracking IDs with this locale.','amalinkspro') .'</p>';

							if( $associate_ids ) {
								echo '<select class="amalinkspro-choose-associate-id-select" style="display: none;">';
								for( $i = 0; $i < $associate_ids; $i++ ) {
									$id = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_'.$i.'_associate_id' );
									if ($i==0) {
										echo '<option value="'.$id.'" selected="selected">'.$id.'</option>';
									}
									else {
										echo '<option value="'.$id.'">'.$id.'</option>';
									}
								}
								echo '</select>';
							}
		    				?>
		    				
		    			</div>

			    		<div class="alp-step3-setting-wrap">
			    			<h3><?php _e('Open Links in a New Window','amalinkspro'); ?></h3>
			    			<?php 
			    			$new_window = get_option('amalinkspro-options_open_links_in_a_new_window', true);
			    			if ( $new_window ) {
			    				$checked = ' checked="checked"';
			    			} else {
			    				$checked = '';
			    			}
			    			?>
							<input id="alp-new-window" type="checkbox" value=""<?php echo $checked; ?> /><label><?php _e('Check this box to open all AmaLinks Pro links in a new window','amalinkspro'); ?></label>
						</div>

						<div class="alp-step3-setting-wrap">
			    			<h3>NoFollow Links</h3>
			    			<?php 
			    			$new_window = get_option('amalinkspro-options_nofollow_links', true);
			    			if ( $new_window ) {
			    				$checked = ' checked="checked"';
			    			} else {
			    				$checked = '';
			    			}
			    			?>
							<input id="alp-nofollow" type="checkbox" value=""<?php echo $checked; ?> /><label><?php _e('Check this box to open add a re="nofollow" tag to all AmaLinks Pro links','amalinkspro'); ?></label>
						</div>

						<div class="alp-step3-setting-wrap">
			    			<h3><?php _e('Add to Cart','amalinkspro'); ?></h3>
			    			<?php 
			    			$new_window = get_option('amalinkspro-options_add_to_cart', true);
			    			if ( $new_window ) {
			    				$checked = ' checked="checked"';
			    			} else {
			    				$checked = '';
			    			}
			    			?>
			    			<p><?php _e('By enabling this feature, all AmaLinks Pro links will become Amazon "Add to Cart" links. When a visitor adds an item to their cart after clicking your link, you get an extra 89 day cookie set on the visitor\'s browser, giving you 3 extra months to get the commission.','amalinkspro'); ?></p>
							<input id="alp-addtocart" type="checkbox" value=""<?php echo $checked; ?> /><label><?php _e('I want AmaLinks Pro to have my links add a product to a visitor\'s Amazon cart','amalinkspro'); ?></label>
						</div>


					</form>


					<div class="amalinkspro-insert-final-link">

			    		<a class="button button-primary js-amalinkspro-insert-final-link-shortcode"><i class="icon-amalinkspro-rocket"></i> <?php _e('Insert Shortcode','amalinkspro'); ?></a>
			    		<a class="button button-secondary js-amalinkspro-insert-final-link-html"><?php _e('Insert Link','amalinkspro'); ?></a>

			    	</div>



				</div>




				<?php do_action('alp_addon_tablebuilder_step_wrap'); ?>
				




			</div> <?php // end #amalinkspro-media-window-content ?>

			<?php do_action('amalinkspro_tablebuilder'); ?>

		
	     </div> <?php // end #amalinkspro-media-window ?>






	<?php
	}  


	

    // #paapi5



	public function amazon_api_connection_test() {

		// make our amazon api call

		echo '<div class="amazon-api-test-message-inner">';


		if( ini_get('allow_url_fopen') ) {
			echo '<p>Making API call using file_get_contents()</p>';
		}
		else {
			echo '<p>Making API using WP_Curl - We recommend having your website hosting turn on "allow_url_fopen" in your server\'s PHP settings';
		}

		$alp_api5_search_results = alp_api5_searchItems( 'guitar', '', '1' );


		if ($alp_api5_search_results) {

			if ( $alp_api5_search_results['status'] && $alp_api5_search_results['status'] == 'error' ) {
				echo '<p style="color: red;font-weight: bold;">There was an error with your Amazon PA-API5 connection. This error message comes directly from Amazon. Please refer to the "Error Message" from Amazon below for troubleshooting help.</p>';
				echo '<pre style="background:pink;padding: 15px;white-space: pre-wrap;">'.$alp_api5_search_results['error'].'</pre>';
			}

			else {

				// echo '$alp_api5_search_results: <pre>'.print_r($alp_api5_search_results,1).'</pre>';

				if ( $alp_api5_search_results['searchResult'] ) {
					echo '<p class="amalinkspro-success-message">Amazon API Connection was Successful!</p>';
					echo '<p class="amalinkspro-success-message">'.$alp_api5_search_results['searchResult']['totalResultCount'].' results returned for this test search.</p>';
				}
				else {
					echo '<p class="amalinkspro-error-message">There was an unknown error connecting to the PA-API5.</p>';
				}

			}


			// echo '$alp_api5_search_results: <pre>'.print_r($alp_api5_search_results,1).'</pre>';
		}

		die();

		if ( $api_response ) {

			

			$arr = simplexml_load_string($api_response);

			echo '<p class="amalinkspro-success-message">Amazon API Connection was Successful!</p>';


			$arguments = $arr->OperationRequest->Arguments->Argument;

			$api_key_name = $arguments[0]['Name'];
			$api_key_value = $arguments[0]['Value'];

			echo '<strong>' . $api_key_name . ': </strong> ' . $api_key_value . '<br />';


			$api_key_name = $arguments[1]['Name'];
			$api_key_value = $arguments[1]['Value'];

			echo '<strong>' . $api_key_name . ':</strong> ' . $api_key_value. '<br />';


			$api_key_name = $arguments[6]['Name'];
			$api_key_value = $arguments[6]['Value'];

			echo '<strong>' . $api_key_name . ':</strong> ' . $api_key_value. '<br />';

			$api_key_name = $arguments[6]['Name'];
			$api_key_value = $arguments[6]['Value'];

			echo '<strong>' . 'Request Processing Time:</strong> ' . $arguments = $arr->OperationRequest->RequestProcessingTime . ' seconds';

		}

		else {
			echo '<p class="amalinkspro-error-message">There was a problem connecting to Amazon. Please check your Amazon credentials.</p>';

		}

		echo '</div>';

		die();




	}



	public function amalinkspro_load_premade_cta_buttons() {

		global $wpdb;
		?>


		<div id="amalinkspro-choose-cta-btn" class="amalinkspro-choose-cta-btn">

			<span class="amalinkspro-close-cta-button-choser"></span>

			<?php
			$buttons = get_option( 'amalinkspro_cta_buttons' );

			//echo '$buttons - '.$buttons;

			if( $buttons != null ) {

			  echo '<h3>' . __('or','amalinkspro') .' ... ' . __('Choose a Premade Button</h3>','amalinkspro');

			  echo '<div class="amalinkspro-choose-cta-btn-list">';

			  for( $i = 0; $i <= $buttons; $i++ ) {


			  	$id   = get_option( 'amalinkspro_cta_buttons_' . $i . '_button_id ' );
			    $data = get_option( 'amalinkspro_cta_buttons_' . $i . '_button_data' );

			    //echo '<pre>'.print_r($data,1).'</pre>';

			    if ($data) {

			    	$btn_css_string = '';
			    	$btn_css_string_hover = '';

			    	foreach ( $data as $key => $data  ) {

			    		if ($key == 'text') {
			    			//echo 'text - <pre>'.print_r($val,1).'</pre>';

			    			$font_family_type = $data['font-family-type'];

			    			if ( $font_family_type == 1 ) {
			    				$btn_css_string .= 'font-family:' . $data['font-family-google'] . ';';
			    			}
			    			else {
			    				$btn_css_string .= 'font-family:' . $data['font-family'] . ';';
			    			}

						    $btn_css_string .= 'font-size:' . $data['font-size'] . 'px;';
						    $btn_css_string .= 'color:' . $data['font-color'] . ';';


						    $btn_css_string_hover .= ' data-alp-textshadow-enable="'.$data['textshadow-enable'].'"';

						    if ( $data['textshadow-enable'] == 'on' ) {
						    	$btn_css_string .= 'text-shadow:' . $data['textshadow-x'] . 'px ' . $data['textshadow-y'] . 'px ' . $data['textshadow-blur'] . 'px ' . $data['textshadow-color'] . ';';

						    	$btn_css_string_hover .= ' data-alp-textshadow-h="' . $data['textshadow-x-h'] . 'px ' . $data['textshadow-y-h'] . 'px ' . $data['textshadow-blur-h'] . 'px ' . $data['textshadow-color-h'] . '"';
						    }
							   
						    $btn_css_string_hover .= ' data-alp-fontsize-h="' . $data['font-size-h'] . 'px"';
						    $btn_css_string_hover .= ' data-alp-fontcolor-h="' . $data['font-color-h'] . '"';
							    

			    		}

			    		elseif ($key == 'box') {
			    			//echo 'box - <pre>'.print_r($val,1).'</pre>';

			    			//echo '$data<pre>'.print_r($data,1).'</pre>';


			    			$btn_css_string .= 'padding:' . $data['padding-t'] . 'px ' . $data['padding-r'] . 'px ' . $data['padding-b'] . 'px ' . $data['padding-l'] . 'px;';

			    			$btn_css_string_hover .= ' data-alp-boxshadow-enable="'.$data['boxshadow-enable'].'"';

			    			if ( $data['boxshadow-enable'] == 'on' ) {
			    				$btn_css_string .= 'box-shadow:' . $data['boxshadow-x'] . 'px ' . $data['boxshadow-y'] . 'px ' . $data['boxshadow-blur'] . 'px ' . $data['boxshadow-color'] . ';';

							    $btn_css_string_hover .= ' data-alp-boxshadow-h="' . $data['boxshadow-x-h'] . 'px ' . $data['boxshadow-y-h'] . 'px ' . $data['boxshadow-blur-h'] . 'px ' . $data['boxshadow-color-h'] . '"';
			    			}

			    			$btn_css_string_hover .= 'data-alp-padding-h="' . $data['padding-t-h'] . 'px ' . $data['padding-r-h'] . 'px ' . $data['padding-b-h'] . 'px ' . $data['padding-l-h'] . 'px"';

			    		}

			    		elseif ($key == 'border') {
			    			//echo 'border - <pre>'.print_r($val,1).'</pre>';


			    			$btn_css_string .= 'border-radius:' . $data['border-radius'] . 'px;';
			    			$btn_css_string .= 'border:' . $data['border-width'] . 'px solid ' . $data['border-color'] . ';';

			    			$btn_css_string_hover .= ' data-alp-border-radius-h="' . $data['border-radius-h'] . 'px"';
			    			$btn_css_string_hover .= ' data-alp-border-h="' . $data['border-width-h'] . 'px solid ' . $data['border-color-h'] . '"';

			    		}

			    		elseif ($key == 'background') {

			    			if ( $data['bg-type'] == 'bg-gradient' ) {
			    				$btn_css_string .= 'background: ' . $data['bg-solid-color'] . ';';
			    				// $btn_css_string .= 'background: -moz-linear-gradient(top, ' . $data['bg-top-color']  . ' 0%, ' . $data['bg-solid-color'] . ' 100%);';
			    				// $btn_css_string .= 'background: -webkit-linear-gradient(top, ' . $data['bg-top-color'] . ' 0%, ' . $data['bg-solid-color'] . ' 100%);';
			    				$btn_css_string .= 'background: linear-gradient(to bottom, ' . $data['bg-top-color'] . ' 0%, ' . $data['bg-solid-color'] . ' 100%);';
			    			}
			    			else {
			    				$btn_css_string .= 'background: ' . $data['bg-solid-color'] . ';';
			    			}


			    			if ( $data['bg-type-h'] == 'bg-gradient' ) {
			    				$btn_css_string_hover .= ' data-alp-bg-h="';
			    				$btn_css_string_hover .= 'linear-gradient(to bottom, ' . $data['bg-top-color-h'] . ' 0%, ' . $data['bg-solid-color-h'] . ' 100%)';
			    				$btn_css_string_hover .= '"';
			    			}
			    			else {
			    				$btn_css_string_hover .= 'data-alp-bg-h="' . $data['bg-solid-color-h'] . '"';
			    			}


							


			    		}


			    		//echo '<pre>'.print_r($btn,1).'</pre>';
			    	}

			    }


            	if ( get_option('amalinkspro-options_cta_btn_default_text') ) {
            		$btn_text = get_option('amalinkspro-options_cta_btn_default_text');
            	}
            	else {
            		$btn_text = 'Buy on Amazon';
            	}


			    echo '<div class="alp-button-id" data-btn-id="'.$id.'">';
			     	echo '<span class="amalinkspro-js-choose-btn amalinkspro-choose-btn">Select</span>';
			     	echo '<span class="amalinkspro-js-load-btn amalinkspro-choose-btn">Edit</span>';
			     	echo '<a class="amalinkspro-css-button amalinkspro-css-button-admin" href="#" style="'.$btn_css_string.'" '.$btn_css_string_hover.'>'.$btn_text.'</a>';
			    echo '</div>';
			    
			  }

			  echo '</div> <!-- END .amalinkspro-choose-cta-btn-list -->';
			}

			else {
				//echo '<p class="amalinkspro-choose-cta-btn-list no-btns-yet">You have not created any buttons yet, go ahead!</p>';
			}

			

			?>

		</div>
	<?php

	die();

	}



	public function amalinkspro_get_cta_button_styles() {

		global $wpdb;

		if ( isset( $_POST['btn_id'] ) ) {
			$btn_id = $_POST['btn_id'];
			$data = get_option( 'amalinkspro_cta_buttons_' . $btn_id . '_button_data' );
			$data = json_encode( $data );
			echo $data;
		}
		else { echo 'error'; }

		die();
	}







	// Performs an API5 Product Search and returns the json #paapi5

	function alp_paapi5_get_products() {


		global $wpdb; // this is how you get access to the database

		$term = $_POST['term'];
	    $locale = $_POST['locale'];
	    $aff_id = $_POST['aff_id'];
	    $page = '1';
	    if ( $_POST['page'] ) {
	    	$page = $_POST['page'];
	    }

		$alp_api5_search_results = alp_api5_searchItems( $term, $aff_id, $page );

		

		// if ( $parse == true ) {

		// 	echo alp_parse_searchItems( $alp_api5_search_results );

		// }
		// else {

		if ( $alp_api5_search_results && $alp_api5_search_results['status'] && $alp_api5_search_results['status'] == 'error' ) {

			usleep(1000000);
			$alp_api5_search_results = alp_api5_searchItems( $term, $aff_id, $page );

			if ( $alp_api5_search_results && $alp_api5_search_results['status'] && $alp_api5_search_results['status'] == 'error' ) {
				echo '<pre style="background:pink;padding: 15px;white-space: pre-wrap;">'.$alp_api5_search_results['error'].'</pre>';
			}
			else {
		    	echo $alp_api5_search_results;
		    }

	        
	    }
	    else {
	    	echo $alp_api5_search_results;
	    }

		// }

		die();

	}


	// Performs an API5 Product Search and returns the json #paapi5

	function alp_paapi5_get_products_info() {


		global $wpdb; // this is how you get access to the database

		$asin = $_POST['asin'];
	    $asins = array($asin);

	    // $asins = array('B07DVVCN83');

		$alp_api5_get_item_result = alp_api5_getItems( $asins );

		

		if ( $alp_api5_search_results && $alp_api5_search_results['status'] && $alp_api5_search_results['status'] == 'error' ) {

			usleep(1000000);
			$alp_api5_search_results = alp_api5_searchItems( $term, '', $page );

			if ( $alp_api5_search_results && $alp_api5_search_results['status'] && $alp_api5_search_results['status'] == 'error' ) {
				echo '<pre style="background:pink;padding: 15px;white-space: pre-wrap;">'.$alp_api5_search_results['error'].'</pre>';
			}
			else {
		    	echo $alp_api5_search_results;
		    }

	        
	    }
	    else {
	    	echo $alp_api5_search_results;
	    }

		die();

	}





	public function alp_save_cta_button() {

		global $wpdb;

		//echo '<pre>'.print_r($_POST,1).'</pre>';

		// exit early if something is missing
		if ( !isset( $_POST['alp_cta_btn_styles_json'] ) ) {
			echo 'error 1 - no button styles';
			die();
		}

		if ( !isset( $_POST['button_id'] ) ) {
			echo 'error 2 - no button id';
			die();
		}

		$alp_cta_btn_styles = $_POST['alp_cta_btn_styles_json'];
		$button_id          = $_POST['button_id'];

			
		$new_id_row = 'amalinkspro_cta_buttons_' . $button_id . '_button_id';
		$new_data_row = 'amalinkspro_cta_buttons_' . $button_id . '_button_data';

		update_option( $new_id_row, $button_id);
		update_option( $new_data_row, $alp_cta_btn_styles);

		$curr_btns = get_option('amalinkspro_cta_buttons');

		echo '$curr_btns: '.$curr_btns;

		if ( $curr_btns!== false ) {

			echo 'it thinks there is an option!';
			if ( $button_id > get_option('amalinkspro_cta_buttons') ) {
				update_option( 'amalinkspro_cta_buttons', $button_id);
			}
		}
		else {
			echo 'no option saved yet ...!';
			update_option( 'amalinkspro_cta_buttons', '0');
		}


			

		echo 'success';
		die();

	}




	function welcome_screen_do_activation_redirect() {
	  // Bail if no activation redirect
	  if ( ! get_transient( '_amalinkspro_welcome_screen_activation_redirect' ) ) {
	    return;
	  }

	  // Delete the redirect transient
	  delete_transient( '_amalinkspro_welcome_screen_activation_redirect' );

	  // Bail if activating from network, or bulk
	  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
	    return;
	  }

	  // Redirect to bbPress about page
	  wp_safe_redirect( add_query_arg( array( 'page' => 'amalinkspro-welcome' ), admin_url( 'admin.php' ) ) );

	}





	public function amazon_api_get_store_url_ajax() {

		global $wpdb;

		$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );

		// The region you are interested in
		if ( $locale == 'US' ) {
			$amazon_store_url = "amazon.com";
		}
		else if ( $locale == 'UK' ) {
			$amazon_store_url = "amazon.co.uk";
		}
		else if ( $locale == 'BR' ) {
			$amazon_store_url = "amazon.com.br";
		}
		else if ( $locale == 'CA' ) {
			$amazon_store_url = "amazon.ca";
		}
		else if ( $locale == 'CN' ) {
			$amazon_store_url = "amazon.cn";
		}
		else if ( $locale == 'FR' ) {
			$amazon_store_url = "amazon.fr";
		}
		else if ( $locale == 'DE' ) {
			$amazon_store_url = "amazon.de";
		}
		else if ( $locale == 'IN' ) {
			$amazon_store_url = "amazon.in";
		}
		else if ( $locale == 'IT' ) {
			$amazon_store_url = "amazon.it";
		}
		else if ( $locale == 'JP' ) {
			$amazon_store_url = "amazon.co.jp";
		}
		else if ( $locale == 'ES' ) {
			$amazon_store_url = "amazon.es";
		}
		else if ( $locale == 'MX' ) {
			$amazon_store_url = "amazon.com.mx";
		}
		else if ( $locale == 'AU' ) {
			$amazon_store_url = "amazon.com.au";
		}

		else {
			$amazon_store_url = "amazon.com";
		}

		echo $amazon_store_url;
		die();

	}




	function amalinkspro_head_script_variables() {

		echo '<script>';

			echo 'var amalinkspro_plugin_url = "' . plugins_url() . '";';

		echo '</script>';

	}



	function amalinkspro_head_admin_styles() {



		if ( get_option('amalinkspro-options_enable_custom_cta_color_showcase') == 1 ) :

			ob_start();

			echo '<style type="text/css" class="amalinkspro-admin-css">';


				if ( get_option('amalinkspro-options_choose_button_text_color_showcase') || get_option('amalinkspro-options_choose_button_text_color_showcase') || get_option('amalinkspro-options_choose_button_border_color_showcase') ) :
				
					echo 'body .amalinkspro-media-window-content .amalinkspro-showcase-preview.amalinkspro-showcase-4 .amalinkspro-showcase-bottom-cta .icon-amalinkspro-edit{';

						if ( get_option('amalinkspro-options_choose_button_color_showcase') ) :
							echo 'background:'.get_option('amalinkspro-options_choose_button_color_showcase').';';
						endif;

						if ( get_option('amalinkspro-options_choose_button_text_color_showcase') ) :
							echo 'color:'.get_option('amalinkspro-options_choose_button_text_color_showcase').'!important;';
						endif;

						if ( get_option('amalinkspro-options_choose_button_border_color_showcase') ) :
							echo 'border-color:'.get_option('amalinkspro-options_choose_button_border_color_showcase').'!important;';
						endif;

					echo '}';

				endif;

				if ( get_option('amalinkspro-options_choose_button_color_hover_showcase') || get_option('amalinkspro-options_choose_button_text_color_hover_showcase') || get_option('amalinkspro-options_choose_button_border_color_hover_showcase') ) :
				
					echo 'body .amalinkspro-media-window-content .amalinkspro-showcase-preview.amalinkspro-showcase-4 .amalinkspro-showcase-bottom-cta .icon-amalinkspro-edit:hover{';

						if ( get_option('amalinkspro-options_choose_button_color_hover_showcase') ) :
							echo 'background:'.get_option('amalinkspro-options_choose_button_color_hover_showcase').';';
						endif;

						if ( get_option('amalinkspro-options_choose_button_text_color_hover_showcase') ) :
							echo 'color:'.get_option('amalinkspro-options_choose_button_text_color_hover_showcase').'!important;';
						endif;

						if ( get_option('amalinkspro-options_choose_button_border_color_hover_showcase') ) :
							echo 'border-color:'.get_option('amalinkspro-options_choose_button_border_color_hover_showcase').'!important;';
						endif;

					echo '}';

				endif;


				if ( get_option('amalinkspro-options_showcase_btn_font_size') || 
					get_option('amalinkspro-options_showcase_button_font_style') || 
					get_option('amalinkspro-options_showcase_btn_padding_top') || 
					get_option('amalinkspro-options_showcase_btn_padding_right') || 
					get_option('amalinkspro-options_showcase_btn_padding_bottom') || 
					get_option('amalinkspro-options_showcase_btn_padding_left') ) :
				
					echo '.amalinkspro-media-window-content .amalinkspro-showcase-preview.amalinkspro-showcase-4 .amalinkspro-showcase-bottom-cta-link {';

						if ( get_option('amalinkspro-options_showcase_btn_font_size') ) :
							echo 'font-size:'.get_option('amalinkspro-options_showcase_btn_font_size').'px;';
						endif;

						if ( get_option('amalinkspro-options_showcase_button_font_style') ) :

							if ( get_option('amalinkspro-options_showcase_button_font_style') == 'bold' ) :
								echo 'font-weight:'. get_option('amalinkspro-options_showcase_button_font_style').';';
							elseif ( get_option('amalinkspro-options_showcase_button_font_style') == 'italic' ) :
								echo 'font-style:'. get_option('amalinkspro-options_showcase_button_font_style').';';
							elseif ( get_option('amalinkspro-options_showcase_button_font_style') == 'normal' ) :
								echo 'font-style:'. get_option('amalinkspro-options_showcase_button_font_style').';';
							endif;
							
						endif;


						if ( get_option('amalinkspro-options_showcase_btn_padding_top') || 
							get_option('amalinkspro-options_showcase_btn_padding_right') || 
							get_option('amalinkspro-options_showcase_btn_padding_bottom') || 
							get_option('amalinkspro-options_showcase_btn_padding_left') ) :

						endif;

						if ( get_option('amalinkspro-options_showcase_btn_padding_top') ) :
							echo 'padding-top:'.get_option('amalinkspro-options_showcase_btn_padding_top').'px;';
						endif;
						if ( get_option('amalinkspro-options_showcase_btn_padding_right') ) :
							echo 'padding-right:'.get_option('amalinkspro-options_showcase_btn_padding_right').'px;';
						endif;
						if ( get_option('amalinkspro-options_showcase_btn_padding_bottom') ) :
							echo 'padding-bottom:'.get_option('amalinkspro-options_showcase_btn_padding_bottom').'px;';
						endif;
						if ( get_option('amalinkspro-options_showcase_btn_padding_left') ) :
							echo 'padding-left:'.get_option('amalinkspro-options_showcase_btn_padding_left').'px;';
						endif;

					echo '}';

				endif;



			echo '</style>';

			$buffer = ob_get_clean();

			// Minify CSS
			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
			$buffer = str_replace(': ', ':', $buffer);
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

			echo $buffer;

		endif;

	

	}




	/**
	 * Clears the license checking transient
	 *
	 * @since    1.0.0
	 */
	public function amalinkspro_clear_transient() {

		global $wpdb;

		// our transient name
		$transient = 'amalinkspro_license_check_transient_arr_2';
		// delete for our transient
		delete_transient( $transient );

		die();


	}




	









}
