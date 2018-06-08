<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<?php  
	$framework = TitanFramework::getInstance( 'Silvercaredentist' );
	$currency_code = get_woocommerce_currency_symbol();
?>

<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">


	<div class="price">
		<del><?php echo $currency_code; ?> <?php echo $framework->getOption( 'price_display' , get_the_ID() ); ?></del>
		<strong><?php echo $currency_code; ?> <?php echo $framework->getOption( 'price_discount' , get_the_ID() ); ?></strong>
	</div>
								
	
	<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>
