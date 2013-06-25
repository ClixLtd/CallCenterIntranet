<?php

namespace Fuel\Migrations;

class Create_data_reset_type
{
	public function up()
	{
        \DBUtil::create_table('data_reset_type', array(
            'id'                 => array('constraint' => 11,    'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name'               => array('constraint' => 255,   'type' => 'varchar'),
        ), array('id'));
	}

	public function down()
	{
    	\DBUtil::drop_table('data_reset_type');
	}
}