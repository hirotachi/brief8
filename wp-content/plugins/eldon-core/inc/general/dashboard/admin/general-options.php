<?php

if ( ! function_exists( 'eldon_core_add_general_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function eldon_core_add_general_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_main_color',
					'title'       => esc_html__( 'Main Color', 'eldon-core' ),
					'description' => esc_html__( 'Choose the most dominant theme color', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_background_color',
					'title'       => esc_html__( 'Page Background Color', 'eldon-core' ),
					'description' => esc_html__( 'Set background color', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_page_background_image',
					'title'       => esc_html__( 'Page Background Image', 'eldon-core' ),
					'description' => esc_html__( 'Set background image', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_repeat',
					'title'       => esc_html__( 'Page Background Image Repeat', 'eldon-core' ),
					'description' => esc_html__( 'Set background image repeat', 'eldon-core' ),
					'options'     => array(
						''          => esc_html__( 'Default', 'eldon-core' ),
						'no-repeat' => esc_html__( 'No Repeat', 'eldon-core' ),
						'repeat'    => esc_html__( 'Repeat', 'eldon-core' ),
						'repeat-x'  => esc_html__( 'Repeat-x', 'eldon-core' ),
						'repeat-y'  => esc_html__( 'Repeat-y', 'eldon-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_size',
					'title'       => esc_html__( 'Page Background Image Size', 'eldon-core' ),
					'description' => esc_html__( 'Set background image size', 'eldon-core' ),
					'options'     => array(
						''        => esc_html__( 'Default', 'eldon-core' ),
						'contain' => esc_html__( 'Contain', 'eldon-core' ),
						'cover'   => esc_html__( 'Cover', 'eldon-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_attachment',
					'title'       => esc_html__( 'Page Background Image Attachment', 'eldon-core' ),
					'description' => esc_html__( 'Set background image attachment', 'eldon-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'eldon-core' ),
						'fixed'  => esc_html__( 'Fixed', 'eldon-core' ),
						'scroll' => esc_html__( 'Scroll', 'eldon-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding',
					'title'       => esc_html__( 'Page Content Padding', 'eldon-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding_mobile',
					'title'       => esc_html__( 'Page Content Padding Mobile', 'eldon-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_global_skin',
					'title'         => esc_html__( 'Global Skin', 'eldon-core' ),
					'description'   => esc_html__( 'Set website global skin', 'eldon-core' ),
					'options'       => array(
						'black' => esc_html__( 'Black', 'eldon-core' ),
						'white' => esc_html__( 'White', 'eldon-core' ),
					),
					'default_value' => 'black',
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_boxed',
					'title'         => esc_html__( 'Boxed Layout', 'eldon-core' ),
					'description'   => esc_html__( 'Set boxed layout', 'eldon-core' ),
					'default_value' => 'no',
				)
			);

			$boxed_section = $page->add_section_element(
				array(
					'name'       => 'qodef_boxed_section',
					'title'      => esc_html__( 'Boxed Layout Section', 'eldon-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_boxed' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_boxed_background_color',
					'title'       => esc_html__( 'Boxed Background Color', 'eldon-core' ),
					'description' => esc_html__( 'Set boxed background color', 'eldon-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_boxed_background_pattern',
					'title'       => esc_html__( 'Boxed Background Pattern', 'eldon-core' ),
					'description' => esc_html__( 'Set boxed background pattern', 'eldon-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_boxed_background_pattern_behavior',
					'title'       => esc_html__( 'Boxed Background Pattern Behavior', 'eldon-core' ),
					'description' => esc_html__( 'Set boxed background pattern behavior', 'eldon-core' ),
					'options'     => array(
						'fixed'  => esc_html__( 'Fixed', 'eldon-core' ),
						'scroll' => esc_html__( 'Scroll', 'eldon-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_passepartout',
					'title'         => esc_html__( 'Passepartout', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will display a passepartout around website content', 'eldon-core' ),
					'default_value' => 'no',
				)
			);

			$passepartout_section = $page->add_section_element(
				array(
					'name'       => 'qodef_passepartout_section',
					'title'      => esc_html__( 'Passepartout Section', 'eldon-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_passepartout' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_passepartout_color',
					'title'       => esc_html__( 'Passepartout Color', 'eldon-core' ),
					'description' => esc_html__( 'Choose background color for passepartout', 'eldon-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_passepartout_image',
					'title'       => esc_html__( 'Passepartout Background Image', 'eldon-core' ),
					'description' => esc_html__( 'Set background image for passepartout', 'eldon-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size',
					'title'       => esc_html__( 'Passepartout Size', 'eldon-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout', 'eldon-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'eldon-core' ),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size_responsive',
					'title'       => esc_html__( 'Passepartout Responsive Size', 'eldon-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (1024px and below)', 'eldon-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'eldon-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_content_width',
					'title'         => esc_html__( 'Initial Width of Content', 'eldon-core' ),
					'description'   => esc_html__( 'Choose the initial width of content which is in grid (applies to pages set to "Default Template" and rows set to "In Grid")', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'content_width', false ),
					'default_value' => '1100',
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_general_options_map', $page );

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_disable_images_lazy_loading',
					'title'         => esc_html__( 'Disable Images Lazy Loading', 'eldon-core' ),
					'description'   => esc_html__( 'Note that some images that have hover animation will not load if this option is turned off', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'yes',
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_custom_js',
					'title'       => esc_html__( 'Custom JS', 'eldon-core' ),
					'description' => esc_html__( 'Enter your custom JavaScript here', 'eldon-core' ),
				)
			);
		}
	}

	add_action( 'eldon_core_action_default_options_init', 'eldon_core_add_general_options', eldon_core_get_admin_options_map_position( 'general' ) );
}
