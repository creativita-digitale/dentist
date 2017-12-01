<?php
/**
 * Template Name: fase1
 *
 */
 
 get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php wc_print_notices(); ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				do_action( 'storefront_page_before' );
				?>
				<?php get_template_part( 'template', 'wizard' ); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				
				<?php
				if ( is_user_logged_in() ) {
					?>
					<p class="myaccount_user">
	<?php
	printf(
		__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
		$current_user->display_name,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);

	printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', 'woocommerce' ),
		wc_customer_edit_account_url()
	);
	?>
</p>
					
					
					
					
					<?
					
				} else {
					?>
					<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

					<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
					
					<div  id="customer_login">
					
						<div class="col-1">
					
					<?php endif; ?>
					
							<h2><?php _e( 'Login', 'woocommerce' ); ?></h2>
					
							<form method="post" class="login">
					
								<?php do_action( 'woocommerce_login_form_start' ); ?>
					
								<p class="form-row form-row-wide">
									<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
									<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
								</p>
								<p class="form-row form-row-wide">
									<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
									<input class="input-text" type="password" name="password" id="password" />
								</p>
					
								<?php do_action( 'woocommerce_login_form' ); ?>
					
								<p class="form-row">
									<?php wp_nonce_field( 'wizard-login' ); ?>
									<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
									<label for="rememberme" class="inline">
										<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
									</label>
								</p>
								<p class="lost_password">
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
								</p>
					
								<?php do_action( 'woocommerce_login_form_end' ); ?>
					
							</form>
					
					<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
					
						</div>
					
						<div class="col-2">
					
							<h2><?php _e( 'Register', 'woocommerce' ); ?></h2>
					
							<form method="post" class="register">
					
								<?php do_action( 'woocommerce_register_form_start' ); ?>
					
								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
					
									<p class="form-row form-row-wide">
										<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
										<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
									</p>
					
								<?php endif; ?>
					
								<p class="form-row form-row-wide">
									<label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
									<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
								</p>
					
								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
					
									<p class="form-row form-row-wide">
										<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
										<input type="password" class="input-text" name="password" id="reg_password" />
									</p>
					
								<?php endif; ?>
					
								<!-- Spam Trap -->
								<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
					
								<?php do_action( 'woocommerce_register_form' ); ?>
								<?php do_action( 'register_form' ); ?>
					
								<p class="form-row">
									<?php wp_nonce_field( 'woocommerce-register' ); ?>
									<input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" />
								</p>
					
								<?php do_action( 'woocommerce_register_form_end' ); ?>
					
							</form>
					
						</div>
					
					</div>
					<?php endif; ?>
					
					<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

					
					
					
					
					<?php
				}
				?>
                
               
                
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