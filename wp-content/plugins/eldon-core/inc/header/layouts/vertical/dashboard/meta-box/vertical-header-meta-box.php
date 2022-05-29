<?php

if ( ! function_exists( 'eldon_core_add_vertical_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function eldon_core_add_vertical_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_vertical_header_section',
				'title'      => esc_html__( 'Vertical Header', 'eldon-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'vertical',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_vertical_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'eldon-core' ),
				'description' => esc_html__( 'Enter header background color', 'eldon-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'name'          => 'qodef_disable_vertical_header_background_image',
				'title'         => esc_html__( 'Disable Header Background Image', 'eldon-core' ),
				'default_value' => 'no',
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'image',
				'name'        => 'qodef_vertical_header_background_image',
				'title'       => esc_html__( 'Header Background Image', 'eldon-core' ),
				'description' => esc_html__( 'Enter header background image', 'eldon-core' ),
				'dependency'  => array(
					'show' => array(
						'qodef_disable_vertical_header_background_image' => array(
							'values'        => 'no',
							'default_value' => 'no',
						),
					),
				),
			)
		);
	}

	add_action( 'eldon_core_action_after_page_header_meta_map', 'eldon_core_add_vertical_header_meta' );
}
