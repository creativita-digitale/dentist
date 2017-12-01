// JavaScript Document

jQuery(function($) {
	"use strict";
	$('html').find( 'select#wizard_background' ).imagepicker();
});

jQuery(document).ajaxComplete(function(){
    // fire when any Ajax requests complete
	"use strict";
	jQuery( 'select.image-picker' ).imagepicker();
});