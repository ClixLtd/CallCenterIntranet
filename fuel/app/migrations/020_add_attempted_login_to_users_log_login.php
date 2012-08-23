<?php

namespace Fuel\Migrations;

class Add_attempted_login_to_users_log_login
{
	public function up()
	{
		\DBUtil::add_fields('users_log_logins', array(
			'attempted_login' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('users_log_logins', array(
			'attempted_login'
    
		));
	}
}