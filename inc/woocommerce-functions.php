<?php

if ( class_exists( 'WooCommerce' ) ) {
	
	remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
	
	//woocommerce/templates/cart/cart-totals.php
	add_action( 'woocommerce_proceed_to_checkout', 'dentist_button_proceed_to_checkout', 20 );
	//woocommerce/includes/class-wc-countries.php
	add_filter( 'woocommerce_default_address_fields' , 'custom_override_checkout_fields' , 90);	
	
	//woocommerce/templates/cart/cart-empty.php
	add_filter( 'woocommerce_return_to_shop_redirect', 'return_true_shop_url' ); 
	
	add_filter( 'woocommerce_get_image_size_shop_single', 'wptt_single_image_size' );
	
	add_action( 'woocommerce_after_add_to_cart_button', 'inserisci_frase' );
	
	
  	/**
	 * override the postcode label, based on a request
	 *
	 */
	function custom_override_checkout_fields( $fields ) {
		$fields['postcode']['label'] = __('C.a.p.', 'scdentist');
		return $fields; 
	}
	
	
	/**
	 * change the shop url redirecting users to the customizer url
	 *
	 *  this function uses wpml to work, otherwise it assign a it value to the var prefix
	 */
	function return_true_shop_url() {
		
		// Verifica che il plugin wpml sia attivo
		
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';

		$options         = get_option( $lang.'_axl_dentist_options' );
		$cutomizer_id     = $options[ 'cutomizer_id' ];
		return  get_permalink( $cutomizer_id ); 

	}
	
	/**
	 *  this function check if the cart subtotal is equal or higher to the minumum setted in backend
	 *
	 */
	function dentist_button_proceed_to_checkout(){

		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
		$options = get_option( $lang.'_axl_dentist_options' );
		$actual = WC()->cart->subtotal_ex_tax;
		$minimum = $options['min_price_d'];

		if($actual >= $minimum){

			?>
			<a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button button alt wc-forward">
	<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
</a>
		
			<?php
		}

	}
	
	function wptt_single_image_size( $size ){
 
		$size['width'] = '600';
		$size['height'] = '600';

		return $size;
 
	} // wptt_single_image_size

	function inserisci_frase (){
	
		global $product;
		$id = $product->id;;
		//echo $id;
		$framework = TitanFramework::getInstance( 'Silvercaredentist' );
		echo '<span class="pocket-q"> ' . $framework->getOption( 'product_q' , $id ) . '</span>';

	}

	
}