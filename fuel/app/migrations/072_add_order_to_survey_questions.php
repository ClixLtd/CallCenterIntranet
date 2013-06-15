<?php

namespace Fuel\Migrations;

class Add_order_to_survey_questions
{
	public function up()
	{
		\DBUtil::add_fields('survey_questions', array(
			'order' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('survey_questions', array(
			'order'

		));
	}
}