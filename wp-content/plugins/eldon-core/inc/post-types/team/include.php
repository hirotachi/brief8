<?php

include_once ELDON_CORE_CPT_PATH . '/team/helper.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/team/dashboard/admin/*.php' ) as $module ) {
	include_once $module;
}

foreach ( glob( ELDON_CORE_CPT_PATH . '/team/dashboard/meta-box/*.php' ) as $module ) {
	include_once $module;
}
