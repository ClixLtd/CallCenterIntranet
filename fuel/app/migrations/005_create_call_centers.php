<?php

namespace Fuel\Migrations;

class Create_call_centers
{
	public function up()
	{
		\DBUtil::create_table('call_centers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'address' => array('type' => 'text'),
			'phone_number' => array('constraint' => 25, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('call_centers');
	}
}