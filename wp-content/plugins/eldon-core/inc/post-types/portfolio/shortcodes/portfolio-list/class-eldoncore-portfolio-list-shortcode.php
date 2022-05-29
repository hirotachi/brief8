<?php

if ( ! function_exists( 'eldon_core_add_portfolio_list_shortcode' ) ) {
	/**
	 * Function that isadding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Portfolio_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_portfolio_list_shortcode' );
}

if ( class_exists( 'EldonCore_List_Shortcode' ) ) {
	class EldonCore_Portfolio_List_Shortcode extends EldonCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'portfolio-item' );
			$this->set_post_type_taxonomy( 'portfolio-category' );
			$this->set_post_type_additional_taxonomies( array( 'portfolio-tag' ) );
			$this->set_layouts( apply_filters( 'eldon_core_filter_portfolio_list_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'eldon_core_filter_portfolio_list_extra_options', array() ) );
			$this->set_hover_animation_options( apply_filters( 'eldon_core_filter_portfolio_list_hover_animation_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_CPT_URL_PATH . '/portfolio/shortcodes/portfolio-list' );
			$this->set_base( 'eldon_core_portfolio_list' );
			$this->set_name( esc_html__( 'Portfolio List', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of portfolios', 'eldon-core' ) );
			$this->set_category( esc_html__( 'Eldon Core', 'eldon-core' ) );
			$this->set_scripts( apply_filters( 'eldon_core_filter_portfolio_list_register_assets', array() ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'eldon-core' ),
				)
			);
			$this->map_list_options();
			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->map_layout_options(
				array(
					'layouts'          => $this->get_layouts(),
					'hover_animations' => $this->get_hover_animation_options(),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'custom_padding',
					'title'         => esc_html__( 'Use Item Custom Padding', 'eldon-core' ),
					'description'   => esc_html__( 'If you set this option to “Yes”, the padding values defined in the Portfolio Item Custom Padding field will be applied', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'no_yes', false ),
					'default_value' => 'no',
					'dependency'    => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns', 'masonry' ),
								'default_value' => 'columns',
							),
						),
					),
					'group'         => esc_html__( 'Layout', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'enable_border',
					'title'      => esc_html__( 'Enable Border', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'no_yes' ),
					'dependency' => array(
						'show' => array(
							'layout' => array(
								'values'        => array( 'info-follow' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Layout', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'enable_arrow',
					'title'      => esc_html__( 'Enable Arrow', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'no_yes' ),
					'dependency' => array(
						'show' => array(
							'layout' => array(
								'values'        => array( 'info-follow' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Layout', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'blur_image',
					'title'      => esc_html__( 'Blur image', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'no_yes', false ),
					'dependency' => array(
						'show' => array(
							'layout' => array(
								'values'        => array( 'info-follow', 'info-on-hover','info-on-hover-simple', 'info-on-image' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Layout', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'tilt_image',
					'title'      => esc_html__( 'Tilt image', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'no_yes' ),
					'dependency' => array(
						'show' => array(
							'layout' => array(
								'values'        => array( 'info-follow' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Layout', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'slider_reverse_direction',
					'title'         => esc_html__( 'Reverse Autoplay Direction', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'no_yes' ),
					'default_value' => 'no',
					'dependency'    => array(
						'hide' => array(
							'slider_autoplay' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'custom_slider_behavior',
					'title'         => esc_html__( 'Custom Slider Behavior', 'gracey-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'no_yes' , false),
					'default_value' => 'no',
					'dependency'    => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'slider' ),
								'default_value' => 'columns',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'smiley_hover',
					'title'      => esc_html__( 'Enable Smiley Image Hover', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'yes_no', false ),
					'group'      => esc_html__( 'Layout', 'eldon-core' ),
					'dependency'    => array (
						'hide' => array (
							'layout' => array (
								'values'        => array('info-follow','info-on-hover-simple','info-on-hover'),
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->map_additional_options();
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'eldon_core_portfolio_list', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {
			parent::load_assets();

			do_action( 'eldon_core_action_portfolio_list_load_assets', $this->get_atts() );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			// custom slider override start
			if ( $this->get_single_att( 'custom_slider_behavior' ) === 'yes' ) {
				$this->set_single_att( 'columns', 'auto' );
			}
			// custom slider override end

			$atts = $this->get_atts();

			$atts['post_type']       = $this->get_post_type();
			$atts['taxonomy_filter'] = $this->get_post_type_filter_taxonomy( $atts );

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			$atts['query_result']   = new \WP_Query( eldon_core_get_query_params( $atts ) );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );

			$atts['slider_attr'] = $this->get_slider_data( $atts, array( 'reverseDirection' => isset( $atts['slider_reverse_direction'] ) && 'yes' === $atts['slider_reverse_direction'] ) );
			$atts['data_attr']   = eldon_core_get_pagination_data( ELDON_CORE_REL_PATH, 'post-types/portfolio/shortcodes', 'portfolio-list', 'portfolio', $atts );

			$atts['this_shortcode'] = $this;

			return eldon_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'templates/content', $atts['behavior'], $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-portfolio-list';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-item-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['enable_border'] ) && 'yes' === $atts['enable_border'] ? 'qodef-border-enabled' : '';
			$holder_classes[] = ! empty( $atts['enable_arrow'] ) && 'yes' === $atts['enable_arrow'] ? 'qodef-arrow-enabled' : '';
			$holder_classes[] = ! empty( $atts['blur_image'] ) && 'yes' === $atts['blur_image'] ? 'qodef-image-blurred' : '';
			$holder_classes[] = ! empty( $atts['tilt_image'] ) && 'yes' === $atts['tilt_image'] ? 'qodef-image-tilt' : '';
			$holder_classes[] = ! empty( $atts['mouse_control'] ) &&  'yes' === $atts['mouse_control'] ? 'qodef--mouse-control-holder' : '';
			$holder_classes[] = ! empty( $atts['custom_slider_behavior'] ) &&  'yes' === $atts['custom_slider_behavior'] ? 'qodef--custom-slider-behavior' : '';
			$holder_classes[] = 'yes' === $atts['smiley_hover'] ? 'qodef--smiley-hover' : '';

			$list_classes            = $this->get_list_classes( $atts );
			$hover_animation_classes = $this->get_hover_animation_classes( $atts );
			$holder_classes          = array_merge( $holder_classes, $list_classes, $hover_animation_classes );

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();

			$list_item_classes = $this->get_list_item_classes( $atts );

			$item_classes = array_merge( $item_classes, $list_item_classes );

			return implode( ' ', $item_classes );
		}

		public function get_title_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			return $styles;
		}

		public function get_list_item_style( $atts ) {
			$styles = array();

			if ( isset( $atts['custom_padding'] ) && 'yes' === $atts['custom_padding'] ) {
				$styles[] = 'padding: ' . get_post_meta( get_the_ID(), 'qodef_portfolio_item_padding', true );
			}

			return $styles;
		}
	}
}
