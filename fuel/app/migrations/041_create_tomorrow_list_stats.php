<?php

namespace Fuel\Migrations;

class Create_tomorrow_list_stats
{
	public function up()
	{
		\DBUtil::create_table('tomorrow_list_stats', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'day_check' => array('constraint' => 11, 'type' => 'int'),
			'content' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('tomorrow_list_stats');
	}
}