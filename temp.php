<?php wc_get_template( 'form-login.php', array() ); ?>
				
				
				
				<form name="sartoria_editor" id="sartoria_editor" method="post" action="edit_address_sartoria">
				
					<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
			 
					<?php echo woocommerce_form_field( 'billing_first_name', array ( 'label' => __( 'First name', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_first_name', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_last_name', array ( 'label' => __( 'Last name', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_last_name', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_email', array ( 'label' => __( 'E-mail', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_email', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_phone', array ( 'label' => __( 'Telephone', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_phone', true ) ); ?>
					<?php // echo woocommerce_form_field( 'billing_country', array ( 'label' => __( 'Country', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_country', true ) ); ?>
					<?php // echo woocommerce_form_field( 'billing_address_1', array ( 'label' => __( 'Address 1', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_address_1', true ) ); ?>
					<?php // echo woocommerce_form_field( 'billing_city', array ( 'label' => __( 'City', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_city', true ) ); ?>
					<?php // echo woocommerce_form_field( 'billing_state', array ( 'label' => __( 'State', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_state', true ) ); ?>
					<?php // echo woocommerce_form_field( 'billing_postcode', array ( 'label' => __( 'Postcode', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_postcode', true ) ); ?>
					
					<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
		
					<p>
						<input type="submit" class="button" name="save_address_sartoria" value="<?php esc_attr_e( 'Choose product', 'woocommerce' ); ?>" />
						<input type="submit" class="button" id="save_image" name="save_image" value="<?php esc_attr_e( 'Store image', 'woocommerce' ); ?>" />
						<?php wp_nonce_field( 'woocommerce-edit_address_sartoria' ); ?>
						<input type="hidden" name="action" value="edit_address_sartoria" />
						<input type="hidden" id="image_data" name="image_data" value="" />
					</p>
					
				</form>
				
				<img id="scream" width="220" height="277" src="<?php echo get_stylesheet_directory_uri() . '/img/base_spazzolino_2.jpg' ?>" alt="The Scream" style="display:none">

				
				<script>
				jQuery(function() {
					
					//stabilisco le variabili principali
					var canvas = document.getElementById( "test-immagine" );
					var context = canvas.getContext( "2d" );
					var img = document.getElementById( "scream" );
					
					//creo la base di gioco
					crea_base ();
					// catturo le informaziona dal form
					message = jQuery( "#billing_first_name" ).val();
					drawScreen();
									
					function crea_base (){
						context.drawImage( img, 0, 10 );
						context.font = "15px Arial";
						context.fillStyle = "#ffffff";
					}					
											
					function textBoxChanged(e) {
						var target = e.target;
      					message = target.value;
						drawScreen();
					}
					   
					jQuery( "#billing_first_name" ).keyup(function(e) {
						console.log( e );	
						 textBoxChanged(e);
						  
					});
							
					function drawScreen() {
						crea_base ();
						
						context.font = "15px Arial";
						context.fillStyle = "#ffffff";
						context.fillText  (message, 300, 190);
						var imgData = canvas.toDataURL("image/jpeg", 1.0);
						jQuery( "#image_data" ).val( imgData );
					}
					
					jQuery( "#pdf" ).click(function(event) {
						
						event.preventDefault();
						var imgData = canvas.toDataURL("image/jpeg", 1.0);
						jQuery( "#image_data" ).val( imgData );
						console.log( imgData );	
						var pdf = new jsPDF();
				
						pdf.addImage(imgData, 'JPEG', 0, 0);
					 	pdf.save("download.pdf");
					});				
				});
				
				
				
			
				
				
				</script>
				
			<canvas id="test-immagine" width="650" height="300"></canvas>
            
            <a id="pdf" href="#">pdf</a>
            