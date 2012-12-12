<?php

namespace Fuel\Migrations;

class Create_surnames
{
	public function up()
	{
		\DBUtil::create_table('surnames', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'surname' => array('constraint' => 255, 'type' => 'varchar'),
			'completed' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('surnames');
	}
}