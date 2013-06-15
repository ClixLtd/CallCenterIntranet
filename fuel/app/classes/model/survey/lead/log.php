<?php
use Orm\Model;

class Model_Survey_Lead_Log extends Model
{
	protected static $_properties = array(
		'id',
		'referral_id',
		'batch_id',
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
		$val->add_field('referral_id', 'Referral Id', 'required|valid_string[numeric]');
		$val->add_field('batch_id', 'Batch Id', 'required|valid_string[numeric]');

		return $val;
	}

}
