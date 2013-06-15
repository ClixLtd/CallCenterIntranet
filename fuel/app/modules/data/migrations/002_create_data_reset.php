<?php

namespace Fuel\Migrations;

class Create_data_reset
{
	public function up()
	{
        \DBUtil::create_table('data_reset', array(
            'id'                 => array('constraint' => 11,    'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'data_id'            => array('constraint' => 11,    'type' => 'int'),
            'user_id'            => array('constraint' => 11,    'type' => 'int'),
            'type'               => array('constraint' => 11,    'type' => 'int'),
            'date'               => array('type' => 'datetime'),
        ), array('id'));
	}

	public function down()
	{
    	\DBUtil::drop_table('data_reset');
	}
}