<?php 
	
	$selection = wc_clean( intval ( $_REQUEST['selection'] ) );
         //wp_die($selection);
	$selection_cat = wizard_wc_cat_id ( trim($selection," ") );
	
	$wizard = new wizard;
	$data = $wizard->	get_cookie_data ();	
	$product_id = $selection;
	
        $lang = $_COOKIE['_icl_current_language'];
        
        //wp_die('template-form ' . $_COOKIE['_icl_current_language'] );
    
        $options = get_option( $lang.'_axl_dentist_options' );
  
		
		?>
			<?php if ( $selection_cat == $options['tooth_id'] ) : ?>
				
				
				<?php echo woocommerce_form_field( 'wizard_fullname', array ( 'label' => __( 'Name and surname', 'scdentist' )) ,  wiz_set_placeholder( 'wizard_fullname' )  ); ?>	
				<?php echo woocommerce_form_field( 'wizard_tel_email', array ( 'label' => __( 'Telephone or email', 'scdentist' )) , wiz_set_placeholder( 'wizard_tel_email' ) ); ?>			
				<?php $img = wizard_categores::$fields['spazzolini']['img']; ?>
				<p>
						<input type="submit" id="submitBtn" class="button" data-toggle="modal" data-target="#confirm-submit" name="customize_spazzolino" value="<?php esc_attr_e( 'Create customization', 'scdentist' ); ?>" />
						<!-- <input type="submit" class="button" id="save_image" name="save_image" value="<?php esc_attr_e( 'salva immagina', 'woocommerce' ); ?>" /> -->
						<?php wp_nonce_field( 'woocommerce-customize_spazzolino' ); ?>
						<input type="hidden" name="action" value="customize_spazzolino" />
						<input type="hidden" id="image_data" name="image_data" value="" />
				</p>
				
				<?php elseif ( $selection_cat == $options['kit_id'] ): ?>

				<?php echo woocommerce_form_field( 'wizard_email', array ( 'label' => __( 'Name dental practice', 'scdentist' )) ,  wiz_set_placeholder( 'wizard_email' ) ); ?>	
				<?php echo woocommerce_form_field( 'wizard_fullname', array ( 'label' => __( '', 'woocommerce' )) ,  wiz_set_placeholder( 'wizard_fullname' )  ); ?>
					
				<?php echo woocommerce_form_field( 'wizard_tel', array ( 'label' => __( 'Telephone' , 'scdentist')) ,  wiz_set_placeholder( 'wizard_tel' )  ); ?>	
				
				<?php echo woocommerce_form_field( 'wizard_address', array ( 'label' => __( 'Address 1' , 'scdentist' )) ,  wiz_set_placeholder( 'wizard_address' ) ); ?>
				<?php echo woocommerce_form_field( 'wizard_address_2', array ( 'label' => __( 'Address 2' , 'scdentist' )) ,  wiz_set_placeholder( 'wizard_address_2' ) ); ?>
				
				<?php echo woocommerce_form_field( 'wizard_city_postcode', array ( 'type' => 'text' , 'label' => __( 'Website / E-mail',  'scdentist'  )) ,  wiz_set_placeholder( 'wizard_city_postcode' ) ); ?>	
				
				<?php echo woocommerce_form_field( 
					'wizard_background', array ( 'type' => 'visual-select', 'label' => __( 'Stile' ) , 'input_class'=> array('image-picker', 'show-html'),
					 
					 'options' => array(
					 	//"1" => "test", 
						//"2" => "test2",
						"3" => "test3", 
						"4" => "test4",
						"5" => "test5", 
						"6" => "test6",
						"7" => "test7", 
						//"8" => "test8",
						//"9" => "test9", 
						"10" => "test10",
						) , 
					 'image_options' => array(
					 	//get_stylesheet_directory_uri() . '/img/texture1zoom.jpg', 
						//get_stylesheet_directory_uri() . '/img/texture2zoom.jpg',
						get_stylesheet_directory_uri() . '/img/texture3zoom.jpg', 
						get_stylesheet_directory_uri() . '/img/texture4zoom.jpg',
						get_stylesheet_directory_uri() . '/img/texture5zoom.jpg', 
						get_stylesheet_directory_uri() . '/img/texture6zoom.jpg',
						get_stylesheet_directory_uri() . '/img/texture7zoom.jpg', 
						//get_stylesheet_directory_uri() . '/img/texture8zoom.jpg',
						//get_stylesheet_directory_uri() . '/img/texture9zoom.jpg', 
						get_stylesheet_directory_uri() . '/img/texture10zoom.jpg',
											)) ,  wiz_set_placeholder( 'wizard_background' ) ); ?>		
				
				<?php $img = wizard_categores::$fields['kit']['img']; ?>		
				
				<p>
						<input type="submit" id="submitBtn" class="button" data-toggle="modal" data-target="#confirm-submit" name="customize_spazzolino" value="<?php esc_attr_e( 'Create customization', 'scdentist'  ); ?>" />
						<!-- <input type="submit" class="button" id="save_image" name="save_image" value="<?php esc_attr_e( 'Store image', 'scdentist' ); ?>" /> -->
						<?php wp_nonce_field( 'woocommerce-customize_spazzolino' ); ?>
						<input type="hidden" name="action" value="customize_spazzolino" />
						<input type="hidden" id="image_data" name="image_data" value="" />
				</p>
				
				<?php elseif ( $selection_cat == $options['box_id'] ): ?>
					
					<?php if( $product_id ==  $options['box_custom_id']): ?>
					
					<?php echo woocommerce_form_field( 
					'wizard_scovolini_quantita_ultra_fine', array ( 'type' => 'select', 'label' => __( 'Quantity Ultra Fine Interdental Brushes' ,'scdentist' ) ,
					 
					 'options' => array(
					 	"0" => "0 pz.",
						"1" => "100 pz.", 
						"2" => "200 pz.",
						"3" => "300 pz.", 
						"4" => "400 pz.",
						"5" => "500 pz.", 
						
						) , 
					)
					); ?>
					
					<?php echo woocommerce_form_field( 
					'wizard_scovolini_quantita_fine', array ( 'type' => 'select', 'label' => __( 'Quantity Fine Interdental Brushes','scdentist'  ) ,
					 
					 'options' => array(
					 	"0" => "0 pz.",
						"1" => "100 pz.", 
						"2" => "200 pz.",
						"3" => "300 pz.", 
						"4" => "400 pz.",
						"5" => "500 pz.", 
						
						) , 
					)
					); ?>		
					
					<?php echo woocommerce_form_field( 
					'wizard_scovolini_quantita_medium', array ( 'type' => 'select', 'label' => __( 'Quantity Medium Interdental Brushes' ,'scdentist' ) ,
					 
					 'options' => array(
					 	"0" => "0 pz.",
						"1" => "100 pz.", 
						"2" => "200 pz.",
						"3" => "300 pz.", 
						"4" => "400 pz.",
						"5" => "500 pz.", 
						
						) , 
					)
					); ?>		
						
					<?php echo woocommerce_form_field( 
					'wizard_scovolini_quantita_large', array ( 'type' => 'select', 'label' => __( 'Quantity Large Interdental Brushes' ,'scdentist' ) ,
					 
					 'options' => array(
					 	"0" => "0 pz.",
						"1" => "100 pz.", 
						"2" => "200 pz.",
						"3" => "300 pz.", 
						"4" => "400 pz.",
						"5" => "500 pz.", 
						
						) , 
					)
					); ?>			
					
					<?php echo woocommerce_form_field( 
					'wizard_scovolini_quantita_extra_large', array ( 'type' => 'select', 'label' => __( 'Quantity Extra Large Interdental Brushes' ,'scdentist' ) ,
					 
					 'options' => array(
					 	"0" => "0 pz.",
						"1" => "100 pz.", 
						"2" => "200 pz.",
						"3" => "300 pz.", 
						"4" => "400 pz.",
						"5" => "500 pz.",  
						
						) , 
					)
					); ?>		
					
					<p>
								<input type="submit" id="submitBtn" class="button" data-toggle="modal" data-target="#modal-generico" name="customize_spazzolino" value="<?php esc_attr_e( 'purchase it', 'scdentist' ); ?>" />
								<!-- <input type="submit" class="button" id="save_image" name="save_image" value="<?php esc_attr_e( 'Store image', 'woocommerce' ); ?>" /> -->
								<?php wp_nonce_field( 'woocommerce-customize_spazzolino' ); ?>
								<input type="hidden" name="action" value="customize_spazzolino" />
								<input type="hidden" id="image_data" name="image_data" value="" />
						</p>
						
						
					<?php else:  ?>
					
						<p>
							<?php _e('This product is not customizable.','scdentist'); // Il prodotto scelto non è componibile.  ?> 
						</p>
						<p>
								<input type="submit" id="submitBtn" class="button" data-toggle="modal" data-target="#confirm-submit" name="customize_spazzolino" value="<?php esc_attr_e( 'purchase it', 'scdentist' ); ?>" />
								<!-- <input type="submit" class="button" id="save_image" name="save_image" value="<?php esc_attr_e( 'Store image', 'woocommerce' ); ?>" /> -->
								<?php wp_nonce_field( 'woocommerce-customize_spazzolino' ); ?>
								<input type="hidden" name="action" value="customize_spazzolino" />
								<input type="hidden" id="image_data" name="image_data" value="" />
						</p>
					
					<?php endif; ?>
				
				
				
				<?php endif; ?>
				