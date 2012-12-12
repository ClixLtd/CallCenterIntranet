<?php

namespace Fuel\Migrations;

class Add_dialler_to_tomorrow_list_stats
{
	public function up()
	{
		\DBUtil::add_fields('tomorrow_list_stats', array(
			'dialler' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('tomorrow_list_stats', array(
			'dialler'
    
		));
	}
}