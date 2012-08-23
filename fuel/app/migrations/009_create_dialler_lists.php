<?php

namespace Fuel\Migrations;

class Create_dialler_lists
{
	public function up()
	{
		\DBUtil::create_table('dialler_lists', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'list_name' => array('constraint' => 30, 'type' => 'varchar'),
			'list_description' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('dialler_lists');
	}
}