<?php

/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 *
 * @return string
 */
 
function wc_empty_cart_redirect_url() {
	$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    $options = get_option( $lang.'_axl_dentist_options' );
	$cutomizer_id = $options['cutomizer_id'];
	
	return get_permalink(  $cutomizer_id );
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );


function modal_scovolini(){
?>

<div id="modal-generico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title" id="gridSystemModalLabel"></h4>
      </div>
      <div class="modal-body">
        
        
      
      </div>
      <div class="modal-footer">
        <button  id="edit" type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Edit quantity', 'scdentist'); ?></button> 
        <button  id="submit" type="button" class="btn btn-primary"><?php _e('Proceed', 'scdentist'); //Procedi ?></button> 
      </div>
    </div>
  </div>
</div>


<?php
}

add_action('storefront_after_footer', 'modal_scovolini' );

if ( ! function_exists ( 'wiz_set_placeholder' ) ){
	
	function wiz_set_placeholder( $field ){	
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    	$options = get_option( $lang.'_axl_dentist_options' );
	
		$wizard = new wizard;	
		$current_cookie_data = $wizard->get_cookie_data ();		
		$user_meta 	= get_user_meta ( get_current_user_id() , $field , true );	
		( is_user_logged_in() ? ( $user_meta ? $updated_field = $user_meta : $updated_field = $current_cookie_data[ $field ] ) :  $updated_field = $current_cookie_data[ $field ] ) ;			
		if ( ! $updated_field ) $updated_field = '';
		return $updated_field;
	}
}


function utf8_urldecode ($str) {
    $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    return html_entity_decode($str,null,'UTF-8');;
  }
  
function current_wizard_data_array() {
	$reading = new wizard();
	$cookie =  $reading->get_cookie_data();
	return $cookie;
}
function wizard_get_data_value( $value ) {
	$cookie = current_wizard_data_array();
	return $cookie[ $value ];
}


function current_wizard_cat(  ) {
	$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    $options = get_option( $lang.'_axl_dentist_options' );
	
	$cookie =  current_wizard_data_array();
	$mycat = $cookie[ 'wizard_cat_id' ];
	// da correggere velocemente
	if ($mycat == 0) { 
		$mycat = $options['tooth_id'];
	}
	return $mycat;
}


		

function wizard_wc_cat_id ($product_id = 0 ) {
	
	
	if ( $product_id  ){
		
		$product_cats = wc_get_product_terms( $product_id, 'product_cat', array('fields' => 'ids') );
		
		
		
		if ( $product_cats && ! is_wp_error ( $product_cats ) ){


		
       	 $single_cat = array_shift( $product_cats ); 

		
			return  $single_cat ;
		
		
		}
		
	}else{
		return current_wizard_cat();
	}
	
}



function wizard_wc_cat_name () {
	$mycat = current_wizard_cat();
	$my_category = get_term_by( 'id', $mycat, 'product_cat' );
	return $my_category->name;
}

function wizard_wc_cat_slug () {
	$mycat = current_wizard_cat();
	$my_category = get_term_by( 'id', $mycat, 'product_cat' );
	return $my_category->slug;
}

function wizard_wc_cat_link ($product) {
	return get_term_link( $product, 'product_cat' );
}


