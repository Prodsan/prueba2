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
class amalinkspro_modal_content {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */




	public function alp_get_chosen_prod_prev() {
	?>

		<div class="amalinkspro-chosen-product">

    		<h2><a class="amalinkspro-chosen-item-previewlink" href="" target="_blank"><i class="icon-amalinkspro-link"></i> view on Amazon</a>Your Chosen Item</h2>

    		<p class="amalinkspro-chosen-product-ranking"><strong><?php _e('Best Sellers Rank', 'amalinkspro'); ?>:</strong> <span class="ranking-span"><img class="amalinkspro-license-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" /></span></p>

    		<h3></h3>

    		<img class="amalinkspro-chosen-product-main-img" src="" alt="" />

			<p class="amalinkspro-chosen-product-bestoffer"><strong><?php _e('Best Offer', 'amalinkspro'); ?>:</strong> <span class="best-offer-span"><img class="amalinkspro-license-loading-gif" src="/wp-admin/images/loading.gif" alt="loading" /></span></p>



			

			<div class="showcase-4-features"></div>
				
			<div class="amalinkspro-clear"></div>

		</div>

	<?php
	}





	public function alp_get_link_type_btns() {
	?>

		<h2 class="amalinkspro-choose-link-type-heading"><?php _e('Choose Link Type', 'amalinkspro'); ?></h2>
		<a href="#" class="js-amalinkspro-choose-link-type" data-link-type="text-link"><i class="icon-amalinkspro-text-link"></i> <?php _e('Text Link', 'amalinkspro'); ?></a>
		<a href="#" class="js-amalinkspro-choose-link-type" data-link-type="image-link"><i class="icon-amalinkspro-image-link"></i> <?php _e('Image Link', 'amalinkspro'); ?></a>
		<a href="#" class="js-amalinkspro-choose-link-type" data-link-type="cta-link"><i class="icon-amalinkspro-cta-link"></i> <?php _e('CTA Link', 'amalinkspro'); ?></a>
		<a href="#" id="showcase-id" class="js-amalinkspro-choose-link-type" data-link-type="showcase" data-showcase-id="1"><i class="icon-amalinkspro-info-block"></i> <?php _e('Showcase', 'amalinkspro'); ?></a>

	<?php
	}




	public function alp_get_text_link_preview() {
	?>

		<div class="amalinkspro-linktype-preview amalinkspro-linktype-preview-text-link"
			data-amalinkspro-linktype="text-link" 
			data-amalinkspro-linktext="" 
			data-amalinkspro-asin="">

			<h3><?php _e('Final Text Link Preview', 'amalinkspro'); ?> <i class="js-amalinkspro-edit-link amalinkspro-edit-link icon-amalinkspro-edit" title="Edit Text Link"></i></h3>

			<p class="amalinkspro-text-link-preview-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  <a href="#" target="_blank"></a> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>

			<div class="amalinkspro-linktype-preview-edit amalinkspro-linktype-preview-text-link-edit">

    			<h3><?php _e('Edit your Link Text', 'amalinkspro'); ?></h3>

    			<div class="amalinkspro-clear"></div>

    			<input type="text" name="amalinkspro-edit-textlink-text" value="" />

    		</div>

		</div>


	<?php
	}







	public function alp_get_img_link_preview() {
	?>

	<div class="amalinkspro-linktype-preview amalinkspro-linktype-preview-image-link"
		data-amalinkspro-linktype="image-link" 
		data-amalinkspro-linkimage="" 
		data-amalinkspro-linktext="" 
		data-amalinkspro-asin="">

		<h3><?php _e('Final Image Link Preview', 'amalinkspro'); ?> <i class="js-amalinkspro-edit-link amalinkspro-edit-link icon-amalinkspro-edit" title="Edit Image Link"></i></h3>

		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

		<a class="amalinkspro-image-link-link" href="#" target="_blank">
			<img class="amalinkspro-image-link-img alignleft" src="" alt="" />
		</a>

		<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

		<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>

		<div class="amalinkspro-clear"></div>

		<div class="amalinkspro-linktype-preview-edit amalinkspro-linktype-preview-image-link-edit">

			<h3><?php _e('These are the available images on Amazon for this item', 'amalinkspro'); ?></h3>
			
			<div class="amalinkspro-clear"></div>

			<div class="amalinkspro-linktype-preview-image-link-edit-imagechoices">
				
			</div>

			<div class="amalinkspro-clear"></div>

		</div>


	</div>


	<?php
	}




