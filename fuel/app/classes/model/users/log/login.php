<?php

class Model_Users_Log_Login extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'login_time',
		'created_at',
		'updated_at',
		'status',
		'attempted_login',
		'ip_address',
	);

	protected static $_belongs_to = array('user');

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
}
