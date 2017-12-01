<?php

/**
 * silvercare engine room
 *
 * @package silvercareone
 */
 

require get_stylesheet_directory() . '/inc/class-imagebuilder.php';
require get_stylesheet_directory() . '/inc/titan-framework-checker.php';
require get_stylesheet_directory() . '/inc/class-wizard-install.php';
require get_stylesheet_directory() . '/inc/class-remote-address.php';
require get_stylesheet_directory() . '/inc/extra-functions.php';
require get_stylesheet_directory() . '/inc/admin-functions.php';
require get_stylesheet_directory() . '/inc/theme-functions.php';

require get_stylesheet_directory() . '/inc/woocommerce-functions.php';

require get_stylesheet_directory() . '/inc/customizer-functions.php';

require get_stylesheet_directory() . '/inc/dentist-customizer-functions.php';



require get_stylesheet_directory() . '/inc/customizer-functions.php';
require get_stylesheet_directory() . '/inc/class-WC-wizard.php';
require get_stylesheet_directory() . '/inc/class-wizard-session.php';

require get_stylesheet_directory() . '/inc/class-wizard-forms.php';
require get_stylesheet_directory() . '/inc/class-wizard-categories.php';
require get_stylesheet_directory() . '/inc/class-metaorders.php';
require get_stylesheet_directory() . '/inc/class-menu-handler.php';
require get_stylesheet_directory() . '/inc/class-wizard-img-handler.php';
require get_stylesheet_directory() . '/inc/class-wizard.php';
require get_stylesheet_directory() . '/inc/class-customizations.php';


require get_stylesheet_directory() . '/inc/wizard-functions.php';

require get_stylesheet_directory() . '/inc/class-wizard-log.php';

require get_stylesheet_directory() . '/inc/class-wiz-ajax.php';


if ( ! function_exists( '_dentist_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
	function _dentist_setup() {
		
		load_child_theme_textdomain( 'scdentist', get_stylesheet_directory() . '/lang' );
	}

endif;

add_action( 'after_setup_theme', '_dentist_setup' );


add_theme_support( 'custom-logo', array(
	'height'      => 68,
	'width'       => 238,
	'flex-height' => true,
	'flex-width'  => true,
	
) );

// Include the Google Analytics Tracking Code (ga.js)
// @ https://developers.google.com/analytics/devguides/collection/gajs/
// include GA tracking code before the closing head tag


function _dentist_tracking_code(){

	$propertyID = 'UA-39620872-1'; // GA Property ID

	 ?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', '<?php echo $propertyID; ?>', 'auto');
		  ga('send', 'pageview');
		
		</script>
	<?php 
}

add_action('wp_head', '_dentist_tracking_code');
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function _dentist_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Header', 'theme-slug' ),
        'id' => 'header',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'scdentist' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );
}

add_action( 'widgets_init', '_dentist_widgets_init' );


add_filter( 'woocommerce_order_button_html', 'my_button' );
function my_button($content){
	 // Set this variable to specify a minimum order value
    $minimum = 300;
	
	/* set the subtotal without taxses as client request. */
 	
	$actual = WC()->cart->subtotal_ex_tax;
	
	if ($actual < $minimum ) {
	return '<h3>'. __('Checkout not avaiable', 'scdentist'). '</h3>';
	}else{
	return $content;
		}
}


add_filter( 'body_class', 'my_class_names' );
function my_class_names( $classes ) {
	$titan = TitanFramework::getInstance( 'Silvercaredentist' );
 	
	$color = $titan->getOption( 'alt-color' );
	$sidebar = $titan->getOption( 'fullwidth' );
	$title = $titan->getOption( 'no-title' );
	
	if( is_active_sidebar( 'header' ) && ! is_woocommerce()){
		// add 'class-name' to the $classes array
		$classes[] = 'adv-header';
	}
	if ( $color OR is_front_page() OR is_tax( 'product_cat', array( 'kit', 'spazzolini' ) ) ){
		$classes[] = 'alt-colors';
	}
	if ( $sidebar OR is_front_page() OR is_tax( 'product_cat', array( 'kit', 'spazzolini' ) ) ){
		
		$classes[] = 'storefront-full-width-content';
		$classes =  array_diff( $classes , array('right-sidebar' ) );
	}
	if ( $title  ){		
		$classes[] = 'no-title';
	}
	
	
	
	// return the $classes array
	return $classes;
}

add_filter( 'body_class', 'product' );
function product( $classes ) {
	
	if( is_page_template( 'template-wiz-config.php' ) ){
		// add 'class-name' to the $classes array
		$classes[] = 'woocommerce product';
	}
	
	
	// return the $classes array
	return $classes;
}




// Add specific CSS class by filter
add_filter( 'body_class', 'removesidebar' );
function removesidebar( $classes ) {
	
	
	// return the $classes array
	return $classes;
}

/*
 * Add this code to the functions.php file of your theme.
 * This is extracted from the WCML WC Subscriptions compatibility class. 
 */
  
add_filter('wcml_register_endpoints_query_vars', 'register_endpoint', 10, 3 );
 
function register_endpoint( $query_vars, $wc_vars, $obj ){
 
    // Add the translation for the custom "view-subscription" endpoint.
    $query_vars[ 'view-subscription' ] = $obj->get_endpoint_translation( 'view-subscription',  isset( $wc_vars['view-subscription'] ) ? $wc_vars['view-subscription'] : 'view-subscription' );
 
    return $query_vars;
}
