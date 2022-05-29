<?php

include_once 'class-eldoncore-portfolio-horizontal-shortcode.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-horizontal/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
