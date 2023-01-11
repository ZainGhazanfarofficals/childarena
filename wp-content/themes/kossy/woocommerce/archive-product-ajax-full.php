<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$show_taxonomy_description = is_product_taxonomy() ? true : false;

$display_mode = kossy_woocommerce_get_display_mode();

?> 

<?php
	// Page title
	printf( '<div id="apus-wp-title">%s</div>', wp_title( '&ndash;', false, 'right' ) );
?>

<?php 
	// Shop header
	wc_get_template_part( 'content', 'product_header' );
?>


<div id="apus-shop-products-wrapper" class="apus-shop-products-wrapper" data-layout_type="<?php echo esc_attr($display_mode); ?>">
<?php
	// Results bar/button
	wc_get_template_part( 'content', 'product_results_bar' );
	
	// Taxonomy description
	if ( $show_taxonomy_description ) {
		/**
		 * woocommerce_archive_description hook
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
	}
	
	if ( have_posts() ) {

		global $woocommerce_loop, $wp_query;
		
		woocommerce_product_loop_start();
            ?>
            <?php woocommerce_product_subcategories( array( 'before' => '<div class="row subcategories-wrapper">', 'after' => '</div>' ) ); ?>
            
            <?php
				$display_mode = kossy_woocommerce_get_display_mode();
				$attr = 'class="products-wrapper-'.esc_attr($display_mode).'"';
				if ( $display_mode == 'mansory-v1' || $display_mode == 'mansory-v2' ) {
					$attr = 'class="products-wrapper-mansory isotope-items row" data-isotope-duration="400" data-columnwidth=".col-sm-3"';
				}
			?>
			<div <?php echo trim($attr); ?>>
				<?php if ( $display_mode == 'list' || $display_mode == 'grid' ) { ?>
					<div class="row row-products-wrapper">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endwhile; // end of the loop. ?>
					</div>
				<?php } else { ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; // end of the loop. ?>
				<?php } ?>
			</div>
            <?php
		woocommerce_product_loop_end();
		
		do_action( 'woocommerce_after_shop_loop' );
		do_action( 'woocommerce_after_main_content' );
		
	} elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) {

		wc_get_template( 'loop/no-products-found.php' );

	}
?>
</div>
