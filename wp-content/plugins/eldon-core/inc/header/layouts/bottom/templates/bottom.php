<div class="qodef-header-logo">
	<?php
	// Include logo
	eldon_core_get_header_logo_image();
	?>
</div>
<?php

// Include main navigation
eldon_core_template_part( 'header', 'templates/parts/navigation' );

// Include widget area one
eldon_core_get_header_widget_area();
