<?php
/**
 * Template Name: fase3
 *
 */
 
 get_header(); ?>

<?php $customer_id = get_current_user_id(); ?>

<script>
/* global wc_checkout_params */
jQuery( function( $ ) {
	
	var wc_checkout_login_form = {
		init: function() {
			$( document.body ).on( 'click', 'a.showlogin', this.show_login_form );
		},
		show_login_form: function() {
			$( 'form.login' ).slideToggle();
			return false;
		}
	};


	wc_checkout_login_form.init();
	
	
	
	$('#sartoria_editor input,  #sartoria_editor textarea,  #sartoria_editor select').each(function( index ) {
		if ( this.id == 'wizard_background'){
					$('.'+ this.id + '_text').attr( 'src', this.value );
			} else{
				$('.'+ this.id + '_text').html( this.value );
			}
	});
	
	$('#sartoria_editor input,  #sartoria_editor textarea, #sartoria_editor select').keyup(function(e) {
		$(this).each(function( index ) {
			
				$('.'+ this.id + '_text').html( this.value );	
				
		});
	
	
	});
	
	
	
	
	
	$( "#sartoria_editor select " ).change(function(e) {
  $('.'+ this.id + '_text').attr( 'src', this.value );
});
	
	
	
	$('#submitBtn').click(function(event) {
    
	 event.preventDefault();
	  
     $('#rew_wizard_fullname').html($('#wizard_fullname').val());
     $('#rew_wizard_tel_email').html($('#wizard_tel_email').val());
	  $('#rew_wizard_tel').html($('#wizard_tel').val());
     $('#rew_wizard_email').html($('#wizard_email').val());
	  $('#rew_wizard_address').html($('#wizard_address').val());
     $('#rew_wizard_city_postcode').html($('#wizard_city_postcode').val());
	  $('#rew_wizard_fullname').html($('#wizard_fullname').val());
     $('#rew_wizard_tel_email').html($('#wizard_tel_email').val());
	 
	 $('#img').attr( 'src', $('#scream').attr('src') );
	 
	
	 
});

$('#submit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#sartoria_editor').submit();
});


	});
	
	
