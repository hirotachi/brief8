<?php

if ( ! function_exists( 'eldon_core_get_portfolio_list_item_url' ) ) {
	/**
	 * Function that return portfolio item link config
	 *
	 * @param int $page_id
	 *
	 * @return array
	 */
	function eldon_core_get_portfolio_list_item_url( $page_id ) {
		$external_link        = get_post_meta( $page_id, 'qodef_portfolio_single_external_link', true );
		$external_link_target = get_post_meta( $page_id, 'qodef_portfolio_single_external_link_target', true );
		$link                 = ! empty( $external_link ) ? $external_link : get_the_permalink();
		$link_target          = ! empty( $external_link_target ) ? $external_link_target : '_self';

		return array(
			'link'   => $link,
			'target' => $link_target,
		);
	}
}

if ( ! function_exists( 'eldon_core_portfolio_include_tilt_scripts' ) ) {
	/**
	 * Function that enqueue modules 3rd party scripts
	 *
	 * @param array $atts
	 */
	function eldon_core_portfolio_include_tilt_scripts( $atts ) {
		
		if ( ($atts['layout'] == 'info-image-divided' && $atts['hover_animation_info-image-divided'] == 'tilt' ) || 'yes' === $atts['tilt_image'] )  {
			wp_enqueue_script( 'tilt');
		}
	}
	
	add_action( 'eldon_core_action_portfolio_list_load_assets', 'eldon_core_portfolio_include_tilt_scripts' );
}

if ( ! function_exists( 'eldon_core_portfolio_register_tilt_scripts' ) ) {
	/**
	 * Function that register modules 3rd party scripts
	 *
	 * @param array $scripts
	 *
	 * @return array
	 */
	function eldon_core_portfolio_register_tilt_scripts( $scripts ) {
		
		$scripts['tilt'] = array(
			'registered'	=> false,
			'url'			=> ELDON_CORE_INC_URL_PATH . '/post-types/portfolio/shortcodes/portfolio-list/assets/js/plugins/tilt.jquery.min.js',
			'dependency'	=> array( 'jquery' )
		);
		
		return $scripts;
	}
	
	add_filter( 'eldon_core_filter_portfolio_list_register_assets', 'eldon_core_portfolio_register_tilt_scripts' );
}
