<?php

if ( !function_exists('kossy_get_products') ) {
    function kossy_get_products( $args = array() ) {
        global $woocommerce, $wp_query;

        $args = wp_parse_args( $args, array(
            'categories' => array(),
            'product_type' => 'recent_product',
            'paged' => 1,
            'post_per_page' => -1,
            'orderby' => '',
            'order' => '',
            'includes' => array(),
            'excludes' => array(),
            'author' => '',
        ));
        extract($args);
        
        $query_args = array(
            'post_type' => 'product',
            'posts_per_page' => $post_per_page,
            'post_status' => 'publish',
            'paged' => $paged,
            'orderby'   => $orderby,
            'order' => $order
        );

        if ( isset( $query_args['orderby'] ) ) {
            if ( 'price' == $query_args['orderby'] ) {
                $query_args = array_merge( $query_args, array(
                    'meta_key'  => '_price',
                    'orderby'   => 'meta_value_num'
                ) );
            }
            if ( 'featured' == $query_args['orderby'] ) {
                $query_args = array_merge( $query_args, array(
                    'meta_key'  => '_featured',
                    'orderby'   => 'meta_value'
                ) );
            }
            if ( 'sku' == $query_args['orderby'] ) {
                $query_args = array_merge( $query_args, array(
                    'meta_key'  => '_sku',
                    'orderby'   => 'meta_value'
                ) );
            }
        }

        switch ($product_type) {
            case 'best_selling':
                $query_args['meta_key']='total_sales';
                $query_args['orderby']='meta_value_num';
                $query_args['ignore_sticky_posts']   = 1;
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'featured_product':
                $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['featured'],
                );
                break;
            case 'top_rate':
                add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'recent_product':
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'deals':
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $query_args['meta_query'][] =  array(
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    )
                );
                break;     
            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $query_args['post__in'] = $product_ids_on_sale;
                break;
            case 'recent_review':
                if($post_per_page == -1) $_limit = 4;
                else $_limit = $post_per_page;
                global $wpdb;
                $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c
                        WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0
                        ORDER BY c.comment_date ASC";
                $results = $wpdb->get_results($query, OBJECT);
                $_pids = array();
                foreach ($results as $re) {
                    if(!in_array($re->comment_post_ID, $_pids))
                        $_pids[] = $re->comment_post_ID;
                    if(count($_pids) == $_limit)
                        break;
                }

                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $query_args['post__in'] = $_pids;

                break;
            case 'rand':
                $query_args['orderby'] = 'rand';
                break;
            case 'recommended':

                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = array(
                    'key' => '_apus_recommended',
                    'value' => 'yes',
                );
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'recently_viewed':
                $viewed_products = ! empty( $_COOKIE['apus_woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['apus_woocommerce_recently_viewed'] ) : array();
                $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

                if ( empty( $viewed_products ) ) {
                    return false;
                }
                $query_args['post__in'] = $viewed_products;
                break;
        }

        if ( !empty($categories) && is_array($categories) ) {
            $query_args['tax_query'][] = array(
                'taxonomy'      => 'product_cat',
                'field'         => 'slug',
                'terms'         => implode(",", $categories ),
                'operator'      => 'IN'
            );
        }

        if (!empty($includes) && is_array($includes)) {
            $query_args['post__in'] = $includes;
        }
        
        if ( !empty($excludes) && is_array($excludes) ) {
            $query_args['post__not_in'] = $excludes;
        }

        if ( !empty($author) ) {
            $query_args['author'] = $author;
        }

        return new WP_Query($query_args);
    }
}

if ( !function_exists('kossy_woocommerce_get_categories') ) {
    function kossy_woocommerce_get_categories() {
        $return = array( esc_html__(' --- Choose a Category --- ', 'kossy') => '' );

        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'taxonomy' => 'product_cat'
        );

        $categories = get_categories( $args );
        kossy_get_category_childs( $categories, 0, 0, $return );

        return $return;
    }
}

if ( !function_exists('kossy_get_category_childs') ) {
    function kossy_get_category_childs( $categories, $id_parent, $level, &$dropdown ) {
        foreach ( $categories as $key => $category ) {
            if ( $category->category_parent == $id_parent ) {
                $dropdown = array_merge( $dropdown, array( str_repeat( "- ", $level ) . $category->name => $category->slug ) );
                unset($categories[$key]);
                kossy_get_category_childs( $categories, $category->term_id, $level + 1, $dropdown );
            }
        }
    }
}

