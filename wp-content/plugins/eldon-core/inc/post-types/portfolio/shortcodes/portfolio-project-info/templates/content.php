<div class="qodef-portfolio-project-info">
	<?php
	// Include title
	eldon_core_template_part( 'post-types/portfolio/shortcodes/portfolio-project-info', 'templates/parts/label', '', $params );

	// Include info
	eldon_core_template_part( 'post-types/portfolio/shortcodes/portfolio-project-info', 'templates/parts/' . $params['project_info_type'], '', $params );
	?>
</div>
