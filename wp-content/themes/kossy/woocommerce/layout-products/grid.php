<?php
global $woocommerce_loop; 
$woocommerce_loop['columns'] = $columns;
$product_item = isset($product_item) ? $product_item : 'inner';
?>
<div class="<?php echo trim($columns <= 1 ? 'w-products-list' : 'products products-grid');?>">
	<div class="row row-products <?php echo esc_attr($product_item == 'inner-center'?'gutter-10':''); ?>">
		<?php wc_set_loop_prop( 'loop', 0 ); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
			<?php wc_get_template( 'content-products.php', array('product_item' => $product_item) ); ?>
		<?php endwhile; ?>
	</div>
</div>
<?php wp_reset_postdata(); ?>