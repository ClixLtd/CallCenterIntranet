<?php
use Orm\Model;

class Model_Selfgeneration extends Model
{
	protected static $_properties = array(
		'id',
		'fname',
		'sname',
		'add1',
		'add2',
		'postcode',
		'telephone',
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
		$val->add_field('fname', 'Fname', 'required|max_length[255]');
		$val->add_field('sname', 'Sname', 'required|max_length[255]');
		$val->add_field('add1', 'Add1', 'required|max_length[255]');
		$val->add_field('add2', 'Add2', 'required|max_length[255]');
		$val->add_field('postcode', 'Postcode', 'required|max_length[255]');
		$val->add_field('telephone', 'Telephone', 'required|valid_string[numeric]');

		return $val;
	}

}
