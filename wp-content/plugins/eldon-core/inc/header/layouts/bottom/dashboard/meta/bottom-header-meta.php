<?php

if ( ! function_exists( 'eldon_core_add_bottom_header_meta' ) ) {
	function eldon_core_add_bottom_header_meta( $page ) {
		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_bottom_header_section',
				'title'      => esc_html__( 'Bottom Header', 'eldon-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'bottom',
							'default_value' => '',
						),
					),
				),
			)
		);

		if ( qode_framework_is_installed( 'revolution-slider' ) ) {
			$section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_bottom_header_slider',
					'title'         => esc_html__( 'Slider Before Header', 'eldon-core' ),
					'description'   => esc_html__( 'Choose Revolution Slider that will appear before header', 'eldon-core' ),
					'default_value' => '',
					'options'       => eldon_core_get_select_type_options_pool( 'rev_sliders' ),
				)
			);
		}

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_bottom_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'eldon-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'eldon-core' ),
				'default_value' => '',
				'options'       => eldon_core_get_select_type_options_pool( 'no_yes' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_bottom_header_height',
				'title'       => esc_html__( 'Header Height', 'eldon-core' ),
				'description' => esc_html__( 'Enter header height', 'eldon-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'eldon-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_bottom_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'eldon-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'eldon-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'eldon-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_bottom_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'eldon-core' ),
				'description' => esc_html__( 'Enter header background color', 'eldon-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_bottom_header_menu_position',
				'title'         => esc_html__( 'Menu position', 'eldon-core' ),
				'default_value' => '',
				'options'       => array(
					''       => esc_html__( 'Default', 'eldon-core' ),
					'left'   => esc_html__( 'Left', 'eldon-core' ),
					'center' => esc_html__( 'Center', 'eldon-core' ),
					'right'  => esc_html__( 'Right', 'eldon-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'name'          => 'qodef_bottom_header_border',
				'title'         => esc_html__( 'Header Bottom Border', 'eldon-core' ),
				'description'   => esc_html__( 'Enable header bottom border', 'eldon-core' ),
				'default_value' => 'no',
			)
		);
	}

	add_action( 'eldon_core_action_after_page_header_meta_map', 'eldon_core_add_bottom_header_meta' );
}
