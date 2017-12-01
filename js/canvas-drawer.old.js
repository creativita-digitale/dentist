jQuery(function() {
					
					var current_cat_id =  js_object.cookie_cat;
					var canvas = document.getElementById( "test-immagine" );
					var context = canvas.getContext( "2d" );
					var img = document.getElementById( "scream" );
					
					//creo la base di gioco
					crea_base ();
					// catturo le informaziona dal form
					var message = jQuery( "#wizard_fullname" ).val();
	
					var wizard_fullname = jQuery( "#wizard_fullname" ).val();
					var wizard_tel_email = jQuery( "#wizard_tel_email" ).val();
					var wizard_tel = jQuery( "#wizard_tel" ).val();
					var wizard_email = jQuery( "#wizard_email" ).val();
					var wizard_address = jQuery( "#wizard_address" ).val();
					var wizard_city_postcode = jQuery( "#wizard_city_postcode" ).val();
					
					drawScreen();
									
					function crea_base (){
						
						var canvas = document.getElementById( "test-immagine" );
					var context = canvas.getContext( "2d" );
					var img = document.getElementById( "scream" );
						context.drawImage( img, 0, 10 );
						context.font = "15px Arial";
						context.fillStyle = "#ffffff";
					}					
											
					function textBoxChanged(e) {
						var target = e.target;
      					message = target.value;
						drawScreen();
					}
					   
					jQuery( "#wizard_fullname" ).keyup(function(e) {
						console.log( e );	
						 textBoxChanged(e);
						  
					});
							
					function drawScreen() {
						crea_base ();
						
						context.font = "15px Arial";
						context.fillStyle = "#ffffff";
						context.fillText  (message, 300, 190);
						var imgData = canvas.toDataURL("image/jpeg", 1.0);
						jQuery( "#image_data" ).val( imgData );
					}
					
					
					
					
					
					
					jQuery( "#pdf" ).click(function(event) {
						
						event.preventDefault();
						var imgData = canvas.toDataURL("image/jpeg", 1.0);
						jQuery( "#image_data" ).val( imgData );
						
						var pdf = new jsPDF();
				
						pdf.addImage(imgData, 'JPEG', 0, 0);
					 	pdf.save("download.pdf");
					});				
				});