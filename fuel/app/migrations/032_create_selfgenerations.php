<?php

namespace Fuel\Migrations;

class Create_selfgenerations
{
	public function up()
	{
		\DBUtil::create_table('selfgenerations', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'fname' => array('constraint' => 255, 'type' => 'varchar'),
			'sname' => array('constraint' => 255, 'type' => 'varchar'),
			'add1' => array('constraint' => 255, 'type' => 'varchar'),
			'add2' => array('constraint' => 255, 'type' => 'varchar'),
			'postcode' => array('constraint' => 255, 'type' => 'varchar'),
			'telephone' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('selfgenerations');
	}
}