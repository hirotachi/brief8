<?php if ( ! empty( $tagline ) ) { ?>
	<div class="qodef-m-tagline">
		<?php echo qode_framework_wp_kses_html( 'content', $tagline ); ?>
	</div>
<?php } ?>
