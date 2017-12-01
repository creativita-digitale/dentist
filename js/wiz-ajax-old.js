jQuery(function($) {
	var globalStore = {};
	var ajax_url = 'https://silvercaredentist.com/wp-admin/admin-ajax.php';
	var str = "";

	var product_opt = '#product_opt';

	$('#product_opt input').live("change", function(e) {

		var $loading = $('.loader').hide();

		$("#product_opt input:checked").each(function() {
			str = $(this).attr('value');
		});
		$.when(
			$.ajax({
				url: ajax_url,
				data: {
					'action': 'example_ajax_request',
					'selection': str
				},
				success: function(data) {
					// This outputs the result of the ajax request
					//console.log(data);
					globalStore.img = data;
					console.log(globalStore.img);
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			}),
			// Get the CSS
			$.ajax({
				url: ajax_url,
				data: {
					'action': 'show_slider_callback',
					'selection': str
				},
				success: function(data) {
					// This outputs the result of the ajax request
					//console.log(data);
					globalStore.form = data;
					console.log(globalStore.form);
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			})
		).then(function() {
			// All is ready now, so...
			// Add CSS to page
			$(".hero-img .stage_bg").css('background-image', 'url("' + globalStore.img + '")');
			// Add HTML to page
			$("#custom-section .x-content").html(globalStore.form);

		})

	});
	$('#custom-section #submitBtn').live("click", function(event) {
		event.preventDefault();
		$("#product_opt input:checked").each(function() {
			str = $(this).attr('value');
		});
		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: {
				"action": "load-filter",
				cat: str
			},
			success: function(response) {
				console.log(response);
				$("#product-section .x-content").html(response);
				return false;
			},
			error: function(errorThrown) {
				console.log(errorThrown);
			}
		});
	})

	// ultima fase: l'utente ha scelto tutto
	var prod_select = "";

	$('#cat_opt').live("change", function(e) {

		$("#cat_opt input:checked").each(function() {

			prod_select = $(this).attr('value');
			console.log('this is: prod_select early ' + prod_select);
		});
		$.when(
			$.ajax({
				url: ajax_url,
				data: {
					'action': 'wiz_getsingle_product',
					'selection': prod_select
				},
				success: function(data) {
					console.log('this is: prod_select coming back ' + data)
					$('#product-editor #stage').html(data);

				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			})
		).then(function() {
			// All is ready now, so...
			// Add CSS to page
			// $(".hero-img .stage_bg").css('background-image', 'url("' + globalStore.img + '")');
			// Add HTML to page
			// $("#custom-section .x-content").html(globalStore.form);
			// window.alert('hello');
		});
	});




	$(document).ajaxSuccess(function() {
		$('#custom-section input,  #custom-section textarea,  #custom-section select').each(function(index) {
			if (this.id == 'wizard_background') {
				$('.' + this.id + '_text').attr('src', this.value);
			} else {
				$('.' + this.id + '_text').html(this.value);
			}
		});
		$(".log").text("Triggered ajaxSuccess handler.");
	});
	$('#custom-section input,  #custom-section textarea, #custom-section select').live("keyup", function(e) {
		$(this).each(function(index) {
			$('.' + this.id + '_text').html(this.value);
		});
	});
	$("#custom-section select ").change(function(e) {
		$('.' + this.id + '_text').attr('src', this.value);
	});
});