<?php

namespace Fuel\Migrations;

class Create_proxies
{
	public function up()
	{
		\DBUtil::create_table('proxies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'host' => array('constraint' => 255, 'type' => 'varchar'),
			'port' => array('constraint' => 11, 'type' => 'int'),
			'fail_count' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('proxies');
	}
}