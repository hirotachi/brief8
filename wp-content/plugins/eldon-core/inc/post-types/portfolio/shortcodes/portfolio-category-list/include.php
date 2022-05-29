<?php

include_once ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-category-list/class-eldoncore-portfolio-category-list-shortcode.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-category-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
