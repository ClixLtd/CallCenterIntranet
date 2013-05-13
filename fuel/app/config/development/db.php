<?php
/**
 * The development database settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=127.0.0.1;dbname=gab_intranet',
			'username'   => 'root',
			'password'   => 'Wvts231ct6D',
		),
	),
	'debtsolv' => array(
		'type'       => 'pdo',
		'connection' => array(
				'dsn'            => 'dblib:host=192.168.1.100:1334;dbname=LeadPool_DM',
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
			'username'   => 'cron',
			'password'   => '1234',
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
