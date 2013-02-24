<?php

namespace Fuel\Migrations;

class Add_payment_percentage_to_telesales_report_values
{
	public function up()
	{
		\DBUtil::add_fields('telesales_report_values', array(
			'payment_percentage' => array('constraint' => '8,5', 'type' => 'float'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('telesales_report_values', array(
			'payment_percentage'
    
		));
	}
}