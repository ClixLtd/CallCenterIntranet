<?php

namespace Fuel\Migrations;

class Create_data_supplier_lists
{
	public function up()
	{
		\DBUtil::create_table('data_supplier_lists', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'data_supplier_id' => array('constraint' => 11, 'type' => 'int'),
			'datafile' => array('type' => 'text'),
			'cost' => array('constraint' => '7,2', 'type' => 'float'),
			'total_leads' => array('type' => 'bigint'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('data_supplier_lists');
	}
}