// hooks
function kossy_woocommerce_enqueue_styles() {
    wp_enqueue_style( 'kossy-woocommerce', get_template_directory_uri() .'/css/woocommerce.css' , 'kossy-woocommerce-front' , KOSSY_THEME_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts', 'kossy_woocommerce_enqueue_styles', 99 );

function kossy_woocommerce_enqueue_scripts() {
    
    wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/js/sticky-kit.js', array( 'jquery' ), '20150330', true );
    
    wp_register_script( 'kossy-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array( 'jquery', 'jquery-unveil', 'slick' ), '20150330', true );

    $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : site_url();
    $options = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'enable_search' => (kossy_get_config('enable_autocompleate_search', true) ? '1' : '0'),
        'template' => apply_filters( 'kossy_autocompleate_search_template', '<a href="{{url}}" class="media autocompleate-media"><div class="media-left media-middle"><img src="{{image}}" class="media-object" height="100" width="100"></div><div class="media-body media-middle"><h4>{{{title}}}</h4><p class="price">{{{price}}}</p></div></a>' ),
        'empty_msg' => apply_filters( 'kossy_autocompleate_search_empty_msg', esc_html__( 'Unable to find any products that match the currenty query', 'kossy' ) ),

        'success'       => sprintf( '<div class="woocommerce-message">%s <a class="button btn btn-primary btn-inverse wc-forward" href="%s">%s</a></div>', esc_html__( 'Products was successfully added to your cart.', 'kossy' ), $cart_url, esc_html__( 'View Cart', 'kossy' ) ),
        'empty'         => sprintf( '<div class="woocommerce-error">%s</div>', esc_html__( 'No Products selected.', 'kossy' ) ),
        'nonce' => wp_create_nonce( 'ajax-nonce' ),
        'view_more_text' => esc_html__('View More', 'kossy'),
        'view_less_text' => esc_html__('View Less', 'kossy'),
    );
    wp_localize_script( 'kossy-woocommerce', 'kossy_woo_options', $options );
    wp_enqueue_script( 'kossy-woocommerce' );
    
    wp_enqueue_script( 'wc-add-to-cart-variation' );
}
add_action( 'wp_enqueue_scripts', 'kossy_woocommerce_enqueue_scripts', 10 );

// cart
if ( !function_exists('kossy_woocommerce_header_add_to_cart_fragment') ) {
    function kossy_woocommerce_header_add_to_cart_fragment( $fragments ){
        global $woocommerce;
        $fragments['.cart .count'] =  ' <span class="count"> '. $woocommerce->cart->cart_contents_count .' </span> ';
        $fragments['.footer-mini-cart .count'] =  ' <span class="count"> '. $woocommerce->cart->cart_contents_count .' </span> ';
        $fragments['.cart .total-minicart'] = '<div class="total-minicart">'. $woocommerce->cart->get_cart_total(). '</div>';
        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'kossy_woocommerce_header_add_to_cart_fragment' );

// breadcrumb for woocommerce page
if ( !function_exists('kossy_woocommerce_breadcrumb_defaults') ) {
    function kossy_woocommerce_breadcrumb_defaults( $args ) {
        $breadcrumb_img = kossy_get_config('woo_breadcrumb_image');
        $breadcrumb_color = kossy_get_config('woo_breadcrumb_color');
        $style = array();
        $show_breadcrumbs = kossy_get_config('show_product_breadcrumbs', true);
        $has_bg = '';
        $is_detail = '';
        if ( !$show_breadcrumbs ) {
            $style[] = 'display:none';
        }
        if( $breadcrumb_color  ){
            $style[] = 'background-color:'.$breadcrumb_color;
        }
        if(!is_single()){
            if ( isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) ) {
                $style[] = 'background-image:url(\''.esc_url($breadcrumb_img['url']).'\')';
                $has_bg = 'has_bg';
            }
        }
        $estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";
        if ( is_single() ) {
            $title = '';
            $is_detail = ' woo-detail ';

        } elseif ( is_product_category() ) {
            global $wp_query;
            $category_name = $wp_query->query_vars['product_cat'];
            $title = '<h2 class="bread-title">'.$category_name.'</h2>';
        } else {
            $title = '<h2 class="bread-title">'.esc_html__('Products List', 'kossy').'</h2>';
        }

        $full_width = apply_filters('kossy_woocommerce_content_class', 'container');
        
        $args['wrap_before'] = '<section id="apus-breadscrumb" class="apus-breadscrumb woo-breadcrumb '.$is_detail.$has_bg.'"'.$estyle.'><div class="'.$full_width.'"><div class="wrapper-breads '.$has_bg.'"><div class="wrapper-breads-inner">'.$title.'
        <ol class="breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';
        $args['wrap_after'] = '</ol></div></div></div></section>';

        return $args;
    }
}
add_filter( 'woocommerce_breadcrumb_defaults', 'kossy_woocommerce_breadcrumb_defaults' );
add_action( 'kossy_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );

// display woocommerce modes
if ( !function_exists('kossy_woocommerce_display_modes') ) {
    function kossy_woocommerce_display_modes(){
        global $wp;
        $current_url = kossy_shop_page_link(true);

        $url_grid = add_query_arg( 'display_mode', 'grid', remove_query_arg( 'display_mode', $current_url ) );
        $url_list = add_query_arg( 'display_mode', 'list', remove_query_arg( 'display_mode', $current_url ) );
        $url_mansory_v1 = add_query_arg( 'display_mode', 'mansory-v1', remove_query_arg( 'display_mode', $current_url ) );
        $url_mansory_v2 = add_query_arg( 'display_mode', 'mansory-v2', remove_query_arg( 'display_mode', $current_url ) );

        $woo_mode = kossy_woocommerce_get_display_mode();

        echo '<div class="display-mode pull-right">';
        echo '<a href="'.  $url_grid  .'" class=" change-view '.($woo_mode == 'grid' ? 'active' : '').'"><i class="ti-layout-grid3"></i></a>';
        echo '<a href="'.  $url_list  .'" class=" change-view '.($woo_mode == 'list' ? 'active' : '').'"><i class="ti-view-list-alt"></i></a>';
        echo '<a href="'.  $url_mansory_v1  .'" class=" change-view '.($woo_mode == 'mansory-v1' ? 'active' : '').'"><i class="ti-view-list-alt"></i></a>';
        echo '<a href="'.  $url_mansory_v2  .'" class=" change-view '.($woo_mode == 'mansory-v2' ? 'active' : '').'"><i class="ti-view-list-alt"></i></a>';
        echo '</div>'; 
    }
}

if ( !function_exists('kossy_woocommerce_get_display_mode') ) {
    function kossy_woocommerce_get_display_mode() {
        $woo_mode = kossy_get_config('product_display_mode', 'grid');
        $args = array( 'grid', 'list', 'mansory-v1', 'mansory-v2' );
        if ( isset($_COOKIE['kossy_woo_mode']) && in_array($_COOKIE['kossy_woo_mode'], $args) ) {
            $woo_mode = $_COOKIE['kossy_woo_mode'];
        }
        return $woo_mode;
    }
}

if(!function_exists('kossy_shop_page_link')) {
    function kossy_shop_page_link($keep_query = false ) {
        if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
            $link = home_url('/');
        } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
            $link = get_post_type_archive_link( 'product' );
        } else {
            $link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
        }

        if( $keep_query ) {
            // Keep query string vars intact
            foreach ( $_GET as $key => $val ) {
                if ( 'orderby' === $key || 'submit' === $key ) {
                    continue;
                }
                $link = add_query_arg( $key, $val, $link );

            }
        }
        return $link;
    }
}


if(!function_exists('kossy_filter_before')){
    function kossy_filter_before(){
        echo '<div class="wrapper-fillter"><div class="apus-filter clearfix">';
    }
}
if(!function_exists('kossy_filter_after')){
    function kossy_filter_after(){
        echo '</div></div>';
    }
}
add_action( 'woocommerce_before_shop_loop', 'kossy_filter_before' , 1 );
add_action( 'woocommerce_before_shop_loop', 'kossy_filter_after' , 40 );


// set display mode to cookie
if ( !function_exists('kossy_before_woocommerce_init') ) {
    function kossy_before_woocommerce_init() {
        if( isset($_GET['display_mode']) && ($_GET['display_mode']=='list' || $_GET['display_mode']=='grid') ){  
            setcookie( 'kossy_woo_mode', trim($_GET['display_mode']) , time()+3600*24*100,'/' );
            $_COOKIE['kossy_woo_mode'] = trim($_GET['display_mode']);
        }
    }
}
add_action( 'init', 'kossy_before_woocommerce_init' );

// Number of products per page
if ( !function_exists('kossy_woocommerce_shop_per_page') ) {
    function kossy_woocommerce_shop_per_page($number) {
        
        if ( isset( $_REQUEST['wppp_ppp'] ) ) :
            $number = intval( $_REQUEST['wppp_ppp'] );
            WC()->session->set( 'products_per_page', intval( $_REQUEST['wppp_ppp'] ) );
        elseif ( isset( $_REQUEST['ppp'] ) ) :
            $number = intval( $_REQUEST['ppp'] );
            WC()->session->set( 'products_per_page', intval( $_REQUEST['ppp'] ) );
        elseif ( WC()->session->__isset( 'products_per_page' ) ) :
            $number = intval( WC()->session->__get( 'products_per_page' ) );
        else :
            $value = kossy_get_config('number_products_per_page', 12);
            $number = intval( $value );
        endif;
        
        return $number;

    }
}
add_filter( 'loop_shop_per_page', 'kossy_woocommerce_shop_per_page', 30 );

// Number of products per row
if ( !function_exists('kossy_woocommerce_shop_columns') ) {
    function kossy_woocommerce_shop_columns($number) {
        $value = kossy_get_config('product_columns');
        if ( in_array( $value, array(1, 2, 3, 4, 5, 6, 7, 8) ) ) {
            $number = $value;
        }
        return $number;
    }
}
add_filter( 'loop_shop_columns', 'kossy_woocommerce_shop_columns' );

// share box
if ( !function_exists('kossy_woocommerce_share_box') ) {
    function kossy_woocommerce_share_box() {
        if ( kossy_get_config('show_product_social_share') ) {
            get_template_part( 'template-parts/sharebox' );
        }
    }
}
add_filter( 'woocommerce_single_product_summary', 'kossy_woocommerce_share_box', 100 );

// quickview
if ( !function_exists('kossy_woocommerce_quickview') ) {
    function kossy_woocommerce_quickview() {
        if ( !empty($_GET['product_id']) ) {
            $args = array(
                'post_type' => 'product',
                'post__in' => array($_GET['product_id'])
            );
            $query = new WP_Query($args);
            if ( $query->have_posts() ) {
                while ($query->have_posts()): $query->the_post(); global $product;
                    wc_get_template_part( 'content', 'product-quickview' );
                endwhile;
            }
            wp_reset_postdata();
        }
        die;
    }
}

if ( kossy_get_global_config('show_quickview') ) {
    add_action( 'wp_ajax_kossy_quickview_product', 'kossy_woocommerce_quickview' );
    add_action( 'wp_ajax_nopriv_kossy_quickview_product', 'kossy_woocommerce_quickview' );
}

// swap effect
if ( !function_exists('kossy_swap_images') ) {
    function kossy_swap_images() {
        global $post, $product, $woocommerce;
        
        $thumb = 'woocommerce_thumbnail';
        $output = '';
        $class = "attachment-$thumb size-$thumb image-no-effect";
        if (has_post_thumbnail()) {
            $swap_image = kossy_get_config('enable_swap_image', true);
            if ( $swap_image ) {
                $attachment_ids = $product->get_gallery_image_ids();
                if ($attachment_ids && isset($attachment_ids[0])) {
                    $class = "attachment-$thumb size-$thumb image-hover";
                    $swap_class = "attachment-$thumb size-$thumb image-effect";
                    $output .= kossy_get_attachment_thumbnail( $attachment_ids[0], $thumb, false, array('class' => $swap_class), false);
                }
            }
            $output .= kossy_get_attachment_thumbnail( get_post_thumbnail_id(), $thumb , false, array('class' => $class), false);
        } else {
            $image_sizes = get_option('shop_catalog_image_size');
            $placeholder_width = $image_sizes['width'];
            $placeholder_height = $image_sizes['height'];

            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'.esc_attr__('Placeholder' , 'kossy').'" class="'.$class.'" width="'.$placeholder_width.'" height="'.$placeholder_height.'" />';
        }
        echo trim($output);
    }
}
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'kossy_swap_images', 10);

