<?php
add_action( 'tf_create_options', 'mytheme_create_options' );
function mytheme_create_options() {
    
$titan = TitanFramework::getInstance( 'Silvercaredentist' );

 $postMetaBox = $titan->createMetaBox( array(
    'name' => 'Suggerimenti',
    'post_type' => 'page',
) );

$postMetaBox->createOption( array(
    'name' => 'Design inverso',
    'id' => 'alt-color',
    'type' => 'checkbox',
    'desc' => 'Questa opzione attiva il design inverso: sfondo blu e testi chiari. Utilizzabile per pagine motivazionali. In genere disattiverà anche il titolo della pagina.',
    'default' => false,
) );

$postMetaBox->createOption( array(
    'name' => 'No titolo',
    'id' => 'no-title',
    'type' => 'checkbox',
    'desc' => 'Questa opzione rimuove il titolo dalla pagina.',
    'default' => false,
) );

$postMetaBox->createOption( array(
    'name' => 'No barra laterale',
    'id' => 'fullwidth',
    'type' => 'checkbox',
    'desc' => 'Questa opzione rimuove la barra laterale e consente al contenuto di estendersi per tutta la lunghezza. Alcune pagine hanno impostazioni non modificabili.',
    'default' => false,
) );


 $postMetaBox->createOption( array(
    'name' => 'Help!',
    'id' => 'help',
    'type' => 'textarea',
    'desc' => 'Aggiungere qui i suggerimenti che si vuole dare.'
) );




$titan = TitanFramework::getInstance( 'Silvercaredentist' );

$productMetaBox = $titan->createMetaBox( array(

    'name' => 'Immagine Configuratore',
	'post_type' => 'product',
	'context' => 'side',
	'priority' => 'core',

) );






$productMetaBox->createOption( array(
    'name' => 'Product Image Editor',
    'id' => 'product_image_editor',
    'type' => 'upload',
	
    'desc' => 'This is the image you see when configuring a product.'
) );


$productMainMetaBox = $titan->createMetaBox( array(

    'name' => 'Caratteristiche del prodotto',
	'post_type' => 'product',

	'priority' => 'core',

) );
$productMainMetaBox->createOption( array(
    'name' => 'Prezzo di listino (€)',
    'id' => 'price_display',
    'type' => 'text',
	
    'desc' => 'Il prezzo che verrà visualizzato'
) );
$productMainMetaBox->createOption( array(
    'name' => 'Prezzo in saldo (€)',
    'id' => 'price_discount',
    'type' => 'text',
	
    'desc' => 'Prezzo che verrà mostrato barrato'
) );

$productMainMetaBox->createOption( array(
    'name' => 'Quantità confezione',
    'id' => 'product_q',
    'type' => 'text',
	
    'desc' => 'Quantità di prodotto'
) );


// Create an admin page with a menu

$panel = $titan->createAdminPanel( array(

    'name' => 'Theme Options',

) );

 

// Create an admin tab inside the admin page above

$tab1 = $panel->createTab( array(

    'name' => 'Wizard',

) );

 


 $tab1->createOption( array(
    'name' => 'Select pages',
    'type' => 'heading',
) );


$tab1->createOption( array(

    'type' => 'note',

    'desc' => 'A note or an important reminder'

) );




$tab1->createOption( 
	array(

	'name' => 'Pagina Configuratore',

	'id' => 'config',

	'type' => 'select-pages',

	'desc' => 'Seleziona la pagina del configuratore'

	)
);

$tab1->createOption( array(
    'name' => 'Categoria Kit',
    'id' => 'kit_option',
    'type' => 'select-categories',
    'desc' => 'Seleziona la categoria che corrisponde al Kit',
    'taxonomy' => 'product_cat',
) );
$tab1->createOption( array(
    'name' => 'Categoria Spazzolini',
    'id' => 'spazzolini_option',
    'type' => 'select-categories',
    'desc' => 'Seleziona la categoria che corrisponde agli spazzolini',
    'taxonomy' => 'product_cat',
) );
$tab1->createOption( array(
    'name' => 'Categotia Scovolini',
    'id' => 'scovolini_option',
    'type' => 'select-categories',
    'desc' => 'Seleziona la categoria che corrisponde agli scovolini',
    'taxonomy' => 'product_cat',
) );


$tab1->createOption( array(
    'type' => 'save',
) );

$tab2 = $panel->createTab( array(

    'name' => 'Variabili',

) );

$tab2->createOption( array(
    'name' => 'My Textarea Option',
    'id' => 'dentist_footer_option',
    'type' => 'textarea',
    'desc' => 'This is our option'
) );



}