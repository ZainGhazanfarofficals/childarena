<?php

if ( function_exists('apus_framework_add_param') ) {
	apus_framework_add_param();
}

function kossy_admin_init_scripts(){
	wp_enqueue_script('google-maps-api', '//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&amp;key=' . esc_js(kossy_get_config('google_map_api_key', '')) );
	wp_enqueue_script('jquery-geocomplete', get_template_directory_uri().'/js/admin/jquery.geocomplete.min.js');

	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-ui-css', get_template_directory_uri() . '/css/jquery-ui.css' );
	wp_enqueue_script( 'kossy-admin-scripts', get_template_directory_uri() . '/js/admin/custom.js', array( 'jquery'  ), '20131022', true );
}
add_action( 'admin_enqueue_scripts', 'kossy_admin_init_scripts' );

function kossy_map_init_scripts() {
	wp_enqueue_script('google-maps-api', '//maps.google.com/maps/api/js?key=' . esc_js(kossy_get_config('google_map_api_key', '')) );
	wp_enqueue_script('gmap3', get_template_directory_uri().'/js/gmap3.js', array( 'jquery' ), '6.0.0', true);
}
add_action('wp_enqueue_scripts', 'kossy_map_init_scripts');
