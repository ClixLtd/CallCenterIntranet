<?php
use Orm\Model;

class Model_Data_Supplier_Campaign extends Model
{
	protected static $_properties = array(
		'id',
		'data_supplier_id',
		'title',
		'description',
		'created_at',
		'updated_at',
	);
	
	protected static $_has_many = array('data_supplier_campaign_lists');
	protected static $_many_many = array('data_suppliers');

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
		$val->add_field('data_supplier_id', 'Data Supplier Id', 'required|valid_string[numeric]');
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('description', 'Description', 'required');

		return $val;
	}

}
