<?php
class wiz_ajax {
	
	private static $instance;
	
	private function __construct(){
   	
	
	add_action( 'wp_ajax_wiz_get_form', 					array( __CLASS__, 'wiz_get_form' ) );
	add_action( 'wp_ajax_nopriv_wiz_get_form', 			array( __CLASS__, 'wiz_get_form' ));
	
	add_action( 'wp_ajax_wiz_get_fields', 					array( __CLASS__, 'wiz_get_fields' ) );
	add_action( 'wp_ajax_nopriv_wiz_get_fields', 			array( __CLASS__, 'wiz_get_fields' ));
	
	
	add_action( 'wp_ajax_nopriv_wiz_load_cat_posts', 	array( __CLASS__, 'wiz_load_cat_posts' ) );
	add_action( 'wp_ajax_wiz_load_cat_posts', 			array( __CLASS__, 'wiz_load_cat_posts'  ) );
	
	add_action( 'wp_ajax_wiz_getsingle_product', array( __CLASS__, 'wiz_getsingle_product' ));
	add_action( 'wp_ajax_nopriv_wiz_getsingle_product', array( __CLASS__, 'wiz_getsingle_product' ));
	
	add_action( 'wp_ajax_wiz_get_image_editor', array( __CLASS__, 'wiz_get_image_editor' ));
	add_action( 'wp_ajax_nopriv_wiz_get_image_editor', array( __CLASS__, 'wiz_get_image_editor' ));
	
	add_action( 'wp_ajax_wiz_get_modal', array( __CLASS__, 'wiz_get_modal' ));
	add_action( 'wp_ajax_nopriv_wiz_get_modal', array( __CLASS__, 'wiz_get_modal' ));
	
	add_action( 'wp_ajax_wiz_get_cat', array( __CLASS__, 'wiz_get_cat' ));
	add_action( 'wp_ajax_nopriv_wiz_get_cat', array( __CLASS__, 'wiz_get_cat' ));
	
	//add_action( 'wp_ajax_wiz_preload_images', array( __CLASS__, 'wiz_preload_images' ));
	//add_action( 'wp_ajax_nopriv_wiz_preload_images', array( __CLASS__, 'wiz_preload_images' ));
	
	add_action( 'wp_ajax_wiz_save_image_spazzolino', array( __CLASS__, 'wiz_save_image_spazzolino' ));
	add_action( 'wp_ajax_nopriv_wiz_save_image_spazzolino', array( __CLASS__, 'wiz_save_image_spazzolino' ));
	
	add_action( 'wp_ajax_wiz_save_image_kit', array( __CLASS__, 'wiz_save_image_kit' ));
	add_action( 'wp_ajax_nopriv_wiz_save_image_kit', array( __CLASS__, 'wiz_save_image_kit' ));
	
	
	add_action( 'wp_ajax_wiz_set_style', array( __CLASS__, 'wiz_set_style' ));
	add_action( 'wp_ajax_nopriv_wiz_set_style', array( __CLASS__, 'wiz_set_style' ));
	
	add_action( 'wp_ajax_wiz_admin_create_post', array( __CLASS__, 'wiz_admin_create_post' ));
	add_action( 'wp_ajax_nopriv_wiz_admin_create_post', array( __CLASS__, 'wiz_admin_create_post' ));
	
	
	add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'), 1);
	add_action( 'wp_loaded', array( __CLASS__, 'wiz_shift_navigation' ) );
	
	
  }
  
