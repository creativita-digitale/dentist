<?php 
class wizard_log {
	
	function __construct (){
	
	add_action ('wp_head', array (__CLASS__, 'create_log'));
	
	}	
	
	
	function create_log ($log = NULL){
	
	
		$logger ='<div id="logger" style="width:100%; position:fixed; height:200px; z-index:999999999; bottom:0; left:0; background:rgba(0,0,0,.5)">';
		$logger .=  apply_filters( 'addlog', $logger, $log);
		$logger .= '</div>';
		echo $logger;
	}
	
	function add_log($log) {
		
		add_filter( 'addlog', array( $this, function( $log ) {  return 'hello'; } ) );
	
	}
	
	
}
