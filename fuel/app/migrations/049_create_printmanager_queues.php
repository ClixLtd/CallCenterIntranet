<?php

namespace Fuel\Migrations;

class Create_printmanager_queues
{
	public function up()
	{
		\DBUtil::create_table('printmanager_queues', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'filename' => array('constraint' => 255, 'type' => 'varchar'),
			'priority' => array('constraint' => 11, 'type' => 'int'),
			'status' => array('constraint' => 255, 'type' => 'varchar'),
			'scheduled' => array('type' => 'datetime'),
			'tray_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('printmanager_queues');
	}
}