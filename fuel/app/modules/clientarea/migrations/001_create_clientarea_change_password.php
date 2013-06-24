<?php

namespace Fuel\Migrations;

class Create_clientarea_change_password
{
	public function up()
	{
		\DBUtil::create_table('clientarea_change_password', array(
			'id'               => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'client_id'        => array('constraint' => 11, 'type' => 'int'),
			'company_id'       => array('constraint' => 11, 'type' => 'int'),
	    'current_password' => array('constraint' => 100, 'type' => 'varchar'),
	    'new_password'     => array('constraint' => 100, 'type' => 'varchar'),
	    'date'             => array('type' => 'datetime'),
	    'status'           => array('constraint' => "'PENDING','DONE','ACCOUNT NOT FOUND', 'FAILED'", 'type' => 'enum', 'default' => 'PENDING'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_change_password');
	}
}