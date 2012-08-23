<?php

namespace Fuel\Migrations;

class Create_database_servers
{
	public function up()
	{
		\DBUtil::create_table('database_servers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'hostname' => array('constraint' => 255, 'type' => 'varchar'),
			'username' => array('constraint' => 255, 'type' => 'varchar'),
			'password' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('database_servers');
	}
}