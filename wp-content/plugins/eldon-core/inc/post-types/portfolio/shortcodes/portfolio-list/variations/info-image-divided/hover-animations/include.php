<?php

include_once ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/variations/info-image-divided/hover-animations/hover-animations.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/variations/info-image-divided/hover-animations/*/include.php' ) as $animation ) {
	include_once $animation;
}
