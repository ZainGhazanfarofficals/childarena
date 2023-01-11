<div id="apus-mobile-menu" class="apus-offcanvas hidden-lg hidden-md"> 
    <div class="apus-offcanvas-body">
        <div class="offcanvas-head bg-primary">
            <a class="btn-toggle-canvas" data-toggle="offcanvas">
                <i class="ti-close"></i> <span><?php esc_html_e( 'Close', 'kossy' ); ?></span>
            </a>
        </div>
        <nav class="navbar navbar-offcanvas navbar-static" role="navigation">
            <div class="navbar-collapse navbar-offcanvas-collapse">
                <ul id="main-mobile-menu" class="nav navbar-nav main-mobile-menu">
                    <?php
                        $args = array(
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'nav navbar-nav',
                            'fallback_cb'     => false,
                            'walker' => new Kossy_Mobile_Menu(),
                            'items_wrap' => '%3$s',
                        );
                        wp_nav_menu($args);
                    ?>
                </ul>
            </div>
            <?php if ( kossy_get_config('show_login_register', true) ) { ?>
                <div class="navbar-collapse navbar-offcanvas-collapse">
                    <h4><span><?php echo esc_html__('My Account', 'kossy') ?></span></h4>
                    <ul class="nav navbar-nav main-mobile-menu">
                        <?php if( !is_user_logged_in() ){ ?>
                            <li><a class="login register-login-action" data-action="#customer_login" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Sign in','kossy'); ?>"><?php esc_html_e('Login', 'kossy'); ?></a></li>
                            <li><a class="register register-login-action" data-action="#customer_register" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Register','kossy'); ?>"><?php esc_html_e('Register', 'kossy'); ?></a></li>
                        <?php } else { ?>
                            <?php if ( has_nav_menu( 'top-menu' ) ): ?>
                                
                                <?php
                                    $args = array(
                                        'theme_location' => 'top-menu',
                                        'container' => false,
                                        'menu_class' => 'nav navbar-nav',
                                        'fallback_cb'     => false,
                                        'walker' => new Kossy_Mobile_Menu(),
                                        'items_wrap' => '%3$s',
                                    );
                                    wp_nav_menu($args);
                                ?>
                            <?php endif; ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </nav>
    </div>
</div>
<div class="over-dark"></div>