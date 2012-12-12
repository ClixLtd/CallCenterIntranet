<?php
use Orm\Model;

class Model_Surname extends Model
{
	protected static $_properties = array(
		'id',
		'surname',
		'completed' => array('default' => 0),
		'last_town' => array('default' => 0),
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
		$val->add_field('surname', 'Surname', 'required|max_length[255]');

		return $val;
	}

}
