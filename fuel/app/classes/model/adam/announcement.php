<?php
use Orm\Model;

class Model_Adam_Announcement extends Model
{
	protected static $_properties = array(
		'id',
		'campaign',
		'alert_type',
		'remove_date',
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
		$val->add_field('campaign', 'Campaign', 'required|max_length[255]');
		$val->add_field('alert_type', 'Alert Type', 'required|max_length[255]');
		$val->add_field('remove_date', 'Remove Date', 'required');

		return $val;
	}

}