  static function wiz_admin_create_post(){
	
	ob_start (); 
		
		$wizard 	= new wizard;
		$data 		= $wizard->	get_cookie_data ();			
		$user_id 	= $data['wizard_user_id'];
		
		$my_post = array(
			'post_title'    => __('Personalizzazione iniziata', 'plugin-domain'),
			'post_status'   => 'draft',
			'post_type'  	=> 'wiz_customization'
					);
					
		$post_id =	wp_insert_post( $my_post );	 
		$data['wizard_post_id'] = $post_id ;
		
		foreach ( $data as $key => $field ) {
			update_post_meta($post_id, $key, $field);
			update_user_meta( $user_id, $key, $field );
		}
      
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
   	die( );
	

}
  
static function  wiz_set_style (){

	$error = new WP_Error();
		
	if ( isset( $_REQUEST[ 'selection' ] ) ) {
		$selection = wc_clean( intval ( $_REQUEST['selection'] ) );	
		$selection = $selection++ ;
	ob_start (); 
		$custom_css = "
                .frame{
                        background: {#333};
                }";
        wp_add_inline_style( 'storefront-child-style-css', $custom_css );
		
			echo get_stylesheet_directory_uri(). '/img/sfondo'. $selection .'.jpg' ?>
			
			<?php
			function my_styles_method() {
			wp_enqueue_style(
				'custom-style',
				get_template_directory_uri() . '/css/custom_script.css'
			);
				$color = get_theme_mod( 'my-custom-color' ); //Es. #FF0000
				$custom_css = "
						 .frame{
                        background: {#333};
                }";
				 wp_add_inline_style( 'storefront-child-style-css', $custom_css );
		}
		add_action( 'wp_enqueue_scripts', 'my_styles_method' );
		
		?>
			<?php
		   $output = ob_get_contents();
			ob_end_clean();
			echo $output;
   	die( );
	
	}else{
			 $error->add('regerror','The parameter "selection" is not set or is NULL');
			 echo $error->get_error_message();
		}
		
		die( );
}
  
   public function wiz_preload_images( ) {
	   
	  $query_args = array (
		   'posts_per_page' => -1,
			'order'			 => 'DESC',
			'post_type' 		 => 'product',
			
							);
							
		$products = new WP_Query( $query_args );
		
		$titan = TitanFramework::getInstance( 'Silvercaredentist' );
			
			
		
		
		
		
	?>
	
			<?php $images = array();
			while ( $products->have_posts() ) : $products->the_post(); ?>
	
	
			<?php 
				
				
				
				$imageID = $titan->getOption( 'product_image_editor', get_the_ID() );
				$editor_img = wp_get_attachment_image_src( $imageID, 'full' );
				if ( !is_null ($editor_img[0]) )
			$images[] = $editor_img[0];
			
			
			$full_img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
			if ( !is_null ($editor_img[0]) )
			$images[] = $full_img[0];
			
			
			$shop_img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'shop_catalog' );			
			if ( !is_null ($editor_img[0]) )
			$images[] = $shop_img[0];
		
			
			 endwhile; // end of the loop. ?>



		
<?php


			woocommerce_reset_loop();
			wp_reset_postdata();
			
			
			
	  
	 ?>
			
			
			<?php 
			ob_start (); 
			echo json_encode( $images ,JSON_FORCE_OBJECT); ?>
			<?php
		   $output = ob_get_contents();
			ob_end_clean();
			echo $output;
   die( );
   }
    
	public function enqueueAssets2( ) {
	}
	public function enqueueAssets( ) {
		
		
		
		
		if( is_page_template( 'template-wiz-config.php' ) ) {
		
		wp_register_script( 'catslider', get_stylesheet_directory_uri() . '/js/jquery.catslider.js', array( 'jquery' ), '', true );
		wp_register_script( 'catslider-act', get_stylesheet_directory_uri() . '/js/catslider.act.js', array( 'jquery' , 'catslider'), '', true );
        
		$wizard = new wizard;
		
		$data = $wizard->	get_cookie_data ();	
		
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    	$options = get_option( $lang.'_axl_dentist_options' );
			
		$spazzolini_id =  $options['tooth_id'];
		$kit_id =  $options['kit_id'];
		$scovolini_id =  $options['box_id'];
		
		//wp_die($data[ 'wizard_currentstep' ]);
		/* deve essere assolutamente wizard_cat_id il parametro, altrimenti nel configuratore, aggiornando, non riesco a tornare sulla stessa sezione. */
		switch( $data['wizard_cat_id'] ){
		
			case $spazzolini_id: 
			
			$cookie_cat_id = 0;
			break;
			
			case $kit_id: 
			
			$cookie_cat_id = 1;
			break;
			
			case $scovolini_id: 
			
			$cookie_cat_id = 2;
			break;
			
			default:
			$cookie_cat_id = 0;
				break;
		}
		
		$js_object_array = array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'cookie_name' => wizard::$cookie_name,
				'cookie_cat_id_raw' => $data['wizard_cat_id'],
				'cookie_product_id_raw' => $data['wizard_product_id'],
				'cookie_cat_id' => $cookie_cat_id,
				'spazzolini_id' => $spazzolini_id,
				'kit_id' => $kit_id,
				'scovolini_id' => $scovolini_id,
				
			);
			if ( current_user_can('manage_options') ) { 
			//	wp_die( $spazzolini_id  );
			}
			
			wp_localize_script( 'catslider', 'js_object', $js_object_array );
			
		
		
		wp_enqueue_script( 'catslider' );
		
		wp_enqueue_script( 'catslider-act' );
		
			wp_register_script( 'wiz_ajax', get_stylesheet_directory_uri() . '/js/wiz-ajax.js', array( 'jquery', 'js_function', 'scrollTo', 'js-cookie-script' ), '', true );
			
			$wiz_ajax_aux = array(
				'ajax_url' 			=> admin_url('admin-ajax.php'),
				'cookie_name' 		=> wizard::$cookie_name,
				'user_settings' 	=> wizard::$defaults,				
				'text_box_1'		=> __('Insert the amount of interdental brushes until you have composed the entire box of 500 pcs. At the moment you have not selected any amount.' , 'scdentist'), //'Inserisci le quantità di scovolini, fino a configurare la scatola intera di 500 pezzi. Attualmente non è stata inserita nessuna quantità.', // riga 336 wiz-ajax.js
				'text_box_2'		=> __('Insert the amount of interdental brushes until you have composed the entire box of 500 pcs. At the moment you have not selected a sufficient quantity to complete your order.' , 'scdentist'), //'Inserisci le quantità di scovolini, fino a configurare la scatola intera di 500 pezzi. Attualmente le quantità inserite sono insufficienti per completare l\'ordine.', // 343 wiz-ajax.js
				'text_box_3'		=> __('You have completed the composition of the box. You can now insert it in your cart.' , 'scdentist'), //'Hai completato la configurazione del box. Ora puoi procedere all\'inserimento nel carrello.', // 354 wiz-ajax.js
				'text_box_4'		=> __('Quantity exceed, every box could contain only max 500 pcs.' , 'scdentist'), //'Quantità superata, ogni box può contenere massimo 500 pezzi.', // 374 wiz-ajax.js
				'text_studio'		=> __('If you want to customize this with your logo, please contact us directly on  <a href="mailto:mkt@piave.com">mkt@piave.com</a>' , 'scdentist') // Se vuoi una personalizzazione con il tuo logo contatta direttamente l’azienda e invia il tuo logo a <a href="mailto:mkt@piave.com">mkt@piave.com</a> // 776 wiz-ajax.js
			);
			
			// Permetto a plugins di passare valori qui
			// Passo i valori per reference
			
			// hook axl-scdentist-options
			
			$wiz_ajax_aux = apply_filters_ref_array ( 'parameters_wiz_ajax' , array( $wiz_ajax_aux, &$this ) );
			
			wp_localize_script( 'wiz_ajax', 'setup', $wiz_ajax_aux );
			wp_enqueue_script( 'wiz_ajax' );
	
		}

		// carica lo stile del configuratore solo in questa pagina
		wp_enqueue_style( 'customizer', get_stylesheet_directory_uri() . '/css/style.css' );
		
		wp_enqueue_style( 'woocommerce');
		
    }
    
