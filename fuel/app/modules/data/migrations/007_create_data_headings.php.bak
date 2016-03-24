<?php

namespace Fuel\Migrations;

class Create_data_headings
{
	public function up()
	{
        \DBUtil::create_table('data_headings', array(
            'id'                 => array('constraint' => 11,    'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'required_heading'   => array('constraint' => 255,   'type' => 'varchar'),
            'given_heading'      => array('constraint' => 255,   'type' => 'varchar'),
        ), array('id'));
	}

	public function down()
	{
    	\DBUtil::drop_table('data_headings');
	}
}