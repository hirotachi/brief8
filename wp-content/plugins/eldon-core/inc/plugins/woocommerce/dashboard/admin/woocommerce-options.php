<?php

if ( ! function_exists( 'eldon_core_add_woocommerce_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function eldon_core_add_woocommerce_options() {
		$qode_framework = qode_framework_get_framework_root();

		$list_item_layouts = apply_filters( 'eldon_core_filter_product_list_layouts', array() );
		$options_map       = eldon_core_get_variations_options_map( $list_item_layouts );

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => ELDON_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'woocommerce',
				'icon'        => 'fa fa-book',
				'title'       => esc_html__( 'WooCommerce', 'eldon-core' ),
				'description' => esc_html__( 'Global WooCommerce Options', 'eldon-core' ),
				'layout'      => 'tabbed',
			)
		);

		if ( $page ) {

			$list_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-list',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Product List', 'eldon-core' ),
					'description' => esc_html__( 'Settings related to product list', 'eldon-core' ),
				)
			);

			if ( $options_map['visibility'] ) {
				$list_tab->add_field_element(
					array(
						'field_type'    => 'select',
						'name'          => 'qodef_product_list_item_layout',
						'title'         => esc_html__( 'Item Layout', 'eldon-core' ),
						'description'   => esc_html__( 'Choose layout for list item on shop lists', 'eldon-core' ),
						'options'       => $list_item_layouts,
						'default_value' => $options_map['default_value'],
					)
				);
			}

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_columns',
					'title'       => esc_html__( 'Number of Columns', 'eldon-core' ),
					'description' => esc_html__( 'Choose number of columns for product list on shop pages', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_columns_space',
					'title'       => esc_html__( 'Space Between Items', 'eldon-core' ),
					'description' => esc_html__( 'Choose space between items for product list on shop pages', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_products_per_page',
					'title'       => esc_html__( 'Products per Page', 'eldon-core' ),
					'description' => esc_html__( 'Set number of products on shop pages. Default value is 12', 'eldon-core' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_title_tag',
					'title'       => esc_html__( 'Title Tag', 'eldon-core' ),
					'description' => esc_html__( 'Choose title tag for product list item on shop pages', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'title_tag' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_product_list_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'eldon-core' ),
					'description'   => esc_html__( 'Choose default sidebar layout for shop pages', 'eldon-core' ),
					'default_value' => 'no-sidebar',
					'options'       => eldon_core_get_select_type_options_pool( 'sidebar_layouts', false ),
				)
			);

			$custom_sidebars = eldon_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$list_tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_woo_product_list_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'eldon-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on shop pages', 'eldon-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'eldon-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'default_value' => 'no',
					'name'          => 'qodef_woo_enable_percent_sign_value',
					'title'         => esc_html__( 'Enable Percent Sign', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will show percent value mark instead of sale label on products', 'eldon-core' ),
				)
			);

			// Hook to include additional options after section module options
			do_action( 'eldon_core_action_after_woo_product_list_options_map', $list_tab );

			$single_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-single',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Product Single', 'eldon-core' ),
					'description' => esc_html__( 'Settings related to product single', 'eldon-core' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_enable_page_title',
					'title'       => esc_html__( 'Enable Page Title', 'eldon-core' ),
					'description' => esc_html__( 'Use this option to enable/disable page title on single product page', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_title_tag',
					'title'       => esc_html__( 'Title Tag', 'eldon-core' ),
					'description' => esc_html__( 'Choose title tag for product on single product page', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'title_tag' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_single_enable_image_lightbox',
					'title'         => esc_html__( 'Enable Image Lightbox', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will set lightbox functionality for images on single product page', 'eldon-core' ),
					'options'       => array(
						''               => esc_html__( 'None', 'eldon-core' ),
						'photo-swipe'    => esc_html__( 'Photo Swipe', 'eldon-core' ),
						'magnific-popup' => esc_html__( 'Magnific Popup', 'eldon-core' ),
					),
					'default_value' => 'magnific-popup',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_woo_single_enable_image_zoom',
					'title'         => esc_html__( 'Enable Zoom Magnifier', 'eldon-core' ),
					'description'   => esc_html__( 'Enabling this option will show magnifier image on hover on single product page', 'eldon-core' ),
					'default_value' => 'yes',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_single_thumb_images_position',
					'title'         => esc_html__( 'Set Thumbnail Images Position', 'eldon-core' ),
					'description'   => esc_html__( 'Choose position of the thumbnail images on single product page relative to featured image', 'eldon-core' ),
					'options'       => array(
						'below' => esc_html__( 'Below', 'eldon-core' ),
						'left'  => esc_html__( 'Left', 'eldon-core' ),
					),
					'default_value' => 'left',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_thumbnail_images_columns',
					'title'       => esc_html__( 'Number of Thumbnail Image Columns', 'eldon-core' ),
					'description' => esc_html__( 'Set a number of columns for thumbnail images on single product pages', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_related_product_list_columns',
					'title'       => esc_html__( 'Number of Related Product Columns', 'eldon-core' ),
					'description' => esc_html__( 'Set a number of columns for related products on single product pages', 'eldon-core' ),
					'options'     => eldon_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			// Hook to include additional options after section module options
			do_action( 'eldon_core_action_after_woo_product_single_options_map', $single_tab );

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_woo_options_map', $page );
		}
	}

	add_action( 'eldon_core_action_default_options_init', 'eldon_core_add_woocommerce_options', eldon_core_get_admin_options_map_position( 'woocommerce' ) );
}
