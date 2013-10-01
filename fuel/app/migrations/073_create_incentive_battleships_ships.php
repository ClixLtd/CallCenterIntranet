<?php

namespace Fuel\Migrations;

class Create_incentive_battleships_ships
{
    public function up()
    {
        \DBUtil::create_table('incentive_battleships_ships', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'length' => array('constraint' => 11, 'type' => 'int'),
            'status' => array('constraint' => 11, 'type' => 'int'),

        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('incentive_battleships_ships');
    }
}