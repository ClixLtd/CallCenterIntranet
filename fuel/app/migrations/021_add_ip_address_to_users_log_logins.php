<?php

namespace Fuel\Migrations;

class Add_ip_address_to_users_log_logins
{
	public function up()
	{
		\DBUtil::add_fields('users_log_logins', array(
			'ip_address' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('users_log_logins', array(
			'ip_address'
    
		));
	}
}