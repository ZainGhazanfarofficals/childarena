<?php global $woocommerce; ?>
<div class="apus-topcart">
 <div class="dropdown version-1 cart2">
        <a class="dropdown-toggle mini-cart" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'kossy'); ?>">
            <i class="icon-bag"></i>
        </a>   
        <span class="count"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?> <?php echo esc_html__('items','kossy'); ?></span>    
        <div class="dropdown-menu"><div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div></div>
    </div>
</div>