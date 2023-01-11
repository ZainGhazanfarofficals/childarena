<?php global $woocommerce; ?>
<div class="apus-topcart">
 	<div class="cart">
        <a class="mini-cart" href="#">
            <i class="icon_cart_alt"></i>
            <span class="count"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></span>
        </a>   
    </div>
</div>