<?php
$tags = wp_get_post_terms( $project_id, 'portfolio-tag' );

if ( ! empty( $tags ) ) { ?>
	<div class="qodef-e-tag">
		<?php echo get_the_term_list( get_the_ID(), 'portfolio-tag', '', '<span class="qodef-info-separator-single"></span>' ); ?>
	</div>
<?php } ?>
