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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('first_name', 'First Name', 'required|max_length[255]');
		$val->add_field('last_name', 'Last Name', 'required|max_length[255]');
		$val->add_field('intranet_id', 'Intranet Id', 'required|valid_string[numeric]');
		$val->add_field('dialler_id', 'Dialler Id', 'required|max_length[255]');
		$val->add_field('debtsolv_id', 'Debtsolv Id', 'required|max_length[255]');
		$val->add_field('network_id', 'Network Id', 'required|max_length[255]');
		$val->add_field('active', 'Active', 'required|valid_string[numeric]');

		return $val;
	}

}
