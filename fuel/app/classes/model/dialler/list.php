<?php
use Orm\Model;

class Model_Dialler_List extends Model
{
	protected static $_properties = array(
		'id',
		'list_name',
		'list_description',
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
		$val->add_field('list_name', 'List Name', 'required|max_length[30]');
		$val->add_field('list_description', 'List Description', 'required|max_length[255]');

		return $val;
	}

}
