<?php

namespace Fuel\Migrations;

class Create_clientarea_messages
{
	public function up()
	{
		\DBUtil::create_table('clientarea_messages', array(
			'id'              => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'client_id'       => array('constraint' => 11, 'type' => 'int'),
			'company_id'      => array('constraint' => 11, 'type' => 'int'),
      'from'            => array('constraint' => "'client','user'", 'type' => 'enum'),
      'subject'         => array('constraint' => 300, 'type' => 'varchar'),
      'date'            => array('type' => 'datetime'),
      'status_id'       => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_messages');
	}
}