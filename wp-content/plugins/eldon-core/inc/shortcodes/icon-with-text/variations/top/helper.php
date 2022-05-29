<?php

if ( ! function_exists( 'eldon_core_add_icon_with_text_variation_top' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_icon_with_text_variation_top( $variations ) {
		$variations['top'] = esc_html__( 'Top', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_icon_with_text_layouts', 'eldon_core_add_icon_with_text_variation_top' );
}

if ( ! function_exists( 'eldon_core_add_icon_with_text_options_text_align' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function eldon_core_add_icon_with_text_options_text_align( $options, $default_layout ) {
		$icon_with_text_options = array();

		$alignment_option = array(
			'field_type' => 'select',
			'name'       => 'content_alignment',
			'title'      => esc_html__( 'Content Alignment', 'eldon-core' ),
			'options'    => array(
				''       => esc_html__( 'Default', 'eldon-core' ),
				'left'   => esc_html__( 'Left', 'eldon-core' ),
				'center' => esc_html__( 'Center', 'eldon-core' ),
				'right'  => esc_html__( 'Right', 'eldon-core' ),
			),
			'dependency' => array(
				'show' => array(
					'layout' => array(
						'values'        => 'top',
						'default_value' => $default_layout,
					),
				),
			),
		);

		$icon_with_text_options[] = $alignment_option;

		return array_merge( $options, $icon_with_text_options );
	}

	add_filter( 'eldon_core_filter_icon_with_text_extra_options', 'eldon_core_add_icon_with_text_options_text_align', 10, 2 );
}

if ( ! function_exists( 'eldon_core_add_icon_with_text_classes_alignment' ) ) {
	/**
	 * Function that return additional holder classes for this module
	 *
	 * @param array $holder_classes
	 * @param array $atts
	 *
	 * @return array
	 */
	function eldon_core_add_icon_with_text_classes_alignment( $holder_classes, $atts ) {

		if ( 'top' === $atts['layout'] ) {
			$holder_classes[] = ! empty( $atts['content_alignment'] ) ? 'qodef-alignment--' . $atts['content_alignment'] : 'qodef-alignment--center';
		}

		return $holder_classes;
	}

	add_filter( 'eldon_core_filter_icon_with_text_variation_classes', 'eldon_core_add_icon_with_text_classes_alignment', 10, 2 );
}
