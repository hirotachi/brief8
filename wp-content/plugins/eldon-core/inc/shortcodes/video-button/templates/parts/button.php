<?php if ( ! empty( $video_link ) ) { ?>
	<a itemprop="url" class="qodef-m-play qodef-magnific-popup qodef-popup-item" <?php echo qode_framework_get_inline_style( $play_button_styles ); ?> href="<?php echo esc_url( $video_link ); ?>" data-type="iframe">
		<span class="qodef-m-play-inner">
			<?php
			eldon_render_svg_icon( 'play-triangle', 'qodef-play-icon qodef-play-icon--full' );
			eldon_render_svg_icon( 'play-triangle', 'qodef-play-icon qodef-play-icon--outline' );
			?>
		</span>
	</a>
<?php } ?>
