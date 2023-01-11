<div id="apus-header-mobile" class="header-mobile hidden-lg hidden-md clearfix">    
    <div class="container">
        <div class="row">
            <div class="table-visiable">
                <div class="col-xs-3">
                    <div class="box-left">
                        <button data-toggle="offcanvas" class="btn btn-offcanvas btn-toggle-canvas offcanvas pull-left" type="button">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="col-xs-6 text-center">
                    <?php
                        $logo = kossy_get_config('media-mobile-logo');
                    ?>
                    <?php if( isset($logo['url']) && !empty($logo['url']) ): ?>
                        <div class="logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="logo logo-theme">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                <img src="<?php echo esc_url_raw( get_template_directory_uri().'/images/logo.png'); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-3">
                    <?php if ( defined('KOSSY_WOOCOMMERCE_ACTIVED') && kossy_get_config('show_cartbtn') && !kossy_get_config( 'enable_shop_catalog' ) ): ?>
                        <div class="box-right pull-right">
                            <!-- Setting -->
                            <div class="top-cart">
                                <?php get_template_part( 'woocommerce/cart/mini-cart-button' ); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ( class_exists( 'YITH_WCWL' ) ):
                        $wishlist_url = YITH_WCWL()->get_wishlist_url();
                    ?>
                        <div class="pull-right">
                            <a class="wishlist-icon" href="<?php echo esc_url($wishlist_url);?>" title="<?php esc_attr_e( 'View Your Wishlist', 'kossy' ); ?>">
                                <i class="icon_heart_alt"></i>
                                <?php if ( function_exists('yith_wcwl_count_products') ) { ?>
                                    <span class="count"><?php echo yith_wcwl_count_products(); ?></span>
                                <?php } ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>