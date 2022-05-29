<?php

include_once ELDON_CORE_INC_PATH . '/blog/shortcodes/blog-list/class-eldoncore-blog-list-shortcode.php';

foreach ( glob( ELDON_CORE_INC_PATH . '/blog/shortcodes/blog-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
