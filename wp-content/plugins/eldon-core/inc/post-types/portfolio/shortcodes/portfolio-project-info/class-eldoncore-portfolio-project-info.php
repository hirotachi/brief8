<?php

if ( ! function_exists( 'eldon_core_add_portfolio_project_info_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_project_info_shortcode( $shortcodes ) {
		$shortcodes[] = 'EldonCore_Portfolio_Project_Info_Shortcode';

		return $shortcodes;
	}

	add_filter( 'eldon_core_filter_register_shortcodes', 'eldon_core_add_portfolio_project_info_shortcode' );
}

if ( class_exists( 'EldonCore_Shortcode' ) ) {
	class EldonCore_Portfolio_Project_Info_Shortcode extends EldonCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'eldon_core_filter_portfolio_project_info_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( ELDON_CORE_CPT_URL_PATH . '/portfolio/shortcodes/portfolio-project-info' );
			$this->set_base( 'eldon_core_portfolio_project_info' );
			$this->set_name( esc_html__( 'Portfolio Project Info', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Shortcode that display list of category items', 'eldon-core' ) );
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
					'field_type' => 'select',
					'name'       => 'portfolio_id',
					'title'      => esc_html__( 'Portfolio Item', 'eldon-core' ),
					'options'    => qode_framework_get_cpt_items( 'portfolio-item', '', true ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'project_info_type',
					'title'      => esc_html__( 'Project Info Type', 'eldon-core' ),
					'options'    => array(
						'title'      => esc_html__( 'Title', 'eldon-core' ),
						'categories' => esc_html__( 'Category', 'eldon-core' ),
						'tags'       => esc_html__( 'Tag', 'eldon-core' ),
						'author'     => esc_html__( 'Author', 'eldon-core' ),
						'date'       => esc_html__( 'Date', 'eldon-core' ),
						'image'      => esc_html__( 'Featured Image', 'eldon-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'project_info_label',
					'title'       => esc_html__( 'Project Info Label', 'eldon-core' ),
					'description' => esc_html__( 'Add project info label before project info element/s', 'eldon-core' ),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['project_id']     = ! empty( $atts['portfolio_id'] ) ? $atts['portfolio_id'] : get_the_ID();
			$atts['this_shortcode'] = $this;

			return eldon_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-project-info', 'templates/content', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-portfolio-project-info';

			return implode( ' ', $holder_classes );
		}
	}
}
