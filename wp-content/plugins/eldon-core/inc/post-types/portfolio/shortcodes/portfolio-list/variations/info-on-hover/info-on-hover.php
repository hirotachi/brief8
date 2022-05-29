<?php

if ( ! function_exists( 'eldon_core_add_portfolio_list_variation_info_on_hover' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_list_variation_info_on_hover( $variations ) {
		$variations['info-on-hover'] = esc_html__( 'Info On Hover', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_list_layouts', 'eldon_core_add_portfolio_list_variation_info_on_hover' );
}

if ( ! function_exists( 'eldon_core_add_portfolio_list_options_info_on_hover' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_list_options_info_on_hover( $options ) {
		$info_on_hover_options = array();
		$mouse_control_option  = array(
			'field_type' => 'select',
			'name'       => 'mouse_control',
			'title'      => esc_html__( 'Enable Mouse Control', 'eldon-core' ),
			'options'    => eldon_core_get_select_type_options_pool( 'yes_no', false ),
			'dependency' => array(
				'show' => array(
					'layout' => array(
						'values'        => 'info-on-hover',
						'default_value' => '',
					),
				),
			),
			'group'      => esc_html__( 'Layout', 'eldon-core' ),
		);
		$info_on_hover_options[] = $mouse_control_option;
		
		return array_merge( $options, $info_on_hover_options );
	}
	
	add_filter( 'eldon_core_filter_portfolio_list_extra_options', 'eldon_core_add_portfolio_list_options_info_on_hover' );
}
