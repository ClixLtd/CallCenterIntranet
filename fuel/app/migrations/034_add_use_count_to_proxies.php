<?php

namespace Fuel\Migrations;

class Add_use_count_to_proxies
{
	public function up()
	{
		\DBUtil::add_fields('proxies', array(
			'use_count' => array('constraint' => 11, 'type' => 'int'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('proxies', array(
			'use_count'
    
		));
	}
}