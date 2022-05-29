<?php

if ( ! function_exists( 'eldon_core_add_social_share_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function eldon_core_add_social_share_widget( $widgets ) {
		$widgets[] = 'EldonCore_Social_Share_Widget';

		return $widgets;
	}

	add_filter( 'eldon_core_filter_register_widgets', 'eldon_core_add_social_share_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class EldonCore_Social_Share_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'eldon_core_social_share',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'eldon_core_social_share' );
				$this->set_name( esc_html__( 'Eldon Social Share', 'eldon-core' ) );
				$this->set_description( esc_html__( 'Add a social share element into widget areas', 'eldon-core' ) );
			}
		}

		public function render( $atts ) {
			echo EldonCore_Social_Share_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
