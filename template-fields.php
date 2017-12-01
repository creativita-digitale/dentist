<?php 
	$selection = wc_clean( intval ( $_REQUEST['selection'] ) );
	$selection = wizard_wc_cat_id ( trim($selection," ") );
	$lang = $_COOKIE['_icl_current_language'];
        
    $options = get_option( $lang.'_axl_dentist_options' );
?>

<?php if ( $selection == $options['tooth_id'] ) : ?>
	<div class="spazzolini">
		<div class="frame tooltip" title="Inserisci i dati relativi alla tua attività qui">
			<span class="wizard_fullname_text"></span>
			<span class="wizard_tel_email_text"></span>
		</div>
		
		<div class="stage_bg"></div>
		
    </div>
				
<?php elseif ( $selection == $options['kit_id'] ): ?>
	<div class="kit">
		<div class="frame">	
        	<span class="wizard_tel_text"></span>	
			<span class="wizard_fullname_text"></span>
			
			<span class="wizard_email_text"></span>
			<span class="wizard_address_text"></span>
            <span class="wizard_address_2_text"></span>
			<span class="wizard_city_postcode_text"></span>
		</div>
	<!-- <img class="wizard_background_text" src="" > -->
	<div class="stage_bg"></div>
    </div>

<?php elseif ( $selection == $options['box_id'] ): ?>
	<div class="scovolini">
		<div class="frame">	
        	<span class="wizard_ultra_fine_box"></span>	
			<span class="wizard_fine_box"></span>
			
			<span class="wizard_medium_box"></span>
			<span class="wizard_large_box"></span>
            <span class="wizard_extra_large"></span>
		</div>
	<!-- <img class="wizard_background_text" src="" > -->
	<div class="stage_bg"></div>
    </div>


<?php endif; ?>
				