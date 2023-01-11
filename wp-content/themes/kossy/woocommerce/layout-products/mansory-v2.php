<?php
$ajax = isset($ajax) && $ajax ? true : false;
if ( !$ajax ) {
wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery', 'imagesloaded' ) );
?>
<div class="mansory-wrapper isotope-items mansory-v2 row" data-isotope-duration="400" data-columnwidth=".col-sm-3">
	<div class="row-products ">
<?php } ?>
		<?php wc_set_loop_prop( 'loop', 0 ); ?>
		<?php $count=0; while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
			
			<?php if ( in_array($count%12, array(0,9)) ) { ?>
				<div class="col-sm-6 isotope-item">
	 				<?php wc_get_template( 'item-product/inner-center.php', array('image_size' => 'kossy-shop-large') ); ?>
	 			</div>
			<?php } elseif ( in_array($count%12, array(3,8)) ) { ?>
				<div class="col-sm-6 isotope-item">
					<?php wc_get_template( 'item-product/inner-center.php', array('image_size' => 'kossy-shop-horizontal1') ); ?>
				</div>
			<?php } else { ?>
				<div class="col-sm-3 isotope-item">
					<?php wc_get_template( 'item-product/inner-center.php', array('image_size' => 'kossy-shop-small') ); ?>
				</div>
			<?php } ?>

		<?php $count++; endwhile; ?>
	
		<?php wp_reset_postdata(); ?>

<?php if ( !$ajax ) { ?>
	</div>
</div>
<?php }