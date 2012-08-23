<?php

namespace Fuel\Migrations;

class Add_call_center_id_to_users
{
	public function up()
	{
		\DBUtil::add_fields('users', array(
			'call_center_id' => array('constraint' => 11, 'type' => 'int'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('users', array(
			'call_center_id'
    
		));
	}
}