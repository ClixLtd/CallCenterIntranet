<?php

namespace Fuel\Migrations;

class Create_debtsolv_transfer_logs
{
	public function up()
	{
		\DBUtil::create_table('debtsolv_transfer_logs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'shortcode' => array('constraint' => 255, 'type' => 'varchar'),
			'dialler_username' => array('constraint' => 255, 'type' => 'varchar'),
			'error_code' => array('constraint' => 11, 'type' => 'int'),
			'error_message' => array('constraint' => 255, 'type' => 'varchar'),
			'var_dump' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('debtsolv_transfer_logs');
	}
}