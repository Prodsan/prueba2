<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/includes
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
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/includes
 * @author     AmaLinks Pro <support@amalinkspro.com>
 */
class Amalinks_Pro_Tables {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Amalinks_Pro_Tables_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Amalinks_Pro_Tables    The string used to uniquely identify this plugin.
	 */
	protected $Amalinks_Pro_Tables;

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
		if ( defined( 'Amalinks_Pro_Tables_VERSION' ) ) {
			$this->version = Amalinks_Pro_Tables_VERSION;
		} else {
			$this->version = '1.3.4';
		}
		$this->Amalinks_Pro_Tables = 'amalinkspro-tables';

		// EDD Constants
		$this->edd_product = 'AmaLinks Pro - Table Builder Add-on';
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
	 * - Amalinks_Pro_Tables_Loader. Orchestrates the hooks of the plugin.
	 * - Amalinks_Pro_Tables_i18n. Defines internationalization functionality.
	 * - Amalinks_Pro_Tables_Admin. Defines all hooks for the admin area.
	 * - Amalinks_Pro_Tables_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amalinkspro-tables-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amalinkspro-tables-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-amalinkspro-tables-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-amalinkspro-tables-public.php';


		/**
		 * The class responsible for adding our automatic EDD plugin updater
		 * side of the site.
		 */
		if( !class_exists( 'AMALINKSPRO_TABLES_Plugin_Updater' ) ) {
			// load our custom updater
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/AMALINKSPRO_TABLES_Plugin_Updater.php';
		}

		$this->loader = new Amalinks_Pro_Tables_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Amalinks_Pro_Tables_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Amalinks_Pro_Tables_i18n();

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

		$plugin_admin = new Amalinks_Pro_Tables_Admin( $this->get_Amalinks_Pro_Tables(), $this->get_version(), $this->edd_product, $this->edd_store );

		$this->loader->add_filter( 'admin_init', $plugin_admin, 'welcome_screen_tb_do_activation_redirect');

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'child_plugin_has_parent_plugin' );
		$this->loader->add_action( 'init', $plugin_admin, 'alp_tables_post_types' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'alp_get_table_global_styles_for_editor' );
		// load updater function
		$this->loader->add_action( 'admin_init', $plugin_admin, 'amalinkspro_tables_plugin_updater', 0 );
		$this->loader->add_action( 'alp_addon_licenses', $plugin_admin, 'alp_tables_license_management' );
		$this->loader->add_action( 'alp_addon_tablebuilder_start', $plugin_admin, 'alp_addon_tablebuilder_start_function' );
		// load ACF fields for this plugin
		$this->loader->add_action( 'acf/init', $plugin_admin, 'amalinkspro_tables_include_acf_fields' );
		$this->loader->add_action( 'amalinkspro_tablebuilder', $plugin_admin, 'amalinkspro_tablebuilder_function' );
		$this->loader->add_action( 'wp_ajax_alp_tables_get_asin_groups_data', $plugin_admin, 'alp_tables_get_asin_groups_data' );
		$this->loader->add_action( 'wp_ajax_amalinkspro_save_new_table', $plugin_admin, 'amalinkspro_save_new_table' );
		$this->loader->add_action( 'wp_ajax_amalinkspro_delete_table', $plugin_admin, 'amalinkspro_delete_table' );
		$this->loader->add_action( 'wp_ajax_amalinkspro_edit_table', $plugin_admin, 'amalinkspro_edit_table' );
		$this->loader->add_action( 'wp_ajax_amalinkspro_save_table_data', $plugin_admin, 'amalinkspro_save_table_data' );
		// used to get columns data when adding a new column in the table editor
		$this->loader->add_action( 'wp_ajax_alp_get_asin_groups_data', $plugin_admin, 'alp_get_asin_groups_data' );
		$this->loader->add_action( 'wp_ajax_nopriv_alp_get_asin_groups_data', $plugin_admin, 'alp_get_asin_groups_data' );
		$this->loader->add_action( 'wp_ajax_amalinkspro_load_table_into_editor', $plugin_admin, 'amalinkspro_load_table_into_editor' );
		$this->loader->add_action( 'wp_ajax_amalinkspro_load_table_link_settings', $plugin_admin, 'amalinkspro_load_table_link_settings' );
		// usd to get api search results for tablebuilder
		$this->loader->add_action( 'wp_ajax_amalinkspro_find_amazon_products_for_table_ajax', $plugin_admin, 'amalinkspro_find_amazon_products_for_table_ajax' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'amalinkspro_tb_menu_options', 100 );

		#paapi5
		$this->loader->add_action( 'wp_ajax_nopriv_alp_paapi5_get_asin_groups_data', $plugin_admin, 'alp_paapi5_get_asin_groups_data' );
		$this->loader->add_action( 'wp_ajax_alp_paapi5_get_asin_groups_data', $plugin_admin, 'alp_paapi5_get_asin_groups_data' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Amalinks_Pro_Tables_Public( $this->get_Amalinks_Pro_Tables(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_shortcode( 'amalinkspro_table', $plugin_public, 'amalinkspro_table_shortcode_function' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'amalinkspro_tables_get_table_global_styles' );

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
	public function get_Amalinks_Pro_Tables() {
		return $this->Amalinks_Pro_Tables;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Amalinks_Pro_Tables_Loader    Orchestrates the hooks of the plugin.
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
