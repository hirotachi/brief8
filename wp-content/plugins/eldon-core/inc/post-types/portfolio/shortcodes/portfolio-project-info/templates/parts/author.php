<?php
$project_post = get_post( $project_id );
$author_id    = $project_post->post_author;
$author       = get_the_author_meta( 'display_name', $author_id );

if ( ! empty( $author ) ) { ?>
	<div class="qodef-e-author"><?php echo esc_html( $author ); ?></div>
	<?php
}
