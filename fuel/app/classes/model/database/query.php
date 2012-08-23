<?php
use Orm\Model;

class Model_Database_Query extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'description',
		'query',
		'cache_time',
		'database_server_id',
		'database',
		'username',
		'password',
		'created_at',
		'updated_at',
	);
	
	protected static $_belongs_to = array('database_servers');
	
	protected static $_has_many = array('database_query_tags');

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
		$val->add_field('description', 'Description', 'required');
		$val->add_field('query', 'Query', 'required');
		$val->add_field('cache_time', 'Cache Time', 'required');
		$val->add_field('database_server_id', 'Database Server', 'required');
		$val->add_field('database', 'Database', 'required|max_length[255]');
		$val->add_field('username', 'Username', '');
		$val->add_field('password', 'Password', '');

		return $val;
	}

}
