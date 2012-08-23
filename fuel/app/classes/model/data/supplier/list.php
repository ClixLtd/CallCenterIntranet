<?php
use Orm\Model;

class Model_Data_Supplier_List extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'data_supplier_id',
		'datafile',
		'cost',
		'total_leads',
		'created_at',
		'updated_at',
	);
	
	protected static $_belongs_to = array('data_supplier');

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
		$val->add_field('data_supplier_id', 'Data Supplier Id', 'required');
		$val->add_field('datafile', 'Datafile', 'required');
		$val->add_field('cost', 'Cost', '');
		$val->add_field('total_leads', 'Total Leads', '');

		return $val;
	}

}
