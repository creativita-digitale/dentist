<?php 







/* check if wpml is active and load in menu bar the language switcher */
if ( function_exists('icl_object_id') ) {
	
	function my_wpml_switcher(){
		do_action( 'icl_language_selector' );
	}
	add_action( 'storefront_header', 'my_wpml_switcher', 51 ); // Hook wherever you want

}



/**
 *
 * Function to manage redirections before woo cart
 *
*/


function continua_acquisti (){
	$lang = ICL_LANGUAGE_CODE;
    $options = get_option( $lang.'_axl_dentist_options' );
	
	?>
	<div class="alert alert-warning" role="alert">
		<div class="container" style="padding-top:50px">
    	
			 
			 <p><a class="button" href=" <?php echo get_permalink( $options [ 'cutomizer_id' ] ); ?>" role="button"><?php _e('Continue shopping','scdentist'); ?></a></p>
			</div>
			
  		</div>
  </div>
	<?php
}

function my_page_template_redirect_kit()
{
    if( is_product_category('kit') )
    {
        wp_redirect( home_url( '/kit/' ) );
        exit();
    }
}
add_action( 'template_redirect', 'my_page_template_redirect_kit' );

function my_page_template_redirect_spazzolini()
{
    if( is_product_category('spazzolini') )
    {
        wp_redirect( home_url( '/spazzolini/' ) );
        exit();
    }
}
add_action( 'template_redirect', 'my_page_template_redirect_spazzolini' );


function my_page_template_redirect_scovolini()
{
    if( is_product_category('scovolini') )
    {
        wp_redirect( home_url( '/scovolini/' ) );
        exit();
    }
}
add_action( 'template_redirect', 'my_page_template_redirect_spazzolini' );


add_action( 'woocommerce_checkout_process', 'wc_minimum_order_amount' );

//add_action( 'woocommerce_before_cart' , 'wc_minimum_order_amount' );
 
function wc_minimum_order_amount() {
    // Set this variable to specify a minimum order value
    $minimum = 299;
	$minimum_declared =  300;
	/* set the subtotal without taxses as client request. */
 	
	$actual = WC()->cart->subtotal_ex_tax;
    //if ( WC()->cart->total < $minimum ) {
	if ($actual < $minimum ) {	
;
        if( is_cart() ) {

            wc_print_notice( 
                sprintf( esc_html__( 'Your order must be at least %s (excluding VAT), currently the total is  %s. (excluding VAT)', 'scdentist' ) ,
						//https://codex.wordpress.org/I18n_for_WordPress_Developers
						//Your order must be at least € 300.00 (excluding VAT), currently the total is € 120.00 (excluding VAT).
						// Il tuo ordine deve essere minimo di %s (+ iva), attualmente il totale è  %s. (+ iva)
                    wc_price( $minimum_declared ), 
                    wc_price( $actual )
                ), 'error' 
            );
			
        } else {

            wc_add_notice( 
               sprintf( esc_html__( 'Your order must be at least %s (excluding VAT), currently the total is  %s. (excluding VAT)', 'scdentist' ) ,
			         wc_price( $minimum_declared ), 
                    wc_price( $actual )
                ), 'error' 
            );

        }
    }

}

add_action('woocommerce_check_cart_items','check_ammount');
function check_ammount(){
	
	$minimum = 300;
	$minimum_declared =  300;
	/* set the subtotal without taxses as client request. */
 	
	$actual = WC()->cart->subtotal_ex_tax;
    //if ( WC()->cart->total < $minimum ) {
	if ($actual < $minimum ) {	
;
        

            wc_add_notice( 
               sprintf( esc_html__( 'Your order must be at least %s (excluding VAT), currently the total is  %s. (excluding VAT)', 'scdentist' ) ,
			         wc_price( $minimum_declared ), 
                    wc_price( $actual )
                ), 'error' 
            );

      
    }
	
	}







