<?php

if ( ! function_exists( 'eldon_core_add_general_page_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function eldon_core_add_general_page_meta_box( $page ) {

		$general_tab = $page->add_tab_element(
			array(
				'name'        => 'tab-page',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Page Settings', 'eldon-core' ),
				'description' => esc_html__( 'General page layout settings', 'eldon-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_page_background_color',
				'title'       => esc_html__( 'Page Background Color', 'eldon-core' ),
				'description' => esc_html__( 'Set background color', 'eldon-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'image',
				'name'        => 'qodef_page_background_image',
				'title'       => esc_html__( 'Page Background Image', 'eldon-core' ),
				'description' => esc_html__( 'Set background image', 'eldon-core' ),
			)
		);

		$general_tab->add_field_element(
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

		$general_tab->add_field_element(
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

		$general_tab->add_field_element(
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

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_padding',
				'title'       => esc_html__( 'Page Content Padding', 'eldon-core' ),
				'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'eldon-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_padding_mobile',
				'title'       => esc_html__( 'Page Content Padding Mobile', 'eldon-core' ),
				'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'eldon-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_global_skin',
				'title'         => esc_html__( 'Page Skin', 'eldon-core' ),
				'description'   => esc_html__( 'Set page skin', 'eldon-core' ),
				'options'       => array(
					''      => esc_html__( 'Default', 'eldon-core' ),
					'black' => esc_html__( 'Black', 'eldon-core' ),
					'white' => esc_html__( 'White', 'eldon-core' ),
				),
				'default_value' => '',
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_boxed',
				'title'         => esc_html__( 'Boxed Layout', 'eldon-core' ),
				'description'   => esc_html__( 'Set boxed layout', 'eldon-core' ),
				'default_value' => '',
				'options'       => eldon_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$boxed_section = $general_tab->add_section_element(
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
					''       => esc_html__( 'Default', 'eldon-core' ),
					'fixed'  => esc_html__( 'Fixed', 'eldon-core' ),
					'scroll' => esc_html__( 'Scroll', 'eldon-core' ),
				),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_passepartout',
				'title'         => esc_html__( 'Passepartout', 'eldon-core' ),
				'description'   => esc_html__( 'Enabling this option will display a passepartout around website content', 'eldon-core' ),
				'default_value' => '',
				'options'       => eldon_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$passepartout_section = $general_tab->add_section_element(
			array(
				'name'       => 'qodef_passepartout_section',
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

		$general_tab->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_content_width',
				'title'       => esc_html__( 'Initial Width of Content', 'eldon-core' ),
				'description' => esc_html__( 'Choose the initial width of content which is in grid (applies to pages set to "Default Template" and rows set to "In Grid")', 'eldon-core' ),
				'options'     => eldon_core_get_select_type_options_pool( 'content_width' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'yesno',
				'default_value' => 'no',
				'name'          => 'qodef_content_behind_header',
				'title'         => esc_html__( 'Always put content behind header', 'eldon-core' ),
				'description'   => esc_html__( 'Enabling this option will put page content behind page header', 'eldon-core' ),
			)
		);

		// Hook to include additional options after module options
		do_action( 'eldon_core_action_after_general_page_meta_box_map', $general_tab );
	}

	add_action( 'eldon_core_action_after_general_meta_box_map', 'eldon_core_add_general_page_meta_box', 9 );
}

if ( ! function_exists( 'eldon_core_add_general_page_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function eldon_core_add_general_page_meta_box_callback( $callbacks ) {
		$callbacks['page'] = 'eldon_core_add_general_page_meta_box';

		return $callbacks;
	}

	add_filter( 'eldon_core_filter_general_meta_box_callbacks', 'eldon_core_add_general_page_meta_box_callback' );
}
