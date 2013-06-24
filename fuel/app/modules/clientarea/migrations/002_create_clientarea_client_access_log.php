<?php

namespace Fuel\Migrations;

class Create_clientarea_client_access_log
{
	public function up()
	{
		\DBUtil::create_table('clientarea_client_access_log', array(
			'id'               => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'log_type_id'      => array('constraint' => 11, 'type' => 'int'),
			'client_id'        => array('constraint' => 11, 'type' => 'int'),
	    'date_time'        => array('type' => 'datetime'),
	    'data'             => array('type' => 'mediumtext'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_client_access_log');
	}
}