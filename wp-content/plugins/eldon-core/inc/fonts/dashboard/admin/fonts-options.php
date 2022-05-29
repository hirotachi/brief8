<?php

if ( ! function_exists( 'eldon_core_add_fonts_options' ) ) {
	/**
	 * Function that add options for this module
	 */
	function eldon_core_add_fonts_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => ELDON_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fonts',
				'title'       => esc_html__( 'Fonts', 'eldon-core' ),
				'description' => esc_html__( 'Global Fonts Options', 'eldon-core' ),
				'icon'        => 'fa fa-cog',
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_google_fonts',
					'title'         => esc_html__( 'Enable Google Fonts', 'eldon-core' ),
					'default_value' => 'yes',
					'args'          => array(
						'custom_class' => 'qodef-enable-google-fonts',
					),
				)
			);

			$google_fonts_section = $page->add_section_element(
				array(
					'name'       => 'qodef_google_fonts_section',
					'title'      => esc_html__( 'Google Fonts Options', 'eldon-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_google_fonts' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_repeater = $google_fonts_section->add_repeater_element(
				array(
					'name'        => 'qodef_choose_google_fonts',
					'title'       => esc_html__( 'Google Fonts to Include', 'eldon-core' ),
					'description' => esc_html__( 'Choose Google Fonts which you want to use on your website', 'eldon-core' ),
					'button_text' => esc_html__( 'Add New Google Font', 'eldon-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type'  => 'googlefont',
					'name'        => 'qodef_choose_google_font',
					'title'       => esc_html__( 'Google Font', 'eldon-core' ),
					'description' => esc_html__( 'Choose Google Font', 'eldon-core' ),
					'args'        => array(
						'include' => 'google-fonts',
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_weight',
					'title'       => esc_html__( 'Google Fonts Weight', 'eldon-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts weights for your website. Impact on page load time', 'eldon-core' ),
					'options'     => array(
						'100'  => esc_html__( '100 Thin', 'eldon-core' ),
						'100i' => esc_html__( '100 Thin Italic', 'eldon-core' ),
						'200'  => esc_html__( '200 Extra-Light', 'eldon-core' ),
						'200i' => esc_html__( '200 Extra-Light Italic', 'eldon-core' ),
						'300'  => esc_html__( '300 Light', 'eldon-core' ),
						'300i' => esc_html__( '300 Light Italic', 'eldon-core' ),
						'400'  => esc_html__( '400 Regular', 'eldon-core' ),
						'400i' => esc_html__( '400 Regular Italic', 'eldon-core' ),
						'500'  => esc_html__( '500 Medium', 'eldon-core' ),
						'500i' => esc_html__( '500 Medium Italic', 'eldon-core' ),
						'600'  => esc_html__( '600 Semi-Bold', 'eldon-core' ),
						'600i' => esc_html__( '600 Semi-Bold Italic', 'eldon-core' ),
						'700'  => esc_html__( '700 Bold', 'eldon-core' ),
						'700i' => esc_html__( '700 Bold Italic', 'eldon-core' ),
						'800'  => esc_html__( '800 Extra-Bold', 'eldon-core' ),
						'800i' => esc_html__( '800 Extra-Bold Italic', 'eldon-core' ),
						'900'  => esc_html__( '900 Ultra-Bold', 'eldon-core' ),
						'900i' => esc_html__( '900 Ultra-Bold Italic', 'eldon-core' ),
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_subset',
					'title'       => esc_html__( 'Google Fonts Style', 'eldon-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts style for your website. Impact on page load time', 'eldon-core' ),
					'options'     => array(
						'latin'        => esc_html__( 'Latin', 'eldon-core' ),
						'latin-ext'    => esc_html__( 'Latin Extended', 'eldon-core' ),
						'cyrillic'     => esc_html__( 'Cyrillic', 'eldon-core' ),
						'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'eldon-core' ),
						'greek'        => esc_html__( 'Greek', 'eldon-core' ),
						'greek-ext'    => esc_html__( 'Greek Extended', 'eldon-core' ),
						'vietnamese'   => esc_html__( 'Vietnamese', 'eldon-core' ),
					),
				)
			);

			$page_repeater = $page->add_repeater_element(
				array(
					'name'        => 'qodef_custom_fonts',
					'title'       => esc_html__( 'Custom Fonts', 'eldon-core' ),
					'description' => esc_html__( 'Add custom fonts', 'eldon-core' ),
					'button_text' => esc_html__( 'Add New Custom Font', 'eldon-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_ttf',
					'title'      => esc_html__( 'Custom Font TTF', 'eldon-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_otf',
					'title'      => esc_html__( 'Custom Font OTF', 'eldon-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff',
					'title'      => esc_html__( 'Custom Font WOFF', 'eldon-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff2',
					'title'      => esc_html__( 'Custom Font WOFF2', 'eldon-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_custom_font_name',
					'title'      => esc_html__( 'Custom Font Name', 'eldon-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_page_fonts_options_map', $page );
		}
	}

	add_action( 'eldon_core_action_default_options_init', 'eldon_core_add_fonts_options', eldon_core_get_admin_options_map_position( 'fonts' ) );
}
