<?php

namespace Fuel\Migrations;

class Create_user_centers
{
	public function up()
	{
		\DBUtil::create_table('user_centers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user' => array('constraint' => 11, 'type' => 'int'),
			'center' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('user_centers');
	}
}