<?php

namespace Fuel\Migrations;

class Add_campaign_to_tomorrow_list_stats
{
	public function up()
	{
		\DBUtil::add_fields('tomorrow_list_stats', array(
			'campaign' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('tomorrow_list_stats', array(
			'campaign'
    
		));
	}
}