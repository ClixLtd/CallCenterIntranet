<?php

namespace Fuel\Migrations;

class Create_staff_departments
{
	public function up()
	{
		\DBUtil::create_table('staff_departments', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('staff_departments');
	}
}