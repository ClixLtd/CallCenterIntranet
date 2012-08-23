<?php
use Orm\Model;

class Model_User extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'username',
		'password',
		'group',
		'email',
		'call_center_id',
		'last_login',
		'login_hash',
		'profile_fields',
		'created_at',
	);
	
	protected static $_belongs_to = array('call_center');

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
