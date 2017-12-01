jQuery(function ($) {
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
		styleID: '',
        modal: '',
        init: function () {
			if (typeof console !== 'undefined' && console.error) {
                  //  console.log('funzione onEditorUpdate corettamente caricata');
            }
            try {
                if (typeof Cookies !== 'function') { throw 'La funzione Cookies non è stata implementata';}
                if (typeof strpos !== 'function') { throw 'La funzione strpos non è stata implementata';}
                if (typeof parseQuery !== 'function') {throw 'La funzione parseQuery non è stata implementata';}
                if (typeof strip !== 'function') {throw 'La funzione strip non è stata implementata';}
                this.form = $('form#wiz-config');               
				this.sliderProducts = $('#mi-slider');
				this.sliderProductsList = $('#mi-slider').find('.mi-current li');
				this.sliderProductsLength = this.sliderProductsList.length;
                this.getCats = $('#mi-slider').find('nav > a');
                this.editorBtn = $('#custom-section #submitBtn');
                this.editorFields = $('#custom-section input,  #custom-section textarea,  #custom-section select');
                this.prodSubmit = $('#prodSubmit');
				this.styleSelector = $('#wizard_background_field .image_picker_selector').find ('li');			
                if (typeof setup.ajax_url === 'undefined') {throw 'setup.ajax_url non è caricato';}
                if (typeof setup.cookie_name === 'undefined') {throw 'setup.cookie_name non è caricato';}
                if (typeof setup.user_settings === 'undefined') {throw 'setup.user_settings non è caricato';}               
				this.wizDocument = $(document);
                this.productSelectDom = $('#cat_opt');
                this.modalBtn = $('#confirm-submit');
                this.summary = $('.summary-wiz');
				wiz_ajax.onDocumentReady();
                wiz_ajax.onAjax();
                wiz_ajax.onProductChange();
				wiz_ajax.onCategoryChange();
                wiz_ajax.onEditorUpdate();
                wiz_ajax.onProductSelect();
                wiz_ajax.editorUpdateOnKeyup();
                wiz_ajax.onHideModal();
				wiz_ajax.onStyleChange();
				wiz_ajax.onFormLoaded();
            } catch (e) {
                if (typeof console !== 'undefined' && console.error) {
                    console.log(e);
                }
            }
        },

		onFormLoaded: function () {
			$( document ).bind( "FormLoaded", function(){
				wiz_ajax.setStyleKit();
				wiz_ajax.getBoxColors();
				
			});
		},
        onAjax: function () {
			if (typeof console !== 'undefined' && console.error) {
                   // console.log('funzione onAjax corettamente caricata');
            }
            this.wizDocument.ajaxSuccess(this.formUpdater);
            this.wizDocument.ajaxSuccess(this.serialize);		
        },
		onCategoryChange: function(){
			$(document).bind('classGiven',function(){
				wiz_ajax.setProductsStyleWidth();
				if( $( "#mi-slider input:checked" ).parents('ul').hasClass( "mi-current" )) {				
					$('#custom-section').fadeIn();
					$('#stage').fadeIn();
				}else{
					$('#custom-section').fadeOut();
					$('#stage').fadeOut();
				}
			});
					
		},
        
        onProductChange: function () {
			
			if (typeof console !== 'undefined' && console.error) {
                    //console.log('prodotto cambiato');
            }
			/*
			*
			* Load a new product, registering the id in the cookie
			*
			*/
			
            this.sliderProducts.live('change', function(){ 
			
				wiz_ajax.loadNewProduct();
				$( document ).on( "ProductUpdated" , function(  ) {
					$('#custom-section').fadeIn();
				$('#stage').fadeIn();
				wiz_ajax.setPreProductFocus();
				
				});
			wiz_ajax.formUpdater();
			});
            this.sliderProducts.live('change', function(){
				
				//console.log('onProductChange sliderProducts.live setCookieData wizard_product_id' +  wiz_ajax.prodID)
				 wiz_ajax.setCookieData('wizard_product_id', wiz_ajax.prodID); 
				 
				  
				 });
			
			
			 
        },


		onStyleChange: function () {
			if (typeof console !== 'undefined' && console.error) {
                   // console.log('funzione onEditorUpdate corettamente caricata');
            }
		   	this.styleSelector.live('click', function(){ 
			wiz_ajax.styleID =  Number($("select").data('picker').selected_values());
            $('.frame').removeClass (function (index, css) {
				return (css.match (/(^|\s)kitstyle-\S+/g) || []).join(' ');
			}).addClass('kitstyle-' + wiz_ajax.styleID);
			
				  });

        },
		
		
		
		setStyleKit: function () {
			
			//$('#product-editor').find('.frame').addClass('kitstyle-' + wiz_ajax.styleID);
			
			
			if (typeof wiz_ajax.styleID === 'undefined' || wiz_ajax.styleID === 0 ) {
			wiz_ajax.styleID =  Number($("#custom-section select").data('picker').selected_values());
			}else{
			wiz_ajax.styleID =  wiz_ajax.cookieContent.wizard_background; 
			}
			
			$('#product-editor').find('.frame').removeClass (function (index, css) {
				return (css.match (/(^|\s)kitstyle-\S+/g) || []).join(' ');
			}).addClass('kitstyle-' + wiz_ajax.styleID);
			
		},
		

        onEditorUpdate: function () {
			if (typeof console !== 'undefined' && console.error) {
                    //console.log('funzione onEditorUpdate corettamente caricata');
            }
			/* da qui parte l'attività qando si clicca su 'crea personalizzazione */
			
            this.editorBtn.live('click', this.afterEditorComplete);
			//this.editorBtn.live('click', this.generateSum);
 			
        },
		
		

        onDocumentReady: function () {
			if (typeof console !== 'undefined' && console.error) {
				var cookie = wiz_ajax.getCookieData();
             	console.log('Procedura di caricamento avviata, id prodotto: ' + cookie.wizard_product_id + ' , id categoria: ' + cookie.wizard_cat_id);
            }
            /**
		     * 1 Carico l'id del cookie
		     * 3 carico il form adeguato
		     * 4 aggiorno l'immagine sull'editor
		     * 5 imposto il modal corretto
		    */  
		   	$(document).bind('classGiven',function(){
						  wiz_ajax.setProductsStyleWidth();
			});
		  
		   //Carico l'id dal cookie
		   wiz_ajax.getIdByCookie();
		   
			$('#product-' + wiz_ajax.prodID).attr("checked", "checked");
			
			if ( typeof console !== 'undefined' && console.error ) {
                //console.log('[ wiz-ajax.js ] ho attivato il seguente prodotto: ' + wiz_ajax.prodID);
			}			
			
						
		   	wiz_ajax.updateProduct();
			
            wiz_ajax.resetSummary();
            this.prodSubmit.click(function () {
                $('.cart').submit();
            });
			
			 wiz_ajax.setProductsStyleWidth();
			 
        },
		
		
		
		
		
        onProductSelect: function () {
           this.productSelectDom.live('change', this.afterProductSelect);
		   
        },
        /*
         * Read the cookie setting or load the default settings.
         * It also do a security check of the cookie.
         * return: Array wiz_ajax.cookieContent -> un array that came from cookie or default settings
         */
        getCookieData: function () {
			console.log('accedo al valore del cookie');
            var cookie = Cookies.get(wiz_ajax.cookieName);
			
			
            if (cookie) {
                cookie = decodeURIComponent(cookie);
                if (strpos(cookie, "=", 0)) {
                    wiz_ajax.cookieContent = parseQuery(cookie);

                }
            } else {
                wiz_ajax.cookieContent = wiz_ajax.defaultSettings;
            }
			//console.dir(wiz_ajax.cookieContent);
            return wiz_ajax.cookieContent;
        },

        setCookieData: function ( key, data ){
			if ( typeof console !== 'undefined' && console.error ) {
            	//console.log('save this informations:' + data);
			}
			
			var cookie = Array(); 
			//console.log('setCookieData accede a getCookieData');
			cookie = wiz_ajax.getCookieData();
			
			cookie[ key ] = data;
			
			if ( typeof console !== 'undefined' && console.error ) {
            	//console.dir( cookie );
			}
			
			//wiz_ajax.cookieContent = cookie;
			//document.cookie = wiz_ajax.cookieName, cookie  ;
			
			//alert(cookies);
			//Cookies.set( wiz_ajax.cookieName , cookies );

		//	for (var prop in wiz_ajax.cookieContent) {
		  //console.log("obj." + prop + " = " + wiz_ajax.cookieContent[prop]);
		  //Cookies.set( wiz_ajax.cookieName , wiz_ajax.cookieContent[prop]);
		//}
			
		},
        onHideModal: function () {
			
			//
			$( '#confirm-submit button#edit' ).live("click", function() {
				 $('#confirm-submit').modal('hide');
				} );
				
					$( '#confirm-submit button#submit' ).live("click", function() {
				 $('#confirm-submit').modal('hide');
				    $.scrollTo($('#product-section'), 600, {
                    easing: 'swing'
                });
                wiz_ajax.loadSummary();
				}  );
		
			   
			
        },
		
		AlertSum:function(){
		   var ultra_fine = Number($( "#wizard_scovolini_quantita_ultra_fine" ).val());
		   var fine = Number($( "#wizard_scovolini_quantita_fine" ).val());
		   var medium = Number($( "#wizard_scovolini_quantita_medium" ).val());
		   var large = Number($( "#wizard_scovolini_quantita_large" ).val());
		   var extra_large = Number($( "#wizard_scovolini_quantita_extra_large" ).val());
		   
		   var scovolini_sum = ultra_fine + fine + medium + large + extra_large;
       	 if( scovolini_sum > 5 ){
					
					$('#modal-generico #submit').css( "display", "none");	
					
					$('#modal-generico').modal({
  						backdrop: 'static'
						}).find('.modal-body' ).html('<p>Quantità superata, ogni box può contenere massimo 500 pezzi.</p>');
					
					
				}
		},
		
	   generateSum:function(){
		   
		   if ( typeof console !== 'undefined' && console.error ) {
                			//console.log('generateSum LOADED');
			}
			
		   var ultra_fine = Number($( "#wizard_scovolini_quantita_ultra_fine" ).val());
		   var fine = Number($( "#wizard_scovolini_quantita_fine" ).val());
		   var medium = Number($( "#wizard_scovolini_quantita_medium" ).val());
		   var large = Number($( "#wizard_scovolini_quantita_large" ).val());
		   var extra_large = Number($( "#wizard_scovolini_quantita_extra_large" ).val());
		   
		   var scovolini_sum = ultra_fine + fine + medium + large + extra_large;
		   
		   if ( ! isNaN ( scovolini_sum ) ) {
				
				$('#modal-generico #submit').css( "display", "none");
				
				if( scovolini_sum === 0 ){
					
					$('#modal-generico').modal({
  						backdrop: 'static'
						}).find('.modal-body' ).html('<p>Inserisci le quantità di scovolini, fino a configurare la scatola intera di 500 pezzi. Attualmente non è stata inserita nessuna quantità</p>');
				}
				
				else if( scovolini_sum < 5 ){
					
					$('#modal-generico').modal({
  						backdrop: 'static'
						}).find('.modal-body' ).html('<p>Inserisci le quantità di scovolini, fino a configurare la scatola intera di 500 pezzi. Attualmente le quantità inserite sono insufficienti per completare l\'ordine</p>');
				
				}
				else
				
				 if( scovolini_sum === 5 ){
					
					$('#modal-generico #submit').css( "display", "inline");	
					
					$('#modal-generico').modal({
  						backdrop: 'static'
						}).find('.modal-body' ).html('<p>Hai completato la configurazione del box. Ora puoi procedere all\'inserimento nel carrello</p>');
					
					wiz_ajax.loadProduct2Buy();
					
						$( '#modal-generico button#submit' ).live("click", function() {
				 $('#modal-generico').modal('hide');
				    $.scrollTo($('#product-section'), 600, {
                    easing: 'swing'
                });
                wiz_ajax.loadSummary();
				}  );
					
				}
				
				else  if( scovolini_sum > 5 ){
					
					$('#modal-generico #submit').css( "display", "none");	
					
					$('#modal-generico').modal({
  						backdrop: 'static'
						}).find('.modal-body' ).html('<p>Quantità superata, ogni box può contenere massimo 500 pezzi.</p>');
					
					
				}
				
				
				   
			
			}
		   
		},
        
		getBoxColors: function(){
			
			$( "#wizard_scovolini_quantita_ultra_fine" ).val(wiz_ajax.cookieContent.wizard_scovolini_quantita_ultra_fine);
			$( "#wizard_scovolini_quantita_fine" ).val(wiz_ajax.cookieContent.wizard_scovolini_quantita_fine);
			$( "#wizard_scovolini_quantita_medium" ).val(wiz_ajax.cookieContent.wizard_scovolini_quantita_medium);
			$( "#wizard_scovolini_quantita_large" ).val(wiz_ajax.cookieContent.wizard_scovolini_quantita_large);
			$( "#wizard_scovolini_quantita_extra_large" ).val(wiz_ajax.cookieContent.wizard_scovolini_quantita_extra_large);
			
			wiz_ajax.setBoxColors();	
		
		},
		
		setBoxColors:function(){
			
			var ultra_fine = Number($( "#wizard_scovolini_quantita_ultra_fine" ).val());
			var fine = Number($( "#wizard_scovolini_quantita_fine" ).val());
			var medium = Number($( "#wizard_scovolini_quantita_medium" ).val());
			var large = Number($( "#wizard_scovolini_quantita_large" ).val());
			var extra_large = Number($( "#wizard_scovolini_quantita_extra_large" ).val());
			
			if (ultra_fine > 0){
				$("#product-editor .frame span").removeClass('ultra-fine fine medium large extra-large').empty();
				$("#product-editor .frame span").slice(0, ultra_fine).addClass('ultra-fine').append('<h3>Ultra Fine</h3>');
				
			}
			if (ultra_fine === 0){
				$("#product-editor .frame span").removeClass('ultra-fine').empty();
			}
			
			if (ultra_fine === 5){
				$("#wizard_scovolini_quantita_fine, #wizard_scovolini_quantita_medium, #wizard_scovolini_quantita_large, #wizard_scovolini_quantita_extra_large").val(0);
			}
			
			
			
			if (fine > 0){
				$("#product-editor .frame span").slice(ultra_fine).removeClass('ultra-fine fine medium large extra-large').empty();
				$("#product-editor .frame span").slice(ultra_fine, ultra_fine + fine).addClass('fine').append('<h3>Fine</h3>');
			}
			
			if (fine === 0){
				$("#product-editor .frame span").slice(ultra_fine).removeClass('fine').empty();
			}
			
			if (fine === 5){
				$("#wizard_scovolini_quantita_ultra_fine, #wizard_scovolini_quantita_medium, #wizard_scovolini_quantita_large, #wizard_scovolini_quantita_extra_large").val(0);
			}
			
			
			
			if (medium > 0){
				$("#product-editor .frame span").slice(ultra_fine + fine).removeClass('ultra-fine fine medium large extra-large').empty();
				$("#product-editor .frame span").slice(ultra_fine +fine, ultra_fine + fine + medium).addClass('medium').append('<h3>Medium</h3>');
			}
			if (medium === 0){
				$("#product-editor .frame span").slice(ultra_fine + fine).removeClass('medium').empty();
			}
			if (medium === 5){
				$("#wizard_scovolini_quantita_ultra_fine, #wizard_scovolini_quantita_fine, #wizard_scovolini_quantita_large, #wizard_scovolini_quantita_extra_large").val(0);
			}
			
			
			
			if (large > 0){
				$("#product-editor .frame span").slice(ultra_fine + fine + medium).removeClass('ultra-fine fine medium large extra-large').empty();
				$("#product-editor .frame span").slice(ultra_fine +fine + medium, ultra_fine + fine + medium +large).addClass('large').append('<h3>Large</h3>');
			}
			if (large === 0){
				$("#product-editor .frame span").slice(ultra_fine + fine + medium).removeClass('large').empty();
				
			}
			if (large === 5){
				$("#wizard_scovolini_quantita_ultra_fine, #wizard_scovolini_quantita_fine, #wizard_scovolini_quantita_medium, #wizard_scovolini_quantita_extra_large").val(0);
			}
			
			if (extra_large > 0){
				$("#product-editor .frame span").slice(ultra_fine + fine + medium + large).removeClass('ultra-fine fine medium large extra-large').empty();
				$("#product-editor .frame span").slice(ultra_fine + fine + medium + large, ultra_fine + fine + medium +large + extra_large).addClass('extra-large').append('<h3>Extra Large</h3>');
			}
			
			if (extra_large === 0){
				$("#product-editor .frame span").slice(ultra_fine + fine + medium + large).removeClass('extra-large').empty();	
			}
			
			if (extra_large === 5){
				$("#wizard_scovolini_quantita_ultra_fine, #wizard_scovolini_quantita_fine, #wizard_scovolini_quantita_medium, #wizard_scovolini_quantita_large, #wizard_scovolini_quantita_extra_large").val(0);
			}
		},
		
        editorUpdateOnKeyup: function () {
           this.editorFields.live('keyup', wiz_ajax.setFieldsEditor);
		   this.editorFields.live('change', wiz_ajax.AlertSum);
		   
		   this.editorFields.live('change', wiz_ajax.setBoxColors);
         	wiz_ajax.form.live('change', this.serialize);
        },
        formUpdater: function () {
          
				$('#custom-section input,  #custom-section textarea,  #custom-section select').each(function () {
                if (this.id === 'wizard_background') {
                    $('.' + this.id + '_text').attr('src', this.value);
               
			    } else {
                    $('.' + this.id + '_text').html(this.value);
					
					if ( typeof console !== 'undefined' && console.error ) {
					//	console.log('trying to save: ' +  this.id + ' ' +  this.value );
					}
					// save every input in the cookie
					wiz_ajax.setCookieData( this.id , this.value);
					
                }
            });
			$( document ).trigger( "FormLoaded" );
        },
        
		
        serialize: function () {
            wiz_ajax.post = $('form').serialize();
        },
        
		updateProduct : function(){
			
			$.when(
                        $("#custom-section .loader").show(),
                        wiz_ajax.getForm(),
                        wiz_ajax.getFields(),
                        wiz_ajax.getImage(),
                        wiz_ajax.getModal()
                    )
                    .then(function () {
                        $("#custom-section .loader").hide();
                        
						wiz_ajax.setForm();
						wiz_ajax.setFields();
                        wiz_ajax.setImage();
						wiz_ajax.setModal();
						wiz_ajax.formUpdater();
                        $("#product-section .x-content").empty();
                        
						
						if ( typeof console !== 'undefined' && console.error ) {
                			//console.log('updateProduct ' + wiz_ajax.prodID + ' completed');
						}
						$( document ).trigger( "ProductUpdated" );
                    });
		
		},
		
        loadNewProduct: function () {
			/*
			*
			* Quando cambio il prodotto carico un nuvo form
			* 1 ottengo l'id corretto
			* 2 carico il prodotto nuovo
			*/
			
            $("#mi-slider :checked").each(function () {
                wiz_ajax.prodID = $(this).attr('value');
               
			   wiz_ajax.updateProduct();
                
            });
        },
		/*
		 this is fired when someone confirm a product
		 */
		 
        afterEditorComplete: function (event) {
			
			if ( typeof console !== 'undefined' && console.error ) {
                			//console.log('afterEditorComplete LOADED');
			}
            
			event.preventDefault();
			wiz_ajax.generateSum();
            wiz_ajax.updateModal();
			//console.log('afterEditorComplete accede a getCookieData');
			var cookie = wiz_ajax.getCookieData();
			
            $('#sum_prod_price').html("<div class='loader'> </div>");
			
			
			
			if( Number(cookie.wizard_product_id) !== 2573){
				
				
				wiz_ajax.loadProduct2Buy();
	
					
			}
		
        },
		
		
		loadProduct2Buy:function(){
			
			$.when(
                    $("#product-section .loader").show(),
                    wiz_ajax.getProduct()
                )
            .then(
                    function () {
                        $("#product-section .loader").hide();
                        wiz_ajax.setProduct();
                        
						
						
						wiz_ajax.updateSummary();
						//console.log('loadProduct2Buy accede a getCookieData');
						var cookie = wiz_ajax.getCookieData();
	
						if( cookie.wizard_cat_id == 7 ){
						
							wiz_ajax.setImage_spazzolino();
						
						}else if (cookie.wizard_cat_id == 11){
						
							wiz_ajax.setImage_kit();
						
						}
						
                    });		
		},
		
        afterProductSelect: function () {
            $("#cat_opt input:checked").each(function () {
                wiz_ajax.productItem = $(this).attr('value');
                $.when(
                        wiz_ajax.getProduct()
                    )
                    .then(function () {
                        $('#product-editor #stage').html(wiz_ajax.productHTML);
					
						
                    });
            });
        },
		
		
        setFieldsEditor: function () {
          //alert('fire');
		   //wiz_ajax.formUpdater();
		    $(this).each(function() {
                if (this.id === 'wizard_background') {
                    $('.' + this.id + '_text').attr('src', this.value);
                } else {
                    $('.' + this.id + '_text').html(this.value);
                }
            });
        },
        setCookie: function () {
            var inFifteenMinutes = new Date(new Date().getTime() + 15 * 60 * 1000);
            Cookies.set('config', true, {
                expires: inFifteenMinutes
            });
        },
		
		setStyle: function () {
			return $.ajax({
                url: wiz_ajax.callUrl,
                //method: 'POST',
                data: {
                    'action': 'wiz_set_style',
                    'selection': wiz_ajax.prodID
                },
                success: function (data) {
                
                },
            });
			
		},
        getForm: function () {
            $('.loaderImage').show();
            return $.ajax({
                url: wiz_ajax.callUrl,
                //method: 'POST',
                data: {
                    'action': 'wiz_get_form',
                    'selection': wiz_ajax.prodID
                },
                success: function (data) {
                    wiz_ajax.formData = data;
                    var started = Cookies.get('config');
                    if (started !== true) {
                        $.scrollTo(250, 600, {
                            easing: 'swing'
                        });
                    } else {
                        wiz_ajax.setCookie();
                    }
                },
            });
        },
		setForm: function (){
			  $("#custom-section .x-content").html(wiz_ajax.formData);
			  $( document ).trigger( "FormLoaded" );
			 
			  
		},
		
        getFields: function () {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_fields',
                    'selection': wiz_ajax.prodID,
					
                },
                success: function (data) {
                    wiz_ajax.fieldsData = data;
                },
            });
        },
		setFields: function(){
			$("#stage").html(wiz_ajax.fieldsData);
			
		},
        getCat: function () {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_cat',
                    'selection': wiz_ajax.prodID
                },
                success: function (data) {
                    wiz_ajax.catID = data;
                    return wiz_ajax.catID;
                },
            });
        },
        getProduct: function () {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_getsingle_product',
                    'selection': wiz_ajax.prodID,
                    'dataForm': wiz_ajax.post,
                },
                success: function (data) {
                    wiz_ajax.productHTML = data;
					
					if ( typeof console !== 'undefined' && console.error ) {
					//console.log('this is: ' + wiz_ajax.post);
					}
					
                },
            });
        },
        setProduct: function () {
            $("#product-section .x-content").html(wiz_ajax.productHTML);
        },
		
		setImage_spazzolino: function(){
		
			return $.ajax({
				url: wiz_ajax.callUrl,
				data: {
					'action': 'wiz_save_image_spazzolino',	
				},
				success: function(){
					wiz_ajax.setPost();
				}	
					
					
			});
		},
		
		setImage_kit: function(){
		
			return $.ajax({
				url: wiz_ajax.callUrl,
				data: {
					'action': 'wiz_save_image_kit',	
				},
				success: function(){
					wiz_ajax.setPost();
				}			
			});
		},
		
		setPreProductFocus: function(){
			
			//var cookie = wiz_ajax.getCookieData();
			$("#pre_product_focus").html('');
			
			if( wiz_ajax.cookieContent.wizard_cat_id == 11 ){
			$("#pre_product_focus").html("<p>Se vuoi una personalizzazione con il tuo logo contatta direttamente l’azienda e invia il tuo logo a <a href='mailto:mkt@piave.com'>mkt@piave.com</a></p>");
			}
		},
		
		setPost: function(){
		
			return $.ajax({
				url: wiz_ajax.callUrl,
				data: {
					'action': 'wiz_save_post',
					
				},
				success: function(data){
					//alert(data);
				}			
					
			});
		},
		
        getModal: function () {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_modal',
                    'selection': wiz_ajax.prodID,
                },
                success: function (data) {
                    wiz_ajax.modal = data;

                },
            });
        },
        setModal: function () {
            $('#modal-wrapper').html(wiz_ajax.modal);
        },
        updateModal: function () {
            $('#rew_wizard_fullname').html($('#wizard_fullname').val());
            $('#rew_wizard_tel_email').html($('#wizard_tel_email').val());
            $('#rew_wizard_tel').html($('#wizard_tel').val());
            $('#rew_wizard_email').html($('#wizard_email').val());
            $('#rew_wizard_address').html($('#wizard_address').val());
			$('#rew_wizard_address_2').html($('#wizard_address_2').val());
            $('#rew_wizard_city_postcode').html($('#wizard_city_postcode').val());
            $('#rew_wizard_fullname').html($('#wizard_fullname').val());
            $('#rew_wizard_tel_email').html($('#wizard_tel_email').val());
			
			$('#rew_wizard_scovolini_quantita_ultra_fine').html($('#wizard_scovolini_quantita_ultra_fine').val());
			$('#rew_wizard_scovolini_quantita_fine').html($('#wizard_scovolini_quantita_fine').val());
			$('#rew_wizard_scovolini_quantita_medium').html($('#wizard_scovolini_quantita_medium').val());
			$('#rew_wizard_scovolini_quantita_large').html($('#wizard_scovolini_quantita_large').val());
			$('#rew_wizard_scovolini_quantita_extra_large').html($('#wizard_scovolini_quantita_extra_large').val());
			
			
			
        },
        getImage: function () {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_image_editor',
                    'prodID': wiz_ajax.prodID
                },
                success: function (data) {
                    wiz_ajax.prodImg = data;
					if ( typeof console !== 'undefined' && console.error ) {
					//console.log('this is prodImg: ' + wiz_ajax.prodImg );
					}
                },
            });
        },
		setImage: function(){
			$("#stage").removeClass().addClass('p-' + wiz_ajax.prodID);
            $("#stage .stage_bg").css('background-image', 'url(' + wiz_ajax.prodImg + ')');
		},

        preloadImages: function () {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_preload_images',
                },

                success: function (data) {

                    $("body").append("<div id='loader' style='display:none' ></div>");
                    var jsonData = (data);

                    for (var key in jsonData) {
                        if (jsonData.hasOwnProperty(key)) {
                            wiz_ajax.preloadedImages[key] = jsonData[key];
                            $('body').find('#loader').append('<img src="' + jsonData[key] + '" />');

                        }
                    }


                },
                dataType: "json"
            });
        },

		setProductsStyleWidth: function (){
			//alert($('#mi-slider').find('.mi-current li').length);
			 var ratio = (95/ $('#mi-slider').find('.mi-current li').length) + '%';
			 wiz_ajax.sliderProductsList = $('#mi-slider').find('.mi-current li');
 			$('#mi-slider').find('.mi-current li').css( 'width', ratio);
		},
		
        resetSummary: function () {
            wiz_ajax.summary.animate({
                'marginBottom': '-147px'
            }, 200);
        },
        /*
         *
         * Summary functions
         *
         *
         */

        updateSummary: function () {
            $('#sum_prod_title').html($('#product-section').find('.product_title').html());
            $('#sum_prod_price').html($('#product-section').find('.price').html());
            $('#sum_prod_q').html($('#product-section').find('.quantity .qty').val());
        },
        loadSummary: function () {
            wiz_ajax.summary.animate({
                'marginBottom': '0px'
            }, 200);
        },
		
		/*
		 *
		 * extra  Functions
		 *
		 *
		*/
		
		getIdByCookie: function (){
			//console.log('getIdByCookie accede a getCookieData');
			var cookieID = wiz_ajax.getCookieData();
        	console.log('wiz_ajax.prodID ha questo valore ora: ' + wiz_ajax.prodID + 'ma sta per essere cambiato');
			try {
            	if (cookieID === '' && cookieID === 0) {
                	throw 'wiz_ajax.getCookieData() non sta funzionando';
                }
			
			wiz_ajax.prodID = cookieID.wizard_product_id;
			
			console.log('ho associato lid che ho letto nel cookie ( ' + cookieID.wizard_product_id + ' )' + ' alla variabile wiz_ajax.prodID ' + wiz_ajax.prodID);
				
				 } catch (e) {
				if ( typeof console !== 'undefined' && console.error ) {
                //console.log(e);
				}
            }   		
		
		
		
		},
		isJSON: function (str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
    };


    wiz_ajax.init();
});
