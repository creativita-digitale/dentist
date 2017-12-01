<?php 


	
class wizard_steps {
	
	public $menu_name;
	public $menu_id;
	
	
	
	
	
	function __construct( $menu_name ){		
		$menu_exists = wp_get_nav_menu_object( $menu_name );
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu( $menu_name );	
		}		
	}
	
	function get_menu_id ( $menu_name ) {		
		$menu_name = wp_get_nav_menu_object( $menu_name );
		return $menu_name->term_id;
	}
	
	function get_menu_steps ( $menu_name ) {		
		$menu_name = wp_get_nav_menu_object( $menu_name );
		return $menu_name->count;
	}
	
	function add_menu_item ( $menu_id, $attr  ){
		wp_update_nav_menu_item($menu_id, 0, $attr );
	
	}
	
	function update_menu_item ( $menu_id, $item_id, $attr  ){
		wp_update_nav_menu_item($menu_id, $item_id, $attr );	
	}
	
	
	
}

/*

$steps = 'menusteps';
$attr = array(	
				'menu-item-title' =>  __('Test'),
				'menu-item-classes' => 'test',
				'menu-item-url' => home_url( '/' ), 
				'menu-item-status' => 'publish'
				);
				
$my_new_menu = new menu_handler ( $steps );
$menu_id = $my_new_menu->get_menu_id( $steps );
$menu_count = $my_new_menu->get_menu_steps( $steps );

Fb::info( $menu_id );
Fb::info( $menu_count );




$my_new_menu->add_menu_item ( $menu_id , $attr );

$attr = array(	
				'menu-item-title' =>  __('Alex'),
				'menu-item-classes' => 'alex',
				'menu-item-url' => home_url( '/' ), 
				'menu-item-status' => 'publish'
				);
$my_new_menu->edit_menu_item ( $menu_id, 230, $attr );

*/
