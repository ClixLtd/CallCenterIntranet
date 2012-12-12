<?php

namespace Fuel\Migrations;

class Create_towns
{
	public function up()
	{
		\DBUtil::create_table('towns', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'town' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('towns');
	}
}