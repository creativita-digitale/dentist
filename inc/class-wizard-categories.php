<?php
class wizard_categores {
	 /**
   * 
   * @var Singleton
   */
   
  
  
 private $titan ;
 private $lang = ICL_LANGUAGE_CODE;
 
 
 // kit_id
 // tooth_id
 // box_id
 
 public static function get_dentist_option( $key ){ 
    
 	$options = get_option( $lang.'_axl_dentist_options'  );
    $option_value = $options['cutomizer_id'];
	return $option_value;
	
 }
 
  public static $fields = array(
			'spazzolini' => array(
				
					'id'    => 7,
					'slug' 	=> 'spazzolini',
					'img'	=> 'spazzolino_2.jpg',
					
					'sensitive' => array ( 
						'wire' 		=> 'spazzolino_2.jpg' ,
						'product' 	=> 'base_spazzolino_1-0.jpg' ,
						'package'	=> 'spazzolino_2.jpg' ,
						),
					'ortodontic' => array ( 
						'wire' 		=> 'spazzolino_2.jpg' ,
						'product' 	=> 'base_spazzolino_2.jpg' ,
						'package'	=> 'spazzolino_2.jpg' ,
						),
					'complete' => array ( 
						'wire' 		=> 'spazzolino_2.jpg' ,
						'product' 	=> 'base_spazzolino_3.jpg' ,
						'package'	=> 'spazzolino_2.jpg' ,
						),
					'compact' => array ( 
						'wire' 		=> 'spazzolino_2.jpg' ,
						'product' 	=> 'base_spazzolino_4.jpg' ,
						'package'	=> 'spazzolino_2.jpg' ,
						),		
					
				),
			'kit' => array(
				'id'    => 11,
				'slug' => 'kit',
				'img' => 'bg_box_3.jpg'
			),
			'scovolini' => array(
				'id'    => 16,
				'slug' => 'scovolini',
				'img' => 'bg_box_3.jpg'
			),
			
		);
		
	public static $steps = array(
			'step1' => array( '
				id' => 24, 
				'name' =>'Personalizzazione'
			),
			'step2' => array( 'id' => 15, 'name' =>''),
			'step3' => array( 'id' => 15, 'name' =>''),
			
		);
  
  
  
  

	
	public static function get_spazzolino_id() {
		return self::$fields;
	}
	
}

