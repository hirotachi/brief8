<?php

if ( ! function_exists( 'eldon_core_add_countdown_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_countdown_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Countdown_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_countdown_shortcode' );
}

if ( class_exists( 'EldonCore_Shortcode' ) ) {
	class EldonCore_Countdown_Shortcode extends EldonCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'eldon_core_filter_countdown_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_SHORTCODES_URL_PATH . '/countdown' );
			$this->set_base( 'eldon_core_countdown' );
			$this->set_name( esc_html__( 'Countdown', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays countdown with provided parameters', 'eldon-core' ) );
			$this->set_category( esc_html__( 'Eldon Core', 'eldon-core' ) );
			$this->set_scripts(
				array(
					'countdown' => array(
						'registered' => false,
						'url'        => ELDON_CORE_INC_URL_PATH . '/shortcodes/countdown/assets/js/plugins/jquery.countdown.min.js',
						'dependency' => array( 'jquery' ),
					),
				)
			);

			$options_map = eldon_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'eldon-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array( 'map_for_page_builder' => $options_map['visibility'] ),
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
					'field_type'  => 'date',
					'name'        => 'date',
					'title'       => esc_html__( 'Date', 'eldon-core' ),
					'description' => esc_html__( 'Format: YYYY/mm/dd', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'date_hour',
					'title'      => esc_html__( 'Hour', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'date_minute',
					'title'      => esc_html__( 'Minute', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'week_label',
					'title'      => esc_html__( 'Week Label', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'week_label_plural',
					'title'      => esc_html__( 'Week Label Plural', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'day_label',
					'title'      => esc_html__( 'Day Label', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'day_label_plural',
					'title'      => esc_html__( 'Day Label Plural', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'hour_label',
					'title'      => esc_html__( 'Hour Label', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'hour_label_plural',
					'title'      => esc_html__( 'Hour Label Plural', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'minute_label',
					'title'      => esc_html__( 'Minute Label', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'minute_label_plural',
					'title'      => esc_html__( 'Minute Label Plural', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'second_label',
					'title'      => esc_html__( 'Second Label', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'second_label_plural',
					'title'      => esc_html__( 'Second Label Plural', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'skin',
					'title'      => esc_html__( 'Skin', 'eldon-core' ),
					'options'    => array(
						''      => esc_html__( 'Default', 'eldon-core' ),
						'light' => esc_html__( 'Light', 'eldon-core' ),
					),
				)
			);
		}

		public function load_assets() {
			wp_enqueue_script( 'countdown' );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['data_attrs']     = $this->get_data_attrs( $atts );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );

			return eldon_core_get_template_part( 'shortcodes/countdown', 'variations/' . $atts['layout'] . '/templates/countdown', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-countdown';
			$holder_classes[] = 'qodef-show--5';

			$holder_classes[] = ! empty( $atts['skin'] ) ? 'qodef-countdown--' . $atts['skin'] : '';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';

			return implode( ' ', $holder_classes );
		}

		private function get_data_attrs( $atts ) {
			$data = array();

			if ( ! empty( $atts['date'] ) ) {
				$date              = $atts['date'];
				$date_formatted    = gmdate( 'Y/m/d', strtotime( $date ) );
				$hour              = ! empty( $atts['date_hour'] ) ? $atts['date_hour'] : '00';
				$minute            = ! empty( $atts['date_minute'] ) ? $atts['date_minute'] : '00';
				$date              = $date_formatted . ' ' . $hour . ':' . $minute . ':00';
				$data['data-date'] = $date;
			}

			$date_formats = array(
				'week'   => array(
					'default' => esc_html__( 'Week', 'eldon-core' ),
					'plural'  => esc_html__( 'Weeks', 'eldon-core' ),
				),
				'day'    => array(
					'default' => esc_html__( 'Day', 'eldon-core' ),
					'plural'  => esc_html__( 'Days', 'eldon-core' ),
				),
				'hour'   => array(
					'default' => esc_html__( 'Hour', 'eldon-core' ),
					'plural'  => esc_html__( 'Hours', 'eldon-core' ),
				),
				'minute' => array(
					'default' => esc_html__( 'Minute', 'eldon-core' ),
					'plural'  => esc_html__( 'Minutes', 'eldon-core' ),
				),
				'second' => array(
					'default' => esc_html__( 'Second', 'eldon-core' ),
					'plural'  => esc_html__( 'Seconds', 'eldon-core' ),
				),
			);

			foreach ( $date_formats as $key => $value ) {
				if ( ! empty( $atts[ $key . '_label' ] ) ) {
					$data[ 'data-' . $key . '-label' ] = $atts[ $key . '_label' ];
				} else {
					$data[ 'data-' . $key . '-label' ] = $value['default'];
				}

				if ( ! empty( $atts[ $key . '_label_plural' ] ) ) {
					$data[ 'data-' . $key . '-label-plural' ] = $atts[ $key . '_label_plural' ];
				} else {
					$data[ 'data-' . $key . '-label-plural' ] = $value['plural'];
				}
			}

			return $data;
		}
	}
}
