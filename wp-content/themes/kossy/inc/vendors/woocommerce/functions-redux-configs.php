<?php

// Shop Archive settings
function kossy_woo_redux_config($sections, $sidebars, $columns) {
    $categories = array();
    $attributes = array();
    if ( is_admin() ) {
        $categories = kossy_woocommerce_get_categories(false);

        $attrs = wc_get_attribute_taxonomies();
        if ( $attrs ) {
            foreach ( $attrs as $tax ) {
                $attributes[wc_attribute_taxonomy_name( $tax->attribute_name )] = $tax->attribute_label;
            }
        }
    }
    $sections[] = array(
        'icon' => 'el el-shopping-cart',
        'title' => esc_html__('Shop Settings', 'kossy'),
        'fields' => array(
            array (
                'id' => 'products_general_total_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'enable_shop_catalog',
                'type' => 'switch',
                'title' => esc_html__('Enable Shop Catalog', 'kossy'),
                'default' => 0
            ),
            array (
                'id' => 'products_swatches_grid_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Swatches Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'show_product_swatches_on_grid',
                'type' => 'switch',
                'title' => esc_html__('Show Swatches On Product Grid', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'product_swatches_attribute',
                'type' => 'select',
                'title' => esc_html__( 'Grid swatch attribute to display', 'kossy' ),
                'subtitle' => esc_html__( 'Choose attribute that will be shown on products grid', 'kossy' ),
                'options' => $attributes
            ),
            array(
                'id' => 'show_product_swatches_use_images',
                'type' => 'switch',
                'title' => esc_html__('Use images from product variations', 'kossy'),
                'subtitle' => esc_html__( 'If enabled swatches buttons will be filled with images choosed for product variations and not with images uploaded to attribute terms.', 'kossy' ),
                'default' => 1
            ),
            array (
                'id' => 'products_brand_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Brands Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'product_brand_attribute',
                'type' => 'select',
                'title' => esc_html__( 'Brand Attribute', 'kossy' ),
                'subtitle' => esc_html__( 'Choose a product attribute that will be used as brands', 'kossy' ),
                'desc' => esc_html__( 'When you have choosed a brand attribute, you will be able to add brand image to the attributes', 'kossy' ),
                'options' => $attributes
            ),
            array (
                'id' => 'products_breadcrumb_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Breadcrumbs Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'show_product_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'kossy'),
                'default' => 1
            ),
            array (
                'title' => esc_html__('Breadcrumbs Background Color', 'kossy'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'kossy').'</em>',
                'id' => 'woo_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'kossy'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'kossy'),
            ),
        )
    );
    // Archive settings
    $sections[] = array(
        'title' => esc_html__('Product Archives', 'kossy'),
        'subsection' => true,
        'fields' => array(
            array (
                'id' => 'products_top_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Top Content Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'product_archive_top_categories',
                'type' => 'switch',
                'title' => esc_html__('Enable Top Categories', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'product_archive_top_filter',
                'type' => 'switch',
                'title' => esc_html__('Enable Filter Top', 'kossy'),
                'default' => 1
            ),
            array (
                'id' => 'products_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'product_display_mode',
                'type' => 'select',
                'title' => esc_html__('Products Layout', 'kossy'),
                'subtitle' => esc_html__('Choose a default layout archive product.', 'kossy'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'kossy'),
                    'list' => esc_html__('List', 'kossy'),
                    'mansory-v1' => esc_html__('Mansory V1', 'kossy'),
                    'mansory-v2' => esc_html__('Mansory V2', 'kossy'),
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'product_item_style',
                'type' => 'select',
                'title' => esc_html__('Product Style', 'kossy'),
                'subtitle' => esc_html__('Choose a default style archive product.', 'kossy'),
                'options' => array(
                    'inner' => esc_html__('Default', 'kossy'),
                    'inner-left' => esc_html__('Style Left', 'kossy'),
                    'inner-center' => esc_html__('Style Center', 'kossy'),
                ),
                'default' => 'inner',
                'required' => array('product_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'product_columns',
                'type' => 'select',
                'title' => esc_html__('Product Columns', 'kossy'),
                'options' => $columns,
                'default' => 4,
                'required' => array('product_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'number_products_per_page',
                'type' => 'text',
                'title' => esc_html__('Number of Products Per Page', 'kossy'),
                'default' => 12,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'show_quickview',
                'type' => 'switch',
                'title' => esc_html__('Show Quick View', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'enable_swap_image',
                'type' => 'switch',
                'title' => esc_html__('Enable Swap Image', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'product_pagination',
                'type' => 'select',
                'title' => esc_html__('Pagination Type', 'kossy'),
                'options' => array(
                    'default' => esc_html__('Default', 'kossy'),
                    'loadmore' => esc_html__('Load More Button', 'kossy'),
                    'infinite' => esc_html__('Infinite Scrolling', 'kossy'),
                ),
                'default' => 'default'
            ),
            array (
                'id' => 'products_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'product_archive_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'kossy'),
                'default' => false
            ),
            array(
                'id' => 'product_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Product Layout', 'kossy'),
                'subtitle' => esc_html__('Select the layout you want to apply on your archive product page.', 'kossy'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'kossy'),
                        'alt' => esc_html__('Main Content', 'kossy'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left Sidebar - Main Content', 'kossy'),
                        'alt' => esc_html__('Left Sidebar - Main Content', 'kossy'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main Content - Right Sidebar', 'kossy'),
                        'alt' => esc_html__('Main Content - Right Sidebar', 'kossy'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'left-main'
            ),
            array(
                'id' => 'product_archive_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Left Sidebar', 'kossy'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'kossy'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_archive_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Right Sidebar', 'kossy'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'kossy'),
                'options' => $sidebars
            ),
        )
    );
    
    // Product Page
    $sections[] = array(
        'title' => esc_html__('Single Product', 'kossy'),
        'subsection' => true,
        'fields' => array(
            array (
                'id' => 'product_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'product_single_version',
                'type' => 'select',
                'title' => esc_html__('Product Layout', 'kossy'),
                'options' => array(
                    'v1' => esc_html__('Layout 1', 'kossy'),
                    'v2' => esc_html__('Layout 2', 'kossy'),
                    'v3' => esc_html__('Layout 3', 'kossy'),
                    'v4' => esc_html__('Layout 4', 'kossy'),
                ),
                'default' => 'v1',
            ),
            array(
                'id' => 'product_thumbs_position',
                'type' => 'select',
                'title' => esc_html__('Thumbnails Position', 'kossy'),
                'options' => array(
                    'thumbnails-left' => esc_html__('Thumbnails Left', 'kossy'),
                    'thumbnails-right' => esc_html__('Thumbnails Right', 'kossy'),
                    'thumbnails-bottom' => esc_html__('Thumbnails Bottom', 'kossy'),
                ),
                'default' => 'thumbnails-left',
                'required' => array('product_single_version', '=', array('v1', 'v3'))
            ),
            array(
                'id' => 'number_product_thumbs',
                'title' => esc_html__('Number Thumbnails Per Row', 'kossy'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '8',
                'type' => 'slider',
                'required' => array('product_single_version','=',array('v1', 'v3'))
            ),
            array(
                'id' => 'show_product_countdown_timer',
                'type' => 'switch',
                'title' => esc_html__('Show Product CountDown Timer', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'kossy'),
                'default' => 1
            ),

            array(
                'id' => 'show_product_review_tab',
                'type' => 'switch',
                'title' => esc_html__('Show Product Review Tab', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'hidden_product_additional_information_tab',
                'type' => 'switch',
                'title' => esc_html__('Hidden Product Additional Information Tab', 'kossy'),
                'default' => 1
            ),

            array (
                'id' => 'product_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'product_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Single Product Sidebar Layout', 'kossy'),
                'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'kossy'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'kossy'),
                        'alt' => esc_html__('Main Only', 'kossy'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'kossy'),
                        'alt' => esc_html__('Left - Main Sidebar', 'kossy'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'kossy'),
                        'alt' => esc_html__('Main - Right Sidebar', 'kossy'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'left-main'
            ),
            array(
                'id' => 'product_single_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'kossy'),
                'default' => false
            ),
            array(
                'id' => 'product_single_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Left Sidebar', 'kossy'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'kossy'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_single_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Right Sidebar', 'kossy'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'kossy'),
                'options' => $sidebars
            ),
            array (
                'id' => 'product_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Product Block Setting', 'kossy').'</h3>',
            ),
            array(
                'id' => 'show_product_releated',
                'type' => 'switch',
                'title' => esc_html__('Show Products Releated', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_upsells',
                'type' => 'switch',
                'title' => esc_html__('Show Products upsells', 'kossy'),
                'default' => 1
            ),
            array(
                'id' => 'number_product_releated',
                'title' => esc_html__('Number of related/upsells products to show', 'kossy'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '20',
                'type' => 'slider'
            ),
            array(
                'id' => 'releated_product_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Products Columns', 'kossy'),
                'options' => $columns,
                'default' => 4
            ),
        )
    );
    
    return $sections;
}
add_filter( 'kossy_redux_framwork_configs', 'kossy_woo_redux_config', 10, 3 );