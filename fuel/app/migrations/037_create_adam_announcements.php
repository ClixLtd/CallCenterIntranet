<?php

namespace Fuel\Migrations;

class Create_adam_announcements
{
	public function up()
	{
		\DBUtil::create_table('adam_announcements', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'campaign' => array('constraint' => 255, 'type' => 'varchar'),
			'alert_type' => array('constraint' => 255, 'type' => 'varchar'),
			'remove_date' => array('type' => 'datetime'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('adam_announcements');
	}
}