</script>
	
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
				<?php wc_print_notices(); ?>
					
				<?php while ( have_posts() ) : the_post(); ?>

				<?php
				do_action( 'storefront_page_before' );
				?>
				<?php get_template_part( 'template', 'wizard' ); ?>
				<?php get_template_part( 'content', 'page' );
				
				//ottengo le voci preregistrate dei moduli
				$data_structure= new wizard_forms;
				//ottengo i dati dai cookie
				$wizard = new wizard;
				$current_cookie_data = $wizard->get_cookie_data ();
				
				
				$is_spazzolini = ( current_wizard_cat () == wizard_categores::$fields['spazzolini']['id'] ? true : false);
				$is_kit = ( current_wizard_cat () == wizard_categores::$fields['kit']['id'] ? true : false);
				
				if ( $is_spazzolini ) : 
					
					$img = wizard_categores::$fields['spazzolini']['img'];
					$data_structure =  array_keys ($data_structure->get_default_spazzolino_fields()) ;
					
				elseif ( $is_kit ): 
					
					$img = wizard_categores::$fields['kit']['img'];
					$data_structure =  array_keys ($data_structure->get_default_kit_fields());
					
				endif;
				
				
				
				
				
				
				 ?>
				
				<div id="product-editor" class="clearfix">
				
				<div class="col-2-3">
					<?php if ( $is_spazzolini ) : ?>
					<div id="stage" class="spazzolini">
						
						<span class="wizard_fullname_text"></span>
						<span class="wizard_tel_email_text"></span>
						<div class="stage_bg"></div>
						
					</div>
						<?php elseif ( $is_kit ): ?>
					<div id="stage" class="kit">
						
						<span class="wizard_fullname_text"></span>
						<span class="wizard_tel_text"></span>
						<span class="wizard_email_text"></span>
						<span class="wizard_address_text"></span>
						<span class="wizard_city_postcode_text"></span>
						<img class="wizard_background_text" src="" >
						<div class="stage_bg"></div>
					</div>
					
					<?php endif; ?>
				</div>
				<div class="col-1-3">
					<form name="sartoria_editor" id="sartoria_editor" method="post">
				
				<?php if ( $is_spazzolini ) : ?>
				
				
				<?php echo woocommerce_form_field( 'wizard_fullname', array ( 'label' => __( 'First and Last Name', 'woocommerce' )) ,  wiz_set_placeholder( 'wizard_fullname' )  ); ?>	
				<?php echo woocommerce_form_field( 'wizard_tel_email', array ( 'label' => __( 'Telephone or Email' )) , wiz_set_placeholder( 'wizard_tel_email' ) ); ?>			
				<?php $img = wizard_categores::$fields['spazzolini']['img']; ?>
				<p>
						<input type="submit" id="submitBtn" class="button" data-toggle="modal" data-target="#confirm-submit" name="customize_spazzolino" value="<?php esc_attr_e( 'Crea personalizzazione', 'woocommerce' ); ?>" />
						<!-- <input type="submit" class="button" id="save_image" name="save_image" value="<?php esc_attr_e( 'salva immagina', 'woocommerce' ); ?>" /> -->
						<?php wp_nonce_field( 'woocommerce-customize_spazzolino' ); ?>
						<input type="hidden" name="action" value="customize_spazzolino" />
						<input type="hidden" id="image_data" name="image_data" value="" />
				</p>
				
				<?php elseif ( $is_kit ): ?>

				
				<?php echo woocommerce_form_field( 'wizard_fullname', array ( 'label' => __( 'First and Last Name', 'woocommerce' )) ,  wiz_set_placeholder( 'wizard_fullname' )  ); ?>	
				<?php echo woocommerce_form_field( 'wizard_tel', array ( 'label' => __( 'Telephone' )) ,  wiz_set_placeholder( 'wizard_tel' )  ); ?>	
				<?php echo woocommerce_form_field( 'wizard_email', array ( 'label' => __( 'Email' )) ,  wiz_set_placeholder( 'wizard_email' ) ); ?>	
				<?php echo woocommerce_form_field( 'wizard_address', array ( 'type' => 'textarea' , 'label' => __( 'Address' )) ,  wiz_set_placeholder( 'wizard_address' ) ); ?>
				<?php echo woocommerce_form_field( 'wizard_city_postcode', array ( 'type' => 'text' , 'label' => __( 'City - Postcode' )) ,  wiz_set_placeholder( 'wizard_city_postcode' ) ); ?>	
				
				<?php echo woocommerce_form_field( 
					'wizard_background', array ( 'type' => 'visual-select', 'label' => __( 'Background' ) , 'input_class'=> array('image-picker', 'show-html'), 'options' => array("http://lorempixel.com/400/200/sports" => "test", "http://lorempixel.com/400/200/sports/1" => "test2") , 'image_options' => array( 'http://lorempixel.com/400/200/sports', 'http://lorempixel.com/400/200/sports/1')) ,  wiz_set_placeholder( 'wizard_background' ) ); ?>	
				
				<?php $img = wizard_categores::$fields['kit']['img']; ?>		
				
				<p>
						<input type="submit" id="submitBtn" class="button" data-toggle="modal" data-target="#confirm-submit" name="customize_spazzolino" value="<?php esc_attr_e( 'Crea personalizzazione', 'woocommerce' ); ?>" />
						<!-- <input type="submit" class="button" id="save_image" name="save_image" value="<?php esc_attr_e( 'Store image', 'woocommerce' ); ?>" /> -->
						<?php wp_nonce_field( 'woocommerce-customize_spazzolino' ); ?>
						<input type="hidden" name="action" value="customize_spazzolino" />
						<input type="hidden" id="image_data" name="image_data" value="" />
				</p>
				
				<?php else : ?>
				
				<?php wc_add_notice( 'errore nella configurazione', 'error' ); ?>
				
				<?php endif; ?>
				
					
					
				</form>
				
				</div>
				</div>
				
				
				
				
				
				
				
				<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h3>Conferma invio</h3>
							</div>
							<div class="modal-body">
							  <p> Rivedi i dati inseriti, prima di procedere.</p>
							<?php if ( $is_spazzolini ) : ?>
								<!-- We display the details entered by the user here -->
								<table class="table">
									<tr>
										<th>Nome e Cognome</th>
										<td id="rew_wizard_fullname"></td>
									</tr>
									<tr>
										<th>Telefono o E-mail</th>
										<td id="rew_wizard_tel_email"></td>
									</tr>
								</table>
								
								<?php elseif ( $is_kit ): ?>
								
								<table class="table">
									<tr>
										<th>Nome e Cognome</th>
										<td id="rew_wizard_fullname"></td>
									</tr>
									<tr>
										<th>Telefono</th>
										<td id="rew_wizard_tel"></td>
									</tr>
									<tr>
										<th>Email</th>
										<td id="rew_wizard_email"></td>
									</tr>
									<tr>
										<th>Indirizzo</th>
										<td id="rew_wizard_address"></td>
									</tr>
									<tr>
										<th>C.A.P. Città</th>
										<td id="rew_wizard_city_postcode"></td>
									</tr>
								</table>
								
								
								<?php endif; ?>
									
								<div id="img-wrap">
							   	<div class="stage_bg"></div>
								</div>
							</div>
				
				  	<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Torna alle modifiche</button>
							<button type="button" id="submit" class="btn btn-success success">Procedi</button>
						</div>
					</div>
				</div>
				
				
				
				
				
				
				
				
				
				<?php	
				/**
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );
				?>
				
				<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>