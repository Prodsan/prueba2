<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://amalinkspro.com
 * @since      1.0.0
 *
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ama_Links_Pro
 * @subpackage Ama_Links_Pro/public
 * @author     Your Name <email@amalinkspro.com>
 */
class Ama_Links_Pro_Public {

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
	 * @param      string    $Ama_Links_Pro       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Ama_Links_Pro, $version ) {

		$this->Ama_Links_Pro = $Ama_Links_Pro;
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
		 * defined in Ama_Links_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ama_Links_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Ama_Links_Pro, plugin_dir_url( __FILE__ ) . 'css/amalinkspro-public.css', array(), $this->version, 'all' );

		$google_fonts_api = new amalinkspro_google_fonts();
		$google_fonts_css = $google_fonts_api->build_google_fonts_css_link();

		// echo 'iuhigiuhiubh: <pre>'.print_r($google_fonts_css,1).'</pre>';
		if ($google_fonts_css) {
			wp_enqueue_style( 'amalinkspro-googlefonts', $google_fonts_css, array(), null, 'all' );
		}

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
		 * defined in Ama_Links_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ama_Links_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Ama_Links_Pro, plugin_dir_url( __FILE__ ) . 'js/amalinkspro-public-min.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->Ama_Links_Pro, 'objectL10n', array(
			'reviews'  => esc_html__('View Ratings and Reviews', 'amalinkspro'),
		) );

		if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) == 1  ) {
			$alp_noapi = 'noapi';
		}

		else {
			$alp_noapi = 'yesapi';
		}

		wp_localize_script( $this->Ama_Links_Pro, 'ALPvars', array(
			'page_id' => get_the_ID(),
			'IsAdminSide' => 0,
			'AlpNoAPI' => $alp_noapi,
			'EventTrackingEnabled' => get_option('amalinkspro-options_enable_event_tracking', true),
		) );



	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function amalinkspro_ajaxurl() {

		echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function amalinks_pro_footer_scripts() {

		$footer_scripts = '';

		$footer_scripts .= get_option('amalinkspro-options_amazon_onelink_script', true);

		echo $footer_scripts;

	} 




	// [amalinkspro /]
	public function amalinkspro_shortcode_functions( $atts, $content=null ) {

	    // set our table ID variable form the id attribute of the shortcode
	    //$table_id = $atts['id'];

	    //echo '<pre>'.print_r($atts,1).'</pre>';

	    $amalinkspro_html_output = '';

	    if ( $atts['asin'] ) {
	    	$asin = $atts['asin'];
	    }
	    else {
	    	$asin = 'noasin';
	    }


	    // create backup aff ID or for old links types bewfore Quota 
	    $amazon_store_url = alp_paapi5_get_amazon_url_for_region();
	    $associate_id = $atts['associate-id'];
	    $aff_url = 'https://'.$amazon_store_url.'/dp/'.$asin.'/?tag='.$associate_id;


	    // if the new attribuite apilink exists - use it as our afiliate link
	    if ( $atts['apilink'] ) {
	    	$aff_url = $atts['apilink'];
	    	$apilink = ' apilink';
	    }
	    else {

	    	$apilink = '';

	    	// if there this is a non-API link ...
	    	 if ($asin == 'noapi' ) {
	    	 	if ( $atts['associate-id'] ) {
			    	$aff_url = $atts['associate-id'];
			    }
			    else {
			    	$aff_url = '';
			    }
		    }

	    }


	    
	    


	    if ( $atts['new-window'] && ( $atts['new-window'] == 1 || $atts['new-window'] == 'true' ) ) {
	    	$new_window = ' target="_blank"';
	    }
	    else {
	    	$new_window = '';
	    }

	    if ( $atts['nofollow'] && ( $atts['nofollow'] == 1 || $atts['nofollow'] == 'true' ) ) {
	    	$nofollow = ' rel="nofollow"';
	    }
	    else {
	    	$nofollow = '';
	    }


	    if ( $atts['addtocart'] && ( $atts['addtocart'] == 1 || $atts['addtocart'] == 'true' ) ) {
	    	$add_to_cart = ' alp-add-to-cart-true';
	    }
	    else {
	    	$add_to_cart = '';
	    }



	    if ( $atts['alignment'] && $atts['alignment'] != '' ) {
	    	$alignment = ' ' . $atts['alignment'];
	    	$img_alignment = $atts['alignment'];
	    }
	    else {
	    	$alignment = ' amalinkspro-align-none';
	    }


	    if ( $atts['width'] && $atts['width'] != '' ) {
	    	$maxWidth = $atts['width'] . 'px';
	    }
	    else {
	    	$maxWidth = '750px';
	    }






	    if ( $asin && $aff_url  ) {


			/*
			http://amzn.com/0470560541/?tag=wpb09-20
			http://amazon.com/dp/0470560541/?tag=wpb09-20
			*/

		    $link_type = $atts['type'];



		    //$aws_access_key_id = trim( get_option( 'amalinkspro-options_amazon_api_access_key' ) );


		    if ( $link_type == 'text-link' ) {

		    	$amalinkspro_html_output .= '<a class="amalinkspro-text-link'.$add_to_cart.' apilink" href="'.$aff_url.'"'.$new_window.$nofollow.' data-alp-asin="' . $asin . '">';
		    	$amalinkspro_html_output .= $content;
		    	$amalinkspro_html_output .= '</a>';

		    }

		    elseif ( $link_type == 'image-link' ) {

		    	$img_alt = $atts['alt'];

		    	$amalinkspro_html_output .= '<a class="amalinkspro-img-link'.$add_to_cart.' apilink" href="'.$aff_url.'"'.$new_window.$nofollow.' data-alp-asin="' . $asin . '"><img class="'.$img_alignment.'" src="' .$content. '" alt="'.$img_alt.'" /></a>';
		    	
		    }

		    elseif ( $link_type == 'cta-btn-css' || $link_type == 'cta-btn-img' ) {




		    	if ( $link_type == 'cta-btn-css' ) {

		    		$cta_id = $atts['ctabtn-id'];
			    	$cta_class = $atts['ctaclass'];

			    	$data = get_option( 'amalinkspro_cta_buttons_' . $cta_id . '_button_data' );

					$amalinkspro_html_output .= '<style type="text/css">';

						$amalinkspro_html_output .= '.amalinkspro-cta-wrap.cta-id-' . $cta_id . ' .amalinkspro-cta-btn{';


							if ( $data['text']['font-family-type'] == 1 ) {
								$font_family = $data['text']['font-family-google'];
							}
							else {
								$font_family = $data['text']['font-family'];
							}
							$amalinkspro_html_output .= 'font-family: '. $font_family.';';
							$amalinkspro_html_output .= 'font-size: '. $data['text']['font-size'].'px;';
							$amalinkspro_html_output .= 'color: '. $data['text']['font-color'].' !important;';
							if ( $data['text']['textshadow-enable'] == 'on' ) {
								$text_shadow = $data['text']['textshadow-x'].'px '.$data['text']['textshadow-y'].'px '.$data['text']['textshadow-blur'].'px '.$data['text']['textshadow-color'];
							}
							else {
								$text_shadow = 'none';
							}
							$amalinkspro_html_output .= 'text-shadow: '. $text_shadow.';';
							$amalinkspro_html_output .= 'padding: '. $data['box']['padding-t'].'px '.$data['box']['padding-r'].'px '.$data['box']['padding-b'].'px '.$data['box']['padding-l'].'px;';
							if ( $data['box']['boxshadow-enable'] == 'on' ) {
								$amalinkspro_html_output .= 'box-shadow:' . $data['box']['boxshadow-x'].'px '. $data['box']['boxshadow-y'].'px '. $data['box']['boxshadow-blur'].'px '. $data['box']['boxshadow-color'].';';
							}
							else {
								$amalinkspro_html_output .= 'box-shadow: none;';
							}
							$amalinkspro_html_output .= 'border-radius: '. $data['border']['border-radius'].'px;';
							$amalinkspro_html_output .= 'border: '. $data['border']['border-width'].'px solid '.$data['border']['border-color'].';';
							if ( $data['background']['bg-type'] == 'bg-solid' ) {
								$amalinkspro_html_output .= 'background:' . $data['background']['bg-solid-color'].';';
							}
							elseif ( $data['background']['bg-type'] == 'bg-gradient' ) {
								$amalinkspro_html_output .= 'background: linear-gradient(' . $data['background']['bg-top-color'] . ' 0%,' . $data['background']['bg-solid-color'] . ' 100%)';
							}


							

						$amalinkspro_html_output .= '}';


						$amalinkspro_html_output .= '.amalinkspro-cta-wrap.cta-id-' . $cta_id . ' .amalinkspro-cta-btn:hover{';


							$amalinkspro_html_output .= 'font-size: '. $data['text']['font-size-h'].'px;';
							$amalinkspro_html_output .= 'color: '. $data['text']['font-color-h'].' !important;';
							if ( $data['text']['textshadow-enable'] == 'on' ) {
								$text_shadow = $data['text']['textshadow-x-h'].'px '.$data['text']['textshadow-y-h'].'px '.$data['text']['textshadow-blur-h'].'px '.$data['text']['textshadow-color-h'];
							}
							else {
								$text_shadow = 'none';
							}
							$amalinkspro_html_output .= 'text-shadow: '. $text_shadow.';';
							$amalinkspro_html_output .= 'padding: '. $data['box']['padding-t-h'].'px '.$data['box']['padding-r-h'].'px '.$data['box']['padding-b-h'].'px '.$data['box']['padding-l-h'].'px;';
							if ( $data['box']['boxshadow-enable'] == 'on' ) {
								$amalinkspro_html_output .= 'box-shadow:' . $data['box']['boxshadow-x-h'].'px '. $data['box']['boxshadow-y-h'].'px '. $data['box']['boxshadow-blur-h'].'px '. $data['box']['boxshadow-color-h'].';';
							}
							else {
								$amalinkspro_html_output .= 'box-shadow: none;';
							}
							$amalinkspro_html_output .= 'border-radius: '. $data['border']['border-radius-h'].'px;';
							$amalinkspro_html_output .= 'border: '. $data['border']['border-width-h'].'px solid '.$data['border']['border-color-h'].';';
							if ( $data['background']['bg-type-h'] == 'bg-solid' ) {
								$amalinkspro_html_output .= 'background:' . $data['background']['bg-solid-color-h'].';';
							}
							elseif ( $data['background']['bg-type-h'] == 'bg-gradient' ) {
								$amalinkspro_html_output .= 'background: linear-gradient(' . $data['background']['bg-top-color-h'] . ' 0%,' . $data['background']['bg-solid-color-h'] . ' 100%)';
							}


						$amalinkspro_html_output .= '}';
								    
					$amalinkspro_html_output .= '</style>';

			    	//$amalinkspro_html_output .= '$data - <pre>'.print_r($data,1).'</pre>'; //die();

		    		$amalinkspro_html_output .= '<span class="amalinkspro-cta-wrap'.$alignment.' cta-id-'.$cta_id .$cta_class. '">';

		    		$amalinkspro_html_output .= '<a href="'.$aff_url.'" class="amalinkspro-cta-btn'.$add_to_cart.$apilink.'"'.$new_window.$nofollow.' data-alp-asin="' . $asin . '">' .$content. '</a> ';

		    		$amalinkspro_html_output .= '</span>';

		    	}

		    	else if ( $link_type == 'cta-btn-img' ) {

		    		$amalinkspro_html_output .= '<span class="amalinkspro-cta-wrap'.$alignment.' ' .$cta_class. '">';

		    		$cta_alt = $atts['cta_alt'];

		    		$amalinkspro_html_output .= '<a href="'.$aff_url.'" class="amalinkspro-cta-image-link'.$add_to_cart.$apilink.'"'.$new_window.$nofollow.' data-alp-asin="' . $asin . '"><img src="' .$content. '" alt="'.$cta_alt.'" /></a> ';

		    		$amalinkspro_html_output .= '</span>';

		    	}

		    	
		    }

		    elseif ( $link_type == 'showcase' ) {

		    	ob_start();

		    	$showcase_id = $atts['sc-id'];

		    	// echo '$atts: <pre>'.print_r($atts,1).'</pre>';

			    $showcase_images = $atts['imgs'];
			    $showcase_specs = $atts['specs'];
			    $showcase_bullets = $atts['specs'];
			    $showcase_color = $atts['btn-color'];


			    if ( $atts['btn-text'] != '' ) {
			    	$button_text = $atts['btn-text'];
			    }
			    else if ( get_option('amalinkspro-options_cta_btn_default_text') ) {
            		$button_text = get_option('amalinkspro-options_cta_btn_default_text');
            	}
            	else {
            		$button_text = 'View on Amazon';
            	}


			    if ( $atts['link-imgs'] ) {
			    	$link_imgs = $atts['link-imgs'];
			    }
			    else {
			    	$link_imgs = 'true';
			    }

			    $temp = explode ('|||',$showcase_specs);

			    $final_array = array();

			    //echo '$temp<pre>'.print_r($temp,1).'</pre>';

			    $i=0;

			    foreach ( $temp as $t ) {

			    	$temp_2 = explode ('~~~',$t);

			    	foreach ( $temp_2 as $t2 ) {
			    		
			    		$temp_3 = explode (':::',$t2);
			    		$final_array[$i][$temp_3[0]] = $temp_3[1];
			    	}

					$i++;
			    }





		    	if ( $showcase_id == '4' ) {


		    		if ( get_option('amalinkspro-settings-tools-hide_stars', true) ) {
		    			$data_alp_hide_stars = 'hide';
		    		}
		    		else {
		    			$data_alp_hide_stars = 'show';
		    		}


		    		if ( $atts['hide-prime'] && $atts['hide-prime'] == true ) {
				    	$hide_prime = true;
				    }
				    else {
				    	$hide_prime = false;
				    }

				    if ( $atts['hide-image'] && $atts['hide-image'] == true ) {
				    	$hide_image = true;
				    }
				    else {
				    	$hide_image = false;
				    }

				    if ( $atts['hide-reviews'] && $atts['hide-reviews'] == true ) {
				    	$hide_reviews = true;
				    }
				    else {
				    	$hide_reviews = false;
				    }

				    if ( $atts['hide-price'] && $atts['hide-price'] == true ) {
				    	$hide_price = true;
				    }
				    else {
				    	$hide_price = false;
				    }

				    if ( $atts['hide-button'] && $atts['hide-button'] == true ) {
				    	$hide_button = true;
				    }
				    else {
				    	$hide_button = false;
				    }

		    		?>

		    		<?php // echo '<pre>'.print_r($atts,1).'</pre>'; ?>


		    		<?php
		    		if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) == true  ) {
						$alp_noapi = 'alp-no-noapi';
					}

					else {
						$alp_noapi = 'alp-load-api';
					}

					if ( get_option( 'amalinkspro-settings-tools-hideprime' ) != 1 ) {
	                	$noprime = ' yesprime';
	                } 
	                else {
	                	$noprime = ' noprime';
	                }
		    		?>




		    		<div class="amalinkspro-showcase<?php echo $alignment.$apilink.$noprime; ?> amalinkspro-showcase-4 <?php echo $alp_noapi; ?>" data-alp-img="<?php echo $showcase_images; ?>" data-alp-asin="<?php echo $asin; ?>" data-alp-hide-prime="<?php echo $hide_prime; ?>" data-alp-hide-image="<?php echo $hide_image; ?>" data-alp-hide-reviews="<?php echo $hide_reviews; ?>" data-alp-hide-price="<?php echo $hide_price; ?>" data-alp-hide-button="<?php echo $hide_button; ?>" style="max-width:<?php echo $maxWidth; ?>;">

		    			<?php if ( get_option( 'amalinkspro-settings-tools-hideimage' ) != 1 ) : ?>

			    			<div class="amalinkspro-showcase-stats-col amalinkspro-showcase-stats-col-img">
			                    <span class="alp-showcase-img-wrap enabled-img">

			                    	<?php if ( $showcase_images == 'LargeImage' || is_numeric($showcase_images) ) : ?>

			                    		<!-- <img class="amalinkspro-license-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" /> -->
										<a class="alp-showcase-img-link <?php echo $add_to_cart; ?>" href="<?php echo $aff_url; ?>" <?php echo $new_window.$nofollow; ?>></a>

			                    	<?php else : ?>

			                    		<?php echo urldecode($showcase_images); ?>

									<?php endif; ?>
								</span>
			                </div>

		                <?php endif; ?>

		                <div class="amalinkspro-showcase-stats-col amalinkspro-showcase-stats-col-info">
		                    <a class="amalinkspro-showcase-4-titlebox <?php echo $add_to_cart; ?>" href="<?php echo $aff_url; ?>" <?php echo $new_window.$nofollow; ?>><?php echo $content; ?></a>
		                    <div class="showcase-4-features">
		                    	<?php
		                    	// echo '$showcase_bullets<pre>'.print_r($showcase_bullets,1).'</pre>';
		                    	$showcase_bullets = explode ('~~~',$showcase_bullets);
			    				// $showcase_bullets = array();
		                    	?>

		                    	<?php if ($showcase_bullets) : ?>

		                    		<ul>
										<?php $i = 1; foreach ( $showcase_bullets as $bullet ) : ?>
											<li>
												<span class="alp-showcase-spec-val-editable"><?php echo $bullet; ?></span>
											</li>
										<?php $i++; endforeach; ?>

									</ul>

								<?php endif; ?>


		                    </div>

		                    <div class="showcase-4-reviews"></div>
		                    
		                </div>

		                <div class="amalinkspro-clear"></div>

		                <div class="amalinkspro-showcase-bottom-cta">
		                	<?php if ( get_option( 'amalinkspro-settings-tools-hideprice' ) != 1 ) : ?>
		                		<div class="amalinkspro-showcase-bottom-cta-price"><span></span><!-- <img class="amalinkspro-license-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" /> --></div>
		                	<?php endif; ?>
		                	<a class="amalinkspro-showcase-bottom-cta-link <?php echo $add_to_cart; ?>" href="<?php echo $aff_url; ?>" <?php echo $new_window.$nofollow; ?>><span class="alp-showcase-amalink-editable"><?php echo $button_text; ?></span></a>
		                	<div class="amalinkspro-clear"></div>
		                </div>

		                <div class="alp-showcase-loader">
		                	<span>
			                	<i class="icon-amalinkspro-spin3 animate-spin"></i>
			                </span>
		                </div>

		                <?php if (!get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

		                	<?php if ( get_option( 'amalinkspro-settings-tools-hideprice' ) != 1 ) : ?>

		                		<?php if ( !$hide_price ) : ?>

									<p class="alp-prices-accuracy"><span class="alp-js-apidate-disclaimer icon-amalinkspro-info-block"></span> <?php _e('Prices pulled from the Amazon Product Advertising API on', 'amalinkspro'); ?>: <span class="alp-api-request-date"></span></p>

									<p class="alp-prices-discalimer"><span class="alp-js-close-price-info-popup"></span><?php _e('Product prices and availability are accurate as of the date/time indicated and are subject to change. Any price and availability information displayed on [relevant Amazon Site(s), as applicable] at the time of purchase will apply to the purchase of this product.', 'amalinkspro'); ?></p>

								<?php endif; ?>

							<?php endif; ?>

						<?php endif; ?>

						<div class="amalinkspro-clear"></div>

		    		</div>

		    		

		    	<?php

		    	}

		    	else {
		    		echo '<p>'.__('Sorry, there was an error building this shortcode. No proper showcase id found.', 'amalinkspro') . '</p>';
		    	}

		    	$amalinkspro_html_output .= ob_get_contents();
				ob_end_clean();

		    }

		    else {
		    	$amalinkspro_html_output .= __('Error: Unknown Link Type', 'amalinkspro');
		    }

		}


	    return $amalinkspro_html_output;



	}



	public function amazon_add_to_cart_setup() {

		global $wpdb; // this is how you get access to the database

		$aws_access_key_id = trim( get_option( 'amalinkspro-options_amazon_api_access_key' ) );
		$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
		$affiliate_id = trim( get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_0_associate_id' ) );

		$amazon_api_get_store_url = alp_paapi5_get_amazon_url_for_region();

		if ( $aws_access_key_id && $affiliate_id ) {

			$form_html = '<form id="alp-amazon_addtocart_form" method="GET" action="https://'.$amazon_api_get_store_url.'/gp/aws/cart/add.html"> 
			<input type="hidden" name="AWSAccessKeyId" value="'.$aws_access_key_id.'" />
			<input type="hidden" name="AssociateTag" value="'.$affiliate_id.'" />
			<input class="alp-asin" type="text" name="ASIN.1" value="" />
			<input type="text" name="Quantity.1" value="1" />
			<input type="submit" name="add" value="add" /> 
			</form>';

		}
		else {
			$form_html = '<p id="alp-amazon_addtocart_form">AmaLinks Pro ' . __('Error') . '</p>';
		}

			

		echo $form_html;

		die();

		
	}




	public function amalinkspro_autoshowcase_shortcode_function( $atts ) {

		// echo '$atts: <pre>'.print_r($atts,1).'</pre>';

		if ( !$atts['asin'] ) {

			echo 'error';
			die();

		}



		if ( get_option( 'amalinkspro-options_alp_no_amazon_api' )  ) {
			return '<!-- There is No Product Advertising API Connection so this showcase can not display. -->';
		}







		$amalinkspro_html_output = '';

	    $asin = $atts['asin'];
	    $associate_id = $atts['associate-id'];



		$amazon_store_url = alp_paapi5_get_amazon_url_for_region();


	    if ( get_option('amalinkspro-options_open_links_in_a_new_window', true) ) {
	    	$new_window = 'true';
	    }
	    else {
	    	$new_window = 'false';
	    }

	    if ( get_option('amalinkspro-options_nofollow_links', true) ) {
	    	$nofollow = 'true';
	    }
	    else {
	    	$nofollow = 'false';
	    }

	    if ( get_option('amalinkspro-options_add_to_cart', true) ) {
	    	$add_to_cart = 'true';
	    }
	    else {
	    	$add_to_cart = 'false';
	    }



	    $locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
		$affiliate_id = trim( get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_0_associate_id' ) );

		if ( $atts['button-text'] != '' ) {
			$button_text = $atts['button-text'];
		}
		else {
			$button_text = 'View on Amazon';
	    	if ( get_option('amalinkspro-options_showcase_btn_default_text') ) {
	    		$button_text = get_option('amalinkspro-options_showcase_btn_default_text');
	    	}
		}
			

	    $a = shortcode_atts( array(
			'asin' => $atts['asin'],
		    'associate-id' => $affiliate_id,
		    'new-window' => $new_window,
		    'addtocart' => $add_to_cart,
		    'nofollow' => $nofollow,
		    'btn-color' => '#ff9900',
		    'alignment' =>  'aligncenter',
		    'hide-reviews' =>  'false',
		    'hide-title' =>  'false',
		    'hide-features' =>  'false',
		    'hide-price' => 'false',
		    'hide-prime' => false,
		    'hide-image' => 'false',
		    'hide-button' =>  'false',
		    'button-text' =>  $button_text,
		    'width' => '750',
		    'product-title' => '',
		), $atts );

		// echo '$a: <pre>'.print_r($a,1).'</pre>';

		if ( $a['new-window'] == 'true' ) {
			$new_window = ' target="_blank"';
		}
		else {
			$new_window = '';
		}

		if ( $a['nofollow'] == 'true' ) {
			$nofollow = ' rel="nofollow"';
		}
		else {
			$nofollow = '';
		}






		if ( $asin ) { 
			ob_start();
			?>

			<?php
    		if ( get_option( 'amalinkspro-options_alp_no_amazon_api' )  ) {
				$alp_noapi = 'alp-no-noapi';
			}

			else {
				$alp_noapi = 'alp-load-api';
			}
			if ( get_option( 'amalinkspro-settings-tools-hideprime' ) != 1 ) {
            	$noprime = ' yesprime';
            } 
            else {
            	$noprime = ' noprime';
            }

    		?>

			

			<div class="amalinkspro-showcase alignnone amalinkspro-showcase-auto <?php echo $alp_noapi.$noprime; ?>" data-alp-img="LargeImage" data-alp-asin="<?php echo $a['asin']; ?>" data-alp-hide-prime="<?php echo $a['hide-prime']; ?>" data-alp-hide-image="<?php echo $a['hide-image']; ?>" data-alp-hide-reviews="<?php echo $a['hide-reviews']; ?>" data-alp-hide-price="<?php echo $a['hide-price']; ?>" data-alp-hide-title="<?php echo $a['hide-title']; ?>" data-alp-hide-features="<?php echo $a['hide-features']; ?>" data-alp-hide-button="<?php echo $a['hide-button']; ?>" style="max-width:<?php echo $a['width']; ?>;">


				<?php if ( $a['hide-image'] != 'true' ) : ?>
					<div class="amalinkspro-showcase-stats-col amalinkspro-showcase-stats-col-img">

						<span class="alp-showcase-img-wrap enabled-img">
							<a class="alp-showcase-img-link" href="https://<?php echo $amazon_store_url; ?>/dp/<?php echo $asin; ?>/?tag=<?php echo $a['associate-id']; ?>"<?php echo $new_window.$nofollow; ?>></a>
						</span>
					
					</div>
				<?php endif; ?>

				<div class="amalinkspro-showcase-stats-col amalinkspro-showcase-stats-col-info">

					<?php if ( $a['hide-title'] != 'true' ) : ?>

						<a class="amalinkspro-showcase-4-titlebox" href="https://<?php echo $amazon_store_url; ?>/dp/<?php echo $asin; ?>/?tag=<?php echo $a['associate-id']; ?>"<?php echo $new_window.$nofollow; ?>><?php echo $a['product-title']; ?></a>

					<?php endif; ?>

					<?php if ( $a['hide-features'] != 'true' ) : ?>
						<div class="showcase-4-features"></div>
					<?php endif; ?>


					<?php if ( $a['hide-reviews'] != 'true' ) : ?>
						<div class="showcase-4-reviews"></div>
					<?php endif; ?>


				</div>

				<div class="amalinkspro-clear"></div>

				<div class="amalinkspro-showcase-bottom-cta" style="border-top: none;">

					<?php if ( $a['hide-price'] != 'true' ) : ?>
						<div class="amalinkspro-showcase-bottom-cta-price"></div>
					<?php endif; ?>

					<?php if ( $a['hide-button'] != 'true' ) : ?>
						<a class="amalinkspro-showcase-bottom-cta-link" href="https://<?php echo $amazon_store_url; ?>/dp/<?php echo $asin; ?>/?tag=<?php echo $a['associate-id']; ?>"<?php echo $new_window.$nofollow; ?>><span class="alp-showcase-amalink-editable"><?php echo $a['button-text']; ?></span></a>
					<?php endif; ?>

					<div class="amalinkspro-clear"></div>
				</div>

				<div class="alp-showcase-loader">
                	<span>
	                	<i class="icon-amalinkspro-spin3 animate-spin"></i>
	                </span>
                </div>

                <?php if (!get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

                	<?php if ( $a['hide-price'] != 'true'  ) : ?>

						<p class="alp-prices-accuracy"><span class="alp-js-apidate-disclaimer icon-amalinkspro-info-block"></span> <?php _e('Prices pulled from the Amazon Product Advertising API on', 'amalinkspro'); ?>: <span class="alp-api-request-date"></span></p>

						<p class="alp-prices-discalimer"><span class="alp-js-close-price-info-popup"></span><?php _e('Product prices and availability are accurate as of the date/time indicated and are subject to change. Any price and availability information displayed on [relevant Amazon Site(s), as applicable] at the time of purchase will apply to the purchase of this product.', 'amalinkspro'); ?></p>

					<?php endif; ?>

				<?php endif; ?>

				<div class="amalinkspro-clear"></div>

			</div>


			<?php

			$amalinkspro_html_output .= ob_get_contents();
			ob_end_clean();

		}

		return $amalinkspro_html_output;

			

	}




	// this gets the amazon api data from the asins in our table rows
	function alp_paapi5_get_asin_groups_data_for_showcase() {

		global $wpdb; // this is how you get access to the database

		// if ( empty( $_POST['asins'] ) ) {
		// 	return 'Error code 1029: No ASINs group';
		// }

	    $asins = $_POST['asins'];
	    $response = alp_paapi5_get_groups_10_asins_data($asins, '');

	    // echo '$response: <pre>'.print_r($response,1).'</pre>';
	    echo json_encode($response);

		die();

	}





	function amalinkspro_head_script_variables() {

		echo '<script>';

			echo 'var amalinkspro_plugin_url = "' . plugins_url() . '";';

		echo '</script>';

	}


	function amalinkspro_head_user_custom_css() {



		if ( get_option('amalinkspro-options_enable_custom_cta_color_showcase') == 1 ) :

			ob_start();

			echo '<style type="text/css" class="amalinkspro-user-css">';


				if ( get_option('amalinkspro-options_choose_button_text_color_showcase') || get_option('body amalinkspro-options_choose_button_text_color_showcase') || get_option('amalinkspro-options_choose_button_border_color_showcase') ) :
				
					echo 'body .amalinkspro-showcase.amalinkspro-showcase-4 .amalinkspro-showcase-bottom-cta-link, .amalinkspro-showcase.amalinkspro-showcase-auto .amalinkspro-showcase-bottom-cta-link{';

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
				
					echo 'body .amalinkspro-showcase.amalinkspro-showcase-4 .amalinkspro-showcase-bottom-cta-link:hover, body .amalinkspro-showcase.amalinkspro-showcase-auto .amalinkspro-showcase-bottom-cta-link:hover{';

						if ( get_option('amalinkspro-options_choose_button_color_hover_showcase') ) :
							echo 'background:'.get_option('amalinkspro-options_choose_button_color_hover_showcase').'!important;';
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
				
					echo 'body .amalinkspro-showcase.amalinkspro-showcase-4 .amalinkspro-showcase-bottom-cta-link, .amalinkspro-showcase.amalinkspro-showcase-auto .amalinkspro-showcase-bottom-cta-link {';

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




	// Performs an API5 Product Search and returns the json #paapi5

	function alp_paapi5_get_products_info_public() {


		global $wpdb; // this is how you get access to the database

		$asin = $_POST['asin'];
	    $asins = array($asin);
		$alp_api5_get_item_result = alp_api5_getItems( $asins );

		echo $alp_api5_get_item_result;

		die();

	}





}
