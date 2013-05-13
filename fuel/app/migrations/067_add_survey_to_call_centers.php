<?php

namespace Fuel\Migrations;

class Add_survey_to_call_centers
{
	public function up()
	{
		\DBUtil::add_fields('call_centers', array(
			'survey' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('call_centers', array(
			'survey'

		));
	}
}