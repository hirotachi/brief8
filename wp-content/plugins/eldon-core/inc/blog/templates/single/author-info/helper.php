<?php

if ( ! function_exists( 'eldon_core_include_blog_single_author_info_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function eldon_core_include_blog_single_author_info_template() {
		if ( is_single() ) {
			include_once ELDON_CORE_INC_PATH . '/blog/templates/single/author-info/templates/author-info.php';
		}
	}

	add_action( 'eldon_action_after_blog_post_item', 'eldon_core_include_blog_single_author_info_template', 20 );  // permission 20 is set to define template position
}

if ( ! function_exists( 'eldon_core_get_author_social_networks' ) ) {
	/**
	 * Function which includes author info templates on single posts page
	 */
	function eldon_core_get_author_social_networks( $user_id ) {
		$icons           = array();
		$social_networks = array(
			'facebook'  => 'Fb.',
			'instagram' => 'Ig.',
			'twitter'   => 'Tw.',
			'linkedin'  => 'Lnkd.',
			'pinterest' => 'Pin.',
		);

		foreach ( $social_networks as $network => $abbreviation ) {
			$network_meta = get_the_author_meta( 'qodef_user_' . $network, $user_id );

			if ( ! empty( $network_meta ) ) {
				$$network = array(
					'url'          => $network_meta,
					'abbreviation' => $abbreviation,
					'class'        => 'qodef-user-social-' . $network,
				);

				$icons[ $network ] = $$network;
			}
		}

		return $icons;
	}
}