if ( !function_exists('kossy_product_image') ) {
    function kossy_product_image($thumb = 'woocommerce_thumbnail') {
        $swap_image = (bool)kossy_get_config('enable_swap_image', true);
        ?>
        <a title="<?php echo esc_attr(get_the_title()); ?>" href="<?php the_permalink(); ?>" class="product-image">
            <?php kossy_product_get_image($thumb, $swap_image); ?>
        </a>
        <?php
    }
}
// get image
if ( !function_exists('kossy_product_get_image') ) {
    function kossy_product_get_image($thumb = 'woocommerce_thumbnail', $swap = true) {
        global $post, $product, $woocommerce;
        
        $output = '';
        $class = "attachment-$thumb size-$thumb image-no-effect";
        if (has_post_thumbnail()) {
            if ( $swap ) {
                $attachment_ids = $product->get_gallery_image_ids();
                if ($attachment_ids && isset($attachment_ids[0])) {
                    $class = "attachment-$thumb size-$thumb image-hover";
                    $swap_class = "attachment-$thumb size-$thumb image-effect";
                    $output .= kossy_get_attachment_thumbnail( $attachment_ids[0], $thumb , false, array('class' => $swap_class), false);
                }
            }
            $output .= kossy_get_attachment_thumbnail( get_post_thumbnail_id(), $thumb , false, array('class' => $class), false);
        } else {
            $image_sizes = get_option('shop_catalog_image_size');
            $placeholder_width = $image_sizes['width'];
            $placeholder_height = $image_sizes['height'];

            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'.esc_attr__('Placeholder' , 'kossy').'" class="'.$class.'" width="'.$placeholder_width.'" height="'.$placeholder_height.'" />';
        }
        echo trim($output);
    }
}

