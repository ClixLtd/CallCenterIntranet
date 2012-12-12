<?php
use Orm\Model;

class Model_Lead_Table extends Model
{
	protected static $_properties = array(
		'id',
		'phone_number',
		'title',
		'first_name',
		'middle_initial',
		'last_name',
		'address1',
		'address2',
		'address3',
		'city',
		'state',
		'province',
		'postal_code',
		'country_code',
		'gender',
		'date_of_birth',
		'alt_phone',
		'email',
		'security_phrase',
		'comments',
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
		$val->add_field('phone_number', 'Phone Number', 'required');
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('first_name', 'First Name', 'required|max_length[255]');
		$val->add_field('middle_initial', 'Middle Initial', 'required|max_length[255]');
		$val->add_field('last_name', 'Last Name', 'required|max_length[255]');
		$val->add_field('address1', 'Address1', 'required|max_length[255]');
		$val->add_field('address2', 'Address2', 'required|max_length[255]');
		$val->add_field('address3', 'Address3', 'required|max_length[255]');
		$val->add_field('city', 'City', 'required|max_length[255]');
		$val->add_field('state', 'State', 'required|max_length[255]');
		$val->add_field('province', 'Province', 'required|max_length[255]');
		$val->add_field('postal_code', 'Postal Code', 'required|max_length[255]');
		$val->add_field('country_code', 'Country Code', 'required|max_length[255]');
		$val->add_field('gender', 'Gender', 'required|max_length[255]');
		$val->add_field('date_of_birth', 'Date Of Birth', 'required|max_length[255]');
		$val->add_field('alt_phone', 'Alt Phone', 'required');
		$val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
		$val->add_field('security_phrase', 'Security Phrase', 'required|max_length[255]');
		$val->add_field('comments', 'Comments', 'required');

		return $val;
	}

}
