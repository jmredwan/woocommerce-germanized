<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Adds Germanized Shortcodes
 *
 * @class 		WC_GZD_Shortcodes
 * @version		1.0.0
 * @author 		Vendidero
 */
class WC_GZD_Shortcodes {
	
	/**
	 * Initializes Shortcodes
	 */
	public static function init() {
		
		// Define shortcodes
		$shortcodes = array(
			'revocation_form'            => __CLASS__ . '::revocation_form',
			'payment_methods_info'		 => __CLASS__ . '::payment_methods_info',
			'ekomi_badge'				 => __CLASS__ . '::ekomi_badge',
			'ekomi_widget'				 => __CLASS__ . '::ekomi_widget',
			'gzd_feature'				 => __CLASS__ . '::gzd_feature',
			'gzd_vat_info'				 => __CLASS__ . '::gzd_vat_info',
			'gzd_sale_info'				 => __CLASS__ . '::gzd_sale_info',
			'gzd_complaints'			 => __CLASS__ . '::gzd_complaints',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}

	}

	public static function gzd_complaints( $atts ) {
		return wpautop( str_replace( 'http://ec.europa.eu/consumers/odr/', '<a href="http://ec.europa.eu/consumers/odr/" target="_blank">http://ec.europa.eu/consumers/odr/</a>', get_option( 'woocommerce_gzd_complaints_procedure_text' ) ) );
	}

	/**
	 * Returns revocation_form template html
	 *  
	 * @param  array $atts 
	 * @return string revocation form html       
	 */
	public static function revocation_form( $atts ) {
		
		ob_start();
		wc_get_template( 'forms/revocation-form.php' );
		$return = '<div class="woocommerce woocommerce-gzd">' . ob_get_clean() . '</div>';
		return $return;
	
	}

	/**
	 * Returns payment methods info html
	 *  
	 * @param  array $atts
	 * @return string
	 */
	public static function payment_methods_info( $atts ) {
		
		WC_GZD_Payment_Gateways::instance()->manipulate_gateways();

		ob_start();
		wc_get_template( 'global/payment-methods.php' );
		$return = '<div class="woocommerce woocommerce-gzd">' . ob_get_clean() . '</div>';
		return $return;
	
	}

	/**
	 * Returns eKomi Badge html
	 *  
	 * @param  array $atts 
	 * @return string     
	 */
	public static function ekomi_badge( $atts ) {

		return WC_germanized()->ekomi->get_badge( $atts );
	
	}

	/**
	 * Returns eKomi Widget html
	 *  
	 * @param  array $atts 
	 * @return string       
	 */
	public static function ekomi_widget( $atts ) {

		return WC_germanized()->ekomi->get_widget( $atts );
	
	}

	/**
	 * Returns header feature shortcode
	 *  
	 * @param  array $atts    
	 * @param  string $content 
	 * @return string          
	 */
	public static function gzd_feature( $atts, $content = '' ) {

		extract( shortcode_atts( array('icon' => ''), $atts ) );
		return ( !empty( $icon ) ? '<i class="fa fa-' . $icon . '"></i> ' : '' ) . $content;
	
	}

	/**
	 * Returns VAT info
	 *  
	 * @param  array $atts    
	 * @param  string $content 
	 * @return string          
	 */
	public static function gzd_vat_info( $atts, $content = '' ) {

		ob_start();
		wc_get_template( 'footer/vat-info.php' );
		return ob_get_clean();
	
	}

	/**
	 * Returns Sale info
	 *  
	 * @param  array $atts    
	 * @param  string $content 
	 * @return string          
	 */
	public static function gzd_sale_info( $atts, $content = '' ) {

		ob_start();
		wc_get_template( 'footer/sale-info.php' );
		return ob_get_clean();
	
	}

}