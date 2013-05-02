<?php

namespace Fuel\Migrations;

class Create_survey_question_answers
{
	public function up()
	{
		\DBUtil::create_table('survey_question_answers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'question_id' => array('constraint' => 11, 'type' => 'int'),
			'answer' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('survey_question_answers');
	}
}