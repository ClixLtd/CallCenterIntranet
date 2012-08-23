<?php

class Model_Data_Supplier_Campaigns_Data_Suppliers extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'data_supplier_campaign_id',
		'data_supplier_id',
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
