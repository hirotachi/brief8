<?php

if ( ! function_exists( 'eldon_core_add_portfolio_horizontal_shortcode' ) ) {
	/**
	 * Function that is adding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_horizontal_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Portfolio_Horizontal_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_portfolio_horizontal_shortcode' );
}

if ( ! function_exists( 'qodef_portfolio_horizontal_classes' ) ) {
	function qodef_portfolio_horizontal_classes( $classes ) {

		$classes[] = 'qodef-portfolio-list-horizontal-holder';

		return $classes;

	}
}

if ( class_exists( 'EldonCore_List_Shortcode' ) ) {
	class EldonCore_Portfolio_Horizontal_Shortcode extends EldonCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'portfolio-item' );
			$this->set_post_type_taxonomy( 'portfolio-category' );
			$this->set_post_type_additional_taxonomies( array( 'portfolio-tag' ) );
			$this->set_layouts( apply_filters( 'eldon_core_filter_portfolio_horizontal_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'eldon_core_filter_portfolio_horizontal_extra_options', array() ) );
			$this->set_hover_animation_options( apply_filters( 'eldon_core_filter_portfolio_list_hover_animation_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_CPT_URL_PATH . '/portfolio/shortcodes/portfolio-horizontal' );
			$this->set_base( 'eldon_core_portfolio_horizontal' );
			$this->set_name( esc_html__( 'Horizontal Portfolio', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays scattered list of up to 10 portfolios', 'eldon-core' ) );
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
					'field_type' => 'textfield',
					'name'       => 'outlined_title',
					'title'      => esc_html__( 'Outlined Title', 'eldon-core' ),
					'group'      => esc_html__( 'Static Content', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'title',
					'title'      => esc_html__( 'Title', 'eldon-core' ),
					'group'      => esc_html__( 'Static Content', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'title_extra_light_words',
					'title'       => esc_html__( 'Title Thin Words', 'eldon-core' ),
					'description' => esc_html__( 'Enter the positions of the words you would like to display in extra light font weight. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have highlight style, you would enter "1,3,4")', 'eldon-core' ),
					'group'       => esc_html__( 'Static Content', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'enable_appear',
					'title'         => esc_html__( 'Appear Title Animation', 'eldon-core' ),
					'options'       => eldon_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'yes',
					'group'         => esc_html__( 'Static Content', 'eldon-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'button_link',
					'title'      => esc_html__( 'Button link', 'eldon-core' ),
					'group'      => esc_html__( 'Static Content', 'eldon-core' ),
				)
			);

			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );

			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'moving_text',
					'title'      => esc_html__( 'Moving Text', 'eldon-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'moving_text_thin_words',
					'title'       => esc_html__( 'Moving Text Thin Words', 'eldon-core' ),
					'description' => esc_html__( 'Enter the positions of the words you would like to display in thin font weight. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have highlight style, you would enter "1,3,4")', 'eldon-core' ),
				)
			);
			
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'smiley_hover',
					'title'      => esc_html__( 'Enable Smiley Image Hover', 'eldon-core' ),
					'options'    => eldon_core_get_select_type_options_pool( 'yes_no', false ),
					'group'      => esc_html__( 'Layout', 'eldon-core' ),
				)
			);
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'eldon_core_portfolio_horizontal', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {
			parent::load_assets();

			do_action( 'eldon_core_action_portfolio_horizontal_load_assets', $this->get_atts() );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			$atts['post_type']       = $this->get_post_type();
			$atts['taxonomy_filter'] = $this->get_post_type_taxonomy();

			$atts['query_result'] = new \WP_Query( eldon_core_get_query_params( $atts ) );

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			// limiting list to 10 items
			$atts['posts_per_page'] = '10';

			$atts['query_result']   = new \WP_Query( eldon_core_get_query_params( $atts ) );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['slider_attr']    = $this->get_slider_data( $atts );
			$atts['title']          = $this->get_modified_title( $atts );
			$atts['moving_text']    = $this->get_modified_moving_text( $atts );
			$atts['data_attr']      = eldon_core_get_pagination_data( ELDON_CORE_REL_PATH, 'post-types/portfolio/shortcodes', 'portfolio-horizontal', 'portfolio', $atts );

			$atts['this_shortcode'] = $this;

			return eldon_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-horizontal', 'templates/content', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-portfolio-list-horizontal-holder';
			$holder_classes[] = ! empty( $atts['enable_appear'] ) && 'yes' === $atts['enable_appear'] ? 'qodef--has-appear' : '';
			$holder_classes[] = 'yes' === $atts['smiley_hover'] ? 'qodef--smiley-hover' : '';

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();

			$list_item_classes = $this->get_list_item_classes( $atts );

			$item_classes[] = ! empty( $atts['behavior'] ) && 'portfolio-horizontal' === $atts['behavior'] ? 'grid__item-wrap' : 'qodef-grid-item';

			$item_classes = array_merge( $item_classes, $list_item_classes );

			return implode( ' ', $item_classes );
		}

		public function getItemLink() {
			$portfolio_link_meta = get_post_meta( get_the_ID(), 'portfolio_external_link', true );
			$portfolio_link      = ! empty( $portfolio_link_meta ) ? $portfolio_link_meta : get_permalink( get_the_ID() );

			return apply_filters( 'manon_edge_filter_portfolio_external_link', $portfolio_link );
		}

		public function getItemLinkTarget() {
			$portfolio_link_meta   = get_post_meta( get_the_ID(), 'portfolio_external_link', true );
			$portfolio_link_target = ! empty( $portfolio_link_meta ) ? '_blank' : '_self';

			return apply_filters( 'manon_edge_filter_portfolio_external_link_target', $portfolio_link_target );
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

		private function get_modified_title( $atts ) {
			$title = $atts['title'];

			if ( ! empty( $title ) ) {
				$split_title        = explode( ' ', $title );
				$title_italic_words = explode( ',', str_replace( ' ', '', $atts['title_extra_light_words'] ) );

				if ( ! empty( $atts['title_extra_light_words'] ) ) {
					foreach ( $title_italic_words as $value ) {
						if ( ! empty( $split_title[ $value - 1 ] ) ) {
							$split_title[ $value - 1 ] = '<span class="qodef-m-extra-light"><span class="qodef-m-regular-style">' . $split_title[ $value - 1 ] . '</span><span class="qodef-m-extra-light-style">' . $split_title[ $value - 1 ] . '</span></span>';
						}
					}
					
					for ($position = 1; $position < count($split_title) + 1; $position++ ) {
						if (!empty($title_italic_words) && !in_array($position, $title_italic_words)) {
							$split_title[ intval( $position - 1) ] = '<span class="qodef-animated-text-holder"><span class="qodef-animated-text-original">'. $split_title[ intval( $position ) - 1] . '</span><span class="qodef-animated-text-duplicate">'. $split_title[ intval( $position ) - 1] . '</span></span>';
						}
					}
				}

				$title = implode( ' ', $split_title );
			}

			return $title;
		}

		private function get_modified_moving_text( $atts ) {
			$title = $atts['moving_text'];

			if ( ! empty( $title ) ) {
				$split_title        = explode( ' ', $title );
				$title_italic_words = explode( ',', str_replace( ' ', '', $atts['moving_text_thin_words'] ) );

				if ( ! empty( $atts['moving_text_thin_words'] ) ) {
					foreach ( $title_italic_words as $value ) {
						if ( ! empty( $split_title[ $value - 1 ] ) ) {
							$split_title[ $value - 1 ] = '<span class="qodef-m-thin"><span class="qodef-m-regular-style">' . $split_title[ $value - 1 ] . '</span><span class="qodef-m-thin-style">' . $split_title[ $value - 1 ] . '</span></span>';
						}
					}
				}

				$title = implode( ' ', $split_title );
			}

			return $title;
		}
	}
}
