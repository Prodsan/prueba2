<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Amalinks_Pro_Tables
 * @subpackage Amalinks_Pro_Tables/public
 * @author     AmaLinks Pro <support@amalinkspro.com>
 */
class Amalinks_Pro_Tables_Public {

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
	 * @param      string    $Amalinks_Pro_Tables       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Amalinks_Pro_Tables, $version ) {

		$this->Amalinks_Pro_Tables = $Amalinks_Pro_Tables;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->Amalinks_Pro_Tables, plugin_dir_url( __FILE__ ) . 'css/amalinkspro-tables-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->Amalinks_Pro_Tables, plugin_dir_url( __FILE__ ) . 'js/amalinkspro-tables-public-min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'alpfootable', plugin_dir_url( 'amalinkspro-tables.php' ) . 'amalinkspro-tables/includes/plugins/footable-standalone/js/footable.min.js', array( 'jquery' ), $this->version, true );

	}









	// [amalinkspro /]
	public function amalinkspro_table_shortcode_function( $atts, $content=null ) {

	    // set our table ID variable form the id attribute of the shortcode
	    //$table_id = $atts['id'];


	    $amalinkspro_table_html_output = '';

	    $table_id = $atts['id'];

	    $associate_id = $atts['aff-id'];
	    $new_window = $atts['new-window'];
	    $nofollow = $atts['nofollow'];
	    $addtocart = $atts['addtocart'];

	    if ($addtocart=='on'){$addtocart_class=" alp-table-links-addtocart";}
	    else {$addtocart_class="";}

	    if ($new_window=='on'){$new_window_class=" alp-table-links-newwindow"; $new_window_attr = ' target="_blank"';}
	    else {$new_window_class="";$new_window_attr = '';}

	    if ($nofollow=='on'){$nofollow_attr = ' rel="nofollow"';}
	    else {$nofollow_attr="";}

		$amazon_store_url = alp_paapi5_get_amazon_url_for_region();


		// $amalinkspro_table_html_output .= '<style type="text/css">';
		// $amalinkspro_table_html_output .= '</style>';

	    if (!$table_id) {
			$amalinkspro_table_html_output = 'The Table ID is Missing';
			return $amalinkspro_table_html_output;
	    }


	    



	    $table_data = array();


		// we have a saved table to load!

		if ( get_post_meta( $table_id, 'alp_table_api_type', true ) ) {
			$table_data['alp_table_api_type'] = get_post_meta( $table_id, 'alp_table_api_type', true );
		}
		else {
			$table_data['alp_table_api_type'] = 'yesapi';
		}


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
			$alp_featured_row = str_replace('row-', '', get_post_meta( $table_id, 'alp_featured_row', true ) );
			$table_data['alp_featured_row'] = $alp_featured_row;
		}
		else {
			$table_data['alp_featured_row'] = 'none';
		}


		$all_asins = array();


		if ( get_post_meta( $table_id, 'alp_table_columns_data' ) ) {

			$table_data['alp_table_rows'] = get_post_meta( $table_id, 'alp_table_rows', true );

			$rows_count = get_post_meta( $table_id, 'alp_table_rows', true );
			$tds_count = get_post_meta( $table_id, 'alp_table_columns_data', true );

			for ( $i = 0; $i < $rows_count; $i++ ) {

				$table_data['rows'][$i]['settings'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_settings', true );
				$table_data['rows'][$i]['asin'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_asin', true );
				$table_data['rows'][$i]['url'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_url', true );

				$all_asins[$i] = $table_data['rows'][$i]['asin'];
				

				for ( $j = 0; $j <= $tds_count; $j++ ) {
					$table_data['rows'][$i]['cells'][$j]['type'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_type', true );
					$table_data['rows'][$i]['cells'][$j]['html'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_html', true );
					$table_data['rows'][$i]['cells'][$j]['id'] = get_post_meta( $table_id, 'alp_table_rows_' . $i . '_cell_' . $j . '_id', true );
				}

			}

		}
		else {
			$table_data['columns_count'] = '0';
			$table_data['columns'] = '';
		}

		$all_asins_string = '';

		//$amalinkspro_table_html_output .= '$all_asins<pre>'.print_r($all_asins,1).'</pre>';

		if ($all_asins) {

			$m=0;

			foreach ($all_asins as $asin) {

				if ($m>0) {
					$all_asins_string .= ',';
				}

				$all_asins_string .= $asin;

				$m++;

			}

		}


		if ( $table_data && $table_data['columns_count'] ) :


			// echo '$table_data: <pre>'.print_r($table_data,1).'</pre>';


			//$amalinkspro_table_html_output .= $this->amalinkspro_tables_get_table_global_styles(); 
			$Amalinks_Pro_Tables_Admin = New Amalinks_Pro_Tables_Admin('','','','');
			$table_settings = $Amalinks_Pro_Tables_Admin->get_amalinkspro_tables_attributes();

			if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) || $table_data['alp_table_rows'] == 'noapi' ) {
				$alp_noapi = 'alp-no-noapi';
			}
			else {
				$alp_noapi = 'alp-load-api';
			}



			$amalinkspro_table_html_output .= '<div class="alp-table-wrapper">';

			if ( get_option('amalinkspro-settings-tools-no_advanced_table_features') ) {
  				$no_advanced_table_features = ' alp-simple-table';
			}
			else {
				$no_advanced_table_features = '';
			}
			

			$amalinkspro_table_html_output .= '<table border="0" id="alp-table-'.$table_id.'" data-alp-table-id="'.$table_id.'" data-alp-table-cols="'.$table_data['columns_count'].'" data-alp-table-rows="'.$table_data['rows_count'].'" class="amalinkspro-comparison-table amalinkspro-comparison-table-public'.$addtocart_class.$new_window_class.$no_advanced_table_features.' '.$alp_noapi.'" '.$table_settings.' dala-all-asins="'.$all_asins_string.'">';

				if ( $table_data['columns_count'] ) :

					$amalinkspro_table_html_output .= '<thead>';


						if ( $table_data['columns'] ) :

							$amalinkspro_table_html_output .= '<tr class="alp-table-headings">';

								$i=0; $j = 0; 

								foreach ( $table_data['columns'] as $th_col ) :

									if ( $i != 0 ) :

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
											$data_type = 'html';
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
										


										$amalinkspro_table_html_output .= '<th id="column-header-'.$i.'" class="" 
											data-alp-table-col-width="'.$th_col['width'].'" 
											data-alp-table-th-type="'.$th_col['type'].'" 
											data-type="'.$data_type.'" 
											data-breakpoints="'.$col_breakpoints.'" '
											. $disable_sort .
											' style="vertical-align: '.$table_data['columns_settings'][$j]['verticalAlign'].'; text-align: '.$table_data['columns_settings'][$j]['horizontalAlign'].';">'.$th_col['name'].'</th>';

											$j++;

									endif;

								$i++; endforeach;

							$amalinkspro_table_html_output .= '</tr>';

						endif;

					$amalinkspro_table_html_output .= '</thead>';

				endif;





				if ( $table_data['rows_count'] ) :


					$amalinkspro_table_html_output .= '<tbody>';


						$i=1; foreach ( $table_data['rows'] as $row ) :

							// echo '$row: <pre>'.print_r($row,1).'</pre>';

							if ($i % 2 == 0) {
								$evenodd = 'even';
							}
							else {
								$evenodd = 'odd';
							}

							$row_count = $i - 1;

							$featured_class="";
							if ( $table_data['alp_featured_row'] !== 'none' && $row_count == $table_data['alp_featured_row'] ) {
								$featured_class=" alp-featured-table-row";
							}

							$amazon_store_url = alp_paapi5_get_amazon_url_for_region();


							if ( $row['url'] != '' ) {
								$aff_url = $row['url'];
								$full_aff_link_cover = '<a class="alp-td-cover" href="'.$row['url'].'"'.$new_window_attr.$nofollow_attr.'></a>';
							}
							else {
								// this is our old backup manual url that works for old tabels
								$aff_url = 'https://' . $amazon_store_url . '/dp/' .$row['asin']. '/?tag=' .$associate_id;
								$full_aff_link_cover = '<a class="alp-td-cover" href="https://' . $amazon_store_url . '/dp/' .$row['asin']. '/?tag=' .$associate_id.'"'.$new_window_attr.$nofollow_attr.'></a>';
							}

								

							$amalinkspro_table_html_output .= '<tr class="'.$featured_class.'" alp-data-asin="'.$row['asin'].'" data-row-url="'.$row['url'].'" data-table-row-evenodd="'.$evenodd.'">';


								if ( $row['cells'] ) :

									$j=0; $k=0; foreach (  $row['cells'] as $td ) :


									if ( $table_data['alp_featured_row'] !== 'none' && $row_count == $table_data['alp_featured_row'] ) {
										$amalinkspro_featured_row_output =  '<span class="alp-top-pick" href="'.$aff_url.'"><span class="alp-top-pick-text">Top</span><span class="alp-top-pick-angle"></span></span>';
									}
									else {
										$amalinkspro_featured_row_output = '';
									}


									// echo '<pre>'.print_r($td,1).'</pre>';


										if ( $j != 0 ) :

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
												$td_content = $td['html'];
											}
											
											else if ( $td['type'] == 'prime' ) {
												$data_type = 'text';
												$td_content = $td['html'];
											}

											else if ( $td['type'] == 'image' ) {
												$td_content = '<i class="icon-amalinkspro-spin3 animate-spin"></i>';
												$td_img_id = ' data-img-id="'.$td["id"].'"';
											}


											else if (
												$td['type'] == 'price-list' || 
												$td['type'] == 'price-offer' || 
												$td['type'] == 'price-lowest-new-price' || 
												$td['type'] == 'price-lowest-used-price'
											) {

												//$price = $td['html'];
												//$cleaned_number = preg_replace( '/[^0-9]/', '', $price );
												$data_sort_val = ' data-sort-value""';

												$td_content = '<i class="icon-amalinkspro-spin3 animate-spin"></i>';
											}
											else {
												$data_type = 'html';
												$td_content = $td['html'];
												$td_img_id = '';
											}

											if ( $td['type'] == 'cta-btn' ) {
												// clear out the cover link if it is the CTA column
												$full_aff_link_cover = '';
												$aff_url_string = ' data-alp-aff-link="'.$aff_url.'"';
											}
											else {
												$aff_url_string = '';
											}
											

											// echo '$table_data: <pre>'.print_r($table_data,1).'</pre>';

											$amalinkspro_table_html_output .= '<td data-alp-table-td-type="'.$td['type'].'" 
												data-type="'.$data_type.'"'.$data_sort_val.' style="vertical-align:'. $table_data['columns_settings'][$k]['verticalAlign'].'; text-align: '.$table_data['columns_settings'][$k]['horizontalAlign'].';"'.$aff_url_string.$td_img_id.'>';


												if ( $j == 1 ) {
													$amalinkspro_table_html_output .= $amalinkspro_featured_row_output;
												}

												$amalinkspro_table_html_output .= $td_content;

												if ( $table_data['columns_settings'][$k]['linkCell'] == '1' ) {
													$amalinkspro_table_html_output .= $full_aff_link_cover;
												}

												
												
												$amalinkspro_table_html_output .= '</td>';

												$k++;

										endif;

									$j++; endforeach;


								endif;

							$amalinkspro_table_html_output .= '</tr>';

						$i++; endforeach;


					$amalinkspro_table_html_output .= '</tbody>';

				endif;

			$amalinkspro_table_html_output .= '</table>';

			$amalinkspro_table_html_output .= '</div>';


			// $amalinkspro_table_html_output .= '<p class="amalinkspro-table-prices-accuracy">Prices accurate as of: ' . date("F j, Y, g:i a") . '</p>';

			if ( !get_option( 'amalinkspro-options_alp_no_amazon_api' ) )  {

				if ( $table_data['alp_table_api_type'] != 'noapi' ) {

				$amalinkspro_table_html_output .= '<p class="amalinkspro-table-prices-accuracy"><span class="alp-js-apidate-disclaimer icon-amalinkspro-info-block"></span> Prices and images pulled from the Amazon Product Advertising API on: <span class="amalinkspro-table-prices-accuracy-date"></span></p>';

				}

			}

		endif;



	    return $amalinkspro_table_html_output;


	}





	public function amalinkspro_tables_get_table_global_styles() {

		// table header styles

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


			// table wrapper styles
			// if ( get_option('amalinkspro-settings-tables_enable_table_wrapper_border') ) :

			// 	echo '.alp-table-wrapper {';

			// 		if ( get_option('amalinkspro-settings-tables_table_wrapper_border_width') ) :
			// 			echo 'border-width:'.get_option('amalinkspro-settings-tables_table_wrapper_border_width').'px;';
			// 			else:
			// 			echo 'border-width:1px;';
			// 			endif;

			// 		if ( get_option('amalinkspro-settings-tables_table_wrapper_border_style') ) :
			// 			echo 'border-style:'.get_option('amalinkspro-settings-tables_table_wrapper_border_style').';';
			// 			else:
			// 			echo 'border-style:solid;';
			// 			endif;

			// 		if ( get_option('amalinkspro-settings-tables_table_wrapper_border_color') ) :
			// 			echo 'border-color:'.get_option('amalinkspro-settings-tables_table_wrapper_border_color').';';
			// 			else:
			// 			echo 'border-color:#dedede;';
			// 			endif;

			// 	echo '}';

			// endif;



			// table header styles
			if ( get_option('amalinkspro-settings-tables_enable_table_header_styles') ) :

				echo '.alp-table-wrapper .amalinkspro-comparison-table thead tr th{';

					if ( get_option('amalinkspro-settings-tables_table_header_bg_color') ) :
						echo 'background:'.get_option('amalinkspro-settings-tables_table_header_bg_color').';';
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
						echo 'padding-top:'.get_option('amalinkspro-settings-tables_th_padding_top').'px;';
						else:
						echo 'padding-top:10px;';
						endif;

					if ( get_option('amalinkspro-settings-tables_th_padding_right') ) :
						echo 'padding-right:'.get_option('amalinkspro-settings-tables_th_padding_right').'px!important;';
						else:
						echo 'padding-right:15px;';
						endif;

					if ( get_option('amalinkspro-settings-tables_th_padding_bottom') ) :
						echo 'padding-bottom:'.get_option('amalinkspro-settings-tables_th_padding_bottom').'px;';
						else:
						echo 'padding-bottom:10px;';
						endif;

					if ( get_option('amalinkspro-settings-tables_th_padding_left') ) :
						echo 'padding-left:'.get_option('amalinkspro-settings-tables_th_padding_left').'px;';
						else:
						echo 'padding-left:10px;';
						endif;

				echo '}';


				echo '.alp-table-wrapper .amalinkspro-comparison-table .footable .btn-primary{';
					echo 'background-color:'.get_option('amalinkspro-settings-tables_table_header_color').';';
					echo 'border-color:'.get_option('amalinkspro-settings-tables_table_header_color').';';
				echo '}';


				// table header border styles
				if ( get_option('amalinkspro-settings-tables_enable_table_header_border') ) :

					echo '.alp-table-wrapper .amalinkspro-comparison-table thead,body .amalinkspro-comparison-table[data-filtering="true"] > thead > tr.footable-filtering > th{';

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


			// table footer styles
			if ( get_option('amalinkspro-settings-tables_enable_table_footer_styles') ) :

					if ( get_option('amalinkspro-settings-tables_table_footer_bg_color') ) :
						echo '.alp-table-wrapper .amalinkspro-comparison-table tfoot, .footable .label-default, body .amalinkspro-comparison-table tfoot > .footable-paging > td {';
							echo 'background-color:'.get_option('amalinkspro-settings-tables_table_footer_bg_color').';';
							echo 'border-color:'.get_option('amalinkspro-settings-tables_table_footer_bg_color').';';
						echo '}';
					endif;

					if ( get_option('amalinkspro-settings-tables_table_footer_text_color') ) :
						echo '.alp-table-wrapper .amalinkspro-comparison-table tfoot, #content .alp-table-wrapper .amalinkspro-comparison-table tfoot span, .alp-table-wrapper .amalinkspro-comparison-table .footable .pagination > li > a {';
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



			// body .alp-table-wrapper .amalinkspro-comparison-table tbody tr.alp-featured-table-row[data-table-row-evenodd="odd"] td:first-child:before

			/******************/
			// table row styles
			/******************/
			if ( get_option('amalinkspro-settings-tables_enable_table_row_styles') ) :

					// table odd row styles
					if ( get_option('amalinkspro-settings-tables_odd_row_background_color') ) :
						echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"], .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] + .footable-detail-row, .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="odd"] + .footable-detail-row .amalinkspro-comparison-table, body .alp-table-wrapper .amalinkspro-comparison-table tbody tr.alp-featured-table-row[data-table-row-evenodd="odd"] td:first-child:before, body .alp-table-wrapper .amalinkspro-comparison-table tbody tr.alp-featured-table-row[data-table-row-evenodd="odd"] td:last-child:before {';
							echo 'background-color:'.get_option('amalinkspro-settings-tables_odd_row_background_color');
						echo '}';
					endif;

					// table even row styles
					if ( get_option('amalinkspro-settings-tables_even_row_background_color') ) :
						echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"], .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] + .footable-detail-row, .alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] + .footable-detail-row .amalinkspro-comparison-table, body .alp-table-wrapper .amalinkspro-comparison-table tbody tr.alp-featured-table-row[data-table-row-evenodd="even"] td:first-child:before, body .alp-table-wrapper .amalinkspro-comparison-table tbody tr.alp-featured-table-row[data-table-row-evenodd="even"] td:last-child:before {';
							echo 'background-color:'.get_option('amalinkspro-settings-tables_even_row_background_color');
						echo '}';
					endif;

					/*************************/
					// table row bottom border
					/*************************/
					if ( get_option('amalinkspro-settings-tables_enable_table_row_bottom_border') ) :
						echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr{';
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

						echo 'body .alp-table-wrapper .amalinkspro-comparison-table tbody tr.alp-featured-table-row td:first-child:before, body .alp-table-wrapper .amalinkspro-comparison-table tbody tr.alp-featured-table-row td:last-child:before {';
							echo 'border-top: none;';
							echo 'border-bottom: none;';
						echo '}';


						echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr:last-child{border-bottom:none;}';
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
								echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.amalinkspro_features li,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.alp_price .alp-sale-price,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.alp_price .slashed-price span,.alp-table-wrapper .amalinkspro-comparison-table tbody tr[data-table-row-evenodd="even"] td.alp_price .prod-amount-saved {';
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

									// 	echo '.alp-table-wrapper .amalinkspro-comparison-table tbody tr td[data-alp-table-td-type="asin"] {';
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


		// $buffer = '';

		echo $buffer;




	}


}
