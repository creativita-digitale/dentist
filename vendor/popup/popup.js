var modal = (function($){
				var 
				method = {},
				$overlay,
				$modal,
				$content,
				$close;

				// Center the modal in the viewport
				method.center = function () {
					var top, left;

					top = Math.max(jQuery(window).height() - $modal.outerHeight(), 0) / 2;
					left = Math.max(jQuery(window).width() - $modal.outerWidth(), 0) / 2;

					$modal.css({
						top:top + jQuery(window).scrollTop(), 
						left:left + jQuery(window).scrollLeft()
					});
				};

				// Open the modal
				method.open = function (settings) {
					$content.empty().append(settings.content);

					$modal.css({
						width: settings.width || 'auto', 
						height: settings.height || 'auto'
					});

					method.center();
					jQuery(window).bind('resize.modal', method.center);
					$modal.show();
					$overlay.show();
				};

				// Close the modal
				method.close = function () {
					$modal.hide();
					$overlay.hide();
					$content.empty();
					jQuery(window).unbind('resize.modal');
				};

				// Generate the HTML and add it to the document
				$overlay = jQuery('<div id="pp_overlay"></div>');
				$modal = jQuery('<div id="pp_modal"></div>');
				$content = jQuery('<div id="pp_content"></div>');
				$close = jQuery('<a id="pp_close" href="#">close</a>');

				$modal.hide();
				$overlay.hide();
				$modal.append($content, $close);

				jQuery(document).ready(function($){
					$('body').append($overlay, $modal);						
				});

				$close.click(function(e){
					e.preventDefault();
					method.close();
				});

				return method;
			}());
			