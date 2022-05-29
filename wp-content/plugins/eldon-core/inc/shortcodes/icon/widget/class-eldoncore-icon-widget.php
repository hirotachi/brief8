<?php

if ( ! function_exists( 'eldon_core_add_icon_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function eldon_core_add_icon_widget( $widgets ) {
		$widgets[] = 'EldonCore_Icon_Widget';

		return $widgets;
	}

	add_filter( 'eldon_core_filter_register_widgets', 'eldon_core_add_icon_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class EldonCore_Icon_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'eldon_core_icon',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'eldon_core_icon' );
				$this->set_name( esc_html__( 'Eldon Icon', 'eldon-core' ) );
				$this->set_description( esc_html__( 'Add a icon element into widget areas', 'eldon-core' ) );
			}
		}

		public function render( $atts ) {
			echo EldonCore_Icon_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
