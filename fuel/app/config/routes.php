<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	
	
	'reports/disposition/center/:center/:startdate/:enddate' => 'reports/disposition',
	'reports/disposition/center/:center/:startdate' => 'reports/disposition',
	'reports/disposition/center/:center' => 'reports/disposition',
	'reports/disposition/:startdate/:enddate' => 'reports/disposition',
	'reports/disposition/:startdate' => 'reports/disposition',
	
	
	'reports/supplier/fulllist/:listid' => 'reports/supplier',
	'reports/supplier/(:num)' => 'reports/supplier/$1',
	
	
	'database/query/(:num)' => 'database/query/index/$1',
	'database/query/tag/:tag' => 'database/query/index',
	'database/query/(:num)/tag/:tag' => 'database/query/index/$1',
	'database/query/run/(:num)/:format' => 'database/query/run/$1',
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);