
<div class="apus-offcanvas dark-menu-sidebar hidden-sm hidden-xs"> 
    <div class="offcanvas-top">
        <div class="logo-in-theme">
            <?php get_template_part( 'template-parts/logo/logo-white' ); ?>
        </div>
        <div class="clearfix">
            <div class="header-right pull-left">
                <div class="pull-right">
                    <?php if( is_user_logged_in() ){ ?>
                        <div class="top-wrapper-menu">
                            <a class="drop-dow"><i class="icon_lock_alt"></i></a>
                            <?php if ( has_nav_menu( 'top-menu' ) ) {
                                    $args = array(
                                        'theme_location' => 'top-menu',
                                        'container_class' => 'inner-top-menu',
                                        'menu_class' => 'nav navbar-nav topmenu-menu',
                                        'fallback_cb' => '',
                                        'menu_id' => '',
                                        'walker' => new Kossy_Nav_Menu()
                                    );
                                    wp_nav_menu($args);
                                }
                            ?>
                        </div>
                    <?php } else { ?>
                        <div class="top-wrapper-menu">
                            <a class="drop-dow"><i class="icon_lock_alt"></i></a>
                            <div class="inner-top-menu">
                                <ul class="nav navbar-nav topmenu-menu">
                                    <li><a class="login" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Sign in','kossy'); ?>"><?php esc_html_e('Login', 'kossy'); ?></a></li>
                                    <li><a class="register" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Register','kossy'); ?>"><?php esc_html_e('Register', 'kossy'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
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
    <div class="offcanvas-middle">
        <?php if ( has_nav_menu( 'primary' ) ) : ?>
            <div class="apus-offcanvas-body">
                <nav class="navbar navbar-offcanvas navbar-static" role="navigation">
                    <?php
                        $args = array(
                            'theme_location' => 'primary',
                            'container_class' => 'navbar-collapse navbar-offcanvas-collapse',
                            'menu_class' => 'nav navbar-nav main-mobile-menu',
                            'fallback_cb' => '',
                            'menu_id' => 'main-mobile-menu',
                            'walker' => new Kossy_Mobile_Menu()
                        );
                        wp_nav_menu($args);
                    ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>
    <div class="offcanvas-bottom">
        <?php if ( is_active_sidebar( 'sidebar-topbar-left' ) ) { ?>
            <div class="sidebar-topbar-left">
                <?php dynamic_sidebar( 'sidebar-topbar-left' ); ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="over-dark"></div>
