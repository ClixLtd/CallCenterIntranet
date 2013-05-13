<?php

namespace Fuel\Migrations;

class Create_telesales_report_values
{
	public function up()
	{
		\DBUtil::create_table('telesales_report_values', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'center_id' => array('constraint' => 11, 'type' => 'int'),
			'referral_points' => array('constraint' => '5,5', 'type' => 'float'),
			'pack_out_points' => array('constraint' => '5,5', 'type' => 'float'),
			'di_pound_point' => array('constraint' => '5,5', 'type' => 'float'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('telesales_report_values');
	}
}