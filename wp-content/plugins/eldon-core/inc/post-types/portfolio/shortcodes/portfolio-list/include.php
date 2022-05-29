<?php

include_once ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/helper.php';
include_once ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/class-eldoncore-portfolio-list-shortcode.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
