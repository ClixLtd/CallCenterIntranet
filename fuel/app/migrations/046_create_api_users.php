<?php

namespace Fuel\Migrations;

class Create_api_users
{
	public function up()
	{
		\DBUtil::create_table('api_users', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'id' => array('constraint' => 11, 'type' => 'int'),
			'key' => array('constraint' => 255, 'type' => 'varchar'),
			'status' => array('constraint' => 255, 'type' => 'varchar'),
			'description' => array('constraint' => 255, 'type' => 'varchar'),
			'ip' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('api_users');
	}
}