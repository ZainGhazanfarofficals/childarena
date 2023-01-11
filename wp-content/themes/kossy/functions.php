<?php
/**
 * kossy functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Kossy
 * @since Kossy 1.24
 */

define( 'KOSSY_THEME_VERSION', '1.24' );
define( 'KOSSY_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'kossy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Kossy 1.0
 */
function kossy_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on kossy, use a find and replace
	 * to change 'kossy' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kossy', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 750, true );
	add_image_size( 'kossy-shop-large', 570, 570, true );
	add_image_size( 'kossy-shop-largest', 820, 820, true );
	add_image_size( 'kossy-shop-horizontal', 570, 265, true );
	add_image_size( 'kossy-shop-horizontal1', 570, 270, true );
	add_image_size( 'kossy-shop-vertical', 270, 570, true );
	add_image_size( 'kossy-shop-small', 270, 270, true );

	add_image_size( 'kossy-shop-normal', 430, 430, true );
	add_image_size( 'kossy-post-small', 100, 70, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'kossy' ),
		'top-menu' => esc_html__( 'Top Menu', 'kossy' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce", array('gallery_thumbnail_image_width' => 410) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = kossy_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'kossy_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'responsive-embeds' );
	
	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( array( 'css/style-editor.css', kossy_get_fonts_url() ) );

	kossy_get_load_plugins();
}
endif; // kossy_setup
add_action( 'after_setup_theme', 'kossy_setup' );
/**
 * Load Google Front
 */
function kossy_get_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    $rubik = _x( 'on', 'Rubik font: on or off', 'kossy' );
    $dafoe = _x( 'on', 'Dafoe font: on or off', 'kossy' );

    if ( 'off' !== $rubik || 'off' !== $dafoe ) {
        $font_families = array();
        if ( 'off' !== $rubik ) {
            $font_families[] = 'Rubik:400,500,700';
        }
		if ( 'off' !== $dafoe ) {
            $font_families[] = 'Mr+Dafoe';
        }
 		if ( kossy_get_config('font_source', 1) == 2 ) {
	 		$font_google_code = kossy_get_config('font_google_code');
	 		if (!empty($font_google_code) ) {
	 			$font_families[] = $font_google_code;
	 		}
 		}
        $query_args = array(
            'family' => ( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 		
 		$protocol = is_ssl() ? 'https:' : 'http:';
        $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}

function kossy_fonts_url() {  
	$protocol = is_ssl() ? 'https:' : 'http:';
	wp_enqueue_style( 'kossy-theme-fonts', kossy_get_fonts_url(), array(), null );
}
add_action('wp_enqueue_scripts', 'kossy_fonts_url');

/**
 * Enqueue styles.
 *
 * @since Kossy 1.0
 */
function kossy_enqueue_styles() {
	//load font awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );

	// load font themify icon
	wp_enqueue_style( 'font-themify', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );
	
	wp_enqueue_style( 'font-eleganticon', get_template_directory_uri() . '/css/eleganticon-style.css', array(), '1.0.0' );
	
	// load animate version 3.6.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.6.0' );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', array(), '3.2.0' );
	} else {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.2.0' );
	}
	// slick
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.0' );
	// magnific-popup
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/js/magnific/magnific-popup.css', array(), '1.1.0' );
	// perfect scrollbar
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );
	
	// main style
	wp_enqueue_style( 'kossy-template', get_template_directory_uri() . '/css/template.css', array(), '3.2' );
	$footer_style = kossy_print_style_footer();
	if ( !empty($footer_style) ) {
		wp_add_inline_style( 'kossy-template', $footer_style );
	}
	$custom_style = kossy_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'kossy-template', $custom_style );
	}
	wp_enqueue_style( 'kossy-style', get_template_directory_uri() . '/style.css', array(), '3.2' );
}
add_action( 'wp_enqueue_scripts', 'kossy_enqueue_styles', 100 );
/**
 * Enqueue scripts.
 *
 * @since Kossy 1.0
 */
