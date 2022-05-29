<?php

if ( ! function_exists( 'eldon_core_is_page_footer_enabled' ) ) {
	/**
	 * Function that check is module enabled
	 *
	 * @param bool $is_enabled
	 *
	 * @return bool
	 */
	function eldon_core_is_page_footer_enabled( $is_enabled ) {
		$option = 'no' !== eldon_core_get_post_value_through_levels( 'qodef_enable_page_footer' );

		if ( ! $option ) {
			$is_enabled = false;
		}

		return $is_enabled;
	}

	add_filter( 'eldon_filter_enable_page_footer', 'eldon_core_is_page_footer_enabled' );
}

if ( ! function_exists( 'eldon_core_set_footer_holder_classes' ) ) {
	/**
	 * Function that return classes for page footer area
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function eldon_core_set_footer_holder_classes( $classes ) {

		if ( 'yes' === eldon_core_get_post_value_through_levels( 'qodef_enable_uncovering_footer' ) ) {
			$classes[] = 'qodef--uncover';
		}

		return $classes;
	}

	add_filter( 'eldon_filter_footer_holder_classes', 'eldon_core_set_footer_holder_classes' );
}

if ( ! function_exists( 'eldon_core_is_footer_top_area_enabled' ) ) {
	/**
	 * Function that check if page footer top area widgets are empty
	 *
	 * @param bool $is_enabled
	 *
	 * @return bool
	 */
	function eldon_core_is_footer_top_area_enabled( $is_enabled ) {
		$option = 'no' !== eldon_core_get_post_value_through_levels( 'qodef_enable_top_footer_area' );

		if ( ! $option ) {
			$is_enabled = false;
		}

		return $is_enabled;
	}

	add_filter( 'eldon_filter_enable_footer_top_area', 'eldon_core_is_footer_top_area_enabled' );
}

if ( ! function_exists( 'eldon_core_is_footer_bottom_area_enabled' ) ) {
	/**
	 * Function that check if page footer bottom area widgets are empty
	 *
	 * @param bool $is_enabled
	 *
	 * @return bool
	 */
	function eldon_core_is_footer_bottom_area_enabled( $is_enabled ) {
		$option = 'no' !== eldon_core_get_post_value_through_levels( 'qodef_enable_bottom_footer_area' );

		if ( ! $option ) {
			$is_enabled = false;
		}

		return $is_enabled;
	}

	add_filter( 'eldon_filter_enable_footer_bottom_area', 'eldon_core_is_footer_bottom_area_enabled' );
}

if ( ! function_exists( 'eldon_core_set_footer_top_area_classes' ) ) {
	/**
	 * Function that return classes for page footer top area
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	function eldon_core_set_footer_top_area_classes( $classes ) {
		$is_grid_enabled = 'no' !== eldon_core_get_post_value_through_levels( 'qodef_set_footer_top_area_in_grid' );

		if ( ! $is_grid_enabled ) {
			$classes = 'qodef-content-full-width';
		}

		$is_grid_extended = 'yes' === eldon_core_get_post_value_through_levels( 'qodef_set_footer_top_area_extended_grid' );

		if ( $is_grid_extended ) {
			$classes .= ' qodef-extended-grid--left';
		}

		return $classes;
	}

	add_filter( 'eldon_filter_footer_top_area_classes', 'eldon_core_set_footer_top_area_classes' );
}

if ( ! function_exists( 'eldon_core_set_footer_bottom_area_classes' ) ) {
	/**
	 * Function that return classes for page footer bottom area
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	function eldon_core_set_footer_bottom_area_classes( $classes ) {
		$is_grid_enabled = 'no' !== eldon_core_get_post_value_through_levels( 'qodef_set_footer_bottom_area_in_grid' );

		if ( ! $is_grid_enabled ) {
			$classes = 'qodef-content-full-width';
		}

		return $classes;
	}

	add_filter( 'eldon_filter_footer_bottom_area_classes', 'eldon_core_set_footer_bottom_area_classes' );
}

if ( ! function_exists( 'eldon_core_set_footer_sidebars_config' ) ) {
	/**
	 * Function that override default page footer sidebars config
	 *
	 * @param array $config
	 *
	 * @return array
	 */
	function eldon_core_set_footer_sidebars_config( $config ) {
		$top_area_columns    = eldon_core_get_post_value_through_levels( 'qodef_set_footer_top_area_columns' );
		$bottom_area_columns = eldon_core_get_post_value_through_levels( 'qodef_set_footer_bottom_area_columns' );

		if ( ! empty( $top_area_columns ) ) {
			$config['footer_top_sidebars_number'] = $top_area_columns;
		}

		if ( ! empty( $bottom_area_columns ) ) {
			$config['footer_bottom_sidebars_number'] = $bottom_area_columns;
		}

		return $config;
	}

	add_filter( 'eldon_filter_page_footer_sidebars_config', 'eldon_core_set_footer_sidebars_config' );
	add_filter( 'eldon_core_filter_footer_areas_columns_size', 'eldon_core_set_footer_sidebars_config' );
}

