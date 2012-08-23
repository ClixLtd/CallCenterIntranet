<?php
use Orm\Model;

class Model_News extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'article',
		'call_center_id',
		'user_id',
		'created_at',
		'updated_at',
	);
	
	protected static $_belongs_to = array('user');
	
	protected static $_has_many = array('call_center');

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
		$val->add_field('article', 'Article', 'required');
		$val->add_field('call_center_id', 'Call Center Id', 'required');
		$val->add_field('user_id', 'User Id', 'required');

		return $val;
	}

}