function my_theme_shift_navigation() {
remove_action( 'storefront_sidebar',			'storefront_get_sidebar',			10 );
remove_all_actions( 'storefront_sidebar', 9);
}
add_action( 'template_redirect', 'my_theme_shift_navigation' );


add_action('storefront_before_footer' , 'set_help' );

function set_help($params){
	$titan = TitanFramework::getInstance( 'Silvercaredentist' );
 	$params = $titan->getOption( 'help' );
	
	if ( isset ( $params ) && ! empty(  $params  )) {
		echo '<div id="helpertab" class="darker-main-color"><div class="container">';
		echo '<h1>Cosa devo fare in questa schermata?</h1>';
		echo $params;
		echo '</div></div>';
	}
	
}


add_action('storefront_before_footer' , 'set_help_cat' );

function set_help_cat($params){
	$params = term_description();
	if ( is_tax(  )) {
	if ( isset ( $params ) && ! empty(  $params  )) {
		echo '<div id="helpertab" class="darker-main-color"><div class="container">';
		echo '<h1>Cosa devo fare in questa schermata?</h1>';
		echo $params;
		echo '</div></div>';
	}
	}
	
}
//global $woocommerce;
//wp_die(var_dump( $woocommerce));
add_action( 'wp_enqueue_scripts', 'lightbox' );
function lightbox() {
global $woocommerce;
$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
{
wp_enqueue_script( 'prettyPhoto', WP_PLUGIN_URL . '/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
wp_enqueue_script( 'prettyPhoto-init', WP_PLUGIN_URL . '/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
wp_enqueue_style( 'woocommerce_prettyPhoto_css', WP_PLUGIN_URL . '/woocommerce/assets/css/prettyPhoto.css' );
}
}


add_action( 'wp_enqueue_scripts', 'font_awesome' );	
function font_awesome() {

	  wp_enqueue_style( 'font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );  
}




add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );	
function theme_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );  
	  wp_enqueue_style( 'alt-colors', get_stylesheet_directory_uri() . '/css/alt-colors.css', array('storefront-style') );  
}

add_action( 'wp_enqueue_scripts', 'js_functions' );
function js_functions() {
	
	wp_enqueue_script( 'js_function', get_stylesheet_directory_uri() . '/js/functions.js', array(), '0.0.1', true );

}

add_action( 'wp_enqueue_scripts', 'modernizr' );
function modernizr() {
	
	wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . '/vendor/modernizr/modernizr.custom.63321.js', array(), '0.0.1', true );

}

add_action( 'wp_enqueue_scripts', 'scrollTo' );
function scrollTo() {
	if( is_page_template( 'template-wiz-config.php' ) ) {
	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/vendor/scrollTo/jquery.scrollTo.min.js', array('jquery'), '2.1.3', true );
}
}

add_action( 'wp_enqueue_scripts', 'load_popup' );
function load_popup() {
	
	wp_enqueue_style( 'popup-style', get_stylesheet_directory_uri() . '/vendor/popup/popup.css' );
	wp_enqueue_script( 'popup-script', get_stylesheet_directory_uri() . '/vendor/popup/popup.js', array('jquery', 'js-cookie-script'), '0.0.1', true );

}
add_action( 'wp_enqueue_scripts', 'load_js_cookie' );
function load_js_cookie() {
	
	wp_enqueue_script( 'js-cookie-script', get_stylesheet_directory_uri() . '/vendor/js-cookie/js.cookie.js', array(), '2.0.4', true );

}

add_action( 'wp_enqueue_scripts', 'ipq_validation' );
function ipq_validation() {
	if( is_page_template( 'template-wiz-config.php' ) && class_exists( 'IPQ_Actions' )  ) {
	wp_enqueue_script( 'ipq_validation', get_stylesheet_directory_uri() . '/js/ipq_input_value_validation.js', array('jquery'), '2.1.3', true );
}
}



