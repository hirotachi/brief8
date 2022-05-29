<?php

include_once ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-fullscreen-showcase/class-eldoncore-portfolio-fullscreen-showcase-shortcode.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-fullscreen-showcase/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
