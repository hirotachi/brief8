<?php

if ( ! function_exists( 'eldon_core_add_page_footer_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function eldon_core_add_page_footer_meta_box( $page ) {

		if ( $page ) {
			$custom_sidebars = eldon_core_get_custom_sidebars();
			$footer_columns  = apply_filters( 'eldon_core_filter_footer_areas_columns_size', array() );

			$footer_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-footer',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Footer Settings', 'eldon-core' ),
					'description' => esc_html__( 'Footer layout settings', 'eldon-core' ),
				)
			);

			$footer_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_page_footer',
					'title'       => esc_html__( 'Enable Page Footer', 'eldon-core' ),
					'description' => esc_html__( 'Use this option to enable/disable page footer', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$footer_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_footer_borders_enabled',
					'title'       => esc_html__( 'Footer Borders', 'eldon-core' ),
					'description' => esc_html__( 'Enable footer borders', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
					'dependency'  => array(
						'show' => array(
							'qodef_enable_page_footer' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$footer_tab->add_field_element(
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

			$page_footer_section = $footer_tab->add_section_element(
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
					'field_type'  => 'select',
					'name'        => 'qodef_enable_uncovering_footer',
					'title'       => esc_html__( 'Enable Uncovering Footer', 'eldon-core' ),
					'description' => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			// Top Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_top_footer_area',
					'title'       => esc_html__( 'Enable Top Footer Area', 'eldon-core' ),
					'description' => esc_html__( 'Use this option to enable/disable top footer area', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
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
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_in_grid',
					'title'       => esc_html__( 'Top Footer Area in Grid', 'eldon-core' ),
					'description' => esc_html__( 'Enabling this option will set page top footer area to be in grid', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_extended_grid',
					'title'       => esc_html__( 'Extend The Grid To Left', 'eldon-core' ),
					'description' => esc_html__( 'Enabling this option will extend page top footer grid area to the left', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
					'dependency'  => array(
						'hide' => array(
							'qodef_set_footer_top_area_in_grid' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			if ( isset( $footer_columns['footer_top_sidebars_number'] ) && ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				for ( $i = 1; $i <= intval( $footer_columns['footer_top_sidebars_number'] ); $i ++ ) {
					$top_footer_area_section->add_field_element(
						array(
							'field_type'  => 'select',
							'name'        => 'qodef_footer_top_area_custom_widget_' . $i,
							'title'       => sprintf( esc_html__( 'Custom Footer Top Area - Column %s', 'eldon-core' ), $i ),
							'description' => sprintf( esc_html__( 'Widgets added here will appear in the %s column of top footer area', 'eldon-core' ), $i ),
							'options'     => $custom_sidebars,
						)
					);
				}
			}

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
						'show' => array(
							'qodef_set_footer_top_area_extended_grid' => array(
								'values'        => 'no',
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
					'field_type'  => 'select',
					'name'        => 'qodef_enable_bottom_footer_area',
					'title'       => esc_html__( 'Enable Bottom Footer Area', 'eldon-core' ),
					'description' => esc_html__( 'Use this option to enable/disable bottom footer area', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
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
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_in_grid',
					'title'       => esc_html__( 'Bottom Footer Area in Grid', 'eldon-core' ),
					'description' => esc_html__( 'Enabling this option will set page bottom footer area to be in grid', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			if ( isset( $footer_columns['footer_bottom_sidebars_number'] ) && ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				for ( $i = 1; $i <= intval( $footer_columns['footer_bottom_sidebars_number'] ); $i ++ ) {
					$bottom_footer_area_section->add_field_element(
						array(
							'field_type'  => 'select',
							'name'        => 'qodef_footer_bottom_area_custom_widget_' . $i,
							'title'       => sprintf( esc_html__( 'Custom Footer Bottom Area - Column %s', 'eldon-core' ), $i ),
							'description' => sprintf( esc_html__( 'Widgets added here will appear in the %s column of bottom footer area', 'eldon-core' ), $i ),
							'options'     => $custom_sidebars,
						)
					);
				}
			}

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
			do_action( 'eldon_core_action_after_page_footer_meta_box_map', $footer_tab );
		}
	}

	add_action( 'eldon_core_action_after_general_meta_box_map', 'eldon_core_add_page_footer_meta_box' );
}
