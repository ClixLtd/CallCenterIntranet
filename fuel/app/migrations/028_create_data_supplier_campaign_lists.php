<?php

namespace Fuel\Migrations;

class Create_data_supplier_campaign_lists
{
	public function up()
	{
		\DBUtil::create_table('data_supplier_campaign_lists', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'data_supplier_campaign_id' => array('constraint' => 11, 'type' => 'int'),
			'list_id' => array('constraint' => 11, 'type' => 'int'),
			'database_server_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('data_supplier_campaign_lists');
	}
}