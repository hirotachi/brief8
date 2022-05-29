<?php

if ( ! function_exists( 'eldon_core_add_custom_font_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function eldon_core_add_custom_font_widget( $widgets ) {
		$widgets[] = 'EldonCore_Custom_Font_Widget';

		return $widgets;
	}

	add_filter( 'eldon_core_filter_register_widgets', 'eldon_core_add_custom_font_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class EldonCore_Custom_Font_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'eldon_core_custom_font',
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'eldon_core_custom_font' );
				$this->set_name( esc_html__( 'Eldon Custom Font', 'eldon-core' ) );
				$this->set_description( esc_html__( 'Add a custom font element into widget areas', 'eldon-core' ) );
			}
		}

		public function render( $atts ) {
			echo EldonCore_Custom_Font_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
