<?php

foreach ( glob( ELDON_CORE_PLUGINS_PATH . '/*/include.php' ) as $module ) {
	include_once $module;
}