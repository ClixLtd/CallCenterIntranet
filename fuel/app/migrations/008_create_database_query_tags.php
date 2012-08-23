<?php

namespace Fuel\Migrations;

class Create_database_query_tags
{
	public function up()
	{
		\DBUtil::create_table('database_query_tags', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'database_query_id' => array('constraint' => 11, 'type' => 'int'),
			'tag' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('database_query_tags');
	}
}