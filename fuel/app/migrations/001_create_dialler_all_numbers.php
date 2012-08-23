<?php

namespace Fuel\Migrations;

class Create_dialler_all_numbers
{
	public function up()
	{
		\DBUtil::create_table('dialler_all_numbers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'first_name' => array('constraint' => 255, 'type' => 'varchar'),
			'middle_initial' => array('constraint' => 1, 'type' => 'char'),
			'last_name' => array('constraint' => 255, 'type' => 'varchar'),
			'address1' => array('constraint' => 255, 'type' => 'varchar'),
			'address2' => array('constraint' => 255, 'type' => 'varchar'),
			'address3' => array('constraint' => 255, 'type' => 'varchar'),
			'city' => array('constraint' => 255, 'type' => 'varchar'),
			'state' => array('constraint' => 255, 'type' => 'varchar'),
			'province' => array('constraint' => 255, 'type' => 'varchar'),
			'postal_code' => array('constraint' => 255, 'type' => 'varchar'),
			'country_code' => array('constraint' => 255, 'type' => 'varchar'),
			'gender' => array('constraint' => 1, 'type' => 'char'),
			'dateofbirth' => array('type' => 'date'),
			'phone_number' => array('constraint' => 11, 'type' => 'int'),
			'alt_phone' => array('constraint' => 11, 'type' => 'int'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('dialler_all_numbers');
	}
}