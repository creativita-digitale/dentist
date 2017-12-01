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
	
	public function kitGenerateImage( $data = NULL , $retun = false ) {
		
		
		
		$catID = $data['wizard_cat_id'];
		
		$style = $data['wizard_background'];
		
		
		
		$base_dir =  new imagebuilder();
		$dir = $base_dir::IMAGE_DIR;
		$prefix = $base_dir::PREFIX;
		$path = $base_dir->get_image_dir ();		
		$img_name = $prefix . '_KIT_' . $data['wizard_post_id'] . '_' . $data['wizard_product_id']. '_' . date('Y-m-d') . '_' . mt_rand ( ); 	
		$data['wizard_image_id'] = $img_name;
		$img_name = $path . $dir.  $img_name;
		$width = 579; //pixel
		$height = 295;
		$image = new Imagick();		
		$image->setResolution(300,300);
		
			
		$pixel = new ImagickPixel('white');//background		
		$image->newImage( 579, 295 , $pixel);	
		
		//$bgImg = new Imagick(  get_stylesheet_directory() . '/img/sfondo'. $data['wizard_background'] . '.jpg' );
		
		//$image->compositeImage($bgImg, Imagick::COMPOSITE_DEFAULT, 0, 0);
		
		$draw = new ImagickDraw();
		$draw->setFont( $this->font );
		$draw->setFontSize(26);	
		$draw->setGravity(Imagick::GRAVITY_WEST);	
		
		
		$image->setFillColor('#007481');
		$image->annotateImage($draw, 200, -80, 0, $data[ 'wizard_fullname']);
		$image->annotateImage($draw, 200, -50, 0,  $data[ 'wizard_email']);
		
		
		$image->setFillColor('#3d4645');
		$image->annotateImage($draw, 200, -40, 0, $data[ 'wizard_tel']);
        $image->annotateImage($draw, 200, 30, 0, $data[ 'wizard_address']);
		
		$draw->setGravity(Imagick::GRAVITY_CENTER);	
		$image->setFillColor('#ffffff');
        $image->annotateImage($draw, 0, 120, 0, $data[ 'wizard_city_postcode']);
				
		$image->setImageUnits(1); ////0=undefined, 1=pixelsperInch, 2=PixelsPerCentimeter	
	
		$image->setImageFormat('jpg');
		$image->writeImage($img_name . '.jpg');
		
		if ( $return = true){
		
			return $data['wizard_image_id'];
		}
		
		
    }
	

}