	public function alp_get_cta_btn_preview() {
	?>


	<div class="amalinkspro-linktype-preview amalinkspro-linktype-preview-cta-link"	
		data-amalinkspro-linktype="cta-btn-css" 
		data-amalinkspro-ctatext="" 
		data-amalinkspro-ctaimage=""
		data-amalinkspro-asin="">

		<h3><?php _e('Final CTA Link Preview', 'amalinkspro'); ?> <i class="js-amalinkspro-edit-link amalinkspro-edit-link icon-amalinkspro-edit" title="Edit CTA Button"></i></h3>

		<div class="amalinkspro-cta-link-preview-p">

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			
			<div class="amalinkspro-cta-wrap-preview amalinkspro-cta-wrap amalinkspro-cta-button-plain-small amalinkspro-green">
				<?php
            	if ( get_option('amalinkspro-options_cta_btn_default_text') ) {
            		$btn_text = get_option('amalinkspro-options_cta_btn_default_text');
            	}
            	else {
            		$btn_text = 'Buy on Amazon';
            	}
            	?>
				<a class="amalinkspro-css-button-initial" href="#" target="_blank" data-ctabtn-id=""><?php echo $btn_text; ?></a> 
			</div>

			<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

		</div>

		<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

			<div class="alp-ctabutton-noapi-link-wrap note alp-note alp-note-red" style="margin-top: 30px;"><span style="display: block;margin: 0 0 10px 0;"><strong>Enter your Amazon Affiliate Product Link Here.</strong></span>
				<input id="alp-ctabutton-noapi-link" type="text" value="" placeholder="Enter your Amazon Affiliate Link Here" />
				<span style="display: block;margin: 10px 0 0 0;font-size: 12px;">We recommend using your SiteStripe "Text Link". <a href="https://amalinkspro.com/no-api/" target="_blank">Click here</a> for instructions on how to use AmaLinks Pro without an API connection.</span>
			</div>

		<?php endif; ?>

		<div class="amalinkspro-linktype-preview-edit amalinkspro-linktype-preview-cta-link-edit">


			<div class="amalinkspro-linktype-preview-edit-left" data-mh="ctabtn-cols">
				<h3><?php _e('Choose your Button Type', 'amalinkspro'); ?></h3>
				<div class="amalinkspro-clear"></div>

				<select id="amalinkspro-select-cta-btn-type" class="amalinkspro-select-cta-btn-type">
					<option value="ctabtn-ama-img"><?php _e('Amazon Compliant Image Button', 'amalinkspro'); ?></option>
					<option value="ctabtn-custom" selected="selected"><?php _e('Custom Call to Action Button', 'amalinkspro'); ?></option>
				</select>

				<p class="amalinkspro-chose-custom-cta"><?php _e('Choose one of your current buttons, or click the red button to create or edit a button.', 'amalinkspro'); ?></p>

				<p class="amalinkspro-chose-img-cta"><?php _e('Choose one of of the Amazon Associate Approved Graphic Buttons.', 'amalinkspro'); ?></p>

			</div>

			<div class="amalinkspro-linktype-preview-edit-right" data-mh="ctabtn-cols">

				<h3 class="amalinkspro-edit-ctalink-text-title"><?php _e('Edit Your CTA Button Text', 'amalinkspro'); ?></h3>
				<div class="amalinkspro-clear"></div>

				
				<input type="text" name="amalinkspro-edit-ctalink-text" value="<?php echo $btn_text; ?>" />

				<a id="amalinkspro-open-cta-editor" class="button button-primary" href="#"><?php _e('Create a New CTA Button', 'amalinkspro'); ?></a>

				<div id="amalinkspro_load_premade_cta_buttons"></div>

				<div id="amalinkspro-choose-cta-btn" class="amalinkspro-choose-cta-btn alp-ama-img-buttons">

					<?php 
					echo '<div class="alp-button-id" data-btn-id="ama-1">';
				     	echo '<span class="amalinkspro-js-choose-btn img-btn amalinkspro-choose-btn">Select</span>';
				     	echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/cta-buttons/ama-1.gif" alt="" />';
				    echo '</div>';

				    echo '<div class="alp-button-id" data-btn-id="ama-2">';
				     	echo '<span class="amalinkspro-js-choose-btn img-btn amalinkspro-choose-btn">Select</span>';
				     	echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/cta-buttons/ama-2.gif" alt="" />';
				    echo '</div>';

				    echo '<div class="alp-button-id" data-btn-id="ama-3">';
				     	echo '<span class="amalinkspro-js-choose-btn img-btn amalinkspro-choose-btn">Select</span>';
				     	echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/cta-buttons/ama-3.gif" alt="" />';
				    echo '</div>';

				    echo '<div class="alp-button-id" data-btn-id="ama-4">';
				     	echo '<span class="amalinkspro-js-choose-btn img-btn amalinkspro-choose-btn">Select</span>';
				     	echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/cta-buttons/ama-4.gif" alt="" />';
				    echo '</div>';

				    echo '<div class="alp-button-id" data-btn-id="ama-5">';
				     	echo '<span class="amalinkspro-js-choose-btn img-btn amalinkspro-choose-btn">Select</span>';
				     	echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/cta-buttons/ama-5.gif" alt="" />';
				    echo '</div>';

				    echo '<div class="alp-button-id" data-btn-id="ama-6">';
				     	echo '<span class="amalinkspro-js-choose-btn img-btn amalinkspro-choose-btn">Select</span>';
				     	echo '<img src="' . plugin_dir_url( 'amalinkspro.php' ) . 'amalinkspro/includes/images/cta-buttons/ama-6.gif" alt="" />';
				    echo '</div>';
				    ?>


				</div>


			</div>

			<div class="clear"></div>

		</div>


	</div>







	<?php
	}




