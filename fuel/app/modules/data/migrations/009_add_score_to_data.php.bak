<?php

namespace Fuel\Migrations;

class Add_score_to_data
{
    public function up()
    {
        \DBUtil::add_fields('data', array(
            'score' => array('constraint' => 11,    'type' => 'int'),
        ));
    }

    public function down()
    {
        \DBUtil::drop_fields('data', array(
            'score',
        ));
    }
}