<?php if ( class_exists( 'EldonCore_Social_Share_Shortcode' ) ) { ?>
	<div class="qodef-e-info-item qodef-e-info-social-share">
		<?php
		$params           = array();
		$params['layout'] = 'text';
		if ( isset( $title ) && ! empty( $title ) ) {
			$params['title'] = $title;
		}

		echo EldonCore_Social_Share_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>
