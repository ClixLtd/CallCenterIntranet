<?php
use Orm\Model;

class Model_Staff extends Model
{

	protected static $_properties = array(
		'id',
		'first_name',
		'last_name',
		'intranet_id',
		'dialler_id',
		'debtsolv_id',
		'network_id',
		'center_id',
		'department_id',
		'active',
		'created_at',
		'updated_at',
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
