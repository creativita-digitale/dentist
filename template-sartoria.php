<?php
/**
 * Template Name: sartoria
 *
 */
 
 get_header(); ?>
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
	});
			</script>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php wc_print_notices(); ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				do_action( 'storefront_page_before' );
				?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php	
				/**
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );
				?>
				
				<?php
				wc_get_template( 'form-login.php', array() );

				?>
				<?php endwhile; // end of the loop. ?>
				
				<form name="sartoria_editor" id="sartoria_editor" method="post" action="<?php get_permalink(get_the_ID()) ?>">
				
					<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
			 
					<?php echo woocommerce_form_field( 'billing_first_name', array ( 'label' => __( 'First name', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_first_name', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_last_name', array ( 'label' => __( 'Last name', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_last_name', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_email', array ( 'label' => __( 'E-mail', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_email', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_phone', array ( 'label' => __( 'Telephone', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_phone', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_country', array ( 'label' => __( 'Country', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_country', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_address_1', array ( 'label' => __( 'Address 1', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_address_1', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_city', array ( 'label' => __( 'City', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_city', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_state', array ( 'label' => __( 'State', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_state', true ) ); ?>
					<?php echo woocommerce_form_field( 'billing_postcode', array ( 'label' => __( 'Postcode', 'woocommerce' )) ,  get_user_meta ( $customer_id, 'billing_postcode', true ) ); ?>
					
					<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
		
					<p>
						<input type="submit" class="button" name="save_address_sartoria" value="<?php esc_attr_e( 'Save Address', 'woocommerce' ); ?>" />
						<?php wp_nonce_field( 'woocommerce-edit_address_sartoria' ); ?>
						<input type="hidden" name="action" value="edit_address_sartoria" />
					</p>
					
				</form>
				
				<img id="scream" width="220" height="277" src="http://www.silvercaredentist.com/configuratore/files/product/custom/base_spazzolino_2.jpg" alt="The Scream" style="display:none">

				
				<script>
				window.onload = function() {
					var canvas = document.getElementById( "test-immagine" );
					var context = canvas.getContext( "2d" );
					var img = document.getElementById( "scream" );
					context.drawImage( img, 0, 10 );
					context.font = "15px Arial";
					context.fillStyle = "#ffffff";
					context.fillText( "Hello World Bitch", 300, 190 );
					context.fillText( "Hello World Bitch", 300, 205 );
				}
				</script>
				
			<canvas id="test-immagine" width="650" height="300"></canvas>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>