<?php if ( ! post_password_required() ) { ?>
	<div class="qodef-e-read-more">
		<?php
		$button_params = array(
			'link' => get_the_permalink(),
			'text' => esc_html__( 'Read More', 'eldon-core' ),
		);

		echo EldonCore_Button_Shortcode::call_shortcode( $button_params );
		?>
	</div>
<?php } ?>
