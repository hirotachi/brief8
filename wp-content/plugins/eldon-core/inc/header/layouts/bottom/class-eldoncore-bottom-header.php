<?php

class EldonCore_Bottom_Header extends EldonCore_Header {
	private static $instance;

	public function __construct() {
		$header_menu_position = $this->get_menu_position();

		$this->set_layout( 'bottom' );
		if ( 'center' === $header_menu_position ) {
			$this->set_layout_slug( 'centered' );
		}

		$this->set_search_layout( 'covers-header' );
		$this->default_header_height = 100;

		add_filter( 'body_class', array( $this, 'add_body_classes' ) );

		parent::__construct();
	}

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function add_body_classes( $classes ) {
		$header_menu_position = eldon_core_get_post_value_through_levels( 'qodef_bottom_header_menu_position' );
		$header_border        = eldon_core_get_post_value_through_levels( 'qodef_bottom_header_border' );

		$classes[] = ! empty( $header_menu_position ) ? 'qodef-header-bottom--' . $header_menu_position : '';
		$classes[] = 'yes' === $header_border ? 'qodef-header-bottom--border' : '';

		return $classes;
	}

	function get_menu_position() {
		return eldon_core_get_post_value_through_levels( 'qodef_bottom_header_menu_position' );
	}
}
