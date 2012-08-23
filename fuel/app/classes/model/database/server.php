<?php
use Orm\Model;

class Model_Database_Server extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'type',
		'hostname',
		'port',
		'username',
		'password',
		'created_at',
		'updated_at',
	);
	
	protected static $_has_many = array('database_queries');

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
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('type', 'Type', 'required');
		$val->add_field('hostname', 'Hostname', 'required|max_length[255]');
		$val->add_field('port', 'Port', 'required');
		$val->add_field('username', 'Username', 'required|max_length[255]');
		$val->add_field('password', 'Password', 'required|max_length[255]');

		return $val;
	}

}
