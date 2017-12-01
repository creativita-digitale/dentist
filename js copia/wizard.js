// JavaScript Document
jQuery(function($) {
  
  // First part: wizard menu steps
  var wizard_menu = $( "#wizard-wrapper ul li" )
  var current_menu = $( '#wizard-wrapper ul li.current-menu-item' );
  var wizard_menu_lenght = wizard_menu.length;
 

  $( wizard_menu ).each(function( index, element ) {
	
	var link = $( element ).find('a').attr('href');
	$( element ).addClass( 'active' );
	$( this ).css( 'cursor', 'pointer');
	if ( $( this ).is( current_menu ) ) {
      return false;
    }
	$( element ).click(function() {
	 window.location = link;
  
	});
	 
   }); 
    
 //third part: equal steps
 var ratio = (100 / wizard_menu_lenght) + '%';
 $( wizard_menu ).css( 'width', ratio);


 $( wizard_menu ).not( '.active' ).find('a').removeAttr( 'href' ).prop( "onclick", null );
  

  
});
jQuery(document).ready(function($){
	setTimeout(function(){
  		//modal.open({content: "Hows it going?"});
					}, 2000);	
			});