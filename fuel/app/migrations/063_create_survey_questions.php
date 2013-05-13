<?php

namespace Fuel\Migrations;

class Create_survey_questions
{
	public function up()
	{
		\DBUtil::create_table('survey_questions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'survey_id' => array('constraint' => 11, 'type' => 'int'),
			'question' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('survey_questions');
	}
}