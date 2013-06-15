<?php

class Model_Survey_Lead_Dialler extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'referral_id',
		'dialler_id',
		'type',
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
}
