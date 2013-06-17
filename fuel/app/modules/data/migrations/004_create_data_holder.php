<?php

namespace Fuel\Migrations;

class Create_data_holder
{
	public function up()
	{
        \DBUtil::create_table('data_holder', array(
            'id'                 => array('type' => 'int',     'constraint' => 11,  'auto_increment' => true, 'unsigned' => true),
            'data_id'            => array('type' => 'int',     'constraint' => 11),
            'title'              => array('type' => 'varchar', 'constraint' => 4),
            'first_name'         => array('type' => 'varchar', 'constraint' => 30),
            'middle_initial'     => array('type' => 'varchar', 'constraint' => 1),
            'last_name'          => array('type' => 'varchar', 'constraint' => 30),
            'address1'           => array('type' => 'varchar', 'constraint' => 100),
            'address2'           => array('type' => 'varchar', 'constraint' => 100),
            'address3'           => array('type' => 'varchar', 'constraint' => 100),
            'city'               => array('type' => 'varchar', 'constraint' => 50),
            'state'              => array('type' => 'varchar', 'constraint' => 2),
            'province'           => array('type' => 'varchar', 'constraint' => 50),
            'postal_code'        => array('type' => 'varchar', 'constraint' => 10),
            'gender'             => array('type' => 'varchar', 'constraint' => 1),
            'phone_number'       => array('type' => 'bigint',  'constraint' => 18),
            'alt_phone'          => array('type' => 'bigint',  'constraint' => 18),
            'email'              => array('type' => 'varchar', 'constraint' => 255),
            'date_of_birth'      => array('type' => 'date'),
            'comments'           => array('type' => 'varchar', 'constraint' => 255),
        ), array('id'));
	}

	public function down()
	{
    	\DBUtil::drop_table('data_holder');
	}
}