// layout class for woo page
if ( !function_exists('kossy_woocommerce_content_class') ) {
    function kossy_woocommerce_content_class( $class ) {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';
        }
        if( kossy_get_config('product_'.$page.'_fullwidth') ) {
            return 'container-fluid';
        }
        return $class;
    }
}
add_filter( 'kossy_woocommerce_content_class', 'kossy_woocommerce_content_class' );

// get layout configs
if ( !function_exists('kossy_get_woocommerce_layout_configs') ) {
    function kossy_get_woocommerce_layout_configs() {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';
        }
        $left = kossy_get_config('product_'.$page.'_left_sidebar');
        $right = kossy_get_config('product_'.$page.'_right_sidebar');

        switch ( kossy_get_config('product_'.$page.'_layout') ) {
            case 'left-main':
                $configs['left'] = array( 'sidebar' => $left, 'class' => 'col-lg-3 col-md-3 col-sm-12 col-xs-12'  );
                $configs['main'] = array( 'class' => 'col-lg-9 col-md-9 col-sm-12 col-xs-12' );
                break;
            case 'main-right':
                $configs['right'] = array( 'sidebar' => $right,  'class' => 'col-lg-3 col-md-3 col-sm-12 col-xs-12' ); 
                $configs['main'] = array( 'class' => 'col-lg-9 col-md-9 col-sm-12 col-xs-12' );
                break;
            case 'main':
                $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
                break;
            case 'left-main-right':
                $configs['left'] = array( 'sidebar' => $left,  'class' => 'col-md-3 col-sm-12 col-xs-12'  );
                $configs['right'] = array( 'sidebar' => $right, 'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
                $configs['main'] = array( 'class' => 'col-md-6 col-sm-12 col-xs-12' );
                break;
            default:
                $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
                break;
        }

        return $configs; 
    }
}

