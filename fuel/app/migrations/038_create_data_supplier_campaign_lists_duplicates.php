<?php

namespace Fuel\Migrations;

class Create_data_supplier_campaign_lists_duplicates
{
	public function up()
	{
		\DBUtil::create_table('data_supplier_campaign_lists_duplicates', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'list_id' => array('constraint' => 11, 'type' => 'int'),
			'database_server_id' => array('constraint' => 11, 'type' => 'int'),
			'duplicate_number' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('data_supplier_campaign_lists_duplicates');
	}
}