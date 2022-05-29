<?php
$tags = get_the_tags();

if ( $tags ) {
	the_tags( '', ', ' ); ?>
	<div class="qodef-info-separator-end"></div>
<?php } ?>
