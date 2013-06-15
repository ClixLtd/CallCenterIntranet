<?php
use Orm\Model;

class Model_Survey_Question extends Model
{
	protected static $_properties = array(
		'id',
		'survey_id',
		'question',
		'created_at',
		'updated_at',
		'order',
	);
	
	protected static $_has_many = array(
	   'answers' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Survey_Question_Answer',
            'key_to' => 'question_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
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
		$val->add_field('survey_id', 'Survey Id', 'required|valid_string[numeric]');
		$val->add_field('question', 'Question', 'required');

		return $val;
	}

}
