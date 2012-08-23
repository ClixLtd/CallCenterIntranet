<?php

namespace Fuel\Migrations;

class Create_dialler_campaigns
{
	public function up()
	{
		\DBUtil::create_table('dialler_campaigns', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'campaign_title' => array('constraint' => 255, 'type' => 'varchar'),
			'campaign_name' => array('constraint' => 255, 'type' => 'varchar'),
			'campaign_description' => array('constraint' => 255, 'type' => 'varchar'),
			'call_center_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('dialler_campaigns');
	}
}