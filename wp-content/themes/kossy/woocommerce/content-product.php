<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
	
$woo_display = kossy_woocommerce_get_display_mode();

if ( $woo_display == 'list' ) { 	
	$classes[] = 'list-products col-xs-12';
?>
	<div <?php wc_product_class( $classes, $product ); ?>>
	 	<?php wc_get_template_part( 'item-product/inner', 'list' ); ?>
	</div>
<?php
} elseif ( $woo_display == 'mansory-v1' ) {
	// Store loop count we're currently on
	if ( empty( $woocommerce_loop['loop'] ) ) {
		$woocommerce_loop['loop'] = 0;
		$nb_per_page = kossy_get_config('number_products_per_page', 12);
		if ( isset($current_page) ) {
			$woocommerce_loop['loop'] = ((int)$current_page - 1) * $nb_per_page;
		}
	}

	$args = array();
	if ( in_array($woocommerce_loop['loop']%12, array(0,9)) ) {
		$classes[] = 'col-md-6 col-sm-6 col-xs-6 isotope-item';
		$args = array('image_size' => 'kossy-shop-large');
	} elseif ( in_array($woocommerce_loop['loop']%12, array(5,6)) ) {
		$classes[] = 'col-md-6 col-sm-6 col-xs-6 isotope-item';
		$args = array('image_size' => 'kossy-shop-horizontal');
	} else {
		$classes[] = 'col-md-3 col-sm-3 col-xs-6 isotope-item';
		$args = array('image_size' => 'kossy-shop-small');
	}
	?>

	<div <?php wc_product_class( $classes, $product ); ?>>
	 	<?php wc_get_template( 'item-product/inner-center.php', $args ); ?>
	</div>

<?php
} elseif ( $woo_display == 'mansory-v2' ) {
	// Store loop count we're currently on
	if ( empty( $woocommerce_loop['loop'] ) ) {
		$woocommerce_loop['loop'] = 0;
		$nb_per_page = kossy_get_config('number_products_per_page', 12);
		if ( isset($current_page) ) {
			$woocommerce_loop['loop'] = ((int)$current_page - 1) * $nb_per_page;
		}
	}

	$args = array();
	if ( in_array($woocommerce_loop['loop']%12, array(0,10)) ) {
		$classes[] = 'col-md-6 col-sm-6 col-xs-6 isotope-item';
		$args = array('image_size' => 'kossy-shop-largest');
	} elseif ( in_array($woocommerce_loop['loop']%12, array(3,11)) ) {
		$classes[] = 'col-md-6 col-sm-6 col-xs-6 isotope-item';
		$args = array('image_size' => 'kossy-shop-horizontal');
	} else {
		$classes[] = 'col-md-3 col-sm-3 col-xs-6 isotope-item';
		$args = array('image_size' => 'kossy-shop-normal');
	}
	?>

	<div <?php wc_product_class( $classes, $product ); ?>>
	 	<?php wc_get_template( 'item-product/inner-center.php', $args ); ?>
	</div>

<?php
} else {

	// Store loop count we're currently on
	if ( empty( $woocommerce_loop['loop'] ) ) {
		$woocommerce_loop['loop'] = 0;
	}
	// Store column count for displaying the grid
	
	$woocommerce_loop['columns'] = kossy_woocommerce_shop_columns(4);
	

	$columns = 12/$woocommerce_loop['columns'];
	if($woocommerce_loop['columns'] == 5){
		$columns = 'col-md-cus-5';
	}
	if($woocommerce_loop['columns'] >=4 ){
		$classes[] = 'col-lg-'.$columns.' col-md-4 col-sm-4 col-xs-6 ';
	}else{
		$classes[] = 'col-md-'.$columns.' col-sm-6 col-xs-6 ';
	}

	$inner = kossy_get_config('product_item_style', 'inner');
	?>
	<div <?php wc_product_class( $classes, $product ); ?>>
		<?php wc_get_template_part( 'item-product/'.$inner ); ?>
	</div>
<?php } ?>