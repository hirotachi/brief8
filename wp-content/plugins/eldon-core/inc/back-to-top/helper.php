<?php

if ( ! function_exists( 'eldon_core_is_back_to_top_enabled' ) ) {
	/**
	 * Function that check is module enabled
	 *
	 * @return bool
	 */
	function eldon_core_is_back_to_top_enabled() {
		return 'no' !== eldon_core_get_post_value_through_levels( 'qodef_back_to_top' );
	}
}

if ( ! function_exists( 'eldon_core_add_back_to_top_to_body_classes' ) ) {
	/**
	 * Function that add additional class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function eldon_core_add_back_to_top_to_body_classes( $classes ) {
		$classes[] = eldon_core_is_back_to_top_enabled() ? 'qodef-back-to-top--enabled' : '';

		return $classes;
	}

	add_filter( 'body_class', 'eldon_core_add_back_to_top_to_body_classes' );
}

if ( ! function_exists( 'eldon_core_load_back_to_top' ) ) {
	/**
	 * Loads Back To Top HTML
	 */
	function eldon_core_load_back_to_top() {

		if ( eldon_core_is_back_to_top_enabled() ) {
			$parameters = array();

			eldon_core_template_part( 'back-to-top', 'templates/back-to-top', '', $parameters );
		}
	}

	add_action( 'eldon_action_before_wrapper_close_tag', 'eldon_core_load_back_to_top' );
}

if ( ! function_exists( 'eldon_core_set_back_to_top_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function eldon_core_set_back_to_top_styles( $style ) {
		$styles = array();

		$color         = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_color' );
		$bg_color      = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_background_color' );
		$border_color  = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_border_color' );
		$border_width  = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_border_width' );
		$border_radius = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_border_radius' );
		$icon_size     = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_icon_size' );

		if ( ! empty( $color ) ) {
			$styles['color'] = $color;
		}

		if ( ! empty( $bg_color ) ) {
			$styles['background-color'] = $bg_color;
		}

		if ( ! empty( $border_color ) ) {
			$styles['border-color'] = $border_color;
		}

		if ( ! empty( $border_width ) ) {
			$styles['border-width'] = intval( $border_width ) . 'px';
		}

		if ( '' !== $border_radius ) {
			if ( qode_framework_string_ends_with_space_units( $border_radius, true ) ) {
				$styles['border-radius'] = $border_radius;
			} else {
				$styles['border-radius'] = intval( $border_radius ) . 'px';
			}
		}

		if ( ! empty( $icon_size ) ) {
			if ( qode_framework_string_ends_with_typography_units( $icon_size ) ) {
				$styles['font-size'] = $icon_size;
			} else {
				$styles['font-size'] = intval( $icon_size ) . 'px';
			}
		}

		if ( ! empty( $styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-back-to-top .qodef-back-to-top-icon',
				),
				$styles
			);
		}

		$hover_styles       = array();
		$hover_color        = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_hover_color' );
		$bg_hover_color     = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_background_hover_color' );
		$border_hover_color = eldon_core_get_post_value_through_levels( 'qodef_back_to_top_border_hover_color' );

		if ( ! empty( $hover_color ) ) {
			$hover_styles['color'] = $hover_color;
		}

		if ( ! empty( $bg_hover_color ) ) {
			$hover_styles['background-color'] = $bg_hover_color;
		}

		if ( ! empty( $border_hover_color ) ) {
			$hover_styles['border-color'] = $border_hover_color;
		}

		if ( ! empty( $hover_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-back-to-top:hover .qodef-back-to-top-icon',
				),
				$hover_styles
			);
		}

		$icon_styles = array();

		if ( ! empty( $icon_size ) ) {
			if ( qode_framework_string_ends_with_space_units( $icon_size, true ) ) {
				$icon_styles['width'] = $icon_size;
			} else {
				$icon_styles['width'] = intval( $icon_size ) . 'px';
			}
		}

		if ( ! empty( $icon_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-back-to-top .qodef-back-to-top-icon svg',
				),
				$icon_styles
			);
		}

		return $style;
	}

	add_filter( 'eldon_filter_add_inline_style', 'eldon_core_set_back_to_top_styles' );
}
