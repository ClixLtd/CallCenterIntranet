<?php

namespace Fuel\Migrations;

class Create_clientarea_type_access_log_type
{
	public function up()
	{
		\DBUtil::create_table('clientarea_type_access_log_type', array(
			'id'           => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'description'  => array('constraint' => 100, 'type' => 'varchar'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_type_access_log_type');
	}
}