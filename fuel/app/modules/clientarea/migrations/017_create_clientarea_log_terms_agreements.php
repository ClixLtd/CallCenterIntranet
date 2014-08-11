<?php

namespace Fuel\Migrations;

class Install_clientarea_terms_agreement
{
    public function up()
    {
        \DBUtil::create_table('clientarea_log_terms_agreements', array(
            'id'               => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'client_id'        => array('constraint' => 11, 'type' => 'int'),
            'company_id'       => array('constraint' => 11, 'type' => 'int'),
            'terms_id'         => array('constraint' => 11, 'type' => 'int'),
            'accepted_at'      => array('type' => 'datetime'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('clientarea_log_terms_agreements');
    }
}