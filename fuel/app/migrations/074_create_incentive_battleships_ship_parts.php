<?php

namespace Fuel\Migrations;

class Create_incentive_battleships_ship_parts
{
    public function up()
    {
        \DBUtil::create_table('incentive_battleships_ship_parts', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'ship_id' => array('constraint' => 11, 'type' => 'int'),
            'square' => array('constraint' => 11, 'type' => 'varchar'),
            'status' => array('constraint' => 11, 'type' => 'int'),

        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('incentive_battleships_ship_parts');
    }
}