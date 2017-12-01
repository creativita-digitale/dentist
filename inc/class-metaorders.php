<?php
//https://gist.github.com/lucasstark/6594983

class Meta_Orders {
 
	public function __construct() {
	
		// Add meta to order - WC 2.x
		//add_action('woocommerce_add_order_item_meta', array($this, 'order_item_meta_2'), 10, 2);
		add_action( 'woocommerce_add_to_cart', array( $this, 'complete_customization' ), 10, 6 );
	}
	
	/**
	 * order_item_meta_2 function.
	 *
	 * @access public
	 * @param mixed $item_id
	 * @param mixed $values
	 * @return void
	 */
	function order_item_meta_2($item_id, $values) {
		if (function_exists('woocommerce_add_order_item_meta')) {
			woocommerce_add_order_item_meta($item_id, 'image', wizard_get_data_value( 'wizard_image_id' ) );
			woocommerce_add_order_item_meta($item_id, 'wizard_data', wizard_get_data_value( 'wizard_post_id' ) );
			
			
		}
	}
	
	function complete_customization( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
			
			global $woocommerce;
		
			$wizard = new wizard();
			
			$data['wizard_custom_end'] = true;
			$data[ 'wizard_post_id' ] = false;
			
			$wizard->set_cookie_data ( $data );
			
			
			
			// Do nothing with the data and return
    		return true;
			
			
		
	}
	
	
	//do_action( 'woocommerce_add_to_cart', $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data );
}
$test = new Meta_Orders();