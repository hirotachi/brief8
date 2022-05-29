<?php

if ( ! function_exists( 'eldon_get_search_page_excerpt_length' ) ) {
	/**
	 * Function that return number of characters for excerpt on search page
	 *
	 * @return int
	 */
	function eldon_get_search_page_excerpt_length() {
		$length = apply_filters( 'eldon_filter_post_excerpt_length', 180 );

		return intval( $length );
	}
}

if ( ! function_exists( 'eldon_override_search_block_templates' ) ) {
	/**
	 * Function that override `core/search` block template
	 *
	 * @see register_block_core_search()
	 */
	function eldon_override_search_block_templates( $atts ) {

		if ( ! empty( $atts ) && isset( $atts['render_callback'] ) && 'render_block_core_search' === $atts['render_callback'] ) {
			$atts['render_callback'] = 'eldon_render_block_core_search';
		}

		return $atts;
	}

	add_filter( 'block_type_metadata_settings', 'eldon_override_search_block_templates' );
}

if ( ! function_exists( 'eldon_render_block_core_search' ) ) {
	/**
	 * Function that dynamically renders the `core/search` block
	 *
	 * @param array $attributes - the block attributes
	 *
	 * @return string - the search block markup
	 *
	 * @see render_block_core_search()
	 */
	function eldon_render_block_core_search( $attributes ) {
		// TODO - replace whole function with get_search_form call, and pass attributes to template
		static $instance_id = 0;

		$attributes = wp_parse_args(
			$attributes,
			array(
				'label'      => esc_html__( 'Search', 'eldon' ),
				'buttonText' => esc_html__( 'Search', 'eldon' ),
			)
		);

		$input_id        = 'qodef-search-form-' . ++ $instance_id;
		$show_label      = ! empty( $attributes['showLabel'] );
		$use_icon_button = ! empty( $attributes['buttonUseIcon'] );
		$show_input      = ! ( ! empty( $attributes['buttonPosition'] ) && 'button-only' === $attributes['buttonPosition'] );
		$show_button     = ! ( ! empty( $attributes['buttonPosition'] ) && 'no-button' === $attributes['buttonPosition'] );
		$label_markup    = '';
		$input_markup    = '';
		$button_markup   = '';
		$inline_styles   = styles_for_block_core_search( $attributes );

		if ( $show_label ) {
			if ( ! empty( $attributes['label'] ) ) {
				$label_markup = sprintf(
					'<label for="%s" class="qodef-search-form-label">%s</label>',
					$input_id,
					$attributes['label']
				);
			} else {
				$label_markup = sprintf(
					'<label for="%s" class="screen-reader-text">%s</label>',
					$input_id,
					esc_html__( 'Search', 'eldon' )
				);
			}
		}

		if ( $show_input ) {
			$input_markup = sprintf(
				'<input type="search" id="%s" class="qodef-search-form-field" name="s" value="%s" placeholder="%s" %s required />',
				$input_id,
				esc_attr( get_search_query() ),
				esc_attr( $attributes['placeholder'] ),
				$inline_styles['shared']
			);
		}

		if ( $show_button ) {
			$button_internal_markup = '';
			$button_classes         = ! empty( $attributes['buttonPosition'] ) ? 'qodef--' . $attributes['buttonPosition'] : '';

			if ( ! $use_icon_button ) {
				if ( ! empty( $attributes['buttonText'] ) ) {
					$button_internal_markup = $attributes['buttonText'];
				}
			} else {
				$button_classes        .= ' qodef--has-icon';
				$button_internal_markup = eldon_get_svg_icon( 'search' );
			}

			$button_markup = sprintf(
				'<button type="submit" class="qodef-search-form-button %s"%s>%s</button>',
				$button_classes,
				$inline_styles['shared'],
				$button_internal_markup
			);
		}

		$field_markup = sprintf(
			'<div class="qodef-search-form-inner"%s>%s</div>',
			$inline_styles['wrapper'],
			$input_markup . $button_markup
		);

		return sprintf(
			'<form role="search" method="get" class="qodef-search-form" action="%s">%s</form>',
			esc_url( home_url( '/' ) ),
			$label_markup . $field_markup
		);
	}
}
