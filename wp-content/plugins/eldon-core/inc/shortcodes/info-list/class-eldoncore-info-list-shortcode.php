<?php

if ( ! function_exists( 'eldon_core_add_info_list_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_info_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Info_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_info_list_shortcode' );
}

if ( class_exists( 'EldonCore_Shortcode' ) ) {
	class EldonCore_Info_List_Shortcode extends EldonCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_SHORTCODES_URL_PATH . '/info-list' );
			$this->set_base( 'eldon_core_info_list' );
			$this->set_name( esc_html__( 'Info List', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds info list element', 'eldon-core' ) );
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
					'name'       => 'title',
					'title'      => esc_html__( 'Title', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'text',
					'title'      => esc_html__( 'Text', 'eldon-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Info List Items', 'eldon-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'info_title',
							'title'         => esc_html__( 'Info Title', 'eldon-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'info_subtitle',
							'title'         => esc_html__( 'Info Subtitle', 'eldon-core' ),
							'default_value' => '',
						),
					),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return eldon_core_get_template_part( 'shortcodes/info-list', 'templates/info-list', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-info-list';

			return implode( ' ', $holder_classes );
		}
	}
}
