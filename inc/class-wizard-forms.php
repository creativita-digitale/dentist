<?php
if (class_exists('WC_Countries')){
class wizard_forms extends WC_Countries {
	/**
	 * Returns the fields we show by default. This can be filtered later on.
	 * @return array
	 */
	public function get_default_cookie_fields() {
		$fields = array(
			'wizard_currentstep' => array(
				'label'    => __( 'Current step', 'scdentist' ),
				'required' => true,				
			),
			'wizard_user_id' => array(
				'label'    => __( 'User id', 'scdentist' ),
				'required' => true,
			),
			'wizard_product_id' => array(
				'label'    => __( 'Product id', 'scdentist' ),
				'required' => true,
			),
			'wizard_cat_id' => array(
				'label'    => __( 'Cat id', 'scdentist' ),
				'required' => true,
			),
			'wizard_image_id' => array(
				'label'    => __( 'Image id', 'scdentist' ),
				'required' => true,
			),
			
		);

		return apply_filters( 'scdentist_default_cookie_fields', $fields );
	}
	
	public function get_default_spazzolino_fields() {
		$fields = array(
			'wizard_fullname' => array(
				'label'    => __( 'Name and surname', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_tel_email' => array(
				'label'    => __( 'Telphone or e-mail', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			
		);

		return apply_filters( 'scdentist_default_spazzolino_fields', $fields );
	}
	
	public function get_default_kit_fields() {
		$fields = array(
			'wizard_fullname' => array(
				'label'    => __( 'Name and surname', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_tel' => array(
				'label'    => __( 'Telephone', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_email' => array(
				'label'    => __( 'Email', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_address' => array(
				'label'    => __( 'Address', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_address_2' => array(
				'label'    => __( 'Address', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_city_postcode' => array(
				'label'    => __( 'City - Postcode', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_background' => array(
				'label'    => __( 'Image background', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			
		);

		return apply_filters( 'scdentist_default_kit_fields', $fields );
	}

public function get_default_scovolini_fields() {
		$fields = array(
			'wizard_scovolini_quantita_ultra_fine' => array(
				'label'    => __( 'Quantity Ultra Fine Interdental Brushes', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_scovolini_quantita_fine' => array(
				'label'    => __( 'Quantity Fine Interdental Brushes', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_scovolini_quantita_medium' => array(
				'label'    => __( 'Quantity Medium Interdental Brushes', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_scovolini_quantita_large' => array(
				'label'    => __( 'Quantity Large Interdental Brushes', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			'wizard_scovolini_quantita_extra_large' => array(
				'label'    => __( 'Quantity Extra Large Interdental Brushes', 'scdentist' ),
				'required' => true,
				'class'    => array( 'form-row-first' ),
			),
			
		);

		return apply_filters( 'scdentist_default_kit_fields', $fields );
	}


}
}
