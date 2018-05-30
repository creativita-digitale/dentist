<?php
/**
 * Template Name: fase2
 *
 */

?>

<?php
 get_header(); ?>
 <script>
/* global wc_checkout_params */
jQuery( function( $ ) {
	
	
$('.image_picker_selector .thumbnail').live( "click", function() {
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#choose').submit();
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
				<?php get_template_part( 'content', 'page' ); ?>
				<script>
				
				
				</script>
				<form id="choose" method="post" action="<?php get_permalink(15) ?>">
					<select class="image-picker show-html" name="product_opt">
					  <option data-img-src="http://localhost:8888/silvercaredentist/wp-content/uploads/2015/11/singolo-spazzolino.png" value="<?php echo wizard_categores::$fields['spazzolini']['id'] ?>">  Spazzolini  </option>
					  <option data-img-src="http://localhost:8888/silvercaredentist/wp-content/uploads/2015/11/singolo-kit.png" value="<?php echo wizard_categores::$fields['kit']['id'] ?>">  Kit  </option>
					</select>
					
					<p>
						<input style =" clear: both; display: block;
    margin: 17px auto;" type="submit" class="button" name="choose_sartoria" value="<?php esc_attr_e( 'Scegli la tipologia', 'woocommerce' ); ?>" />
						<?php wp_nonce_field( 'woocommerce-choose_sartoria' ); ?>
						<input type="hidden" name="action" value="choose_sartoria" />
					</p>
					
				</form>
				
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