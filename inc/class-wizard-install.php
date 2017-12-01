<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Calls the class on the post edit screen.
 */
function call_someClass() {
    new wiz_install();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_someClass' );
    add_action( 'load-post-new.php', 'call_someClass' );
}






class wiz_install {
	
	public function __construct() {
		
	
		
	if ( apply_filters( 'woocommerce_show_addons_page', true ) ) {
			add_action( 'admin_menu', array( $this, 'test' ), 10 );
		}
	
		add_action( 'init', array( __CLASS__, 'wizard_create_configurations' ));

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		

		add_filter( 'manage_wiz_customization_posts_columns', array( __CLASS__, 'ST4_columns_head'),10 );
		add_action ( 'manage_wiz_customization_posts_custom_column', array( __CLASS__, 'ST4_columns_content'), 10, 2);
	}
	
	
	


function ST4_get_featured_image($post_ID) {
   
	$upload_dir = wp_upload_dir();
			 
			$base_dir = trailingslashit ( $upload_dir['baseurl'] );
			$custom_dir = 'WC_custom_work/';
			
	return 'hello';
				
}


function ST4_columns_head($defaults) {
    $defaults['featured_image'] = 'Featured Image';
    return $defaults;
}
 

function ST4_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
     
	 
			 $upload_dir = wp_upload_dir();
			 
			$base_dir = trailingslashit ( $upload_dir['baseurl'] );
			$custom_dir = 'WC_custom_work/';
			
			 if ( get_post_meta( $post_ID, 'wizard_image_id', true ) ) : ?>
   
        <img class="thumb" style=" height: 90px; width:auto" src="<?php echo esc_url( $base_dir . $custom_dir . get_post_meta( $post_ID, 'wizard_image_id', true ) ); ?>.jpg" alt="<?php the_title_attribute(); ?>" />
        
        <?php 
        endif;
    }
}

	
	
	public function test() {
		add_submenu_page( 'woocommerce', __( 'Customization', 'dentist' ),  __( 'Customizations', 'dentist' ) , 'manage_woocommerce', 'edit.php?post_type=wiz_customization' );
	}
	
	
	
	public function add_meta_box( $post_type ) {
            $post_types = array('wiz_customization');     //limit meta box to certain post types
            if ( in_array( $post_type, $post_types )) {
		add_meta_box(
			'some_meta_box_name'
			,__( 'Some Meta Box Headline', 'myplugin_textdomain' )
			,array( $this, 'render_meta_box_content' )
			,$post_type
			,'advanced'
			,'high'
		);
            }
	}
	
	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
	
		$lang = ( function_exists('icl_object_id') ) ? ICL_LANGUAGE_CODE : 'it';
    $options = get_option( $lang.'_axl_dentist_options' );
	
	
			  ?> <table width="100%" border="0">
			<tbody>
			<tr>
			<td width="50%">Personalizzazione attuale:</td>
			<td width="16%">Step corrente</td>
			<td width="34%"><?php echo get_post_meta( get_the_ID(), 'wizard_currentstep', true ) ?></td>
			</tr>
			<tr>
			<td rowspan="14">
			<?php
			
			$upload_dir = wp_upload_dir();
			 
			$base_dir = trailingslashit ( $upload_dir['baseurl'] );
			$custom_dir = 'WC_custom_work/';
			
			 if ( get_post_meta( get_the_ID(), 'wizard_image_id', true ) ) : ?>
   
        <img class="thumb" style="width:100%" src="<?php echo esc_url( $base_dir . $custom_dir . get_post_meta( get_the_ID(), 'wizard_image_id', true ) ); ?>.jpg" alt="<?php the_title_attribute(); ?>" />
    
<?php endif; ?>

