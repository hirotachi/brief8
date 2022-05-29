<?php

class EldonCore_Portfolio_Horizontal_Shortcode_Elementor extends EldonCore_Elementor_Widget_Base {

	function __construct( array $data = array(), $args = null ) {
		$this->set_shortcode_slug( 'eldon_core_portfolio_horizontal' );

		parent::__construct( $data, $args );
	}
}

eldon_core_get_elementor_widgets_manager()->register_widget_type( new EldonCore_Portfolio_Horizontal_Shortcode_Elementor() );
