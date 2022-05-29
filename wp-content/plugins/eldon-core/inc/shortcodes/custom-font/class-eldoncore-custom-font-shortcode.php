<?php

if ( ! function_exists( 'eldon_core_add_custom_font_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_custom_font_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Custom_Font_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_custom_font_shortcode' );
}

if ( class_exists( 'EldonCore_Shortcode' ) ) {
	class EldonCore_Custom_Font_Shortcode extends EldonCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'eldon_core_filter_custom_font_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_SHORTCODES_URL_PATH . '/custom-font' );
			$this->set_base( 'eldon_core_custom_font' );
			$this->set_name( esc_html__( 'Custom Font', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays custom font with provided parameters', 'eldon-core' ) );
			$this->set_category( esc_html__( 'Eldon Core', 'eldon-core' ) );

			$options_map = eldon_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'eldon-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array(
						'map_for_page_builder' => $options_map['visibility'],
						'map_for_widget'       => $options_map['visibility'],
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'tagline',
					'title'      => esc_html__( 'Tagline', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'title',
					'title'      => esc_html__( 'Title Text', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'emphasized_words_positions',
					'title'       => esc_html__( 'Positions of Emphasized Words', 'eldon-core' ),
					'description' => esc_html__( 'Enter the positions of the words you would like to have different styling. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a second break, you would enter "1,3,4")', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'linked_words_positions',
					'title'       => esc_html__( 'Positions of Linked Words', 'eldon-core' ),
					'description' => esc_html__( 'Enter the positions of the words you would like to be linked. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a second break, you would enter "1,3,4")', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'link',
					'title'       => esc_html__( 'Custom Link', 'eldon-core' ),
					'description' => esc_html__( 'Enter the URL for the linked words.', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Custom Link Target', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
					'dependency'    => array(
						'hide' => array(
							'link' => array(
								'values'        => '',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'p',
					'group'         => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'color',
					'title'      => esc_html__( 'Color', 'eldon-core' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'font_family',
					'title'      => esc_html__( 'Font Family', 'eldon-core' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'font_size',
					'title'      => esc_html__( 'Font Size', 'eldon-core' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'line_height',
					'title'      => esc_html__( 'Line Height', 'eldon-core' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'letter_spacing',
					'title'      => esc_html__( 'Letter Spacing', 'eldon-core' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'font_weight',
					'title'      => esc_html__( 'Font Weight', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'font_weight' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'font_style',
					'title'      => esc_html__( 'Font Style', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'font_style' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'text_transform',
					'title'      => esc_html__( 'Text Transform', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'text_transform' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'margin',
					'title'      => esc_html__( 'Margin', 'eldon-core' ),
					'group'      => esc_html__( 'Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'content_alignment',
					'title'      => esc_html__( 'Content Alignment', 'eldon-core' ),
					'options'    => array(
						''       => esc_html__( 'Default', 'eldon-core' ),
						'left'   => esc_html__( 'Left', 'eldon-core' ),
						'center' => esc_html__( 'Center', 'eldon-core' ),
						'right'  => esc_html__( 'Right', 'eldon-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'emphasized_font_family',
					'title'      => esc_html__( 'Font Family', 'eldon-core' ),
					'group'      => esc_html__( 'Emphasized Typography Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'emphasized_font_size',
					'title'       => esc_html__( 'Font Size', 'eldon-core' ),
					'description' => esc_html__( 'Set in ems to maintain proportion on responsive screens', 'eldon-core' ),
					'group'       => esc_html__( 'Emphasized Typography Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'emphasized_line_height',
					'title'      => esc_html__( 'Line Height', 'eldon-core' ),
					'group'      => esc_html__( 'Emphasized Typography Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'emphasized_letter_spacing',
					'title'      => esc_html__( 'Letter Spacing', 'eldon-core' ),
					'group'      => esc_html__( 'Emphasized Typography Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'emphasized_font_weight',
					'title'      => esc_html__( 'Font Weight', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'font_weight' ),
					'group'      => esc_html__( 'Emphasized Typography Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'emphasized_font_style',
					'title'      => esc_html__( 'Font Style', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'font_style' ),
					'group'      => esc_html__( 'Emphasized Typography Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'emphasized_text_transform',
					'title'      => esc_html__( 'Text Transform', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'text_transform' ),
					'group'      => esc_html__( 'Emphasized Typography Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_1366',
					'title'       => esc_html__( 'Font Size', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1366', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 1366 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_1366',
					'title'       => esc_html__( 'Line Height', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1366', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 1366 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_1366',
					'title'       => esc_html__( 'Letter Spacing', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1366', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 1366 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_1024',
					'title'       => esc_html__( 'Font Size', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1024', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 1024 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_1024',
					'title'       => esc_html__( 'Line Height', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1024', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 1024 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_1024',
					'title'       => esc_html__( 'Letter Spacing', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1024', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 1024 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_768',
					'title'       => esc_html__( 'Font Size', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 768', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 768 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_768',
					'title'       => esc_html__( 'Line Height', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 768', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 768 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_768',
					'title'       => esc_html__( 'Letter Spacing', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 768', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 768 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_680',
					'title'       => esc_html__( 'Font Size', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 680', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 680 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_680',
					'title'       => esc_html__( 'Line Height', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 680', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 680 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_680',
					'title'       => esc_html__( 'Letter Spacing', 'eldon-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 680', 'eldon-core' ),
					'group'       => esc_html__( 'Screen Size 680 Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'appear_animation',
					'title'      => esc_html__( 'Enable Appear Animation', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'yes_no', false ),
				)
			);
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'eldon_core_custom_font', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['unique_class']   = 'qodef-custom-font-' . rand( 0, 1000 );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['holder_styles']  = $this->get_holder_styles( $atts );
			$atts['title']          = $this->get_modified_title( $atts );
			$this->set_responsive_styles( $atts );
			$this->set_emphasized_styles( $atts );

			return eldon_core_get_template_part( 'shortcodes/custom-font', 'variations/' . $atts['layout'] . '/templates/custom-font', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-custom-font';
			$holder_classes[] = $atts['unique_class'];
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['content_alignment'] ) ? 'qodef-alignment--' . $atts['content_alignment'] : 'qodef-alignment--left';
			$holder_classes[] = 'yes' === $atts['appear_animation'] ? 'qodef--has-appear' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_holder_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['color'] ) ) {
				$styles[] = 'color: ' . $atts['color'];
			}

			if ( ! empty( $atts['font_family'] ) ) {
				$styles[] = 'font-family: ' . $atts['font_family'];
			}

			$font_size = $atts['font_size'];
			if ( ! empty( $font_size ) ) {
				if ( qode_framework_string_ends_with_typography_units( $font_size ) ) {
					$styles[] = 'font-size: ' . $font_size;
				} else {
					$styles[] = 'font-size: ' . intval( $font_size ) . 'px';
				}
			}

			$line_height = $atts['line_height'];
			if ( ! empty( $line_height ) ) {
				if ( qode_framework_string_ends_with_typography_units( $line_height ) ) {
					$styles[] = 'line-height: ' . $line_height;
				} else {
					$styles[] = 'line-height: ' . intval( $line_height ) . 'px';
				}
			}

			$letter_spacing = $atts['letter_spacing'];
			if ( '' !== $letter_spacing ) {
				if ( qode_framework_string_ends_with_typography_units( $letter_spacing ) ) {
					$styles[] = 'letter-spacing: ' . $letter_spacing;
				} else {
					$styles[] = 'letter-spacing: ' . intval( $letter_spacing ) . 'px';
				}
			}

			if ( ! empty( $atts['font_weight'] ) ) {
				$styles[] = 'font-weight: ' . $atts['font_weight'];
			}

			if ( ! empty( $atts['font_style'] ) ) {
				$styles[] = 'font-style: ' . $atts['font_style'];
			}

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			if ( '' !== $atts['margin'] ) {
				$styles[] = 'margin: ' . $atts['margin'];
			}

			return $styles;
		}

		private function set_emphasized_styles( $atts ) {

			$unique_class = '.' . $atts['unique_class'];
			$styles = array();

			if ( ! empty( $atts['emphasized_color'] ) ) {
				$styles['color'] = $atts['emphasized_color'];
			}

			if ( ! empty( $atts['emphasized_font_family'] ) ) {
				$styles['font-family'] = $atts['emphasized_font_family'];
			}

			$font_size = $atts['emphasized_font_size'];
			if ( ! empty( $font_size ) ) {
				if ( qode_framework_string_ends_with_typography_units( $font_size ) ) {
					$styles['font-size'] = $font_size;
				} else {
					$styles['font-size'] = intval( $font_size ) . 'px';
				}
			}

			$line_height = $atts['emphasized_line_height'];
			if ( ! empty( $line_height ) ) {
				if ( qode_framework_string_ends_with_typography_units( $line_height ) ) {
					$styles['line-height'] = $line_height;
				} else {
					$styles['line-height'] = intval( $line_height ) . 'px';
				}
			}

			$letter_spacing = $atts['emphasized_letter_spacing'];
			if ( '' !== $letter_spacing ) {
				if ( qode_framework_string_ends_with_typography_units( $letter_spacing ) ) {
					$styles['letter-spacing'] = $letter_spacing;
				} else {
					$styles['letter-spacing'] = intval( $letter_spacing ) . 'px';
				}
			}

			if ( ! empty( $atts['emphasized_font_weight'] ) ) {
				$styles['font-weight'] = $atts['emphasized_font_weight'];
			}

			if ( ! empty( $atts['emphasized_font_style'] ) ) {
				$styles['font-style'] = $atts['emphasized_font_style'];
			}

			if ( ! empty( $atts['emphasized_text_transform'] ) ) {
				$styles['text-transform'] = $atts['emphasized_text_transform'];
			}

			if ( ! empty( $styles ) ) {
				$unique_class = '.' . $atts['unique_class'] . ' .qodef-m-title--emphasized';

				add_filter(
					'eldon_core_filter_add_inline_style_in_footer',
					function( $style ) use ( $unique_class, $styles ) {
						$style .= qode_framework_dynamic_style( $unique_class, $styles );
						return $style;
					}
				);
			}
		}

		private function set_responsive_styles( $atts ) {
			$unique_class = '.' . $atts['unique_class'] . ' .qodef-custom-font-content';
			$screen_sizes = array( '1366', '1024', '768', '680' );
			$option_keys  = array( 'font_size', 'line_height', 'letter_spacing' );

			foreach ( $screen_sizes as $screen_size ) {
				$styles = array();

				foreach ( $option_keys as $option_key ) {
					$option_value = $atts[ $option_key . '_' . $screen_size ];
					$style_key    = str_replace( '_', '-', $option_key );

					if ( '' !== $option_value ) {
						if ( qode_framework_string_ends_with_typography_units( $option_value ) ) {
							$styles[ $style_key ] = $option_value . '!important';
						} else {
							$styles[ $style_key ] = intval( $option_value ) . 'px !important';
						}
					}
				}

				if ( ! empty( $styles ) ) {
					add_filter(
						'eldon_core_filter_add_responsive_' . $screen_size . '_inline_style_in_footer',
						function ( $style ) use ( $unique_class, $styles ) {
							$style .= qode_framework_dynamic_style( $unique_class, $styles );

							return $style;
						}
					);
				}
			}
		}

		private function get_modified_title( $atts ) {
			$title = $atts['title'];

			if ( ! empty( $title ) ) {
				$split_title = explode( ' ', $title );
				$link_positions = explode( ',', str_replace( ' ', '', $atts['linked_words_positions'] ) );
				$emphasized_words_positions = explode( ',', str_replace( ' ', '', $atts['emphasized_words_positions'] ) );
				$animated = $atts['appear_animation'] === 'yes';

				if ( ! empty( $atts['emphasized_words_positions'] ) ) {
					foreach ( $emphasized_words_positions as $position ) {
						if ( ! empty( $split_title[ intval( $position ) - 1 ] ) ) {
							$split_title[ intval( $position ) - 1 ] = '<span class="qodef-m-emphasized-holder"><span class="qodef-m-title--emphasized" >' . $split_title[ intval( $position ) - 1 ] . '</span></span>';
						}
					}
				}

				if ( $animated ) {
					for ( $position = 1; $position < count( $split_title ) + 1; $position++ ) {
						if ( ! empty( $emphasized_words_positions ) && ! in_array( $position, $emphasized_words_positions ) ) {
							$split_title[ intval( $position - 1 ) ] = '<span class="qodef-animated-text-holder"><span class="qodef-animated-text-original">'. $split_title[ intval( $position ) - 1] . '</span><span class="qodef-animated-text-duplicate">'. $split_title[ intval( $position ) - 1] . '</span></span>';
						}
					}
				}

				if ( ! empty( $link_positions ) ) {
					if ( count( $link_positions ) === 2 ) {
						$begin = intval( $link_positions[0] );
						$end   = intval( $link_positions[1] );
						if ( ! empty( $split_title[ $begin - 1 ] ) && ! empty( $split_title [ $end - 1 ] ) ) {
							$split_title[ $begin - 1 ] = '<a class="qodef-m-link" href="' . esc_attr( $atts['link'] ) . '" target="' . esc_attr( $atts['target'] ) . '">' . $split_title[ $begin - 1 ];
							$split_title[ $end - 1 ]   = $split_title[ $end - 1 ] . '</a>';
						}
					} else {
						foreach ( $link_positions as $position ) {
							$position = intval( $position );

							if ( isset( $split_title[ $position - 1 ] ) && ! empty( $split_title[ $position - 1 ] ) ) {
								$split_title[ $position - 1 ] = '<a class="qodef-m-link" href="' . esc_attr( $atts['link'] ) . '" target="' . esc_attr( $atts['target'] ) . '">' . $split_title[ $position - 1 ] . '</a>';
							}
						}
					}
				}

				$title = implode( ' ', $split_title );
			}

			return $title;
		}
	}
}
