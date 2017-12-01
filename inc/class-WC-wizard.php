<?php 
if (class_exists('WC_Form_Handler')){
class WC_wizard extends WC_Form_Handler {
	/**
	 * Hook in methods
	 */
	public static function init() {
		//add_action( 'woocommerce_add_to_cart_validation', array( __CLASS__, 'wizard_cart_no_config' ), 1, 3 );
		//add_action( 'woocommerce_add_to_cart_validation', array( __CLASS__, 'wizard_cart_no_match' ), 1, 3 );
		add_action( 'woocommerce_add_to_cart', array( __CLASS__, 'add_product' ), 10, 6 );
		add_action( 'template_redirect', array( __CLASS__, 'customize_spazzolino' ) );
		//add_action( 'template_redirect', array( __CLASS__, 'alert_new_product' ) );
		add_action( 'template_redirect', array( __CLASS__, 'choose_sartoria' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'wizard_login' ), 20 );
		
		
		
	
	}
	
	

	
	
	

	static function wizard_cart_no_config( $passed, $product_id, $quantity) {
	
		$data = current_wizard_data_array();
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    	$options = get_option( $lang.'_axl_dentist_options' );
	
		// Check if the quantity is less then our minimum
		if ( ! $data[ 'wizard_fullname' ] ) {
			
			$link = get_permalink( wizard_categores::$steps['step1']['id'] );
		
			wc_add_notice( sprintf( __( 'Non è possibile acquistare il seguente prodotto senza personalizzazione. Per personalizzarlo fai <a href="%s">click qui</a>.', "your-theme-language" ), $link  ) ,'error' );
			
			$data['wizard_cat_id'] = false ;
			
		} else {
			return true;
		}
	}

	static function wizard_cart_no_match( $passed, $product_id, $quantity) {
		$data = current_wizard_data_array();
		$product_cart_cat = wizard_wc_cat_id ( $product_id );
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    $options = get_option( $lang.'_axl_dentist_options' );
		
		if ( $product_cart_cat !=  $data[ 'wizard_cat_id' ] ) {
			
			$link = get_permalink( wizard_categores::$steps['step1']['id'] );
		
			wc_add_notice( sprintf( __('La personalizzazione creata non può essere associata a questo prodotto. Torna alle modifiche <a href="%s">tramite questo link</a>, e scegli una tipologia di versa.', 'plugin-domain'), $link ) , $notice_type = 'error' ) ;
			
			
		} else {
			return true;
		}
	}

	public static function add_product( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
					
			//if ( $product_id =  $data[ 'wizard_product_id' ] ){
				$data[ 'wizard_currentstep' ] = '3';
				$data[ 'wizard_product_id' ] = $product_id;
				$data[ 'wizard_custom_end' ] = true;
				
				$wizard = new wizard;
				
				$wizard->set_cookie_data ( $data  ) ;
				
				
				
 
			//}
	}
	
	
	
	function alert_new_product (){
		global $product;
		$current_id = $product->id;
		
		$data = current_wizard_data_array();
		
		if ( $data['wizard_product_id'] != $current_id  ){
			
		
			
		}
		
	
	}
	
	

	/**
	 * Save and and update a billing or shipping address if the
	 * form was submitted through the user account page.
	 */
	public static function customize_spazzolino() {
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    	$options = get_option( $lang.'_axl_dentist_options' );
	
		global $wp;	
		if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
			return;
		}
		if ( empty( $_POST[ 'action' ] ) || 'customize_spazzolino' !== $_POST[ 'action' ] || empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-customize_spazzolino' ) ) {
			return;
		}
		
		
		
		$user_id = get_current_user_id();
		
		
		$image = new imagebuilder ( $_POST['image_data'] );
			
			
			
		

		$load_address = isset( $wp->query_vars['edit-address'] ) ? wc_edit_address_i18n( sanitize_title( $wp->query_vars['edit-address'] ), true ) : 'billing';
		
		
		$is_spazzolini = ( current_wizard_cat () == $options['tooth_id'] ? true : false);
		$is_kit = ( current_wizard_cat () == $options['kit_id'] ? true : false);
		
		//carico i forms per pubblicarli nella pagina
		
		$default_form = new wizard_forms;
		( $is_spazzolini ) ? $address = $default_form->get_default_spazzolino_fields() : $address = $default_form->get_default_kit_fields();
		
		//ottengo e sanitizzo i darti del form
		foreach ( $address as $key => $field ) {

			if ( ! isset( $field['type'] ) ) {
				$field['type'] = 'text';
			}

			// Get Value
			switch ( $field['type'] ) {
				case "checkbox" :
					$_POST[ $key ] = isset( $_POST[ $key ] ) ? 1 : 0;
				break;
				default :
					$_POST[ $key ] = isset( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : '';
				break;
			}

			// Hook to allow modification of value
			$_POST[ $key ] = apply_filters( 'woocommerce_process_myaccount_field_' . $key, $_POST[ $key ] );

			// Validation: Required fields
			if ( ! empty( $field['required'] ) && empty( $_POST[ $key ] ) ) {
				wc_add_notice( $field['label'] . ' ' . __( 'is a required field.', 'woocommerce' ), 'error' );
			}

			if ( ! empty( $_POST[ $key ] ) ) {

				// Validation rules
				if ( ! empty( $field['validate'] ) && is_array( $field['validate'] ) ) {
					foreach ( $field['validate'] as $rule ) {
						switch ( $rule ) {
							case 'postcode' :
								$_POST[ $key ] = strtoupper( str_replace( ' ', '', $_POST[ $key ] ) );

								if ( ! WC_Validation::is_postcode( $_POST[ $key ], $_POST[ $load_address . '_country' ] ) ) {
									wc_add_notice( __( 'Please enter a valid postcode/ZIP.', 'woocommerce' ), 'error' );
								} else {
									$_POST[ $key ] = wc_format_postcode( $_POST[ $key ], $_POST[ $load_address . '_country' ] );
								}
							break;
							case 'phone' :
								$_POST[ $key ] = wc_format_phone_number( $_POST[ $key ] );

								if ( ! WC_Validation::is_phone( $_POST[ $key ] ) ) {
									wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not a valid phone number.', 'woocommerce' ), 'error' );
								}
							break;
							case 'email' :
								$_POST[ $key ] = strtolower( $_POST[ $key ] );

								if ( ! is_email( $_POST[ $key ] ) ) {
									wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not a valid email address.', 'woocommerce' ), 'error' );
								}
							break;
						}
					}
				}
			}
		}
		
		
		
		if ( wc_notice_count( 'error' ) == 0 ) {

			foreach ( $address as $key => $field ) {
				
				// aggiungo i dati all'utente
				get_current_user_id() ? update_user_meta( $user_id, $key, $_POST[ $key ] ) : 0;
				
				// salvo i dati per un prossimo utilizzo
				$data[ $key ] = $_POST[ $key ];
			}
			
			//do_action( 'wizard_customized_image', $data);
			//$image->image_save();
		
			$data[ 'wizard_currentstep' ] = '2';
			//$data[ 'wizard_image_id' ] = $image->get_image_name();
			$data[ 'wizard_user_id' ] =  ( get_current_user_id() ? get_current_user_id() : false);
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;
				 
	
			if ( $is_spazzolini ){
				
				wp_safe_redirect( wizard_wc_cat_link ( wizard_categores::$fields['spazzolini']['slug'] ) );
			
			
			} elseif ($is_kit ){		
				wp_safe_redirect( wizard_wc_cat_link ( wizard_categores::$fields['kit']['slug'] ) );
			}

			
			
			
			
			exit;
		}
	}
	
	
	public static function choose_sartoria() {
		
		global $wp;

		if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
			return;
		}

		if ( empty( $_POST[ 'action' ] ) || 'choose_sartoria' !== $_POST[ 'action' ] || empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-choose_sartoria' ) ) {
			return;
		}

		if ( wc_notice_count( 'error' ) == 0 ) {
			// avviso l'utente quale categoria ha scelto
			//$value = $_POST['product_opt'];
			$current_category = get_term_by( 'id', $_POST['product_opt'], 'product_cat' );
			
			wc_add_notice( sprintf( __('You have chosen to customize the  %d category', 'scdentist'),  $current_category->name ) );
			
			

			// registro le prime informazioni e inizializzo $data;

			$data[ 'wizard_currentstep' ] = '1';
			$data[ 'wizard_user_id' ] =  ( get_current_user_id() ? get_current_user_id() : false);
			$data[ 'wizard_cat_id' ] = 	( $_POST['product_opt'] ? $_POST['product_opt'] : false) ;
			
			// salvo i dati
			
			$wizard = new wizard;
			$wizard->set_cookie_data ( $data  ) ;
				
			wp_safe_redirect( get_permalink( wizard_categores::$steps['step2']['id'] ) );
			
			exit;
		}
	}
	
	public static function wizard_login() {
		if ( ! empty( $_POST['login'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'wizard-login' ) ) {

			try {
				$creds  = array();

				$validation_error = new WP_Error();
				$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $_POST['username'], $_POST['password'] );

				if ( $validation_error->get_error_code() ) {
					throw new Exception( '<strong>' . __( 'Error', 'woocommerce' ) . ':</strong> ' . $validation_error->get_error_message() );
				}

				if ( empty( $_POST['username'] ) ) {
					throw new Exception( '<strong>' . __( 'Error', 'woocommerce' ) . ':</strong> ' . __( 'Username is required.', 'woocommerce' ) );
				}

				if ( empty( $_POST['password'] ) ) {
					throw new Exception( '<strong>' . __( 'Error', 'woocommerce' ) . ':</strong> ' . __( 'Password is required.', 'woocommerce' ) );
				}

				if ( is_email( $_POST['username'] ) && apply_filters( 'woocommerce_get_username_from_email', true ) ) {
					$user = get_user_by( 'email', $_POST['username'] );

					if ( isset( $user->user_login ) ) {
						$creds['user_login'] 	= $user->user_login;
					} else {
						throw new Exception( '<strong>' . __( 'Error', 'woocommerce' ) . ':</strong> ' . __( 'A user could not be found with this email address.', 'woocommerce' ) );
					}

				} else {
					$creds['user_login'] 	= $_POST['username'];
				}

				$creds['user_password'] = $_POST['password'];
				$creds['remember']      = isset( $_POST['rememberme'] );
				$secure_cookie          = is_ssl() ? true : false;
				$user                   = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), $secure_cookie );

				if ( is_wp_error( $user ) ) {
					$message = $user->get_error_message();
					$message = str_replace( '<strong>' . esc_html( $creds['user_login'] ) . '</strong>', '<strong>' . esc_html( $_POST['username'] ) . '</strong>', $message );
					throw new Exception( $message );
				} else {

					
						$redirect = get_permalink(24);
					

					// Feedback
					wc_add_notice( sprintf( __( 'You are now logged in as <strong>%s</strong>', 'woocommerce' ), $user->display_name ) );

					wp_redirect( apply_filters( 'woocommerce_login_redirect', $redirect, $user ) );
					exit;
				}

			} catch (Exception $e) {

				wc_add_notice( apply_filters('login_errors', $e->getMessage() ), 'error' );

			}
		}
	}

}
WC_wizard::init();
}