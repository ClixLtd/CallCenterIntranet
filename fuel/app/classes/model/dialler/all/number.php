<?php

class Model_Dialler_All_Number extends \Orm\Model
{
	protected static $_properties = array(
		'id',
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
		'phone_number',
		'alt_phone',
		'email',
		'created_at',
		'updated_at'
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
}
