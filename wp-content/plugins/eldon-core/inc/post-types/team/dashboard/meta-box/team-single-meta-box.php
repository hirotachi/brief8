<?php

if ( ! function_exists( 'eldon_core_add_team_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function eldon_core_add_team_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();
		$has_single     = eldon_core_team_has_single();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'team' ),
				'type'  => 'meta',
				'slug'  => 'team',
				'title' => esc_html__( 'Team Single', 'eldon-core' ),
			)
		);

		if ( $page ) {
			$section = $page->add_section_element(
				array(
					'name'        => 'qodef_team_general_section',
					'title'       => esc_html__( 'General Settings', 'eldon-core' ),
					'description' => esc_html__( 'General information about team member.', 'eldon-core' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_team_single_layout',
						'title'       => esc_html__( 'Single Layout', 'eldon-core' ),
						'description' => esc_html__( 'Choose default layout for team single', 'eldon-core' ),
						'options'     => array(
							'' => esc_html__( 'Default', 'eldon-core' ),
						),
					)
				);
			}

			$section->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_team_member_bio',
					'title'       => esc_html__( 'Short Bio', 'eldon-core' ),
					'description' => esc_html__( 'Enter short biographical information', 'eldon-core' ),
				)
			);

			$section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_team_member_role',
					'title'       => esc_html__( 'Role', 'eldon-core' ),
					'description' => esc_html__( 'Enter team member role', 'eldon-core' ),
				)
			);

			$section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_team_member_hover_image',
					'title'       => esc_html__( 'Hover Image', 'eldon-core' ),
					'description' => esc_html__( 'Upload image to be displayed on team list item hover', 'zermatt-core' ),
				)
			);

			$social_icons_repeater = $section->add_repeater_element(
				array(
					'name'        => 'qodef_team_member_social_icons',
					'title'       => esc_html__( 'Social Networks', 'eldon-core' ),
					'description' => esc_html__( 'Populate team member social networks info', 'eldon-core' ),
					'button_text' => esc_html__( 'Add New Network', 'eldon-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_team_member_icon_source',
					'title'      => esc_html__( 'Icon Source', 'fairwaygreen-core' ),
					'options'    => array(
						'textual'  => esc_html__( 'Textual', 'fairwaygreen-core' ),
						'iconpack' => esc_html__( 'Icon Pack', 'fairwaygreen-core' ),
					),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'iconpack',
					'name'       => 'qodef_team_member_icon',
					'title'      => esc_html__( 'Icon', 'fairwaygreen-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_team_member_icon_source' => array(
								'values'        => 'iconpack',
								'default_value' => 'textual',
							),
						),
					),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_team_member_icon_text',
					'title'      => esc_html__( 'Icon Text', 'fairwaygreen-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_team_member_icon_source' => array(
								'values'        => 'textual',
								'default_value' => 'textual',
							),
						),
					),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_team_member_icon_link',
					'title'      => esc_html__( 'Icon Link', 'eldon-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_team_member_icon_target',
					'title'      => esc_html__( 'Icon Target', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'link_target' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'date',
						'name'        => 'qodef_team_member_birth_date',
						'title'       => esc_html__( 'Birth Date', 'eldon-core' ),
						'description' => esc_html__( 'Enter team member birth date', 'eldon-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_email',
						'title'       => esc_html__( 'E-mail', 'eldon-core' ),
						'description' => esc_html__( 'Enter team member e-mail address', 'eldon-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_address',
						'title'       => esc_html__( 'Address', 'eldon-core' ),
						'description' => esc_html__( 'Enter team member address', 'eldon-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_education',
						'title'       => esc_html__( 'Education', 'eldon-core' ),
						'description' => esc_html__( 'Enter team member education', 'eldon-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'file',
						'name'        => 'qodef_team_member_resume',
						'title'       => esc_html__( 'Resume', 'eldon-core' ),
						'description' => esc_html__( 'Upload team member resume', 'eldon-core' ),
						'args'        => array(
							'allowed_type' => '[application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
						),
					)
				);
			}

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_team_meta_box_map', $page, $has_single );
		}
	}

	add_action( 'eldon_core_action_default_meta_boxes_init', 'eldon_core_add_team_single_meta_box' );
}
