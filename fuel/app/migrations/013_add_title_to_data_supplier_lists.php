<?php

namespace Fuel\Migrations;

class Add_title_to_data_supplier_lists
{
	public function up()
	{
		\DBUtil::add_fields('data_supplier_lists', array(
			'title' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('data_supplier_lists', array(
			'title'
    
		));
	}
}