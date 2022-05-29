<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<?php if ( isset( $title ) && ! empty( $title ) ) { ?>
		<h2 class="qodef-m-info-list-title"><?php echo esc_html( $title ); ?></h2>
	<?php } ?>
	<?php if ( isset( $text ) && ! empty( $text ) ) { ?>
		<p class="qodef-m-info-list-text"><?php echo esc_html( $text ); ?></p>
	<?php } ?>
	<ul class="qodef-m-info-list-content">
	<?php foreach ( $items as $key => $item ) : ?>
		<li class="qodef-m-info-list-item">
			<?php if ( isset( $item['info_title'] ) && ! empty( $item['info_title'] ) ) { ?>
				<h4 class="qodef-m-info-title"><?php echo esc_html( $item['info_title'] ); ?></h4>
			<?php } ?>
			<?php if ( isset( $item['info_subtitle'] ) && ! empty( $item['info_subtitle'] ) ) { ?>
				<p class="qodef-m-info-subtitle"><?php echo esc_html( $item['info_subtitle'] ); ?></p>
			<?php } ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
