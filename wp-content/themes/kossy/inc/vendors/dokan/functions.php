<?php

if ( ! function_exists( 'kossy_dokan_sidebars' ) ) {
	
	function kossy_dokan_sidebars() {
		register_sidebar( array(
			'name' 				=> esc_html__( 'Store Sidebar', 'kossy' ),
			'id' 				=> 'store-sidebar',
			'before_widget'		=> '<aside class="widget %2$s">',
			'after_widget' 		=> '</aside>',
			'before_title' 		=> '<h2 class="widget-title">',
			'after_title' 		=> '</h2>'
		));
	}

}

add_action( 'widgets_init', 'kossy_dokan_sidebars' );


function kossy_dokan_redux_config( $sections, $sidebars, $columns ) {
	// Dokan Store Sidebar
    $dokan_fields = array(
        array(
            'id' => 'dokan_sidebar_layout',
            'type' => 'image_select',
            'compiler' => true,
            'title' => esc_html__('Dokan Store Layout', 'kossy'),
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
            'id' => 'dokan_sidebar_fullwidth',
            'type' => 'switch',
            'title' => esc_html__('Is Full Width?', 'kossy'),
            'default' => false
        ),
    );

    if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) !== 'off' ) {
    	
    	$dokan_fields[] = array(
            'id' => 'dokan_left_sidebar',
            'type' => 'select',
            'title' => esc_html__('Dokan Store Left Sidebar', 'kossy'),
            'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'kossy'),
            'options' => $sidebars
        );

        $dokan_fields[] = array(
            'id' => 'dokan_right_sidebar',
            'type' => 'select',
            'title' => esc_html__('Dokan Store Right Sidebar', 'kossy'),
            'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'kossy'),
            'options' => $sidebars
        );
    }
    $sections[] = array(
        'title' => esc_html__('Dokan Store Sidebar', 'kossy'),
        'fields' => $dokan_fields
    );

    return $sections;
}
add_filter( 'kossy_redux_framwork_configs', 'kossy_dokan_redux_config', 20, 3 );



// layout class for woo page
if ( !function_exists('kossy_dokan_content_class') ) {
    function kossy_dokan_content_class( $class ) {
        if( kossy_get_config('dokan_sidebar_fullwidth') ) {
            return 'container-fluid';
        }
        return $class;
    }
}
add_filter( 'kossy_dokan_content_class', 'kossy_dokan_content_class' );

// get layout configs
if ( !function_exists('kossy_get_dokan_layout_configs') ) {
    function kossy_get_dokan_layout_configs() {
        
                // lg and md for fullwidth
        if( kossy_get_config('dokan_sidebar_fullwidth') ) {
            $sidebar_width = 'col-lg-2 col-md-3 ';
            $main_width = 'col-lg-10 col-md-9';
        }else{
            $sidebar_width = 'col-lg-3 col-md-3 ';
            $main_width = 'col-lg-9 col-md-9 ';
        }

        $left = kossy_get_config('dokan_left_sidebar');
        $right = kossy_get_config('dokan_right_sidebar');

        switch ( kossy_get_config('dokan_sidebar_layout') ) {
            case 'left-main':
                $configs['left'] = array( 'sidebar' => $left, 'class' => $sidebar_width.' col-sm-12 col-xs-12'  );
                $configs['main'] = array( 'class' => $main_width.' col-sm-12 col-xs-12' );
                break;
            case 'main-right':
                $configs['right'] = array( 'sidebar' => $right,  'class' => $sidebar_width.' col-sm-12 col-xs-12' ); 
                $configs['main'] = array( 'class' => $main_width.' col-sm-12 col-xs-12' );
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