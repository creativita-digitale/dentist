<?php
/**
 * Template Name: test
 
 *
 */
  get_header('wiz-config'); ?>
  
  <?php global $post, $product, $woocommerce; // just in case if your template file need this?>
  
  <?php
 		
			 $args = array (
		   
			'posts_per_page' => -1,
			'post_type' => 'product',
			'page_id'	=>  187
		);
		
  
		$products = new WP_Query( $args );
		
		if ( $products->have_posts() ) : ?>

		

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			
		<?php endif;

		woocommerce_reset_loop();
		wp_reset_postdata();
	
  
get_footer( 'wiz-config' ); ?>