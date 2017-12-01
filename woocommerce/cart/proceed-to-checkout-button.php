<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

	
$lang =ICL_LANGUAGE_CODE;
$options = get_option( $lang.'_axl_dentist_options' );

switch ($options['min_price']){

	case '':
	$minimum = $options['min_price_d'];
	break;
	
	default:
	$minimum = $options['min_price'];
	
}
   
