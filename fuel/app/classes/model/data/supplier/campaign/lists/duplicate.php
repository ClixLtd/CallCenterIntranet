<?php
use Orm\Model;

class Model_Data_Supplier_Campaign_Lists_Duplicate extends Model
{
	protected static $_properties = array(
		'id',
		'list_id',
		'database_server_id',
		'duplicate_number',
		'created_at',
		'updated_at',
		'dialler',
		'lead_id',
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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('list_id', 'List Id', 'required|valid_string[numeric]');
		$val->add_field('database_server_id', 'Database Server Id', 'required|valid_string[numeric]');
		$val->add_field('duplicate_number', 'Duplicate Number', 'required|valid_string[numeric]');

		return $val;
	}

}
