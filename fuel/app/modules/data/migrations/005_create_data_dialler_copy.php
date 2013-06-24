<?php

namespace Fuel\Migrations;

class Create_data_dialler_copy
{
	public function up()
	{
        \DBUtil::create_table('data_dialler_copy', array(
            'id'                 => array('type' => 'int',     'constraint' => 11,  'auto_increment' => true, 'unsigned' => true),
            'data_lead_id'       => array('type' => 'int',     'constraint' => 11),
            'dialler_lead_id'    => array('type' => 'int',     'constraint' => 11),
            'number_data'        => array('type' => 'text'),
        ), array('id'));
	}

	public function down()
	{
    	\DBUtil::drop_table('data_dialler_copy');
	}
}