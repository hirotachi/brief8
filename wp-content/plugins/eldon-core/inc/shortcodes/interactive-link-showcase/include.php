<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/interactive-link-showcase/class-eldoncore-interactive-link-showcase-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/interactive-link-showcase/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
