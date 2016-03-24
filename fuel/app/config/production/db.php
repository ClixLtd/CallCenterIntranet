<?php
/**
 * The development database settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=192.168.99.100;dbname=gbs_intranet;port=32777',
			'username'   => 'root',
			'password'   => 'password',
		),
	),
    'dialler' => array(
        'type'       => 'pdo',
        'table_prefix' => '',
        'connection'  => array(
			'dsn'        => 'mysql:host=ie.db.dialler.tech3k.co.uk;dbname=vicidial',
			'username'   => 'dialler',
			'password'   => 'Wvts231ct6D',
        ),
    ),
);
