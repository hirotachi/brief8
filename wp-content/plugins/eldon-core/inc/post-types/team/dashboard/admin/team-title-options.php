<?php

if ( ! function_exists( 'eldon_core_add_team_title_options' ) ) {
	/**
	 * Function that add title options for team module
	 */
	function eldon_core_add_team_title_options( $tab ) {

		if ( $tab ) {
			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_team_title',
					'title'       => esc_html__( 'Enable Title on Team Single', 'eldon-core' ),
					'description' => esc_html__( 'Use this option to enable/disable team single title', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'yes_no' ),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_team_title_area_in_grid',
					'title'       => esc_html__( 'Team Title in Grid', 'eldon-core' ),
					'description' => esc_html__( 'Enabling this option will set team title area to be in grid', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
		}
	}

	add_action( 'eldon_core_action_after_team_options_single', 'eldon_core_add_team_title_options' );
}
