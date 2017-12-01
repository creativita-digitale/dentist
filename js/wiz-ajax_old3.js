jQuery(function($) {
    'use strict';
    var wiz_ajax = {
		
		
        callUrl: setup.ajax_url,
        cookieName: setup.cookie_name,
        defaultSettings: setup.user_settings,
        defaultSpazzoliniID: setup.spazzolini_id,
        defaultKitID: setup.kit_id,
        post: Object,
        prodID: '',
        catID: '',
        productItem: '',
        formData: '',
        fieldsData: '',
        returnedEditorData: '',
        productHTML: '',
        prodImg: '',
        cookieContent: Array,
		preloadedImages: Array,
        modal: '',
        init: function() {
            try {
  
                this.form = $('form#wiz-config');
                this.getProducts = $('#mi-slider');
                this.getCategory = $('#mi-slider').find('nav > a');
                this.getEditorBtn = $('#custom-section #submitBtn');
                this.getEditorFields = $('#custom-section input,  #custom-section textarea, #custom-section select');
                this.prodSubmit = $('#prodSubmit');
              
                this.productSelectDom = $('#cat_opt');
                this.modal = $('#confirm-submit');
				this.summary = $('.summary-wiz');
				
				//wiz_ajax.listeners();
				wiz_ajax.onDocumentReady();
				wiz_ajax.onProductChange();
				wiz_ajax.onCategoryChange();
				wiz_ajax.onEditorSubmit();
				wiz_ajax.onEditorUpdate();
					
              
            } catch (e) {
               if ( typeof console !== 'undefined' && console.error ) {
                console.log(e);
				}
            }
        },
        
		/*
		 *
		 * Initial Listeners
		 *
		 *
		*/
        onDocumentReady: function() {
          //  this.wizDocument.ajaxSuccess(function(){ alert('onAjax');});        
        	$(document).ready(
				function(){ 
					if ( typeof console !== 'undefined' && console.error ) {
					console.log('Document Ready');
					
					}
				}
			);  
			 /*
		   * 1 Carico l'id del cookie
		   * 3 carico il form adeguato
		   * 4 aggiorno l'immagine sull'editor
		   * 5 imposto il modal corretto
		   */  
		   
		  
		   wiz_ajax.getIdByCookie();
		   
			$('#product-' + wiz_ajax.prodID).attr("checked", "checked");
			
			if ( typeof console !== 'undefined' && console.error ) {
                console.log('#product-' + wiz_ajax.prodID);
			}			
			
						
		   	wiz_ajax.updateProduct();
					
			
            	
		},
		
		onProductChange: function() {
           this.getProducts.on( "change", function(){ 
		   /*
		   * 1 aggiorno il valore sul cookie
		   * 2 salvo il valore del form caricato
		   * 3 carico il form adeguato
		   * 4 aggiorno l'immagine sull'editor
		   * 5 imposto il modal corretto
		   */
		  
			   $("#mi-slider :checked").each(function() {
					
					wiz_ajax.prodID = $(this).attr('value');
					wiz_ajax.setCookieData	( 'wizard_product_id', wiz_ajax.prodID );
					
					wiz_ajax.updateProduct();
					
				});
				
			});
        },
		
		onCategoryChange: function() {
             this.getCategory.on( "click", function(){ alert('onCatChange');});
        },
		
		
		onEditorSubmit: function() {
			// don't know why but 'on' doesn't work. instead 'live' does it.
            this.getEditorBtn.live('click', wiz_ajax.afterEditorComplete);
			 
        },
		
		onEditorUpdate: function() {
            this.getEditorFields.live('keyup', this.setFieldsEditor);
            wiz_ajax.form.live('change', this.serialize);
        },
		
		
		updateProduct: function(){
			$.when( 
					
						wiz_ajax.getForm(),
						wiz_ajax.getFields(),
						wiz_ajax.getImage(),
						wiz_ajax.getModal()
					)
					.then(
						function() {
						wiz_ajax.setForm();
						wiz_ajax.setFields();
						wiz_ajax.setImage();
						wiz_ajax.setModal();
						wiz_ajax.formUpdater();
						if ( typeof console !== 'undefined' && console.error ) {
                			console.log('updateProduct ' + wiz_ajax.prodID + ' completed');
						}	
	
						}
					);
		},
		
       
		
		/*
		 *
		 * Functions Form
		 *
		 *
		*/
		
		getForm: function( ) {
            $('.loaderImage').show();
			
			var prodID = wiz_ajax.prodID;
		
            return $.ajax({
                url: wiz_ajax.callUrl,
                method: 'POST',
                data: {
                    'action': 'wiz_get_form',
                    'selection': prodID
                },
                success: function(data) {
                    wiz_ajax.formData = data;
                },
            });
        },
		setForm: function (){
			  $("#custom-section .x-content").html(wiz_ajax.formData);
		},
		
		serialize: function() {
            wiz_ajax.post = $('form').serialize();
        },
		
		formUpdater: function() {
            $('#custom-section input,  #custom-section textarea,  #custom-section select').each(function() {
                if (this.id === 'wizard_background') {
                    $('.' + this.id + '_text').attr('src', this.value);
                } else {
                    $('.' + this.id + '_text').html(this.value);
                }
            });
        },
		getFields: function() {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_fields',
                    'selection': wiz_ajax.prodID
                },
                success: function(data) {
                    wiz_ajax.fieldsData = data;
                },
            });
        },
		setFields: function(){
			$("#stage").html(wiz_ajax.fieldsData);
		},
		
		setFieldsEditor: function() {
            $(this).each(function() {
                if (this.id === 'wizard_background') {
                    $('.' + this.id + '_text').attr('src', this.value);
                } else {
                    $('.' + this.id + '_text').html(this.value);
                }
            });
        },
		
		getImage: function() {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_image_editor',
                    'prodID': wiz_ajax.prodID
                },
                success: function(data) {
                    wiz_ajax.prodImg = data;
                },
            });
        },
		setImage: function(){
			$("#stage").removeClass().addClass('p-' + wiz_ajax.prodID);
            $("#stage .stage_bg").css('background-image', 'url(' + wiz_ajax.prodImg + ')');
		},
		
		afterEditorComplete: function(event) {
        	
			event.preventDefault();
        	wiz_ajax.updateModal();
			$.when(
            	$("#product-section .loader").show(),
                wiz_ajax.getProduct()
            ).then(
            	function() {
                	
					$("#product-section .loader").hide();
                   	wiz_ajax.setProduct();
                	wiz_ajax.updateSummary();
				   
               });
         
        },
		
		/*
		 *
		 * Product functions
		 *
		 *
		*/
		 getProduct: function() {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_getsingle_product',
                    'selection': wiz_ajax.prodID,
                    'dataForm': wiz_ajax.post,
                },
                success: function(data) {
                    wiz_ajax.productHTML = data;
                },
            });
        },
		
		
		setProduct: function(){
			$("#product-section .x-content").html(wiz_ajax.productHTML);
		},
		
		/*
		 *
		 * Functions Cookie
		 *
		 *
		*/
		getCookieData: function() {
		    var cookie = Cookies.get(wiz_ajax.cookieName);
           
			if (cookie) {
                cookie = decodeURIComponent(cookie);
				if ( typeof console !== 'undefined' && console.error ) {
            		console.log( 'this is cookie inside getCookieData :' + cookie );
				}	
                if (strpos(cookie, "=", 0)) {
                    wiz_ajax.cookieContent = parseQuery(cookie);
                    
                }
            } else {			
				if ( typeof console !== 'undefined' && console.error ) {
                	console.log('caricato default');
				}	
                wiz_ajax.cookieContent = wiz_ajax.defaultSettings;
            }
            return wiz_ajax.cookieContent;
        },
		
		setCookieData: function ( key, data ){
			if ( typeof console !== 'undefined' && console.error ) {
            	console.log('save this informations:' + data);
			}
			
			var cookie = Array(); 
			console.log('getCookieData accede a getCookieData');
			cookie = wiz_ajax.getCookieData();
			cookie[ key ] = data;
			
			if ( typeof console !== 'undefined' && console.error ) {
            	console.dir( cookie );
			}
		},
		
		/*
		 *
		 * Summary functions
		 *
		 *
		*/
		getModal: function() {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_modal',
                    'selection': wiz_ajax.prodID,
                },
                success: function(data) {
                    wiz_ajax.modal = data;
					
                },
            });
        },
		setModal: function() {
			$('#modal-wrapper').html(wiz_ajax.modal);
		},
		updateModal: function(){
			$('#rew_wizard_fullname').html($('#wizard_fullname').val());
            $('#rew_wizard_tel_email').html($('#wizard_tel_email').val());
            $('#rew_wizard_tel').html($('#wizard_tel').val());
            $('#rew_wizard_email').html($('#wizard_email').val());
            $('#rew_wizard_address').html($('#wizard_address').val());
            $('#rew_wizard_city_postcode').html($('#wizard_city_postcode').val());
            $('#rew_wizard_fullname').html($('#wizard_fullname').val());
            $('#rew_wizard_tel_email').html($('#wizard_tel_email').val());
		},
		
		/*
		 *
		 * Summary functions
		 *
		 *
		*/
		
		updateSummary: function(){
			$('#sum_prod_title').html($('#product-section').find('.product_title').html());
            $('#sum_prod_price').html($('#product-section').find('.price').html());
            $('#sum_prod_q').html($('#product-section').find('.quantity .qty').val());
		},
		
		/*
		 *
		 * extra  Functions
		 *
		 *
		*/
		
		getIdByCookie: function (){
		console.log('getIdByCookie accede a getCookieData');
		  var cookieID = wiz_ajax.getCookieData();
            try {
                if (cookieID === '' && cookieID === 0) {
                    throw 'wiz_ajax.getCookieData() non sta funzionando';
                }
				 wiz_ajax.prodID = cookieID.wizard_product_id;
				
				
				 } catch (e) {
				if ( typeof console !== 'undefined' && console.error ) {
                console.log(e);
				}
            }   		
		
		
		
		}
		
	};
    wiz_ajax.init();
});