if ( !function_exists( 'kossy_product_review_tab' ) ) {
    function kossy_product_review_tab($tabs) {
        global $post;
        if ( !kossy_get_config('show_product_review_tab') && isset($tabs['reviews']) ) {
            unset( $tabs['reviews'] ); 
        }

        if ( !kossy_get_config('hidden_product_additional_information_tab') && isset($tabs['additional_information']) ) {
            unset( $tabs['additional_information'] ); 
        }
        
        return $tabs;
    }
}
add_filter( 'woocommerce_product_tabs', 'kossy_product_review_tab', 90 );

function kossy_woocommerce_get_ajax_products() {
    $settings = isset($_POST['settings']) ? $_POST['settings'] : '';
    $tab = isset($_POST['tab']) ? $_POST['tab'] : '';
    
    if ( empty($settings) || empty($tab) ) {
        exit();
    }

    $categories = isset($tab['category']) ? $tab['category'] : '';
    $columns = isset($settings['columns']) ? $settings['columns'] : 4;
    $rows = isset($settings['rows']) ? $settings['rows'] : 1;
    $show_nav = isset($settings['show_nav']) ? $settings['show_nav'] : false;
    $show_pagination = isset($settings['show_pagination']) ? $settings['show_pagination'] : false;
    $number = isset($settings['number']) ? $settings['number'] : 4;
    $product_type = isset($tab['type']) ? $tab['type'] : 'recent_product';

    $layout_type = isset($settings['layout_type']) ? $settings['layout_type'] : 'grid';

    $categories = !empty($categories) ? array($categories) : array();
    $args = array(
        'categories' => $categories,
        'product_type' => $product_type,
        'paged' => 1,
        'post_per_page' => $number,
    );
    $loop = kossy_get_products( $args );
    if ( $loop->have_posts() ) {
        $max_pages = $loop->max_num_pages;
        wc_get_template( 'layout-products/'.$layout_type.'.php' , array(
            'loop' => $loop,
            'columns' => $columns,
            'rows' => $rows,
            'show_nav' => $show_nav,
            'show_pagination' => $show_pagination,
        ) );
    }
    exit();
}
add_action( 'wp_ajax_kossy_ajax_get_products', 'kossy_woocommerce_get_ajax_products' );
add_action( 'wp_ajax_nopriv_kossy_ajax_get_products', 'kossy_woocommerce_get_ajax_products' );

