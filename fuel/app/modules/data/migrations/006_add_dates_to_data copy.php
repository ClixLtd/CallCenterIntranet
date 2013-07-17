<?php

namespace Fuel\Migrations;

class Add_dates_to_data
{
	public function up()
	{
		\DBUtil::add_fields('data', array(
			'added_date' => array('type' => 'datetime'),
			'import_date' => array('type' => 'datetime'),
			'copied_date' => array('type' => 'datetime'),
			'completion_date' => array('type' => 'datetime'),
		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('data', array(
			'added_date',
			'import_date',
			'copied_date',
			'completion_date',
		));
	}
}