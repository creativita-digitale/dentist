<?php 
class wizard {
	
	public static $defaults = array(
				'wizard_currentstep'    => false,
				'wizard_user_id'        => false,
				'wizard_product_id' 		=> false,
				'wizard_cat_id'     	=> false,
				'wizard_image_id'   		=> false,
				'wizard_fullname'   		=> false,
				'wizard_tel_email'  		=> false,
				'wizard_tel'       		=> false,
				'wizard_email'       	=> false,
				'wizard_address'        => false,
				'wizard_city_postcode'  => false,
				'wizard_background'     => false,
				'wizard_cart'     		=> false,
				'wizard_post_id'     	=> false,
				'wizard_custom_end'     => false, //if true, the customization is end. So we can start another.
				'wizard_user_ip'     	=> false,
				'wizard_scovolini_quantita_ultra_fine' => 0,
				'wizard_scovolini_quantita_fine' => 0,
				'wizard_scovolini_quantita_medium' => 0,
				'wizard_scovolini_quantita_large' => 0,
				'wizard_scovolini_quantita_extra_large' => 0
			);
	public static $cookie_name = 'wiz';
	
	
	static function init(){
		add_action( 'init', array( __CLASS__, 'add_ep' ) );
		//add_action( 'template_redirect', array( __CLASS__, 'wiz_clear_redirect' ) );
		add_action('wp_login', array( __CLASS__, 'wizard_register_custom' ), 10, 2 );
		//add_action( 'template_redirect', array( __CLASS__, 'wiz_testimage' ) );
		add_action ('wp', array( __CLASS__, 'wiz_spazzolini_ep_it' ), 8);
		add_action ('wp', array( __CLASS__, 'wiz_kit_ep_it' ), 8);
		add_action ('wp', array( __CLASS__, 'wiz_scovolini_ep_it' ), 8);
		add_action ('wp', array( __CLASS__, 'wiz_spazzolini_ep_en' ), 7);
		add_action ('wp', array( __CLASS__, 'wiz_kit_ep_en' ), 8);
		add_action ('wp', array( __CLASS__, 'wiz_scovolini_ep_en' ), 8);

	 add_action( 'wp_ajax_wiz_get_cookie', array( __CLASS__, 'wiz_get_cookie' ));
        add_action( 'wp_ajax_nopriv_wiz_get_cookie', array( __CLASS__, 'wiz_get_cookie' ));
                
	}
	
	
	function wiz_set_default(){ 
		
		if ( ! $_COOKIE[ self::$cookie_name ]  ) {
					
				$defaults = self::$defaults;
		
			$expire = time() + ( 12 * HOUR_IN_SECONDS );
					
			$cookie_content = http_build_query($defaults, '', '&');
		
				
			setcookie( self::$cookie_name , $cookie_content, $expire, '/' );
			
			}
			
		
	}
	
	
	
	static function add_ep() {
		add_rewrite_endpoint( 'sezione-spazzolino', EP_PERMALINK | EP_PAGES  );
		add_rewrite_endpoint( 'sezione-kit', EP_PERMALINK | EP_PAGES  );
		add_rewrite_endpoint( 'sezione-scovolini', EP_PERMALINK | EP_PAGES  );
		
		
		add_rewrite_endpoint( 'toothbrushes-section', EP_PERMALINK | EP_PAGES  );
		add_rewrite_endpoint('kit-section', EP_PERMALINK | EP_PAGES  );
		add_rewrite_endpoint( 'box-section', EP_PERMALINK | EP_PAGES  );
	}


	static function wizard_register_custom($user_login, $user) {
	  
	  	$data = new wizard;  
		$data = $data->get_cookie_data (  );
		
		if ( isset( $_COOKIE[ self::$cookie_name ] ) ) {
		$data['wizard_user_id'] = $user->ID;
			
			foreach ( $data as $key => $field ) {
					update_user_meta( $data['wizard_user_id'], $key, $field );
					update_post_meta($data['wizard_post_id'], $key, $field);
					
			}
		}
	}
	
