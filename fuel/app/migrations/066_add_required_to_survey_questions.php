<?php

namespace Fuel\Migrations;

class Add_required_to_survey_questions
{
	public function up()
	{
		\DBUtil::add_fields('survey_questions', array(
			'required' => array('type' => 'bool'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('survey_questions', array(
			'required'

		));
	}
}