add_action( 'wp_enqueue_scripts', 'load_tooltipster' );
function load_tooltipster() {
	
	wp_enqueue_style( 'tooltipster-style', get_stylesheet_directory_uri() . '/vendor/tooltipster/tooltipster.css' );
	wp_enqueue_script( 'tooltipster-script', get_stylesheet_directory_uri() . '/vendor/tooltipster/jquery.tooltipster.min.js', array('jquery'), '3.3.0', true );
	wp_enqueue_script( 'tooltipster-action', get_stylesheet_directory_uri() . '/js/tooltipster.act.js', array('jquery', 'tooltipster-script'), '0.0.1', true );

}


add_action( 'wp_enqueue_scripts', 'load_jsPDF' );
 function load_jsPDF() {
	wp_enqueue_script( 'jsPDF', get_stylesheet_directory_uri() . '/vendor/jsPDF/jspdf.min.js', array('jquery'), '0.9.0', true );
}

add_action( 'wp_enqueue_scripts', 'wizard' );
 function wizard() {
	wp_enqueue_script( 'wizard', get_stylesheet_directory_uri() . '/js/wizard.js', array('jquery'), '0.0.1', true );
}



add_action( 'wp_enqueue_scripts', 'canvas_drawer' );
 function canvas_drawer() {
	 if ( is_page_template( 'template-fase3.php' ))
	wp_enqueue_script( 'canvas-drawer', get_stylesheet_directory_uri() . '/js/canvas-drawer.js', array('jquery', 'jsPDF'), '0.0.1', true );
	
	// Localize the script with new data
	$translation_array = array(
		'cookie_cat_id' => current_wizard_cat(),
		'is_spazzolino' => true,
		'is_kit' => false
	);
	
	wp_localize_script( 'canvas-drawer', 'js_object', $translation_array );
}


add_action( 'wp_enqueue_scripts', 'preload' );

 function preload() {
	if ( is_page_template( 'template-wiz-config.php'  ) ) {
	wp_enqueue_script( 'preload', get_stylesheet_directory_uri() . '/vendor/jqueryPreload/jquery.preload.min.js', array('jquery'), '1.0.3', true );
	
}
}



add_action('init','unhook_functions');
function unhook_functions() {
	remove_action( 'storefront_header', 'storefront_secondary_navigation', 30 );	
	//remove_action( 'storefront_header', 'storefront_header_cart', 60 );
	remove_action( 'storefront_header', 'storefront_product_search', 40 );
}
 /**
 * Proper way to enqueue scripts and styles
 */
function load_image_picker() {
	if ( is_page_template( 'template-wiz-config.php'  ) ) {
	wp_enqueue_style( 'image-picker-style', get_stylesheet_directory_uri() . '/vendor/image-picker/image-picker.css' );
	wp_enqueue_script( 'image-picker-script', get_stylesheet_directory_uri() . '/vendor/image-picker/image-picker.min.js', array('jquery'), '0.2.4', true );
	wp_enqueue_script( 'image-picker-action', get_stylesheet_directory_uri() . '/js/image-picker.act.js', array('jquery', 'image-picker-script'), '0.0.1', true );
	}
}

add_action( 'wp_enqueue_scripts', 'load_image_picker' );

 /**
 * Proper way to enqueue scripts and styles
 */
function load_image_zoom() {
	if ( is_page_template( 'template-wiz-config.php'  ) ) {
	wp_enqueue_script( 'hoover-zoom', get_stylesheet_directory_uri() . '/vendor/hover-zoom/hover_zoom_v2.min.js', array('jquery'), '0.2.4', true );
	}
}

add_action( 'wp_enqueue_scripts', 'load_image_zoom' );



 /**
 * Proper way to enqueue scripts and styles
 */
function load_bootstrap() {
	
	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/vendor/bootstrap/css/bootstrap.css' );
	wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/vendor/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.5', true );
	
	
	//wp_enqueue_script( 'image-picker-action', get_stylesheet_directory_uri() . '/js/image-picker.act.js', array('jquery', 'image-picker-script'), '0.0.1', true );
	
}

