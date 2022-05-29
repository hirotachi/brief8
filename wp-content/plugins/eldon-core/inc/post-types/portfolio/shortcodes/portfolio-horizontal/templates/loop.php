<?php if ( $query_result->have_posts() ) {
	while ( $query_result->have_posts() ) :
		$query_result->the_post();
		$params['image_dimension'] = $this_shortcode->get_list_item_image_dimension( $params );
		$params['item_classes']    = $this_shortcode->get_item_classes( $params );

		eldon_core_template_part( 'post-types/portfolio/shortcodes/portfolio-horizontal', 'templates/portfolio-horizontal-item', '', $params );
	endwhile; // End of the loop.
} else {
	eldon_core_template_part( 'post-types/portfolio/shortcodes/portfolio-horizontal', 'templates/posts-not-found' );
}

wp_reset_postdata();