function kossy_enqueue_scripts() {
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// bootstrap
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20150330', true );
	// slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.8.0', true );
	// countdown
	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), '20150315', true );
	wp_localize_script( 'countdown', 'kossy_countdown_opts', array(
		'days' => esc_html__('Days', 'kossy'),
		'hours' => esc_html__('Hours', 'kossy'),
		'mins' => esc_html__('Mins', 'kossy'),
		'secs' => esc_html__('Secs', 'kossy'),
	));
	wp_enqueue_script( 'countdown' );
	// popup
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/magnific/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	// unviel
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );
	// perfect scrollbar
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), '0.6.12', true );
	
	if ( kossy_get_config('enable_smooth_scroll') ) {
		wp_enqueue_script( 'SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll.js', '1.3.0', true );
	}
	// main script
	wp_register_script( 'kossy-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'kossy-script', 'kossy_ajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'previous' => esc_html__('Previous', 'kossy'),
		'next' => esc_html__('Next', 'kossy'),
	));
	wp_enqueue_script( 'kossy-script' );
	
	wp_add_inline_script( 'kossy-script', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'kossy_enqueue_scripts', 1 );

/**
 * Display descriptions in main navigation.
 *
 * @since Kossy 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function kossy_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'kossy_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Kossy 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function kossy_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'kossy_search_form_modify' );

/**
 * Function get opt_name
 *
 */
function kossy_get_opt_name() {
	return 'kossy_theme_options';
}
add_filter( 'apus_framework_get_opt_name', 'kossy_get_opt_name' );


function kossy_register_demo_mode() {
	if ( defined('KOSSY_DEMO_MODE') && KOSSY_DEMO_MODE ) {
		return true;
	}
	return false;
}
add_filter( 'apus_framework_register_demo_mode', 'kossy_register_demo_mode' );

function kossy_get_demo_preset() {
	$preset = '';
    if ( defined('KOSSY_DEMO_MODE') && KOSSY_DEMO_MODE ) {
        if ( isset($_GET['_preset']) && $_GET['_preset'] ) {
            $presets = get_option( 'apus_framework_presets' );
            if ( is_array($presets) && isset($presets[$_GET['_preset']]) ) {
                $preset = $_GET['_preset'];
            }
        } else {
            $preset = get_option( 'apus_framework_preset_default' );
        }
    }
    return $preset;
}

function kossy_register_post_types($post_types) {
	foreach ($post_types as $key => $post_type) {
		if ( $post_type == 'brand' ) {
			unset($post_types[$key]);
		}
	}
	return $post_types;
}
add_filter( 'apus_framework_register_post_types', 'kossy_register_post_types' );

function kossy_get_config($name, $default = '') {
	global $apus_options;
    if ( isset($apus_options[$name]) ) {
        return $apus_options[$name];
    }
    return $default;
}

function kossy_get_global_config($name, $default = '') {
	$options = get_option( 'kossy_theme_options', array() );
	if ( isset($options[$name]) ) {
        return $options[$name];
    }
    return $default;
}

function kossy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'kossy' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'kossy' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Topbar Left Sidebar', 'kossy' ),
		'id'            => 'sidebar-topbar-left',
		'description'   => esc_html__( 'Add widgets here to appear in your Topbar.', 'kossy' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'kossy' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'kossy' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name' 				=> esc_html__( 'Shop Sidebar', 'kossy' ),
		'id' 				=> 'shop-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'kossy' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	));
	
	register_sidebar( array(
		'name' 				=> esc_html__( 'Shop Top Sidebar', 'kossy' ),
		'id' 				=> 'shop-top-sidebar',
		'description'   => esc_html__( 'Use 3 widgets: Apus WooCommerce Price Filter List, Apus Filter Products by Attribute, Apus WooCommerce Product Sorting', 'kossy' ),
		'before_widget' => '<aside class="widget %2$s"><div class="dropdown">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<span>',
		'after_title'   => '</span>',
	));
}
add_action( 'widgets_init', 'kossy_widgets_init' );

