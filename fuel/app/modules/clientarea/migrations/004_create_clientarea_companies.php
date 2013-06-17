<?php

namespace Fuel\Migrations;

class Create_clientarea_companies
{
	public function up()
	{
		\DBUtil::create_table('clientarea_companies', array(
			'id'              => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'alias'           => array('constraint' => 100, 'type' => 'varchar'),
			'company_name'    => array('constraint' => 200, 'type' => 'varchar'),
      'active'          => array('constraint' => "'YES','NO'", 'type' => 'enum', 'default' => 'YES'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_companies');
	}
}