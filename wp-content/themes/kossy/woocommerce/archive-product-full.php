<?php

get_header();
$sidebar_configs = kossy_get_woocommerce_layout_configs();

$display_mode = kossy_woocommerce_get_display_mode();
$layout_type = $display_mode;
if ( $display_mode == 'mansory-v1' || $display_mode == 'mansory-v2' ) {
	wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery', 'imagesloaded' ) );
}

?>
<?php do_action( 'kossy_woo_template_main_before' ); ?>

<section id="main-container" class="page-shop <?php echo apply_filters('kossy_woocommerce_content_class', 'container');?>">
	<?php do_action('kossy_woocommerce_archive_description'); ?>

	<?php kossy_before_content( $sidebar_configs ); ?>

	<?php if ( kossy_get_config('product_archive_top_categories') || kossy_get_config('product_archive_top_filter') ) : ?>
		<!-- header for full -->
		<?php
			wc_get_template_part( 'content', 'product_header' );
			
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_before_shop_loop', 'kossy_filter_before' , 1 );
			remove_action( 'woocommerce_before_shop_loop', 'kossy_filter_after' , 40 );
			remove_action( 'woocommerce_before_shop_loop', 'kossy_woocommerce_display_modes' , 2 );
		?>
	<?php endif; ?>
	<div class="row">
		<?php kossy_display_sidebar_left( $sidebar_configs ); ?>

		<div id="main-content" class="archive-shop col-xs-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">

			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					
					<div id="apus-shop-products-wrapper" class="apus-shop-products-wrapper" data-layout_type="<?php echo esc_attr($layout_type); ?>">
						<?php
                            // Results bar/button
                            wc_get_template_part( 'content', 'product_results_bar' );
                        ?>
						
                        <!-- product content -->
						<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
						<?php endif; ?>

						<?php do_action( 'woocommerce_archive_description' ); ?>

						<?php if ( have_posts() ) : ?>

							<?php do_action( 'woocommerce_before_shop_loop' ); ?>

							<?php woocommerce_product_loop_start(); ?>
								
								<?php woocommerce_product_subcategories( array( 'before' => '<div class="row subcategories-wrapper">', 'after' => '</div>' ) ); ?>
								
								<?php
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

							<?php woocommerce_product_loop_end(); ?>

							<?php do_action( 'woocommerce_after_shop_loop' ); ?>

						<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
							<?php do_action( 'woocommerce_no_products_found' ); ?>
						<?php endif; ?>

					</div>
				</div><!-- #content -->
			</div><!-- #primary -->
		</div><!-- #main-content -->
		
		<?php kossy_display_sidebar_right( $sidebar_configs ); ?>
		
	</div>
</section>
<?php

get_footer();
