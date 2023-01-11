<?php

if ( function_exists('vc_map') && class_exists('WPBakeryShortCode') ) {

    function kossy_get_post_categories() {
        $return = array( esc_html__(' --- Choose a Category --- ', 'kossy') => '' );

        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'taxonomy' => 'category'
        );

        $categories = get_categories( $args );
        kossy_get_post_category_childs( $categories, 0, 0, $return );

        return $return;
    }

    function kossy_get_post_category_childs( $categories, $id_parent, $level, &$dropdown ) {
        foreach ( $categories as $key => $category ) {
            if ( $category->category_parent == $id_parent ) {
                $dropdown = array_merge( $dropdown, array( str_repeat( "- ", $level ) . $category->name => $category->slug ) );
                unset($categories[$key]);
                kossy_get_post_category_childs( $categories, $category->term_id, $level + 1, $dropdown );
            }
        }
	}

	function kossy_load_post2_element() {
		$layouts = array(
			esc_html__('Grid', 'kossy') => 'grid',
			esc_html__('List', 'kossy') => 'list',
			esc_html__('Carousel', 'kossy') => 'carousel',
		);
		$columns = array(1,2,3,4,6);
		$categories = array();
		if ( is_admin() ) {
			$categories = kossy_get_post_categories();
		}
		vc_map( array(
			'name' => esc_html__( 'Apus Grid Posts', 'kossy' ),
			'base' => 'apus_gridposts',
			'icon' => 'icon-wpb-news-12',
			"category" => esc_html__('Apus Post', 'kossy'),
			'description' => esc_html__( 'Create Post having blog styles', 'kossy' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'kossy' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'kossy' ),
					"admin_label" => true
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Category','kossy'),
	                "param_name" => 'category',
	                "value" => $categories
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Order By','kossy'),
	                "param_name" => 'orderby',
	                "value" => array(
	                	esc_html__('Date', 'kossy') => 'date',
	                	esc_html__('ID', 'kossy') => 'ID',
	                	esc_html__('Author', 'kossy') => 'author',
	                	esc_html__('Title', 'kossy') => 'title',
	                	esc_html__('Modified', 'kossy') => 'modified',
	                	esc_html__('Parent', 'kossy') => 'parent',
	                	esc_html__('Comment count', 'kossy') => 'comment_count',
	                	esc_html__('Menu order', 'kossy') => 'menu_order',
	                	esc_html__('Random', 'kossy') => 'rand',
	                )
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Sort order','kossy'),
	                "param_name" => 'order',
	                "value" => array(
	                	esc_html__('Descending', 'kossy') => 'DESC',
	                	esc_html__('Ascending', 'kossy') => 'ASC',
	                )
	            ),
	            array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Limit', 'kossy' ),
					'param_name' => 'posts_per_page',
					'description' => esc_html__( 'Enter limit posts.', 'kossy' ),
					'std' => 4,
					"admin_label" => true
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination?', 'kossy' ),
					'param_name' => 'show_pagination',
					'description' => esc_html__( 'Enables to show paginations to next new page.', 'kossy' ),
					'value' => array( esc_html__( 'Yes, to show pagination', 'kossy' ) => 'yes' )
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Grid Columns','kossy'),
	                "param_name" => 'grid_columns',
	                "value" => $columns
	            ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Layout Type", 'kossy'),
					"param_name" => "layout_type",
					"value" => $layouts
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Thumbnail size', 'kossy' ),
					'param_name' => 'thumbsize',
					'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'kossy' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'kossy' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kossy' )
				)
			)
		) );
	}

	add_action( 'vc_after_set_mode', 'kossy_load_post2_element', 99 );

	class WPBakeryShortCode_apus_gridposts extends WPBakeryShortCode {}
}