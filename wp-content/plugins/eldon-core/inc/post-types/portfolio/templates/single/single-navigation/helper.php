<?php

if ( ! function_exists( 'eldon_core_include_portfolio_single_post_navigation_template' ) ) {
	/**
	 * Function which includes additional module on single portfolio page
	 */
	function eldon_core_include_portfolio_single_post_navigation_template() {
		eldon_core_template_part( 'post-types/portfolio', 'templates/single/single-navigation/templates/single-navigation' );
	}

	add_action( 'eldon_core_action_after_portfolio_single_item', 'eldon_core_include_portfolio_single_post_navigation_template' );
}
