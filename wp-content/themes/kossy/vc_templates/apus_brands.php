<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$bcol = 12/$columns;

if($columns == 5) $bcol='c5';

if ( !class_exists('Kossy_Woo_Brand') ) {
	return;
}
$brands = Kossy_Woo_Brand::get_brands($number);

?>
<div class="widget-brands <?php echo esc_attr($el_class.$style); ?>">
    <?php if ($title!=''): ?>
        <h3 class="widget-title text-center">
            <span><?php echo esc_attr( $title ); ?></span>
        </h3>
    <?php endif; ?>
    <div class="widget-content">
    	<?php if ( ! empty( $brands ) && ! is_wp_error( $brands ) ): ?>
    		<?php if ( $layout_type == 'carousel' ): ?>
				<div class="slick-carousel" data-carousel="slick" data-items="<?php echo esc_attr($columns); ?>" <?php echo trim($columns>=5?'data-large="5"':''); ?> data-smallmedium="4" data-extrasmall="3" data-smallest="3" data-pagination="false" data-nav="true">
		    		<?php foreach ($brands as $brand) { ?>
    					<div class="item">
							<a href="<?php echo esc_url( get_term_link( $brand ) ); ?>">
								<?php
								$image = get_woocommerce_term_meta( $brand->term_id, 'product_brand_image', true );
								?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php esc_attr_e('Image', 'kossy'); ?>" />
							</a>
						</div>
		    		<?php } ?>
	    		</div>
	    	<?php else: ?>
	    		<div class="row no-margin style-grid">
		    		<?php $count=1; foreach ($brands as $brand) { ?>
		    			<?php if($count%$columns == 1) echo '<div class="clearfix list-row flex-middle">'; ?>
    					<div class="item col-md-<?php echo esc_attr($bcol); ?> col-xs-6 <?php if($count%$columns == 1) echo 'first-child'; if($count%$columns == 0) echo 'last-child'; ?>">
							<a href="<?php echo esc_url( get_term_link( $brand ) ); ?>">
								<?php
								$image = get_woocommerce_term_meta( $brand->term_id, 'product_brand_image', true );
								?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php esc_attr_e('Image', 'kossy'); ?>" />
							</a>
						</div>
						<?php 
							if($count%$columns == 0 || (count($brands ) == $count) ) echo '</div>';
						?>
		    		<?php $count++; } ?>
	    		</div>
	    	<?php endif; ?>
    	<?php endif; ?>
    </div>
</div>