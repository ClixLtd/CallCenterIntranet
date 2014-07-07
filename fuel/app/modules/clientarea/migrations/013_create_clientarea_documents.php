<?php

namespace Fuel\Migrations;

Class Create_clientarea_documents
{

    public function up()
    {
        \DBUtil::create_table('clientarea_documents', array(
            'id'            => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'client_id'     => array('type' => 'int', 'constraint' => 11),
            'compnay_id'    => array('type' => 'int', 'constraint' => 11),
            'location'      => array('type' => 'varchar', 'constraint' => 255),
            'filename'      => array('type' => 'varchar', 'constraint' => 255),
            'status'        => array('type' => 'int', 'constraint' => 11),
            'actioned_by'   => array('type' => 'int', 'constraint' => 11),
            'created_at'    => array('type' => 'datetime', 'defaut' => DB::expr('NOW()')),
            'updated_at'    => array('type' => 'datetime'),
        ), array('id'));

        \DBUtil::create_index('clientarea_documents', 'actioned_by');
    }

    public function down()
    {
        \DBUtil::drop_table('clientarea_documents');
    }

}