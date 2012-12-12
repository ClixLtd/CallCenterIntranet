<?php

namespace Fuel\Migrations;

class Create_adam_messages
{
	public function up()
	{
		\DBUtil::create_table('adam_messages', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'message' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('adam_messages');
	}
}