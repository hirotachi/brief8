<div <?php qode_framework_class_attribute( $holder_classes ); ?> >
	<?php if ( ! empty( $moving_text ) ) { ?>
		<div class="qodef-moving-text">
			<span><?php echo wp_kses_post( $moving_text ); ?></span>
		</div>
	<?php } ?>
	<div class="qodef-portfolio-list-horizontal-inner">
	<?php if ( ! empty( $title ) || ! empty( $outlined_title ) ) { ?>
		<div class="qodef-ptfh-static">
			<div class="qodef-ptfh-title-holder">
				<span class="qodef-ptfh-outlined-title"><?php echo esc_attr( $outlined_title ); ?></span>
				<h3 class="qodef-ptfh-title">
					<span><?php echo qode_framework_wp_kses_html( 'content', $title ); ?></span>
				</h3>
				<?php if ( ! empty( $button_link ) ) { ?>
					<a href="<?php echo esc_url( $button_link ); ?>" class="qodef-ptfh-button">
					<?php
					eldon_render_svg_icon( 'slider-arrow-right', 'qodef-icon-outlined' );
					eldon_render_svg_icon( 'slider-arrow-right', 'qodef-icon-filled' );
					?>
					</a>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
		<?php
		eldon_core_template_part( 'post-types/portfolio/shortcodes/portfolio-horizontal', 'templates/loop', '', $params );
		?>
	</div>
</div>
