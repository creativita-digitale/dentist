<?php 
	
	class customizations {
		
		private static $instance;
		 
		public static function register() {
			if (self::$instance == null) {
				self::$instance = new customizations();
			}
		}
		
		
		
		function __construct (){
			
			//add_filter ( 'wizard_set_data', array ( __CLASS__, 'store_customization' ) );
		}
		
		
		static function complete_customization ( $data ) {
			
			$my_post = array(
				'ID' => $data[ 'wizard_post_id' ],
				'post_title'    => sprintf( __('Personalizzazione %d completata', 'plugin-domain'), $data[ 'wizard_post_id' ] ),
				'post_status'   => 'publish',
				'post_type'  => 'wiz_customization'
						);
					
			$post_id = wp_insert_post( $my_post);
			
			// imposto l'indicatore a zero e scrivo un altro post
				
			foreach ( $data as $key => $field ) {
					
							update_post_meta($post_id, $key, $field);
						
						}
			
			
			return $data;
		
		}
		
		static function start_customization ( $data ) {
			$data['wizard_post_id'] = false;
			$my_post = array(
						
					  	'post_title'    => __('Personalizzazione iniziata', 'plugin-domain'),
					  	'post_status'   => 'publish',
					  	'post_type'  	=> 'wiz_customization'
					);
					
					
				
					$post_id =	wp_insert_post( $my_post );	 
					
					$data['wizard_post_id'] = $post_id ;
					
					foreach ( $data as $key => $field ) {
					
							update_post_meta($post_id, $key, $field);
						
						}
			
			return $data;
		
		}
		
		static function edit_customization ( $data ) {
			
			$my_post = array(
						
							'ID' => $data[ 'wizard_post_id' ],
							'post_title'    => sprintf( __('Personalizzazione %d in modifica', 'plugin-domain'), $data[ 'wizard_post_id' ] ),
							'post_status'   => 'publish',
							'post_type'  => 'wiz_customization'
						);
					
						$post_id = wp_insert_post( $my_post);
						
						
						foreach ( $data as $key => $field ) {
					
							update_post_meta($post_id, $key, $field);
						
						}
			
			return $data;
		
		}
		
		
		static function store_customization ( $data ) {
			
			
			$my_post = array(
						
					  	'post_title'    => __('Personalizzazione iniziata', 'plugin-domain'),
					  	'post_status'   => 'draft',
					  	'post_type'  	=> 'wiz_customization'
					);
					
					
				
					$post_id =	wp_insert_post( $my_post );	 
					
					$data['wizard_post_id'] = $post_id ;
					
					foreach ( $data as $key => $field ) {
					
							update_post_meta($post_id, $key, $field);
						
						}
			
			return $data;
		
			
		
		}
		
		
	
		
	}
	customizations::register();