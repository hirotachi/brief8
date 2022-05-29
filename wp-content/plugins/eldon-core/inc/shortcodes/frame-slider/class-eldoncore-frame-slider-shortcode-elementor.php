<?php

class EldonCore_Frame_Slider_Shortcode_Elementor extends EldonCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'eldon_core_frame_slider' );

		parent::__construct( $data, $args );
	}
}

eldon_core_get_elementor_widgets_manager()->register_widget_type( new EldonCore_Frame_Slider_Shortcode_Elementor() );
