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
class amalinkspro_amazon_api {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */


	public function amazon_api_get_addtocart_endpoint($asin) {

		// https://docs.aws.amazon.com/AWSECommerceService/latest/DG/AddToCartForm.html

		$locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
		$aws_access_key_id = trim( get_option( 'amalinkspro-options_amazon_api_access_key' ) );
		$affiliate_id = trim( get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_0_associate_id' ) );

		// The region you are interested in
		if ( $locale == 'US' ) {
			$endpoint = "webservices.amazon.com";
			$endpoint = 'https://www.amazon.com/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'UK' ) {
			$endpoint = 'https://www.amazon.co.uk/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'BR' ) {
			$endpoint = 'https://www.amazon.com.br/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'CA' ) {
			$endpoint = 'https://www.amazon.ca/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'CN' ) {
			$endpoint = 'https://www.amazon.cn/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'FR' ) {
			$endpoint = 'https://www.amazon.fr/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'DE' ) {
			$endpoint = 'https://www.amazon.de/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'IN' ) {
			$endpoint = 'https://www.amazon.in/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'IT' ) {
			$endpoint = 'https://www.amazon.it/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'JP' ) {
			$endpoint = 'https://www.amazon.co.jp/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'ES' ) {
			$endpoint = 'https://www.amazon.es/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'MX' ) {
			$endpoint = 'https://www.amazon.com.mx/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}
		else if ( $locale == 'AU' ) {
			$endpoint = 'https://www.amazon.com.au/gp/aws/cart/add.html?AWSAccessKeyId='.$aws_access_key_id.'&AssociateTag='.$affiliate_id.'&ASIN='.$asin.'&Quantity=1';
		}

		return $endpoint;

	}



}