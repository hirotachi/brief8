<?php
$author           = get_post_meta( get_the_ID(), 'qodef_testimonials_author', true );
$author_signature = get_post_meta( get_the_ID(), 'qodef_testimonials_author_signature_svg_path', true );

if ( ! empty( $author ) ) { ?>
	<div class="qodef-e-author">
		<span class="qodef-e-author-name"><?php echo esc_html( $author ); ?></span>
	</div>
	<?php if ( ! empty( $author_signature ) ) { ?>
		<div class="qodef-e-author-signature">
			<?php echo $author_signature; ?>
		</div>
	<?php }
} ?>
