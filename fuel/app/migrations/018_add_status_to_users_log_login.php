<?php

namespace Fuel\Migrations;

class Add_status_to_users_log_login
{
	public function up()
	{
		\DBUtil::add_fields('users_log_logins', array(
			'status' => array('constraint' => 11, 'type' => 'int'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('users_log_logins', array(
			'status'
    
		));
	}
}