<?php 
$id = get_post_meta( get_the_ID(), 'wizard_user_id', true );
if( $id ){
	$user_info = get_userdata($id);
      
	  
}
	 ?> 
			</td>
			<td>Utente</td>
			<td><?php  if( $id ){ echo '<a target="_blank" href="'. get_edit_user_link( $user_info->ID ) .'">'. esc_attr( $user_info->user_nicename ) .'</a>'; }else{ echo 'utente non registrato'; } ?> </td>
			</tr>
			
            <tr>
            <td>Prodotto modificato </td>
            <td><?php 
				
				$post_id =  get_post_meta( get_the_ID(), 'wizard_product_id', true );
				if ( $post_id && function_exists( 'wizard_wc_cat_link' ) ){						
					$post_data = get_post( $post_id ); 
					echo '<a target="_blank" href="'. get_permalink( $post_data->ID ) .'">'. esc_attr( $post_data->post_title ) .'</a>';
				}
			 ?> </td>
            </tr>
			
            <tr>
			<td>Categoria</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_cat_id', true ) ?></td>
			</tr>
            
			<tr>
			<td>Campo nome studio</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_email', true ) ?></td>
			</tr>
			
			<tr>
			<td> Campo Nome Cognome</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_fullname', true ) ?></td>
			</tr>
            
			<tr>
			<td>Campo Telefono / Email</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_tel_email', true ) ?></td>
			</tr>
			<tr>
			<td>Campo Telefono</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_tel', true ) ?></td>
			</tr>
			
			<tr>
			<td>Campo Indirizzo</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_address', true ) ?></td>
			</tr>
            <td>Campo Indirizzo 2</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_address_2', true ) ?></td>
			</tr>
			<tr>
			<td>Campo C.A.P.</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_city_postcode', true ) ?></td>
			</tr>
			<tr>
			<td>Campo Sfondo</td>
			<td><?php echo get_post_meta( get_the_ID(), 'wizard_background', true ) ?></td>
			</tr>
			<tr>
            <?php
			
			$spazzolini =  $options['tooth_id'];
			$kit =  $options['kit_id'];
			
			switch ( get_post_meta( get_the_ID(), 'wizard_cat_id', true ) ) {
				
				case $spazzolini:
				// DO 
				$ext = 'tiff';
				break;
				
				case $kit:
				// DO 
				$ext = 'jpg';
				break;
			
			}
			?>
            
<td colspan="2"><a download class="button button-primary button-large" href="<?php echo esc_url( $base_dir . $custom_dir . get_post_meta( get_the_ID(), 'wizard_image_id', true ) ); ?>.<?php echo $ext ?>" target="_blank">scarica file</a></td>
</tr>
	
			
			</tbody>
			</table> <?php ;
		}




static function wizard_create_configurations() {

	$labels = array(
		'name'                  => _x( 'Customizations', 'Post Type General Name', 'dentist' ),
		'singular_name'         => _x( 'Customization', 'Post Type Singular Name', 'dentist' ),
		'menu_name'             => __( 'Customization', 'dentist' ),
		'name_admin_bar'        => __( 'Customization', 'dentist' ),
		'parent_item_colon'     => __( 'Parent Customization:', 'dentist' ),
		'all_items'             => __( 'All Customizations', 'dentist' ),
		'add_new_item'          => __( 'Add New Customization', 'dentist' ),
		'add_new'               => __( 'Add New', 'dentist' ),
		'new_item'              => __( 'New Customization', 'dentist' ),
		'edit_item'             => __( 'Edit Customization', 'dentist' ),
		'update_item'           => __( 'Update Customization', 'dentist' ),
		'view_item'             => __( 'View Customization', 'dentist' ),
		'search_items'          => __( 'Search Customization', 'dentist' ),
		'not_found'             => __( 'Not found', 'dentist' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'dentist' ),
		'items_list'            => __( 'Customizations list', 'dentist' ),
		'items_list_navigation' => __( 'Items Customization navigation', 'dentist' ),
		'filter_items_list'     => __( 'Filter Customizations list', 'dentist' ),
	);
	$args = array(
		'label'                 => __( 'Customization', 'dentist' ),
		'description'           => __( 'Customization of products', 'dentist' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'comments', 'custom-fields'),
		
	
		
		'show_in_menu'          => current_user_can( 'manage_woocommerce' ) ? 'woocommerce' : true,
		
		'show_in_admin_bar'     => false,
		
		'can_export'            => true,
		
		
		
		
		'capability_type'       => 'page',
	
					'public'              => false,
					'show_ui'             => true,
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'show_in_nav_menus'   => false,
					'rewrite'             => false,
					'query_var'           => false,
					'has_archive'         => false,
	);
	register_post_type( 'wiz_customization', $args );

}
}
$install = new wiz_install;

//Fb::info ( $test->get_cookie_data() );