	/* 
	scopo di questa fuunzione è di ottenere il primo prodotto
	di una categoria
	*/
	static function get_first_by_cat( $cat ) {
		
		if( $cat != '' || $cat != null ){
			$query_args = array (
					
						'post_type' 		=> 'product',
						'orderby' 			=> 'menu_order',
						'suppress_filters' 	=> false,
						'order' 			=> 'ASC',
						'tax_query' 		 => array(
												array(
													'taxonomy' 	=> 'product_cat',
													'field' 	=> 'term_id',
													'terms' 	=> $cat
													)
											),
						
						'posts_per_page'	=>	1
						);
			$products = new WP_Query( $query_args );
			
			while ( $products->have_posts() ) :
				$products->the_post();
				$item = get_the_ID(); //dovrebbe essere 20
			endwhile;
			
			return $item;
			
			
		}
		
	}
	
static function wiz_spazzolini_ep_it() {
		
	$lang = $_COOKIE['_icl_current_language'];
    	$options = get_option( $lang.'_axl_dentist_options' );
	$ep_t = 'sezione-spazzolino';
	global $wp_query;
	
        
        //wp_die(var_dump($wp_query->query_vars));
        if ( ! array_key_exists ( $ep_t, $wp_query->query_vars ) ) 
            
             return;
        //wp_die(var_dump($wp_query->query_vars));
        $data[ 'wizard_cat_id' ] = $options['tooth_id'];		
	$data[ 'wizard_product_id' ] = self::get_first_by_cat($data[ 'wizard_cat_id' ]);		
	$wizard = new wizard;
	$wizard->set_cookie_data ( $data  ) ;	
	
       //
      //wp_die('fire ' . $data[ 'wizard_cat_id' ] . ' ' . $data[ 'wizard_product_id' ] );
        wp_reset_query();
}
	
		/**********************************************/
	
	static function wiz_spazzolini_ep_en() {
		
		$lang =  $_COOKIE['_icl_current_language'];;
    	$options = get_option( $lang.'_axl_dentist_options' );
		$ep_t = 'toothbrushes-section';
		global $wp_query;
	
		if ( ! array_key_exists ( $ep_t, $wp_query->query_vars ) )
            
                    return;
         
			$data[ 'wizard_cat_id' ] = $options['tooth_id'];
			
			$data[ 'wizard_product_id' ] = self::get_first_by_cat($data[ 'wizard_cat_id' ]);
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;
			
			wp_reset_query();
			//wp_die(var_dump($wp_query->query_vars));
                        //wp_die('fire ' . $data[ 'wizard_cat_id' ] . ' ' . $data[ 'wizard_product_id' ] );
		
				
}
	
	

static function wiz_kit_ep_it() {
		$lang = $_COOKIE['_icl_current_language'];
                $options = get_option( $lang.'_axl_dentist_options' );
		$ep_k = 'sezione-kit';
		global $wp_query;
	 	
		
	
		if ( ! array_key_exists ( $ep_k, $wp_query->query_vars ) )
            
            return;
        	
		//wp_die(var_dump($wp_query->query_vars));
			$data[ 'wizard_cat_id' ] = $options['kit_id'];
	
			$data[ 'wizard_product_id' ] = self::get_first_by_cat( $data[ 'wizard_cat_id' ] );
	
			
			
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;	
                        wp_reset_query();
			//wp_die('fire ' . $data[ 'wizard_cat_id' ] . ' ' . $data[ 'wizard_product_id' ] );	
}

static function wiz_scovolini_ep_it() {
    
    
   //wp_die('scovolini');
			
			
			
			
		$lang = $_COOKIE['_icl_current_language'];
    	$options = get_option( $lang.'_axl_dentist_options' );
		$ep_b = 'sezione-scovolini';
		global $wp_query;
                
                //wp_die(var_dump($wp_query->query_vars));
		
                if ( ! array_key_exists ( $ep_b, $wp_query->query_vars ) )
            
            return;
        
        
			$data[ 'wizard_cat_id' ] = $options['box_id'];
			$data[ 'wizard_product_id' ] = self::get_first_by_cat( $data[ 'wizard_cat_id' ] );
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;
                        wp_reset_query();
			//wp_die('errore');	
			
 
    //wp_die('fire ' . $data[ 'wizard_cat_id' ] . ' ' . $data[ 'wizard_product_id' ] );
		
                        
                        
}



static function wiz_kit_ep_en() {
		$lang = $_COOKIE['_icl_current_language'];
                $options = get_option( $lang.'_axl_dentist_options' );
		$ep_k = 'kit-section';
		global $wp_query;
	 	
		if ( ! array_key_exists ( $ep_k, $wp_query->query_vars ) )
            
                    return;
        
		
			$data[ 'wizard_cat_id' ] = $options['kit_id'];
	
			$data[ 'wizard_product_id' ] = self::get_first_by_cat( $data[ 'wizard_cat_id' ] );
	
			
			
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;	
                        wp_reset_query();
			//wp_die($data[ 'wizard_currentstep' ]);
				
}

static function wiz_scovolini_ep_en() {
		$lang = $_COOKIE['_icl_current_language'];
    	$options = get_option( $lang.'_axl_dentist_options' );
		$ep_b = 'box-section';
		global $wp_query;
		
                if ( ! array_key_exists ( $ep_b, $wp_query->query_vars ) )
            
            return;
        
		
			
			$data[ 'wizard_cat_id' ] = $options['box_id'];
			$data[ 'wizard_product_id' ] = self::get_first_by_cat( $data[ 'wizard_cat_id' ] );
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;
                        wp_reset_query();
			//wp_die('errore');	
			
}
	
