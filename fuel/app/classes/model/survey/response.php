<?php
use Orm\Model;

class Model_Survey_Response extends Model
{
	protected static $_properties = array(
		'id',
		'reference',
		'question_id',
		'answer_id',
		'extra',
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
		$val->add_field('reference', 'Reference', 'required|max_length[255]');
		$val->add_field('question_id', 'Question Id', 'required|valid_string[numeric]');
		$val->add_field('answer_id', 'Answer Id', 'required|valid_string[numeric]');
		$val->add_field('extra', 'Extra', 'required');

		return $val;
	}

}
