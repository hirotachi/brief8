<?php

if ( ! function_exists( 'eldon_core_include_blog_single_post_navigation_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function eldon_core_include_blog_single_post_navigation_template() {
		if ( is_single() ) {
			include_once ELDON_CORE_INC_PATH . '/blog/templates/single/single-post-navigation/templates/single-post-navigation.php';
		}
	}

	add_action( 'eldon_action_after_blog_post_item', 'eldon_core_include_blog_single_post_navigation_template', 15 ); // permission 15 is set to define template position
}
