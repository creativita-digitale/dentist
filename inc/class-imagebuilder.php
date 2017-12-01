<?php

class imagebuilder{
	
	public $image_raw;
	public $image_name;
	public $image_data;
	
	const PREFIX = 'img';
	const IMAGE_DIR = 'WC_custom_work/';
	
	function __construct ( $image = NULL ){
	
		//$this->image_raw = $image;
		//$this->image_js_to_php();
		//$this->image_register();
	}
	
	function image_js_to_php () {
	//wp_die ( $this->image );
		//Get the base-64 string from data
			$filteredData = substr( $this->image_raw, strpos( $this->image_raw, ",")+1);			 
			//Decode the string
			$this->image_raw = base64_decode( $filteredData );
	}
	
	function get_image_dir () {
	
			$upload_dir = wp_upload_dir();			 
			$base_dir = trailingslashit ( $upload_dir['basedir'] );	
			return $base_dir;
			
	}
	
	function get_image_dir_url () {
	
			$upload_dir = wp_upload_dir();			 
			$base_dir = trailingslashit ( $upload_dir['baseurl'] );	
			return $base_dir;
			
	}
	
	function image_register () {
			 
			$base_dir = $this->get_image_dir ();	
			
			$custom_name = tempnam ( $base_dir . self::IMAGE_DIR , self::PREFIX );
			$file_name_path =  $custom_name . '.jpg';
	
			$file_lenght = file_put_contents( $file_name_path , $this->image_raw);
	
			$this->image_data = wp_get_image_editor( $file_name_path );
			
			$this->image_name = basename ( $file_name_path );
			
	}
	
	function image_save () {
		if ( ! is_wp_error( $this->image_data ) ) {
		
		$filename = $this->image_data->generate_filename( NULL, $base_dir = $this->get_image_dir () );
		
		$this->image_data->save( $filename );
		
		}
	}
	
	
	function get_image_name () {
		//wp_die($this->image_name);
			
			return $this->image_name ;
			
	}
}