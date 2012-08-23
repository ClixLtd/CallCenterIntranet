<?php

namespace Fuel\Migrations;

class Add_shortcode_to_call_center
{
	public function up()
	{
		\DBUtil::add_fields('call_centers', array(
			'shortcode' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('call_centers', array(
			'shortcode'
    
		));
	}
}