add_action( 'wp_enqueue_scripts', 'load_bootstrap' );




if ( ! function_exists( 'storefront_credit' ) ) {
	/**
	 * Display the theme credit
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_credit() {
		?>
		<div class="site-info">
			<?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) ); ?>
			<?php if ( apply_filters( 'storefront_credit_link', true ) ) { ?>
			Spazzolificio Piave S.p.a. Via A.Palladio 5, 35019 Tombolo – Pd (Italia) <?php if ( function_exists ('wc_accepted_payment_methods') ) wc_accepted_payment_methods(); ?>
			<?php } ?>
		</div><!-- .site-info -->
		<?php
	}
}



if ( ! function_exists( 'storefront_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false">Menu</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'primary',
					'container_class'	=> 'primary-navigation',
					)
			);

			wp_nav_menu(
				array(
					'theme_location'	=> 'handheld',
					'container_class'	=> 'handheld-navigation',
					)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

// remove links/menus from the admin bar
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	if ( ! is_admin() ) {
	$wp_admin_bar->remove_menu('comments');
	//$wp_admin_bar->remove_menu('edit');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('my-blogs');
	$wp_admin_bar->remove_menu('appearance');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('vc_inline-admin-bar-link');
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('site-name');
	$wp_admin_bar->remove_menu('search');
	$wp_admin_bar->remove_menu('revslider');
	}
}
//add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

//add_action('admin_head', 'remove_notices');

function remove_notices() {
  echo '<style>
    .wp-admin  .updated{display:none !important}
    } 
  </style>';
}

function my_admin_bar_init() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
//add_action('admin_bar_init', 'my_admin_bar_init');


// move admin bar to bottom
function fb_move_admin_bar() {
	if ( ! is_admin() ) { ?>
	<style type="text/css">
	#wp-toolbar{
    margin: 0 auto;
   
}

@media (min-width: 768px) {
  #wp-toolbar {
    width: 750px;
  }
}
@media (min-width: 992px) {
  #wp-toolbar {
    width: 970px;
  }
}
@media (min-width: 1200px) {
  #wp-toolbar {
    width: 1170px;
  }
}

	#wp-admin-bar-wp-logo{
		display:none;
	}
		#wpadminbar {
    background: #414141 none repeat scroll 0 0;
	height:58px;
	font: 400 13px/58px "Open Sans",sans-serif;
    
}
#wpadminbar * {
   
    font: 400 13px/58px "Open Sans",sans-serif;
  
}
html { margin-top: 58px !important; }
	* html body { margin-top: 58px !important; }
	@media screen and ( max-width: 782px ) {
		html { margin-top: 46px !important; }
		* html body { margin-top: 46px !important; }
	}
	
#wpadminbar .ab-icon, #wpadminbar .ab-item::before, #wpadminbar > #wp-toolbar > #wp-admin-bar-root-default .ab-icon {
    -moz-osx-font-smoothing: grayscale;
    background-image: none !important;
    float: left;
    font: 400 20px/46px dashicons;
    margin-right: 6px;
    padding: 4px 0;
    position: relative;
}
#wpadminbar .quicklinks .ab-empty-item, #wpadminbar .quicklinks a, #wpadminbar .shortlink-input {
    display: block;
    height: 58px;
    margin: 0;
    padding: 0 10px;
}
	</style>
<?php }}
// on backend area
//add_action( 'admin_head', 'fb_move_admin_bar' );
// on frontend area
//add_action( 'wp_head', 'fb_move_admin_bar' );

// always show admin bar
function pjw_login_adminbar( $wp_admin_bar) {
	$account_page = get_permalink( get_option('woocommerce_myaccount_page_id') );
	if ( ! is_admin() ) {
	if ( !is_user_logged_in() )
	$wp_admin_bar->add_menu( array( 'parent' => 'top-secondary',  'title' => __( 'Accedi o registrati', 'scdentist' ), 'href' => $account_page ) );
}}
//add_action( 'admin_bar_menu', 'pjw_login_adminbar' );
//add_filter( 'show_admin_bar', '__return_true' , 1000 );

// add links/menus to the admin bar
function silvercare_admin_bar_render() {
	global $wp_admin_bar, $woocommerce;
	



	if ( ! is_admin() ) {
	$wp_admin_bar->add_menu( array(
		'parent' => 'top-secondary', // use 'false' for a root menu, or pass the ID of the parent menu
		'id' => 'cart', // link ID, defaults to a sanitized title value
		'title' => __('Cart', 'woocommerce'), // link title
		'href' =>  wc_get_checkout_url(), // name of file
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));
	
}}
//add_action( 'wp_before_admin_bar_render', 'silvercare_admin_bar_render' );

if (  class_exists( 'IPQ_Actions' ) ) :
class IPQ_edited_Actions  extends IPQ_Actions {
	
	public function __construct() {
		
		// Add quantity message shortcode
		add_action( 'woocommerce_single_product_summary', array( $this, 'wizard_display_minimum_quantity_note' ), 30);
		add_shortcode('wpbo_quantity_message', array( $this, 'wizard_display_minimum_quantity_note' ));
		
	}
	
	public function wizard_display_minimum_quantity_note() {
	
		global $product;
		
		
		
		if( $product->product_type == 'grouped' )
			return;
		
		$settings = get_option( 'ipq_options' );
		extract( $settings );
		
		// Get minimum value for product 
		$rule = wpbo_get_applied_rule( $product );
		
		// Return nothing if APQ is deactivated
		if ( $rule == 'inactive' or $rule == null ) {
			return; 
		}
		
		// Check if the product is out of stock 
		$stock = $product->get_stock_quantity();

		// Check if the product is under stock management and out of stock
		if ( strlen( $stock ) != 0 and $stock <= 0 ) {
			$min = wpbo_get_value_from_rule( 'min_oos', $product, $rule );
			$max = wpbo_get_value_from_rule( 'max_oos', $product, $rule );
		} else {
			$min = wpbo_get_value_from_rule( 'min', $product, $rule );
			$max = wpbo_get_value_from_rule( 'max', $product, $rule );
		}	

		$step = wpbo_get_value_from_rule( 'step', $product, $rule );

		// If sitewide rule is applied, convert return arrays to values
		if ( $rule == 'sitewide' and strlen( $stock ) != 0 and $stock <= 0  ) {
			if ( is_array( $min ) )
				$min = $min['min_oos'];
		
			if ( is_array( $max ) )
				$max = $max['max_oos'];
				
			if ( is_array( $step ) ) {
				$step = $step['step'];
			}
		} else if ( $rule == 'sitewide' ) {
			if ( is_array( $min ) )
				$min = $min['min'];
		
			if ( is_array( $max ) )
				$max = $max['max'];
				
			if ( is_array( $step ) ) {
				$step = $step['step'];
			}
		}
		
		// If the text is set, update and print the output
		if ( isset( $ipq_qty_text ) ) {
			$min_pattern = '/\%MIN\%/';
			$max_pattern = '/\%MAX\%/';
			$step_pattern = '/\%STEP\%/';

			$ipq_qty_text = preg_replace($min_pattern, $min, $ipq_qty_text);
			$ipq_qty_text = preg_replace($max_pattern, $max, $ipq_qty_text);
			$ipq_qty_text = preg_replace($step_pattern, $step, $ipq_qty_text);

			// Output result with optional custom class
			echo "<span";
			if ( isset( $ipq_qty_class ) and $ipq_qty_class != '' )
				echo " class='" . $ipq_qty_class . "'";
			echo ">";	
			echo $ipq_qty_text;
			echo "</span>";
		}
	}

}


return new IPQ_edited_Actions();
endif;

add_action( 'woocommerce_before_checkout_billing_form', 'woocommerce_checkout_login_form' );