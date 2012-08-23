<?php

namespace Fuel\Migrations;

class Add_name_to_data_users
{
	public function up()
	{
		\DBUtil::add_fields('users', array(
			'name' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('users', array(
			'name'
    
		));
	}
}