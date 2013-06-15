<?php
use Orm\Model;

class Model_Survey_Lead_Batch extends Model
{
	protected static $_properties = array(
		'id',
		'supplier_id',
		'date_added',
		'filename',
		'collected',
		'date_collected',
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
		$val->add_field('supplier_id', 'Supplier Id', 'required|valid_string[numeric]');
		$val->add_field('date_added', 'Date Added', 'required');
		$val->add_field('filename', 'Filename', 'required|max_length[255]');
		$val->add_field('collected', 'Collected', 'required');
		$val->add_field('date_collected', 'Date Collected', 'required');

		return $val;
	}

}
