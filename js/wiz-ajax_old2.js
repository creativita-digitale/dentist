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
                //if (typeof preload !== 'function') {
                //    throw 'La funzione preload non è stata implementata';
                //}
				if (typeof Cookies !== 'function') {
                    throw 'La funzione Cookies non è stata implementata';
                }
                if (typeof strpos !== 'function') {
                    throw 'La funzione strpos non è stata implementata';
                }
                if (typeof parseQuery !== 'function') {
                    throw 'La funzione parseQuery non è stata implementata';
                }
                if (typeof strip !== 'function') {
                    throw 'La funzione strip non è stata implementata';
                }
                this.form = $('form#wiz-config');
                this.sliderProducts = $('#mi-slider');
                this.getCats = $('#mi-slider').find('nav > a');
                this.editorBtn = $('#custom-section #submitBtn');
                this.editorFields = $('#custom-section input,  #custom-section textarea, #custom-section select');
                this.prodSubmit = $('#prodSubmit');
                if (typeof setup.ajax_url === 'undefined') {
                    throw 'setup.ajax_url non è caricato';
                }
                if (typeof setup.cookie_name === 'undefined') {
                    throw 'setup.cookie_name non è caricato';
                }
                if (typeof setup.user_settings === 'undefined') {
                    throw 'setup.user_settings non è caricato';
                }
                //if (this.form.length === 0){			throw 'Errore! Manca form';}
                //if (this.sliderProducts.length === 0){		throw 'Errore! Manca sliderProducts';}
                //if (this.getCats.length === 0){			throw 'Errore! Manca getCats';}
                this.wizDocument = $(document);
                this.productSelectDom = $('#cat_opt');
                this.modal = $('#confirm-submit');
				this.summary = $('.summary-wiz');
				
				
				 $.when(
                      wiz_ajax.preloadImages()
                    )
                    .then(function() {
						
                        wiz_ajax.onPageLoad();
						wiz_ajax.onAjax();
						wiz_ajax.onProductChange();
						wiz_ajax.onCatChange();
						wiz_ajax.onEditorUpdate();
						wiz_ajax.onProductSelect();
						wiz_ajax.editorUpdateOnKeyup();
						wiz_ajax.onHideModal();
                    });
					
              
            } catch (e) {
               if ( typeof console !== 'undefined' && console.error ) {
                console.log(e);
				}
            }
        },
        
        onAjax: function() {
            this.wizDocument.ajaxSuccess(this.formUpdater);
            this.wizDocument.ajaxSuccess(this.serialize);
        },
       
	   
	   
       /* onCatChange: function() {
            this.getCats.click(this.emptyForm);
        },
        onProductChange: function() {
            this.sliderProducts.live('change', this.focusProductChange);
			this.sliderProducts.live('change', this.setCookieData(wiz_ajax.prodID));
        },
		*/
		
		
		
        onEditorUpdate: function() {
            this.editorBtn.live('click', this.afterEditorComplete);
			 
        },
		
        onPageLoad: function() {
            this.wizDocument.ready(this.loadPrecompiledForm);
			wiz_ajax.resetSummary();
            this.prodSubmit.click(function() {
                $('.cart').submit();
            });
        },
        onProductSelect: function() {
            this.productSelectDom.live('change', this.afterProductSelect);
        },/*
         * Read the cookie setting or load the default settings.
         * It also do a security check of the cookie.
         * return: Array wiz_ajax.cookieContent -> un array that came from cookie or default settings
         */
        getCookieData: function() {
            var cookie = Cookies.get(wiz_ajax.cookieName);
            if (cookie) {
                cookie = decodeURIComponent(cookie);
                if (strpos(cookie, "=", 0)) {
                    wiz_ajax.cookieContent = parseQuery(cookie);
                    
                }
            } else {
                wiz_ajax.cookieContent = wiz_ajax.defaultSettings;
            }
            return wiz_ajax.cookieContent;
        },
		
		setCookieData: function ( data ){
		alert('save this informations:' + data);
		},
        onHideModal: function() {
            this.modal.live('hide.bs.modal', function() {
                $.scrollTo($('#product-section'), 600, {
                    easing: 'swing'
                });
				wiz_ajax.loadSummary();
            });
        },
        loadPrecompiledForm: function() {
            var testx = wiz_ajax.getCookieData();
            try {
                if (testx === '') {
                    throw 'wiz_ajax.getCookieData() non sta funzionando';
                }
                wiz_ajax.prodID = testx.wizard_product_id;
                $.when(
                        $("#custom-section .loader").show(),
                        wiz_ajax.setForm(),
                        wiz_ajax.getFields(),
                        wiz_ajax.updateProductImage(),
                        wiz_ajax.getModal()
                    )
                    .then(function() {
                        $("#custom-section .loader").hide();
                        $("#custom-section .x-content").html(wiz_ajax.formData);
                        $("#stage").html(wiz_ajax.fieldsData);
                        $("#stage").addClass ( wiz_ajax.getCat); 
                        $("#stage .stage_bg").css('background-image', 'url(' + wiz_ajax.prodImg + ')');
                        $("#product-section .x-content").empty();
                        $('#modal-wrapper').html(wiz_ajax.modal);
                    });
            } catch (e) {
				if ( typeof console !== 'undefined' && console.error ) {
                console.log(e);
				}
            }
        },
        editorUpdateOnKeyup: function() {
            this.editorFields.live('keyup', this.setFieldsEditor);
            wiz_ajax.form.live('change', this.serialize);
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
        emptyForm: function() {
            if (!wiz_ajax.prodID) {
                $("#mi-slider :checked").each(function() {
                    wiz_ajax.prodID = $(this).attr('value');
                });
            } else {
            }
        },
        serialize: function() {
            wiz_ajax.post = $('form').serialize();
        },
        setAjax: function() {
            try {
                if (!wiz_ajax.formData) {
                    throw 'wiz_ajax.formData è vuoto';
                } else if (!wiz_ajax.fieldsData) {
                    throw 'wiz_ajax.fieldsData è vuoto';
                } else if (!wiz_ajax.prodID) {
                    throw 'wiz_ajax.prodID è vuoto';
                } else if (!wiz_ajax.prodID) {
                    throw 'wiz_ajax.prodID è vuoto';
                }
                $.when(
                        $("#custom-section .loader").show(),
						$('#product-focus').css({ opacity: 0.5 }),
						wiz_ajax.resetSummary(),
                        wiz_ajax.setForm(),
                        wiz_ajax.getFields(),
                        wiz_ajax.updateProductImage(),
                        wiz_ajax.getModal()
                    )
                    .then(function() {
                        $("#custom-section .loader").hide();
						
                        $("#custom-section .x-content").html(wiz_ajax.formData);
                        $("#stage").html(wiz_ajax.fieldsData);
                        $("#stage .stage_bg").css('background-image', 'url(' + wiz_ajax.prodImg + ')');
                        $("#product-section .x-content").empty();
                        $('#modal-wrapper').html(wiz_ajax.modal);
						$('#product-focus').css({ opacity: 1.0 });
                    });
            } catch (e) {
               if ( typeof console !== 'undefined' && console.error ) {
                console.log(e);
				}
            }
        },
        focusProductChange: function() {
            $("#mi-slider :checked").each(function() {
                wiz_ajax.prodID = $(this).attr('value');
                wiz_ajax.setAjax();
                $.when(
                        $("#custom-section .loader").show(),
                        wiz_ajax.setForm(),
                        wiz_ajax.getFields(),
                        wiz_ajax.updateProductImage(),
                        wiz_ajax.getModal()
                    )
                    .then(function() {
                        $("#custom-section .loader").hide();
                        $("#custom-section .x-content").html(wiz_ajax.formData);
                        $("#stage").html(wiz_ajax.fieldsData);
						
                        $("#product-section .x-content").empty();
                        $('#modal-wrapper').html(wiz_ajax.modal);
                    });
            });
        },
        afterEditorComplete: function(event) {
            event.preventDefault();
            wiz_ajax.updateModal();
			
            $('#sum_prod_price').html("<div class='loader'> </div>");
            $.when(
                    $("#product-section .loader").show(),
                    wiz_ajax.getProduct()
                )
                .then(
                    function() {
                        $("#product-section .loader").hide();
                        wiz_ajax.setProduct();
                        wiz_ajax.updateSummary();
                    });
        },
        afterProductSelect: function() {
            $("#cat_opt input:checked").each(function() {
                wiz_ajax.productItem = $(this).attr('value');
                $.when(
                        wiz_ajax.getProduct()
                    )
                    .then(function() {
                        $('#product-editor #stage').html(wiz_ajax.productHTML);
                    });
            });
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
        setCookie: function() {
            var inFifteenMinutes = new Date(new Date().getTime() + 15 * 60 * 1000);
            Cookies.set('config', true, {
                expires: inFifteenMinutes
            });
        },
        setForm: function() {
            $('.loaderImage').show();
            return $.ajax({
                url: wiz_ajax.callUrl,
                method: 'POST',
                data: {
                    'action': 'wiz_get_form',
                    'selection': wiz_ajax.prodID
                },
                success: function(data) {
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
        getCat: function() {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_get_cat',
                    'selection': wiz_ajax.prodID
                },
                success: function(data) {
                    wiz_ajax.catID = data;
                    return wiz_ajax.catID;
                },
            });
        },
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
        updateProductImage: function() {
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
		
		 preloadImages: function() {
            return $.ajax({
                url: wiz_ajax.callUrl,
                data: {
                    'action': 'wiz_preload_images',
                },
				 
                success: function(data) {
                   
					$( "body" ).append( "<div id='loader' style='display:none' ></div>" );
					var jsonData = (data);
					
					for (var key in jsonData) {
						  if (jsonData.hasOwnProperty(key)) {
							  wiz_ajax.preloadedImages[key] = jsonData[key];
							$('body').find('#loader').append('<img src="' + jsonData[key] + '" />' );
							
						  }
						}
						
				
                },
				dataType: "json"
            });
        },
		
		 resetSummary: function() {
         wiz_ajax.summary.animate({
                    'marginBottom':'-110px'
                },200);
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
	loadSummary: function() {
         wiz_ajax.summary.animate({
                    'marginBottom':'0px'
                },200);
    }
    };
	
       
    wiz_ajax.init();
});
