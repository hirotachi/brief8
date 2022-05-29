<?php $title_tag = isset( $title_tag ) && ! empty( $title_tag ) ? $title_tag : 'p'; ?>
<div <?php qode_framework_class_attribute( $holder_classes ); ?> >
	<?php if ( ! empty( $tagline ) ) { ?>
		<div class="qodef-m-tagline">
			<?php echo qode_framework_wp_kses_html( 'content', $tagline ); ?>
		</div>
	<?php } ?>
	<<?php echo esc_attr( $title_tag ); ?> class="qodef-custom-font-content" <?php qode_framework_inline_style( $holder_styles ); ?>><?php echo qode_framework_wp_kses_html( 'content', $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
</div>