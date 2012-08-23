<?php
use Orm\Model;

class Model_Data_Supplier extends Model
{
	protected static $_properties = array(
		'id',
		'company_name',
		'contact_name',
		'contact_email',
		'contact_address',
		'web_address',
		'telephone',
		'mobile',
		'fax',
		'created_at',
		'updated_at',
	);
	
	//protected $_has_many = array('data_supplier_list');

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
		$val->add_field('company_name', 'Company Name', 'required|max_length[255]');
		$val->add_field('contact_name', 'Contact Name', 'required|max_length[255]');
		$val->add_field('contact_email', 'Contact Email', 'required|max_length[255]');
		$val->add_field('contact_address', 'Contact Address', 'required');
		$val->add_field('web_address', 'Web Address', 'required|max_length[255]');
		$val->add_field('telephone', 'Telephone', 'required|max_length[255]');
		$val->add_field('mobile', 'Mobile', 'required|max_length[255]');
		$val->add_field('fax', 'Fax', 'required|max_length[255]');

		return $val;
	}

}
