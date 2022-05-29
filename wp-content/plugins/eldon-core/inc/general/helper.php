<?php

if ( ! function_exists( 'eldon_core_get_content_width' ) ) {
	/**
	 * Function that return option value
	 *
	 * @return string
	 */
	function eldon_core_get_content_width() {
		return eldon_core_get_post_value_through_levels( 'qodef_content_width' );
	}
}

if ( ! function_exists( 'eldon_core_global_skin' ) ) {
	/**
	 * Function that check is option enabled
	 *
	 * @return bool
	 */
	function eldon_core_global_skin() {
		return eldon_core_get_post_value_through_levels( 'qodef_global_skin' );
	}
}

if ( ! function_exists( 'eldon_core_is_boxed_enabled' ) ) {
	/**
	 * Function that check is option enabled
	 *
	 * @return bool
	 */
	function eldon_core_is_boxed_enabled() {
		return 'yes' === eldon_core_get_post_value_through_levels( 'qodef_boxed' );
	}
}

if ( ! function_exists( 'eldon_core_is_passepartout_enabled' ) ) {
	/**
	 * Function that check is option enabled
	 *
	 * @return bool
	 */
	function eldon_core_is_passepartout_enabled() {
		return 'yes' === eldon_core_get_post_value_through_levels( 'qodef_passepartout' );
	}
}

