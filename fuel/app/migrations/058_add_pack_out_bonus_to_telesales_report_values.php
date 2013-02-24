<?php

namespace Fuel\Migrations;

class Add_pack_out_bonus_to_telesales_report_values
{
	public function up()
	{
		\DBUtil::add_fields('telesales_report_values', array(
			'pack_out_bonus' => array('constraint' => '7,2', 'type' => 'float'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('telesales_report_values', array(
			'pack_out_bonus'
    
		));
	}
}