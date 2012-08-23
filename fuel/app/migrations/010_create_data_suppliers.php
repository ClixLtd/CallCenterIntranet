<?php

namespace Fuel\Migrations;

class Create_data_suppliers
{
	public function up()
	{
		\DBUtil::create_table('data_suppliers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'company_name' => array('constraint' => 255, 'type' => 'varchar'),
			'contact_name' => array('constraint' => 255, 'type' => 'varchar'),
			'contact_email' => array('constraint' => 255, 'type' => 'varchar'),
			'contact_address' => array('type' => 'text'),
			'web_address' => array('constraint' => 255, 'type' => 'varchar'),
			'telephone' => array('constraint' => 255, 'type' => 'varchar'),
			'mobile' => array('constraint' => 255, 'type' => 'varchar'),
			'fax' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('data_suppliers');
	}
}