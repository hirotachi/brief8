<?php
// Load title image template
eldon_core_get_page_title_image();
?>
<div class="qodef-m-content <?php echo esc_attr( eldon_core_get_page_title_content_classes() ); ?>">
	<?php
	// Load breadcrumbs template
	eldon_core_breadcrumbs();
	?>
</div>