	public function alp_get_showcase_previewbox() {
	?>

		<?php
    	if ( get_option('amalinkspro-options_showcase_btn_default_text') ) {
    		$btn_text = get_option('amalinkspro-options_showcase_btn_default_text');
    	}
    	else {
    		$btn_text = 'Buy on Amazon...';
    	}
    	?>

		<div class="amalinkspro-linktype-preview amalinkspro-linktype-preview-showcase" data-amalinkspro-linktype="showcase" data-alp-showcase-id="4" data-amalinkspro-asin="" data-amalinkspro-specs="" data-amalinkspro-images="LargeImage" data-amalinkspro-linktext="" data-amalinkspro-linktext-button="<?php echo $btn_text; ?>" data-alp-hide-prime="0" data-alp-hide-image="0" data-alp-hide-reviews="0" data-alp-hide-price="0" data-alp-hide-button="0" data-alp-width="750">

			<!-- <h3>Final Showcase Preview <i class="js-amalinkspro-edit-link amalinkspro-edit-link icon-amalinkspro-edit edit-box-open"></i></h3> -->

			<h3><?php _e('Final Showcase Preview', 'amalinkspro'); ?></h3>

			<?php 
    		if ( get_option('amalinkspro-settings-tools-hide_stars', true) ) {
    			$data_alp_hide_stars = 'hide';
    		}
    		else {
    			$data_alp_hide_stars = 'show';
    		}
    		?>

    		<p class="lorem-ipsum">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 
			<p class="lorem-ipsum">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<!-- 

			<select id="alp-showcase-chooser">
				<option value="showcase-4">Original Product Showcase</option>
				<option value="showcase-nonapi">Manual Content Showcase</option>
			</select> -->

			<?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>
				<div class="non-api-showcase-buttons">
	        		<a class="js-reset-nonapi-showcase" href="#">Reset Showcase</a>
	        	</div>
			<?php endif; ?>


			<?php
			if ( get_option('amalinkspro-options_enable_custom_cta_color_showcase') == 1 ) :

				ob_start();

				echo '<style type="text/css" class="amalinkspro-user-css">';


					if ( get_option('amalinkspro-options_choose_button_text_color_showcase') || get_option('body amalinkspro-options_choose_button_text_color_showcase') || get_option('amalinkspro-options_choose_button_border_color_showcase') ) :
					
						echo 'body .amalinkspro-showcase.amalinkspro-showcase-4 .amalinkspro-showcase-bottom-cta-link, .amalinkspro-showcase.amalinkspro-showcase-auto .amalinkspro-showcase-bottom-cta-link{';

							if ( get_option('amalinkspro-options_choose_button_color_showcase') ) :
								echo 'background:'.get_option('amalinkspro-options_choose_button_color_showcase').' !important;';
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
			?>



            <div class="amalinkspro-showcase amalinkspro-showcase-preview amalinkspro-showcase-4 amalinkspro-showcase-4-preview aligncenter">


                <div class="amalinkspro-showcase-stats-col amalinkspro-showcase-stats-col-img">
                	
                    <span class="alp-showcase-img-wrap enabled-img">
			    		<i class="icon-amalinkspro-edit js-edit-showcase-image" data-api-img=""></i>
						<a href="#"><img class="amalinkspro-chosen-product-main-img" src="" alt="" data-api-img="" /></a>
					</span>
                </div>

                <div class="amalinkspro-showcase-stats-col amalinkspro-showcase-stats-col-info">
                    <a class="amalinkspro-showcase-4-titlebox"><span class="alp-showcase-title alp-showcase-spec-val-editable-textarea"></span></a>
                    <div class="showcase-4-features"></div>
                    <div class="showcase-4-reviews"></div>
                </div>

                <div class="amalinkspro-clear"></div>

                <div class="amalinkspro-showcase-bottom-cta">

                	<div class="amalinkspro-showcase-bottom-cta-price"><span></span></div>

                	<?php
                	if ( get_option('amalinkspro-options_showcase_btn_default_text') ) {
                		$btn_text = get_option('amalinkspro-options_showcase_btn_default_text');
                	}
                	else {
                		$btn_text = 'Buy on Amazon';
                	}
                	?>

                	<a class="amalinkspro-showcase-bottom-cta-link"><i class="icon-amalinkspro-link-icon"></i> <span class="alp-showcase-amalink-editable"><?php echo $btn_text; ?></span></a>

                	<div class="amalinkspro-clear"></div>
                </div>

                <div class="alp-showcase-loader">
                	<span class="alp-spinner"></span>
                </div>

                <?php if ( !get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

					<p class="alp-prices-accuracy"><span class="alp-js-apidate-disclaimer icon-amalinkspro-info-block"></span> <?php _e('Prices pulled from the Amazon Product Advertising API on', 'amalinkspro'); ?>: <span class="alp-api-request-date"></span></p>

					<p class="alp-prices-discalimer"><span class="alp-js-close-price-info-popup"></span><?php _e('Product prices and availability are accurate as of the date/time indicated and are subject to change. Any price and availability information displayed on [relevant Amazon Site(s), as applicable] at the time of purchase will apply to the purchase of this product.', 'amalinkspro'); ?></p>

				<?php endif; ?>

            </div>

            <?php if ( get_option( 'amalinkspro-options_alp_no_amazon_api' ) ) : ?>

				<p class="alp-showcase-noapi-link-wrap note alp-note alp-note-red" style="margin-top: 30px;"><span style="display: block;margin: 0 0 10px 0;"><strong>Enter your Amazon Affiliate Product Link Here.</strong></span>
					<input id="alp-showcase-noapi-link" type="text" value="" placeholder="Enter your Amazon Affiliate Link Here" />
					<span style="display: block;margin: 10px 0 0 0;font-size: 12px;">We recommend using your SiteStripe "Text Link". <a href="https://amalinkspro.com/no-api/" target="_blank">Click here</a> for instructions on how to use AmaLinks Pro without an API connection.</span>
				</p>

			<?php endif; ?>

            <p class="lorem-ipsum">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 
			<p class="lorem-ipsum">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>



		</div>


	<?php
	}



}