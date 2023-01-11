<header id="apus-header" class="apus-header header-v6 hidden-sm hidden-xs" role="banner">
    <div class="<?php echo esc_attr(kossy_get_config('keep_header') ? 'main-sticky-header-wrapper' : ''); ?>">
        <div class="<?php echo esc_attr(kossy_get_config('keep_header') ? 'main-sticky-header' : ''); ?>">
                <div class="header-bottom container p-relative">
                    <div class="row">
                        <div class="table-visiable">
                            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                            <div class="col-lg-5 col-md-5 p-static">
                                <div class="pull-left">
                                    <span class="show-main-menu"><i class="ti-align-left"></i></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="logo-in-theme text-center">
                                    <?php get_template_part( 'template-parts/logo/logo' ); ?>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <div class="header-right clearfix">
                                    <?php kossy_login_register(); ?>
                                    <?php if ( defined('KOSSY_WOOCOMMERCE_ACTIVED') && kossy_get_config('show_cartbtn') && !kossy_get_config( 'enable_shop_catalog' ) ): ?>
                                        <div class="pull-right">
                                            <?php get_template_part( 'woocommerce/cart/mini-cart-button' ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( class_exists( 'YITH_WCWL' ) ):
                                        $wishlist_url = YITH_WCWL()->get_wishlist_url();
                                    ?>
                                        <div class="pull-right">
                                            <a class="wishlist-icon" href="<?php echo esc_url($wishlist_url);?>" title="<?php esc_attr_e( 'View Your Wishlist', 'kossy' ); ?>"><i class="icon_heart_alt"></i>
                                                <?php if ( function_exists('yith_wcwl_count_products') ) { ?>
                                                    <span class="count"><?php echo yith_wcwl_count_products(); ?></span>
                                                <?php } ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ( kossy_get_config('show_searchform') ){ ?>
                                        <div class="pull-right">
                                            <a class="btn-search-top"><i class="icon_search"></i></a>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>   
                    </div>   
                </div>
        </div>
    </div>
</header>
<?php if ( kossy_get_config('show_searchform') ): ?>
    <div class="search-header">
         <?php get_template_part( 'template-parts/productsearchform-nocategory' ); ?>
     </div>
<?php endif; ?>