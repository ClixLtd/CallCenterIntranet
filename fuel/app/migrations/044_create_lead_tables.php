<?php

namespace Fuel\Migrations;

class Create_lead_tables
{
	public function up()
	{
		\DBUtil::create_table('lead_tables', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'phone_number' => array('type' => 'bigint'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'first_name' => array('constraint' => 255, 'type' => 'varchar'),
			'middle_initial' => array('constraint' => 255, 'type' => 'varchar'),
			'last_name' => array('constraint' => 255, 'type' => 'varchar'),
			'address1' => array('constraint' => 255, 'type' => 'varchar'),
			'address2' => array('constraint' => 255, 'type' => 'varchar'),
			'address3' => array('constraint' => 255, 'type' => 'varchar'),
			'city' => array('constraint' => 255, 'type' => 'varchar'),
			'state' => array('constraint' => 255, 'type' => 'varchar'),
			'province' => array('constraint' => 255, 'type' => 'varchar'),
			'postal_code' => array('constraint' => 255, 'type' => 'varchar'),
			'country_code' => array('constraint' => 255, 'type' => 'varchar'),
			'gender' => array('constraint' => 255, 'type' => 'varchar'),
			'date_of_birth' => array('constraint' => 255, 'type' => 'varchar'),
			'alt_phone' => array('type' => 'bigint'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'security_phrase' => array('constraint' => 255, 'type' => 'varchar'),
			'comments' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('lead_tables');
	}
}