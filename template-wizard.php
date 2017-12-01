<div id="wizard">
	<nav id="wizard-wrapper">
	  <?php wp_nav_menu( array('menu' => 'Wizard' )); ?>
	</nav>
		<?php if( ! is_cart() ) : ?>
	<ul class="cat-controller clearfix <?php echo wizard_wc_cat_slug(); ?>">
		<li><a class="tooltip" title="Qui puoi modificare la categoria" href="<?php echo get_permalink(24); ?>"><i class="fa fa-caret-left"></i>
	</a></li>
		<li> Hai scelto la tipologia <?php echo wizard_wc_cat_name(); ?> </li>
		<li><a  title="Qui puoi modificare la categoria"  class="tooltip thumb-<?php echo wizard_wc_cat_slug (); ?>" href="<?php echo get_permalink(24); ?>"><?php echo wizard_wc_cat_name(); ?></a></li>
	</ul>
	<?php endif; ?>
</div>