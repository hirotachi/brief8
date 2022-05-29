<?php

if ( ! function_exists( 'eldon_is_installed' ) ) {
	/**
	 * Function that checks if forward plugin installed
	 *
	 * @param string $plugin - plugin name
	 *
	 * @return bool
	 */
	function eldon_is_installed( $plugin ) {

		switch ( $plugin ) {
			case 'framework':
				return class_exists( 'QodeFramework' );
			case 'core':
				return class_exists( 'EldonCore' );
			case 'woocommerce':
				return class_exists( 'WooCommerce' );
			case 'gutenberg-page':
				$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : array();

				return method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor();
			case 'gutenberg-editor':
				return class_exists( 'WP_Block_Type' );
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'eldon_include_theme_is_installed' ) ) {
	/**
	 * Function that set case is installed element for framework functionality
	 *
	 * @param bool $installed
	 * @param string $plugin - plugin name
	 *
	 * @return bool
	 */
	function eldon_include_theme_is_installed( $installed, $plugin ) {

		if ( 'theme' === $plugin ) {
			return class_exists( 'Eldon_Handler' );
		}

		return $installed;
	}

	add_filter( 'qode_framework_filter_is_plugin_installed', 'eldon_include_theme_is_installed', 10, 2 );
}

if ( ! function_exists( 'eldon_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 */
	function eldon_template_part( $module, $template, $slug = '', $params = array() ) {
		echo eldon_get_template_part( $module, $template, $slug, $params ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'eldon_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return string - string containing html of template
	 */
	function eldon_get_template_part( $module, $template, $slug = '', $params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = ELDON_INC_ROOT_DIR . '/' . $module;

		$temp = $template_path . '/' . $template;
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params ); // @codingStandardsIgnoreLine
		}

		$template = '';

		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";

				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}

		if ( $template ) {
			ob_start();
			include( $template ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			$html = ob_get_clean();
		}

		return $html;
	}
}

if ( ! function_exists( 'eldon_get_page_id' ) ) {
	/**
	 * Function that returns current page id
	 * Additional conditional is to check if current page is any wp archive page (archive, category, tag, date etc.) and returns -1
	 *
	 * @return int
	 */
	function eldon_get_page_id() {
		$page_id = get_queried_object_id();

		if ( eldon_is_wp_template() ) {
			$page_id = - 1;
		}

		return apply_filters( 'eldon_filter_page_id', $page_id );
	}
}

if ( ! function_exists( 'eldon_is_wp_template' ) ) {
	/**
	 * Function that checks if current page default wp page
	 *
	 * @return bool
	 */
	function eldon_is_wp_template() {
		return is_archive() || is_search() || is_404() || ( is_front_page() && is_home() );
	}
}

if ( ! function_exists( 'eldon_get_ajax_status' ) ) {
	/**
	 * Function that return status from ajax functions
	 *
	 * @param string $status - success or error
	 * @param string $message - ajax message value
	 * @param string|array $data - returned value
	 * @param string $redirect - url address
	 */
	function eldon_get_ajax_status( $status, $message, $data = null, $redirect = '' ) {
		$response = array(
			'status'   => esc_attr( $status ),
			'message'  => esc_html( $message ),
			'data'     => $data,
			'redirect' => ! empty( $redirect ) ? esc_url( $redirect ) : '',
		);

		$output = json_encode( $response );

		exit( $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'eldon_get_button_element' ) ) {
	/**
	 * Function that returns button with provided params
	 *
	 * @param array $params - array of parameters
	 *
	 * @return string - string representing button html
	 */
	function eldon_get_button_element( $params ) {
		if ( class_exists( 'EldonCore_Button_Shortcode' ) ) {
			return EldonCore_Button_Shortcode::call_shortcode( $params );
		} else {
			$link   = isset( $params['link'] ) ? $params['link'] : '#';
			$target = isset( $params['target'] ) ? $params['target'] : '_self';
			$text   = isset( $params['text'] ) ? $params['text'] : '';

			return '<a itemprop="url" class="qodef-theme-button" href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '">' . esc_html( $text ) . '</a>';
		}
	}
}

if ( ! function_exists( 'eldon_render_button_element' ) ) {
	/**
	 * Function that render button with provided params
	 *
	 * @param array $params - array of parameters
	 */
	function eldon_render_button_element( $params ) {
		echo eldon_get_button_element( $params ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'eldon_class_attribute' ) ) {
	/**
	 * Function that render class attribute
	 *
	 * @param string|array $class
	 */
	function eldon_class_attribute( $class ) {
		echo eldon_get_class_attribute( $class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'eldon_get_class_attribute' ) ) {
	/**
	 * Function that return class attribute
	 *
	 * @param string|array $class
	 *
	 * @return string|mixed
	 */
	function eldon_get_class_attribute( $class ) {
		return eldon_is_installed( 'framework' ) ? qode_framework_get_class_attribute( $class ) : '';
	}
}

if ( ! function_exists( 'eldon_get_post_value_through_levels' ) ) {
	/**
	 * Function that returns meta value if exists
	 *
	 * @param string $name name of option
	 * @param int $post_id id of
	 *
	 * @return string value of option
	 */
	function eldon_get_post_value_through_levels( $name, $post_id = null ) {
		return eldon_is_installed( 'framework' ) && eldon_is_installed( 'core' ) ? eldon_core_get_post_value_through_levels( $name, $post_id ) : '';
	}
}

if ( ! function_exists( 'eldon_get_space_value' ) ) {
	/**
	 * Function that returns spacing value based on selected option
	 *
	 * @param string $text_value - textual value of spacing
	 *
	 * @return int
	 */
	function eldon_get_space_value( $text_value ) {
		return eldon_is_installed( 'core' ) ? eldon_core_get_space_value( $text_value ) : 0;
	}
}

if ( ! function_exists( 'eldon_wp_kses_html' ) ) {
	/**
	 * Function that does escaping of specific html.
	 * It uses wp_kses function with predefined attributes array.
	 *
	 * @param string $type - type of html element
	 * @param string $content - string to escape
	 *
	 * @return string escaped output
	 * @see wp_kses()
	 *
	 */
	function eldon_wp_kses_html( $type, $content ) {
		return eldon_is_installed( 'framework' ) ? qode_framework_wp_kses_html( $type, $content ) : $content;
	}
}

if ( ! function_exists( 'eldon_render_svg_icon' ) ) {
	/**
	 * Function that print svg html icon
	 *
	 * @param string $name - icon name
	 * @param string $class_name - custom html tag class name
	 */
	function eldon_render_svg_icon( $name, $class_name = '' ) {
		echo eldon_get_svg_icon( $name, $class_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'eldon_get_svg_icon' ) ) {
	/**
	 * Returns svg html
	 *
	 * @param string $name - icon name
	 * @param string $class_name - custom html tag class name
	 *
	 * @return string - string containing svg html
	 */
	function eldon_get_svg_icon( $name, $class_name = '' ) {
		$html  = '';
		$class = isset( $class_name ) && ! empty( $class_name ) ? 'class="' . esc_attr( $class_name ) . '"' : '';

		switch ( $name ) {
			case 'menu':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><line x1="12" y1="21" x2="52" y2="21"/><line x1="12" y1="33" x2="52" y2="33"/><line x1="12" y1="45" x2="52" y2="45"/></svg>';
				break;
			case 'search':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M456.69 421.39L362.6 327.3a173.81 173.81 0 0034.84-104.58C397.44 126.38 319.06 48 222.72 48S48 126.38 48 222.72s78.38 174.72 174.72 174.72A173.81 173.81 0 00327.3 362.6l94.09 94.09a25 25 0 0035.3-35.3zM97.92 222.72a124.8 124.8 0 11124.8 124.8 124.95 124.95 0 01-124.8-124.8z"/></svg>';
				break;
			case 'star':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" width="17" height="16"><defs><path id="qodef_star" d="M16.625 5.901l-5.2 3.637 2 5.9-5.112-3.674-5.122 3.674 2-5.9L0 5.901h6.346l1.967-5.9 1.967 5.9z"/><clipPath id="clip_qodef_star"><use xlink:href="#qodef_star"/></clipPath></defs><g><use xlink:href="#qodef_star" stroke-width="1.5" clip-path="url(#clip_qodef_star)"/></g></svg>';
				break;
			case 'menu-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z"></path></g></svg>';
				break;
			case 'slider-arrow-left':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 43 30" xml:space="preserve"><polygon points="-0.1,15.2 13.7,30 21.8,30 10.8,18.2 43,18.2 43,12.2 10.7,12.2 21.8,0 13.7,0 "/></svg>';
				break;
			case 'slider-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 43 30" xml:space="preserve"><polygon points="29.2,0 21.1,0 32.2,12.2 -0.1,12.2 -0.1,18.2 32.1,18.2 21.1,30 29.2,30 43,15.2 "/></svg>';
				break;
			case 'pagination-arrow-left':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 43 30" xml:space="preserve"><polygon points="-0.1,15.2 13.7,30 21.8,30 10.8,18.2 43,18.2 43,12.2 10.7,12.2 21.8,0 13.7,0 "/></svg>';
				break;
			case 'pagination-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 43 30" xml:space="preserve"><polygon points="29.2,0 21.1,0 32.2,12.2 -0.1,12.2 -0.1,18.2 32.1,18.2 21.1,30 29.2,30 43,15.2 "/></svg>';
				break;
			case 'portfolio-nav-arrow-left':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="14" x="0px" y="0px" viewBox="0 0 20 14" style="enable-background:new 0 0 20 14;" xml:space="preserve"><polygon points="0.1,7.1 6.4,13.9 10.2,13.9 5.1,8.5 19.9,8.5 19.9,5.8 5.1,5.8 10.2,0.2 6.4,0.2 "/></svg>';
				break;
			case 'portfolio-nav-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="14" x="0px" y="0px" viewBox="0 0 20 14" style="enable-background:new 0 0 20 14;" xml:space="preserve"><polygon points="13.7,0.2 9.9,0.2 15,5.8 0.2,5.8 0.2,8.5 15,8.5 9.9,13.9 13.7,13.9 20,7.1 "/></svg>';
				break;
			case 'portfolio-nav-back-link':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0px" y="0px" viewBox="0 0 22 22" style="enable-background:new 0 0 22 22;" xml:space="preserve">
					<rect x="0.8" y="0.9" width="5" height="5"/>
					<rect x="8.5" y="0.9" width="5" height="5"/>
					<rect x="16.2" y="0.9" width="5" height="5"/>
					<rect x="0.8" y="8.6" width="5" height="5"/>
					<rect x="8.5" y="8.6" width="5" height="5"/>
					<rect x="16.2" y="8.6" width="5" height="5"/>
					<rect x="0.8" y="16.4" width="5" height="5"/>
					<rect x="8.5" y="16.4" width="5" height="5"/>
					<rect x="16.2" y="16.4" width="5" height="5"/>
				</svg>';
				break;
			case 'close':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 10.050,23.95c 0.39,0.39, 1.024,0.39, 1.414,0L 17,18.414l 5.536,5.536c 0.39,0.39, 1.024,0.39, 1.414,0 c 0.39-0.39, 0.39-1.024,0-1.414L 18.414,17l 5.536-5.536c 0.39-0.39, 0.39-1.024,0-1.414c-0.39-0.39-1.024-0.39-1.414,0 L 17,15.586L 11.464,10.050c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 15.586,17l-5.536,5.536 C 9.66,22.926, 9.66,23.56, 10.050,23.95z"></path></g></svg>';
				break;
			case 'spinner':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>';
				break;
			case 'link':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99 55"><path d="M63.1 12.5c.9 2.3 1.4 4.8 1.4 7.5v7.5H53.3V20c0-2.2-.7-4-2.1-5.4s-3.2-2.1-5.4-2.1H19.5c-2.2 0-4 .7-5.4 2.1S12 17.8 12 20v7.5c0 2.2.7 4 2.1 5.4s3.2 2.1 5.4 2.1h3.8c.5 2.2 1.3 4.2 2.6 6.1 1.2 1.9 2.4 3.2 3.5 4l1.4 1.2H19.5c-5.2 0-9.6-1.8-13.2-5.5C2.6 37.1.8 32.7.8 27.6V20c0-5.2 1.8-9.6 5.5-13.2 3.7-3.7 8.1-5.5 13.2-5.5h26.3c3.8 0 7.2 1.1 10.4 3.2s5.5 4.8 6.9 8zM72 1.3c5.2 0 9.6 1.8 13.2 5.5 3.7 3.7 5.5 8.1 5.5 13.2v7.5c0 5.2-1.8 9.6-5.5 13.2-3.7 3.7-8.1 5.5-13.2 5.5H45.8c-8 0-13.7-3.8-17.1-11.3-1.1-2.7-1.6-5.2-1.6-7.5V20h11.3v7.5c0 2.2.7 4 2.1 5.4s3.2 2.1 5.4 2.1H72c2.2 0 4-.7 5.4-2.1s2.1-3.2 2.1-5.4V20c0-2.2-.7-4-2.1-5.4s-3.2-2.1-5.4-2.1h-3.8c-.5-2.2-1.3-4.2-2.6-6.1-1.3-1.9-2.4-3.2-3.5-4l-1.4-1.2H72z"/><path d="M79.7 53.7H53.4c-8.1 0-14.1-3.9-17.6-11.5-1.1-2.7-1.7-5.3-1.7-7.7v-8h12.3v8c0 2.1.6 3.7 2 5s3 2 5 2h26.3c2.1 0 3.7-.6 5-2s2-3 2-5V27c0-2.1-.6-3.7-2-5s-3-2-5-2h-4.2l-.1-.4c-.5-2.1-1.3-4.1-2.5-5.9-1.2-1.8-2.4-3.1-3.4-3.9L67 7.7h12.6c5.3 0 9.8 1.9 13.6 5.7 3.8 3.8 5.7 8.3 5.7 13.6v7.5c0 5.3-1.9 9.8-5.7 13.6-3.7 3.7-8.2 5.6-13.5 5.6zM35.2 27.4v7c0 2.3.5 4.7 1.6 7.3 3.3 7.3 8.9 10.9 16.6 10.9h26.3c5 0 9.3-1.8 12.9-5.4 3.6-3.6 5.4-7.9 5.4-12.9v-7.5c0-5-1.8-9.3-5.4-12.9-3.6-3.6-7.9-5.4-12.9-5.4h-9.9l.3.3c1.1.8 2.3 2.2 3.6 4.1 1.2 1.8 2.1 3.8 2.6 5.9h3.4c2.3 0 4.2.8 5.7 2.3 1.5 1.5 2.3 3.4 2.3 5.7v7.5c0 2.3-.8 4.2-2.3 5.7s-3.4 2.3-5.7 2.3H53.4c-2.3 0-4.2-.8-5.7-2.3-1.5-1.5-2.3-3.4-2.3-5.7v-7H35.2zm4.6 26.3H27.2c-5.3 0-9.8-1.9-13.6-5.7-3.8-3.7-5.7-8.3-5.7-13.6v-7.5c0-5.3 1.9-9.8 5.7-13.6 3.8-3.8 8.3-5.7 13.6-5.7h26.3c3.8 0 7.4 1.1 10.7 3.2 3.3 2.2 5.7 5 7.1 8.3 1 2.4 1.4 5 1.4 7.7v8H60.4v-8c0-2.1-.6-3.7-2-5s-3-2-5-2H27.2c-2.1 0-3.7.6-5 2s-2 3-2 5v7.5c0 2.1.6 3.7 2 5s3 2 5 2h4.2l.1.4c.5 2.1 1.3 4.1 2.5 5.9 1.2 1.8 2.4 3.1 3.4 3.9l2.4 2.2zm-12.6-45c-5 0-9.3 1.8-12.9 5.4C10.7 17.7 8.9 22 8.9 27v7.5c0 5 1.8 9.3 5.4 12.9 3.6 3.6 7.9 5.4 12.9 5.4h9.9l-.3-.3c-1.1-.8-2.3-2.2-3.6-4.1-1.2-1.8-2.1-3.8-2.6-5.9h-3.4c-2.3 0-4.2-.8-5.7-2.3-1.5-1.5-2.3-3.4-2.3-5.7V27c0-2.3.8-4.2 2.3-5.7 1.5-1.5 3.4-2.3 5.7-2.3h26.3c2.3 0 4.2.8 5.7 2.3 1.5 1.5 2.3 3.4 2.3 5.7v7h10.3v-7c0-2.6-.5-5-1.4-7.3-1.4-3.2-3.6-5.8-6.7-7.9-3.1-2-6.5-3.1-10.2-3.1H27.2z"/></svg>';
				break;
			case 'play-triangle':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" width="98.684" height="98.858" viewBox="0 0 98.684 98.858"><path d="M98.684 49.432L0 98.86V.002z"/></svg>';
				break;
			case 'back-to-top':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 43.1" xml:space="preserve"><g><polygon points="14.8,0 0,13.8 0,21.9 11.8,10.9 11.8,43.1 17.8,43.1 17.8,10.8 30,21.9 30,13.8 "/></g><g><polygon points="14.8,0 0,13.8 0,21.9 11.8,10.9 11.8,43.1 17.8,43.1 17.8,10.8 30,21.9 30,13.8 "/></g></svg>';
				break;
		}

		// remove white spaces from loaded svg markup
		$html = preg_replace( '~>\s+<~', '><', $html );
		$html = trim( $html );

		return apply_filters( 'eldon_filter_svg_icon', $html );
	}
}
