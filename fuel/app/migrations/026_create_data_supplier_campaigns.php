<?php

namespace Fuel\Migrations;

class Create_data_supplier_campaigns
{
	public function up()
	{
		\DBUtil::create_table('data_supplier_campaigns', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'data_supplier_id' => array('constraint' => 11, 'type' => 'int'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'description' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('data_supplier_campaigns');
	}
}