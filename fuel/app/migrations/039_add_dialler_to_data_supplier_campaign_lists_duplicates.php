<?php

namespace Fuel\Migrations;

class Add_dialler_to_data_supplier_campaign_lists_duplicates
{
	public function up()
	{
		\DBUtil::add_fields('data_supplier_campaign_lists_duplicates', array(
			'dialler' => array('constraint' => 11, 'type' => 'int'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('data_supplier_campaign_lists_duplicates', array(
			'dialler'
    
		));
	}
}