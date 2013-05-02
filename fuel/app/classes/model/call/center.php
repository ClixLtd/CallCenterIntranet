<?php
use Orm\Model;

class Model_Call_Center extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'address',
		'phone_number',
		'shortcode',
		'survey',
		'created_at',
		'updated_at',
	);
	
	protected static $_has_many = array('dialler_campaign');
	
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
		$val->add_field('address', 'Address', 'required');
		$val->add_field('phone_number', 'Phone Number', 'required|max_length[25]');
		$val->add_field('shortcode', 'Short Code', 'required|max_length[255]');

		return $val;
	}

}
