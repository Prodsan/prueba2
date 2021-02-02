<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/includes
 * @author     Your Name <email@amalinkspro.com>
 */
class Ama_Links_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ama_Links_Pro_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Ama_Links_Pro    The string used to uniquely identify this plugin.
	 */
	protected $Ama_Links_Pro;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'Ama_Links_Pro_VERSION' ) ) {
			$this->version = Ama_Links_Pro_VERSION;
		} else {
			$this->version = '1.5.7';
		}
		$this->Ama_Links_Pro = 'amalinkspro';
		
		// EDD Constants
		$this->edd_product = 'AmaLinks Pro';
		$this->edd_store = 'https://amalinkspro.com';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ama_Links_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - Ama_Links_Pro_i18n. Defines internationalization functionality.
	 * - Ama_Links_Pro_Admin. Defines all hooks for the admin area.
	 * - Ama_Links_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amalinkspro-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amalinkspro-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-amalinkspro-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-amalinkspro-public.php';

		/**
		 * Include ACF
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/advanced-custom-fields-pro/acf.php';

		/**
		 * The class responsible for all of our Amazon API Requests
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amalinkspro-amazon-functions.php';

		/**
		 * The class responsible for all of our Google Fonts Integration
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amalinkspro-google-fonts.php';


		/**
		 * The class responsible for all of our Google Fonts Integration
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/amalinkspro-modal.php';


		// #paapi5
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/paapi5-php-sdk/vendor/autoload.php';



		// API5 helper functions
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/alp-paapi5/alp-paapi5-helpers.php';

		// API5 product search
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/alp-paapi5/alp-paapi5-searchItems.php';

		// API5 product get item
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/alp-paapi5/alp-paapi5-getItem.php';
		




		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/gutenberg/alp-gutenberg.php';



		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/amalinkspro/plugin.php';

		

		// require_once( WP_PLUGIN_DIR . '/../../wp-includes/rss.php');

		/**
		 * The class responsible for adding our automatic EDD plugin updater
		 * side of the site.
		 */
		if( !class_exists( 'AMALINKSPRO_Plugin_Updater' ) ) {
			// load our custom updater
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/AMALINKSPRO_Plugin_Updater.php';
		}

		$this->loader = new Ama_Links_Pro_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ama_Links_Pro_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ama_Links_Pro_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ama_Links_Pro_Admin( $this->get_Ama_Links_Pro(), $this->get_version(), $this->edd_product, $this->edd_store );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'acf/settings/path', $plugin_admin, 'amalinkspro_acf_settings_path');
		$this->loader->add_filter( 'acf/settings/dir', $plugin_admin, 'amalinkspro_acf_settings_dir');



		$this->loader->add_filter( 'admin_init', $plugin_admin, 'welcome_screen_do_activation_redirect');

		// $this->loader->add_filter( 'admin_menu', $plugin_admin, 'welcome_screen_pages');

		// $this->loader->add_filter( 'admin_head', $plugin_admin, 'welcome_screen_remove_menus');


		$this->loader->add_action( 'wp_ajax_amalinkspro_clear_transient', $plugin_admin, 'amalinkspro_clear_transient' );
		


		// load updater function
		$this->loader->add_action( 'admin_init', $plugin_admin, 'amalinkspro_plugin_updater', 0 );

		$this->loader->add_action( 'activate_amalinkspro', $plugin_admin, 'amalinkspro_options_init' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'amalinkspro_menu_options', 100 );

		$this->loader->add_action( 'wp_ajax_activate_amalinkspro_license', $plugin_admin, 'activate_amalinkspro_license' );

		$this->loader->add_action( 'wp_ajax_deactivate_amalinkspro_license', $plugin_admin, 'deactivate_amalinkspro_license' );


		// load ACF fields for this plugin
		$this->loader->add_action( 'acf/init', $plugin_admin, 'amalinkspro_include_acf_fields' );




		$this->loader->add_action( 'media_buttons', $plugin_admin, 'add_amalinkspro_media_button' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'amalinkspro_add_inline_popup_content' );


		// Add amazon api lookup ajax function
		$this->loader->add_action( 'wp_ajax_amazon_api_connection_test', $plugin_admin, 'amazon_api_connection_test' );


		#paapi5
		// gets api5 search results
		$this->loader->add_action( 'wp_ajax_alp_paapi5_get_products', $plugin_admin, 'alp_paapi5_get_products' );
		// gets api5 products info
		$this->loader->add_action( 'wp_ajax_alp_paapi5_get_products_info', $plugin_admin, 'alp_paapi5_get_products_info' );

		
		$this->loader->add_action( 'admin_post_add_foobar', $plugin_admin, 'prefix_admin_add_foobar' );


		// populate our quickview info box via ajax
		//$this->loader->add_action( 'wp_ajax_nopriv_alp_save_cta_button', $plugin_public, 'alp_save_cta_button' );

		// populate our quickview info box via ajax
		$this->loader->add_action( 'wp_ajax_alp_save_cta_button', $plugin_admin, 'alp_save_cta_button' );




		$this->loader->add_action( 'wp_ajax_amalinkspro_load_premade_cta_buttons', $plugin_admin, 'amalinkspro_load_premade_cta_buttons' );

		$this->loader->add_action( 'wp_ajax_amalinkspro_get_cta_button_styles', $plugin_admin, 'amalinkspro_get_cta_button_styles' );

		$this->loader->add_action( 'wp_ajax_alp_clear_license', $plugin_admin, 'alp_clear_license' );




		$this->loader->add_action( 'wp_ajax_amazon_api_get_store_url_ajax', $plugin_admin, 'amazon_api_get_store_url_ajax' );


		


		
		$this->loader->add_action( 'wp_ajax_amalinkspro_save_setting', $plugin_admin, 'amalinkspro_save_setting' );



		$this->loader->add_action( 'wp_ajax_amalinkspro_js_debug_check', $plugin_admin, 'amalinkspro_js_debug_check' );

		$this->loader->add_action( 'admin_head', $plugin_admin, 'amalinkspro_head_script_variables' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'amalinkspro_head_admin_styles' );

		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'amalinkspro_dashboard_widget' );

		
		


		// $this->loader->add_action( 'http_api_curl', $plugin_admin, 'sar_custom_curl_timeout', 9999, 1 );

		// $this->loader->add_action( 'http_request_timeout', $plugin_admin, 'sar_custom_http_request_timeout', 9999 );

		// $this->loader->add_action( 'http_request_args', $plugin_admin, 'sar_custom_http_request_args', 9999, 1 );





	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ama_Links_Pro_Public( $this->get_Ama_Links_Pro(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// add our shortcode function for displaying a table
		$this->loader->add_shortcode( 'amalinkspro', $plugin_public, 'amalinkspro_shortcode_functions' );

		// add our shortcode function for displaying a table
		$this->loader->add_shortcode( 'amalinkspro_autoshowcase', $plugin_public, 'amalinkspro_autoshowcase_shortcode_function' );


		$this->loader->add_action( 'wp_footer', $plugin_public, 'amalinks_pro_footer_scripts' );

		$this->loader->add_action( 'wp_head', $plugin_public, 'amalinkspro_ajaxurl' );

		$this->loader->add_action( 'wp_ajax_amazon_add_to_cart_setup', $plugin_public, 'amazon_add_to_cart_setup' );
		$this->loader->add_action( 'wp_ajax_nopriv_amazon_add_to_cart_setup', $plugin_public, 'amazon_add_to_cart_setup' );


		$this->loader->add_action( 'wp_head', $plugin_public, 'amalinkspro_head_script_variables' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'amalinkspro_head_user_custom_css' );

		#paapi5
		// gets api5 products info
		$this->loader->add_action( 'wp_ajax_alp_paapi5_get_products_info_public', $plugin_public, 'alp_paapi5_get_products_info_public' );
		$this->loader->add_action( 'wp_ajax_nopriv_alp_paapi5_get_products_info_public', $plugin_public, 'alp_paapi5_get_products_info_public' );

		$this->loader->add_action( 'wp_ajax_alp_paapi5_get_asin_groups_data_for_showcase', $plugin_public, 'alp_paapi5_get_asin_groups_data_for_showcase' );
		$this->loader->add_action( 'wp_ajax_nopriv_alp_paapi5_get_asin_groups_data_for_showcase', $plugin_public, 'alp_paapi5_get_asin_groups_data_for_showcase' );



		//$this->loader->add_action( 'wp_head', $plugin_public, 'alp_wp_ajax_url' );

		//$this->loader->remove_filter( 'the_content', $plugin_public, 'wpautop' );
		// remove_filter( 'the_content', 'wpautop' );
		//$this->loader->add_filter( 'the_content', $plugin_public, 'wpautop' , 99 );
		

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_Ama_Links_Pro() {
		return $this->Ama_Links_Pro;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ama_Links_Pro_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
