<?php

class EldonCore_Minimal_Mobile_Header extends EldonCore_Mobile_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'minimal' );
		$this->default_header_height = 70;

		add_action( 'eldon_action_before_wrapper_close_tag', array( $this, 'fullscreen_menu_template' ) );

		add_filter( 'eldon_core_filter_available_mobile_header_logo_images', array( $this, 'set_logo_image' ) );

		parent::__construct();
	}

	/**
	 * @return EldonCore_Minimal_Mobile_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function fullscreen_menu_template() {
		$header = eldon_core_get_post_value_through_levels( 'qodef_header_layout' );

		if ( 'minimal' !== $header && 'vertical-minimal' !== $header ) {
			$parameters = array(
				'fullscreen_menu_in_grid' => 'yes' === eldon_core_get_post_value_through_levels( 'qodef_fullscreen_menu_in_grid' ),
			);

			eldon_core_template_part( 'fullscreen-menu', 'templates/full-screen-menu', '', $parameters );
		}
	}

	function set_logo_image( $available_logo_images ) {
		$available_logo_images = array_merge(
			$available_logo_images,
			array(
				'dark'  => 'dark',
				'light' => 'dark',
			)
		);

		return $available_logo_images;
	}
}
