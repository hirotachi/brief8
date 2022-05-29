<?php

class EldonCore_Minimal_Header extends EldonCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'minimal' );
		$this->set_search_layout( 'fullscreen' );
		$this->default_header_height = 100;

		add_action( 'eldon_action_before_wrapper_close_tag', array( $this, 'fullscreen_menu_template' ) );

		parent::__construct();
	}

	/**
	 * @return EldonCore_Minimal_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function fullscreen_menu_template() {
		$parameters = array(
			'fullscreen_menu_in_grid' => 'yes' === eldon_core_get_post_value_through_levels( 'qodef_fullscreen_menu_in_grid' ),
		);

		eldon_core_template_part( 'fullscreen-menu', 'templates/full-screen-menu', '', $parameters );
	}
}
