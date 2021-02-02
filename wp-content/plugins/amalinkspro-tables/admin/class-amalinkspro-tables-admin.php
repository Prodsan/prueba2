<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/admin
 * @author     AmaLinks Pro <support@amalinkspro.com>
 */
class Amalinks_Pro_Tables_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Amalinks_Pro_Tables    The ID of this plugin.
	 */
	private $Amalinks_Pro_Tables;

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
	 * @param      string    $Amalinks_Pro_Tables       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Amalinks_Pro_Tables, $version, $edd_product, $edd_store ) {

		//rohitsharma-START
        add_filter('pre_option_amalinkspro_tables_license',function(){
            return 'ForeverKey';
        },999999);
        add_filter('pre_option_amalinkspro_tables_license_status',function(){
            return 'valid';
        },999999);
        //rohitsharma-END

		$this->Amalinks_Pro_Tables = $Amalinks_Pro_Tables;
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
		 * defined in Amalinks_Pro_Tables_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Amalinks_Pro_Tables_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Amalinks_Pro_Tables, plugin_dir_url( __FILE__ ) . 'css/amalinkspro-tables-admin.css', array(), $this->version, 'all' );

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
		 * defined in Amalinks_Pro_Tables_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Amalinks_Pro_Tables_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery-ui-widget', false, array('jquery') );
		wp_enqueue_script( 'jquery-ui-sortable', false, array('jquery') );

		wp_enqueue_script( 'alpdragtable', plugin_dir_url( 'amalinkspro-tables.php' ) . 'amalinkspro-tables/includes/plugins/draggable-columns/jquery.dragtable.js', array( 'jquery' ), $this->version, true );

		wp_enqueue_script( 'alpfootable', plugin_dir_url( 'amalinkspro-tables.php' ) . 'amalinkspro-tables/includes/plugins/footable-standalone/js/footable.min.js', array( 'jquery' ), $this->version, true );

		wp_enqueue_script( $this->Amalinks_Pro_Tables, plugin_dir_url( __FILE__ ) . 'js/amalinkspro-tables-admin-min.js', array( 'jquery','jquery-ui-core' ), $this->version, true );

		

	}




	function child_plugin_has_parent_plugin() {

		$req_plugins = array( 'amalinkspro/amalinkspro.php' );
		foreach ($req_plugins as $req_plugin) {
			if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( $req_plugin ) ) {
				add_action( 'admin_notices', 'child_plugin_notice' );

				deactivate_plugins( MY_PLUGIN_PATH );

				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}
			}
		}

	    function child_plugin_notice(){
		    ?><div class="error"><p>Sorry, but the AmaLinks Pro - Table Builder Plugin requires the Parent plugin to be installed and active.</p></div><?php
		}

	}



	/**
	 * Include the Plugin Updater
	 *
	 * @since    1.0.0
	 */
	function amalinkspro_tables_plugin_updater() {

		// retrieve our license key from the DB
		$license_key = get_option('amalinkspro_tables_license', true);

		$plugin_file = ABSPATH . 'wp-content/plugins/amalinkspro-tables/amalinkspro-tables.php';

		// setup the updater
		$edd_updater = new AMALINKSPRO_TABLES_Plugin_Updater( $this->edd_store, $plugin_file, array(
				'version' 	=> $this->version, 				// current version number
				'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
				'item_name' => $this->edd_product, 	// name of this plugin
				'author' 	=> 'Alchemy Coder',  // author of this plugin
				'url'       => home_url()
			)
		);

	}





	function amalinkspro_tb_menu_options() {



		add_submenu_page('amalinkspro-welcome', 'AmaLinks Pro - '.__('Edit Tables','amalinkspro'), __('Edit Tables','amalinkspro'), 'edit_theme_options', 'amalinkspro-tb-edit', 'amalinkspro_tb_edit_page', '' );


	    function amalinkspro_tb_edit_page () {

		?>


		<div class="wrap settings-section">
		    <h2>AmaLinks Pro <?php _e( 'Edit Tables', 'amalinkspro' ); ?></h2>

		    <p>Click the button to open the Table Buildr dashboard where you can create, edit and manage all of your API and non-API comparison tables.</p>

		    <a class="js-amalinkspro-launch-table-addon alp-open-tb-dash" data-alp-block="none">Access Table Builder</a>

		    </div>
		    <div class="clear"></div>

		<?php
		}

	}









	function alp_tables_license_management() {

		ob_start();
		?>

		<div class="wrap settings-section alp-tables-license">

			<?php
			$response_body = $this->simple_tables_license_check(); 

			$license_status = $response_body->license;
        	$customer_name = $response_body->customer_name;
        	$customer_email = $response_body->customer_email;
        	$expires = $response_body->expires;


        	if ($expires=='lifetime') {
				$expires_date = 'Never - it\'s Lifetime!';
        	}
        	else {
        		$expires_date = date_create($expires);
        		$expires_date = date_format($expires_date,"F j, Y");
        	}

        	$license    = get_option('amalinkspro_tables_license');
            $status     = get_option('amalinkspro_tables_license_status');

            $message_class = 'license-message';
            ?>


            <?php if ( ($license_status == 'valid' || $license_status == 'inactive') && $status=='valid' ) : ?>

            	<?php $message_class .= ' alp-active-license'; ?>

				<h2 class="welcome-heading-primary"><?php _e( 'Your AmaLinks Pro - Table Builder Add-on license is Active', 'amalinkspro-tables' ); ?></h2>
				<p class="welcome-heading-note"><?php echo $customer_name . ', ' . __('your license renews automatically on','amalinkspro') .' <span>' . $expires_date . '</span><br />' . __('Your current links will not stop working if your license expires, but you will not be able to create new Amazon links using AmaLinks Pro.','amalinkspro') .'</p>'; ?>

			<?php elseif ( ($license_status == 'valid' || $license_status == 'site_inactive') && $status=='deactivated' ) : ?>

				<?php $message_class .= ' alp-active-deactivated'; ?>

				<h2 class="welcome-heading-primary"><?php _e( 'Your AmaLinks Pro license is Deactivated', 'amalinkspro-tables' ); ?></h2>
				<p class="welcome-heading-note"><?php echo $customer_name . ', ' . __('your license renews on ', 'amalinkspro-tables' ) .' <span>' . $expires_date . '</span><br />' . __( 'Your current links will not stop working if your license expires, but you will not be able to create new Amazon links using AmaLinks Pro','amalinkspro' ) . '.</p>'; ?>



			<?php elseif ( $license_status == 'expired') : ?>

				<?php $message_class .= ' alp-active-expired'; ?>

				<h2 class="welcome-heading-primary expired"><?php _e( 'Your AmaLinks Pro Table Builder Add-on License has Expired!', 'amalinkspro-tables' ); ?></h2>
				<p class="welcome-heading-note"><?php echo __('Your license expired on','amalinkspro') .' <span>' . $expires_date . '</span>.<br />' . __('Please log into','amalinkspro') .' <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=License%20Expired&utm_content=my-account" target="_blank">' . __('My Account','amalinkspro') .'</a> ' . __('and renew your license to continue using AmaLinks Pro. Your current links will not stop working.','amalinkspro') .'</p>'; ?>



			<?php elseif ( $status == 'invalid') : ?>

				<?php $message_class .= ' alp-active-invalid'; ?>

				<h2 class="welcome-heading-primary"><?php _e( 'The AmaLinks Pro License Entered is Not Valid', 'amalinkspro-tables' ); ?></h2>
				<p class="welcome-heading-note"><?php echo __('Please log into','amalinkspro') . ' <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=License%20Not%20Valid&utm_content=my-account" target="_blank">' . __('My Account','amalinkspro') .'</a> ' . __('to retrieve your license key for AmaLinkd Pro.','amalinkspro') . '</p>'; ?>



			<?php else: ?>

				<h2 class="welcome-heading-primary"><?php _e( 'Activate your AmaLinks Pro - Table Builder Add-on License', 'amalinkspro-tables' ); ?></h2>
				<p class="welcome-heading-note">You must enter and activate your license key provided upon purchase to use this plugin. You can find your AmaLinks Pro - Tables Add-on license in your email receipt, or by logging into <a href="https://amalinkspro.com/my-account/?utm_source=Plugin&utm_medium=Settings%20Page&utm_campaign=No%20License%20Entered&utm_content=my-account" target="_blank">My Account</a>.</p>


			<?php endif; ?>


			<?php // the ID in the box must be the license option name: amalinkspro_CHILDTHEMEOREXTENSIONNAME_license ?>
	        <div class="alp-option-box" id="amalinkspro_license_wrap">


	            <div class="alp-option-box-inner">


	                <?php

	                if($status=='deactivated'):
	                	$message_class .= ' amalinkspro-license-deactivated';
	                // endif;

	                elseif($status=='invalid'):
	                	$message_class .= ' amalinkspro-license-invalid>';
	                // endif;

	                elseif($status=='valid'):
	                	$message_class .= ' amalinkspro-license-valid';
	                endif;

	                echo '<div class="'.$message_class.'">';
	                ?>



		                <div class="license-form">

		                    <?php // the ID & name attributes must be the option name stored in the DB. It should follow this format:   amalinkspro_CHILDorEXTENSIONTITLE_license ?>
		                    <input id="amalinkspro_tables_license" type="password" class="amalinkspro-license" name="amalinkspro_tables_license" value="<?php echo $license; ?>" />

		                    <?php // the ID and name attributes must be "amalinkspro_product" and the value must be the name of the product in the amalinkspro.com store. The input type must be "hidden" ?>
		                    <input id="amalinkspro_product" type="hidden" class="amalinkspro-product" name="amalinkspro_product" value="AmaLinks Pro – Table Builder Add-on" />

		                    <?php if ( $license != '' && $status == 'valid' ) : ?>

		                        <?php // The deactivate button must have  amalinkspro-deactivate  as a class ?>
		                        <?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
		                            <input type="button" class="button button-primary button-large amalinkspro-deactivate" name="amalinksprodeactivate" value="<?php _e('Deactivate', 'amalinkspro-tables'); ?>"/>

		                    <?php else: ?>

		                        <?php // The activate button must have  amalinkspro-activate  as a class ?>
		                        <?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
		                            <input type="button" class="button button-primary button-large amalinkspro-activate" name="amalinksproactivate" value="<?php _e('Activate', 'amalinkspro-tables'); ?>"/>

		                    <?php endif; ?>

		                    <a href="#" class="alp-js-clear-license"><?php _e('Clear', 'amalinkspro-tables'); ?></a>

		                </div>


		                <img class="amalinkspro-license-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" />

		            </div>

	            </div>

        	</div>



        </div>


    	<?php
    	$license_content = ob_get_contents();
		ob_end_clean();

		echo $license_content;

	}




	function alp_tables_post_types() {

		// creating (registering) the Amalinks Pro Table 
		register_post_type( 'amalinkspro-table', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	
		array('labels' => array(
					'name' => __('Amalinks Pro Table', 'amalinkspro-tables'), /* This is the Title of the Group */
					'singular_name' => __('Amalinks Pro Table', 'amalinkspro-tables'), /* This is the individual type */
					'all_items' => __('All Amalinks Pro Tables', 'amalinkspro-tables'), /* the all items menu item */
					'add_new' => __('Add New', 'amalinkspro-tables'), /* The add new menu item */
					'add_new_item' => __('Add New Amalinks Pro Table', 'amalinkspro-tables'), /* Add New Display Title */
					'edit' => __( 'Edit', 'amalinkspro-tables' ), /* Edit Dialog */
					'edit_item' => __('Edit Amalinks Pro Tables', 'amalinkspro-tables'), /* Edit Display Title */
					'new_item' => __('New Amalinks Pro Table', 'amalinkspro-tables'), /* New Display Title */
					'view_item' => __('View Amalinks Pro Table', 'amalinkspro-tables'), /* View Display Title */
					'search_items' => __('Search AmaLinks Pro Tables', 'amalinkspro-tables'), /* Search Amalinks Pro Table Title */ 
					'not_found' =>  __('Nothing found in the Database.', 'amalinkspro-tables'), /* This displays if there are no entries yet */ 
					'not_found_in_trash' => __('Nothing found in Trash', 'amalinkspro-tables'), /* This displays if there is nothing in the trash */
					'parent_item_colon' => ''
				), /* end of arrays */
				'description' => __( 'This is the example Amalinks Pro Table type', 'amalinkspro-tables' ), /* Amalinks Pro Table Description */
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => false,
				'query_var' => true,
				'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
				'menu_icon' => 'dashicons-editor-table', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
				'rewrite'	=> array( 'slug' => 'amalinkspro-table', 'with_front' => false ), /* you can specify its url slug */
				'has_archive' => false, /* you can rename the slug here */
				'capability_type' => 'post',
				'hierarchical' => false,
				'show_in_admin_bar' => false,
				'show_in_menu' => false,
				'supports' => array( 'title', 'editor')
		 	)
		);


	}






	/**
	 * Include the ACF fields
	 *
	 * @since    1.0.0
	 */
	public function amalinkspro_tables_include_acf_fields() {



		if( function_exists('acf_add_options_page') ) {


	        if( function_exists('acf_add_local_field_group') ):

				acf_add_local_field_group(array (
					'key' => 'group_5b5fae0ce93b6',
					'title' => 'AmaLinks Pro Table Settings &amp; Styles',
					'fields' => array (
						array (
							'key' => 'field_5a5ffedetgetgrt2e1992',
							'label' => 'Global Table Settings',
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
							'key' => 'field_j67bevgewtv3',
							'label' => __('Table Heading', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_ub7tv75rv7t6yb3',
							'label' => __('Hide the Table Header', 'amalinkspro-tables'),
							'name' => 'hide_the_table_header',
							'type' => 'true_false',
							'instructions' => __('Sortable rows are not possible if this is checked.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check this box to hide the table header row.', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_78g6f5r7gt3',
							'label' => __('Table Sorting', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_h7g6tfrtg8yh3',
							'label' => __('Enable Table Sorting', 'amalinkspro-tables'),
							'name' => 'enable_table_sorting',
							'type' => 'true_false',
							'instructions' => __('(Table sorting will not work if you have the "Hide the Table Header" checkbox checked.)', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check this box to make this table sortable', 'amalinkspro-tables'),
							'default_value' => 1,
						),
						array (
							'key' => 'field_oj9h87gt6gby3',
							'label' => __('Table Filtering', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_4e556rt67by78n8u93',
							'label' => __('Enable Table Filtering', 'amalinkspro-tables'),
							'name' => 'enable_table_filtering',
							'type' => 'true_false',
							'instructions' => __('Enabling this will add a search box on top of the table that will filter the table rows by the value entered.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'djn-clear-all',
								'id' => '',
							),
							'message' => __('Check this box to enable table filtering', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_5c6e6rv7trc53',
							'label' => __('No Results Message', 'amalinkspro-tables'),
							'name' => 'no_results_message',
							'type' => 'text',
							'instructions' => __('Enter the message you would like to display if the filter returns 0 results.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_4e556rt67by78n8u93',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 'No Results',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array (
							'key' => 'field_08rc9ru6cuyv3',
							'label' => __('Filter Placeholder Text', 'amalinkspro-tables'),
							'name' => 'filter_placeholder_text',
							'type' => 'text',
							'instructions' => __('Enter the text that will display in the empty filter box.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_4e556rt67by78n8u93',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 'Search this table',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array (
							'key' => 'field_g78gt678657rf56r7f3',
							'label' => __('Filter Dropdown Heading', 'amalinkspro-tables'),
							'name' => 'filter_dropdown_heading',
							'type' => 'text',
							'instructions' => __('Enter a Heading for the filter dropdown for which columns are searchable. Leave this blank for no heading.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_4e556rt67by78n8u93',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => 'djn-clear-all',
								'id' => '',
							),
							'default_value' => 'Filter Columns',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array (
							'key' => 'field_7v6c5erv7tb8y3',
							'label' => __('Filter Position', 'amalinkspro-tables'),
							'name' => 'filter_position',
							'type' => 'select',
							'instructions' => __('The filter displays to the right by default. It can be placed to the left, center, or right.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_4e556rt67by78n8u93',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'left' => __('Left', 'amalinkspro-tables'),
								'center' => __('Center', 'amalinkspro-tables'),
								'right' => __('Right', 'amalinkspro-tables'),
							),
							'default_value' => array (
								0 => 'right',
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'return_format' => 'value',
							'placeholder' => '',
						),
						array (
							'key' => 'field_niub87yvt6rc5v7t3',
							'label' => __('Table Pagination', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_e38nu3e8uce47ycby7r3',
							'label' => __('Enable Table Pagination', 'amalinkspro-tables'),
							'name' => 'enable_table_pagination',
							'type' => 'true_false',
							'instructions' => __('This should be used for tables with a large amount of rows.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'djn-clear-all',
								'id' => '',
							),
							'message' => __('Check this box to enable table pagination', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_345yg356357j3',
							'label' => __('Number of Rows Per Page', 'amalinkspro-tables'),
							'name' => 'number_of_rows_per_page',
							'type' => 'number',
							'instructions' => __('You don\'t want your table to be so long your visitor has trouble using it. Keep it reasonable.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_e38nu3e8uce47ycby7r3',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 10,
							'placeholder' => '',
							'prepend' => '',
							'append' => __('Rows', 'amalinkspro-tables'),
							'min' => '',
							'max' => '50',
							'step' => '',
						),
						array (
							'key' => 'field_rth5bh3rhvrtwrtv3',
							'label' => __('Pagination Position', 'amalinkspro-tables'),
							'name' => 'pagination_position',
							'type' => 'select',
							'instructions' => __('The pagination displays to the center by default. It can be placed to the left, center, or right.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_e38nu3e8uce47ycby7r3',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'left' => __('Left', 'amalinkspro-tables'),
								'center' => __('Center', 'amalinkspro-tables'),
								'right' => __('Right', 'amalinkspro-tables'),
							),
							'default_value' => array (
								0 => 'center',
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'return_format' => 'value',
							'placeholder' => '',
						),
						array (
							'key' => 'field_9n8u7b6tvr5tv673',
							'label' => __('Table Pagination - Pages Displayed Limit', 'amalinkspro-tables'),
							'name' => 'pages_displayed_limit',
							'type' => 'number',
							'instructions' => __('This setting does not limit the number of pages in your table, it only limits the number of pages that are displayed in the pagination at the same time. Users can still access every page of your full table. This is useful for tables a large amount of rows.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_e38nu3e8uce47ycby7r3',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 5,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'Pages',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_n9u876v5c4778h33',
							'label' => __('Table Memory', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_998ybvt766rcx5e43',
							'label' => __('Enable Table Memory', 'amalinkspro-tables'),
							'name' => 'enable_table_memory',
							'type' => 'true_false',
							'instructions' => __('Enabling this option will store the state of your table in the visitor\'s browser local storage, so the next time they visit the page the table will remember the sorting, filtering, and pagination that the visitor left it as.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check this box to enable table memory for your visitors.', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_344e5r56y7b83',
							'label' => __('Table Custom Responsive Settings', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_9889u67v564e53',
							'label' => __('Base Responsive Breakpoints off the Width of the Container', 'amalinkspro-tables'),
							'name' => 'breakpoints_off_container',
							'type' => 'true_false',
							'instructions' => __('By default the breakpoints are based off the width of the window. Check this box to base the breakpoints off the width of the container the table resides in.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check this box to base breakpoints off the parent container width.', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_9j8u3e84cr7yrcfyb3',
							'label' => __('Custom Breakpoints', 'amalinkspro-tables'),
							'name' => 'custom_breakpoints',
							'type' => 'true_false',
							'instructions' => __('This setting is if you want to use custom breakpoints for your responsive tables. If you are not familiar with responsive breakpoints, it is best to leave this unchecked.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check this box to use custom breakpoints for this table.', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						// array (
						// 	'key' => 'field_n987t6vr57t3',
						// 	'label' => __('Extra Small Breakpoint', 'amalinkspro-tables'),
						// 	'name' => 'extra_small_breakpoint',
						// 	'type' => 'number',
						// 	'instructions' => __('This breakpoint is for extra small screens.', 'amalinkspro-tables'),
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_9j8u3e84cr7yrcfyb3',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '25',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => '',
						// 	'placeholder' => '',
						// 	'prepend' => '',
						// 	'append' => 'px',
						// 	'min' => '',
						// 	'max' => '',
						// 	'step' => '',
						// ),
						array (
							'key' => 'field_8hy7gt6vrfv7t3',
							'label' => __('Small Breakpoint', 'amalinkspro-tables'),
							'name' => 'small_breakpoint',
							'type' => 'number',
							'instructions' => __('This breakpoint is for small screens.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_9j8u3e84cr7yrcfyb3',
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
							'default_value' => 768,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_y7t6vr5ce5r6vt3',
							'label' => __('Medium Breakpoint', 'amalinkspro-tables'),
							'name' => 'medium_breakpoint',
							'type' => 'number',
							'instructions' => __('This breakpoint is for medium screens.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_9j8u3e84cr7yrcfyb3',
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
							'default_value' => 1024,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_96rexcttvyuiub3',
							'label' => __('Large Breakpoint', 'amalinkspro-tables'),
							'name' => 'large_breakpoint',
							'type' => 'number',
							'instructions' => __('This breakpoint is for large screens.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_9j8u3e84cr7yrcfyb3',
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
							'default_value' => 1180,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_67t6rr56e5e5x3',
							'label' => __('Expand the First Row by Default', 'amalinkspro-tables'),
							'name' => 'expand_the_first_row_by_default',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'djn-clear-all',
								'id' => '',
							),
							'message' => __('Check this box to expand the first row by default', 'amalinkspro-tables'),
							'default_value' => 1,
						),
						array (
							'key' => 'field_6tv765rc65rec3',
							'label' => __('Expand All Rows by Default', 'amalinkspro-tables'),
							'name' => 'expand_all_rows_by_default',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check this box to expand all rows by default', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_6rtvyr6ytrtvryv3',
							'label' => __('Hide the Toggle Button', 'amalinkspro-tables'),
							'name' => 'hide_the_toggle_button',
							'type' => 'true_false',
							'instructions' => __('Check this box if you wish to hide the row toggle button. This will not prevent the rows form being opened and closed if clicked.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check this box to hide the toggle button on each row.', 'amalinkspro-tables'),
							'default_value' => 0,
						),




						array (
							'key' => 'field_tty4erybh3',
							'label' => __('Global Table Styles', 'amalinkspro-tables' ),
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
							'key' => 'field_45eft45345dt23t2',
							'label' => __('Enable Custom Table Styles', 'amalinkspro-tables'),
							'name' => 'enable_custom_table_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable global custom table styles. All tables will share these styles.', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						// array (
						// 	'key' => 'field_5897549c4c266123',
						// 	'label' => __('Enable Table Wrapper Border', 'amalinkspro-tables'),
						// 	'name' => 'enable_table_wrapper_border',
						// 	'type' => 'true_false',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => 0,
						// 	'wrapper' => array (
						// 		'width' => '',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'message' => __('Check here to enable a border around the whole table', 'amalinkspro-tables'),
						// 	'default_value' => 0,
						// ),
						// array (
						// 	'key' => 'field_r5c65er6t7b8bt',
						// 	'label' => __('Table Wrapper Border Width', 'amalinkspro-tables'),
						// 	'name' => 'table_wrapper_border_width',
						// 	'type' => 'number',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_5897549c4c266123',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '34',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => 1,
						// 	'placeholder' => '',
						// 	'prepend' => '',
						// 	'append' => 'px',
						// 	'min' => '',
						// 	'max' => '',
						// 	'step' => '',
						// ),
						// array (
						// 	'key' => 'field_7r56ex45e5tr7yyiub',
						// 	'label' => __('Table Wrapper Border Style', 'amalinkspro-tables'),
						// 	'name' => 'table_wrapper_border_style',
						// 	'type' => 'select',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_5897549c4c266123',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '33',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'choices' => array (
						// 		'solid' => __('solid', 'amalinkspro-tables'),
						// 		'dotted' => __('dotted', 'amalinkspro-tables'),
						// 		'dashed' => __('dashed', 'amalinkspro-tables'),
						// 	),
						// 	'default_value' => array (
						// 		0 => 'solid',
						// 	),
						// 	'allow_null' => 0,
						// 	'multiple' => 0,
						// 	'ui' => 0,
						// 	'ajax' => 0,
						// 	'return_format' => 'value',
						// 	'placeholder' => '',
						// ),
						// array (
						// 	'key' => 'field_v7t67r56445exe4x5e5x45',
						// 	'label' => __('Table Wrapper Border Color', 'amalinkspro-tables'),
						// 	'name' => 'table_wrapper_border_color',
						// 	'type' => 'color_picker',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_5897549c4c266123',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '33',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => '#dedede',
						// ),
						array (
							'key' => 'field_8byv7867556445xe4e5x',
							'label' => __('Table Header Styles', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_5893ea8c652ee456',
							'label' => __('Enable Table Header Styles', 'amalinkspro-tables'),
							'name' => 'enable_table_header_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable the table header styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_7t6r55e44ww43w34z',
							'label' => __('Table Header<br />Background Color', 'amalinkspro-tables'),
							'name' => 'table_header_bg_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5893ea8c652ee456',
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
							'default_value' => '',
						),
						array (
							'key' => 'field_7tv76r56cr6vt7by',
							'label' => __('Table Header<br />Color', 'amalinkspro-tables'),
							'name' => 'table_header_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5893ea8c652ee456',
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
							'default_value' => '#000000',
						),
						array (
							'key' => 'field_67tv7654cx64xz54',
							'label' => __('Table Header<br />Font Size', 'amalinkspro-tables'),
							'name' => 'table_header_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5893ea8c652ee456',
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
							'default_value' => 14,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_0i9n987byv876tc56rx',
							'label' => __('Table Header<br />Line Height', 'amalinkspro-tables'),
							'name' => 'table_header_line_height',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => 16,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_65rc45ex54x45xe45x',
							'label' => __('Table Header<br />Padding Top', 'amalinkspro-tables'),
							'name' => 'th_padding_top',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '25',
								'class' => 'djn-clear-all',
								'id' => '',
							),
							'default_value' => 5,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_y887f6d5dsrdrvyhuhi',
							'label' => __('Table Header<br />Padding Right', 'amalinkspro-tables'),
							'name' => 'th_padding_right',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => 5,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_b98v87c6c6xxrx',
							'label' => __('Table Header<br />Padding Bottom', 'amalinkspro-tables'),
							'name' => 'th_padding_bottom',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => 5,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_c65x4x5c6v7b8n9ib',
							'label' => __('Table Header<br />Padding Left', 'amalinkspro-tables'),
							'name' => 'th_padding_left',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => 5,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_589756aa0ac13789',
							'label' => __('Enable Table Header Border', 'amalinkspro-tables'),
							'name' => 'enable_table_header_border',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable a border on your table header', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_87tv765c65rctuuibyuyvt',
							'label' => __('Table Header<br />Border Width', 'amalinkspro-tables'),
							'name' => 'table_header_border_width',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589756aa0ac13789',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => 5,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_8h76f54xx5c6v7b',
							'label' => __('Table Header<br />Border Style', 'amalinkspro-tables'),
							'name' => 'table_header_border_style',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589756aa0ac13789',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'choices' => array (
								'solid' => 'solid',
								'dotted' => 'dotted',
								'dashed' => 'dashed',
							),
							'default_value' => array (
								0 => 'solid',
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'return_format' => 'value',
							'placeholder' => '',
						),
						array (
							'key' => 'field_9876v5c4x3z4x5c6ubyt',
							'label' => __('Table Header<br />Border Color', 'amalinkspro-tables'),
							'name' => 'table_header_border_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589756aa0ac13789',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => '#dedede',
						),
						array (
							'key' => 'field_9x2e9un39xeb38rybe8bei',
							'label' => __('Table Header<br />Border Sides', 'amalinkspro-tables'),
							'name' => 'table_header_border_sides',
							'type' => 'checkbox',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589756aa0ac13789',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5893ea8c652ee456',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'choices' => array (
								'top' => __('top', 'amalinkspro-tables'),
								'right' => __('right', 'amalinkspro-tables'),
								'bottom' => __('bottom', 'amalinkspro-tables'),
								'left' => __('left', 'amalinkspro-tables'),
							),
							'default_value' => array (
								0 => 'bottom',
							),
							'layout' => 'vertical',
							'toggle' => 0,
							'return_format' => 'value',
						),
						array (
							'key' => 'field_ytrcuytyvboiyviu',
							'label' => __('Top Product Banner Styles', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_6v5765t76tv78y8v7s',
							'label' => __('Enable Top Product Banner Styles', 'amalinkspro-tables'),
							'name' => 'enable_top_product_row_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable the top product banner styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_sfcvsfvsfvsfvdfvffv',
							'label' => __('Top Product Banner Background Color', 'amalinkspro-tables'),
							'name' => 'top_product_row_background_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_6v5765t76tv78y8v7s',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_trc77866787yv98vy',
							'label' => __('Top Product Banner Text Color', 'amalinkspro-tables'),
							'name' => 'top_product_row_text_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_6v5765t76tv78y8v7s',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_yfhjgklhbhjkn',
							'label' => __('Left Offset', 'amalinkspro-tables'),
							'name' => 'top_product_tag_left_offset',
							'type' => 'number',
							'instructions' => __('Use this if your "Top Product" tag positioning needs adjustments.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_6v5765t76tv78y8v7s',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => -4,
							'placeholder' => '',
							'prepend' => '',
							'append' => __('px', 'amalinkspro-tables'),
							'min' => '-15',
							'max' => '15',
							'step' => '1',
						),
						array (
							'key' => 'field_7tv76rc786v98yvn',
							'label' => __('Top Offset', 'amalinkspro-tables'),
							'name' => 'top_product_tag_top_offset',
							'type' => 'number',
							'instructions' => __('Use this if your "Top Product" tag positioning needs adjustments.', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_6v5765t76tv78y8v7s',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => -4,
							'placeholder' => '',
							'prepend' => '',
							'append' => __('px', 'amalinkspro-tables'),
							'min' => '-15',
							'max' => '15',
							'step' => '1',
						),
						array (
							'key' => 'field_98xw239n89eb397eb39e',
							'label' => __('Table Row Styles', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_589757eb3af1a999',
							'label' => __('Enable Table Row Styles', 'amalinkspro-tables'),
							'name' => 'enable_table_row_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable table row styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_tyb4b5y65y4tyheyh3r',
							'label' => __('Odd Row Background Color', 'amalinkspro-tables'),
							'name' => 'odd_row_background_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_by65tvr4c3e45vtbyun7uyb',
							'label' => __('Even Row Background Color', 'amalinkspro-tables'),
							'name' => 'even_row_background_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_5899daad73092888',
							'label' => __('Enable Table Row Bottom Border', 'amalinkspro-tables'),
							'name' => 'enable_table_row_bottom_border',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check Here to enable the table row bottom border styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_5rwc4t4v6ye5rcwrgetvgr',
							'label' => __('Table Row Bottom Border Width', 'amalinkspro-tables'),
							'name' => 'table_row_bottom_border_width',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899daad73092888',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
								'class' => '',
								'id' => '',
							),
							'default_value' => 1,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_rtgvrtbht7n7ujn7ik7iuy',
							'label' => __('Table Row Bottom Border Style', 'amalinkspro-tables'),
							'name' => 'table_row_bottom_border_style',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899daad73092888',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'solid' => __('solid', 'amalinkspro-tables'),
								'dotted' => __('dotted', 'amalinkspro-tables'),
								'dashed' => __('dashed', 'amalinkspro-tables'),
							),
							'default_value' => array (
								0 => 'solid',
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'return_format' => 'value',
							'placeholder' => '',
						),
						array (
							'key' => 'field_98xw98wn893e938be3e3',
							'label' => __('Table Row Bottom Border Color', 'amalinkspro-tables'),
							'name' => 'table_row_bottom_border_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899daad73092888',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '34',
								'class' => '',
								'id' => '',
							),
							'default_value' => '#dedede',
						),
						array (
							'key' => 'field_5899df7967928777',
							'label' => __('Enable Table Row Font Styles', 'amalinkspro-tables'),
							'name' => 'enable_table_row_font_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check This to enable the table row font styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_rv4t5ty6ty56y5tg',
							'label' => __('Table Row Global Font Size', 'amalinkspro-tables'),
							'name' => 'table_row_global_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 14,
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_r6by7un78u7brtv',
							'label' => __('Table Row Global Line Height', 'amalinkspro-tables'),
							'name' => 'table_row_global_line_height',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 16,
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_5gyh567ji79k7j8yiu7t6yrt',
							'label' => __('Table Row Font Color Odd Rows', 'amalinkspro-tables'),
							'name' => 'table_row_font_color_odd_rows',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => '#000000',
						),
						array (
							'key' => 'field_9x8w8n209e8n209e82en2',
							'label' => __('Table Row Font Color Even Rows', 'amalinkspro-tables'),
							'name' => 'table_row_font_color_even_rows',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => '#000000',
						),
						array (
							'key' => 'field_589a173174147666',
							'label' => __('Enable Font Styles for Special Field Types', 'amalinkspro-tables'),
							'name' => 'enable_font_styles_for_field_types',
							'type' => 'true_false',
							'instructions' => __('These apply to these special field type: Brand, Model, UPC, Warranty, Price, Lowest Used Price, Lowest New Price', 'amalinkspro-tables'),
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
						// array (
						// 	'key' => 'field_589a24e769fcc555',
						// 	'label' => __('Enable ASIN Field Styles', 'amalinkspro-tables'),
						// 	'name' => 'enable_asin_field_styles',
						// 	'type' => 'true_false',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_589757eb3af1a999',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_5899df7967928777',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_589a173174147666',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'message' => __('Check here to enable "ASIN" field styles', 'amalinkspro-tables'),
						// 	'default_value' => 0,
						// ),
						// array (
						// 	'key' => 'field_cqer34vt4y56y5',
						// 	'label' => __('ASIN Font Size', 'amalinkspro-tables'),
						// 	'name' => 'asin_font_size',
						// 	'type' => 'number',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_589757eb3af1a999',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_5899df7967928777',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_589a173174147666',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_589a24e769fcc555',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '33',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => 14,
						// 	'placeholder' => '',
						// 	'prepend' => '',
						// 	'append' => 'px',
						// 	'min' => '',
						// 	'max' => '',
						// 	'step' => '',
						// ),
						// array (
						// 	'key' => 'field_etv56y5b6yt3c4r',
						// 	'label' => __('ASIN Line Height', 'amalinkspro-tables'),
						// 	'name' => 'asin_line_height',
						// 	'type' => 'number',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_589757eb3af1a999',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_5899df7967928777',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_589a173174147666',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_589a24e769fcc555',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '33',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => 16,
						// 	'placeholder' => '',
						// 	'prepend' => '',
						// 	'append' => 'px',
						// 	'min' => '',
						// 	'max' => '',
						// 	'step' => '',
						// ),
						// array (
						// 	'key' => 'field_ev5tyb6un6i8n4',
						// 	'label' => __('ASIN Text Color', 'amalinkspro-tables'),
						// 	'name' => 'asin_text_color',
						// 	'type' => 'color_picker',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => array (
						// 		array (
						// 			array (
						// 				'field' => 'field_589757eb3af1a999',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_5899df7967928777',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_589a173174147666',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 			array (
						// 				'field' => 'field_589a24e769fcc555',
						// 				'operator' => '==',
						// 				'value' => '1',
						// 			),
						// 		),
						// 	),
						// 	'wrapper' => array (
						// 		'width' => '34',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => '#000',
						// ),
						array (
							'key' => 'field_589a24fe69fcd222',
							'label' => __('Enable Brand Field Styles', 'amalinkspro-tables'),
							'name' => 'enable_brand_field_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable "brand" field styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_2345cwrtbryyh4by6y56yb56',
							'label' => __('Brand Font Size', 'amalinkspro-tables'),
							'name' => 'brand_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a24fe69fcd222',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
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
							'key' => 'field_rtby57u68u78u78i78',
							'label' => __('Brand Line Height', 'amalinkspro-tables'),
							'name' => 'brand_line_height',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a24fe69fcd222',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
								'class' => '',
								'id' => '',
							),
							'default_value' => 16,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_2cr3c5v35v35353v5',
							'label' => __('Brand Text Color', 'amalinkspro-tables'),
							'name' => 'brand_text_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a24fe69fcd222',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '34',
								'class' => '',
								'id' => '',
							),
							'default_value' => '#000',
						),
						array (
							'key' => 'field_589a250969fce111',
							'label' => __('Enable Model Field Styles', 'amalinkspro-tables'),
							'name' => 'enable_model_field_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable "model" field styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_rebyutnitrbyetvcawtveyrbutn',
							'label' => __('Model Font Size', 'amalinkspro-tables'),
							'name' => 'model_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a250969fce111',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
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
							'key' => 'field_by76cr5ex46cr7tvy8bu',
							'label' => __('Model Line Height', 'amalinkspro-tables'),
							'name' => 'model_line_height',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a250969fce111',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
								'class' => '',
								'id' => '',
							),
							'default_value' => 16,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_8h7g6f54xerctvybu',
							'label' => __('Model Text Color', 'amalinkspro-tables'),
							'name' => 'model_text_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a250969fce111',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '34',
								'class' => '',
								'id' => '',
							),
							'default_value' => '#000',
						),
						array (
							'key' => 'field_589a251069fcf999',
							'label' => __('Enable UPC Field Styles', 'amalinkspro-tables'),
							'name' => 'enable_upc_field_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable "UPC" field styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_345b7nutyb5v4rcw4vetbryt',
							'label' => __('UPC Font Size', 'amalinkspro-tables'),
							'name' => 'upc_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a251069fcf999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
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
							'key' => 'field_uytv6rc8rcrynbd',
							'label' => __('UPC Line Height', 'amalinkspro-tables'),
							'name' => 'upc_line_height',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a251069fcf999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
								'class' => '',
								'id' => '',
							),
							'default_value' => 16,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_6tv5454tyvuyuibhbj',
							'label' => __('UPC Text Color', 'amalinkspro-tables'),
							'name' => 'upc_text_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a251069fcf999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '34',
								'class' => '',
								'id' => '',
							),
							'default_value' => '#000',
						),

						array (
							'key' => 'field_589a252469fd1777',
							'label' => __('Enable Warranty Field Styles', 'amalinkspro-tables'),
							'name' => 'enable_warranty_field_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable "warranty" field styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_76u6n7u7878u6uybyrt',
							'label' => __('Warranty Font Size', 'amalinkspro-tables'),
							'name' => 'warranty_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a252469fd1777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
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
							'key' => 'field_i7bywbr73byr93bruc3rbei',
							'label' => __('Warranty Line Height', 'amalinkspro-tables'),
							'name' => 'warranty_line_height',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a252469fd1777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33',
								'class' => '',
								'id' => '',
							),
							'default_value' => 16,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_67iu6y5fr4tyrgvbg',
							'label' => __('Warranty Text Color', 'amalinkspro-tables'),
							'name' => 'warranty_text_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a252469fd1777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '34',
								'class' => '',
								'id' => '',
							),
							'default_value' => '#000',
						),
						array (
							'key' => 'field_589a253769fd2666',
							'label' => __('Enable Price Field Styles', 'amalinkspro-tables'),
							'name' => 'enable_price_field_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable "price" field styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_ery6b5yu67u6uj65u',
							'label' => __('Sale Price Font Size', 'amalinkspro-tables'),
							'name' => 'sale_price_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a253769fd2666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 18,
							'placeholder' => '',
							'prepend' => '',
							'append' => 'px',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array (
							'key' => 'field_5e67h6u767uy4g56y3',
							'label' => __('Sale Price Color', 'amalinkspro-tables'),
							'name' => 'sale_price_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_589757eb3af1a999',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_5899df7967928777',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a173174147666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_589a253769fd2666',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '#3ABB22',
						),
						array (
							'key' => 'field_67t67r55ee45e5cry',
							'label' => __('Table Footer Styles', 'amalinkspro-tables'),
							'name' => '',
							'type' => 'message',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => 'amalinkspro-setting-heading',
								'id' => '',
							),
							'message' => '',
							'new_lines' => 'wpautop',
							'esc_html' => 0,
						),
						array (
							'key' => 'field_o7yb6vt5c4vt7by8333',
							'label' => __('Enable Table Footer Styles', 'amalinkspro-tables'),
							'name' => 'enable_table_footer_styles',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_45eft45345dt23t2',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => __('Check here to enable the table footer styles', 'amalinkspro-tables'),
							'default_value' => 0,
						),
						array (
							'key' => 'field_u6tv76t7tviyvyivui',
							'label' => __('Table Footer Background Color', 'amalinkspro-tables'),
							'name' => 'table_footer_bg_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_o7yb6vt5c4vt7by8333',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => '',
						),
						array (
							'key' => 'field_76rrc565ex44e54w5z',
							'label' => __('Table Footer Text Color', 'amalinkspro-tables'),
							'name' => 'table_footer_text_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_o7yb6vt5c4vt7by8333',
										'operator' => '==',
										'value' => '1',
									),
									array (
										'field' => 'field_45eft45345dt23t2',
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
							'default_value' => '#FFFFFF',
						),





						array (
							'key' => 'field_t6r5f56767r566tv7',
							'label' => __('Table Defaults', 'amalinkspro-tables' ),
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
							'key' => 'field_hyvrecserfr3ewrc',
							'label' => __('Table Default Button Text', 'amalinkspro-tables'),
							'name' => 'table_default_btn_text',
							'type' => 'text',
							'instructions' => __('Enter the default text you want to use for the buttons in the tables.', 'amalinkspro-tables'),
							'required' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 'No Results',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),


						array(
							'key' => 'field_5d75f7d151887',
							'label' => 'Enable the Table\'s Custom CTA Button Styles',
							'name' => 'enable_custom_cta_color',
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
							'key' => 'field_5d75f7dc51888',
							'label' => 'Choose Button Background Color',
							'name' => 'choose_button_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_5dgfgyhujbjn888',
							'label' => 'Choose Button Text Color',
							'name' => 'choose_button_text_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_5ddfgthyg6f56gy888',
							'label' => 'Choose Button Border Color',
							'name' => 'choose_button_border_color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_5thgrfergtr51888',
							'label' => 'Choose Button Background Color - Hover',
							'name' => 'choose_button_color_hover',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_5drgtrfgbfrn888',
							'label' => 'Choose Button Text Color - Hover',
							'name' => 'choose_button_text_color_hover',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_rfgthytgfrgtr8',
							'label' => 'Choose Button Border Color - Hover',
							'name' => 'choose_button_border_color_hover',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_xxxxxy7iooiucx64xz54',
							'label' => __('Table Button Font Size', 'amalinkspro'),
							'name' => 'table_btn_font_size',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_xxxxxferfreik7iuy',
							'label' => __('Table Button Font Style', 'amalinkspro-tables'),
							'name' => 'table_button_font_style',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5d75f7d151887',
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
								'italic' => __('Italic', 'amalinkspro')
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
							'key' => 'field_xxxxxxgw4x',
							'label' => __('Table Button Padding Top', 'amalinkspro-tables'),
							'name' => 'table_btn_padding_top',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_xxxxxxvhgufw4x',
							'label' => __('Table Button Padding Right', 'amalinkspro-tables'),
							'name' => 'table_btn_padding_right',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_xxxxxxxxssss4x',
							'label' => __('Table Button Padding Bottom', 'amalinkspro-tables'),
							'name' => 'table_btn_padding_bottom',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5d75f7d151887',
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
							'key' => 'field_bcrtdtrd65445dt4x',
							'label' => __('Table Button Padding Left', 'amalinkspro-tables'),
							'name' => 'table_btn_padding_left',
							'type' => 'number',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_5d75f7d151887',
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




					),
					'location' => array (
						array (
							array (
								'param' => 'options_page',
								'operator' => '==',
								'value' => 'amalinkspro-settings-tables',
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




		}




	}



	public function simple_tables_license_check() {

		global $wpdb;


		// our transient name
		$transient = 'amalinkspro_license_check_transient_arr_2';
		// check for our transient
		$transient_check = get_transient( $transient );

		if ($transient_check ) {
			$license_check_response = $transient_check;
			// rohitsharma-START
			return unserialize($license_check_response);
			// rohitsharma-END
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

	}





	function alp_addon_tablebuilder_start_function() {
		// $Ama_Links_Pro_Admin = New Ama_Links_Pro_Admin('','','AmaLinks Pro','');
  //   	$core_plug_incheck = $Ama_Links_Pro_Admin->simple_license_check();
  //   	$cpi = $core_plug_incheck->payment_id;
		// $cls = $core_plug_incheck->license;
  //   	$license_check = $this -> simple_tables_license_check();
		// $tpi = $license_check->payment_id;
		// $tls = $license_check->license;
		// $l = $this->get_cvals($cpi,$cls,$tpi,$tls);
		$status = get_option('amalinkspro_tables_license_status');
		// if ($l[0]==7 && $l[1]==5 && $l[2]==12 && $status=='valid'  ) :
		if ( $status=='valid'  ) :?>
			<div class="alp-tablebuilder-start"><p class="alp-tablebuilder-start-or">or <a class="button button-primary js-amalinkspro-launch-table-addon" data-alp-block="none">Table Builder</a></p><?php echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/amalinks-pro-table-builder-add-on-beta-flag.png" alt="AmaLinks Pro - Table Builder - BETA" />'; ?></div>
		<?php
		endif;
	}



	function amalinkspro_save_new_table() {

		if ( empty( $_REQUEST ) ) {
			echo 'Error 10457';
			wp_die();
		}

		$post_id = $_REQUEST['table_post_id'];
		$post_title = $_REQUEST['table_post_title'];
		$api_type = $_REQUEST['table_api_type'];
	
		
		$my_post = array(
			'ID'			=> $post_id,
			'post_type'     => 'amalinkspro-table',
		    'post_title'    => $post_title,
		    'post_content'  => '',
		    'post_status'   => 'publish',
		);
 

		$post_id = wp_insert_post( $my_post, $wp_error );

		if ($post_id && $api_type) {
			update_post_meta( $post_id, 'alp_table_api_type', $api_type );
		}

		$response = $post_id;

		echo $response;
		wp_die();


	}




	function amalinkspro_delete_table() {

		if ( empty( $_REQUEST ) ) {
			echo 'Error 10457';
			wp_die();
		}


		$post_id = $_REQUEST['table_post_id'];


		if ( $post_id ) {
			

			$current_post_meta = get_post_meta( $post_id );
			foreach( $current_post_meta as $key=>$val )  {
				// delete the meta data - WRITE A BETTER DELETE FUNCTION HERE!!
                delete_post_meta($post_id, $key);

            }

            wp_delete_post( $post_id, true );

		}

		$response = $post_id;

		wp_die();

	}


	function amalinkspro_edit_table() {

		if ( empty( $_REQUEST ) ) {
			echo 'Error 10457';
			wp_die();
		}

		$post_id = $_REQUEST['table_post_id'];


		if ( ! empty( $post_id  ) ) {
			$response['post_title'] = get_the_title($post_id);
		}


		echo json_encode($response);

		wp_die();

	}





	function amalinkspro_save_table_data() {

		if ( empty( $_REQUEST ) ) {
			echo 'Error 9386';
			wp_die();
		}

		$post_id = $_REQUEST['table_post_id'];
		$table_data = $_REQUEST['table_data_to_save'];

		// echo '$table_data<pre>'.print_r($table_data,1).'</pre>';
		// die();


		if ( !$post_id || !$table_data ) {
			echo 'The post_id or the table_data was missing.';
			wp_die();
		}



		if ( $table_data['columns_count'] ) { // we know we have a saved table. let's clear it to re-save

			$current_post_meta = get_post_meta( $post_id );

			foreach( $current_post_meta as $key=>$val )  {
				// delete the meta data - WRITE A BETTER DELETE FUNCTION HERE!!

				if ( $key != 'alp_table_api_type' ) {
					delete_post_meta($post_id, $key);
				}
                

            }

		}




		// if ( $table_data['columns_count'] ) {
		// 	update_post_meta( $post_id, 'alp_table_columns_count', $table_data['columns_count'] );
		// }
		if ( $table_data['columns_settings'] ) {

			$col_settings_arr = $table_data['columns_settings'];
			$i=0;
			foreach ( $col_settings_arr as $setting ) {
				update_post_meta( $post_id, 'alp_table_columns_settings_' . $i . '_hideForSm', $setting['hideForSm'] );
				update_post_meta( $post_id, 'alp_table_columns_settings_' . $i . '_hideForMd', $setting['hideForMd'] );
				update_post_meta( $post_id, 'alp_table_columns_settings_' . $i . '_hideForLg', $setting['hideForLg'] );
				update_post_meta( $post_id, 'alp_table_columns_settings_' . $i . '_verticalAlign', $setting['verticalAlign'] );
				update_post_meta( $post_id, 'alp_table_columns_settings_' . $i . '_horizontalAlign', $setting['horizontalAlign'] );
				update_post_meta( $post_id, 'alp_table_columns_settings_' . $i . '_linkCell', $setting['linkCell'] );
				update_post_meta( $post_id, 'alp_table_columns_settings_' . $i . '_disableSort', $setting['disableSort'] );
				$i++;
			}
			update_post_meta( $post_id, 'alp_table_columns_settings', $i );

		}


		if ( $table_data['columns'] ) {

			$columns = $table_data['columns'];
			$i=0;
			foreach ( $columns as $col ) {
				update_post_meta( $post_id, 'alp_table_columns_data_' . $i . '_name', $col['name'] );
				update_post_meta( $post_id, 'alp_table_columns_data_' . $i . '_type', $col['type'] );
				update_post_meta( $post_id, 'alp_table_columns_data_' . $i . '_width', $col['width'] );
				$i++;
			}
			update_post_meta( $post_id, 'alp_table_columns_data', $table_data['columns_count'] );

		}



		if ( $table_data['rows_count'] ) {
			update_post_meta( $post_id, 'alp_table_rows', $table_data['rows_count'] );
		}

		$featured_row = 'row-'.$table_data['featured_row'].'';
		if ( $featured_row ) {
			update_post_meta( $post_id, 'alp_featured_row', $featured_row );
		}



		if ( $table_data['rows'] ) {

			$rows = $table_data['rows'];
			$i=0;
			foreach ( $rows as $row ) {

				update_post_meta( $post_id, 'alp_table_rows_' . $i . '_settings', $row['rowSettings'] );
				update_post_meta( $post_id, 'alp_table_rows_' . $i . '_asin', $row['rowASIN'] );
				update_post_meta( $post_id, 'alp_table_rows_' . $i . '_url', $row['rowURL'] );

				if ( $row['rowCells'] ) {

					$rowCells = $row['rowCells'];
					$j=0;

					foreach ( $rowCells as $cell ) {

						$trimmed_html = trim( $cell['html'] );

						update_post_meta( $post_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_html', $trimmed_html );
						update_post_meta( $post_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_type', $cell['type'] );
						update_post_meta( $post_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_id', $cell['id'] );

						$j++;

					}

				}

				$i++;

			}

			// update_post_meta( $post_id, 'alp_table_columns_data', $i );

		}


		if ( $table_data['affiliate_id'] ) {
			update_post_meta( $post_id, 'alp_table_affiliate_link_id', $table_data['affiliate_id'] );
		}

		if ( $table_data['new_window'] == 'on' ) {
			update_post_meta( $post_id, 'alp_table_open_links_in_a_new_window','on' );
		}
		else {
			update_post_meta( $post_id, 'alp_table_open_links_in_a_new_window','off' );
		}

		if ( $table_data['nofollow'] == 'on' ) {
			update_post_meta( $post_id, 'alp_table_nofollow_links', 'on' );
		}
		else {
			update_post_meta( $post_id, 'alp_table_nofollow_links', 'off' );
		}

		if ( $table_data['addtocart'] == 'on' ) {
			update_post_meta( $post_id, 'alp_table_add_to_cart', 'on' );
		}
		else {
			update_post_meta( $post_id, 'alp_table_add_to_cart', 'off' );
		}
	
		$response = json_encode('success');

		echo $response;
		wp_die();


	}





	function amalinkspro_tablebuilder_function() {
		// $Ama_Links_Pro_Admin = New Ama_Links_Pro_Admin('','','AmaLinks Pro','');
  //   	$core_plug_incheck = $Ama_Links_Pro_Admin->simple_license_check();
  //   	$cpi = $core_plug_incheck->payment_id;
		// $cls = $core_plug_incheck->license;
  //   	$license_check = $this -> simple_tables_license_check();
		// $tpi = $license_check->payment_id;
		// $tls = $license_check->license;
		// $l = $this->get_cvals($cpi,$cls,$tpi,$tls);
		$status = get_option('amalinkspro_tables_license_status');
		if ($status== 'valid'  ):
		// if ($l[0]==7 && $l[1]==5 && $l[2]==12 && $status== 'valid'  ):
		?>
		<div id="amalinkspro-tablebuilder" class="amalinkspro-tablebuilder">

			<?php
			$cta_default = 'Buy Now';
			
			if ( get_option('amalinkspro-settings-tables_table_default_btn_text') ) {
				$cta_default = get_option('amalinkspro-settings-tables_table_default_btn_text', true);
			}
			
			?>

		<div class="amalinkspro-media-window-title alp-table-title" data-alp-cta-default="<?php echo $cta_default; ?>">
			<span class="amalinkspro-close-tablebuilder-modal"></span>
			<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' )  ) : ?>
				<h1><span class="alp-tb-title-nonapi-tag">Non-API Mode</span><?php _e('Product Comparison Table Builder', 'amalinkspro-tables'); ?></h1>
			<?php else: ?>
				<h1><?php _e('Product Comparison Table Builder', 'amalinkspro-tables'); ?></h1>
			<?php endif; ?>
		</div>


		<div class="amalinkspro-tablebuilder-table-post-editor">
			<div class="amalinkspro-tablebuilder-table-post-editor-inner">
				<h1><?php _e('Create a New Table', 'amalinkspro-tables'); ?></h1>

				<form id="alp-new-table-post-form" data-alp-table-post-id="0">
					<span class="post-id"></span>
					<input id="new-alp-table-title" class="new-alp-table-title" type="text" value="" placeholder="Give your Table a Name" />
				</form>

				<a class="js-alp-table-alp_save_new_table amalinkspro-add-table-btn" href="#"><?php _e('Save Table and Continue','amalinkspro-tables'); ?></a>

				<a class="alp-js-cancel-new-table" href="#">Cancel</a>

			</div>
		</div>



		<div class="amalinkspro-tablebuilder-search" data-alp-selected-products="none">

			<a class="alp-js-insert-product-rows" href="#">Click Here to Insert Selections</a>
			<span class="alp-js-close-tablebuilder-product-search"></span>

			<div class="amalinkspro-tablebuilder-search-inner">

				<div class="amalinkspro-popup-form">


					<?php
					$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
					$associate_ids_field = 'amalinkspro-options_'.$locale.'_amazon_associate_ids';
					$associate_ids = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids' );

					//echo '<p>' . __('Your chosen Locale is','amalinkspro') . ': <strong>'.$locale.'</strong>. ' . __( 'You have associated these Amazon Associate Tracking IDs with this locale.','amalinkspro') .'</p>';

					echo '<div class="api5-choose-id">';
					echo '<h3>* Choose your Amazon Tracking ID</h3>';
					if( $associate_ids ) {
					  echo '<select id="alp-api5-select-id-tables">';
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
					?>

		    		<h2>Add Some Rows - Find Products by Keyword or ASIN</h2>
		    		<p>
		    			<input id="amalinkspro-search-keyword-tablebuilder" name="amalinkspro-search-keyword-tablebuilder" value="" type="text" placeholder="Enter your search term or ASIN here">
		    			<input id="amalinkspro-search-locale-tablebuilder" type="hidden" name="amalinkspro-search-locale" value="US">
		    			<a class="button button-primary button-large js-amalinkspro-tablebuilder-search">Search</a>
		    			<img class="amalinkspro-search-loading-gif" src="/wp-admin/images/loading.gif" alt="loading">
		    		</p>
			
				</div>


				<div id="amalinkspro-tablebuilder-search-results" class="amalinkspro-tablebuilder-search-results">

				</div>

				<div class="amalinkspro-table-search-pagination">
					<span class="alp-table-search-page current" data-api-page="1">Page 1</span>
					<span class="alp-table-search-page" data-api-page="2">2</span>
					<span class="alp-table-search-page" data-api-page="3">3</span>
					<span class="alp-table-search-page" data-api-page="4">4</span>
					<span class="alp-table-search-page" data-api-page="5">5</span>
				</div>


			</div>
		</div>



		<div class="amalinkspro-tablebuilder-img-chooser">

			<span class="alp-js-close-tablebuilder-img-chooser"></span>

			<div class="amalinkspro-tablebuilder-img-chooser-inner">

				<div class="amalinkspro-popup-form">
					<h2>Choose an Image</h2>

					<div class="amalinkspro-tablebuilder-img-chooser-choices"><div class="amalinkspro-loading-overlay"><span class="alp-spinner"></span></div></div>

				</div>
			</div>
		</div>




		<div class="amalinkspro-tablebuilder-manage">
			<div class="amalinkspro-tablebuilder-manage-inner">

				<div class="amalinkspro-tablebuilder-dashboard">

					<h1><i class="icon-amalinkspro-link-icon"></i> <?php _e('Comparison Tables - Dashboard', 'amalinkspro-tables'); ?></h1>


					<div class="amalinkspro-tablebuilder-dashboard-controls">
						<a class="js-amalinkspro-add-table amalinkspro-add-table-btn" href="#"><?php _e('Add Table','amalinkspro-table'); ?> <i class="icon-amalinkspro-right-open"></i></a>
					</div>


					<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' )  ) {
						$meta_query_1 = array(
							'relation' => 'OR',  
						       array(
						         'key' => 'alp_table_api_type',
						         'value' => 'noapi',
						         'compare' => '=='
						       )
							);

						$meta_query_2 = array(
							'relation' => 'OR',  
						       array(
						         'key' => 'alp_table_api_type',
						         'value' => 'noapi',
						         'compare' => '!='
						       ),
						       array(
						         'key' => 'alp_table_api_type',
						         'value' => 'noapi',
						         'compare' => 'NOT EXISTS'
						       )
							);

						$tables_title_1 = 'NO-API Product Comparison Tables';
						$tables_title_2 = 'API Product Comparison Tables (Not editable in non-API mode)';

						$tables_class_1 = ' noapi-tables-list';
						$tables_class_2 = ' api-tables-list';

					}

					else {

						$meta_query_1 = array(
							'relation' => 'OR',  
						       array(
						         'key' => 'alp_table_api_type',
						         'value' => 'noapi',
						         'compare' => '!='
						       ),
						       array(
						         'key' => 'alp_table_api_type',
						         'value' => 'noapi',
						         'compare' => 'NOT EXISTS'
						       )
							);

						$meta_query_2 = array(
							'relation' => 'OR',  
						       array(
						         'key' => 'alp_table_api_type',
						         'value' => 'noapi',
						         'compare' => '=='
						       )
							);

						$tables_title_1 = 'API Product Comparison Tables';
						$tables_title_2 = 'NO-API Product Comparison Tables (Not editable in API mode)';

						$tables_class_1 = ' api-tables-list';
						$tables_class_2 = ' noapi-tables-list';

					}
					?>


					<div class="amalinkspro-tablebuilder-dashboard-table-list<?php echo $tables_class_1; ?>">

						<h2><?php echo $tables_title_1; ?></h2>


						<div class="alp-posts">

								<div class="alp-posts-tr">

									<div class="alp-posts-tr-th">
										<span class="">Table Title/Shortcode</span>
									</div>


									<div class="alp-posts-tr-th">
										<span class="">Insert</span>
									</div>

									<div class="alp-posts-tr-th">
										<span class="">Last Update</span>
									</div>

									<div class="alp-posts-tr-th">
										<span class="">Manage</span>
									</div>

								</div>
								
							

							<?php
							$args = array( 
								'post_type' => 'amalinkspro-table',
								'posts_per_page' => -1,
								'orderby' => 'date',
								'order' => 'DESC',
								'meta_query' => $meta_query_1
							);

							$the_query = new WP_Query( $args );

							?>

							<?php if ( $the_query->have_posts() ) : ?>

								

									<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
										
										

											<div class="alp-posts-tr" data-alp-table-id="<?php echo get_the_ID(); ?>">

												<?php
												if ( get_post_meta( get_the_ID(), 'alp_table_affiliate_link_id', true) ) {
													$affiliate_id = get_post_meta( get_the_ID(), 'alp_table_affiliate_link_id', true );
												}
												else if ( get_option( 'amalinkspro-options_default_amazon_search_locale' ) ) {
													$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
													$affiliate_id = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_0_associate_id' );
												}
												else {
													$affiliate_id = '';
												}


												if ( get_post_meta( get_the_ID(), 'alp_table_open_links_in_a_new_window', true) == 'on' ) {
													$new_window = get_post_meta( get_the_ID(), 'alp_table_open_links_in_a_new_window', true );
												}
												else if ( get_option('amalinkspro-options_open_links_in_a_new_window') == 1 ) {
													$new_window = 'on';
												}
												else {
													$new_window = 'off';
												}
												

												if ( get_post_meta( get_the_ID(), 'alp_table_nofollow_links', true) == 'on' ) {
													$nofollow = get_post_meta( get_the_ID(), 'alp_table_nofollow_links', true );
												}
												else if ( get_option('amalinkspro-options_nofollow_links' == 1 ) ) {
													$nofollow = 'on';
												}
												else {
													$nofollow = 'off';
												}


												if ( get_post_meta( get_the_ID(), 'alp_table_add_to_cart', true) == 'on' ) {
													$add_to_cart = get_post_meta( get_the_ID(), 'alp_table_add_to_cart', true );
												}
												else if ( get_option('amalinkspro-options_add_to_cart' == 1 ) ) {
													$add_to_cart = 'on';
												}
												else {
													$add_to_cart = 'off';
												}
												?>

												<div class="alp-posts-tr-td">
														<span class="alp-posts-tr-td-shortcode-title"><span class="table-id">#<?php echo get_the_ID(); ?> - </span> <?php the_title(); ?></span>
												</div>


												<div class="alp-posts-tr-td" data-aff-id="<?php echo $affiliate_id; ?>" data-new-window="<?php echo $new_window; ?>" data-nofollow="<?php echo $nofollow; ?>" data-addtocart="<?php echo $add_to_cart; ?>">
													<p><a href="#" class="js-insert-table-shortcode-into-editor-from-all">Insert into Classic Editor</a></p>
													<p><a href="#" class="js-insert-table-shortcode-into-block-from-all">Insert into Gutenberg</a></p>
												</div>

												<div class="alp-posts-tr-td">
													<span class=""><?php the_modified_date('m/d/Y'); ?></span>
												</div>

												<div class="alp-posts-tr-td" data-alp-table-id="<?php echo get_the_ID(); ?>">
													<div>
														<i class="icon-amalinkspro-edit alp-js-edit-table"></i>
														<i class="icon-amalinkspro-trash alp-js-delete-table"></i>
														<i class="icon-amalinkspro-cog alp-js-edit-table-settings"></i>
														<span class="shortcode-copy-link alp-js-copy-table-shortcode">[&nbsp;/]</span>
														<p class="alp-posts-tr-td-shortcode">[amalinkspro_table id="<?php echo get_the_ID(); ?>" aff-id="<?php echo $affiliate_id; ?>" new-window="<?php echo $new_window; ?>" nofollow="<?php echo $nofollow; ?>" addtocart="<?php echo $add_to_cart; ?>" /]<span class="alp-close-popup-shortcode"></span></p>	
													</div>												
												</div>

											</div>

										

									<?php endwhile; ?>

								


							<?php else: ?>

								<div class="alp-posts-tr alp-posts-tr-tbody alp-posts-notables" data-alp-table-id="<?php echo get_the_ID(); ?>">
									<p class="alp-js-create-table"><?php _e('There are no Tables Yet','amalinkspro-tables') ;?> </p>
								</div>


							<?php endif; ?>



							
						</div>


					</div>




					<div class="amalinkspro-tablebuilder-dashboard-table-list<?php echo $tables_class_2; ?>">

						<h2><?php echo $tables_title_2; ?></h2>


						<div class="alp-posts">

								<div class="alp-posts-tr">

									<div class="alp-posts-tr-th">
										<span class="">Table Title/Shortcode</span>
									</div>


									<div class="alp-posts-tr-th">
										<span class="">Insert</span>
									</div>

									<div class="alp-posts-tr-th">
										<span class="">Last Update</span>
									</div>

									<div class="alp-posts-tr-th">
										<span class="">Manage</span>
									</div>

								</div>
								
							

							<?php
							$args = array( 
								'post_type' => 'amalinkspro-table',
								'posts_per_page' => -1,
								'orderby' => 'date',
								'order' => 'DESC',
								'meta_query' => $meta_query_2
							);

							$the_query = new WP_Query( $args );

							?>

							<?php if ( $the_query->have_posts() ) : ?>

								

									<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
										
										

											<div class="alp-posts-tr" data-alp-table-id="<?php echo get_the_ID(); ?>">

												<?php
												if ( get_post_meta( get_the_ID(), 'alp_table_affiliate_link_id', true) ) {
													$affiliate_id = get_post_meta( get_the_ID(), 'alp_table_affiliate_link_id', true );
												}
												else if ( get_option( 'amalinkspro-options_default_amazon_search_locale' ) ) {
													$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
													$affiliate_id = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_0_associate_id' );
												}
												else {
													$affiliate_id = '';
												}


												if ( get_post_meta( get_the_ID(), 'alp_table_open_links_in_a_new_window', true) == 'on' ) {
													$new_window = get_post_meta( get_the_ID(), 'alp_table_open_links_in_a_new_window', true );
												}
												else if ( get_option('amalinkspro-options_open_links_in_a_new_window') == 1 ) {
													$new_window = 'on';
												}
												else {
													$new_window = 'off';
												}
												

												if ( get_post_meta( get_the_ID(), 'alp_table_nofollow_links', true) == 'on' ) {
													$nofollow = get_post_meta( get_the_ID(), 'alp_table_nofollow_links', true );
												}
												else if ( get_option('amalinkspro-options_nofollow_links' == 1 ) ) {
													$nofollow = 'on';
												}
												else {
													$nofollow = 'off';
												}


												if ( get_post_meta( get_the_ID(), 'alp_table_add_to_cart', true) == 'on' ) {
													$add_to_cart = get_post_meta( get_the_ID(), 'alp_table_add_to_cart', true );
												}
												else if ( get_option('amalinkspro-options_add_to_cart' == 1 ) ) {
													$add_to_cart = 'on';
												}
												else {
													$add_to_cart = 'off';
												}
												?>

												<div class="alp-posts-tr-td">
														<span class="alp-posts-tr-td-shortcode-title"><span class="table-id">#<?php echo get_the_ID(); ?> - </span> <?php the_title(); ?></span>
												</div>


												<div class="alp-posts-tr-td" data-aff-id="<?php echo $affiliate_id; ?>" data-new-window="<?php echo $new_window; ?>" data-nofollow="<?php echo $nofollow; ?>" data-addtocart="<?php echo $add_to_cart; ?>">
													<p><a href="#" class="js-insert-table-shortcode-into-editor-from-all">Insert into Classic Editor</a></p>
													<p><a href="#" class="js-insert-table-shortcode-into-block-from-all">Insert into Gutenberg</a></p>
												</div>

												<div class="alp-posts-tr-td">
													<span class=""><?php the_modified_date('m/d/Y'); ?></span>
												</div>

												<div class="alp-posts-tr-td" data-alp-table-id="<?php echo get_the_ID(); ?>">
													<div>
														<i class="icon-amalinkspro-trash alp-js-delete-table"></i>
														<i class="icon-amalinkspro-cog alp-js-edit-table-settings"></i>
														<span class="shortcode-copy-link alp-js-copy-table-shortcode">[&nbsp;/]</span>
														<p class="alp-posts-tr-td-shortcode">[amalinkspro_table id="<?php echo get_the_ID(); ?>" aff-id="<?php echo $affiliate_id; ?>" new-window="<?php echo $new_window; ?>" nofollow="<?php echo $nofollow; ?>" addtocart="<?php echo $add_to_cart; ?>" /]</p>	
													</div>												
												</div>

											</div>

										

									<?php endwhile; ?>

								


							<?php else: ?>

								<div class="alp-posts-tr alp-posts-tr-tbody alp-posts-notables" data-alp-table-id="<?php echo get_the_ID(); ?>">
									<p class="alp-js-create-table"><?php _e('There are no Tables Yet','amalinkspro-tables') ;?> </p>
								</div>


							<?php endif; ?>



							
						</div>


					</div>

						


				</div>

			</div>
		</div>




		<div class="amalinkspro-tablebuilder-tablebuilder">



			<div class="amalinkspro-tablebuilder-tablebuilder-inner">

				<div id="amalinkspro-tablebuilder-preview-wrap" class="amalinkspro-tablebuilder-preview-wrap alp-table-wrapper"></div>

				<div class="amalinkspro-tablebuilder-wrap">

					<div class="alp-table-wrapper amalinkspro-tablebuilder-table" 
						data-alp-table-new="1" 
						data-alp-table-id="0">




						<?php // echo function amalinkspro_load_table_into_editor() { ?>

						

						<div class="alp-table-editor-add-row"><i class="icon-amalinkspro-plus" title="Add a Product Row"></i></div>
						<div class="alp-table-editor-add-column"><i class="icon-amalinkspro-plus" title="Add a Column"></i></div>

						<div id="alp-table-add-column" class="alp-table-add-column" data-alp-addcol-type="0" data-alp-addcol-th-text="Click to Edit" data-alp-addcol-hide-sm="0"  data-alp-addcol-hide-md="0" data-alp-addcol-hide-lg="0">

							<span class="alp-js-close-col-settings"></span>

							<!-- <div class="alp-table-add-column-inner"> -->
								

								<form class="alp-add-column-form">

									<div class="alp-table-addcol-step1">

										<label><?php _e('Choose a Column Type', 'amalinkspro-tables'); ?></label>
										<select class="alp-table-addcol-type">
											<option>- select -</option>
											<option value="custom"><?php _e('Custom Text', 'amalinkspro-tables'); ?></option>
											<option value="title"><?php _e('Title', 'amalinkspro-tables'); ?></option>
											<?php if ( !get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>
												<option value="prime"><?php _e('Prime', 'amalinkspro-tables'); ?></option>
											<?php endif; ?>
											<!-- <option value="price-list"><?php _e('List Price', 'amalinkspro-tables'); ?></option> -->
											<?php if ( !get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>
												<option value="price-offer"><?php _e('Offer Price', 'amalinkspro-tables'); ?></option>
											<?php endif; ?>
											<!-- <option value="price-lowest-new-price"><?php _e('Lowest New Price', 'amalinkspro-tables'); ?></option>
											<option value="price-lowest-used-price"><?php _e('Lowest Used Price', 'amalinkspro-tables'); ?></option> -->
											<?php if ( !get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>
												<option value="image"><?php _e('API Image', 'amalinkspro-tables'); ?></option>
											<?php endif; ?>
											<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>
												<option value="image-sitestripe"><?php _e('SiteStripe Image', 'amalinkspro-tables'); ?></option>
											<?php endif; ?>
											<option value="cta-btn"><?php _e('Button', 'amalinkspro-tables'); ?></option>
											<!-- <option value="features"><?php _e('Features', 'amalinkspro-tables'); ?></option> -->
											<option value="brand"><?php _e('Brand', 'amalinkspro-tables'); ?></option>
											<option value="model"><?php _e('Model', 'amalinkspro-tables'); ?></option>
											<!-- <option value="manufacturer"><?php _e('Manufacturer', 'amalinkspro-tables'); ?></option> -->
											<!-- <option value="upc"><?php _e('UPC', 'amalinkspro-tables'); ?></option>-->
											<option value="warranty"><?php _e('Warranty', 'amalinkspro-tables'); ?></option>
											<option value="author"><?php _e('Books - Author', 'amalinkspro-tables'); ?></option>
											<!-- <option value="binding"><?php _e('Books - Binding', 'amalinkspro-tables'); ?></option> -->
											<!-- <option value="edition"><?php _e('Books - Edition', 'amalinkspro-tables'); ?></option> -->
											<option value="number-of-pages"><?php _e('Books - Number of Pages', 'amalinkspro-tables'); ?></option>
											<option value="publication-date"><?php _e('Books - Publication Date', 'amalinkspro-tables'); ?></option>
											<!-- <option value="publisher"><?php _e('Books - Publisher', 'amalinkspro-tables'); ?></option> -->
											<option value="release-date"><?php _e('Books - Release Date', 'amalinkspro-tables'); ?></option>
											<!-- <option value="studio"><?php _e('Books - Studio', 'amalinkspro-tables'); ?></option> -->
										</select>

									</div>


									<div class="alp-table-addcol-step3">

										<a class="alp-button alp-table-add-col-insert" href="#">Insert Column</a>

									</div>

								</form>

							<!-- </div> -->

						</div>

					</div>



				</div>

			</div>





		</div>

		<div class="amalinkspro-tablebuilder-sidebar">

			<div class="amalinkspro-tablebuilder-sidebar-buttons">
				<h3><?php _e('Table Options', 'amalinkspro-tables'); ?></h3>
				<ul>
					<li>
						<a href="#" class="js-alp-save-table-data"><?php _e('Save Table', 'amalinkspro-tables'); ?></a>
					</li>
					<li>
						<a href="#" class="js-alp-preview-table"><?php _e('Preview Table', 'amalinkspro-tables'); ?></a>
					</li>
					<li>
						<a href="#" class="js-alp-back-all-tables"><?php _e('Back to All Tables', 'amalinkspro-tables'); ?></a>
					</li>
					<li class="alp-insert-table-into-editor">
						<a href="#" class="js-insert-table-shortcode-into-editor">Insert into Classic Editor</a>
					</li>
					<li class="alp-insert-table-into-gutenberg">
						<a href="#" class="js-insert-table-shortcode-into-block">Insert into Gutenberg</a>
					</li>
				</ul>

			</div>


			<div class="amalinkspro-tablebuilder-sidebar-settings amalinkspro-tablebuilder-sidebar-settings-basic">

<!-- 				<h4><?php _e('Link Settings', 'amalinkspro-tables'); ?></h4> -->

				<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Link Settings','amalinkspro'); ?></h2>

	    		<p><?php _e('Your Global Link Settings have been automatically loaded. You can override them here. Your final link will be built using these options.','amalinkspro'); ?></p>

	    		<form class="amalinkspro-associate-ids-form">
<!--
	    			<div class="alp-step3-setting-wrap amalinkspro-choose-associate-id-wrap">

	    			<h3><?php _e('Choose Your Affiliate ID','amalinkspro'); ?></h3>

	    				<?php 
	    				$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
	    				$associate_ids_field = 'amalinkspro-options_'.$locale.'_amazon_associate_ids';
	    				$associate_ids = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids' );

	    				echo '<p>' . __('Your chosen Locale is','amalinkspro') . ': <strong>'.$locale.'</strong>. ' . __( 'You have associated these Amazon Associate Tracking IDs with this locale.','amalinkspro') .'</p>';

						if( $associate_ids ) {
							echo '<select class="amalinkspro-table-choose-associate-id-select">';
							for( $i = 0; $i < $associate_ids; $i++ ) {
								$id = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_'.$i.'_associate_id' );
								if ($i == 0) {$checked=' selected=selected';} else {$checked='';}
								echo '<option value="'.$id.'"'.$checked.'>'.$id.'</option>';
							}
							echo '</select>';
						}
	    				?>
	    				
	    			</div>
-->
		    		<div class="alp-step3-setting-wrap">
		    			<h3><?php _e('Open Links in a New Window','amalinkspro'); ?></h3>
						<input id="alp-new-window" type="checkbox" value="" /><label><?php _e('Check this box','amalinkspro'); ?></label>
					</div>

					<div class="alp-step3-setting-wrap">
		    			<h3>NoFollow Links</h3>
						<input id="alp-nofollow" type="checkbox" value="" /><label><?php _e('Check this box to open add a re="nofollow" tag to all links in this table. Note: sometimes WordPress strips this out.','amalinkspro'); ?></label>
					</div>

					<div class="alp-step3-setting-wrap">
		    			<h3><?php _e('Add to Cart','amalinkspro'); ?></h3>
						<input id="alp-addtocart" type="checkbox" value="" /><label><?php _e('I want AmaLinks Pro to have my links add a product to a visitor\'s Amazon cart in this table','amalinkspro'); ?></label>
					</div>


				</form>

			</div>


			<!-- <div class="amalinkspro-tablebuilder-sidebar-settings amalinkspro-tablebuilder-sidebar-settings-advanced">

				<h3><?php _e('Advanced Settings', 'amalinkspro-tables'); ?></h3>

			</div> -->


		</div>



		<div class="amalinkspro-tablebuilder-loading-overlay amalinkspro-loading-overlay"><span class="alp-spinner"></span></div>

	</div>



	<?php
	endif;
	}






	function amalinkspro_load_table_into_editor() {


		if ( empty( $_POST ) ) {
			echo 'Error 9386';
			wp_die();
		}

		$table_id = $_POST['table_id'];


		if ( $table_id == '0' || ( $table_id != '0' && !get_post_meta( $table_id, 'alp_table_rows' ) ) ) {

			// echo '$table_id: ' . $table_id;

			ob_start();
			?>

			<?php
			// echo $this->alp_get_table_global_styles_for_editor(); 
			$table_settings = $this->get_amalinkspro_tables_attributes();

			if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) {
				$num_rows = '1';
			}
			else {
				$num_rows = '0';
			}

			?>

				<table id="alp-table" data-alp-table-id="<?php echo $table_id; ?>" data-alp-table-cols="5" 
						data-alp-table-rows="<?php echo $num_rows; ?>" class="amalinkspro-comparison-table amalinkspro-comparison-table-admin amalinkspro-comparison-table-admin-editor" <?php echo $table_settings; ?>>

					<thead>

						<tr class="no-table-rows no-table-rows-thead th-settings">

							<th>&nbsp;</th>

							<th class="draggable" 
								data-alp-table-hide-for-sm="0" 
								data-alp-table-hide-for-md="0" 
								data-alp-table-hide-for-lg="0" 
								data-alp-table-v-align="middle" 
								data-alp-table-h-align="center" 
								data-alp-table-col-link="0" 
								data-alp-table-col-disable-sort="0"
								>

								<span class="icon-amalinkspro-drag" title="Drag left or Right"></span>
								<span class="icon-amalinkspro-cog js-alp-column-settings" title="Column Settings"></span>
								<span class="icon-amalinkspro-trash js-alp-delete-column" title="Delete Column"></span>

								<div class="alp-table-editor-col-settings">

									<div class="alp-table-editor-col-settings-slide alp-responsive test" data-col-settings-slide="1">

										<span class="alp-table-editor-col-settings-title"><?php _e('1/4<br />Hide this column on', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-responsive">

											<label title="Hide on Small Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-phone"></i>
												<input type="checkbox" value="hide-on-mobile">
											</label>

											<label title="Hide on Medium Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-tablet"></i>
												<input type="checkbox" value="hide-on-tablet">
											</label>

											<label title="Hide on Large Screens Phones">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-desktop"></i>
												<input type="checkbox" value="hide-on-desktop">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="2">
										<span class="alp-table-editor-col-settings-title"><?php _e('2/4<br />Vertical Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-v-align">

											<label title="Align Top">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-v" value="top">
											</label>

											<label title="Align Middle">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-v" value="middle" checked=checked>
											</label>

											<label title="Align Bottom">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-v" value="bottom">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="3">
										<span class="alp-table-editor-col-settings-title"><?php _e('3/4<br />Horizontal Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-h-align">

											<label title="Align Left">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-h" value="left" checked=checked>
											</label>

											<label title="Align Center">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-h" value="center">
											</label>

											<label title="Align Right">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-h" value="right">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>


									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="4">

										<span class="alp-table-editor-col-settings-title"><?php _e('4/4<br />Additional Settings', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-additional">

											<div class="alp-settings-form-inner">

												<label title="Link Cells"><input type="checkbox" value="link-cells"> Link Cells</label>

												<label title="Disable Sorting if Enabled on this Table"><input type="checkbox" value="disable-sort"> Disable Sorting</label>

											</div>
										</form>

									</div>

									<span class="alp-js-close-col-settings"></span>

									<span class="alp-col-settings-prev icon-amalinkspro-left-open" data-alp-next-setting="4"></span>
									<span class="alp-col-settings-next icon-amalinkspro-right-open" data-alp-next-setting="2"></span>

								</div>
							</th>
							<th class="draggable" 
								data-alp-table-hide-for-sm="0" 
								data-alp-table-hide-for-md="0" 
								data-alp-table-hide-for-lg="0" 
								data-alp-table-v-align="middle" 
								data-alp-table-h-align="center" 
								data-alp-table-col-link="0" 
								data-alp-table-col-disable-sort="0"
								>

								<span class="icon-amalinkspro-drag" title="Drag left or Right"></span>
								<span class="icon-amalinkspro-cog js-alp-column-settings" title="Column Settings"></span>
								<span class="icon-amalinkspro-trash js-alp-delete-column" title="Delete Column"></span>

								<div class="alp-table-editor-col-settings">

									<div class="alp-table-editor-col-settings-slide alp-responsive" data-col-settings-slide="1">

										<span class="alp-table-editor-col-settings-title"><?php _e('1/4<br />Hide this column on', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-responsive">

											<label title="Hide on Small Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-phone"></i>
												<input type="checkbox" value="hide-on-mobile">
											</label>

											<label title="Hide on Medium Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-tablet"></i>
												<input type="checkbox" value="hide-on-tablet">
											</label>

											<label title="Hide on Large Screens Phones">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-desktop"></i>
												<input type="checkbox" value="hide-on-desktop">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="2">
										<span class="alp-table-editor-col-settings-title"><?php _e('2/4<br />Vertical Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-v-align">

											<label title="Align Top">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-v" value="top">
											</label>

											<label title="Align Middle">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-v" value="middle" checked=checked>
											</label>

											<label title="Align Bottom">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-v" value="bottom">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="3">
										<span class="alp-table-editor-col-settings-title"><?php _e('3/4<br />Horizontal Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-h-align">

											<label title="Align Left">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-h" value="left" checked=checked>
											</label>

											<label title="Align Center">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-h" value="center">
											</label>

											<label title="Align Right">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-h" value="right">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>


									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="4">

										<span class="alp-table-editor-col-settings-title"><?php _e('4/4<br />Additional Settings', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-additional">

											<div class="alp-setitngs-form-inner">

												<label title="Link Cells"><input type="checkbox" value="link-cells"> Link Cells</label>

												<label title="Disable Sorting if Enabled on this Table"><input type="checkbox" value="disable-sort"> Disable Sorting</label>

											</div>

										</form>

									</div>

									<span class="alp-js-close-col-settings"></span>

									<span class="alp-col-settings-prev icon-amalinkspro-left-open" data-alp-next-setting="4"></span>
									<span class="alp-col-settings-next icon-amalinkspro-right-open" data-alp-next-setting="2"></span>

								</div>
							</th>
							<th class="draggable" 
								data-alp-table-hide-for-sm="0" 
								data-alp-table-hide-for-md="0" 
								data-alp-table-hide-for-lg="0" 
								data-alp-table-v-align="middle" 
								data-alp-table-h-align="center" 
								data-alp-table-col-link="0" 
								data-alp-table-col-disable-sort="0"
								>

								<span class="icon-amalinkspro-drag" title="Drag left or Right"></span>
								<span class="icon-amalinkspro-cog js-alp-column-settings" title="Column Settings"></span>
								<span class="icon-amalinkspro-trash js-alp-delete-column" title="Delete Column"></span>

								<div class="alp-table-editor-col-settings">

									<div class="alp-table-editor-col-settings-slide alp-responsive" data-col-settings-slide="1">

										<span class="alp-table-editor-col-settings-title"><?php _e('1/4<br />Hide this column on', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-responsive">

											<label title="Hide on Small Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-phone"></i>
												<input type="checkbox" value="hide-on-mobile">
											</label>

											<label title="Hide on Medium Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-tablet"></i>
												<input type="checkbox" value="hide-on-tablet">
											</label>

											<label title="Hide on Large Screens Phones">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-desktop"></i>
												<input type="checkbox" value="hide-on-desktop">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="2">
										<span class="alp-table-editor-col-settings-title"><?php _e('2/4<br />Vertical Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-v-align">

											<label title="Align Top">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-v" value="top">
											</label>

											<label title="Align Middle">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-v" value="middle" checked=checked>
											</label>

											<label title="Align Bottom">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-v" value="bottom">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="3">
										<span class="alp-table-editor-col-settings-title"><?php _e('3/4<br />Horizontal Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-h-align">

											<label title="Align Left">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-h" value="left" checked=checked>
											</label>

											<label title="Align Center">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-h" value="center">
											</label>

											<label title="Align Right">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-h" value="right">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>


									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="4">

										<span class="alp-table-editor-col-settings-title"><?php _e('4/4<br />Additional Settings', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-additional">

											<div class="alp-setitngs-form-inner">

												<label title="Link Cells"><input type="checkbox" value="link-cells"> Link Cells</label>

												<label title="Disable Sorting if Enabled on this Table"><input type="checkbox" value="disable-sort"> Disable Sorting</label>

											</div>

										</form>

									</div>

									<span class="alp-js-close-col-settings"></span>

									<span class="alp-col-settings-prev icon-amalinkspro-left-open" data-alp-next-setting="3"></span>
									<span class="alp-col-settings-next icon-amalinkspro-right-open" data-alp-next-setting="2"></span>

								</div>
							</th>
							<th class="draggable" 
								data-alp-table-hide-for-sm="0" 
								data-alp-table-hide-for-md="0" 
								data-alp-table-hide-for-lg="0" 
								data-alp-table-v-align="middle" 
								data-alp-table-h-align="center" 
								data-alp-table-col-link="0" 
								data-alp-table-col-disable-sort="0"
								>

								<span class="icon-amalinkspro-drag" title="Drag left or Right"></span>
								<span class="icon-amalinkspro-cog js-alp-column-settings" title="Column Settings"></span>
								<span class="icon-amalinkspro-trash js-alp-delete-column" title="Delete Column"></span>

								<div class="alp-table-editor-col-settings">

									<div class="alp-table-editor-col-settings-slide alp-responsive" data-col-settings-slide="1">

										<span class="alp-table-editor-col-settings-title"><?php _e('1/4<br />Hide this column on', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-responsive">

											<label title="Hide on Small Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-phone"></i>
												<input type="checkbox" value="hide-on-mobile">
											</label>

											<label title="Hide on Medium Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-tablet"></i>
												<input type="checkbox" value="hide-on-tablet">
											</label>

											<label title="Hide on Large Screens Phones">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-desktop"></i>
												<input type="checkbox" value="hide-on-desktop">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="2">
										<span class="alp-table-editor-col-settings-title"><?php _e('2/4<br />Vertical Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-v-align">

											<label title="Align Top">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-v" value="top">
											</label>

											<label title="Align Middle">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-v" value="middle" checked=checked>
											</label>

											<label title="Align Bottom">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-v" value="bottom">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="3">
										<span class="alp-table-editor-col-settings-title"><?php _e('3/4<br />Horizontal Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-h-align">

											<label title="Align Left">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-h" value="left" checked=checked>
											</label>

											<label title="Align Center">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-h" value="center">
											</label>

											<label title="Align Right">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-h" value="right">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>


									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="4">

										<span class="alp-table-editor-col-settings-title"><?php _e('4/4<br />Additional Settings', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-additional">

											<div class="alp-setitngs-form-inner">

												<label title="Link Cells"><input type="checkbox" value="link-cells"> Link Cells</label>

												<label title="Disable Sorting if Enabled on this Table"><input type="checkbox" value="disable-sort"> Disable Sorting</label>

											</div>

										</form>

									</div>

									<span class="alp-js-close-col-settings"></span>

									<span class="alp-col-settings-prev icon-amalinkspro-left-open" data-alp-next-setting="3"></span>
									<span class="alp-col-settings-next icon-amalinkspro-right-open" data-alp-next-setting="2"></span>

								</div>
							</th>
							<th class="draggable" 
								data-alp-table-hide-for-sm="0" 
								data-alp-table-hide-for-md="0" 
								data-alp-table-hide-for-lg="0" 
								data-alp-table-v-align="middle" 
								data-alp-table-h-align="center" 
								data-alp-table-col-link="0" 
								data-alp-table-col-disable-sort="0"
								>

								<span class="icon-amalinkspro-drag" title="Drag left or Right"></span>
								<span class="icon-amalinkspro-cog js-alp-column-settings" title="Column Settings"></span>
								<span class="icon-amalinkspro-trash js-alp-delete-column" title="Delete Column"></span>

								<div class="alp-table-editor-col-settings">

									<div class="alp-table-editor-col-settings-slide alp-responsive" data-col-settings-slide="1">

										<span class="alp-table-editor-col-settings-title"><?php _e('1/4<br />Hide this column on', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-responsive">

											<label title="Hide on Small Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-phone"></i>
												<input type="checkbox" value="hide-on-mobile">
											</label>

											<label title="Hide on Medium Screens">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-tablet"></i>
												<input type="checkbox" value="hide-on-tablet">
											</label>

											<label title="Hide on Large Screens Phones">
												<span class="icon-amalinkspro-eye-off"></span>
												<i class="icon-amalinkspro-desktop"></i>
												<input type="checkbox" value="hide-on-desktop">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="2">
										<span class="alp-table-editor-col-settings-title"><?php _e('2/4<br />Vertical Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-v-align">

											<label title="Align Top">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-v" value="top">
											</label>

											<label title="Align Middle">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-v" value="middle" checked=checked>
											</label>

											<label title="Align Bottom">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-v" value="bottom">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>

									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="3">
										<span class="alp-table-editor-col-settings-title"><?php _e('3/4<br />Horizontal Alignment', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-h-align">

											<label title="Align Left">
												<i class="icon-amalinkspro-align-left"></i>
												<input type="radio" name="col-align-h" value="left" checked=checked>
											</label>

											<label title="Align Center">
												<i class="icon-amalinkspro-align-center"></i>
												<input type="radio" name="col-align-h" value="center">
											</label>

											<label title="Align Right">
												<i class="icon-amalinkspro-align-right"></i>
												<input type="radio" name="col-align-h" value="right">
											</label>

											<div class="amalinkspro-clear"></div>

										</form>

									</div>


									<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="4">

										<span class="alp-table-editor-col-settings-title"><?php _e('4/4<br />Additional Settings', 'amalinkspro-tables'); ?>:</span>
										<form class="alp-table-editor-col-settings-additional">

											<div class="alp-setitngs-form-inner">

												<label title="Link Cells"><input type="checkbox" value="link-cells"> Link Cells</label>

												<label title="Disable Sorting if Enabled on this Table"><input type="checkbox" value="disable-sort"> Disable Sorting</label>

											</div>

										</form>

									</div>

									<span class="alp-js-close-col-settings"></span>

									<span class="alp-col-settings-prev icon-amalinkspro-left-open" data-alp-next-setting="3"></span>
									<span class="alp-col-settings-next icon-amalinkspro-right-open" data-alp-next-setting="2"></span>

								</div>
							</th>
						</tr>

						<tr class="no-table-rows no-table-rows-thead">

							<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) )  : ?>

								<th>&nbsp;</th>
								<th data-alp-table-col-width="0" style="position: relative; width: 200px" data-alp-table-th-type="image-sitestripe" data-type="html" data-breakpoints=""><span class="alp-table-th-editable">SiteStripe Image<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 400px" data-alp-table-th-type="title" data-type="html" data-breakpoints=""><span class="alp-table-th-editable">Title<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 100px" data-alp-table-th-type="custom" data-type="html" data-breakpoints="sm md"><span class="alp-table-th-editable">Custom<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 100px" data-alp-table-th-type="custom" data-type="html" data-breakpoints="sm"><span class="alp-table-th-editable">Custom<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 160px" data-alp-table-th-type="cta-btn" data-type="html" data-breakpoints=""><span class="alp-table-th-editable">Buy<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>

							<?php else: ?>

								<th>&nbsp;</th>
								<th data-alp-table-col-width="0" style="position: relative; width: 200px" data-alp-table-th-type="image" data-type="html" data-breakpoints=""><span class="alp-table-th-editable">Image<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 400px" data-alp-table-th-type="title" data-type="html" data-breakpoints=""><span class="alp-table-th-editable">Title<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 100px" data-alp-table-th-type="price-offer" data-type="html" data-breakpoints="sm md"><span class="alp-table-th-editable">Price<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 100px" data-alp-table-th-type="prime" data-type="html" data-breakpoints="sm"><span class="alp-table-th-editable">Prime<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>
								<th data-alp-table-col-width="0" style="position: relative; width: 160px" data-alp-table-th-type="cta-btn" data-type="html" data-breakpoints=""><span class="alp-table-th-editable">Buy<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>

							<?php endif; ?>

						</tr>

					</thead>

					<tbody>

						<tr class="no-table-rows no-table-rows-tbody" alp-data-asin="" data-row-url="">

							<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) )  : ?>

								<td>
									<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) )  : ?>
										<span class="icon-amalinkspro-link" title="Non-API Affiliate Link"></span>
										<span class="alp-tb-noapi-row-link">
											<input type="text" placeholder="Insert product URL for this row" value="" />
											<i class="icon-amalinkspro-ok"></i>
										</span>
									<?php endif; ?>
								  <span class="icon-amalinkspro-drag" title="Drag Up or Down"></span>
								  <label class="star-radio-label" title="Set as Top Choice">
								    <input type="radio" name="alp-table-top-product" value="0">
								    <i class="icon-amalinkspro-star"></i>
								  </label>
								  <span class="icon-amalinkspro-trash js-alp-delete-row" title="Delete Row"></span>
								</td>
								<td data-alp-table-td-type="image-sitestripe">
									<i class="icon-amalinkspro-edit js-edit-table-image-sitestripe"></i><span class="alp-sitestripe-tb-col-html"></span
								</td>
								<td data-alp-table-td-type="title">
									<span class="alp-table-td-editable">Click to Edit<i class="icon-amalinkspro-edit" title="Edit Text"></i></span>
								</td>
								<td data-alp-table-td-type="custom">
									<span class="alp-table-td-editable">Click to Edit<i class="icon-amalinkspro-edit" title="Edit Text"></i></span>
								</td>
								<td data-alp-table-td-type="custom">
									<span class="alp-table-td-editable">Click to Edit<i class="icon-amalinkspro-edit" title="Edit Text"></i></span>
								</td>
								<td data-alp-table-td-type="cta-btn">
									<span class="alp-table-td-ctabtn-editable"><a class="amalinkspro-cta-btn" href="#" target="_blank" rel="nofollow">Click Here</a><i class="icon-amalinkspro-edit"></i></span>
								</td>

							<?php else: ?>

								<td>
									&nbsp;
								</td>
								<td data-alp-table-td-type="image">
									-
								</td>
								<td data-alp-table-td-type="title">
									-
								</td>
								<td data-alp-table-td-type="price-offer">
									-
								</td>
								<td data-alp-table-td-type="prime">
									-
								</td>
								<td data-alp-table-td-type="cta-btn">
									-
								</td>

							<?php endif; ?>

						</tr>

					</tbody>

				</table>


			<?php

			$table_html = ob_get_contents();
			ob_end_clean();


		}


		else {

			global $wpdb;


			$table_data = array();

			// we have a saved table to load!

			if ( get_post_meta( $table_id, 'alp_table_columns_settings' ) ) {

				$table_data['settings_count'] = get_post_meta( $table_id, 'alp_table_columns_settings', true );
				$col_settings_count = get_post_meta( $table_id, 'alp_table_columns_settings', true );

				for ( $i = 0; $i < $col_settings_count; $i++ ) {
					$table_data['columns_settings'][$i]['hideForSm'] = get_post_meta( $table_id, 'alp_table_columns_settings_' . $i . '_hideForSm', true );
					$table_data['columns_settings'][$i]['hideForMd'] = get_post_meta( $table_id, 'alp_table_columns_settings_' . $i . '_hideForMd', true );
					$table_data['columns_settings'][$i]['hideForLg'] = get_post_meta( $table_id, 'alp_table_columns_settings_' . $i . '_hideForLg', true );
					$table_data['columns_settings'][$i]['verticalAlign'] = get_post_meta( $table_id, 'alp_table_columns_settings_' . $i . '_verticalAlign', true );
					$table_data['columns_settings'][$i]['horizontalAlign'] = get_post_meta( $table_id, 'alp_table_columns_settings_' . $i . '_horizontalAlign', true );
					$table_data['columns_settings'][$i]['linkCell'] = get_post_meta( $table_id, 'alp_table_columns_settings_' . $i . '_linkCell', true );
					$table_data['columns_settings'][$i]['disableSort'] = get_post_meta( $table_id, 'alp_table_columns_settings_' . $i . '_disableSort', true );
				}

			}
			else {
				$table_data['settings_count'] = '0';
				$table_data['columns_settings'] = '';
			}


			if ( get_post_meta( $table_id, 'alp_table_columns_data' ) ) {

				$table_data['columns_count'] = get_post_meta( $table_id, 'alp_table_columns_data', true );
				$columns_count = get_post_meta( $table_id, 'alp_table_columns_data', true );

				for ( $i = 0; $i <= $columns_count; $i++ ) {
					$table_data['columns'][$i]['name'] = get_post_meta( $table_id, 'alp_table_columns_data_' . $i . '_name', true );
					$table_data['columns'][$i]['type'] = get_post_meta( $table_id, 'alp_table_columns_data_' . $i . '_type', true );
					$table_data['columns'][$i]['width'] = get_post_meta( $table_id, 'alp_table_columns_data_' . $i . '_width', true );
					$table_data['columns'][$i]['hideForSm'] = $table_data['columns_settings'][$i]['hideForSm'];
					$table_data['columns'][$i]['hideForMd'] = $table_data['columns_settings'][$i]['hideForMd'];
					$table_data['columns'][$i]['hideForLg'] = $table_data['columns_settings'][$i]['hideForLg'];
				}

			}
			else {
				$table_data['columns_count'] = '0';
				$table_data['columns'] = '';
			}




			if ( get_post_meta( $table_id, 'alp_table_rows' ) ) {
				$table_data['rows_count'] = get_post_meta( $table_id, 'alp_table_rows', true );
			}
			else {
				$table_data['rows_count'] = '0';
			}


			if ( get_post_meta( $table_id, 'alp_featured_row' ) ) {

				$alp_featured_row_string = get_post_meta( $table_id, 'alp_featured_row', true );

				$alp_featured_row = str_replace('row-', '', $alp_featured_row_string);

				$table_data['alp_featured_row'] = $alp_featured_row;
			}
			else {
				$table_data['alp_featured_row'] = 'none';
			}



			if ( get_post_meta( $table_id, 'alp_table_columns_data' ) ) {

				$table_data['alp_table_rows'] = get_post_meta( $table_id, 'alp_table_rows', true );

				$rows_count = get_post_meta( $table_id, 'alp_table_rows', true );
				$tds_count = get_post_meta( $table_id, 'alp_table_columns_data', true );

				for ( $i = 0; $i < $rows_count; $i++ ) {

					$table_data['rows'][$i]['settings'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_settings', true );
					$table_data['rows'][$i]['asin'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_asin', true );
					$table_data['rows'][$i]['url'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_url', true );


					

					for ( $j = 0; $j <= $tds_count; $j++ ) {
						$table_data['rows'][$i]['cells'][$j]['type'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_type', true );
						$table_data['rows'][$i]['cells'][$j]['html'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_html', true );
					}

				}

			}
			else {
				$table_data['columns_count'] = '0';
				$table_data['columns'] = '';
			}


			//echo '$table_data: <pre>'.print_r($table_data,1).'</pre>';


			ob_start();
			?>

			

			<?php 
			// echo '$table_data: <pre>'.print_r($table_data,1).'</pre>'; ?>

			<?php if ( $table_data ) : ?>

				<?php // echo '$table_data: <pre>'.print_r($table_data,1).'</pre>'; ?>


				<?php 
				//echo $this->alp_get_table_global_styles_for_editor(); 
				$table_settings = $this->get_amalinkspro_tables_attributes();
				?>

				<table id="alp-table" data-alp-table-id="<?php echo $table_id; ?>" data-alp-table-cols="<?php echo $table_data['columns_count']; ?>" 
						data-alp-table-rows="<?php echo $table_data['rows_count']; ?>" class="amalinkspro-comparison-table amalinkspro-comparison-table-admin amalinkspro-comparison-table-admin-editor" <?php echo $table_settings; ?>>

					<?php if ( $table_data['columns_count'] ) : ?>

						<thead>

							<?php if ( $table_data['columns_settings'] ) : ?>

								<tr class="th-settings">


									<?php
									if ( $table_data['alp_featured_row'] == 'none' ) {
										$checked = ' checked=checked';
									}
									else {
										$checked = '';
									}
									?>

									<th>
										<!-- <label class="star-radio-label th" title="No Top Choice">
											<input type="radio" name="alp-table-top-product" value="none"<?php echo $checked; ?> />
											<i class="icon-amalinkspro-star-empty"></i>
										</label> -->
									</th>

									<?php foreach ( $table_data['columns_settings'] as $col ) : ?>

										<th class="draggable" 
											data-alp-table-hide-for-sm="<?php echo $col['hideForSm']; ?>" 
											data-alp-table-hide-for-md="<?php echo $col['hideForMd']; ?>" 
											data-alp-table-hide-for-lg="<?php echo $col['hideForLg']; ?>" 
											data-alp-table-v-align="<?php echo $col['verticalAlign']; ?>" 
											data-alp-table-h-align="<?php echo $col['horizontalAlign']; ?>" 
											data-alp-table-col-link="<?php echo $col['linkCell']; ?>" 
											data-alp-table-col-disable-sort="<?php echo $col['disableSort']; ?>" 
											data-breakpoints="" 
											>

											<span class="icon-amalinkspro-drag" title="Drag left or Right"></span>
											<span class="icon-amalinkspro-cog js-alp-column-settings" title="Column Settings"></span>
											<span class="icon-amalinkspro-trash js-alp-delete-column" title="Delete Column"></span>



											<div class="alp-table-editor-col-settings">

												<div class="alp-table-editor-col-settings-slide alp-responsive" data-col-settings-slide="1">

													<span class="alp-table-editor-col-settings-title"><?php _e('1/4<br />Hide this column on', 'amalinkspro-tables'); ?>:</span>
													<form class="alp-table-editor-col-settings-responsive">

														<label title="Hide on Small Screens"<?php if ( $col['hideForSm'] == '1' ) echo ' class="checked"' ?>>
															<span class="icon-amalinkspro-eye-off"></span>
															<i class="icon-amalinkspro-phone"></i>
															<input type="checkbox" value="hide-on-mobile"<?php if ( $col['hideForSm'] == '1' ) echo ' checked=checked' ?>>
														</label>

														<label title="Hide on Medium Screens"<?php if ( $col['hideForMd'] == '1' ) echo ' class="checked"' ?>>
															<span class="icon-amalinkspro-eye-off"></span>
															<i class="icon-amalinkspro-tablet"></i>
															<input type="checkbox" value="hide-on-tablet"<?php if ( $col['hideForMd'] == '1' ) echo ' checked=z' ?>>
														</label>

														<label title="Hide on Large Screens Phones"<?php if ( $col['hideForLg'] == '1' ) echo ' class="checked"' ?>>
															<span class="icon-amalinkspro-eye-off"></span>
															<i class="icon-amalinkspro-desktop"></i>
															<input type="checkbox" value="hide-on-desktop"<?php if ( $col['hideForLg'] == '1' ) echo ' checked=checked' ?>>
														</label>

														<div class="amalinkspro-clear"></div>

													</form>

												</div>

												<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="2">
													<span class="alp-table-editor-col-settings-title"><?php _e('2/4<br />Vertical Alignment', 'amalinkspro-tables'); ?>:</span>
													<form class="alp-table-editor-col-settings-v-align">

														<label title="Align Top">
															<i class="icon-amalinkspro-align-left"></i>
															<input type="radio" name="col-align-v" value="top"<?php if ( $col['verticalAlign'] == 'top' ) echo ' checked=checked' ?>>
														</label>

														<label title="Align Middle">
															<i class="icon-amalinkspro-align-center"></i>
															<input type="radio" name="col-align-v" value="middle"<?php if ( $col['verticalAlign'] == 'middle' ) echo ' checked=checked' ?>>
														</label>

														<label title="Align Bottom">
															<i class="icon-amalinkspro-align-right"></i>
															<input type="radio" name="col-align-v" value="bottom"<?php if ( $col['verticalAlign'] == 'bottom' ) echo ' checked=checked' ?>>
														</label>

														<div class="amalinkspro-clear"></div>

													</form>

												</div>

												<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="3">
													<span class="alp-table-editor-col-settings-title"><?php _e('3/4<br />Horizontal Alignment', 'amalinkspro-tables'); ?>:</span>
													<form class="alp-table-editor-col-settings-h-align">

														<label title="Align Left">
															<i class="icon-amalinkspro-align-left"></i>
															<input type="radio" name="col-align-h" value="left"<?php if ( $col['horizontalAlign'] == 'left' ) echo ' checked=checked' ?>>
														</label>

														<label title="Align Center">
															<i class="icon-amalinkspro-align-center"></i>
															<input type="radio" name="col-align-h" value="center"<?php if ( $col['horizontalAlign'] == 'center' ) echo ' checked=checked' ?>>
														</label>

														<label title="Align Right">
															<i class="icon-amalinkspro-align-right"></i>
															<input type="radio" name="col-align-h" value="right"<?php if ( $col['horizontalAlign'] == 'right' ) echo ' checked=checked' ?>>
														</label>

														<div class="amalinkspro-clear"></div>

													</form>

												</div>



												<div class="alp-table-editor-col-settings-slide" data-col-settings-slide="4">

													<span class="alp-table-editor-col-settings-title"><?php _e('4/4<br />Additional Settings', 'amalinkspro-tables'); ?>:</span>
													<form class="alp-table-editor-col-settings-additional">

														<div class="alp-setitngs-form-inner">

															<label title="Link Cells"><input type="checkbox" value="link-cells"<?php if ( $col['linkCell'] == '1' ) echo ' checked=checked' ?>> Link Cells</label>

															<label title="Disable Sorting if Enabled on this Table"><input type="checkbox" value="disable-sort"<?php if ( $col['disableSort'] == '1' ) echo ' checked=checked' ?>> Disable Sorting</label>

														</div>

													</form>

												</div>

												<span class="alp-js-close-col-settings"></span>

												<span class="alp-col-settings-prev icon-amalinkspro-left-open" data-alp-next-setting="4"></span>
												<span class="alp-col-settings-next icon-amalinkspro-right-open" data-alp-next-setting="2"></span>

											</div>



										</th>
									
									<?php endforeach; ?>

								</tr>

							<?php endif; ?>


							<?php if ( $table_data['columns'] ) : ?>

								<tr class="alp-table-headings">

									<?php $i=0; $j = 0; foreach ( $table_data['columns'] as $th_col ) : ?>

										<?php if ( $i == 0 ) : ?>

											<th>&nbsp;</th>

										<?php else: ?>

											<?php
											if (
												$th_col['type'] == 'custom' || 
												$th_col['type'] == 'title' || 
												$th_col['type'] == 'brand' || 
												$th_col['type'] == 'model' || 
												$th_col['type'] == 'manufacturer' || 
												$th_col['type'] == 'upc' || 
												$th_col['type'] == 'warranty' || 
												$th_col['type'] == 'author' || 
												$th_col['type'] == 'binding' || 
												$th_col['type'] == 'edition' || 
												$th_col['type'] == 'number-of-pages' || 
												$th_col['type'] == 'publication-date' || 
												$th_col['type'] == 'publisher' || 
												$th_col['type'] == 'release-date' || 
												$th_col['type'] == 'studio'

											) {
												$data_type = 'text';
											}
											else {
												$data_type = 'html';
											}


											if ($table_data['columns_settings'][$j]['disableSort']) {
												$disable_sort = ' data-sortable="false"';
											}
											else {
												$disable_sort = '';
											}

											$col_breakpoints = '';

											if ( $table_data['columns_settings'][$j]['hideForSm'] ) {
												$col_breakpoints .= 'xs sm';
											}
											if ( $table_data['columns_settings'][$j]['hideForMd'] ) {
												$col_breakpoints .= ' md';
											}
											if ( $table_data['columns_settings'][$j]['hideForLg'] ) {
												$col_breakpoints .= ' lg';
											}

											// data-alp-table-col-width="<?php echo $th_col['width'];" - used to be a data attribute of the th element below |  min-width: <?php echo $th_col['width']; px; &  width: <?php echo $th_col['width']; px; taken out of style attribute as well
											?>


											<th id="column-header-<?php echo $i; ?>" class="" 
												data-alp-table-th-type="<?php echo $th_col['type']; ?>" 
												data-type="<?php echo $data_type; ?>" 
												data-breakpoints="<?php echo $col_breakpoints; ?>"
												<?php echo $disable_sort; ?>
												style="vertical-align:<?php echo $table_data['columns_settings'][$j]['verticalAlign']; ?>;text-align:<?php echo $table_data['columns_settings'][$j]['horizontalAlign']; ?>;"
												><span class="alp-table-th-editable"><?php echo $th_col['name']; ?><i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span></th>

												<?php $j++; ?>

										<?php endif; ?>

									<?php $i++; endforeach; ?>

								</tr>

							<?php endif; ?>

						</thead>

					<?php endif; ?>





					<?php if ( $table_data['rows_count'] || $table_data['alp_table_rows'] ) : // need both to overcome bug I can't find ?>

						<tbody>


							<?php $i=1; foreach ( $table_data['rows'] as $row ) : ?>

							<?php
							if ($i % 2 == 0) {
								$evenodd = 'even';
							}
							else {
								$evenodd = 'odd';
							}
							
							$row_counter = $i - 1;

							$amalinkspro_featured_row_output =  '<span class="alp-top-pick"><span class="alp-top-pick-text">Top</span><span class="alp-top-pick-angle"></span></span>';

							if ( $table_data['alp_featured_row'] != 'none' && $table_data['alp_featured_row'] == $row_counter ) {
								$top_class = ' class="alp-featured-table-row"';
								// $amalinkspro_featured_row_output =  '<a class="alp-top-pick"><span class="alp-top-pick-text">Top</span><span class="alp-top-pick-angle"></span></a>';
							}
							else {
								$top_class = '';
								// $amalinkspro_featured_row_output = '';
							}
							?>


								<tr alp-data-asin="<?php echo $row['asin']; ?>" data-row-url="<?php echo $row['url']; ?>" data-table-row-evenodd="<?php echo $evenodd; ?>"<?php echo $top_class; ?>>


									<?php if ( $row['cells'] ) : ?>

										<?php $j=0; $k=0; foreach (  $row['cells'] as $td ) : ?>



											<?php if ( $j == 0 ) : ?>
												<td>
													<?php
													if ( $table_data['alp_featured_row'] != 'none' && $table_data['alp_featured_row'] == $row_counter ) {
														$checked = ' checked=checked';
													}
													else {
														$checked = '';
													}
													?>

													<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) )  : ?>
														<span class="icon-amalinkspro-link" title="Non-API Affiliate Link"></span>
														<span class="alp-tb-noapi-row-link">
															<input type="text" placeholder="Insert product URL for this row" value="<?php echo $row['url']; ?>" />
															<i class="icon-amalinkspro-ok"></i>
														</span>
													<?php endif; ?>

													<span class="icon-amalinkspro-drag" title="Drag Up or Down"></span>
													<label class="star-radio-label" title="Set as Top Choice">
														<input type="radio" name="alp-table-top-product" value="<?php echo $i; ?>"<?php echo $checked; ?> />
														<i class="icon-amalinkspro-star"></i>
													</label>
													<span class="icon-amalinkspro-trash js-alp-delete-row" title="Delete Row"></span>
												</td>
											<?php else: ?>


												<?php
												if (
													$td['type'] == 'custom' || 
													$td['type'] == 'title' || 
													$td['type'] == 'brand' || 
													$td['type'] == 'model' || 
													$td['type'] == 'manufacturer' || 
													$td['type'] == 'upc' || 
													$td['type'] == 'warranty' || 
													$td['type'] == 'author' || 
													$td['type'] == 'binding' || 
													$td['type'] == 'edition' || 
													$td['type'] == 'number-of-pages' || 
													$td['type'] == 'publication-date' || 
													$td['type'] == 'publisher' || 
													$td['type'] == 'release-date' || 
													$td['type'] == 'studio'

												) {
													$data_type = 'text';
												}
												else {
													$data_type = 'html';
												}

												if (
													$td['type'] == 'price-list' || 
													$td['type'] == 'price-offer' || 
													$td['type'] == 'price-lowest-new-price' || 
													$td['type'] == 'price-lowest-used-price'
												) {

													$price = $td['html'];
													$cleaned_number = preg_replace( '/[^0-9]/', '', $price );
													$data_sort_val = ' data-sort-value"' . $cleaned_number . '"';
												}
												else {
													$data_sort_val = '';
												}
												?>

												<?php // echo '$table_data: <pre>'.print_r($table_data,1).'</pre>'; ?>

												<td data-alp-table-td-type="<?php echo $td['type']; ?>" 
													data-type="<?php echo $data_type; ?>"<?php echo $data_sort_val; ?>
													style="vertical-align:<?php echo $table_data['columns_settings'][$k]['verticalAlign']; ?>;text-align:<?php echo $table_data['columns_settings'][$k]['horizontalAlign']; ?>;"
													><?php
													if (
														$td['type'] == 'custom' || 
														$td['type'] == 'title' || 
														$td['type'] == 'brand' || 
														$td['type'] == 'model' || 
														$td['type'] == 'manufacturer' || 
														$td['type'] == 'upc' || 
														$td['type'] == 'warranty' || 
														$td['type'] == 'author' || 
														$td['type'] == 'binding' || 
														$td['type'] == 'edition' || 
														$td['type'] == 'number-of-pages' || 
														$td['type'] == 'publication-date' || 
														$td['type'] == 'publisher' || 
														$td['type'] == 'release-date' || 
														$td['type'] == 'studio'

													) {
														echo '<span class="alp-table-td-editable">' . $td['html'] . '<i class="icon-amalinkspro-edit" title="Edit Column Heading"></i></span>';

													}
													else if ( $td['type'] == 'image' ) {
														echo $td['html'];
														echo '<i class="icon-amalinkspro-edit js-edit-table-image" data-api-img="medium"></i>';
													}
													else if ( $td['type'] == 'cta-btn' ) {
														
														echo '<span class="alp-table-td-ctabtn-editable">';
														echo $td['html'];
														echo '<i class="icon-amalinkspro-edit" data-api-img="medium"></i>';
														echo '</span>';
													}

													else if ( $td['type'] == 'prime' ) {
														echo $td['html'];
													}

													else if ($td['type'] == 'image-sitestripe' ) {
														echo '<i class="icon-amalinkspro-edit js-edit-table-image-sitestripe"></i>';
														echo $td['html'];
													}
													
													else { echo $td['html']; }	
													?>


													<?php if ( $j == 1 ) {
														echo $amalinkspro_featured_row_output;
													} ?>

														


													</td>

													<?php $k++; ?>

											<?php endif; ?>

										<?php $j++; endforeach; ?>

	
									<?php endif; ?>

								</tr>

							<?php $i++; endforeach; ?>


						</tbody>

					<?php endif; ?>

				</table>

			<?php endif; ?>


			<?php

			$table_html = ob_get_contents();
			ob_end_clean();

		}

		echo $table_html;

		wp_die();


	}




	// this gets the amazon api data from the asins in our table rows
	function alp_paapi5_get_asin_groups_data() {

		global $wpdb; // this is how you get access to the database

		if ( empty( $_POST['asins'] ) ) {
			return 'Error code 1029: No ASINs group';
		}

	    $asins = $_POST['asins'];
	    $aff_id = $_POST['aff_id'];
	    $response = alp_paapi5_get_groups_10_asins_data($asins, $aff_id);

	    // echo '$response: <pre>'.print_r($response,1).'</pre>';
	    echo json_encode($response);

		die();

	}





	public function amalinkspro_load_table_link_settings() {

		global $wpdb; // this is how you get access to the database


		$table_settings = array();

		$table_id = $_POST['table_id'];


		if ( get_post_meta($table_id, 'alp_table_affiliate_link_id', true) ) {
			$table_settings['affiliate_id'] = get_post_meta( $table_id, 'alp_table_affiliate_link_id', true );
		}
		else if ( get_option( 'amalinkspro-options_default_amazon_search_locale' ) ) {
			$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
			$table_settings['affiliate_id'] = get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_0_associate_id' );
		}
		else {
			$table_settings['affiliate_id'] = '';
		}


		if ( get_post_meta($table_id, 'alp_table_open_links_in_a_new_window', true) == 'on' ) {
			$table_settings['new_tab'] = get_post_meta( $table_id, 'alp_table_open_links_in_a_new_window', true );
		}
		else if ( get_option('amalinkspro-options_open_links_in_a_new_window') == 1 ) {
			$table_settings['new_tab'] = 'on';
		}
		else {
			$table_settings['new_tab'] = 'off';
		}
		

		if ( get_post_meta($table_id, 'alp_table_nofollow_links', true) == 'on' ) {
			$table_settings['nofollow'] = get_post_meta( $table_id, 'alp_table_nofollow_links', true );
			// echo 'pulling post meta: ' . get_post_meta( $table_id, 'alp_table_nofollow_links', true );
		}
		else if ( get_option('amalinkspro-options_nofollow_links' ) ) {
			$table_settings['nofollow'] = 'on';
			// echo 'pulling option: ' . get_option('amalinkspro-options_nofollow_links' );
		}
		else {
			$table_settings['nofollow'] = 'off';
			// echo 'no setting pulled at all... ' . $table_settings['nofollow'];
		}

		// die();


		if ( get_post_meta($table_id, 'alp_table_add_to_cart', true) == 'on' ) {
			$table_settings['add_to_cart'] = get_post_meta( $table_id, 'alp_table_add_to_cart', true );
		}
		else if ( get_option('amalinkspro-options_add_to_cart' ) == 1 ) {
			$table_settings['add_to_cart'] = 'on';
		}
		else {
			$table_settings['add_to_cart'] = 'off';
		}

		// echo ' $table_settings: <pre>'.print_r( $table_settings,1).'</pre>';

		// die();



		$table_settings_encoded = json_encode( $table_settings );

		echo $table_settings_encoded;

		die();



	}




	function welcome_screen_tb_do_activation_redirect() {
	  // Bail if no activation redirect
	  if ( ! get_transient( '_amalinkspro_tb_welcome_screen_activation_redirect' ) ) {
	    return;
	  }

	  // Delete the redirect transient
	  delete_transient( '_amalinkspro_tb_welcome_screen_activation_redirect' );

	  // Bail if activating from network, or bulk
	  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
	    return;
	  }

	  // Redirect to bbPress about page
	  wp_safe_redirect( add_query_arg( array( 'page' => 'amalinkspro-welcome' ), admin_url( 'admin.php' ) ) );

	}













	/** Set our table attributes
	 *
	 * @since    1.0.0
	 */
	public function get_amalinkspro_tables_attributes() {


		$table_attributes = '';


		//enable state saving
		$enable_table_memory = get_option( 'amalinkspro-settings-tables_enable_table_memory' );
		if ( $enable_table_memory ) { $table_attributes .= ' data-state="true"'; }

		// look into "key" for persistent state on different pages


		// enable hide the header row
		$hide_header = get_option( 'amalinkspro-settings-tables_hide_the_table_header' );
		if ( $hide_header ) { $table_attributes .= ' data-show-header="false"'; }

		//enable table sorting
		$enable_table_sorting = get_option( 'amalinkspro-settings-tables_enable_table_sorting' );
		if ( $enable_table_sorting ) { $table_attributes .= ' data-sorting="true"'; }

		//echo '::: '.$enable_table_sorting;

		//enable filtering
		$enable_table_filtering = get_option( 'amalinkspro-settings-tables_enable_table_filtering' );
		if ( $enable_table_filtering ) {

			$table_attributes .= ' data-filtering="true"';

			// add a no results message when filtering returns 0 results
			$no_results_message = get_option( 'amalinkspro-settings-tables_no_results_message' );
			if ( $no_results_message ) { $table_attributes .= ' data-empty="'.$no_results_message.'"'; }


			// ad custom filter input placeholder text
			$filter_placeholder_text = get_option( 'amalinkspro-settings-tables_filter_placeholder_text' );
			if ( $filter_placeholder_text ) { $table_attributes .= ' data-filter-placeholder="'.$filter_placeholder_text.'"'; }


			// add a title to the filter columns dropdown
			$filter_dropdown_heading = get_option( 'amalinkspro-settings-tables_filter_dropdown_heading' );
			if ( $filter_dropdown_heading ) { $table_attributes .= ' data-filter-dropdown-title="'.$filter_dropdown_heading.'"'; }

		}


		//enable pagination
		$enable_table_pagination = get_option( 'amalinkspro-settings-tables_enable_table_pagination' );
		if ( $enable_table_pagination ) {

			$table_attributes .= ' data-paging="true"';

			$number_of_rows_per_page = get_option( 'amalinkspro-settings-tables_number_of_rows_per_page' );
			if ( $number_of_rows_per_page ) {
				$table_attributes .= ' data-paging-size="'.$number_of_rows_per_page.'"';
			}

			//enable pagination limit to pages shown in pagination
			$pages_displayed_limit = get_option( 'amalinkspro-settings-tables_pages_displayed_limit' );
			if ( $pages_displayed_limit ) { $table_attributes .= ' data-paging-limit="'.$pages_displayed_limit.'"'; }

			// set the pagination positioning
			$pagination_position = get_option( 'amalinkspro-settings-tables_pagination_position' );
			if ( $pagination_position ) { $table_attributes .= ' data-paging-position="'.$pagination_position.'"'; }

		}


		//enable breakpoints to run off parent container width
		$breakpoints_off_container = get_option( 'amalinkspro-settings-tables_breakpoints_off_container' );
		if ( $breakpoints_off_container ) { $table_attributes .= ' data-use-parent-width="true"'; }


		// use custom breakpoints
		$custom_breakpoints = get_option( 'amalinkspro-settings-tables_custom_breakpoints' );

		if ( $custom_breakpoints ) {

			// set defaults as a fallback
			$default_breakpoints = array(
				'xs' => '480',
				'sm' => '768',
				'md' => '992',
				'lg' => '1200',
				'xl' => (int) '1400'
			);

			// set our user chosen values if they exist and don't equal 0
			$xs = get_option( 'amalinkspro-settings-tables_extra_small_breakpoint' );
			$sm = get_option( 'amalinkspro-settings-tables_small_breakpoint' );
			$md = get_option( 'amalinkspro-settings-tables_medium_breakpoint' );
			$lg = get_option( 'amalinkspro-settings-tables_large_breakpoint' );

			if ( $xs && $xs != '0' ) { $default_breakpoints['xs'] = (int) $xs; }
			if ( $sm && $sm != '0' ) { $default_breakpoints['sm'] = (int) $sm; }
			if ( $md && $md != '0' ) { $default_breakpoints['md'] = (int) $md; }
			if ( $lg && $lg != '0' ) { $default_breakpoints['lg'] = (int) $lg; }

			$encoded = json_encode( $default_breakpoints );
			$table_attributes .= " data-breakpoints='".htmlspecialchars($encoded)."'";

		}


		// display the first row open by default
		$expand_the_first_row_by_default = get_option( 'amalinkspro-settings-tables_expand_the_first_row_by_default' );
		if ( $expand_the_first_row_by_default ) { $table_attributes .= ' data-expand-first="true"'; }


		// display the first row open by default
		$expand_all_rows_by_default = get_option( 'amalinkspro-settings-tables_expand_all_rows_by_default' );
		if ( $expand_all_rows_by_default ) { $table_attributes .= ' data-expand-all="true"'; }

		// hide the row toggle button
		$hide_the_toggle_button = get_option( 'amalinkspro-settings-tables_hide_the_toggle_button' );
		if ( $hide_the_toggle_button ) { $table_attributes .= ' data-show-toggle="false"'; }


		// hide the row toggle button
		$filter_position = get_option( 'amalinkspro-settings-tables_filter_position' );
		if ( $filter_position ) { $table_attributes .= ' data-filter-position="'.$filter_position.'"'; }



		return $table_attributes;


	}





	


	public function alp_get_table_global_styles_for_editor() {


		ob_start();


		if ( get_option('amalinkspro-settings-tables_enable_custom_cta_color') == 1 ) :

			echo '<style type="text/css" class="amalinkspro-table-css">';


				if ( get_option('amalinkspro-settings-tables_choose_button_color') || get_option('amalinkspro-settings-tables_choose_button_text_color') || get_option('amalinkspro-settings-tables_choose_button_border_color') ) :
				
					echo 'body .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=cta-btn] .amalinkspro-cta-btn{';

						if ( get_option('amalinkspro-settings-tables_choose_button_color') ) :
							echo 'background:'.get_option('amalinkspro-settings-tables_choose_button_color').';';
						endif;

						if ( get_option('amalinkspro-settings-tables_choose_button_text_color') ) :
							echo 'color:'.get_option('amalinkspro-settings-tables_choose_button_text_color').'!important;';
						endif;

						if ( get_option('amalinkspro-settings-tables_choose_button_border_color') ) :
							echo 'border-color:'.get_option('amalinkspro-settings-tables_choose_button_border_color').'!important;';
						endif;

					echo '}';

				endif;

				if ( get_option('amalinkspro-settings-tables_choose_button_color_hover') || get_option('amalinkspro-settings-tables_choose_button_text_color_hover') || get_option('amalinkspro-settings-tables_choose_button_border_color_hover') ) :
				
					echo 'body .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=cta-btn] .amalinkspro-cta-btn:hover{';

						if ( get_option('amalinkspro-settings-tables_choose_button_color_hover') ) :
							echo 'background:'.get_option('amalinkspro-settings-tables_choose_button_color_hover').';';
						endif;

						if ( get_option('amalinkspro-settings-tables_choose_button_text_color_hover') ) :
							echo 'color:'.get_option('amalinkspro-settings-tables_choose_button_text_color_hover').'!important;';
						endif;

						if ( get_option('amalinkspro-settings-tables_choose_button_border_color_hover') ) :
							echo 'border-color:'.get_option('amalinkspro-settings-tables_choose_button_border_color_hover').'!important;';
						endif;

					echo '}';

				endif;

				if ( get_option('amalinkspro-settings-tables_table_btn_font_size') || get_option('amalinkspro-settings-tables_table_button_font_style') || get_option('amalinkspro-settings-tables_table_btn_padding_top') || get_option('amalinkspro-settings-tables_table_btn_padding_right') || get_option('amalinkspro-settings-tables_table_btn_padding_bottom') || get_option('amalinkspro-settings-tables_table_btn_padding_left') ) :
				
					echo 'body .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=cta-btn] .amalinkspro-cta-btn{';

						if ( get_option('amalinkspro-settings-tables_table_btn_font_size') ) :
							echo 'font-size:'.get_option('amalinkspro-settings-tables_table_btn_font_size').'px;';
						endif;

						if ( get_option('amalinkspro-settings-tables_table_button_font_style') ) :

							if ( get_option('amalinkspro-settings-tables_table_button_font_style') == 'bold' ) :
								echo 'font-weight:'. get_option('amalinkspro-settings-tables_table_button_font_style').';';
							elseif ( get_option('amalinkspro-settings-tables_table_button_font_style') == 'italic' ) :
								echo 'font-style:'. get_option('amalinkspro-settings-tables_table_button_font_style').';';
							elseif ( get_option('amalinkspro-settings-tables_table_button_font_style') == 'normal' ) :
								echo 'font-style:'. get_option('amalinkspro-settings-tables_table_button_font_style').';';
							endif;
							
						endif;


						if ( get_option('amalinkspro-settings-tables_table_btn_padding_top') || 
							get_option('amalinkspro-settings-tables_table_btn_padding_right') || 
							get_option('amalinkspro-settings-tables_table_btn_padding_bottom') || 
							get_option('amalinkspro-settings-tables_table_btn_padding_left') ) :

						endif;

						if ( get_option('amalinkspro-settings-tables_table_btn_padding_top') ) :
							echo 'padding-top:'.get_option('amalinkspro-settings-tables_table_btn_padding_top').'px;';
						endif;
						if ( get_option('amalinkspro-settings-tables_table_btn_padding_right') ) :
							echo 'padding-right:'.get_option('amalinkspro-settings-tables_table_btn_padding_right').'px;';
						endif;
						if ( get_option('amalinkspro-settings-tables_table_btn_padding_bottom') ) :
							echo 'padding-bottom:'.get_option('amalinkspro-settings-tables_table_btn_padding_bottom').'px;';
						endif;
						if ( get_option('amalinkspro-settings-tables_table_btn_padding_left') ) :
							echo 'padding-left:'.get_option('amalinkspro-settings-tables_table_btn_padding_left').'px;';
						endif;

					echo '}';

				endif;



			echo '</style>';

		endif;


		if ( get_option('amalinkspro-settings-tables_enable_custom_table_styles', true) ) {
		

			echo '<style type="text/css" class="amalinkspro-table-css">';



			// table header styles
			if ( get_option('amalinkspro-settings-tables_enable_table_header_styles') ) :

				echo '.amalinkspro-tablebuilder-table table.amalinkspro-comparison-table-admin-editor thead tr:nth-child(2) th,
				.amalinkspro-tablebuilder-table .dragtable-sortable li tr.alp-table-headings th, table.amalinkspro-comparison-table-admin-preview thead tr:nth-child(2) th {';

					if ( get_option('amalinkspro-settings-tables_table_header_bg_color') ) :
						echo 'background:'.get_option('amalinkspro-settings-tables_table_header_bg_color').' !important;';
						else:
						echo 'background:#fff;';
						endif;

					if ( get_option('amalinkspro-settings-tables_table_header_color') ) :
						echo 'color:'.get_option('amalinkspro-settings-tables_table_header_color').';';
						else:
						echo 'color:#000;';
						endif;

					if ( get_option('amalinkspro-settings-tables_table_header_font_size') ) :
						echo 'font-size:'.get_option('amalinkspro-settings-tables_table_header_font_size').'px;';
						else:
						echo 'font-size:14px;';
						endif;

					if ( get_option('amalinkspro-settings-tables_table_header_line_height') ) :
						echo 'line-height:'.get_option('amalinkspro-settings-tables_table_header_line_height').'px;';
						else:
						echo 'line-height:16px;';
						endif;

					if ( get_option('amalinkspro-settings-tables_th_padding_top') ) :
						echo 'padding-top:'.get_option('amalinkspro-settings-tables_th_padding_top').'px !important;';
						else:
						echo 'padding-top:10px !important;';
						endif;

					if ( get_option('amalinkspro-settings-tables_th_padding_right') ) :
						echo 'padding-right:'.get_option('amalinkspro-settings-tables_th_padding_right').'px!important;';
						else:
						echo 'padding-right:15px !important;';
						endif;

					if ( get_option('amalinkspro-settings-tables_th_padding_bottom') ) :
						echo 'padding-bottom:'.get_option('amalinkspro-settings-tables_th_padding_bottom').'px !important;';
						else:
						echo 'padding-bottom:10px !important;';
						endif;

					if ( get_option('amalinkspro-settings-tables_th_padding_left') ) :
						echo 'padding-left:'.get_option('amalinkspro-settings-tables_th_padding_left').'px !important;';
						else:
						echo 'padding-left:10px !important;';
						endif;

				echo '}';


				echo 'body .amalinkspro-comparison-table thead tr.footable-filtering th {';
					if ( get_option('amalinkspro-settings-tables_table_header_bg_color') ) :
						echo 'background:'.get_option('amalinkspro-settings-tables_table_header_bg_color').' !important;';
						else:
						echo 'background:#fff;';
						endif;

				echo '}';


				echo '.alp-table-wrapper .amalinkspro-comparison-table .footable .btn-primary{';
					echo 'background-color:'.get_option('amalinkspro-settings-tables_table_header_color').';';
					echo 'border-color:'.get_option('amalinkspro-settings-tables_table_header_color').';';
				echo '}';


				// table header border styles
				if ( get_option('amalinkspro-settings-tables_enable_table_header_border') ) :

					echo '.alp-table-wrapper .amalinkspro-comparison-table-admin-preview thead,body .amalinkspro-comparison-table[data-filtering="true"] > thead > tr.footable-filtering > th{';

						echo 'border-radius: 0;';

						if ( get_option('amalinkspro-settings-tables_table_header_border_width') ) :
							echo 'border-width:'.get_option('amalinkspro-settings-tables_table_header_border_width').'px;';
							else:
							echo 'border-width:1px;';
							endif;

						if ( get_option('amalinkspro-settings-tables_table_header_border_style') ) :
							echo 'border-style:'.get_option('amalinkspro-settings-tables_table_header_border_style').';';
							else:
							echo 'border-style:solid;';
							endif;

						if ( get_option('amalinkspro-settings-tables_table_header_border_color') ) :
							echo 'border-color:'.get_option('amalinkspro-settings-tables_table_header_border_color').';';
							else:
							echo 'border-color:#dedede;';
							endif;

						$sides = get_option('amalinkspro-settings-tables_table_header_border_sides');

						if ( is_array( $sides ) ) :

							if( !in_array( 'top', $sides ) ) :
								echo 'border-top: none;';
								endif;
							if( !in_array( 'right', $sides ) ) :
								echo 'border-right: none;';
								endif;
							if( !in_array( 'bottom', $sides ) ) :
								echo 'border-bottom: none;';
								endif;
							if( !in_array( 'left', $sides ) ) :
								echo 'border-left: none;';
								endif;

						else:

							if( 'top' != $sides ) :
								echo 'border-top: none;';
								endif;
							if( 'right' != $sides ) :
								echo 'border-right: none;';
								endif;
							if( 'bottom' != $sides ) :
								echo 'border-bottom: none;';
								endif;
							if( 'left' != $sides ) :
								echo 'border-left: none;';
								endif;

						endif;

					echo '}';

				endif;

			endif;



			/**********************/
			// table footer styles
			/**********************/


			if ( get_option('amalinkspro-settings-tables_enable_table_footer_styles') ) :

					if ( get_option('amalinkspro-settings-tables_table_footer_bg_color') ) :
						echo 'body .amalinkspro-comparison-table tfoot, .footable .label-default, body .amalinkspro-comparison-table tfoot > .footable-paging > td {';
							echo 'background-color:'.get_option('amalinkspro-settings-tables_table_footer_bg_color').';';
							echo 'border-color:'.get_option('amalinkspro-settings-tables_table_footer_bg_color').';';
						echo '}';
					endif;

					if ( get_option('amalinkspro-settings-tables_table_footer_text_color') ) :
						echo 'body .amalinkspro-comparison-table tfoot, #content body .amalinkspro-comparison-table tfoot span, body .amalinkspro-comparison-table .footable .pagination > li > a {';
							echo 'color:'.get_option('amalinkspro-settings-tables_table_footer_text_color').';';
						echo '}';
					endif;

					if ( get_option('amalinkspro-settings-tables_table_footer_text_color') ) :
						echo '.footable .pagination > .active > a, .footable .pagination > .active > a:hover {';
							echo 'background-color:'.get_option('amalinkspro-settings-tables_table_footer_text_color').';';
							echo 'border-color:'.get_option('amalinkspro-settings-tables_table_footer_text_color').';';
						echo '}';
					endif;

			endif;

											
			 /*\								/***\
		    /***\ Table Top Product Row Styles |*
		   /*   *\							    \***/

			if ( get_option('amalinkspro-settings-tables_enable_top_product_row_styles') ) :


				// table odd row styles
				if ( get_option('amalinkspro-settings-tables_top_product_row_background_color') ) :
					echo 'body table.amalinkspro-comparison-table tbody tr.alp-featured-table-row span.alp-top-pick .alp-top-pick-angle {';

						if ( get_option('amalinkspro-settings-tables_top_product_row_background_color') ) :
							echo 'border-color:'.get_option('amalinkspro-settings-tables_top_product_row_background_color').' transparent transparent transparent !important;';
							else:
							echo 'border-color: #5dc723 transparent transparent transparent !important;';
							endif;

					echo '}';
					
				endif;

				if ( get_option('amalinkspro-settings-tables_top_product_row_text_color') ) :
					echo 'body table.amalinkspro-comparison-table tbody tr.alp-featured-table-row span.alp-top-pick .alp-top-pick-text {';

						if ( get_option('amalinkspro-settings-tables_top_product_row_text_color') ) :
							echo 'color:'.get_option('amalinkspro-settings-tables_top_product_row_text_color').';';
							else:
							echo 'color: #fff;';
							endif;

					echo '}';
					
				endif;

				if ( get_option('amalinkspro-settings-tables_top_product_tag_left_offset') || get_option('amalinkspro-settings-tables_top_product_tag_top_offset') ) :
					echo 'body table.amalinkspro-comparison-table tbody tr.alp-featured-table-row span.alp-top-pick {';

						if ( get_option('amalinkspro-settings-tables_top_product_tag_left_offset') ) :
							echo 'left:'.get_option('amalinkspro-settings-tables_top_product_tag_left_offset').'px;';
							else:
							echo 'left: -4px;';
							endif;

						if ( get_option('amalinkspro-settings-tables_top_product_tag_top_offset') ) :
							echo 'top:'.get_option('amalinkspro-settings-tables_top_product_tag_top_offset').'px;';
							else:
							echo 'top: -4px;';
							endif;

					echo '}';
					
				endif;




			endif;


			/******************/
			// table row styles
			/******************/
			if ( get_option('amalinkspro-settings-tables_enable_table_row_styles') ) :

					// table odd row styles
					if ( get_option('amalinkspro-settings-tables_odd_row_background_color') ) :


						echo 'table.amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"], table.amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] + .footable-detail-row {';

							echo 'background-color:'.get_option('amalinkspro-settings-tables_odd_row_background_color');
						echo '}';
					endif;

					// table even row styles
					if ( get_option('amalinkspro-settings-tables_odd_row_background_color') ) :
						echo 'table.amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"], table.amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] + .footable-detail-row {';
							echo 'background-color:'.get_option('amalinkspro-settings-tables_even_row_background_color');
						echo '}';
					endif;

					/*************************/
					// table row bottom border
					/*************************/
					if ( get_option('amalinkspro-settings-tables_enable_table_row_bottom_border') ) :
						echo 'table.amalinkspro-comparison-table-admin tbody tr td:not(:first-child),
						table.amalinkspro-comparison-table-admin-preview tbody tr td {';
							if ( get_option('amalinkspro-settings-tables_table_row_bottom_border_width') ) :
								echo 'border-bottom-width:'.get_option('amalinkspro-settings-tables_table_row_bottom_border_width').'px;';
								else:
								echo 'border-bottom-width:1px;';
								endif;
							if ( get_option('amalinkspro-settings-tables_table_row_bottom_border_style') ) :
								echo 'border-bottom-style:'.get_option('amalinkspro-settings-tables_table_row_bottom_border_style').';';
								else:
								echo 'border-bottom-style:solid;';
								endif;
							if ( get_option('amalinkspro-settings-tables_table_row_bottom_border_color') ) :
								echo 'border-bottom-color:'.get_option('amalinkspro-settings-tables_table_row_bottom_border_color').';';
								else:
								echo 'border-bottom-color:#dedede;';
								endif;
						echo '}';
						
					endif;





					/***********************/
					// table row font styles
					/***********************/

					if ( get_option('amalinkspro-settings-tables_enable_table_row_font_styles') ) :

							echo 'body .amalinkspro-comparison-table tbody tr td,body .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=title], body .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=price-list], body .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=price-lowest-new-price], body .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=price-lowest-used-price],.alp-table-wrapper .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=price-offer] .alp-price-offer,
								.alp-table-wrapper .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type=price-offer] .alp-price-savings {';
								// table row font styles
								if ( get_option('amalinkspro-settings-tables_table_row_global_font_size') ) :
									echo 'font-size:'.get_option('amalinkspro-settings-tables_table_row_global_font_size').'px;';
									else:
									echo 'font-size:14px;';
									endif;

								if ( get_option('amalinkspro-settings-tables_table_row_global_line_height') ) :
									echo 'line-height:'.get_option('amalinkspro-settings-tables_table_row_global_line_height').'px;';
									else:
									echo 'line-height:16px;';
									endif;
							echo '}';






							// table odd row font styles
							if ( get_option('amalinkspro-settings-tables_table_row_font_color_odd_rows') ) :
								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] td,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] td.amalinkspro_features li,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] td.alp_price .alp-sale-price,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] td.alp_price .slashed-price span,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] td.alp_price .prod-amount-saved{';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_font_color_odd_rows').';';
								echo '}';

								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] + .footable-detail-row td{';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_font_color_odd_rows').';';
								echo '}';

								echo '#content .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] td .footable-toggle{';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_font_color_odd_rows').';';
								echo '}';

							endif;

							if ( get_option('amalinkspro-settings-tables_table_row_link_color_odd_rows') ) :
								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"]) td a:not(.spec-button), .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"]) + .footable-detail-row td a:not(.spec-button){';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_link_color_odd_rows').';';
								echo '}';
							endif;

							if ( get_option('amalinkspro-settings-tables_table_row_button_bg_color_odd_rows') || get_option('amalinkspro-settings-tables_table_row_button_text_color_odd_rows') ) :
								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] td a.spec-button, .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"]) + .footable-detail-row td a.spec-button{';
									if ( get_option('amalinkspro-settings-tables_table_row_button_bg_color_odd_rows') ) :
										echo 'background-color:'.get_option('amalinkspro-settings-tables_table_row_button_bg_color_odd_rows').';';
									endif;
									if ( get_option('amalinkspro-settings-tables_table_row_button_text_color_odd_rows') ) :
										echo 'color:'.get_option('amalinkspro-settings-tables_table_row_button_text_color_odd_rows').';';
									endif;
								echo '}';
							endif;







							// table even row font styles
							if ( get_option('amalinkspro-settings-tables_table_row_font_color_even_rows') ) :
								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.amalinkspro_features li,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.alp_price .alp-sale-price,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.alp_price .slashed-price span,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.alp_price .prod-amount-saved{';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_font_color_even_rows').';';
								echo '}';

								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] + .footable-detail-row td{';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_font_color_even_rows').';';
								echo '}';

								echo '#content .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td .footable-toggle{';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_font_color_even_rows').';';
								echo '}';


							endif;

							if ( get_option('amalinkspro-settings-tables_table_row_link_color_even_rows') ) :
								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td a:not(.spec-button), .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"]) + .footable-detail-row td a:not(.spec-button){';
									echo 'color:'.get_option('amalinkspro-settings-tables_table_row_link_color_even_rows').';';
								echo '}';
							endif;

							if ( get_option('amalinkspro-settings-tables_table_row_button_bg_color_even_rows') || get_option('amalinkspro-settings-tables_table_row_button_text_color_even_rows') ) :
								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td a.spec-button, .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"]) + .footable-detail-row td a.spec-button{';
									if ( get_option('amalinkspro-settings-tables_table_row_button_bg_color_even_rows') ) :
										echo 'background-color:'.get_option('amalinkspro-settings-tables_table_row_button_bg_color_even_rows').';';
									endif;
									if ( get_option('amalinkspro-settings-tables_table_row_button_text_color_even_rows') ) :
										echo 'color:'.get_option('amalinkspro-settings-tables_table_row_button_text_color_even_rows').';';
									endif;
								echo '}';
							endif;







							/*************************************/
							// table row font special field styles
							/*************************************/
							if ( get_option('amalinkspro-settings-tables_enable_font_styles_for_field_types') ) :




									// ASIN special field styles
									// if ( get_option('amalinkspro-settings-tables_enable_asin_field_styles') ) :

									// 	echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td.amalinkspro_asin {';
									// 		if ( get_option('amalinkspro-settings-tables_asin_text_color') ) :
									// 			echo 'color:'.get_option('amalinkspro-settings-tables_asin_text_color').';';
									// 			else:
									// 			echo 'color:#000;';
									// 			endif;

									// 		if ( get_option('amalinkspro-settings-tables_asin_font_size') ) :
									// 			echo 'font-size:'.get_option('amalinkspro-settings-tables_asin_font_size').'px;';
									// 			else:
									// 			echo 'font-size:14px;';
									// 			endif;

									// 		if ( get_option('amalinkspro-settings-tables_asin_line_height') ) :
									// 			echo 'line-height:'.get_option('amalinkspro-settings-tables_asin_line_height').'px;';
									// 			else:
									// 			echo 'line-height:16px;';
									// 			endif;
									// 	echo '}';

									// endif;




									// Brand special field styles
									if ( get_option('amalinkspro-settings-tables_enable_brand_field_styles') ) :

										echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type="brand"] {';
											if ( get_option('amalinkspro-settings-tables_brand_text_color') ) :
												echo 'color:'.get_option('amalinkspro-settings-tables_brand_text_color').';';
												else:
												echo 'color:#000;';
												endif;

											if ( get_option('amalinkspro-settings-tables_brand_font_size') ) :
												echo 'font-size:'.get_option('amalinkspro-settings-tables_brand_font_size').'px;';
												else:
												echo 'font-size:14px;';
												endif;

											if ( get_option('amalinkspro-settings-tables_brand_line_height') ) :
												echo 'line-height:'.get_option('amalinkspro-settings-tables_brand_line_height').'px;';
												else:
												echo 'line-height:16px;';
												endif;
										echo '}';

									endif;




									// Model special field styles
									if ( get_option('amalinkspro-settings-tables_enable_model_field_styles') ) :

										echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type="model"] {';
											if ( get_option('amalinkspro-settings-tables_model_text_color') ) :
												echo 'color:'.get_option('amalinkspro-settings-tables_model_text_color').';';
												else:
												echo 'color:#000;';
												endif;

											if ( get_option('amalinkspro-settings-tables_model_font_size') ) :
												echo 'font-size:'.get_option('amalinkspro-settings-tables_model_font_size').'px;';
												else:
												echo 'font-size:14px;';
												endif;

											if ( get_option('amalinkspro-settings-tables_model_line_height') ) :
												echo 'line-height:'.get_option('amalinkspro-settings-tables_model_line_height').'px;';
												else:
												echo 'line-height:16px;';
												endif;
										echo '}';

									endif;




									// UPC special field styles
									if ( get_option('amalinkspro-settings-tables_enable_upc_field_styles') ) :

										echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type="upc"] {';
											if ( get_option('amalinkspro-settings-tables_upc_text_color') ) :
												echo 'color:'.get_option('amalinkspro-settings-tables_upc_text_color').';';
												else:
												echo 'color:#000;';
												endif;

											if ( get_option('amalinkspro-settings-tables_upc_font_size') ) :
												echo 'font-size:'.get_option('amalinkspro-settings-tables_upc_font_size').'px;';
												else:
												echo 'font-size:14px;';
												endif;

											if ( get_option('amalinkspro-settings-tables_upc_line_height') ) :
												echo 'line-height:'.get_option('amalinkspro-settings-tables_upc_line_height').'px;';
												else:
												echo 'line-height:16px;';
												endif;
										echo '}';

									endif;




									// Features special field styles
									// if ( get_option('amalinkspro-settings-tables_enable_features_field_styles') ) :

									// 	echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td.amalinkspro_features li,.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(odd) td.amalinkspro_features li,.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(even) td.amalinkspro_features li{';
									// 		if ( get_option('amalinkspro-settings-tables_features_text_color') ) :
									// 			echo 'color:'.get_option('amalinkspro-settings-tables_features_text_color').';';
									// 			else:
									// 			echo 'color:#000;';
									// 			endif;

									// 		if ( get_option('amalinkspro-settings-tables_features_font_size') ) :
									// 			echo 'font-size:'.get_option('amalinkspro-settings-tables_features_font_size').'px;';
									// 			else:
									// 			echo 'font-size:14px;';
									// 			endif;

									// 		if ( get_option('amalinkspro-settings-tables_features_line_height') ) :
									// 			echo 'line-height:'.get_option('amalinkspro-settings-tables_features_line_height').'px;';
									// 			else:
									// 			echo 'line-height:16px;';
									// 			endif;
									// 	echo '}';

									// endif;




									// Warranty special field styles
									if ( get_option('amalinkspro-settings-tables_enable_warranty_field_styles') ) :

										echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type="warranty"] {';
											if ( get_option('amalinkspro-settings-tables_warranty_text_color') ) :
												echo 'color:'.get_option('amalinkspro-settings-tables_warranty_text_color').';';
												else:
												echo 'color:#000;';
												endif;

											if ( get_option('amalinkspro-settings-tables_warranty_font_size') ) :
												echo 'font-size:'.get_option('amalinkspro-settings-tables_warranty_font_size').'px;';
												else:
												echo 'font-size:14px;';
												endif;

											if ( get_option('amalinkspro-settings-tables_warranty_line_height') ) :
												echo 'line-height:'.get_option('amalinkspro-settings-tables_warranty_line_height').'px;';
												else:
												echo 'line-height:16px;';
												endif;
										echo '}';

									endif;




									// Star Rating special field styles
									// if ( get_option('amalinkspro-settings-tables_enable_star_rating_field_styles') ) :

									// 	echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td.amalinkspro_asin {';

									// 	echo '}';

									// endif;




									// Yes/No special field styles
									// if ( get_option('amalinkspro-settings-tables_enable_yesno_rating_field_styles') ) :

									// 	echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td.amalinkspro_yesno {';

									// 	echo '}';

									// endif;




									// Price special field styles
									if ( get_option('amalinkspro-settings-tables_enable_price_field_styles') ) :

										if ( get_option('amalinkspro-settings-tables_sale_price_font_size') || get_option('amalinkspro-settings-tables_sale_price_color') ) :

											echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(odd) td.alp_price .alp-sale-price,.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(even) td.alp_price .alp-sale-price{';

												if ( get_option('amalinkspro-settings-tables_sale_price_font_size') ) :
													echo 'font-size:'.get_option('amalinkspro-settings-tables_sale_price_font_size').'px;';
													else:
													echo 'font-size:18px;';
													endif;

												if ( get_option('amalinkspro-settings-tables_sale_price_color') ) :
													echo 'color:'.get_option('amalinkspro-settings-tables_sale_price_color').';';
													else:
													echo 'color:#000;';
													endif;

											echo '}';

										endif;

										if ( get_option('amalinkspro-settings-tables_slashed_price_font_size') || get_option('amalinkspro-settings-tables_slashed_price_color') ) :

											echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(odd) td.alp_price .slashed-price span,.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(even) td.alp_price .slashed-price span{';

												if ( get_option('amalinkspro-settings-tables_slashed_price_font_size') ) :
													echo 'font-size:'.get_option('amalinkspro-settings-tables_slashed_price_font_size').'px;';
													else:
													echo 'font-size:18px;';
													endif;

												if ( get_option('amalinkspro-settings-tables_slashed_price_color') ) :
													echo 'color:'.get_option('amalinkspro-settings-tables_slashed_price_color').';';
													else:
													echo 'color:#000;';
													endif;

											echo '}';

										endif;

										if ( get_option('amalinkspro-settings-tables_amountpercentage_saved_font_size') || get_option('amalinkspro-settings-tables_amountpercentage_saved_color') ) :

											echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(odd) td.alp_price .prod-amount-saved,.alp-table-wrapper .amalinkspro-comparison-table tbody tr:nth-child(even) td.alp_price .prod-amount-saved{';

												if ( get_option('amalinkspro-settings-tables_amountpercentage_saved_font_size') ) :
													echo 'font-size:'.get_option('amalinkspro-settings-tables_amountpercentage_saved_font_size').'px;';
													else:
													echo 'font-size:18px;';
													endif;

												if ( get_option('amalinkspro-settings-tables_amountpercentage_saved_color') ) :
													echo 'color:'.get_option('amalinkspro-settings-tables_amountpercentage_saved_color').';';
													else:
													echo 'color:#000;';
													endif;

											echo '}';

										endif;


									endif;




									// Lowest New Price special field styles
									if ( get_option('amalinkspro-settings-tables_enable_lowest_new_price_field_styles') ) :

										echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td.amalinkspro_lowest-new-price {';
											if ( get_option('amalinkspro-settings-tables_lowest_new_price_text_color') ) :
												echo 'color:'.get_option('amalinkspro-settings-tables_lowest_new_price_text_color').';';
												else:
												echo 'color:#000;';
												endif;

											if ( get_option('amalinkspro-settings-tables_lowest_new_price_font_size') ) :
												echo 'font-size:'.get_option('amalinkspro-settings-tables_lowest_new_price_font_size').'px;';
												else:
												echo 'font-size:14px;';
												endif;

											if ( get_option('amalinkspro-settings-tables_lowest_new_price_line_height') ) :
												echo 'line-height:'.get_option('amalinkspro-settings-tables_lowest_new_price_line_height').'px;';
												else:
												echo 'line-height:16px;';
												endif;
										echo '}';

									endif;




									// Lowest Used Price special field styles
									if ( get_option('amalinkspro-settings-tables_enable_lowest_used_price_field_styles') ) :

										echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td.amalinkspro_lowest-used-price {';
											if ( get_option('amalinkspro-settings-tables_lowest_used_price_text_color') ) :
												echo 'color:'.get_option('amalinkspro-settings-tables_lowest_used_price_text_color').';';
												else:
												echo 'color:#000;';
												endif;

											if ( get_option('amalinkspro-settings-tables_lowest_used_price_font_size') ) :
												echo 'font-size:'.get_option('amalinkspro-settings-tables_lowest_used_price_font_size').'px;';
												else:
												echo 'font-size:14px;';
												endif;

											if ( get_option('amalinkspro-settings-tables_lowest_used_price_line_height') ) :
												echo 'line-height:'.get_option('amalinkspro-settings-tables_lowest_used_price_line_height').'px;';
												else:
												echo 'line-height:16px;';
												endif;
										echo '}';

									endif;



							endif; // END if ( get_option('amalinkspro-settings-tables_enable_font_styles_for_field_types') )

					endif; // end if ( get_option('amalinkspro-settings-tables_enable_table_row_font_styles') )

			endif; // END if ( get_option('amalinkspro-settings-tables_enable_table_row_styles') )



			echo '</style>';

			

		}

		$buffer = ob_get_clean();

		// Minify CSS
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(': ', ':', $buffer);
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

		echo $buffer;



	}



}