function add_specific_menu_atts( $atts, $item, $args ) {
	$menu_items = array(82);
	if (in_array($item->ID, $menu_items)) {
	  $atts['href'] = wizard_wc_cat_link(wizard_wc_cat_name());
	}
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_specific_menu_atts', 10, 3 );

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class($classes, $item){
	
	$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    $options = get_option( $lang.'_axl_dentist_options' );
	
	
	$menu_items = array(82);
	$current_wizard_cat = current_wizard_cat();
	$registered_spazzolini_cat_id = $options['tooth_id'];
	$registered_kit_cat_id = $options['kit_id'];
	
     if ( in_array( $item->ID, $menu_items ) ) {
		 global $wp_query;
		 $current_cat = $wp_query->get_queried_object_id();
		 if (  $current_wizard_cat == $current_cat ){
             $classes[] = 'current-menu-item ' . 'current ' . $current_wizard_cat . ' | stored ' . $current_cat    ;
	 	}
	 }
     return $classes;
}
function array_map_assoc( $callback , $array ){
  $r = array();
  foreach ($array as $key=>$value)
    $r[$key] = $callback($key,$value);
  return $r;
}
function combine_arr($a, $b)
{
    $acount = count($a);
    $bcount = count($b);
    $size = ($acount > $bcount) ? $bcount : $acount;
    $a = array_slice($a, 0, $size);
    $b = array_slice($b, 0, $size);
    return array_combine($a, $b);
} 

/** Forms ****************************************************************/

/**
	 * Outputs a checkout/address form field.
	 *
	 * @subpackage	Forms
	 * @param string $key
	 * @param mixed $args
	 * @param string $value (default: null)
	 * @todo This function needs to be broken up in smaller pieces
	 */
	function woocommerce_form_field( $key, $args, $value = null ) {
		$defaults = array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'placeholder'       => '',
			'maxlength'         => false,
			'required'          => false,
			'id'                => $key,
			'class'             => array(),
			'label_class'       => array(),
			'input_class'       => array(),
			'return'            => false,
			'options'           => array(),
			'image_options'     => array(),
			'custom_attributes' => array(),
			'validate'          => array(),
			'default'           => '',
		);

		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr>';
		} else {
			$required = '';
		}

		$args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';

		if ( is_string( $args['label_class'] ) ) {
			$args['label_class'] = array( $args['label_class'] );
		}

		if ( is_null( $value ) ) {
			$value = $args['default'];
		}

		// Custom attribute handling
		$custom_attributes = array();

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		if ( ! empty( $args['validate'] ) ) {
			foreach( $args['validate'] as $validate ) {
				$args['class'][] = 'validate-' . $validate;
			}
		}

		$field = '';
		$label_id = $args['id'];
		$field_container = '<p class="form-row %1$s" id="%2$s">%3$s</p>';

		switch ( $args['type'] ) {
			case 'country' :

				$countries = $key == 'shipping_country' ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

				if ( sizeof( $countries ) == 1 ) {

					$field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

					$field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys($countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" />';

				} else {

					$field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . '>'
							. '<option value="">'.__( 'Select a country&hellip;', 'woocommerce' ) .'</option>';

					foreach ( $countries as $ckey => $cvalue ) {
						$field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';
					}

					$field .= '</select>';

					$field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';

				}

				break;
			case 'state' :

				/* Get Country */
				$country_key = $key == 'billing_state'? 'billing_country' : 'shipping_country';
				$current_cc  = WC()->checkout->get_value( $country_key );
				$states      = WC()->countries->get_states( $current_cc );

				if ( is_array( $states ) && empty( $states ) ) {

					$field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

					$field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key )  . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" />';

				} elseif ( is_array( $states ) ) {

					$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '">
						<option value="">'.__( 'Select a state&hellip;', 'woocommerce' ) .'</option>';

					foreach ( $states as $ckey => $cvalue ) {
						$field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';
					}

					$field .= '</select>';

				} else {

					$field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				}

				break;
			case 'textarea' :

				$field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>'. esc_textarea( $value  ) .'</textarea>';

				break;
			case 'checkbox' :

				$field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) .'" ' . implode( ' ', $custom_attributes ) . '>
						<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" '.checked( $value, 1, false ) .' /> '
						 . $args['label'] . $required . '</label>';

				break;
			case 'password' :

				$field .= '<input type="password" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'text' :

				$field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'email' :

				$field .= '<input type="email" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'tel' :

				$field .= '<input type="tel" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'select' :

				$options = $field = '';

				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						if ( "" === $option_key ) {
							// If we have a blank option, select2 needs a placeholder
							if ( empty( $args['placeholder'] ) ) {
								$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
							}
							$custom_attributes[] = 'data-allow_clear="true"';
						}
						$options .= '<option value="' . esc_attr( $option_key ) . '" '. selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) .'</option>';
					}

					$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select '.esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '">
							' . $options . '
						</select>';
				}

				break;
				
			case 'visual-select' :

				$options = $field = '';

				if ( ! empty( $args['options'] ) ) {
					$i = 0;
					foreach ( $args['options'] as $option_key => $option_text ) {
						if ( "" === $option_key ) {
							// If we have a blank option, select2 needs a placeholder
							if ( empty( $args['placeholder'] ) ) {
								$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
							}
							$custom_attributes[] = 'data-allow_clear="true"';
						}
						
						$options .= '<option data-img-src="' . $args['image_options'][$i] .'" value="' . esc_attr( $option_key ) . '" '. selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) .'</option>';
						
						$i++;
					}
					
					$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select '.esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '">
							' . $options . '
						</select>';
				}

				break;
				
					
			case 'radio' :

				$label_id = current( array_keys( $args['options'] ) );

				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						$field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
						$field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) .'">' . $option_text . '</label>';
					}
				}

				break;
		}

		if ( ! empty( $field ) ) {
			$field_html = '';

			if ( $args['label'] && 'checkbox' != $args['type'] ) {
				$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) .'">' . $args['label'] . $required . '</label>';
			}

			$field_html .= $field;

			if ( $args['description'] ) {
				$field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>';
			}

			$container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
			$container_id = esc_attr( $args['id'] ) . '_field';

			$after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';

			$field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
		}

		$field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

		if ( $args['return'] ) {
			return $field;
		} else {
			echo $field;
		}
	}
	
	add_action ('pre_product_editor', 'wizard_product_slider');
	function wizard_product_slider(){
	?>	
   
	<div id="mi-slider" class="mi-slider">
		
		<?php	
		
		
		$terms = get_terms(  array( 'taxonomy' => 'product_cat', 'order'  => 'DESC') );
			 
		foreach ( $terms as $term ) {
				$termsID[] = $term->term_id;
		}
			 
		$i = 0;
		
		
		
		foreach ( $terms as $term ) { 
			  
					$query_args = array (
					
						'post_type' => 'product',
						'orderby' => 'menu_order',
						'suppress_filters' => false,
						'order' => 'ASC',
						'tax_query' 		 => array(
												array(
													'taxonomy' 	=> 'product_cat',
													'field' 	=> 'term_id',
													'terms' 	=> $termsID[ $i]
													)
											)
						);
					
					$products = new WP_Query( $query_args );
					echo' <ul>';
					if( $products->have_posts() ):
					
					 while ( $products->have_posts() ) : $products->the_post(); ?>
					 
					 
							<li>
							<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
							
							<label for = "product-<?php   the_ID(); ?>" ><input type="radio" class="aselector" id="product-<?php   the_ID(); ?>" name="group-1" value="<?php   the_ID(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'data-img-src' => $large_image_url[0])); ?>
								<h4><?php the_title(); ?></h4>
								<?php 
								global $product;
								$framework = TitanFramework::getInstance( 'Silvercaredentist' );
								?>
								<div class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
								
                                <?php $price_discount = $framework->getOption( 'price_discount' , get_the_ID() ); ?>
								 <del>€ <?php echo $framework->getOption( 'price_display' , get_the_ID() ); ?></del> 
									<?php 	if( $price_discount != '' ) { ?><strong>€ <?php echo $framework->getOption( 'price_discount' , get_the_ID() ); ?></strong> <?php } ?>
								
								</div>
							
                            </label>
							</li>
					
					<?php endwhile; // end of the loop. 
					
					else:
					 echo '<li>' . __('No products to show', 'scdentist') . '</li>';
					endif;
					echo '</ul>';
					?>
			 <?php $i++;
			}
		
			wp_reset_query();
			wp_reset_postdata();
		?>
		
		<?php  
		 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			 echo '<nav id="prod-cats">';
			 foreach ( $terms as $term ) {
			   echo '<a>' . $term->name . '</a>';
				
			 }
			 echo '</nav>';
		 } 
 		
		echo '</div>';
		
	}