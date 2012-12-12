<?php

namespace Fuel\Migrations;

class Add_last_town_to_surnames
{
	public function up()
	{
		\DBUtil::add_fields('surnames', array(
			'last_town' => array('constraint' => 11, 'type' => 'int'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('surnames', array(
			'last_town'
    
		));
	}
}