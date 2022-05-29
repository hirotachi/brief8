<?php

if ( ! function_exists( 'eldon_core_add_page_title_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function eldon_core_add_page_title_meta_box( $page ) {

		if ( $page ) {

			$title_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-title',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Title Settings', 'eldon-core' ),
					'description' => esc_html__( 'Title layout settings', 'eldon-core' ),
				)
			);

			$title_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_page_title',
					'title'       => esc_html__( 'Enable Page Title', 'eldon-core' ),
					'description' => esc_html__( 'Use this option to enable/disable page title', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$page_title_section = $title_tab->add_section_element(
				array(
					'name'       => 'qodef_page_title_section',
					'title'      => esc_html__( 'Title Area', 'eldon-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_page_title' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_title_layout',
					'title'       => esc_html__( 'Title Layout', 'eldon-core' ),
					'description' => esc_html__( 'Choose a title layout', 'eldon-core' ),
					'options'     => apply_filters( 'eldon_core_filter_title_layout_options', $layouts = array( '' => esc_html__( 'Default', 'eldon-core' ) ) ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_page_title_area_in_grid',
					'title'       => esc_html__( 'Page Title In Grid', 'eldon-core' ),
					'description' => esc_html__( 'Enabling this option will set page title area to be in grid', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_height',
					'title'       => esc_html__( 'Height', 'eldon-core' ),
					'description' => esc_html__( 'Enter title height', 'eldon-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'eldon-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_height_on_smaller_screens',
					'title'       => esc_html__( 'Height on Smaller Screens', 'eldon-core' ),
					'description' => esc_html__( 'Enter title height to be displayed on smaller screens with active mobile header', 'eldon-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'eldon-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_page_title_top_margin',
					'title'      => esc_html__( 'Title Top Margin', 'eldon-core' ),
					'args'       => array(
						'suffix' => esc_html__( 'px', 'eldon-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_page_title_bottom_margin',
					'title'      => esc_html__( 'Title Bottom Margin', 'eldon-core' ),
					'args'       => array(
						'suffix' => esc_html__( 'px', 'eldon-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_title_background_color',
					'title'       => esc_html__( 'Background Color', 'eldon-core' ),
					'description' => esc_html__( 'Enter page title area background color', 'eldon-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_page_title_background_image',
					'title'       => esc_html__( 'Background Image', 'eldon-core' ),
					'description' => esc_html__( 'Enter page title area background image', 'eldon-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_page_title_background_image_behavior',
					'title'      => esc_html__( 'Background Image Behavior', 'eldon-core' ),
					'options'    => array(
						''           => esc_html__( 'Default', 'eldon-core' ),
						'responsive' => esc_html__( 'Set Responsive Image', 'eldon-core' ),
						'parallax'   => esc_html__( 'Set Parallax Image', 'eldon-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_page_title_color',
					'title'      => esc_html__( 'Title Color', 'eldon-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_tag',
					'title'         => esc_html__( 'Title Tag', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will set title tag', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => '',
					'dependency'    => array(
						'show' => array(
							'qodef_title_layout' => array(
								'values'        => array( 'standard-with-breadcrumbs', 'standard' ),
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_text_alignment',
					'title'         => esc_html__( 'Text Alignment', 'eldon-core' ),
					'options'       => array(
						''       => esc_html__( 'Default', 'eldon-core' ),
						'left'   => esc_html__( 'Left', 'eldon-core' ),
						'center' => esc_html__( 'Center', 'eldon-core' ),
						'right'  => esc_html__( 'Right', 'eldon-core' ),
					),
					'default_value' => '',
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_vertical_text_alignment',
					'title'         => esc_html__( 'Vertical Text Alignment', 'eldon-core' ),
					'options'       => array(
						''              => esc_html__( 'Default', 'eldon-core' ),
						'header-bottom' => esc_html__( 'From Bottom of Header', 'eldon-core' ),
						'window-top'    => esc_html__( 'From Window Top', 'eldon-core' ),
					),
					'default_value' => '',
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_page_title_meta_box_map', $page_title_section );
		}
	}

	add_action( 'eldon_core_action_after_general_meta_box_map', 'eldon_core_add_page_title_meta_box' );
}

if ( ! function_exists( 'eldon_core_add_general_page_title_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function eldon_core_add_general_page_title_meta_box_callback( $callbacks ) {
		$callbacks['page-title'] = 'eldon_core_add_page_title_meta_box';

		return $callbacks;
	}

	add_filter( 'eldon_core_filter_general_meta_box_callbacks', 'eldon_core_add_general_page_title_meta_box_callback' );
}
