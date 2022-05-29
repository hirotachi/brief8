<?php if ( ! empty( $title ) ) { ?>
	<<?php echo esc_attr( $title_tag ); ?> class="qodef-m-title" <?php qode_framework_inline_style( $title_styles ); ?>>
		<?php if ( ! empty( $link ) ) : ?>
			<a itemprop="url" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
		<?php endif; ?>
		<?php if ( ! empty( $number ) ) { ?>
			<span class="qodef-m-number"><span><?php echo esc_html( $number ); ?></span><span><?php echo esc_html( $number ); ?></span></span>
		<?php } ?>
			<span class="qodef-m-title-holder"><span><?php echo esc_html( $title ); ?></span><span><?php echo esc_html( $title ); ?></span></span>
		<?php if ( ! empty( $link ) ) : ?>
			</a>
		<?php endif; ?>
	</<?php echo esc_attr( $title_tag ); ?>>
<?php } ?>
