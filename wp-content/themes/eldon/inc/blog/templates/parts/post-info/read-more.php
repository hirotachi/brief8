<?php if ( ! post_password_required() ) { ?>
	<div class="qodef-e-read-more">
		<?php
		if ( eldon_post_has_read_more() ) {
			$button_params = array(
				'link'          => get_permalink() . '#more-' . get_the_ID(),
				'text'          => esc_html__( 'Continue Reading', 'eldon' ),
			);
		} else {
			$button_params = array(
				'link'          => get_the_permalink(),
				'text'          => esc_html__( 'Read More', 'eldon' ),
			);
		}
		?>

		<a class="qodef-button" href="<?php echo esc_url( $button_params['link'] ); ?>" target="_self">
			<span class="qodef-m-text"><?php echo esc_html( $button_params['text'] ); ?></span>
		</a>
	</div>
<?php } ?>
