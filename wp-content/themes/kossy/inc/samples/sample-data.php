<?php

$path_dir = get_template_directory() . '/inc/samples/data/';
$path_uri = get_template_directory_uri() . '/inc/samples/data/';

if ( is_dir($path_dir) ) {
	$demo_datas = array(
		'home12345'               => array(
			'data_dir'      => $path_dir . 'home12345',
			'title'         => esc_html__( 'Home 1, 2, 3, 4, 5', 'kossy' ),
		),
		'home6'               => array(
			'data_dir'      => $path_dir . 'home6',
			'title'         => esc_html__( 'Home 6', 'kossy' ),
		),
		'home78'               => array(
			'data_dir'      => $path_dir . 'home78',
			'title'         => esc_html__( 'Home 7, 8', 'kossy' ),
		),
		'home910'               => array(
			'data_dir'      => $path_dir . 'home910',
			'title'         => esc_html__( 'Home 9, 10', 'kossy' ),
		)
	);
}