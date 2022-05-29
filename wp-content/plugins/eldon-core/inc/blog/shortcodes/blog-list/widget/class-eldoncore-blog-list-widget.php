<?php

if ( ! function_exists( 'eldon_core_add_blog_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function eldon_core_add_blog_list_widget( $widgets ) {
		$widgets[] = 'EldonCore_Blog_List_Widget';

		return $widgets;
	}

	add_filter( 'eldon_core_filter_register_widgets', 'eldon_core_add_blog_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class EldonCore_Blog_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'eldon-core' ),
				)
			);
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'eldon_core_blog_list',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'eldon_core_blog_list' );
				$this->set_name( esc_html__( 'Eldon Blog List', 'eldon-core' ) );
				$this->set_description( esc_html__( 'Display a list of blog posts', 'eldon-core' ) );
			}
		}

		public function render( $atts ) {
			echo EldonCore_Blog_List_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
