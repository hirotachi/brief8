<?php

if ( ! function_exists( 'eldon_core_add_portfolio_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function eldon_core_add_portfolio_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'  => array( 'portfolio-item' ),
				'type'   => 'meta',
				'slug'   => 'portfolio-item',
				'title'  => esc_html__( 'Portfolio Settings', 'eldon-core' ),
				'layout' => 'tabbed',
			)
		);

		if ( $page ) {

			$general_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-general',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'General Settings', 'eldon-core' ),
					'description' => esc_html__( 'General portfolio settings', 'eldon-core' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_portfolio_subtitle',
					'title'       => esc_html__( 'Portfolio Item Subtitle', 'eldon-core' ),
					'description' => esc_html__( 'Enter Subtitle for the portfolio item', 'eldon-core' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_portfolio_single_layout',
					'title'       => esc_html__( 'Single Layout', 'eldon-core' ),
					'description' => esc_html__( 'Choose default layout for portfolio single', 'eldon-core' ),
					'options'     => apply_filters( 'eldon_core_filter_portfolio_single_layout_options', array( '' => esc_html__( 'Default', 'eldon-core' ) ) ),
				)
			);

			$section_columns = $general_tab->add_section_element(
				array(
					'name'       => 'qodef_portfolio_columns_section',
					'dependency' => array(
						'show' => array(
							'qodef_portfolio_single_layout' => array(
								'values'        => array(
									'masonry-big',
									'masonry-small',
									'gallery-big',
									'gallery-small',
								),
								'default_value' => '',
							),
						),
					),
				)
			);

			$section_columns->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_portfolio_columns_number',
					'title'      => esc_html__( 'Number of Columns', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$section_columns->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_portfolio_space_between_items',
					'title'      => esc_html__( 'Space Between Items', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$section_media = $general_tab->add_section_element(
				array(
					'name'        => 'qodef_portfolio_media_section',
					'title'       => esc_html__( 'Media Settings', 'eldon-core' ),
					'description' => esc_html__( 'Media that will be displayed on portfolio page', 'eldon-core' ),
				)
			);

			$media_repeater = $section_media->add_repeater_element(
				array(
					'name'        => 'qodef_portfolio_media',
					'title'       => esc_html__( 'Media Items', 'eldon-core' ),
					'description' => esc_html__( 'Enter media items for this portfolio', 'eldon-core' ),
					'button_text' => esc_html__( 'Add Media', 'eldon-core' ),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_portfolio_media_type',
					'title'         => esc_html__( 'Media Item Type', 'eldon-core' ),
					'options'       => array(
						'gallery' => esc_html__( 'Gallery', 'eldon-core' ),
						'image'   => esc_html__( 'Image', 'eldon-core' ),
						'video'   => esc_html__( 'Video', 'eldon-core' ),
						'audio'   => esc_html__( 'Audio', 'eldon-core' ),
					),
					'default_value' => 'gallery',
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_portfolio_gallery',
					'title'      => esc_html__( 'Upload Portfolio Images', 'eldon-core' ),
					'multiple'   => 'yes',
					'dependency' => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'gallery',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_portfolio_image',
					'title'      => esc_html__( 'Upload Portfolio Image', 'eldon-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'image',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_portfolio_video',
					'title'       => esc_html__( 'Video URL', 'eldon-core' ),
					'description' => esc_html__( 'Enter your video URL', 'eldon-core' ),
					'dependency'  => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'video',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_portfolio_audio',
					'title'       => esc_html__( 'Audio URL', 'eldon-core' ),
					'description' => esc_html__( 'Enter your audio URL', 'eldon-core' ),
					'dependency'  => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'audio',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$section_info = $general_tab->add_section_element(
				array(
					'name'        => 'qodef_portfolio_info_section',
					'title'       => esc_html__( 'Info Settings', 'eldon-core' ),
					'description' => esc_html__( 'Info that will be displayed on portfolio page', 'eldon-core' ),
				)
			);

			$info_items_repeater = $section_info->add_repeater_element(
				array(
					'name'        => 'qodef_portfolio_info_items',
					'title'       => esc_html__( 'Info Items', 'eldon-core' ),
					'description' => esc_html__( 'Enter additional info for portoflio item', 'eldon-core' ),
					'button_text' => esc_html__( 'Add Item', 'eldon-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_info_item_label',
					'title'      => esc_html__( 'Item Label', 'eldon-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_info_item_value',
					'title'      => esc_html__( 'Item Text', 'eldon-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_info_item_link',
					'title'      => esc_html__( 'Item Link', 'eldon-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_info_item_target',
					'title'      => esc_html__( 'Item Target', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'link_target' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_portfolio_single_external_link',
					'title'       => esc_html__( 'Portfolio External Link', 'eldon-core' ),
					'description' => esc_html__( 'Enter URL to link from Portfolio List element', 'eldon-core' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_portfolio_single_external_link_target',
					'title'      => esc_html__( 'Portfolio External Link Target', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'link_target' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_portfolio_meta_box_map', $page, $general_tab );
		}
	}

	add_action( 'eldon_core_action_default_meta_boxes_init', 'eldon_core_add_portfolio_single_meta_box' );
}

if ( ! function_exists( 'eldon_core_include_general_meta_boxes_for_portfolio_single' ) ) {
	/**
	 * Function that add general meta box options for this module
	 */
	function eldon_core_include_general_meta_boxes_for_portfolio_single() {
		$callbacks = eldon_core_general_meta_box_callbacks();

		if ( ! empty( $callbacks ) ) {
			foreach ( $callbacks as $module => $callback ) {

				if ( 'page-sidebar' !== $module ) {
					add_action( 'eldon_core_action_after_portfolio_meta_box_map', $callback );
				}
			}
		}
	}

	add_action( 'eldon_core_action_default_meta_boxes_init', 'eldon_core_include_general_meta_boxes_for_portfolio_single', 8 ); // Permission 8 is set in order to load it before default meta box function
}
