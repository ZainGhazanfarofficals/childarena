<?php 
global $product;
$product_id = $product->get_id();
?>
<div class="product-block product-block-list" data-product-id="<?php echo esc_attr($product_id); ?>">
	<div class="row flex-middle">
		<div class="col-xs-4">	
			<div class="wrapper-image">
				<div class="inner">
				    <figure class="image">
				        <?php
		                $onsale_price = kossy_onsale_price_show();
		                if ($onsale_price && $product->is_type( 'simple' )) {?>
		                        <div class="downsale">-<?php echo wc_price($onsale_price); ?></div>
		                <?php } ?>
				        <a title="<?php echo esc_attr(get_the_title()); ?>" href="<?php the_permalink(); ?>" class="product-image">
				            <?php
				                /**
				                * woocommerce_before_shop_loop_item_title hook
				                *
				                * @hooked woocommerce_show_product_loop_sale_flash - 10
				                * @hooked woocommerce_template_loop_product_thumbnail - 10
				                */
				                remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 10);
				                do_action( 'woocommerce_before_shop_loop_item_title' );
				            ?>
				        </a>
				        <?php do_action('kossy_woocommerce_before_shop_loop_item'); ?>
				        <?php Kossy_Woo_Swatches::swatches_list( $image_size ); ?>
				    </figure>
				</div>    
			</div> 
		</div>  
		<div class="col-xs-8">	 
		    <div class="wrapper-info">
		    	<h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	            <?php
		            /**
		            * woocommerce_after_shop_loop_item_title hook
		            *
		            * @hooked woocommerce_template_loop_rating - 5
		            * @hooked woocommerce_template_loop_price - 10
		            */
		            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5);
		            do_action( 'woocommerce_after_shop_loop_item_title');
		        ?>
		        <div class="rating clearfix">
	                <?php
	                    $rating_html = wc_get_rating_html( $product->get_average_rating() );
	                    if ( $rating_html ) {
	                        echo trim( $rating_html );
	                    }
	                ?>
	            </div>
	            <div class="product-excerpt">
		            <?php the_excerpt(); ?>
		        </div>
		        <div class="bottom-list">
		        	<div class="cart-left">
		        		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		        	</div>
		        	<div class="wishlist-left">
		        		<?php
				            if ( class_exists( 'YITH_WCWL' ) ) {
				                echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
				            }
				        ?>
			        </div>
		        </div>
			</div>  
		</div>  
	</div>
</div>