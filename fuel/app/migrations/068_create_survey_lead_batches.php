<?php

namespace Fuel\Migrations;

class Create_survey_lead_batches
{
	public function up()
	{
		\DBUtil::create_table('survey_lead_batches', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'supplier_id' => array('constraint' => 11, 'type' => 'int'),
			'date_added' => array('type' => 'datetime'),
			'filename' => array('constraint' => 255, 'type' => 'varchar'),
			'collected' => array('type' => 'bool'),
			'date_collected' => array('type' => 'datetime'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('survey_lead_batches');
	}
}