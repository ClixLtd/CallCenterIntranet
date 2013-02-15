<?php

namespace Fuel\Migrations;

class Add_center_id_to_staff
{
	public function up()
	{
		\DBUtil::add_fields('staffs', array(
			'center_id' => array('constraint' => 11, 'type' => 'int'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('staffs', array(
			'center_id'
    
		));
	}
}