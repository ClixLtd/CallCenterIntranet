<?php

namespace Fuel\Migrations;

class Add_api_key_to_call_centers
{
	public function up()
	{
		\DBUtil::add_fields('call_centers', array(
			'api_key' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('call_centers', array(
			'api_key'
    
		));
	}
}