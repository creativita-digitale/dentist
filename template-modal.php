<?php 
	$id = wc_clean( intval ( $_REQUEST['selection'] ) );
	$selection = wizard_wc_cat_id ( trim($id," ") );
	$lang =$_COOKIE['_icl_current_language'];
    $options = get_option( $lang.'_axl_dentist_options' );
?>

<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h3><?php _e('Check edits','scdentist'); // Conferma invio ?></h3>
							</div>
							<div class="modal-body">
							
							<?php if( ! $id == $options['box_custom_id'] ) { ?> <p> <?php _e('Please review your entry before proceeding.','scdentist') // Rivedi i dati inseriti, prima di procedere?></p>  <?php } ?>
							
							<?php if ( $selection == $options['tooth_id'] ) : ?>
								
								<table class="table">
									<tr>
										<th><?php _e('Name and surname','scdentist'); // Nome e Cognome ?></th>
										<td id="rew_wizard_fullname"></td>
									</tr>
									<tr>
										<th><?php _e('Telephone or email','scdentist'); // Telefono o E-mail ?></th>
										<td id="rew_wizard_tel_email"></td>
									</tr>
								</table>
								
								<?php elseif ( $selection == $options['kit_id'] ): ?>
								
								<table class="table">
									<tr>
										<th><?php _e('Name and surname','scdentist'); // Nome e Cognome ?></th>
										<td id="rew_wizard_email"></td>
									</tr>
									<tr>
										<th></th>
										<td id="rew_wizard_fullname"></td>
									</tr>
									<tr>
										<th><?php _e('Telephone','scdentist'); // Telefono ?></th>
										<td id="rew_wizard_tel"></td>
									</tr>
									
									<tr>
										<th><?php _e('Address','scdentist'); // indirizzo ?></th>
										<td id="rew_wizard_address"></td>
									</tr>
                                    <tr>
										<th></th>
										<td id="rew_wizard_address_2"></td>
									</tr>
									<tr>
										<th><?php _e( 'Website / E-mail', 'scdentist'  ); // cap ?></th>
										<td id="rew_wizard_city_postcode"></td>
									</tr>
									
									
								</table>
								
								<?php elseif ( $selection == $options['box_id'] ): ?>
									<?php if( $id ==  $options['box_custom_id']): ?>
									<table class="table">
										<tr>
											<th><?php _e('Q.tity Ultra Fine Interdental Brushes x 100: ','scdentist'); // Scovolino ultra fine Q.tà x 100: ?></th>
											<td id="rew_wizard_scovolini_quantita_ultra_fine"></td>
										</tr>
										<tr>
											<th><?php _e('Q.tity Fine Interdental Brushes x 100: ','scdentist'); // Scovolino fine Q.tà x 100: ?></th>
											<td id="rew_wizard_scovolini_quantita_fine"></td>
										</tr>
										<tr>
											<th><?php _e('Q.tity Medium Interdental Brushes x 100: ','scdentist'); // Scovolino Medium Q.tà x 100: ?></th>
											<td id="rew_wizard_scovolini_quantita_medium"></td>
										</tr>
										
										<tr>
											<th><?php _e('Q.tity Large Interdental Brushes x 100: ','scdentist'); // Scovolino Large Q.tà x 100: ?></th>
											<td id="rew_wizard_scovolini_quantita_large"></td>
										</tr>
										<tr>
											<th><?php _e('Q.tity Extra Large Interdental Brushes x 100: ','scdentist'); // Scovolino Extra Large Q.tà x 100: ?></th>
											<td id="rew_wizard_scovolini_quantita_extra_large"></td>
										</tr>
										
										
										
									</table>
									
									<?php else: ?>
									<p> <?php _e('No customizations avaiable for this product ','scdentist'); // il prodotto non prevede configurazione ?>  </p>
									<?php endif; ?>
								<?php endif; ?>
									
								<div id="img-wrap">
							   	<div class="stage_bg"></div>
								</div>
							</div>
				
				  	<div class="modal-footer">
                    		<button type="button" id="edit" class="btn btn-success success pull-left" data-dismiss="modal"><?php _e('Edit','scdentist'); // Modifica ?></button>
							<button type="button" id="submit" class="btn btn-success success" data-dismiss="modal"><?php _e('Proceed','scdentist'); // indirizzo ?></button>
						</div>
					</div>
				</div>
                
                