<?php
/**
 * The development database settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=127.0.0.1;dbname=gbs_intranet',
			'username'   => 'vicidial',
			'password'   => 'kVan9YkcGwKU5aB4',
		),
	),
	'dialler' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=127.0.0.1;dbname=vicidial',
			'username'   => 'vicidial',
			'password'   => 'kVan9YkcGwKU5aB4',
		),
	),

  'debtsolv_1tick' => array(
		'type'       => 'pdo',
		'connection' => array(
		#'dsn'            => 'dblib:host=192.168.1.100:1334;dbname=Leadpool_DM', //production
		'dsn'            => 'sqlsrv:Server=192.168.1.100,1334;Database=Leadpool_DM',
        'username'       => 'superuser',
		    'password'       => 'Rfd32xs12B',
		    'persistent'     => false,
		),
	),

    'debtsolv_gabfs' => array(
        'type'       => 'pdo',
        'connection' => array(
            'dsn'            => 'sqlsrv:Server=192.168.3.11,1433;Database=Leadpool_GABFS',
            #'dsn'            => 'dblib:host=192.168.3.11:1433;dbname=Leadpool_GABFS',
            'username'       => 'debtsolv',
            'password'       => '63BW3fver3241',
            'persistent'     => false,
        ),
    ),

	'debtsolv' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection' => array(
			#'dsn'	=> 'dblib:host=192.168.3.31:1433;dbname=LeadPool_MMS', //production
	        'dsn'	=> 'sqlsrv:Server=192.168.3.31,1433;Database=LeadPool_MMS',
		        'username'       => 'debtsolv',
		        'password'       => '76GerZnu871',
		        'persistent'     => false,
		),
	),
  
  // -- Debtsolv Expert Money Solutions Database (Client Area)
  // ----------------------------------------------------------
  'debtsolv_clientarea_expertmoneysolutions' => array(
		'type'       => 'pdo',
		'connection' => array(
            	'dsn'            => 'dblib:host=192.168.1.100:1334;dbname=Debtsolv_Test', //production
				#'dsn'            => 'sqlsrv:Server=109.235.124.18,1334;Database=Debtsolv_Test',
		        'username'       => 'superuser',
		        'password'       => 'Rfd32xs12B',
		        'persistent'     => false,
		),
	),
  
  // -- Debtsolv 1-Tick Database (Client Area)
  // -----------------------------------------
  'debtsolv_clientarea_1-tick' => array(
		'type'       => 'pdo',
		'connection' => array(
            	#'dsn'            => 'dblib:host=192.168.1.100:1334;dbname=Debtsolv_Test', //production
				'dsn'            => 'sqlsrv:Server=109.235.124.18,1334;Database=Debtsolv_Test',
		        'username'       => 'superuser',
		        'password'       => 'Rfd32xs12B',
		        'persistent'     => false,
		),
	),
	
	// GAB Databases
	'gabdialler' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=192.168.5.215;dbname=asterisk',
			'username'   => 'intranet',
			'password'   => 'Wvts231ct6D',
		),
	),
	/* GAB Databases
	'gabdialler' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=192.168.1.234;dbname=asterisk',
			'username'   => 'cron',
			'password'   => '1234',
		),
	),
	*/
	'gabpbx' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=10.1.0.120;dbname=asterisk',
			'username'   => 'cron',
			'password'   => '1234',
		),
	),
	
	
	
	'resolvedialler' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=10.150.5.240;dbname=asterisk',
			'username'   => 'cron',
			'password'   => '1234',
		),
	),
	'gipltd' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=1.22.173.18;dbname=asterisk',
			'username'   => 'cron',
			'password'   => '1234',
		),
	),
);
