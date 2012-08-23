<?php

class Model_Dialler_All_Log extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'phone_number',
		'call_date',
		'length_in_sec',
		'status',
		'user',
		'created_at',
		'updated_at'
	);

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