	/***********************************/
	

	


	function set_cookie_data ( $data  ) {
            
            //global $wp_query;
            //array_keys
		//wp_die( var_dump($data ));
		// se non esiste il cookie dove vengono salvate le informazioni
		// Partiamo da un inizio pulito
		if ( ! isset( $_COOKIE[ self::$cookie_name ] ) ) {
			$defaults = self::$defaults;
		
		// altrimenti otteniamo i dati dal cookie (per aggiungerli da quelli appena ricevuti).
		}else{
			$defaults = $this->get_cookie_data();
		}	
			
		// codice che serve ad evitare che set cookie data venga caricato 2 volte
		//$queryvars_keys = array_keys( $wp_query->query_vars );
                //$links = array('kit-section', 'sezione-kit', 'box-section','sezione-scovolini', 'toothbrushes-section', 'sezione-spazzolino' );
                //$result = array_intersect($links, $queryvars_keys);
                //$errors = array_filter($result);

                //if ( empty($errors)) 
                 //   return;
                
                $data = wp_parse_args( $data, $defaults );
		//wp_die( print_r($result) );
		$data = apply_filters( 'wizard_set_data', $data);
		
                setcookie( self::$cookie_name , http_build_query($data, '', '&') , time() + ( 12 * HOUR_IN_SECONDS ) , '/' );
               
                //wp_die( var_dump($data ));
                
		do_action('after_set_cookie_data');
                
                
			
	}
        
          static      function wiz_get_cookie(){
		 
		 $error = new WP_Error();
		
		
			
			$selection = wc_clean( intval ( $_REQUEST['selection'] ) );
			$current_category =  wizard_wc_cat_id ( trim($selection," ") );
			
			ob_start ();
                        
                        //return wizard::get_cookie_data() ; 
		   echo   urldecode ( $_COOKIE[ self::$cookie_name ] );;    
		   
		   $output = ob_get_contents();
			ob_end_clean();
			echo $output;
		   
		  
		
		die( );
	  }
  
	
static	function get_cookie_data ( ) {
	
		$wiz_user_settings = array();
	
		if ( isset( $_COOKIE[ self::$cookie_name ] ) ) {
			
			$cookie = urldecode ( $_COOKIE[ self::$cookie_name ] );
			
			if ( strpos( $cookie, '=' ) ) { // '=' cannot be 1st char
				parse_str( $cookie, $wiz_user_settings );
			}
		} else {
			
			$wiz_user_settings = self::$defaults;
				
		}
	
		$_wiz_updated_user_settings = $wiz_user_settings;
		return $wiz_user_settings;
		
		do_action('after_get_cookie_data');
	
	}
	
}

wizard::init();
