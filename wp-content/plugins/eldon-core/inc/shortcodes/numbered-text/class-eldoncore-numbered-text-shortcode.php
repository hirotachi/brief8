<?php

if ( ! function_exists( 'eldon_core_add_numbered_text_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_numbered_text_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Numbered_Text_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_numbered_text_shortcode' );
}

if ( class_exists( 'EldonCore_Shortcode' ) ) {
	class EldonCore_Numbered_Text_Shortcode extends EldonCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_SHORTCODES_URL_PATH . '/numbered-text' );
			$this->set_base( 'eldon_core_numbered_text' );
			$this->set_name( esc_html__( 'Numbered Text', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds numbered text element', 'eldon-core' ) );
			$this->set_category( esc_html__( 'Eldon Core', 'eldon-core' ) );
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
					'name'       => 'number',
					'title'      => esc_html__( 'Number', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'number_font_size',
					'title'      => esc_html__( 'Number Font Size', 'eldon-core' ),
					'group'      => esc_html__( 'Number Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'background_image',
					'title'      => esc_html__( 'Number Background Image', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title',
					'title'      => esc_html__( 'Title', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h3',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'title_color',
					'title'      => esc_html__( 'Title Color', 'eldon-core' ),
					'group'      => esc_html__( 'Title Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_margin_top',
					'title'      => esc_html__( 'Title Margin Top', 'eldon-core' ),
					'group'      => esc_html__( 'Title Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text',
					'title'      => esc_html__( 'Text', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_color',
					'title'      => esc_html__( 'Text Color', 'eldon-core' ),
					'group'      => esc_html__( 'Text Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_font_size',
					'title'      => esc_html__( 'Text Font Size', 'eldon-core' ),
					'group'      => esc_html__( 'Text Style', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_margin_top',
					'title'      => esc_html__( 'Text Margin Top', 'eldon-core' ),
					'group'      => esc_html__( 'Text Style', 'eldon-core' ),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes();
			$atts['number_styles']  = $this->get_number_styles( $atts );
			$atts['title_styles']   = $this->get_title_styles( $atts );
			$atts['text_styles']    = $this->get_text_styles( $atts );

			return eldon_core_get_template_part( 'shortcodes/numbered-text', 'templates/numbered-text', '', $atts );
		}

		private function get_holder_classes() {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-numbered-text';

			return implode( ' ', $holder_classes );
		}

		private function get_number_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['background_image'] ) ) {
				$image_url = esc_url( wp_get_attachment_image_url( $atts['background_image'], 'full' ) );

				$styles[] = 'background-image: ' . 'url(' . $image_url . ')';
			} else {
				$styles[] = 'color: var(--qodef-main-color)';
			}

			if ( '' !== $atts['number_font_size'] ) {
				if ( qode_framework_string_ends_with_typography_units( $atts['number_font_size'] ) ) {
					$styles[] = 'font-size: ' . $atts['number_font_size'];
				} else {
					$styles[] = 'font-size: ' . intval( $atts['number_font_size'] ) . 'px';
				}
			}

			return $styles;
		}

		private function get_title_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['title_color'] ) ) {
				$styles[] = 'color: ' . $atts['title_color'];
			}

			if ( '' !== $atts['title_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['title_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['title_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['title_margin_top'] ) . 'px';
				}
			}

			return $styles;
		}

		private function get_text_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			if ( '' !== $atts['text_font_size'] ) {
				if ( qode_framework_string_ends_with_typography_units( $atts['text_font_size'] ) ) {
					$styles[] = 'font-size: ' . $atts['text_font_size'];
				} else {
					$styles[] = 'font-size: ' . intval( $atts['text_font_size'] ) . 'px';
				}
			}

			if ( '' !== $atts['text_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['text_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['text_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['text_margin_top'] ) . 'px';
				}
			}

			return $styles;
		}
	}
}
