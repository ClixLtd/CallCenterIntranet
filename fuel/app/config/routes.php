<?php
return array(
	'_root_'                                                     => 'welcome/index',  // The default route
	'_404_'                                                      => 'welcome/404',    // The main 404 route
	
	
	'reports/change_office/:lead/:office'                        => 'reports/change_office',
	'reports/change_resolve_office/:lead/:office'                => 'reports/change_resolve_office',
	
	'dialler/campaign/liveview/(:string)/:showtime'              => 'dialler/campaign/liveview/$1',
	'dialler/campaign/liveview/(:string)'                        => 'dialler/campaign/liveview/$1',
	
	
	'heartbeat/server_stats/(:string)/:showtime'                 => 'heartbeat/server_stats/$1',
	'heartbeat/server_stats/(:string)'                           => 'heartbeat/server_stats/$1',
	
	'reports/disposition/center/:center/:startdate/:enddate'     => 'reports/disposition',
	'reports/disposition/center/:center/:startdate'              => 'reports/disposition',
	'reports/disposition/center/:center'                         => 'reports/disposition',
	'reports/disposition/:startdate/:enddate'                    => 'reports/disposition',
	'reports/disposition/:startdate'                             => 'reports/disposition',
	
	'reports/dispositions/center/:center/:startdate/:enddate'    => 'reports/dispositions',
	'reports/dispositions/center/:center/:startdate'             => 'reports/dispositions',
	'reports/dispositions/center/:center'                        => 'reports/dispositions',
	'reports/dispositions/:startdate/:enddate'                   => 'reports/dispositions',
	'reports/dispositions/:startdate'                            => 'reports/dispositions',
	
	'reports/commission/center/:center/:startdate/:enddate'      => 'reports/commission',
	'reports/commission/center/:center/:startdate'               => 'reports/commission',
	'reports/commission/center/:center'                          => 'reports/commission',
	'reports/commission/:startdate/:enddate'                     => 'reports/commission',
	'reports/commission/:startdate'                              => 'reports/commission',
	
	'reports/dispositiontest/center/:center/:startdate/:enddate' => 'reports/dispositiontest',
	'reports/dispositiontest/center/:center/:startdate'          => 'reports/dispositiontest',
	'reports/dispositiontest/center/:center'                     => 'reports/dispositiontest',
	'reports/dispositiontest/:startdate/:enddate'                => 'reports/dispositiontest',
	'reports/dispositiontest/:startdate'                         => 'reports/dispositiontest',
	
	
	'dialler/api/get_telesales_report_period/(:center)/:month'   => 'dialler/api/get_telesales_report_period/$1',
	'dialler/api/get_telesales_report_period/(:center)'          => 'dialler/api/get_telesales_report_period/$1',
	'dialler/api/get_telesales_report_period'                    => 'dialler/api/get_telesales_report_period',
	
	'reports/get_telesales_report/(:center)/:month'              => 'reports/get_telesales_report/$1',
	'reports/get_telesales_report/(:center)'                     => 'reports/get_telesales_report/$1',
	'reports/get_telesales_report'                               => 'reports/get_telesales_report',

	//Hot keyed  Report 
	'reports/get_hotkey_report/agent/(:agent)/:startdate/:enddate'	=> 'reports/get_hotkey_report',
	'reports/get_hotkey_report/agent/(:agent)/:startdate'			=> 'reports/get_hotkey_report',
	'reports/get_hotkey_report/agent/(:agent)'                     	=> 'reports/get_hotkey_report',
	'reports/get_hotkey_report/:startdate/:enddate'              	=> 'reports/get_hotkey_report',
	'reports/get_hotkey_report/:startdate'                       	=> 'reports/get_hotkey_report',

	//dialer report outcome
	'reports/get_dialler_report/:startdate/:enddate'              => 'reports/get_dialler_report',
	'reports/get_dialler_report/:startdate'                       => 'reports/get_dialler_report',
	
	'reports/get_senior_report/(:center)/:month'                 => 'reports/get_senior_report/$1',
	'reports/get_senior_report/(:center)'                        => 'reports/get_senior_report/$1',
	'reports/get_senior_report'                                  => 'reports/get_senior_report',

	'reports/get_monthly_payment/(:center)/:month'               => 'reports/get_monthly_payment/$1',
	'reports/get_monthly_payment/(:center)'                      => 'reports/get_monthly_payment/$1',
	'reports/get_monthly_payment'                                => 'reports/get_monthly_payment',

	
	'reports/supplier/fulllist/:listid'                          => 'reports/supplier',
	'reports/supplier/(:num)'                                    => 'reports/supplier/$1',
	
	
	'database/query/(:num)'                                      => 'database/query/index/$1',
	'database/query/tag/:tag'                                    => 'database/query/index',
	'database/query/(:num)/tag/:tag'                             => 'database/query/index/$1',
	'database/query/run/(:num)/:format'                          => 'database/query/run/$1',

	'clientarea/documents/view/(:num)'							=> 'clientarea/document_view/$1',
	
	
	
	'hello(/:name)?' => array('welcome/hello', 'name'            => 'hello'),
);