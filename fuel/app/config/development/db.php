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
);
