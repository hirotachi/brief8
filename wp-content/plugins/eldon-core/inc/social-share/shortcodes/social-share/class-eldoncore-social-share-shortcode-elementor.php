<?php

class EldonCore_Social_Share_Shortcode_Elementor extends EldonCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'eldon_core_social_share' );

		parent::__construct( $data, $args );
	}
}

eldon_core_get_elementor_widgets_manager()->register_widget_type( new EldonCore_Social_Share_Shortcode_Elementor() );
