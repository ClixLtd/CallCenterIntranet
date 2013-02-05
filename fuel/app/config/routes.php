<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	
	'reports/change_office/:lead/:office' => 'reports/change_office',
	
	'dialler/campaign/liveview/(:string)/:showtime' => 'dialler/campaign/liveview/$1',
	'dialler/campaign/liveview/(:string)' => 'dialler/campaign/liveview/$1',
	
	
	'heartbeat/server_stats/(:string)/:showtime' => 'heartbeat/server_stats/$1',
	'heartbeat/server_stats/(:string)' => 'heartbeat/server_stats/$1',
	
	
	
	'reports/disposition/center/:center/:startdate/:enddate' => 'reports/disposition',
	'reports/disposition/center/:center/:startdate' => 'reports/disposition',
	'reports/disposition/center/:center' => 'reports/disposition',
	'reports/disposition/:startdate/:enddate' => 'reports/disposition',
	'reports/disposition/:startdate' => 'reports/disposition',
	
	'reports/dispositions/center/:center/:startdate/:enddate' => 'reports/dispositions',
	'reports/dispositions/center/:center/:startdate' => 'reports/dispositions',
	'reports/dispositions/center/:center' => 'reports/dispositions',
	'reports/dispositions/:startdate/:enddate' => 'reports/dispositions',
	'reports/dispositions/:startdate' => 'reports/dispositions',
	
	
	
	
	'reports/commission/center/:center/:startdate/:enddate' => 'reports/commission',
	'reports/commission/center/:center/:startdate' => 'reports/commission',
	'reports/commission/center/:center' => 'reports/commission',
	'reports/commission/:startdate/:enddate' => 'reports/commission',
	'reports/commission/:startdate' => 'reports/commission',
	
	'reports/dispositiontest/center/:center/:startdate/:enddate' => 'reports/dispositiontest',
	'reports/dispositiontest/center/:center/:startdate' => 'reports/dispositiontest',
	'reports/dispositiontest/center/:center' => 'reports/dispositiontest',
	'reports/dispositiontest/:startdate/:enddate' => 'reports/dispositiontest',
	'reports/dispositiontest/:startdate' => 'reports/dispositiontest',
	
	
	
	'reports/supplier/fulllist/:listid' => 'reports/supplier',
	'reports/supplier/(:num)' => 'reports/supplier/$1',
	
	
	'database/query/(:num)' => 'database/query/index/$1',
	'database/query/tag/:tag' => 'database/query/index',
	'database/query/(:num)/tag/:tag' => 'database/query/index/$1',
	'database/query/run/(:num)/:format' => 'database/query/run/$1',
	
	
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);