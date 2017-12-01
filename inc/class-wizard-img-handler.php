<?php

class wiz_img_handler {
	
	
	private $font;
	private $width;
	private $height;
	
	private $kit_id = 11;
	private $spazzolini_id = 7;
	
	private $style;
	
	
	
	function __construct(){
		$this->font =  get_stylesheet_directory() . '/fonts/arial_bold.ttf';
		
	}
	
	public function create_spazzolino_label ($data = NULL , $retun = false) {
	
		define("LEFT", 1);
		define("CENTER", 2);
		define("RIGHT", 3);
		
		
		$catID = $data['wizard_cat_id'];
		
		$base_dir =  new imagebuilder();
		$dir = $base_dir::IMAGE_DIR;
		$prefix = $base_dir::PREFIX;
		$path = $base_dir->get_image_dir ();		
		//$img_name = $prefix . '_SPAZZOLINO_' . $data['wizard_post_id'] . '_' . $data['wizard_product_id']. '_' . date('Y-m-d') . '_' . mt_rand ( ); 
		$img_name = $prefix . '_SPAZZOLINO_' . $data['wizard_post_id'] . '_' . $data['wizard_product_id']. '_' . date('Y-m-d') . '_' . mt_rand ( ); 
			
		$data['wizard_image_id'] = $img_name;
		$img_name = $path . $dir.  $img_name;
		
		$image = new Imagick();		
		$image->setResolution(240,240);	
		$pixel = new ImagickPixel('white');//background		
		$image->newImage( 1008, 168 , $pixel);	
		$draw = new ImagickDraw();
		$draw->setFont( $this->font );
		$draw->setFontSize(54);	
		$draw->setGravity(Imagick::GRAVITY_CENTER);	
		$image->annotateImage($draw, 0, -40, 0, $data[ 'wizard_fullname']);
		$image->annotateImage($draw, 0, 30, 0,  $data[ 'wizard_tel_email']);		
		$image->setImageUnits(2); ////0=undefined, 1=pixelsperInch, 2=PixelsPerCentimeter	
		$image->setImageType(imagick::IMGTYPE_BILEVEL); //bitmap-> ESPLICITA RICHIESTA DEL CLIENTE!	
		$image->setImageFormat('tiff');//ESPLICITA RICHIESTA DEL CLIENTE!	
		 $image->writeImage(  $img_name. '.tiff' );	
		$image->setImageFormat('jpg');
		$image->writeImage($img_name . '.jpg');
		
		if ( $return = true){
		
			return $data['wizard_image_id'];
		}
	}
	
	public function kitGenerateImage( $data = NULL , $retun = false , $echo = false) {
		
		define("LEFT", 1);
		define("CENTER", 2);
		define("RIGHT", 3);
		
		$catID = $data['wizard_cat_id'];		
		$style = $data['wizard_background'];
		$base_dir =  new imagebuilder();
		$dir = $base_dir::IMAGE_DIR;
		$prefix = $base_dir::PREFIX;
		$path = $base_dir->get_image_dir ();		
		
		$img_name = $prefix . '_KIT_' . $data['wizard_post_id'] . '_' . $data['wizard_product_id']. '_' . date('Y-m-d') . '_' . mt_rand ( );
		
		//$img_name = $prefix . '_KIT_';
		
		$data['wizard_image_id'] = $img_name;
		$img_name = $path . $dir.  $img_name;
		$width = 579; //pixel
		$height = 295;
		$image = new Imagick();		
		$image->setResolution(300,300);
		
			
		$pixel = new ImagickPixel('white');//background		
		$image->newImage( 579, 295 , $pixel); 	
		
		$bgImg = new Imagick(  get_stylesheet_directory() . '/img/sfondo'. $data['wizard_background'] . '.jpg' );
		
		
		
		$image->compositeImage($bgImg, Imagick::COMPOSITE_DEFAULT, 0, 0);
		
		$draw = new ImagickDraw();
		
		switch ($data['wizard_background']) {
		
		 case 3:
		 	$fillColorTitle = 'rgb(34, 135, 146)';
			$fillColorBody = 'rgb(77, 88, 90)';
			$fillColorFooter = 'rgb(255, 255, 255)';
			$gravity = Imagick::GRAVITY_CENTER;
			break;
		
		case 4:
		 	$fillColorTitle = 'rgb(0, 132, 184)';
			$fillColorBody = 'rgb(0, 132, 184)';
			$fillColorFooter = 'rgb(255, 255, 255)';
			$gravity = Imagick::GRAVITY_CENTER;
			break;
		
		case 5:
		 	$fillColorTitle = 'rgb(57, 181, 74)';
			$fillColorBody = 'rgb(77, 88, 90)';
			$fillColorFooter = 'rgb(255, 255, 255)';
			$gravity = Imagick::GRAVITY_CENTER;
			break;
		
		case 6:
		 	$fillColorTitle = 'rgb(14, 118, 188)';
			$fillColorBody = 'rgb(77, 88, 90)';
			$fillColorFooter = 'rgb(255, 255, 255)';
			$gravity = Imagick::GRAVITY_CENTER;
			break;
		
		case 7:
		 	$fillColorTitle = 'rgb(50, 52, 125)';
			$fillColorBody = 'rgb(14, 118, 188)';
			$fillColorFooter = 'rgb(255, 255, 255)';
			$gravity = Imagick::GRAVITY_CENTER;
			break;
			
		case 10:
		 	$fillColorTitle = 'rgb(50, 52, 125)';
			$fillColorBody = 'rgb(236, 0, 140)';
			$fillColorFooter = 'rgb(46, 49, 146)';
			$gravity = Imagick::GRAVITY_CENTER;
			break;
		}
		
		
		
		
		$draw->setFontSize(8);
		$draw->setFontStretch(Imagick::STRETCH_ULTRACONDENSED);
		
		$draw->setFillColor($fillColorTitle);
		
		$draw->annotation(198, 72, $data[ 'wizard_email']);
		$draw->annotation(198, 118,  $data[ 'wizard_fullname']);
		
		
		$draw->setFillColor($fillColorBody);
		
		$draw->annotation(198, 170,  $data[ 'wizard_tel']);
		
		$draw->setFontSize(6);
		
		$draw->annotation(198, 200,  $data[ 'wizard_address']);
		$draw->annotation(198, 225,  $data[ 'wizard_address_2']);
		
		
		$draw->setFillColor($fillColorFooter);
		$draw->setGravity($gravity);	
		
		$draw->annotation(0, 124,  $data[ 'wizard_city_postcode']);
		
		
		
		//$image->setFillColor("rgb(0, 116, 129)");
		$image->drawImage($draw);
		
		
		
		
		$image->setImageFormat('jpg');
		$image->writeImage($img_name . '.jpg');
		
		if ( $return = true){
		
			return $data['wizard_image_id'];
		}
		
		
    }
	

}