if ( ! function_exists( 'eldon_core_set_footer_top_area_columns_classes' ) ) {
	/**
	 * Function that set classes for page footer top area columns
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function eldon_core_set_footer_top_area_columns_classes( $classes ) {
		$gutter_size        = eldon_core_get_post_value_through_levels( 'qodef_set_footer_top_area_grid_gutter' );
		$alignment          = eldon_core_get_post_value_through_levels( 'qodef_set_footer_top_area_content_alignment' );
		$columns_proportion = eldon_core_get_post_value_through_levels( 'qodef_set_footer_top_four_columns_proportion' );

		if ( ! empty( $gutter_size ) ) {
			$classes[] = 'qodef-gutter--' . esc_attr( $gutter_size );
		}

		if ( ! empty( $alignment ) ) {
			$classes[] = 'qodef-alignment--' . esc_attr( $alignment );
		}

		if ( ! empty( $columns_proportion ) ) {
			$classes[] = 'qodef-proportion--' . esc_attr( $columns_proportion );
		}

		return $classes;
	}

	add_filter( 'eldon_filter_footer_top_area_columns_classes', 'eldon_core_set_footer_top_area_columns_classes' );
}

if ( ! function_exists( 'eldon_core_set_footer_bottom_area_columns_classes' ) ) {
	/**
	 * Function that set classes for page footer bottom area columns
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function eldon_core_set_footer_bottom_area_columns_classes( $classes ) {
		$gutter_size = eldon_core_get_post_value_through_levels( 'qodef_set_footer_bottom_area_grid_gutter' );
		$alignment   = eldon_core_get_post_value_through_levels( 'qodef_set_footer_bottom_area_content_alignment' );

		if ( ! empty( $gutter_size ) ) {
			$classes[] = 'qodef-gutter--' . esc_attr( $gutter_size );
		}

		if ( ! empty( $alignment ) ) {
			$classes[] = 'qodef-alignment--' . esc_attr( $alignment );
		}

		return $classes;
	}

	add_filter( 'eldon_filter_footer_bottom_area_columns_classes', 'eldon_core_set_footer_bottom_area_columns_classes' );
}

if ( ! function_exists( 'eldon_core_set_custom_footer_widget_area' ) ) {
	/**
	 * This function set custom footer widgets area
	 *
	 * @param string $widget_id
	 * @param string $widget_area
	 * @param string $column
	 *
	 * @return string
	 */
	function eldon_core_set_custom_footer_widget_area( $widget_id, $widget_area, $column ) {
		$page_id            = qode_framework_get_page_id();
		$custom_widget_id   = 'qodef_footer_' . esc_attr( $widget_area ) . '_area_custom_widget_' . esc_attr( $column );
		$custom_widget_area = get_post_meta( $page_id, $custom_widget_id, true );

		if ( ! empty( $custom_widget_area ) ) {
			return $custom_widget_area;
		}

		return $widget_id;
	}

	add_filter( 'eldon_filter_footer_widget_area', 'eldon_core_set_custom_footer_widget_area', 10, 3 );
}

