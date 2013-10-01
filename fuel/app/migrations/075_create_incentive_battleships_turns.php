<?php

namespace Fuel\Migrations;

class Create_incentive_battleships_turns
{
    public function up()
    {
        \DBUtil::create_table('incentive_battleships_turns', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'user_id' => array('constraint' => 255, 'type' => 'varchar'),
            'square' => array('constraint' => 11, 'type' => 'varchar'),
            'status' => array('constraint' => 11, 'type' => 'int'),

        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('incentive_battleships_turns');
    }
}