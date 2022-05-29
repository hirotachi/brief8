<?php if ( class_exists( 'EldonCore_Social_Share_Shortcode' ) ) { ?>
	<div class="qodef-e qodef-inof--social-share">
		<?php
		$params = array(
			'title'  => esc_html__( 'Share:', 'eldon-core' ),
			'layout' => 'text',
		);

		echo EldonCore_Social_Share_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>
