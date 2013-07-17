<?php

namespace Fuel\Migrations;

class Add_current_status_to_data_dialler_copy
{
	public function up()
	{
		\DBUtil::add_fields('data_dialler_copy', array(
			'current_status'         => array('constraint' => 255, 'type' => 'varchar'),
			'current_status_update'  => array('type' => 'datetime'),
		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('data_dialler_copy', array(
			'current_status',
			'current_status_update',
		));
	}
}