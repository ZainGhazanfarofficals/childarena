<?php
if ( !function_exists( 'kossy_footer_metaboxes' ) ) {
	function kossy_footer_metaboxes(array $metaboxes) {
		$prefix = 'apus_footer_';
	    $fields = array(
			array(
				'name' => esc_html__( 'Footer Style', 'kossy' ),
				'id'   => $prefix.'style_class',
				'type' => 'select',
				'options' => array(
					'container' => esc_html__('Boxed', 'kossy'),
					'full' => esc_html__('Full', 'kossy'),
				)
			),
			array(
				'name' => esc_html__( 'Footer Background Color', 'kossy' ),
				'id'   => $prefix.'background_class',
				'type' => 'select',
				'options' => array(
					'' => esc_html__('White', 'kossy'),
					'dark' => esc_html__('Dark', 'kossy'),
				)
			),
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'kossy' ),
			'object_types'              => array( 'apus_footer' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'kossy_footer_metaboxes' );