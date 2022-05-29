<div class="qodef-e-media">
	<?php
	switch ( get_post_format() ) {
		case 'gallery':
			eldon_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			eldon_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			eldon_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			eldon_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?>
</div>
