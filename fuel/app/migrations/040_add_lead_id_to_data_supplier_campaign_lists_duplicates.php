<?php

namespace Fuel\Migrations;

class Add_lead_id_to_data_supplier_campaign_lists_duplicates
{
	public function up()
	{
		\DBUtil::add_fields('data_supplier_campaign_lists_duplicates', array(
			'lead_id' => array('constraint' => 11, 'type' => 'int'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('data_supplier_campaign_lists_duplicates', array(
			'lead_id'
    
		));
	}
}