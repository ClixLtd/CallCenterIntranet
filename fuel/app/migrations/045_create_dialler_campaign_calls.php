<?php

namespace Fuel\Migrations;

class Create_dialler_campaign_calls
{
	public function up()
	{
		\DBUtil::create_table('dialler_campaign_calls', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'campaign' => array('constraint' => 255, 'type' => 'varchar'),
			'calls_made' => array('constraint' => 11, 'type' => 'int'),
			'calls_answered' => array('constraint' => 11, 'type' => 'int'),
			'date' => array('type' => 'datetime'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('dialler_campaign_calls');
	}
}