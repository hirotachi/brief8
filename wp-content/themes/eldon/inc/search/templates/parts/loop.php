<?php

if ( have_posts() ) {
	while ( have_posts() ) :
		the_post();

		// Hook to include additional content before search item
		do_action( 'eldon_action_before_search_item' );

		// Include post item
		echo apply_filters( 'eldon_filter_search_item_template', eldon_get_template_part( 'search', 'templates/parts/post' ), get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// Hook to include additional content after search item
		do_action( 'eldon_action_after_search_item' );

	endwhile; // End of the loop.
} else {
	// Include global posts not found
	eldon_template_part( 'content', 'templates/parts/posts-not-found' );
}

wp_reset_postdata();
