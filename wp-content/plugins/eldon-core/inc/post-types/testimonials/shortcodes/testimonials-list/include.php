<?php

include_once ELDON_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/class-eldoncore-testimonials-list-shortcode.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
