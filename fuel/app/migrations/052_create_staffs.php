<?php

namespace Fuel\Migrations;

class Create_staffs
{
	public function up()
	{
		\DBUtil::create_table('staffs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'first_name' => array('constraint' => 255, 'type' => 'varchar'),
			'last_name' => array('constraint' => 255, 'type' => 'varchar'),
			'intranet_id' => array('constraint' => 11, 'type' => 'int'),
			'dialler_id' => array('constraint' => 255, 'type' => 'varchar'),
			'debtsolv_id' => array('constraint' => 255, 'type' => 'varchar'),
			'network_id' => array('constraint' => 255, 'type' => 'varchar'),
			'active' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('staffs');
	}
}