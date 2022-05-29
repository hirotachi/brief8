<?php

if ( ! function_exists( 'eldon_core_add_single_image_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param $shortcodes array
	 *
	 * @return array
	 */
	function eldon_core_add_single_image_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Single_Image_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_single_image_shortcode' );
}

if ( class_exists( 'EldonCore_Shortcode' ) ) {
	class EldonCore_Single_Image_Shortcode extends EldonCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'eldon_core_filter_single_image_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'eldon_core_filter_single_image_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_SHORTCODES_URL_PATH . '/single-image' );
			$this->set_base( 'eldon_core_single_image' );
			$this->set_name( esc_html__( 'Single Image', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds image element', 'eldon-core' ) );
			$this->set_category( esc_html__( 'Eldon Core', 'eldon-core' ) );
			$this->set_scripts(
				array(
					'jquery-magnific-popup' => array(
						'registered' => true,
					),
				)
			);
			$this->set_necessary_styles(
				array(
					'magnific-popup' => array(
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
					'field_type' => 'image',
					'name'       => 'image',
					'title'      => esc_html__( 'Image', 'eldon-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'image_size',
					'title'       => esc_html__( 'Image Size', 'eldon-core' ),
					'description' => esc_html__( 'For predefined image sizes input thumbnail, medium, large or full. If you wish to set a custom image size, type in the desired image dimensions in pixels (e.g. 400x400).', 'eldon-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'image_action',
					'title'      => esc_html__( 'Image Action', 'eldon-core' ),
					'options'    => array(
						''            => esc_html__( 'No Action', 'eldon-core' ),
						'open-popup'  => esc_html__( 'Open Popup', 'eldon-core' ),
						'custom-link' => esc_html__( 'Custom Link', 'eldon-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link',
					'title'      => esc_html__( 'Custom Link', 'eldon-core' ),
					'dependency' => array(
						'show' => array(
							'image_action' => array(
								'values'        => array( 'custom-link' ),
								'default_value' => '',
							),
						),
					),
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
						'show' => array(
							'image_action' => array(
								'values'        => 'custom-link',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'shake_animation',
					'title'      => esc_html__( 'Enable Shake Animation', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'no_yes', false),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'mouse_control',
					'title'      => esc_html__( 'Enable Mouse Control', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'no_yes', false),
				)
			);
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'eldon_core_single_image', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {

			if ( isset( $atts['image_action'] ) && 'open-popup' === $atts['image_action'] ) {
				wp_enqueue_style( 'magnific-popup' );
				wp_enqueue_script( 'jquery-magnific-popup' );
			}
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();
			
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			$atts['image_params']   = $this->generate_image_params( $atts );
			$atts['data_attrs']     = $this->get_data_attrs( $atts );

			return eldon_core_get_template_part( 'shortcodes/single-image', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-single-image';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] =  'yes' === $atts['shake_animation'] ? 'qodef--shake-animation' : '';
			$holder_classes[] =  'yes' === $atts['mouse_control'] ? 'qodef--mouse-control-holder' : '';

			return implode( ' ', $holder_classes );
		}
		
		private function get_item_classes( $atts ) {
			$item_classes = array();
			
			$item_classes[] = 'qodef-m-image';
			$item_classes[] =  'yes' === $atts['mouse_control'] ? 'qodef--mouse-control-item' : '';
			
			return implode( ' ', $item_classes );
		}
		
		private function get_data_attrs( $atts ) {
			$data = array();
			
			if ( 'yes' === $atts['mouse_control'] ) {
				$data['data-move-limit'] = 30;
			}
			
			return $data;
		}

		private function generate_image_params( $atts ) {
			$image = array();

			if ( ! empty( $atts['image'] ) ) {
				$id = $atts['image'];

				$image['image_id'] = intval( $id );
				$image_original    = wp_get_attachment_image_src( $id, 'full' );
				$image['url']      = $image_original[0];
				$image['alt']      = get_post_meta( $id, '_wp_attachment_image_alt', true );

				$image_size = trim( $atts['image_size'] );
				preg_match_all( '/\d+/', $image_size, $matches ); /* check if numeral width and height are entered */
				if ( in_array( $image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) ) {
					$image['image_size'] = $image_size;
				} elseif ( ! empty( $matches[0] ) ) {
					$image['image_size'] = array(
						$matches[0][0],
						$matches[0][1],
					);
				} else {
					$image['image_size'] = 'full';
				}
			}

			return $image;
		}
	}
}
