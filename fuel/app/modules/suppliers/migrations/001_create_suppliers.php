<?php

namespace Fuel\Migrations;

class Create_suppliers
{
	public function up()
	{
        \DBUtil::create_table('suppliers', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
        ), array('id'));
	}

	public function down()
	{
    	\DBUtil::drop_table('suppliers');
	}
}