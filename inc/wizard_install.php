<?php

class wiz_install {
	static function init(){
	
		add_action( 'init', array( __CLASS__, 'wizard_create_configurations' ));

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
		'supports'              => array( ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => false,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'wiz_customization', $args );

}
}
wiz_install::init();
//Fb::info ( $test->get_cookie_data() );