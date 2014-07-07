<?php

namespace Fuel\Migrations;

Class Create_clientarea_type_docuemnts_status
{
    
    public function up(){

        \DBUtil::create_table('clientarea_type_documents_status', array(
            'id'            => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'description'   => array('type' => 'varchar', 'constraint' => 60)
        ), array('id'));

    }

    public function down(){

        \DBUtil::drop_table('clientarea_type_documents_status');

    }

}