	static function wiz_shift_navigation() {

		remove_action ('woocommerce_after_single_product_summary',  'woocommerce_output_related_products', 20);
		//remove_action ('woocommerce_after_single_product_summary',  'woocommerce_output_product_data_tabs', 10);
		//remove_action ('woocommerce_before_single_product_summary',  'woocommerce_show_product_images', 20);
		//remove_action ('woocommerce_after_shop_loop_item',  'woocommerce_template_loop_add_to_cart', 10);
		//remove_action ('woocommerce_before_shop_loop_item_title',  'woocommerce_show_product_loop_sale_flash', 10);
		//add_action ('woocommerce_before_single_product_summary',  array( __CLASS__, 'wiz_show_product_images'));
	}
	
	
   
   
static function wiz_save_image_spazzolino(){
	ob_start();       
	
	$wizard = new wizard;
	$data = $wizard->	get_cookie_data (   );	
			
	$test = new wiz_img_handler();
	
	$data[ 'wizard_image_id' ] = $test->create_spazzolino_label ( $data );
	$wizard->set_cookie_data ( $data  ) ;
	
	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
	die( );
}	  



static function wiz_save_image_kit(){
	ob_start();       
	
	$wizard = new wizard;
	$data = $wizard->	get_cookie_data (   );	
			
	$test = new wiz_img_handler();
	
	$data[ 'wizard_image_id' ] = $test->kitGenerateImage ( $data );
	$wizard->set_cookie_data ( $data  ) ;
	
	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
	die( );
}	  
	  
	  
	  
   
  static  function wiz_get_form( ) {
		
		$error = new WP_Error();
		
		if ( isset( $_REQUEST[ 'selection' ] ) ) {
			// valore consegnato da wc-ajax.js
			$selection = wc_clean( intval ( $_REQUEST['selection'] ) );
			$current_category =  wizard_wc_cat_id ( trim($selection," ") );
			
			$data[ 'wizard_currentstep' ] = '1';
			$data[ 'wizard_user_id' ] =  ( get_current_user_id() ? get_current_user_id() : false);
			$data[ 'wizard_cat_id' ] = 	( $current_category ? $current_category : false) ;
			// non rimuovere
			$data[ 'wizard_product_id' ] = $selection;
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;
			
			ob_start(); ?>       
			<?php
			// wc_get_template( 'template-form.php', array(), get_stylesheet_directory() );
			 
			 require_once( trailingslashit( get_stylesheet_directory() ) . 'template-form.php' );
			 ?>       
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
			
			
			
			die( );
			
		}else{
			 $error->add('regerror','The parameter "selection" is not set or is NULL');
			 echo $error->get_error_message();
		}
		
		die( );
    }
	
	
	 function wiz_get_cat(){
		 
		 $error = new WP_Error();
		
		if ( isset( $_REQUEST[ 'selection' ] ) ) {
			
			$selection = wc_clean( intval ( $_REQUEST['selection'] ) );
			$current_category =  wizard_wc_cat_id ( trim($selection," ") );
			
			ob_start ();?>
		  	
			<?php echo $current_category ; ?>
		   
		   <?php
		   $output = ob_get_contents();
			ob_end_clean();
			echo $output;
		   
		  }else{
			 $error->add('regerror','The parameter "selection" is not set or is NULL');
			 echo $error->get_error_message();
		}
		
		die( );
	  }
	
	
	
