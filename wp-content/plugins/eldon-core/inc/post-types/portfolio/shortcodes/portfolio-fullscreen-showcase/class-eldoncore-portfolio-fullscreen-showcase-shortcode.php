<?php

if ( ! function_exists( 'eldon_core_add_portfolio_fullscreen_showcase_shortcode' ) ) {
	/**
	 * Function that is adding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_fullscreen_showcase_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Portfolio_Fullscreen_Showcase_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_portfolio_fullscreen_showcase_shortcode' );
}

if ( class_exists( 'EldonCore_List_Shortcode' ) ) {
	class EldonCore_Portfolio_Fullscreen_Showcase_Shortcode extends EldonCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'portfolio-item' );
			$this->set_post_type_taxonomy( 'portfolio-category' );
			$this->set_post_type_additional_taxonomies( array( 'portfolio-tag' ) );
			$this->set_layouts( apply_filters( 'eldon_core_filter_portfolio_fullscreen_showcase_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_CPT_URL_PATH . '/portfolio/shortcodes/portfolio-fullscreen-showcase' );
			$this->set_base( 'eldon_core_portfolio_fullscreen_showcase' );
			$this->set_name( esc_html__( 'Portfolio Fullscreen Showcase', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays fullscreen list of portfolios', 'eldon-core' ) );
			$this->set_category( esc_html__( 'Eldon Core', 'eldon-core' ) );
			$this->set_scripts( apply_filters( 'eldon_core_filter_portfolio_fullscreen_showcase_register_assets', array() ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'eldon-core' ),
				)
			);
			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->map_layout_options(
				array(
					'layouts' => $this->get_layouts(),
				)
			);
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'eldon_core_portfolio_fullscreen_showcase', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {
			parent::load_assets();

			do_action( 'eldon_core_action_portfolio_fullscreen_showcase_load_assets', $this->get_atts() );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			$atts['post_type']         = $this->get_post_type();
			$atts['taxonomy_filter']   = $this->get_post_type_filter_taxonomy( $atts );
			$atts['behavior']          = 'slider';
			$atts['slider_navigation'] = 'no';
			$atts['slider_pagination'] = 'yes';
			$atts['images_proportion'] = 'full';

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			$atts['query_result']   = new \WP_Query( eldon_core_get_query_params( $atts ) );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['slider_attr']    = $this->get_fullscreen_slider_data( $atts );

			$atts['this_shortcode'] = $this;

			return eldon_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-fullscreen-showcase', 'templates/content', 'slider', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-portfolio-fullscreen-showcase';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-item-layout--' . $atts['layout'] : '';

			$list_classes   = $this->get_list_classes( $atts );
			$holder_classes = array_merge( $holder_classes, $list_classes );

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

		private function get_fullscreen_slider_data( $atts ) {
			$params = array();

			if ( 'inverted-color-title' === $atts['layout'] ) {
				$params['customStages']      = true;
				$params['slidesPerView1440'] = 2;
				$params['slidesPerView1366'] = 2;
				$params['slidesPerView1024'] = 2;
				$params['slidesPerView768']  = 1;
				$params['slidesPerView680']  = 1;
				$params['slidesPerView480']  = 1;
				$atts['columns']             = 2;
			} else {
				$params['effect']  = 'fade';
			}

			return $this->get_slider_data( $atts, $params );
		}
	}
}
