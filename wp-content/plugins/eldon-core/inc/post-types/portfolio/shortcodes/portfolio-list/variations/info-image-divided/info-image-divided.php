<?php

if ( ! function_exists( 'eldon_core_add_portfolio_list_variation_info_image_divided' ) ) {
	function eldon_core_add_portfolio_list_variation_info_image_divided( $variations ) {

		$variations['info-image-divided'] = esc_html__( 'Info Image Divided', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_list_layouts', 'eldon_core_add_portfolio_list_variation_info_image_divided' );
}
