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
class amalinkspro_google_fonts {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */



	public function get_google_fonts() {

		$google_fonts_api_key = get_option('amalinkspro-options_google_fonts_api_key');
		$url = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key='.$google_fonts_api_key;

		//echo '$url - ' . $url;

		if( ini_get('allow_url_fopen') ) {
			$api_response = @file_get_contents( $url, 0, null, null );
		}

		else {

			$api_response_wp = wp_remote_get($request_url);

			if ( is_wp_error($amazon_request_return) ) {
				$errors_arr = $amazon_request_return->errors;

				foreach( $errors_arr as $error ) {
					$api_response = $error[0];
				}
			}

			else {

				$request_response = $amazon_request_return['response']['code'];

				if ( $request_response == '200' ) {
					$api_response = wp_remote_retrieve_body($api_response_wp);
				}
				else {
					$api_response = 'NOT 200';
				}

			}

		}

		return $api_response;

	
	}


	public function build_google_fonts_select() {


		$google_fonts_json = $this->get_google_fonts();
		$google_fonts_obj = json_decode($google_fonts_json);
		$google_fonts_items_arr = $google_fonts_obj->items;
		$select_input = '';

		if ( $google_fonts_items_arr ) {

			$select_input .= '<select class="alp-control-font-family-google">';
			$select_input .= '<option></option>';

			$i=0;
		
			foreach ( $google_fonts_items_arr as $item ) {

				if ( $i == 100 ) continue;

				$select_input .= '<option value="'.$item->family.'">'.$item->family.'</option>';
				$i++;
			}

			$select_input .= '</select>';

		}



		return $select_input;

	}


	public function build_google_fonts_css_link() {
		$google_fonts_json = $this->get_google_fonts();
			
		if ( $google_fonts_json ) {

			$google_fonts_obj = json_decode($google_fonts_json);
			$google_fonts_items_arr = $google_fonts_obj->items;
			$google_fonts_css_call = 'https://fonts.googleapis.com/css';
			if ( $google_fonts_items_arr ) {
				$i=0;
				foreach ( $google_fonts_items_arr as $item ) {
					if ( $i == 100 ) continue;
					if ( $i == 0 ) { $connector = '?family='; }
					else { $connector = '|'; }
					$font_url_string = $connector . str_replace(' ', '+', $item->family);
					$google_fonts_css_call .= $font_url_string;
					$i++;
				}
				return $google_fonts_css_call;
			}
			else {
				return;
			}
		}
		else {
			return;
		}
		
	}

	



}