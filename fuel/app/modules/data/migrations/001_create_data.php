<?php

namespace Fuel\Migrations;

class Create_data
{
	public function up()
	{
        \DBUtil::create_table('data', array(
            'id'                 => array('constraint' => 11,    'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'supplier_id'        => array('constraint' => 11,    'type' => 'int'),
            'dialler_id'         => array('constraint' => 11,    'type' => 'int'),
            'import_status'      => array('constraint' => 11,    'type' => 'int'),
            'headers'            => array('type' => 'text'),
            'import_options'     => array('type' => 'text'),
            'filename'           => array('constraint' => 255,   'type' => 'varchar'),
            'cost'               => array('constraint' => '7,2', 'type' => 'float'),
            
            'purchased_leads'    => array('constraint' => 11,    'type' => 'int'),
            'duplicates'         => array('constraint' => 11,    'type' => 'int'),
            'tps'                => array('constraint' => 11,    'type' => 'int'),
            'dialable_leads'     => array('constraint' => 11,    'type' => 'int'),
            'contacted_leads'    => array('constraint' => 11,    'type' => 'int'),
                                                                 
            'referrals'          => array('constraint' => 11,    'type' => 'int'),
            'pack_out'           => array('constraint' => 11,    'type' => 'int'),
            'pack_in'            => array('constraint' => 11,    'type' => 'int'),
            'first_payment'      => array('constraint' => 11,    'type' => 'int'),
            
            'reset_soft'         => array('constraint' => 11,    'type' => 'int'),
            'reset_hard'         => array('constraint' => 11,    'type' => 'int'),
        ), array('id'));
	}

	public function down()
	{
    	\DBUtil::drop_table('data');
	}
}