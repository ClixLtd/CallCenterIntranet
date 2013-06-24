<?php

namespace Fuel\Migrations;

class Create_clientarea_messages_statuses
{
	public function up()
	{
		\DBUtil::create_table('clientarea_messages_statuses', array(
			'id'           => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'description'  => array('constraint' => 100, 'type' => 'varchar'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_messages_statuses');
	}
}