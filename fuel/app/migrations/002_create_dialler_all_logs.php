<?php

namespace Fuel\Migrations;

class Create_dialler_all_logs
{
	public function up()
	{
		\DBUtil::create_table('dialler_all_logs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'phone_number' => array('constraint' => 15, 'type' => 'varchar'),
			'call_date' => array('type' => 'datetime'),
			'length_in_sec' => array('constraint' => 11, 'type' => 'int'),
			'status' => array('constraint' => 255, 'type' => 'varchar'),
			'user' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('dialler_all_logs');
	}
}