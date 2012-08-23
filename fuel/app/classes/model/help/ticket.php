<?php
use Orm\Model;

class Model_Help_Ticket extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'description',
		'priority',
		'help_topic_id',
		'user_id',
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
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('description', 'Description', 'required');
		$val->add_field('priority', 'Priority', 'required');
		$val->add_field('help_topic_id', 'Help Topic Id', 'required');
		$val->add_field('user_id', 'User Id', 'required');

		return $val;
	}

}
