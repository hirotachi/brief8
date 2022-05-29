<?php

class EldonCore_Product_List_Shortcode_Elementor extends EldonCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'eldon_core_product_list' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	eldon_core_get_elementor_widgets_manager()->register_widget_type( new EldonCore_Product_List_Shortcode_Elementor() );
}