if ( ! function_exists( 'eldon_core_set_page_footer_area_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function eldon_core_set_page_footer_area_styles( $style ) {
		$footer_area = array( 'top', 'bottom' );

		foreach ( $footer_area as $area ) {
			$footer_styles    = array();
			$styles           = array();
			$borders_enabled  = 'no' !== eldon_core_get_post_value_through_levels( 'qodef_footer_borders_enabled' );
			$background_color = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_background_color' );
			$background_image = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_background_image' );

			if ( ! $borders_enabled ) {
				$footer_styles['border'] = 'none';
			}

			if ( ! empty( $footer_styles ) ) {
				$style .= qode_framework_dynamic_style( '#qodef-page-footer', $footer_styles );
			}

			if ( ! empty( $background_color ) ) {
				$styles['background-color'] = $background_color;
			}

			if ( ! empty( $background_image ) ) {
				$styles['background-image'] = 'url(' . esc_url( wp_get_attachment_image_url( $background_image, 'full' ) ) . ')';
			}

			if ( ! empty( $styles ) ) {
				$style .= qode_framework_dynamic_style( '#qodef-page-footer-' . $area . '-area', $styles );
			}

			$inner_styles = array();

			$columns_size   = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_columns_size' );
			$padding_top    = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_padding_top' );
			$padding_bottom = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_padding_bottom' );
			$side_padding   = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_side_padding' );

			if ( ! empty( $columns_size ) ) {
				if ( qode_framework_string_ends_with_space_units( $columns_size ) ) {
					$inner_styles['max-width'] = $columns_size;
				} else {
					$inner_styles['max-width'] = intval( $columns_size ) . 'px';
				}
			}

			if ( '' !== $padding_top ) {
				if ( qode_framework_string_ends_with_space_units( $padding_top, true ) ) {
					$inner_styles['padding-top'] = $padding_top;
				} else {
					$inner_styles['padding-top'] = intval( $padding_top ) . 'px';
				}
			}

			if ( '' !== $padding_bottom ) {
				if ( qode_framework_string_ends_with_space_units( $padding_bottom, true ) ) {
					$inner_styles['padding-bottom'] = $padding_bottom;
				} else {
					$inner_styles['padding-bottom'] = intval( $padding_bottom ) . 'px';
				}
			}

			if ( '' !== $side_padding ) {
				if ( qode_framework_string_ends_with_space_units( $side_padding, true ) ) {
					$inner_styles['padding-left']  = $side_padding . '!important';
					$inner_styles['padding-right'] = $side_padding . '!important';
				} else {
					$inner_styles['padding-left']  = intval( $side_padding ) . 'px !important';
					$inner_styles['padding-right'] = intval( $side_padding ) . 'px !important';
				}
			}

			if ( ! empty( $inner_styles ) ) {
				$style .= qode_framework_dynamic_style( '#qodef-page-footer-' . $area . '-area #qodef-page-footer-' . $area . '-area-inner', $inner_styles );
			}

			$widgets_styles = array();
			$margin_bottom  = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_widgets_margin_bottom' );

			if ( ! empty( $margin_bottom ) ) {
				if ( qode_framework_string_ends_with_space_units( $margin_bottom, true ) ) {
					$widgets_styles['margin-bottom'] = $margin_bottom;
				} else {
					$widgets_styles['margin-bottom'] = intval( $margin_bottom ) . 'px';
				}
			}

			if ( ! empty( $widgets_styles ) ) {
				$style .= qode_framework_dynamic_style( '#qodef-page-footer-' . $area . '-area .widget', $widgets_styles );
			}

			$widgets_title_styles = array();
			$title_margin_bottom  = eldon_core_get_post_value_through_levels( 'qodef_' . $area . '_footer_area_widgets_title_margin_bottom' );

			if ( ! empty( $title_margin_bottom ) ) {
				if ( qode_framework_string_ends_with_space_units( $title_margin_bottom, true ) ) {
					$widgets_title_styles['margin-bottom'] = $title_margin_bottom;
				} else {
					$widgets_title_styles['margin-bottom'] = intval( $title_margin_bottom ) . 'px';
				}
			}

			if ( ! empty( $widgets_title_styles ) ) {
				$style .= qode_framework_dynamic_style( '#qodef-page-footer-' . $area . '-area .widget .qodef-widget-title', $widgets_title_styles );
			}

			$offset_responsive_styles = array();
			$offset_responsive        = eldon_core_get_post_value_through_levels( 'qodef_footer_offset_responsive' );

			if ( ! empty( $offset_responsive ) ) {
				if ( qode_framework_string_ends_with_space_units( $offset_responsive ) ) {
					$offset_responsive_styles['margin'] = '0 ' . $offset_responsive . ' ' . $offset_responsive;
					$offset_responsive_styles['width']  = 'calc(100% - 2 * ' . $offset_responsive . ')';

				} else {
					$offset_responsive_styles['margin'] = '0 ' . intval( $offset_responsive ) . 'px ' . intval( $offset_responsive ) . 'px';
					$offset_responsive_styles['width']  = 'calc(100% - 2 * ' . intval( $offset_responsive ) . 'px)';

				}
			}

			if ( ! empty( $offset_responsive_styles ) ) {
				$style .= qode_framework_dynamic_style_responsive( '#qodef-page-footer', $offset_responsive_styles, '', '1024' );
			}
		}

		return $style;
	}

	add_filter( 'eldon_filter_add_inline_style', 'eldon_core_set_page_footer_area_styles' );
}