	 static function wiz_get_fields(){
		 
		 $error = new WP_Error();
		
		if ( isset( $_REQUEST[ 'selection' ] ) ) {
			
			$selection = wc_clean( intval ( $_REQUEST['selection'] ) );
			$current_category =  wizard_wc_cat_id ( trim($selection," ") );
			
			ob_start ();?>
		  	
			<?php
			// wc_get_template( 'template-fields.php',  array(), get_stylesheet_directory());
			  require_once( trailingslashit( get_stylesheet_directory() ) . 'template-fields.php' );
			 ?>      
		   
		   <?php
		   $output = ob_get_contents();
			ob_end_clean();
			echo $output;
		   
		  }else{
			 $error->add('regerror','The parameter "selection" is not set or is NULL');
			 echo $error->get_error_message();
		}
		
		die( );
	  }
	
	
	function wiz_load_cat_posts () {
		$error = new WP_Error();
		$cat_ID = wc_clean( intval ( $_REQUEST[ 'cat' ] ) );
		
		if ( isset( $cat_ID ) ) {
			
			global $post, $woocommerce, $product;
			$columns = 4;
			$query_args = array (
		   
			'posts_per_page' => -1,
			'order'			 => 'DESC',
			'post_type' 		 => 'product',
			'tax_query' 		 => array(
									array(
										'taxonomy' 	=> 'product_cat',
										'field' 	=> 'tag_ID',
										'terms' 	=> array( $cat_ID )
										)
									)
							);
							
				 // La Query
			$products = new WP_Query( $query_args );
		
			ob_start ();
			?>
		
			<div id="cat_opt" class="woocommerce columns-<?php echo $columns ?>'">
			
			<?php
			if ( $products->have_posts() ) :?>
			
			<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php get_template_part( 'template', 'wiz-product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			

			<?php
			endif;
			?>
			
			</div> <?php
			// Ripristina Query & Post Data originali
			wp_reset_query();
			wp_reset_postdata();
		
		
		  
		
		   $response = ob_get_contents();
		   ob_end_clean();
		
		   echo $response;
		   die(1);
				
				
				
			
		}else{
			 $error->add('regerror','The parameter "cat" is not set or is NULL');
			 echo $error->get_error_message();
		}
	die( );
  }
  
  
  static function get_editor_fields ( $post ) {
	  $error = new WP_Error();
		
		if ( isset( $post ) ) {
	  
			global $wp;
			
			$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    		$options = get_option( $lang.'_axl_dentist_options' );
			
			$is_spazzolini 	= ( current_wizard_cat () == $options['tooth_id'] ? true : false);
			$is_kit 			= ( current_wizard_cat () == $options['kit_id'] ? true : false);
			$is_scovolini 	= ( current_wizard_cat () == $options['box_id'] ? true : false);
			
			$default_form = new wizard_forms;
			
			if( $is_spazzolini ) { $address = $default_form->get_default_spazzolino_fields(); } ;
			if( $is_kit ) { $address = $default_form->get_default_kit_fields();};
			if( $is_scovolini ) { $address = $default_form->get_default_scovolini_fields();};
			
			
			
			//ottengo e sanitizzo i darti del form
			foreach ( $address as $key => $field ) {
				if ( ! isset( $field['type'] ) ) {
					$field['type'] = 'text';
				}
				// Get Value
				switch ( $field['type'] ) {
					case "checkbox" :
						$post[ $key ] = isset( $post[ $key ] ) ? 1 : 0;
					break;
					default :
						$post[ $key ] = isset( $post[ $key ] ) ? wc_clean( $post[ $key ] ) : '';
					break;
				}
				// Hook to allow modification of value
				$post[ $key ] = apply_filters( 'woocommerce_process_myaccount_field_' . $key, $post[ $key ] );
				
				$data[ $key ] = $post[ $key ];
			}
		
			$data[ 'wizard_currentstep' ] = '2';
			//$data[ 'wizard_image_id' ] = $image->get_image_name();
			$data[ 'wizard_user_id' ] =  ( get_current_user_id() ? get_current_user_id() : false);
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;
		
		
		}else{
			 $error->add('regerror','The parameter "data" is not set or is NULL');
			 echo $error->get_error_message();
		}
	
	}
  
  
 static function wiz_get_image_editor (){
		$error = new WP_Error();
		
		$prod_id =  $_REQUEST['prodID']  ;
		if ( isset( $prod_id ) ) {
	
	
		$titan = TitanFramework::getInstance( 'Silvercaredentist' );
		
		$imageID = $titan->getOption( 'product_image_editor', $prod_id );
		
		 $imageSrc = $imageID; // For the default value
			if ( is_numeric( $imageID ) ) {
				$imageAttachment = wp_get_attachment_image_src( $imageID, 'full' );
				$imageSrc = $imageAttachment[0];
			} 
		ob_start (); 
		echo esc_url( $imageSrc );
	
	 	$response = ob_get_contents();
		   ob_end_clean();
		
		   echo $response;
		   
		
		}else{
			 $error->add('regerror','The parameter "prodID" is not set or is NULL');
			 echo $error->get_error_message();
		} 
		   die(1);
	}
  
  static function wiz_get_modal (){
	 
	  $selection = $_REQUEST['selection']  ;
	  
	 ob_start ();
	 
	 
	 set_query_var( 'selection', $selection );
	// wc_get_template_part( 'template', 'modal' ); 
	 require_once( trailingslashit( get_stylesheet_directory() ) . 'template-modal.php' );
	 
	$response = ob_get_contents();
		   ob_end_clean();
		
		   echo $response;
		   die(1);
     
	}
  
  static function wiz_getsingle_product () {
	  
	  $postData = $_REQUEST['dataForm']  ;
	  $cat_id = intval( $_REQUEST['selection']  );
	  
	  $cat_id = icl_object_id( $cat_id , 'product', false, ICL_LANGUAGE_CODE);
	  
	  if ( isset( $postData ) ) {
			
			$postData = urldecode ( $postData );
			
			 parse_str($postData, $postData);
		}
		
		
	  		self::get_editor_fields ( $postData );
	  
	  
	 		global $post, $product, $woocommerce;
		 
			 $args = array (
		   
			'posts_per_page' => 1,
			'post_type' => 'product',
			'page_id'	=>  $cat_id
		);
		
	
		$products = new WP_Query( $args );
	
		ob_start ();  
	
		//var_dump($postData)	;
	
		if ( $products->have_posts() ) : ?>
	
			
	
				<?php woocommerce_product_loop_start(); ?>
	
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
	
						<?php wc_get_template_part( 'content', 'single-product' ); ?>
	
					<?php endwhile; // end of the loop. ?>
	
				<?php woocommerce_product_loop_end(); ?>
	
				
			<?php endif;
	
			woocommerce_reset_loop();
			wp_reset_postdata();
			
		
		
		
		
		
		   $response = ob_get_contents();
		   ob_end_clean();
		
		   echo $response;
		   die(1);
	   }
    
  public static function getInstance(){
    if ( is_null( self::$instance ) )
    {
      self::$instance = new self();
    }
    return self::$instance;
  }
}

wiz_ajax::getInstance();

