<?php

namespace Fuel\Migrations;

class Create_survey_responses
{
	public function up()
	{
		\DBUtil::create_table('survey_responses', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'reference' => array('constraint' => 255, 'type' => 'varchar'),
			'question_id' => array('constraint' => 11, 'type' => 'int'),
			'answer_id' => array('constraint' => 11, 'type' => 'int'),
			'extra' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('survey_responses');
	}
}