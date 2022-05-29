<?php

include_once ELDON_CORE_INC_PATH . '/search/class-eldoncore-search.php';
include_once ELDON_CORE_INC_PATH . '/search/helper.php';
include_once ELDON_CORE_INC_PATH . '/search/dashboard/admin/search-options.php';

foreach ( glob( ELDON_CORE_INC_PATH . '/search/layouts/*/include.php' ) as $layout ) {
	include_once $layout;
}