function kossy_get_load_plugins() {

	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'kossy' ),
        'slug'                     => 'apus-framework',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-framework.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WPBakery Visual Composer', 'kossy' ),
	    'slug'                     => 'js_composer',
	    'required'                 => true,
	    'source'				   => get_template_directory() . '/inc/plugins/js_composer.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Revolution Slider', 'kossy' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/revslider.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'kossy' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'kossy' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'kossy' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	// woocommerce plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'Woocommerce', 'kossy' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	);

	$plugins[] =(array(
		'name'                     => esc_html__( 'WooCommerce Variation Swatches', 'kossy' ),
	    'slug'                     => 'variation-swatches-for-woocommerce',
	    'required'                 =>  false
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Compare', 'kossy' ),
	    'slug'                     => 'yith-woocommerce-compare',
	    'required'                 =>  false
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Wishlist', 'kossy' ),
	    'slug'                     => 'yith-woocommerce-wishlist',
	    'required'                 =>  false
	));

	tgmpa( $plugins );
}

require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/functions-helper.php';
require get_template_directory() . '/inc/functions-frontend.php';

/**
 * Implement the Custom Header feature.
 *
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/classes/megamenu.php';
require get_template_directory() . '/inc/classes/mobilemenu.php';

/**
 * Custom template tags for this theme.
 *
 */
require get_template_directory() . '/inc/template-tags.php';

if ( defined( 'APUS_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require get_template_directory() . '/inc/vendors/redux-framework/redux-config.php';
	define( 'KOSSY_REDUX_FRAMEWORK_ACTIVED', true );
}
if( kossy_is_cmb2_activated() ) {
	require get_template_directory() . '/inc/vendors/cmb2/page.php';
	require get_template_directory() . '/inc/vendors/cmb2/footer.php';
	require get_template_directory() . '/inc/vendors/cmb2/product.php';
	define( 'KOSSY_CMB2_ACTIVED', true );
}
if( kossy_is_vc_activated() ) {
	require get_template_directory() . '/inc/vendors/visualcomposer/functions.php';
	require get_template_directory() . '/inc/vendors/visualcomposer/google-maps-styles.php';
	if ( defined('WPB_VC_VERSION') && version_compare( WPB_VC_VERSION, '6.0', '>=' ) ) {
		require get_template_directory() . '/inc/vendors/visualcomposer/vc-map-posts2.php';
	} else {
		require get_template_directory() . '/inc/vendors/visualcomposer/vc-map-posts.php';
	}
	require get_template_directory() . '/inc/vendors/visualcomposer/vc-map-theme.php';
	define( 'KOSSY_VISUALCOMPOSER_ACTIVED', true );
}
if( kossy_is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/vendors/woocommerce/functions.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-search.php';
	require get_template_directory() . '/inc/vendors/woocommerce/vc-map.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-brand.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-redux-configs.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-swatches.php';
	define( 'KOSSY_WOOCOMMERCE_ACTIVED', true );
}
if( kossy_is_apus_framework_activated() ) {
	require get_template_directory() . '/inc/widgets/contact-info.php';
	require get_template_directory() . '/inc/widgets/custom_menu.php';
	require get_template_directory() . '/inc/widgets/popup_newsletter.php';
	require get_template_directory() . '/inc/widgets/recent_comment.php';
	require get_template_directory() . '/inc/widgets/recent_post.php';
	require get_template_directory() . '/inc/widgets/search.php';
	require get_template_directory() . '/inc/widgets/single_image.php';
	require get_template_directory() . '/inc/widgets/socials.php';
	require get_template_directory() . '/inc/widgets/woo-price-filter.php';
	require get_template_directory() . '/inc/widgets/woo-product-sorting.php';
	require get_template_directory() . '/inc/widgets/woo-layered-nav.php';
	define( 'KOSSY_FRAMEWORK_ACTIVED', true );
}
if( kossy_is_dokan_activated() ) {
	require get_template_directory() . '/inc/vendors/dokan/functions.php';
}
if( kossy_is_wcvendors_activated() ) {
	require get_template_directory() . '/inc/vendors/wc-vendors/functions.php';
	define( 'KOSSY_WC_VENDORS_ACTIVED', true );
}

/**
 * Customizer additions.
 *
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Styles
 *
 */
require get_template_directory() . '/inc/custom-styles.php';