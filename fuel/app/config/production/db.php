<?php
/**
 * The development database settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=127.0.0.1;dbname=gab_intranet',
			'username'   => 'intranet',
			'password'   => 'Wvts231ct6D',
		),
	),
	'debtsolv' => array(
		'type'       => 'pdo',
		'connection' => array(
				'dsn'            => 'dblib:host=192.168.3.31,1433;dbname=LeadPool_MMS',
		        'username'       => 'debtsolv',
		        'password'       => '76GerZnu871',
		        'persistent'     => false,
		),
	),
    'dialler' => array(
        'type'       => 'pdo',
        'table_prefix' => '',
        'connection'  => array(
            'dsn'        => 'mysql:host=192.168.5.215;dbname=asterisk',
            'username'   => 'intranet',
            'password'   => 'Wvts231ct6D',
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
	'pccdialler' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=10.10.1.240;dbname=asterisk',
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
	'rj5' => array(
		'type'       => 'pdo',
		'table_prefix' => '',
		'connection'  => array(
			'dsn'        => 'mysql:host=119.92.172.42;dbname=asterisk',
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
