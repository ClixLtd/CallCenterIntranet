<?php

namespace Fuel\Migrations;

class Create_printmanager_trays
{
	public function up()
	{
		\DBUtil::create_table('printmanager_trays', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'printer_id' => array('constraint' => 11, 'type' => 'int'),
			'tray_name' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('printmanager_trays');
	}
}