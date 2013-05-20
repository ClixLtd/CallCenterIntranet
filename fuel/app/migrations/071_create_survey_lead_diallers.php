<?php

namespace Fuel\Migrations;

class Create_survey_lead_diallers
{
	public function up()
	{
		\DBUtil::create_table('survey_lead_diallers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'referral_id' => array('constraint' => 11, 'type' => 'int'),
			'dialler_id' => array('constraint' => 11, 'type' => 'int'),
			'type' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('survey_lead_diallers');
	}
}