<?php

namespace Fuel\Migrations;

class Create_dialler_current_agents
{
	public function up()
	{
		\DBUtil::create_table('dialler_current_agents', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'center' => array('constraint' => 255, 'type' => 'varchar'),
			'agents' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('dialler_current_agents');
	}
}