// Wishlist
add_filter( 'yith_wcwl_button_label', 'kossy_woocomerce_icon_wishlist'  );
add_filter( 'yith-wcwl-browse-wishlist-label', 'kossy_woocomerce_icon_wishlist_add' );
function kossy_woocomerce_icon_wishlist( $value='' ){
    return '<i class="icon_heart"></i>'.'<span class="sub-title">'.esc_html__('Add to Wishlist','kossy').'</span>';
}

function kossy_woocomerce_icon_wishlist_add(){
    return '<i class="icon_heart"></i>'.'<span class="sub-title">'.esc_html__('Wishlisted','kossy').'</span>';
}
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

function kossy_get_all_subcategories_levels($parent_id, $parent_slug, &$return = array()) {
    $return[] = $parent_slug;
    $args = array(
        'hierarchical' => true,
        'show_option_none' => '',
        'hide_empty' => true,
        'parent' => $parent_id,
        'taxonomy' => 'product_cat'
    );
    $cats = get_categories($args);
    foreach ($cats as $cat) {
        kossy_get_all_subcategories_levels($cat->term_id, $cat->slug, $return);
    }
    return $return;
}

function kossy_woocommerce_accessories() {
    get_template_part( 'woocommerce/single-product/tabs/accessories' );
}

function kossy_woocommerce_single_countdown() {
    if ( kossy_get_config('show_product_countdown_timer') ) {
        get_template_part( 'woocommerce/single-product/countdown' );
    }
}
add_action('woocommerce_single_product_summary', 'kossy_woocommerce_single_countdown', 15);


if ( ! function_exists( 'kossy_wc_products_per_page' ) ) {
    function kossy_wc_products_per_page() {
        global $wp_query;

        $action = '';
        $cat                = $wp_query->get_queried_object();
        $return_to_first    = apply_filters( 'kossy_wc_ppp_return_to_first', false );
        $total              = $wp_query->found_posts;
        $per_page           = $wp_query->get( 'posts_per_page' );
        $_per_page          = kossy_get_config('number_products_per_page', 12);

        // Generate per page options
        $products_per_page_options = array();
        while ( $_per_page < $total ) {
            $products_per_page_options[] = $_per_page;
            $_per_page = $_per_page * 2;
        }

        if ( empty( $products_per_page_options ) ) {
            return;
        }

        $products_per_page_options[] = -1;

        $query_string = ! empty( $_GET['QUERY_STRING'] ) ? '?' . add_query_arg( array( 'ppp' => false ), $_GET['QUERY_STRING'] ) : null;

        if ( isset( $cat->term_id ) && isset( $cat->taxonomy ) && $return_to_first ) {
            $action = get_term_link( $cat->term_id, $cat->taxonomy ) . $query_string;
        } elseif ( $return_to_first ) {
            $action = get_permalink( wc_get_page_id( 'shop' ) ) . $query_string;
        }

        if ( ! woocommerce_products_will_display() ) {
            return;
        }
        ?>
        <form method="POST" action="<?php echo esc_url( $action ); ?>" class="form-kossy-ppp">
            <?php
            foreach ( $_GET as $key => $value ) {
                if ( 'ppp' === $key || 'submit' === $key ) {
                    continue;
                }
                if ( is_array( $value ) ) {
                    foreach( $value as $i_value ) {
                        ?>
                        <input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $i_value ); ?>" />
                        <?php
                    }
                } else {
                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" /><?php
                }
            }
            ?>

            <select name="ppp" onchange="this.form.submit()" class="kossy-wc-wppp-select">
                <?php foreach( $products_per_page_options as $key => $value ) { ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $per_page ); ?>><?php
                        $ppp_text = apply_filters( 'kossy_wc_ppp_text', esc_html__( 'Show: %s', 'kossy' ), $value );
                        esc_html( printf( $ppp_text, $value == -1 ? esc_html__( 'All', 'kossy' ) : $value ) );
                    ?></option>
                <?php } ?>
            </select>
        </form>
        <?php
    }
}

