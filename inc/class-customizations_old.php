<?php 
	
	class customizations {
		
		private static $instance;
		 
		public static function register() {
			if (self::$instance == null) {
				self::$instance = new customizations();
			}
		}
		
		
		
		function __construct (){
			
			add_filter ( 'wizard_set_data', array ( __CLASS__, 'store_customization' ) );
		}
		
		
		
		
		static function store_customization ( $data ) {
			
			
			//wp_die( var_dump(  $data ));
			// immissione diretta di data, anzichè dai cookie
			// ottengo i dati
			
			$stored_product_id = $data[ 'wizard_product_id' ];
			
			
			
			if (  $data['wizard_custom_end'] = false ){
				// la personalizzazione non è ancora completata (l'utente non ha messo nel basket il prodotto)
				
				if ( $data[ 'wizard_post_id' ]  ) {
				
					//La personalizzazione non è completata ma è iniziata
					// recupero quindi il post in modifica
					
					
					 
						$my_post = array(
						
							'ID' => $data[ 'wizard_post_id' ],
							'post_title'    => sprintf( __('Personalizzazione %d in modifica', 'plugin-domain'), $data[ 'wizard_post_id' ] ),
							'post_status'   => 'draft',
							'post_type'  => 'wiz_customization'
						);
					
						$post_id = wp_insert_post( $my_post);
						$data[ 'wizard_post_id' ] = $post_id;	
					
							foreach ( $data as $key => $field ) {
						
							update_post_meta($post_id, $key, $field);
							
							}
							
						
							$test = new wiz_img_handler();
		 				
						
						
						//echo $test->create_spazzolino_label ( $data );
		 				//echo $test->kitGenerateImage ();
		
						return $data;
						
				} else {
					// la presonalizzazione non è completata ne iniziata ()
					// si può generare un custom post che fornirà un id.
					
					$data[ 'wizard_custom_end' ] = false; // riporto l'indicatore in modifica
					
						$my_post = array(
							  'post_title'    => 'Nuova personalizzazione iniziata',
							  'post_status'   => 'draft',
							  'post_type'  => 'wiz_customization'
							);
					
						$post_id =	wp_insert_post( $my_post );	 
						
						$data[ 'wizard_post_id' ] = $post_id;
						
						
						
						
						foreach ( $data as $key => $field ) {
					
							update_post_meta($post_id, $key, $field);
						
						}
						
						return $data;
					
					
				}
				
				
			
			} else {
				// la personalizzazone è completata è possibile crearne una nuova
					
					
					
					$my_post = array(
						
					  	'post_title'    => __('Personalizzazione iniziata', 'plugin-domain'),
					  	'post_status'   => 'publish',
					  	'post_type'  	=> 'wiz_customization'
					);
					
					
				
					$post_id =	wp_insert_post( $my_post );	 
						
					
					
					foreach ( $data as $key => $field ) {
					
						update_post_meta($post_id, $key, $field);
						
					}
					
					$data[ 'wizard_post_id' ] = $post_id;
					
					$data[ 'wizard_custom_end' ] = false; // riporto l'indicatore in modifica
					
					return $data;
			}
			
			
			
		}
		
		
	
		
	}
	customizations::register();