if ( ! function_exists( 'eldon_core_add_general_options_body_classes' ) ) {
	/**
	 * Function that add additional class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function eldon_core_add_general_options_body_classes( $classes ) {
		$content_behind_header = eldon_core_get_post_value_through_levels( 'qodef_content_behind_header' );

		$classes[] = eldon_core_is_boxed_enabled() ? 'qodef--boxed' : '';
		$classes[] = eldon_core_global_skin() === 'black' ? 'qodef-skin--black' : 'qodef-skin--white';
		$classes[] = 'yes' === $content_behind_header ? 'qodef-content-behind-header' : '';
		$classes[] = eldon_core_is_passepartout_enabled() ? 'qodef--passepartout' : '';

		return $classes;
	}

	add_filter( 'body_class', 'eldon_core_add_general_options_body_classes' );
}

if ( ! function_exists( 'eldon_core_add_general_options_grid_size_classes' ) ) {
	/**
	 * Function that add grid size class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function eldon_core_add_general_options_grid_size_classes( $classes ) {
		$content_width = eldon_core_get_content_width();

		$classes['grid_size'] = 'qodef-content-grid-' . $content_width;

		return $classes;
	}

	add_filter( 'eldon_filter_add_body_classes', 'eldon_core_add_general_options_grid_size_classes' );
}

if ( ! function_exists( 'eldon_core_add_boxed_wrapper_classes' ) ) {
	/**
	 * Function that add additional class name for main page wrapper
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	function eldon_core_add_boxed_wrapper_classes( $classes ) {

		if ( eldon_core_is_boxed_enabled() ) {
			$classes .= ' qodef-content-grid';
		}

		return $classes;
	}

	add_filter( 'eldon_filter_page_wrapper_classes', 'eldon_core_add_boxed_wrapper_classes' );
}

if ( ! function_exists( 'eldon_core_set_video_format_settings' ) ) {
	/**
	 * Function that set global video format size depending of the grid size
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	function eldon_core_set_video_format_settings( $settings ) {
		$content_width = eldon_core_get_content_width();

		if ( ! empty( $content_width ) ) {
			$width = intval( $content_width );

			$settings['width']  = $width;
			$settings['height'] = round( $width * 9 / 16 );  // Aspect ration is 16:9
		}

		return $settings;
	}

	add_filter( 'eldon_core_filter_video_format_settings', 'eldon_core_set_video_format_settings' );
	add_filter( 'eldon_filter_video_post_format_settings', 'eldon_core_set_video_format_settings' );
}

if ( ! function_exists( 'eldon_core_set_general_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function eldon_core_set_general_styles( $style ) {
		$styles = array();

		$background_color      = eldon_core_get_post_value_through_levels( 'qodef_page_background_color' );
		$background_image      = eldon_core_get_post_value_through_levels( 'qodef_page_background_image' );
		$background_repeat     = eldon_core_get_post_value_through_levels( 'qodef_page_background_repeat' );
		$background_size       = eldon_core_get_post_value_through_levels( 'qodef_page_background_size' );
		$background_attachment = eldon_core_get_post_value_through_levels( 'qodef_page_background_attachment' );

		if ( ! empty( $background_color ) ) {
			$styles['background-color'] = $background_color;
		}

		if ( ! empty( $background_image ) ) {
			$styles['background-image'] = 'url(' . esc_url( wp_get_attachment_image_url( $background_image, 'full' ) ) . ')';
		}

		if ( ! empty( $background_repeat ) ) {
			$styles['background-repeat'] = $background_repeat;
		}

		if ( ! empty( $background_size ) ) {
			$styles['background-size'] = $background_size;
		}

		if ( ! empty( $background_attachment ) ) {
			$styles['background-attachment'] = $background_attachment;
		}

		if ( ! empty( $styles ) ) {

			if ( eldon_core_is_boxed_enabled() ) {
				$selector = '.qodef--boxed #qodef-page-wrapper';
			} elseif ( eldon_core_is_passepartout_enabled() ) {
				$selector = '.qodef--passepartout #qodef-page-wrapper';
			} else {
				$selector = 'body';
			}

			$style .= qode_framework_dynamic_style( $selector, $styles );
		}

		if ( eldon_core_is_boxed_enabled() ) {
			$boxed_styles = array();

			$boxed_background_color    = eldon_core_get_post_value_through_levels( 'qodef_boxed_background_color' );
			$boxed_background_pattern  = eldon_core_get_post_value_through_levels( 'qodef_boxed_background_pattern' );
			$boxed_background_behavior = eldon_core_get_post_value_through_levels( 'qodef_boxed_background_pattern_behavior' );

			if ( ! empty( $boxed_background_color ) ) {
				$boxed_styles['background-color'] = $boxed_background_color;
			}

			if ( ! empty( $boxed_background_pattern ) ) {
				$boxed_styles['background-image']    = 'url(' . esc_url( wp_get_attachment_image_url( $boxed_background_pattern, 'full' ) ) . ')';
				$boxed_styles['background-position'] = '0 0';
				$boxed_styles['background-repeat']   = 'repeat';
			}

			if ( 'fixed' === $boxed_background_behavior ) {
				$boxed_styles['background-attachment'] = 'fixed';
			}

			if ( ! empty( $boxed_styles ) ) {
				$style .= qode_framework_dynamic_style( '.qodef--boxed', $boxed_styles );
			}
		}

		if ( eldon_core_is_passepartout_enabled() ) {
			$passepartout_styles = array();
			$passepartout_fixed_header_styles = array();
			$qodef_slider_styles = array();
			$passepartout_color  = eldon_core_get_post_value_through_levels( 'qodef_passepartout_color' );
			$passepartout_image  = eldon_core_get_post_value_through_levels( 'qodef_passepartout_image' );
			$passepartout_size   = eldon_core_get_post_value_through_levels( 'qodef_passepartout_size' );

			if ( ! empty( $passepartout_color ) ) {
				$passepartout_styles['background-color'] = $passepartout_color;
			}

			if ( ! empty( $passepartout_image ) ) {
				$passepartout_styles['background-image'] = 'url(' . esc_url( wp_get_attachment_image_url( $passepartout_image, 'full' ) ) . ')';
			}

			if ( ! empty( $passepartout_size ) ) {

				if ( qode_framework_string_ends_with_space_units( $passepartout_size ) ) {
					$passepartout_styles['padding'] = $passepartout_size;
					$qodef_slider_styles['width']   = 'calc(100% - 2*' . $passepartout_size . ')';
					$passepartout_fixed_header_styles['width']   = 'calc(100% - 2*' . $passepartout_size . ')';
					$passepartout_fixed_header_styles['left']     = $passepartout_size;
					$passepartout_fixed_header_styles['top']     = $passepartout_size;
				} else {
					$passepartout_styles['padding'] = intval( $passepartout_size ) . 'px';
					$qodef_slider_styles['width']   = 'calc(100% - 2*' . intval( $passepartout_size ) . 'px)';
					$passepartout_fixed_header_styles['width']   = 'calc(100% - 2*' . intval( $passepartout_size ) . 'px)';
					$passepartout_fixed_header_styles['left']   = 'calc(100% - 2*' . intval( $passepartout_size ) . 'px)';
					$passepartout_fixed_header_styles['top']   = intval( $passepartout_size ) . 'px';
				}
			}

			if ( ! empty( $passepartout_styles ) ) {
				$style .= qode_framework_dynamic_style( '.qodef--passepartout', $passepartout_styles );
				$style .= qode_framework_dynamic_style( '.qodef--passepartout.qodef-header--fixed-display #qodef-page-header, .qodef--passepartout.qodef-header--fixed-display #qodef-top-area', $passepartout_fixed_header_styles );
			}

			if ( ! empty( $qodef_slider_styles ) ) {
				$style .= qode_framework_dynamic_style( '.qodef--passepartout.qodef-header--bottom #qodef-slider-holder', $qodef_slider_styles );
			}

			$passepartout_responsive_styles = array();
			$passepartout_size_responsive   = eldon_core_get_post_value_through_levels( 'qodef_passepartout_size_responsive' );

			if ( ! empty( $passepartout_size_responsive ) ) {
				if ( qode_framework_string_ends_with_space_units( $passepartout_size_responsive ) ) {
					$passepartout_responsive_styles['padding'] = $passepartout_size_responsive;
				} else {
					$passepartout_responsive_styles['padding'] = intval( $passepartout_size_responsive ) . 'px';
				}
			}

			if ( ! empty( $passepartout_responsive_styles ) ) {
				$style .= qode_framework_dynamic_style_responsive( '.qodef--passepartout', $passepartout_responsive_styles, '', '1024' );
			}
		}

		$page_content_style = array();

		$page_content_padding = eldon_core_get_post_value_through_levels( 'qodef_page_content_padding' );
		if ( ! empty( $page_content_padding ) ) {
			$page_content_style['padding'] = $page_content_padding;
		}

		if ( ! empty( $page_content_style ) ) {
			$style .= qode_framework_dynamic_style( '#qodef-page-inner', $page_content_style );
		}

		$page_content_style_mobile = array();

		$page_content_padding_mobile = eldon_core_get_post_value_through_levels( 'qodef_page_content_padding_mobile' );
		if ( ! empty( $page_content_padding_mobile ) ) {
			$page_content_style_mobile['padding'] = $page_content_padding_mobile;
		}

		if ( ! empty( $page_content_style_mobile ) ) {
			$style .= qode_framework_dynamic_style_responsive( '#qodef-page-inner', $page_content_style_mobile, '', '1024' );
		}

		return $style;
	}

	add_filter( 'eldon_filter_add_inline_style', 'eldon_core_set_general_styles' );
}

if ( ! function_exists( 'eldon_core_set_general_main_color_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function eldon_core_set_general_main_color_styles( $style ) {
		$main_color = eldon_core_get_post_value_through_levels( 'qodef_main_color' );

		if ( ! empty( $main_color ) ) {
			$style .= qode_framework_dynamic_style( ':root', array( '--qode-main-color' => $main_color ) );
		}

		return $style;
	}

	add_filter( 'eldon_filter_add_inline_style', 'eldon_core_set_general_main_color_styles' );
}

if ( ! function_exists( 'eldon_core_print_custom_js' ) ) {
	/**
	 * Prints out custom js from theme options
	 */
	function eldon_core_print_custom_js() {
		$custom_js = eldon_core_get_post_value_through_levels( 'qodef_custom_js' );

		if ( ! empty( $custom_js ) ) {
			wp_add_inline_script( 'eldon-main-js', $custom_js );
		}
	}

	add_action( 'wp_enqueue_scripts', 'eldon_core_print_custom_js', 15 ); // Permission 15 is set in order to call a function after the main theme script initialization
}

if ( ! function_exists( 'eldon_core_disable_images_lazy_loading' ) ) {
	/**
	 * Function that disables images lazy loading
	 *
	 * @param boolean $value
	 *
	 * @return boolean
	 */
	function eldon_core_disable_images_lazy_loading( $value ) {
		$option = eldon_core_get_post_value_through_levels( 'qodef_disable_images_lazy_loading' );

		if ( ! empty( $option ) && 'yes' === $option ) {
			$value = __return_false();
		}

		return $value;
	}

	add_filter( 'wp_lazy_loading_enabled', 'eldon_core_disable_images_lazy_loading' );
}