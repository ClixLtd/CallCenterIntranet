<?php
use Orm\Model;

class Model_Database_Query_Tag extends Model
{
	protected static $_properties = array(
		'id',
		'database_query_id',
		'tag',
		'created_at',
		'updated_at',
	);
	
	protected static $_belongs_to = array('database_queries');

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
		$val->add_field('database_query_id', 'Database Query Id', 'required');
		$val->add_field('tag', 'Tag', 'required|max_length[255]');

		return $val;
	}

}
