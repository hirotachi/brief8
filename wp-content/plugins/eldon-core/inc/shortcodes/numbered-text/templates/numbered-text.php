<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<?php eldon_core_template_part( 'shortcodes/numbered-text', 'templates/parts/number', '', $params ); ?>
	<div class="qodef-m-content">
		<?php eldon_core_template_part( 'shortcodes/numbered-text', 'templates/parts/title', '', $params ); ?>
		<?php eldon_core_template_part( 'shortcodes/numbered-text', 'templates/parts/text', '', $params ); ?>
	</div>
</div>
