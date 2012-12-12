<?php

namespace Fuel\Migrations;

class Create_printmanager_printers
{
	public function up()
	{
		\DBUtil::create_table('printmanager_printers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'printer_name' => array('constraint' => 255, 'type' => 'varchar'),
			'printer_reference' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('printmanager_printers');
	}
}