function kossy_woo_after_shop_loop_before() {
    ?>
    <div class="apus-after-loop-shop clearfix">
    <?php
}
function kossy_woo_after_shop_loop_after() {
    ?>
    </div>
    <?php
}
add_action( 'woocommerce_after_shop_loop', 'kossy_woo_after_shop_loop_before', 1 );
add_action( 'woocommerce_after_shop_loop', 'kossy_woo_after_shop_loop_after', 99999 );
// add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 30 );
// add_action( 'woocommerce_after_shop_loop', 'kossy_wc_products_per_page', 20 );


function kossy_woo_display_product_cat($product_id) {
    $terms = get_the_terms( $product_id, 'product_cat' );
    if ( !empty($terms) ) { ?>
        <div class="product-cats">
        <?php foreach ( $terms as $term ) {
            echo '<a href="' . get_term_link( $term->term_id ) . '">' . $term->name . '</a>';
            break;
        } ?>
        </div>
    <?php
    }
}
if ( !function_exists ('kossy_onsale_price_show') ) {
    function kossy_onsale_price_show() {
        global $product;
        if( $product->is_on_sale() ) {
            return $product->get_regular_price() - $product->get_sale_price();
        }
        return '';
    }
}

// catalog mode
add_action( 'wp', 'kossy_catalog_mode_init' );
add_action( 'wp', 'kossy_pages_redirect' );


function kossy_catalog_mode_init() {

    if( ! kossy_get_config( 'enable_shop_catalog' ) ) return false;

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

}

function kossy_pages_redirect() {
    if( ! kossy_get_config( 'enable_shop_catalog' ) ) return false;

    $cart     = is_page( wc_get_page_id( 'cart' ) );
    $checkout = is_page( wc_get_page_id( 'checkout' ) );

    wp_reset_postdata();

    if ( $cart || $checkout ) {
        wp_redirect( home_url('/') );
        exit;
    }
}




/*
 * Start for only Kossy theme
 */
function kossy_is_ajax_request() {
    if ( isset( $_REQUEST['load_type'] ) ) {
        return true;
    }
    return false;
}

function kossy_category_menu_create_list( $category, $current_cat_id ) {
    $output = '<li class="cat-item-' . $category->term_id;
                    
    if ( $current_cat_id == $category->term_id ) {
        $output .= ' current-cat';
    }
    
    $output .=  '"><a href="' . esc_url( get_term_link( (int) $category->term_id, 'product_cat' ) ) . '">' . esc_attr( $category->name ) . '</a></li>';
    
    return $output;
}

/*
 *  Product category menu
 */
if ( ! function_exists( 'kossy_category_menu' ) ) {
    function kossy_category_menu() {
        global $wp_query;

        $current_cat_id = ( is_tax( 'product_cat' ) ) ? $wp_query->queried_object->term_id : '';
        $is_category = ( strlen( $current_cat_id ) > 0 ) ? true : false;
        $hide_empty = true;
        $shop_categories_top_level = true;
        // Should top-level categories be displayed?
        if ( !$shop_categories_top_level && $is_category ) {
            kossy_sub_category_menu_output( $current_cat_id, $hide_empty );
        } else {
            kossy_category_menu_output( $is_category, $current_cat_id, $hide_empty );
        }
    }
}

    

/*
 *  Product category menu: Output
 */
