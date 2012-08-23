<?php
use Orm\Model;

class Model_Dialler_Campaign extends Model
{
	protected static $_properties = array(
		'id',
		'campaign_title',
		'campaign_name',
		'campaign_description',
		'call_center_id',
		'created_at',
		'updated_at',
	);
	
	protected static $_belongs_to = array('call_center');
	
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
		$val->add_field('campaign_title', 'Campaign Title', 'required|max_length[255]');
		$val->add_field('campaign_name', 'Campaign Name', 'required|max_length[255]');
		$val->add_field('campaign_description', 'Campaign Description', 'required|max_length[255]');
		$val->add_field('call_center_id', 'Call Center Id', 'required');

		return $val;
	}

}
