<?php

namespace Fuel\Migrations;

class Create_clientarea_client_change_profile
{
	public function up()
	{
		\DBUtil::create_table('clientarea_client_change_profile', array(
			'id'              => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'client_id'       => array('constraint' => 11, 'type' => 'int'),
			'company_id'      => array('constraint' => 11, 'type' => 'int'),
      'field'           => array('constraint' => 100, 'type' => 'varchar'),
      'old_value'       => array('type' => 'text'),
      'new_value'       => array('type' => 'text'),
      'date_requested'  => array('type' => 'datetime'),
      'approved_by'     => array('constraint' => 11, 'type' => 'int'),
      'date_approved'   => array('type' => 'datetime'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_client_change_profile');
	}
}