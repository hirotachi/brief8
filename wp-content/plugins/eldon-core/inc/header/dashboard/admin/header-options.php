<?php

if ( ! function_exists( 'eldon_core_add_header_options' ) ) {
	/**
	 * Function that add header options for this module
	 */
	function eldon_core_add_header_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => ELDON_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'layout'      => 'tabbed',
				'slug'        => 'header',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Header', 'eldon-core' ),
				'description' => esc_html__( 'Global Header Options', 'eldon-core' ),
			)
		);

		if ( $page ) {
			$general_tab = $page->add_tab_element(
				array(
					'name'  => 'tab-header-general',
					'icon'  => 'fa fa-cog',
					'title' => esc_html__( 'General Settings', 'eldon-core' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'radio',
					'name'          => 'qodef_header_layout',
					'title'         => esc_html__( 'Header Layout', 'eldon-core' ),
					'description'   => esc_html__( 'Choose a header layout to set for your website', 'eldon-core' ),
					'args'          => array( 'images' => true ),
					'options'       => apply_filters( 'eldon_core_filter_header_layout_option', array() ),
					'default_value' => apply_filters( 'eldon_core_filter_header_layout_default_option_value', '' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_header_skin',
					'title'       => esc_html__( 'Header Skin', 'eldon-core' ),
					'description' => esc_html__( 'Choose a predefined header style for header elements', 'eldon-core' ),
					'options'     => array(
						'none'  => esc_html__( 'None', 'eldon-core' ),
						'light' => esc_html__( 'Light', 'eldon-core' ),
						'dark'  => esc_html__( 'Dark', 'eldon-core' ),
					),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'default_value' => 'yes',
					'name'          => 'qodef_header_outer_borders_enabled',
					'title'         => esc_html__( 'Outer Header Borders', 'eldon-core' ),
					'description'   => esc_html__( 'Enable Outer header borders', 'eldon-core' ),
					'dependency'    => array(
						'show' => array(
							'qodef_header_layout' => array(
								'values'        => array( 'standard', 'bottom' ),
								'default_value' => '',
							),
						),
					),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'default_value' => 'no',
					'name'          => 'qodef_header_borders_enabled',
					'title'         => esc_html__( 'Inner Header Borders', 'eldon-core' ),
					'description'   => esc_html__( 'Enable Inner header borders', 'eldon-core' ),
					'dependency'    => array(
						'show' => array(
							'qodef_header_layout' => array(
								'values'        => array( 'standard', 'bottom' ),
								'default_value' => '',
							),
						),
					),
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_header_options_map', $page, $general_tab );
		}
	}

	add_action( 'eldon_core_action_default_options_init', 'eldon_core_add_header_options', eldon_core_get_admin_options_map_position( 'header' ) );
}
