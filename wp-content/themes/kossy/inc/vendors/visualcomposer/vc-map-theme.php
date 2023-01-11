<?php

if ( function_exists('vc_map') && class_exists('WPBakeryShortCode') ) {
	
	if ( !function_exists('kossy_load_load_theme_element')) {
		function kossy_load_load_theme_element() {
			$columns = array(1,2,3,4,6);
			// Heading Text Block
			vc_map( array(
				'name'        => esc_html__( 'Apus Widget Heading','kossy'),
				'base'        => 'apus_title_heading',
				"class"       => "",
				"category" => esc_html__('Apus Elements', 'kossy'),
				'description' => esc_html__( 'Create title for one Widget', 'kossy' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget title', 'kossy' ),
						'param_name' => 'title',
						'description' => esc_html__( 'Enter heading title.', 'kossy' ),
						"admin_label" => true,
					),
					array(
						"type" => "textarea",
						'heading' => esc_html__( 'Description', 'kossy' ),
						"param_name" => "des",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'kossy' )
				    ),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'kossy'),
						"param_name" => "style",
						'value' 	=> array(
							esc_html__('Default Center', 'kossy') => 'center', 
							esc_html__('Default Center Style 2', 'kossy') => 'center style2', 
						),
						'std' => ''
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'kossy' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kossy' )
					)
				),
			));
			// Our Stage
			vc_map( array(
	            "name" => esc_html__("Apus Our Stage",'kossy'),
	            "base" => "apus_stage",
	            'description'=> esc_html__('Display Our Stage In FrontEnd', 'kossy'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'kossy'),
	            "params" => array(
	              	array(
						'type' => 'param_group',
						'heading' => esc_html__('Members Settings', 'kossy' ),
						'param_name' => 'members',
						'description' => '',
						'value' => '',
						'params' => array(
							array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Number','kossy'),
				                "param_name" => "number",
				            ),
							array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Title','kossy'),
				                "param_name" => "name",
				            ),
				            array(
				                "type" => "textarea",
				                "class" => "",
				                "heading" => esc_html__('Description','kossy'),
				                "param_name" => "des",
				            )
						),
					),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'kossy'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
					)
	            )
	        ));
			// Our Team
			vc_map( array(
	            "name" => esc_html__("Apus Our Team",'kossy'),
	            "base" => "apus_ourteam",
	            'description'=> esc_html__('Display Our Team In FrontEnd', 'kossy'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'kossy'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
	              	array(
						'type' => 'param_group',
						'heading' => esc_html__('Members Settings', 'kossy' ),
						'param_name' => 'members',
						'description' => '',
						'value' => '',
						'params' => array(
							array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Name','kossy'),
				                "param_name" => "name",
				            ),
				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Job','kossy'),
				                "param_name" => "job",
				            ),
							array(
								"type" => "attach_image",
								"heading" => esc_html__("Image", 'kossy'),
								"param_name" => "image"
							),
				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Facebook','kossy'),
				                "param_name" => "facebook",
				            ),

				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Twitter Link','kossy'),
				                "param_name" => "twitter",
				            ),

				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Google plus Link','kossy'),
				                "param_name" => "google",
				            ),

				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Linkin Link','kossy'),
				                "param_name" => "linkin",
				            ),

						),
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','kossy'),
		                "param_name" => 'columns',
		                "value" => array(1,2,3,4,5,6),
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'kossy'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
					)
	            )
	        ));
			// calltoaction
			vc_map( array(
				'name'        => esc_html__( 'Apus Call To Action','kossy'),
				'base'        => 'apus_call_action',
				"category" => esc_html__('Apus Elements', 'kossy'),
				'description' => esc_html__( 'Create title for one Widget', 'kossy' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub title', 'kossy' ),
						'param_name' => 'sub_title',
						'value'       => esc_html__( 'Title', 'kossy' ),
						'description' => esc_html__( 'Enter Sub heading title.', 'kossy' ),
						"admin_label" => true
					),
					array(
						"type" => "textarea_html",
						'heading' => esc_html__( 'Title', 'kossy' ),
						"param_name" => "content",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'kossy' )
				    ),
					array(
						"type" => "textarea",
						'heading' => esc_html__( 'Description', 'kossy' ),
						"param_name" => "des",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'kossy' )
				    ),
				    array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Text Button', 'kossy' ),
						'param_name' => 'textbutton1',
						'description' => esc_html__( 'Text Button', 'kossy' ),
						"admin_label" => true
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( ' Link Button', 'kossy' ),
						'param_name' => 'linkbutton1',
						'description' => esc_html__( 'Link Button', 'kossy' ),
						"admin_label" => true
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Button Style", 'kossy'),
						"param_name" => "buttons1",
						'value' 	=> array(
							esc_html__('Default ', 'kossy') => 'btn-default ', 
							esc_html__('Primary ', 'kossy') => 'btn-primary ', 
							esc_html__('Success ', 'kossy') => 'btn-success radius-0 ', 
							esc_html__('Info ', 'kossy') => 'btn-info ', 
							esc_html__('Warning ', 'kossy') => 'btn-warning ', 
							esc_html__('Theme Color ', 'kossy') => 'btn-theme',
							esc_html__('Theme Gradient Color ', 'kossy') => 'btn-theme btn-gradient',
							esc_html__('Second Color ', 'kossy') => 'btn-theme-second',
							esc_html__('Danger ', 'kossy') => 'btn-danger ', 
							esc_html__('Pink ', 'kossy') => 'btn-pink ', 
							esc_html__('White Gradient ', 'kossy') => 'btn-white btn-gradient', 
							esc_html__('Primary Outline', 'kossy') => 'btn-primary btn-outline', 
							esc_html__('White ', 'kossy') => 'btn-white',
							esc_html__('White Outline', 'kossy') => 'btn-white btn-outline',
							esc_html__('Theme Outline ', 'kossy') => 'btn-theme btn-outline ',
						),
						'std' => ''
					),
					
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'kossy'),
						"param_name" => "style",
						'value' 	=> array(
							esc_html__('Default Center', 'kossy') => 'default',
							esc_html__('White Center 1', 'kossy') => 'default st_white1',
							esc_html__('White Center 2', 'kossy') => 'default st_white2',
							esc_html__('Classic', 'kossy') => 'classic',
							esc_html__('Title Top', 'kossy') => 'titletop',
							esc_html__('Left', 'kossy') => 'st_left',
						),
						'std' => ''
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'kossy' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kossy' )
					)
				),
			));
			
			// Apus Counter
			vc_map( array(
			    "name" => esc_html__("Apus Counter",'kossy'),
			    "base" => "apus_counter",
			    "class" => "",
			    "description"=> esc_html__('Counting number with your term', 'kossy'),
			    "category" => esc_html__('Apus Elements', 'kossy'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number", 'kossy'),
						"param_name" => "number",
						"value" => ''
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Color Number", 'kossy'),
						"param_name" => "text_color",
						'value' 	=> '',
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'kossy'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
					)
			   	)
			));
			// Banner CountDown
			vc_map( array(
				'name'        => esc_html__( 'Apus Banner CountDown','kossy'),
				'base'        => 'apus_banner_countdown',
				"category" => esc_html__('Apus Elements', 'kossy'),
				'description' => esc_html__( 'Show CountDown with banner', 'kossy' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub Title', 'kossy' ),
						'param_name' => 'subtitle',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget Title', 'kossy' ),
						'param_name' => 'title',
					),
					array(
					    'type' => 'textfield',
					    'heading' => esc_html__( 'Date Expired', 'kossy' ),
					    'param_name' => 'input_datetime'
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Url', 'kossy' ),
						'param_name' => 'btn_url',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button Text', 'kossy' ),
						'param_name' => 'btn_text',
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'kossy'),
						"param_name" => "style_widget",
						'value' 	=> array(
							esc_html__('Default', 'kossy') => '',
						),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'kossy' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kossy' )
					),
				),
			));
			// Banner
			vc_map( array(
				'name'        => esc_html__( 'Apus Banner','kossy'),
				'base'        => 'apus_banner',
				"category" => esc_html__('Apus Elements', 'kossy'),
				'description' => esc_html__( 'Show banner in FrontEnd', 'kossy' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub Title', 'kossy' ),
						'param_name' => 'subtitle',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget Title', 'kossy' ),
						'param_name' => 'title',
					),
				    array(
						"type" => "attach_image",
						"heading" => esc_html__("Banner Image", 'kossy'),
						"param_name" => "image"
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Background Color", 'kossy'),
						"param_name" => "bg_color",
						'value' 	=> '',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Text Button', 'kossy' ),
						'param_name' => 'textbutton',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Url', 'kossy' ),
						'param_name' => 'url',
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Style','kossy'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Center ', 'kossy') => 'st_center', 
							esc_html__('Left Center', 'kossy') => 'st_left inner_center', 
							esc_html__('Right Center', 'kossy') => 'st_right inner_center',
						),
						'std' => ''
		            ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'kossy' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kossy' )
					),
				),
			));
			// Banner Image
			vc_map( array(
				'name'        => esc_html__( 'Apus Banner Image','kossy'),
				'base'        => 'apus_banner_img',
				"category" => esc_html__('Apus Elements', 'kossy'),
				'description' => esc_html__( 'Show banner in FrontEnd', 'kossy' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub Title', 'kossy' ),
						'param_name' => 'subtitle',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget Title', 'kossy' ),
						'param_name' => 'title',
					),
				    array(
						"type" => "attach_image",
						"heading" => esc_html__("Banner Image", 'kossy'),
						"param_name" => "image"
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Url', 'kossy' ),
						'param_name' => 'url',
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Style','kossy'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Style 1', 'kossy') => 'style1', 
							esc_html__('Style 2 ', 'kossy') => 'style2', 
						),
						'std' => ''
		            ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'kossy' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kossy' )
					),
				),
			));
			// Apus Brands
			vc_map( array(
			    "name" => esc_html__("Apus Brands",'kossy'),
			    "base" => "apus_brands",
			    "class" => "",
			    "description"=> esc_html__('Display brands on front end', 'kossy'),
			    "category" => esc_html__('Apus Elements', 'kossy'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number", 'kossy'),
						"param_name" => "number",
						"value" => ''
					),
				 	array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout Type", 'kossy'),
						"param_name" => "layout_type",
						'value' 	=> array(
							esc_html__('Carousel', 'kossy') => 'carousel', 
							esc_html__('Grid', 'kossy') => 'grid'
						),
						'std' => ''
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','kossy'),
		                "param_name" => 'columns',
		                "value" => array(1,2,3,4,5,6,8),
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Style','kossy'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Default ', 'kossy') => '', 
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
			));
			
			vc_map( array(
			    "name" => esc_html__("Apus Socials link",'kossy'),
			    "base" => "apus_socials_link",
			    "description"=> esc_html__('Show socials link', 'kossy'),
			    "category" => esc_html__('Apus Elements', 'kossy'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Description", 'kossy'),
						"param_name" => "description",
						"value" => '',
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Facebook Page URL", 'kossy'),
						"param_name" => "facebook_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Twitter Page URL", 'kossy'),
						"param_name" => "twitter_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Youtube Page URL", 'kossy'),
						"param_name" => "youtube_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Pinterest Page URL", 'kossy'),
						"param_name" => "pinterest_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Google Plus Page URL", 'kossy'),
						"param_name" => "google-plus_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Instagram Page URL", 'kossy'),
						"param_name" => "instagram_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Align", 'kossy'),
						"param_name" => "align",
						'value' 	=> array(
							esc_html__('Left', 'kossy') => 'left', 
							esc_html__('Right', 'kossy') => 'right',
							esc_html__('Center', 'kossy') => 'center'
						),
						'std' => ''
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'kossy'),
						"param_name" => "style",
						'value' 	=> array(
							esc_html__('Default', 'kossy') => '', 
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
			));
			// newsletter
			vc_map( array(
			    "name" => esc_html__("Apus Newsletter",'kossy'),
			    "base" => "apus_newsletter",
			    "class" => "",
			    "description"=> esc_html__('Show newsletter form', 'kossy'),
			    "category" => esc_html__('Apus Elements', 'kossy'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Description", 'kossy'),
						"param_name" => "description",
						"value" => '',
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Layout','kossy'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Style 1 ', 'kossy') => 'style1',
							esc_html__('Style 2 ', 'kossy') => 'style2',
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
			));
			
			// google map
			$map_styles = array( esc_html__('Choose a map style', 'kossy') => '' );
			if ( is_admin() && class_exists('Kossy_Google_Maps_Styles') ) {
				$styles = Kossy_Google_Maps_Styles::styles();
				foreach ($styles as $style) {
					$map_styles[$style['title']] = $style['slug'];
				}
			}
			vc_map( array(
			    "name" => esc_html__("Apus Google Map",'kossy'),
			    "base" => "apus_googlemap",
			    "description" => esc_html__('Diplay Google Map', 'kossy'),
			    "category" => esc_html__('Apus Elements', 'kossy'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
		                "type" => "textarea",
		                "class" => "",
		                "heading" => esc_html__('Description','kossy'),
		                "param_name" => "des",
		            ),
		            array(
		                'type' => 'googlemap',
		                'heading' => esc_html__( 'Location', 'kossy' ),
		                'param_name' => 'location',
		                'value' => ''
		            ),
		            array(
		                'type' => 'hidden',
		                'heading' => esc_html__( 'Latitude Longitude', 'kossy' ),
		                'param_name' => 'lat_lng',
		                'value' => '21.0173222,105.78405279999993'
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Map height", 'kossy'),
						"param_name" => "height",
						"value" => '',
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Map Zoom", 'kossy'),
						"param_name" => "zoom",
						"value" => '13',
					),
		            array(
		                'type' => 'dropdown',
		                'heading' => esc_html__( 'Map Type', 'kossy' ),
		                'param_name' => 'type',
		                'value' => array(
		                    esc_html__( 'roadmap', 'kossy' ) 		=> 'ROADMAP',
		                    esc_html__( 'hybrid', 'kossy' ) 	=> 'HYBRID',
		                    esc_html__( 'satellite', 'kossy' ) 	=> 'SATELLITE',
		                    esc_html__( 'terrain', 'kossy' ) 	=> 'TERRAIN',
		                )
		            ),
		            array(
						"type" => "attach_image",
						"heading" => esc_html__("Custom Marker Icon", 'kossy'),
						"param_name" => "marker_icon"
					),
					array(
		                'type' => 'dropdown',
		                'heading' => esc_html__( 'Custom Map Style', 'kossy' ),
		                'param_name' => 'map_style',
		                'value' => $map_styles
		            ),
		            
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'kossy'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
					)
			   	)
			));
			// Testimonial
			vc_map( array(
	            "name" => esc_html__("Apus Testimonials",'kossy'),
	            "base" => "apus_testimonials",
	            'description'=> esc_html__('Display Testimonials In FrontEnd', 'kossy'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'kossy'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
	              	array(
		              	"type" => "textfield",
		              	"heading" => esc_html__("Number", 'kossy'),
		              	"param_name" => "number",
		              	"value" => '4',
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','kossy'),
		                "param_name" => 'columns',
		                "value" => array(1,2,3,4,5,6),
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'kossy'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
					)
	            )
	        ));
	        
	        // Gallery Images
			vc_map( array(
	            "name" => esc_html__("Apus Gallery",'kossy'),
	            "base" => "apus_gallery",
	            'description'=> esc_html__('Display Gallery In FrontEnd', 'kossy'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'kossy'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Images', 'kossy'),
						'param_name' => 'images',
						'params' => array(
							array(
								"type" => "attach_image",
								"param_name" => "image",
								'heading'	=> esc_html__('Image', 'kossy')
							),
							array(
				                "type" => "textfield",
				                "heading" => esc_html__('Title','kossy'),
				                "param_name" => "title",
				            ),
				            array(
				                "type" => "textarea",
				                "heading" => esc_html__('Description','kossy'),
				                "param_name" => "description",
				            ),
						),
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','kossy'),
		                "param_name" => 'columns',
		                "value" => $columns,
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Layout Type','kossy'),
		                "param_name" => 'layout_type',
		                'value' 	=> array(
							esc_html__('Grid', 'kossy') => 'grid', 
							esc_html__('Mansory 1', 'kossy') => 'mansory',
							esc_html__('Mansory 2', 'kossy') => 'mansory2',
						),
						'std' => 'grid'
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Gutter Elements','kossy'),
		                "param_name" => 'gutter',
		                'value' 	=> array(
							esc_html__('Default ', 'kossy') => '', 
							esc_html__('Gutter 30', 'kossy') => 'gutter30',
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
	        ));
	        // Gallery Video
			vc_map( array(
	            "name" => esc_html__("Apus Video",'kossy'),
	            "base" => "apus_video",
	            'description'=> esc_html__('Display Video In FrontEnd', 'kossy'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'kossy'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
						"type" => "textarea_html",
						'heading' => esc_html__( 'Description', 'kossy' ),
						"param_name" => "content",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'kossy' )
				    ),
	              	array(
						"type" => "attach_image",
						"heading" => esc_html__("Background Play Image", 'kossy'),
						"param_name" => "image"
					),
					array(
		                "type" => "textfield",
		                "heading" => esc_html__('Youtube Video Link','kossy'),
		                "param_name" => 'video_link'
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'kossy'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
					)
	            )
	        ));
	        // Features Box
			vc_map( array(
	            "name" => esc_html__("Apus Features Box",'kossy'),
	            "base" => "apus_features_box",
	            'description'=> esc_html__('Display Features In FrontEnd', 'kossy'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'kossy'),
	            "params" => array(
	            	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Members Settings', 'kossy' ),
						'param_name' => 'items',
						'description' => '',
						'value' => '',
						'params' => array(
							array(
								"type" => "attach_image",
								"description" => esc_html__("Image for box.", 'kossy'),
								"param_name" => "image",
								"value" => '',
								'heading'	=> esc_html__('Image', 'kossy' )
							),
							array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Title','kossy'),
				                "param_name" => "title",
				            ),
				            array(
				                "type" => "textarea",
				                "class" => "",
				                "heading" => esc_html__('Description','kossy'),
				                "param_name" => "description",
				            ),
							array(
								"type" => "textfield",
								"heading" => esc_html__("Material Design Icon and Awesome Icon", 'kossy'),
								"param_name" => "icon",
								"value" => '',
								'description' => esc_html__( 'This support display icon from Material Design and Awesome Icon, Please click', 'kossy' )
												. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://zavoloklom.github.io/material-design-iconic-font/icons.html" target="_blank">'
												. esc_html__( 'here to see the list', 'kossy' ) . '</a>'
							),
						),
					),
		           	array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Style Layout','kossy'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Default', 'kossy') => '', 
							esc_html__('Center', 'kossy') => 'st_center', 
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
	        ));

			$custom_menus = array();
			if ( is_admin() ) {
				$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
				if ( is_array( $menus ) && ! empty( $menus ) ) {
					foreach ( $menus as $single_menu ) {
						if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
							$custom_menus[ $single_menu->name ] = $single_menu->slug;
						}
					}
				}
			}
			// Menu
			vc_map( array(
			    "name" => esc_html__("Apus Custom Menu",'kossy'),
			    "base" => "apus_custom_menu",
			    "class" => "",
			    "description"=> esc_html__('Show Custom Menu', 'kossy'),
			    "category" => esc_html__('Apus Elements', 'kossy'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Menu', 'kossy' ),
						'param_name' => 'nav_menu',
						'value' => $custom_menus,
						'description' => empty( $custom_menus ) ? esc_html__( 'Custom menus not found. Please visit Appearance > Menus page to create new menu.', 'kossy' ) : esc_html__( 'Select menu to display.', 'kossy' ),
						'admin_label' => true,
						'save_always' => true,
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Align','kossy'),
		                "param_name" => 'align',
		                'value' 	=> array(
							esc_html__('Inherit', 'kossy') => '', 
							esc_html__('Left', 'kossy') => 'left', 
							esc_html__('Right', 'kossy') => 'right', 
							esc_html__('Center', 'kossy') => 'center', 
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
			));

			vc_map( array(
	            "name" => esc_html__("Apus Instagram",'kossy'),
	            "base" => "apus_instagram",
	            'description'=> esc_html__('Display Instagram In FrontEnd', 'kossy'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'kossy'),
	            "params" => array(
	            	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'kossy'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
		                "type" => "textarea",
		                "heading" => esc_html__('Description','kossy'),
		                "param_name" => "description",
		            ),
					array(
		              	"type" => "textfield",
		              	"heading" => esc_html__("Instagram Username", 'kossy'),
		              	"param_name" => "username",
		            ),
					array(
		              	"type" => "textfield",
		              	"heading" => esc_html__("Number", 'kossy'),
		              	"param_name" => "number",
		              	'value' => '1',
		            ),
	             	array(
		              	"type" => "textfield",
		              	"heading" => esc_html__("Number Columns", 'kossy'),
		              	"param_name" => "columns",
		              	'value' => '1',
		            ),
		           	array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Layout Type','kossy'),
		                "param_name" => 'layout_type',
		                'value' 	=> array(
							esc_html__('Grid', 'kossy') => 'grid', 
							esc_html__('Carousel', 'kossy') => 'carousel', 
						)
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Photo size','kossy'),
		                "param_name" => 'size',
		                'value' 	=> array(
							esc_html__('Thumbnail', 'kossy') => 'thumbnail', 
							esc_html__('Small', 'kossy') => 'small', 
							esc_html__('Large', 'kossy') => 'large', 
							esc_html__('Original', 'kossy') => 'original', 
						)
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Open links in','kossy'),
		                "param_name" => 'target',
		                'value' 	=> array(
							esc_html__('Current window (_self)', 'kossy') => '_self', 
							esc_html__('New window (_blank)', 'kossy') => '_blank',
						)
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Layout For Widget','kossy'),
		                "param_name" => 'layout_widget',
		                'value' 	=> array(
							esc_html__('Default', 'kossy') => '', 
						)
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'kossy'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'kossy')
					)
	            )
	        ));
		}
	}
	add_action( 'vc_after_set_mode', 'kossy_load_load_theme_element', 99 );

	class WPBakeryShortCode_apus_title_heading extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_call_action extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_brands extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_socials_link extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_newsletter extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_googlemap extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_testimonials extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_banner_countdown extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_banner extends WPBakeryShortCode {}

	class WPBakeryShortCode_apus_counter extends WPBakeryShortCode {
		public function __construct( $settings ) {
			parent::__construct( $settings );
			$this->load_scripts();
		}

		public function load_scripts() {
			wp_register_script('jquery-counterup', get_template_directory_uri().'/js/jquery.counterup.min.js', array('jquery'), false, true);
		}
	}
	class WPBakeryShortCode_apus_gallery extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_video extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_features_box extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_custom_menu extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_instagram extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_banner_img extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_ourteam extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_stage extends WPBakeryShortCode {}
}