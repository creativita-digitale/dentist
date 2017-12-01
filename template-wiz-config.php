<?php
/**
 * Template Name: Wizard Configurator
 *
 */
 
get_header('wiz-config'); ?>



	<div id="wiz-config" class="clearfix">
		<form method="post" class="register" id="wiz-config" autocorrect="off" autocapitalize="off" autocomplete="off">

			<div class="container clearfix">
				<div class="main">
					<?php the_post();  ?>
					<?php the_content(); ?>
				</div>
			</div>
			
			<div class="container">
				<h2 style="margin-top:20px; "><span class="circle-icon">1</span><? _e('Choose the type of product to customize','scdentist'); ?></h2>
				<p><? _e('Click on one of the items below','scdentist'); ?></p>
			</div>


			<div class="container clearfix">
				<div class="main">
					<?php  do_action( 'pre_product_editor' ); ?>
				</div>
			</div>

			
            
			<div class="container clearfix">
				<div class="row">
					<h2><span class="circle-icon">2</span><? _e('Create your own customization','scdentist'); ?></h2>
					<?php do_action('pre_product_focus'); ?>
					<span id="pre_product_focus"></span>
				</div>
			</div>
            
			<div id="product-focus" class="container">
				<div class="row">
					
                    <div class="col-md-4">
						<div class="config-main">
						
                        	<div id="custom-section" class="clearfix">

                                <div class="x-content">
                                    <div class="loader"> </div>
                                </div>
							
                            </div>
						
                        </div>
					</div>

                    <div class="col-md-8">
                        <div id="product-editor" class="hero-img">
                            <div id="stage">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

	<div class="container">

		<div id="product-section" class="single-product clearfix">

			<div class="product">
				<h2><span class="circle-icon">3</span><? _e('Product recap:','scdentist'); ?></h2>
				<div class="x-content">
					<div class="loader"> </div>
				</div>


			</div>
		</div>
	</div>

	</form>
	</div>
	<div class="summary-wiz">
		<div class="summary-body container">

			<div class="row">
				<div class="col-md-12">
					<h1><? _e('Order recap:','scdentist'); ?></h1>
				</div>

			</div>
			<div class="row">
				<div class="summary-table col-md-10">
					<table class="table">

						<tbody>
							<tr>
								<td><? _e('Product:','scdentist'); ?></td>
								<td><? _e('Price:','scdentist'); ?></td>
								<td><? _e('Quantity:','scdentist'); ?></td>
							</tr>
							<tr>
								<td>
									<div id="sum_prod_title"></div>
								</td>
								<td>
									<div id="sum_prod_price"></div>
								</td>
								<td>
									<div id="sum_prod_q"></div>
								</td>
							</tr>
						</tbody>
					</table>

				</div>
				<div class="col-md-2">
					
					<small class="x-small"><? _e('Please note: in the next screen it is still possible to make changes to your order
','scdentist'); ?></small>
				</div>
			</div>

		</div>
	</div>
	<div id="modal-wrapper"></div>

	<?php get_footer( 'wiz-config' ); ?>