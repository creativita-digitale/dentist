<?php


function _remove_script_version( $src ){

	$parts = explode( '?ver', $src );
	return $parts[0];

}
//add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
//add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


// get taxonomy link by id
function get_tax_link ($term_slug, $taxonomy) { 

	$tax = get_terms( $taxonomy );
	
	return $terms;
	foreach ( $terms as $term ) {
		if($term['slug'] == $term_slug)
		$term_link = get_term_link( $term , $taxonomy);
		if ( is_wp_error( $term_link ) ) {
			continue;
		}
		return esc_url( $term_link );
	}
}


// read the cookie and extract data
function config_cookie_array () {
	$product_config_cookie = $_COOKIE[ 'product_config' ];
	
	if ( ! empty( $product_config_cookie ) ) {	
		$product_config_array = explode( '|', wp_unslash( $product_config_cookie ) );
		return $product_config_array;
		
	}
}

function config_cookie_array_image () {
	$temp_array = config_cookie_array();	
	return $temp_array[2];
}

add_action('storefront_header','pulsante_magico', 100);
function pulsante_magico() {
	?>
	<div id="magicbutton">
	
	<?php 
	$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';   
    $options = get_option( $lang.'_axl_dentist_options' );
    $cutomizer_id = $options['cutomizer_id'];
	
	$genre_url = add_query_arg('utm_source', 'magic_b', get_permalink( $cutomizer_id ));
	 
	 ?>
	
	<a href="<?php echo $genre_url ?>">
	<span id ="arrow"><i class="fa fa-caret-right"></i></span>
	<span id ="description">
		<span id="text1"><?php _e('Customize products','scdentist'); ?></span>
		<span id="text2"><?php _e('Start here','scdentist'); ?></span>
	</span>	
	</a>
	</div>
	<?php
}

add_action('storefront_before_header','price_advice', 100);

function price_advice(){
?>
<div id="priceadvisory" class="bg-info"> 
	<div class="container">
    	
    	<p><?php  _e('Total minimum order € 300.00', 'scdentist' ); ?></p>
     </div>   
      
</div> 
<?php
}