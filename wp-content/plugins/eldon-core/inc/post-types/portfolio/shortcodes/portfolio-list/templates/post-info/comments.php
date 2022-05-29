<?php if ( comments_open() ) { ?>
	<a itemprop="url" href="<?php comments_link(); ?>" class="qodef-e-info-comments-link">
		<?php comments_number( '0 ' . esc_html__( 'Comments', 'eldon-core' ), '1 ' . esc_html__( 'Comment', 'eldon-core' ), '% ' . esc_html__( 'Comments', 'eldon-core' ) ); ?>
	</a><div class="qodef-info-separator-end"></div>
<?php } ?>
