<?php

if ( ! function_exists( 'eldon_core_add_page_footer_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function eldon_core_add_page_footer_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => ELDON_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'footer',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Footer', 'eldon-core' ),
				'description' => esc_html__( 'Global Footer Options', 'eldon-core' ),
			)
		);

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_page_footer',
					'title'         => esc_html__( 'Enable Page Footer', 'eldon-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable page footer', 'eldon-core' ),
					'default_value' => 'yes',
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'default_value' => 'yes',
					'name'          => 'qodef_footer_borders_enabled',
					'title'         => esc_html__( 'Footer Borders', 'eldon-core' ),
					'description'   => esc_html__( 'Enable footer borders', 'eldon-core' ),
					'dependency'    => array(
						'show' => array(
							'qodef_enable_page_footer' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_footer_offset_responsive',
					'title'       => esc_html__( 'Footer Responsive Offset', 'eldon-core' ),
					'description' => esc_html__( 'Enter size amount for footer offset for smaller screens (1024px and below)', 'eldon-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'eldon-core' ),
					),
				)
			);

			$page_footer_section = $page->add_section_element(
				array(
					'name'       => 'qodef_page_footer_section',
					'title'      => esc_html__( 'Footer Area', 'eldon-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_page_footer' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			// General Footer Area Options

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_uncovering_footer',
					'title'         => esc_html__( 'Enable Uncovering Footer', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'eldon-core' ),
					'default_value' => 'no',
				)
			);

			// Top Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_top_footer_area',
					'title'         => esc_html__( 'Enable Top Footer Area', 'eldon-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable top footer area', 'eldon-core' ),
					'default_value' => 'yes',
				)
			);

			$top_footer_area_section = $page_footer_section->add_section_element(
				array(
					'name'       => 'qodef_top_footer_area_section',
					'title'      => esc_html__( 'Top Footer Area', 'eldon-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_top_footer_area' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_top_area_in_grid',
					'title'         => esc_html__( 'Top Footer Area In Grid', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will set page top footer area to be in grid', 'eldon-core' ),
					'default_value' => 'yes',
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_top_area_extended_grid',
					'title'         => esc_html__( 'Extend The Grid To Left', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will extend page top footer grid area to the left', 'eldon-core' ),
					'default_value' => 'no',
					'dependency'    => array(
						'hide' => array(
							'qodef_set_footer_top_area_in_grid' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_top_area_columns',
					'title'         => esc_html__( 'Top Footer Area Columns', 'eldon-core' ),
					'description'   => esc_html__( 'Choose number of columns for top footer area', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'columns_number', true, array( '5', '6' ) ),
					'default_value' => '4',
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_top_four_columns_proportion',
					'title'         => esc_html__( 'Top Footer Four Columns Proportion', 'eldon-core' ),
					'description'   => esc_html__( 'Choose proportion for columns', 'eldon-core' ),
					'options'       => array(
						'25-25-25-25' => esc_html__( '25% - 25% - 25% - 25%', 'eldon-core' ),
						'20-20-20-40' => esc_html__( '20% - 20% - 20% - 40%', 'eldon-core' ),
					),
					'default_value' => '25-25-25-25',
					'dependency'    => array(
						'show' => array(
							'qodef_set_footer_top_area_columns' => array(
								'values'        => '4',
								'default_value' => '4',
							),
						),
					),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_grid_gutter',
					'title'       => esc_html__( 'Top Footer Area Grid Gutter', 'eldon-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between columns for top footer area', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_content_alignment',
					'title'       => esc_html__( 'Content Alignment', 'eldon-core' ),
					'description' => esc_html__( 'Set widgets content alignment inside top footer area', 'eldon-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'eldon-core' ),
						'left'   => esc_html__( 'Left', 'eldon-core' ),
						'center' => esc_html__( 'Center', 'eldon-core' ),
						'right'  => esc_html__( 'Right', 'eldon-core' ),
					),
				)
			);

			$top_footer_area_styles_section = $top_footer_area_section->add_section_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_section',
					'title' => esc_html__( 'Top Footer Area Styles', 'eldon-core' ),
				)
			);

			$top_footer_area_styles_row = $top_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_row',
					'title' => '',
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_padding_top',
					'title'      => esc_html__( 'Padding Top', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_padding_bottom',
					'title'      => esc_html__( 'Padding Bottom', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_side_padding',
					'title'      => esc_html__( 'Side Padding', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
					'dependency' => array(
						'hide' => array(
							'qodef_set_footer_top_area_extended_grid' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_top_footer_area_background_color',
					'title'      => esc_html__( 'Background Color', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_top_footer_area_background_image',
					'title'      => esc_html__( 'Background Image', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row_2 = $top_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_row_2',
					'title' => '',
				)
			);

			$top_footer_area_styles_row_2->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_top_footer_area_widgets_margin_bottom',
					'title'       => esc_html__( 'Widgets Margin Bottom', 'eldon-core' ),
					'description' => esc_html__( 'Set space value between widgets', 'eldon-core' ),
					'args'        => array(
						'col_width' => 4,
					),
				)
			);

			$top_footer_area_styles_row_2->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_top_footer_area_widgets_title_margin_bottom',
					'title'       => esc_html__( 'Widgets Title Margin Bottom', 'eldon-core' ),
					'description' => esc_html__( 'Set space value between widget title and widget content', 'eldon-core' ),
					'args'        => array(
						'col_width' => 4,
					),
				)
			);

			// Bottom Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_bottom_footer_area',
					'title'         => esc_html__( 'Enable Bottom Footer Area', 'eldon-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable bottom footer area', 'eldon-core' ),
					'default_value' => 'yes',
				)
			);

			$bottom_footer_area_section = $page_footer_section->add_section_element(
				array(
					'name'       => 'qodef_bottom_footer_area_section',
					'title'      => esc_html__( 'Bottom Footer Area', 'eldon-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_bottom_footer_area' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_bottom_area_in_grid',
					'title'         => esc_html__( 'Bottom Footer Area In Grid', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will set page bottom footer area to be in grid', 'eldon-core' ),
					'default_value' => 'yes',
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_bottom_area_columns',
					'title'         => esc_html__( 'Bottom Footer Area Columns', 'eldon-core' ),
					'description'   => esc_html__( 'Choose number of columns for bottom footer area', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'columns_number', true, array( '3', '4', '5', '6' ) ),
					'default_value' => '2',
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_grid_gutter',
					'title'       => esc_html__( 'Bottom Footer Area Grid Gutter', 'eldon-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between columns for bottom footer area', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_content_alignment',
					'title'       => esc_html__( 'Content Alignment', 'eldon-core' ),
					'description' => esc_html__( 'Set widgets content alignment inside bottom footer area', 'eldon-core' ),
					'options'     => array(
						''              => esc_html__( 'Default', 'eldon-core' ),
						'left'          => esc_html__( 'Left', 'eldon-core' ),
						'center'        => esc_html__( 'Center', 'eldon-core' ),
						'right'         => esc_html__( 'Right', 'eldon-core' ),
						'space-between' => esc_html__( 'Space Between', 'eldon-core' ),
					),
				)
			);

			$bottom_footer_area_styles_section = $bottom_footer_area_section->add_section_element(
				array(
					'name'  => 'qodef_bottom_footer_area_styles_section',
					'title' => esc_html__( 'Bottom Footer Area Styles', 'eldon-core' ),
				)
			);

			$bottom_footer_area_styles_row = $bottom_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_bottom_footer_area_styles_row',
					'title' => '',
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_padding_top',
					'title'      => esc_html__( 'Padding Top', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_padding_bottom',
					'title'      => esc_html__( 'Padding Bottom', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_side_padding',
					'title'      => esc_html__( 'Side Padding', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_bottom_footer_area_background_color',
					'title'      => esc_html__( 'Background Color', 'eldon-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_page_footer_options_map', $page );
		}
	}

	add_action( 'eldon_core_action_default_options_init', 'eldon_core_add_page_footer_options', eldon_core_get_admin_options_map_position( 'footer' ) );
}
