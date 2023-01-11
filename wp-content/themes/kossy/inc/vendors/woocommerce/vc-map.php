<?php
if ( function_exists('vc_map') && class_exists('WPBakeryShortCode') ) {
	
	if ( !function_exists('kossy_vc_get_product_object')) {
		function kossy_vc_get_product_object($term) {
			$vc_taxonomies_types = vc_taxonomies_types();

			return array(
				'label' => $term->post_title,
				'value' => $term->post_name,
				'group_id' => $term->post_name,
				'group' => isset( $vc_taxonomies_types[ $term->taxonomy ], $vc_taxonomies_types[ $term->taxonomy ]->labels, $vc_taxonomies_types[ $term->taxonomy ]->labels->name ) ? $vc_taxonomies_types[ $term->taxonomy ]->labels->name : esc_html__( 'Taxonomies', 'kossy' ),
			);
		}
	}

	if ( !function_exists('kossy_product_field_search')) {
		function kossy_product_field_search( $search_string ) {
			$data = array();
			$loop = kossy_get_products( array( 'product_type' => 'deals' ) );

			if ( !empty($loop->posts) ) {

				foreach ( $loop->posts as $t ) {
					if ( is_object( $t ) ) {
						$data[] = kossy_vc_get_product_object( $t );
					}
				}
			}
			
			return $data;
		}
	}

	if ( !function_exists('kossy_product_render')) {
		function kossy_product_render( $query ) {
			$args = array(
			  'name'        => $query['value'],
			  'post_type'   => 'product',
			  'post_status' => 'publish',
			  'numberposts' => 1
			);
			$products = get_posts($args);
			if ( ! empty( $query ) && $products ) {
				$product = $products[0];
				$data = array();
				$data['value'] = $product->post_name;
				$data['label'] = $product->post_title;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}
	}
	add_filter( 'vc_autocomplete_apus_product_deal_product_slugs_callback', 'kossy_product_field_search', 10, 1 );
	add_filter( 'vc_autocomplete_apus_product_deal_product_slugs_render', 'kossy_product_render', 10, 1 );
	
	if ( !function_exists('kossy_vc_get_term_object')) {
		function kossy_vc_get_term_object($term) {
			$vc_taxonomies_types = vc_taxonomies_types();

			return array(
				'label' => $term->name,
				'value' => $term->slug,
				'group_id' => $term->taxonomy,
				'group' => isset( $vc_taxonomies_types[ $term->taxonomy ], $vc_taxonomies_types[ $term->taxonomy ]->labels, $vc_taxonomies_types[ $term->taxonomy ]->labels->name ) ? $vc_taxonomies_types[ $term->taxonomy ]->labels->name : esc_html__( 'Taxonomies', 'kossy' ),
			);
		}
	}

	if ( !function_exists('kossy_category_field_search')) {
		function kossy_category_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('product_cat');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = kossy_vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}
	}

	if ( !function_exists('kossy_category_render')) {
		function kossy_category_render($query) {  
			$category = get_term_by('slug', $query['value'], 'product_cat');
			if ( ! empty( $query ) && !empty($category)) {
				$data = array();
				$data['value'] = $category->slug;
				$data['label'] = $category->name;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}
	}

	$bases = array( 'apus_products' );
	foreach( $bases as $base ){   
		add_filter( 'vc_autocomplete_'.$base .'_categories_callback', 'kossy_category_field_search', 10, 1 );
	 	add_filter( 'vc_autocomplete_'.$base .'_categories_render', 'kossy_category_render', 10, 1 );
	}

	function kossy_load_woocommerce_element() {
		$categories = array();
		if ( is_admin() ) {
			$categories = kossy_woocommerce_get_categories();
		}
		$types = array(
			esc_html__('Recent Products', 'kossy' ) => 'recent_product',
			esc_html__('Best Selling', 'kossy' ) => 'best_selling',
			esc_html__('Featured Products', 'kossy' ) => 'featured_product',
			esc_html__('Top Rate', 'kossy' ) => 'top_rate',
			esc_html__('On Sale', 'kossy' ) => 'on_sale',
			esc_html__('Recent Review', 'kossy' ) => 'recent_review'
		);

		vc_map( array(
			'name' => esc_html__( 'Apus Products', 'kossy' ),
			'base' => 'apus_products',
			'icon' => 'icon-wpb-woocommerce',
			'category' => esc_html__( 'Apus Woocommerce', 'kossy' ),
			'description' => esc_html__( 'Display products in frontend', 'kossy' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'kossy' ),
					'param_name' => 'title',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Get Products By", 'kossy'),
					"param_name" => "type",
					"value" => $types,
				),
				array(
				    'type' => 'autocomplete',
				    'heading' => esc_html__( 'Get Products By Categories', 'kossy' ),
				    'param_name' => 'categories',
				    'settings' => array(
				     	'multiple' => true,
				     	'unique_values' => true
				    ),
			   	),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number Products', 'kossy' ),
					'value' => 10,
					'param_name' => 'number',
					'description' => esc_html__( 'Number products per page to show', 'kossy' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( 'Layout Type', 'kossy' ),
					"param_name" => "layout_type",
					"value" => array(
						esc_html__( 'Grid', 'kossy' ) => 'grid',
						esc_html__( 'Carousel', 'kossy' ) => 'carousel',
						esc_html__( 'Mansory V1', 'kossy' ) => 'mansory-v1',
						esc_html__( 'Mansory V2', 'kossy' ) => 'mansory-v2',
						esc_html__( 'Mansory V3', 'kossy' ) => 'mansory-v3',
					)
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Columns', 'kossy'),
	                "param_name" => 'columns',
	                "value" => array(1,2,3,4,5,6),
	                'dependency' => array(
						'element' => 'layout_type',
						'value' => array('grid', 'carousel'),
					),
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Rows', 'kossy'),
	                "param_name" => 'rows',
	                "value" => array(1,2,3,4,5),
	                'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
	            ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( 'Product Style', 'kossy' ),
					"param_name" => "product_style",
					"value" => array(
						esc_html__( 'Grid Default', 'kossy' ) => 'inner',
						esc_html__( 'Grid Left', 'kossy' ) => 'inner-left',
						esc_html__( 'Grid Center', 'kossy' ) => 'inner-center',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Navigation', 'kossy' ),
					'param_name' => 'show_nav',
					'value' => array( esc_html__( 'Yes, to show navigation', 'kossy' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination', 'kossy' ),
					'param_name' => 'show_pagination',
					'value' => array( esc_html__( 'Yes, to show Pagination', 'kossy' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Button All Items', 'kossy' ),
					'param_name' => 'show_all',
					'value' => array( esc_html__( 'Yes, Show Button All Items', 'kossy' ) => 'yes' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Text Button', 'kossy' ),
					'param_name' => 'text_button',
					'dependency' => array(
						'element' => 'show_all',
						'value' => 'yes',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Link Button', 'kossy' ),
					'param_name' => 'link_button',
					'dependency' => array(
						'element' => 'show_all',
						'value' => 'yes',
					),
				),
	            array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name",'kossy'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",'kossy')
				)
			)
		) );

		vc_map( array(
			'name' => esc_html__( 'Apus Products Tabs', 'kossy' ),
			'base' => 'apus_products_tabs',
			'icon' => 'icon-wpb-woocommerce',
			'category' => esc_html__( 'Apus Woocommerce', 'kossy' ),
			'description' => esc_html__( 'Display products in Tabs', 'kossy' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget Title', 'kossy' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'param_group',
					'heading' => esc_html__( 'Product Tabs', 'kossy' ),
					'param_name' => 'tabs',
					'params' => array(
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Tab Title', 'kossy' ),
							'param_name' => 'title',
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Get Products By",'kossy'),
							"param_name" => "type",
							"value" => $types,
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__( 'Category', 'kossy' ),
							"param_name" => "category",
							"value" => $categories
						),
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number Products', 'kossy' ),
					'value' => 10,
					'param_name' => 'number',
					'description' => esc_html__( 'Number products per page to show', 'kossy' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( 'Layout Type', 'kossy' ),
					"param_name" => "layout_type",
					"value" => array(
						esc_html__( 'Grid', 'kossy' ) => 'grid',
						esc_html__( 'Carousel', 'kossy' ) => 'carousel',
					)
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Columns', 'kossy'),
	                "param_name" => 'columns',
	                "value" => array(1,2,3,4,5,6),
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Rows', 'kossy'),
	                "param_name" => 'rows',
	                "value" => array(1,2,3,4),
	                'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
	            ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( 'Product Item Style', 'kossy' ),
					"param_name" => "product_item",
					"value" => array(
						esc_html__( 'Grid Style', 'kossy' ) => 'inner',
						esc_html__( 'List Style', 'kossy' ) => 'list',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Navigation', 'kossy' ),
					'param_name' => 'show_nav',
					'value' => array( esc_html__( 'Yes, to show navigation', 'kossy' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination', 'kossy' ),
					'param_name' => 'show_pagination',
					'value' => array( esc_html__( 'Yes, to show Pagination', 'kossy' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
				),
	            array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name",'kossy'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",'kossy')
				)
			)
		) );

		vc_map( array(
			'name' => esc_html__( 'Apus Products Deal', 'kossy' ),
			'base' => 'apus_product_deal',
			'icon' => 'icon-wpb-woocommerce',
			'category' => esc_html__( 'Apus Woocommerce', 'kossy' ),
			'description' => esc_html__( 'Display product deal', 'kossy' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'kossy' ),
					'param_name' => 'title',
				),
				array(
				    'type' => 'autocomplete',
				    'heading' => esc_html__( 'Choose Products', 'kossy' ),
				    'param_name' => 'product_slugs',
				    'settings' => array(
				     	'multiple' => true,
				     	'unique_values' => true
				    ),
			   	),
			   	array(
					"type" => "dropdown",
					"heading" => esc_html__( 'Layout Type', 'kossy' ),
					"param_name" => "layout_type",
					"value" => array(
						esc_html__( 'Grid', 'kossy' ) => 'grid',
						esc_html__( 'Carousel', 'kossy' ) => 'carousel',
					)
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Columns', 'kossy'),
	                "param_name" => 'columns',
	                "value" => array(1,2,3,4,5,6),
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Rows', 'kossy'),
	                "param_name" => 'rows',
	                "value" => array(1,2,3,4),
	                'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
	            ),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Navigation', 'kossy' ),
					'param_name' => 'show_nav',
					'value' => array( esc_html__( 'Yes, to show navigation', 'kossy' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination', 'kossy' ),
					'param_name' => 'show_pagination',
					'value' => array( esc_html__( 'Yes, to show Pagination', 'kossy' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show 2 Item on Laptop', 'kossy' ),
					'param_name' => 'show_smalldestop',
					'value' => array( esc_html__( 'Yes', 'kossy' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value' => array('carousel'),
					),
				),
	            array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'kossy'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",'kossy')
				)
			)
		) );

		vc_map( array(
			'name' => esc_html__( 'Apus Category Banners', 'kossy' ),
			'base' => 'apus_category_banner',
			'icon' => 'icon-wpb-woocommerce',
			'category' => esc_html__( 'Apus Woocommerce', 'kossy' ),
			'description' => esc_html__( 'Display category banner', 'kossy' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'kossy' ),
					'param_name' => 'title',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( 'Category', 'kossy' ),
					"param_name" => "category",
					"value" => $categories
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Category Image", 'kossy'),
					"param_name" => "image"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'kossy'),
					"param_name" => "style",
					'value' 	=> array(
						esc_html__('Style 1', 'kossy') => '', 
						esc_html__('Style 2', 'kossy') => 'style2', 
					),
					'std' => ''
				),
	            array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'kossy'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
				)
			)
		) );
	}
	add_action( 'vc_after_set_mode', 'kossy_load_woocommerce_element', 99 );

	class WPBakeryShortCode_apus_products extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_products_tabs extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_product_deal extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_category_banner extends WPBakeryShortCode {}
}