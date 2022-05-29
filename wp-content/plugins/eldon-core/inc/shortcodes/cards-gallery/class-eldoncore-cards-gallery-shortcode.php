<?php

if ( ! function_exists( 'eldon_core_add_cards_gallery_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_cards_gallery_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Cards_Gallery_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_cards_gallery_shortcode' );
}

if ( class_exists( 'EldonCore_Shortcode' ) ) {
	class EldonCore_Cards_Gallery_Shortcode extends EldonCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_SHORTCODES_URL_PATH . '/cards-gallery' );
			$this->set_base( 'eldon_core_cards_gallery' );
			$this->set_name( esc_html__( 'Cards Gallery', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds cards gallery holder', 'eldon-core' ) );
			$this->set_category( esc_html__( 'Eldon Core', 'eldon-core' ) );
			$this->set_scripts(
				array(
					'jquery-appear' => array(
						'registered' => true,
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
					'field_type'    => 'select',
					'name'          => 'link_target',
					'title'         => esc_html__( 'Link Target', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'orientation',
					'title'         => esc_html__( 'Info Position', 'eldon-core' ),
					'options'       => array(
						''      => esc_html__( 'Default', 'eldon-core' ),
						'right' => esc_html__( 'Shuffled Right', 'eldon-core' ),
						'left'  => esc_html__( 'Shuffled Left', 'eldon-core' ),
					),
					'default_value' => 'right',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'bundle_animation',
					'title'         => esc_html__( 'Bundle Animation', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'no_yes' ),
					'default_value' => 'no',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'eldon-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'item_link',
							'title'         => esc_html__( 'Link', 'eldon-core' ),
							'default_value' => '',
						),
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Item Image', 'eldon-core' ),
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public function load_assets() {
			wp_enqueue_script( 'jquery-appear' );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return eldon_core_get_template_part( 'shortcodes/cards-gallery', 'templates/cards-gallery', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-cards-gallery';
			$holder_classes[] = ! empty( $atts['orientation'] ) ? 'qodef-orientation--' . $atts['orientation'] : 'qodef-orientation--right';
			$holder_classes[] = isset( $atts['bundle_animation'] ) && 'yes' === $atts['bundle_animation'] ? 'qodef-animation--bundle' : 'qodef-animation--no';

			return implode( ' ', $holder_classes );
		}
	}
}