function kossy_category_menu_output( $is_category, $current_cat_id, $hide_empty ) {
    global $wp_query;
    
    $page_id = wc_get_page_id( 'shop' );
    $page_url = get_permalink( $page_id );
    $hide_sub = true;
    $all_categories_class = '';
    
    // Is this a category page?                                                             
    if ( $is_category ) {
        $hide_sub = false;
        
        // Get current category's direct children
        $direct_children = get_terms( 'product_cat',
            array(
                'fields'        => 'ids',
                'parent'        => $current_cat_id,
                'hierarchical'  => true,
                'hide_empty'    => $hide_empty
            )
        );
        
        $category_has_children = ( empty( $direct_children ) ) ? false : true;
    } else {
        // No current category, set "All" as current (if not product tag archive or search)
        if ( ! is_product_tag() && ! isset( $_REQUEST['s'] ) ) {
            $all_categories_class = ' class="current-cat"';
        }
    }
    
    $output = '<li' . $all_categories_class . '><a href="' . esc_url ( $page_url ) . '">' . esc_html__( 'All Products', 'kossy' ) . '</a></li>';
    $sub_output = '';
    
    // Categories order
    $orderby = 'slug';
    $order = 'asc';
    
    
    $categories = get_categories( array(
        'type'          => 'post',
        'orderby'       => $orderby, // Note: 'name' sorts by product category "menu/sort order"
        'order'         => $order,
        'hide_empty'    => $hide_empty,
        'hierarchical'  => 1,
        'taxonomy'      => 'product_cat'
    ) );
             
    foreach( $categories as $category ) {
        // Is this a sub-category?
        if ( $category->parent != '0' ) {
            // Should sub-categories be included?
            if ( $hide_sub ) {
                continue;
            } else {
                if ( 
                    $category->term_id == $current_cat_id ||
                    $category->parent == $current_cat_id ||
                    ! $category_has_children && $category->parent == $wp_query->queried_object->parent
                ) {
                    $sub_output .= kossy_category_menu_create_list( $category, $current_cat_id );
                }
                continue;
            }
        }
        
        $output .= kossy_category_menu_create_list( $category, $current_cat_id );
    }
    
    if ( strlen( $sub_output ) > 0 ) {
        $sub_output = '<ul class="apus-shop-sub-categories">' . $sub_output . '</ul>';
    }
    
    $output = $output . $sub_output;
    
    echo trim($output);
}

/*
 *  Product category menu: Output sub-categories
 */
function kossy_sub_category_menu_output( $current_cat_id, $hide_empty ) {
    global $wp_query;
    
    
    $output_sub_categories = '';
    
    // Categories order
    $orderby = 'slug';
    $order = 'asc';
    
    $sub_categories = get_categories( array(
        'type'          => 'post',
        'parent'        => $current_cat_id,
        'orderby'       => $orderby,
        'order'         => $order,
        'hide_empty'    => $hide_empty,
        'hierarchical'  => 1,
        'taxonomy'      => 'product_cat'
    ) );
    
    $has_sub_categories = ( empty( $sub_categories ) ) ? false : true;
    
    // Is there any sub-categories available
    if ( $has_sub_categories ) {
        $current_cat_name = apply_filters( 'kossy_shop_parent_category_title', $wp_query->queried_object->name );
        
        foreach ( $sub_categories as $sub_category ) {
            $output_sub_categories .= kossy_category_menu_create_list( $sub_category, $current_cat_id );
        }
    } else {
        $current_cat_name = $wp_query->queried_object->name;
    }
    
    $current_cat_url = get_term_link( (int) $current_cat_id, 'product_cat' );
    $output_current_cat = '<li class="current-cat"><a href="' . esc_url( $current_cat_url ) . '">' . esc_html( $current_cat_name ) . '</a></li>';
    
    echo trim($output_current_cat . $output_sub_categories);
}

function kossy_count_filtered() {
    $return = 0;
    if ( isset($_GET['min_price']) && isset($_GET['max_price']) ) {
        $return++;
    }
    // filter by attributes
    $attribute_taxonomies = wc_get_attribute_taxonomies();

    if ( ! empty( $attribute_taxonomies ) ) {
        foreach ( $attribute_taxonomies as $tax ) {
            if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                if ( isset($_GET['filter_'.$tax->attribute_name]) ) {
                    $return++;
                }
            }
        }
    }
    return $return;
}

// remove shop and archive descripton
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

// add to kossy
add_action( 'kossy_woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'kossy_woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );