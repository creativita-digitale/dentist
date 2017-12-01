<?php

//http://stackoverflow.com/questions/25188365/how-to-retrieve-cart-item-data-with-woocommerce

class wiz_session {
	
	public static function init() {
			add_filter( 'woocommerce_add_cart_item_data', array(__CLASS__, 'add_cart_item_custom_item_data'), 10, 3 );
			add_filter( 'woocommerce_get_cart_item_from_session', array( __CLASS__, 'get_cart_items_from_session'), 1, 3 );
			add_filter( 'woocommerce_get_item_data', array( __CLASS__, 'get_item_data'), 1, 3 );
			add_action( 'woocommerce_add_order_item_meta',  array( __CLASS__, 'add_order_item_meta'), 10, 3 );
	}
	
	
	static function add_cart_item_custom_item_data( $cart_item_data, $product_id, $variation_id  ) {
	  	//global $woocommerce;
	  	$wizard = new wizard;
		$data =	$wizard-> get_cookie_data ( ) ;
		
		foreach ( $data as $key => $field ) {
			$cart_item_data[ $key ] =  $field ;
		}
				
				
		  return $cart_item_data; 
	}
	
	

	
	//Get it from the session and add it to the cart variable
	static function get_cart_items_from_session( $session_data, $values, $key ) {
		
		
		
		$session_data[ 'test' ] = print_r($values, true);
			
		
		if ( array_key_exists( 'wizard_fullname', $values ) )
		 $session_data[ 'wizard_fullname' ] = $values['wizard_fullname'];
		 
		 if ( array_key_exists( 'wizard_tel_email', $values ) )
		 $session_data[ 'wizard_tel_email' ] = $values['wizard_tel_email'];
		 
		 if ( array_key_exists( 'wizard_tel', $values ) )
		 $session_data[ 'wizard_tel' ] = $values['wizard_tel'];
		 
		 if ( array_key_exists( 'wizard_email', $values ) )
		 $session_data[ 'wizard_email' ] = $values['wizard_email'];
		 
		 if ( array_key_exists( 'wizard_address', $values ) )
		 $session_data[ 'wizard_address' ] = $values['wizard_address'];
		 
		  if ( array_key_exists( 'wizard_address_2', $values ) )
		 $session_data[ 'wizard_address_2' ] = $values['wizard_address_2'];
		 
		  if ( array_key_exists( 'wizard_city_postcode', $values ) )
		 $session_data[ 'wizard_city_postcode' ] = $values['wizard_city_postcode'];
		 
		 
		  if ( array_key_exists( 'wizard_image_id', $values ) )
		 $session_data[ 'wizard_image_id' ] = $values['wizard_image_id'];
		 
		 
		 if ( array_key_exists( 'wizard_scovolini_quantita_ultra_fine', $values ) )
		 $session_data[ 'wizard_scovolini_quantita_ultra_fine' ] = $values['wizard_scovolini_quantita_ultra_fine'];
		 
		 if ( array_key_exists( 'wizard_scovolini_quantita_fine', $values ) )
		 $session_data[ 'wizard_scovolini_quantita_fine' ] = $values['wizard_scovolini_quantita_fine'];
		 
		 if ( array_key_exists( 'wizard_scovolini_quantita_medium', $values ) )
		 $session_data[ 'wizard_scovolini_quantita_medium' ] = $values['wizard_scovolini_quantita_medium'];
		 
		 if ( array_key_exists( 'wizard_scovolini_quantita_large', $values ) )
		 $session_data[ 'wizard_scovolini_quantita_large' ] = $values['wizard_scovolini_quantita_large'];
		 
		 if ( array_key_exists( 'wizard_scovolini_quantita_extra_large', $values ) )
		 $session_data[ 'wizard_scovolini_quantita_extra_large' ] = $values['wizard_scovolini_quantita_extra_large'];
		 
		 if ( current_user_can('manage_options') ) { 
		 //wp_die(var_dump($session_data));
		 }
    return $session_data;
	}
	
	
	
	//  show the data at the cart/checkout page
	
	static function get_item_data ( $data, $cartItem ) {
		
		
		
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    	$options = get_option( $lang.'_axl_dentist_options' );
	
		$is_spazzolini 	= ( $cartItem['wizard_cat_id'] == $options['tooth_id'] ? true : false);
		$is_kit 			= ( $cartItem['wizard_cat_id'] == $options['kit_id'] ? true : false);
		$is_scovolini 	= ( $cartItem['wizard_cat_id'] == $options['box_id'] ? true : false);
			
			
		$base_dir =  new imagebuilder();
		$dir = $base_dir::IMAGE_DIR;
		$prefix = $base_dir::PREFIX;
		$path = $base_dir->get_image_dir_url ();	
	
			if ($is_spazzolini){
				
				if ( isset( $cartItem['wizard_fullname'] ) ) {
					$data[] = array(
						'name' => __('Name','scdentist'),
						'value' => $cartItem['wizard_fullname']
					);
				}
				if ( isset( $cartItem['wizard_tel_email'] ) ) {
					$data[] = array(
						'name' => __('Telphone or e-mail', 'scdentist'),
						'value' => $cartItem['wizard_tel_email']
					);
				}
			}
			
			if ($is_kit){
				if ( isset( $cartItem['wizard_email'] ) ) {
					$data[] = array(
						'name' => __('Name dental practice', 'scdentist'),
						'value' => $cartItem['wizard_email']
					);
				}
				if ( isset( $cartItem['wizard_fullname'] ) ) {
					$data[] = array(
						'name' => __('Name dental practice', 'scdentist'),
						'value' => $cartItem['wizard_fullname']
					);
				}
			}
			
			
			
			
		 if ($is_kit OR $is_spazzolini ){
			 
			
		
			 if ( isset( $cartItem['wizard_image_id'] ) ) {
					
				$data[] = array(
						'name' => __('Customization', 'scdentist'),
						'value' => "<a class='zoom' data-rel='prettyPhoto' href='" . $path . $dir.  $cartItem['wizard_image_id']. ".jpg' >" . __('Show Image', 'scdentist') . "</a>"
					);			 
			 }
			 
		 }
			
			if ($is_scovolini){
				
				if ( isset( $cartItem['wizard_scovolini_quantita_ultra_fine']) && $cartItem['wizard_scovolini_quantita_ultra_fine'] != 0  ) {
					$data[] = array(
						'name' => __('Quantity Ultra Fine Interdental Brushes','scdentist'),
						'value' => $cartItem['wizard_scovolini_quantita_ultra_fine']
					);
				}
				if ( isset( $cartItem['wizard_scovolini_quantita_fine'] ) && $cartItem['wizard_scovolini_quantita_fine'] != 0) {
					$data[] = array(
						'name' => __('Quantity Fine Interdental Brushes', 'scdentist'),
						'value' => $cartItem['wizard_scovolini_quantita_fine']
					);
				}
				if ( isset( $cartItem['wizard_scovolini_quantita_medium'] ) && $cartItem['wizard_scovolini_quantita_medium'] != 0) {
					$data[] = array(
						'name' => __('Quantity Medium Interdental Brushes', 'scdentist'),
						'value' => $cartItem['wizard_scovolini_quantita_medium']
					);
				}
				if ( isset( $cartItem['wizard_scovolini_quantita_large'] ) && $cartItem['wizard_scovolini_quantita_large'] != 0) {
					$data[] = array(
						'name' => __('Quantity Large Interdental Brushes', 'scdentist'),
						'value' => $cartItem['wizard_scovolini_quantita_large']
					);
				}
				if ( isset( $cartItem['wizard_scovolini_quantita_extra_large'] ) && $cartItem['wizard_scovolini_quantita_extra_large'] != 0) {
					$data[] = array(
						'name' => __('Quantity Extra Large Interdental Brushes', 'scdentist'),
						'value' => $cartItem['wizard_scovolini_quantita_extra_large']
					);
				}
				
				
			}
			
			return $data;
		}
		
		
		
static	function add_order_item_meta ( $itemId, $values, $key ) {
	
		$base_dir =  new imagebuilder();
		$dir = $base_dir::IMAGE_DIR;
		$prefix = $base_dir::PREFIX;
		$path = $base_dir->get_image_dir_url ();	
		
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    	 $options = get_option( $lang.'_axl_dentist_options' );
	
		$is_spazzolini 	= ( $values['wizard_cat_id'] == $options['tooth_id'] ? true : false);
		$is_kit 			= ( $values['wizard_cat_id'] == $options['kit_id'] ? true : false);
		$is_scovolini 	= ( $values['wizard_cat_id'] == $options['box_id'] ? true : false);
		
			
		
		
 
		
		if($is_spazzolini){
			
			if ( isset( $values['wizard_fullname'] ) ) {
			wc_add_order_item_meta( $itemId, 'Fullname', $values['wizard_fullname'] );
			}
			if ( isset( $values['wizard_tel_email'] ) ) {
				wc_add_order_item_meta( $itemId, 'Tel / Email', $values['wizard_tel_email'] );
			}
			if ( isset( $values['wizard_image_id'] ) ) {
				wc_add_order_item_meta( $itemId, 'img', "<a  href='" . $path . $dir.  $values['wizard_image_id']. ".jpg' > <img style='width:100%; padding:5px; border: 1px solid #ccc' src='" . $path . $dir.  $values['wizard_image_id']. ".jpg' /> " .'</a>');
			}
			/* do not remove this field */
			if ( isset( $values['wizard_image_id'] ) ) {
				wc_add_order_item_meta( $itemId, 'Codice immagine: ', $values['wizard_image_id'] );
			}
		
		}
		
		if($is_kit){
			if ( isset( $values['wizard_fullname'] ) ) {
				wc_add_order_item_meta( $itemId, 'Fullname', $values['wizard_fullname'] );
			}
			if ( isset( $values['wizard_email'] ) ) {
				wc_add_order_item_meta( $itemId, 'E-Mail', $values['wizard_email'] );
			}
			if ( isset( $values['wizard_tel'] ) ) {
				wc_add_order_item_meta( $itemId, 'Telephone', $values['wizard_tel'] );
			}
			if ( isset( $values['wizard_address'] ) ) {
				wc_add_order_item_meta( $itemId, 'Address', $values['wizard_address'] );
			}
			if ( isset( $values['wizard_city_postcode'] ) ) {
				wc_add_order_item_meta( $itemId, 'Website', $values['wizard_city_postcode'] );
			}
			if ( isset( $values['wizard_image_id'] ) ) {
				wc_add_order_item_meta( $itemId, 'img', "<a  href='" . $path . $dir.  $values['wizard_image_id']. ".jpg' > <img style='width:100%; padding:5px; border: 1px solid #ccc' src='" . $path . $dir.  $values['wizard_image_id']. ".jpg' /> " .'</a>');
			}
			/* do not remove this field */
			if ( isset( $values['wizard_image_id'] ) ) {
				wc_add_order_item_meta( $itemId, 'Codice immagine: ', $values['wizard_image_id'] );
			}
		
		}
		
		if($is_scovolini){
			
			if ( isset( $values['wizard_scovolini_quantita_ultra_fine'] ) ) {
				wc_add_order_item_meta( $itemId, 'Scovolino Ultra Fine Q.tà', $values['wizard_scovolini_quantita_ultra_fine'] );
			}
			if ( isset( $values['wizard_scovolini_quantita_fine'] ) ) {
				wc_add_order_item_meta( $itemId, 'Scovolino Fine Q.tà', $values['wizard_scovolini_quantita_fine'] );
			}
			if ( isset( $values['wizard_scovolini_quantita_medium'] ) ) {
				wc_add_order_item_meta( $itemId, 'Scovolino Medium Q.tà', $values['wizard_scovolini_quantita_medium'] );
			}
			if ( isset( $values['wizard_scovolini_quantita_large'] ) ) {
				wc_add_order_item_meta( $itemId, 'Scovolino Large Q.tà', $values['wizard_scovolini_quantita_large'] );
			}
			if ( isset( $values['wizard_scovolini_quantita_extra_large'] ) ) {
				wc_add_order_item_meta( $itemId, 'Scovolino Extra Large Q.tà', $values['wizard_scovolini_quantita_extra_large'] );
			}
		
		}
	}

	
	
	


}
wiz_session::init();
