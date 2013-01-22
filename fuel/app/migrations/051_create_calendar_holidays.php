<?php

namespace Fuel\Migrations;

class Create_calendar_holidays
{
	public function up()
	{
		\DBUtil::create_table('calendar_holidays', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'date_from' => array('type' => 'date'),
			'date_to' => array('type' => 'date'),
			'authorised' => array('constraint' => 1, 'type' => 'tinyint'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('calendar_holidays');
	}
}