<?php
$ajax = isset($ajax) && $ajax ? true : false;
if ( !$ajax ) {
wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery', 'imagesloaded' ) );
?>
<div class="mansory-wrapper isotope-items mansory-v3" data-isotope-duration="400" data-columnwidth=".col-sm-3">
	<div class="row-products gutter-10 row">
<?php } ?>
		<?php wc_set_loop_prop( 'loop', 0 ); ?>
		<?php $count=0; while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
			
			<?php if ( in_array($count%12, array(0,7)) ) { ?>
				<div class="col-sm-6 isotope-item">
	 				<?php wc_get_template( 'item-product/inner-center.php', array('image_size' => 'kossy-shop-largest') ); ?>
	 			</div>
			<?php } else { ?>
				<div class="col-sm-3 isotope-item">
					<?php wc_get_template( 'item-product/inner-center.php', array('image_size' => 'kossy-shop-large') ); ?>
				</div>
			<?php } ?>

		<?php $count++; endwhile; ?>
	
		<?php wp_reset_postdata(); ?>

<?php if ( !$ajax ) { ?>
	</div>
</div>
<?php }