<?php

if ( ! function_exists( 'eldon_core_add_team_list_variation_info_above' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_team_list_variation_info_above( $variations ) {
		$variations['info-above'] = esc_html__( 'Info Above', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_team_list_layouts', 'eldon_core_add_team_list_variation_info_above' );
}

if ( ! function_exists( 'eldon_core_add_team_list_options_info_above' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function eldon_core_add_team_list_options_info_above( $options ) {
		$info_above_options   = array();
		$margin_option        = array(
			'field_type' => 'text',
			'name'       => 'info_above_content_margin_bottom',
			'title'      => esc_html__( 'Content Bottom Margin', 'eldon-core' ),
			'dependency' => array(
				'show' => array(
					'layout' => array(
						'values'        => 'info-above',
						'default_value' => 'default',
					),
				),
			),
			'group'      => esc_html__( 'Layout', 'eldon-core' ),
		);
		$info_above_options[] = $margin_option;

		return array_merge( $options, $info_above_options );
	}

	add_filter( 'eldon_core_filter_team_list_extra_options', 'eldon_core_add_team_list_options_info_above' );
}
