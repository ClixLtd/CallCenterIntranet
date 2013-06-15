<?php

namespace Fuel\Migrations;

class Create_clientarea_messages_posts
{
	public function up()
	{
		\DBUtil::create_table('clientarea_messages_posts', array(
			'id'           => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'message_id'   => array('constraint' => 11, 'type' => 'int'),
			'user_id'      => array('constraint' => 11, 'type' => 'int'),
      'from'         => array('constraint' => "'client','user'", 'type' => 'enum'),
      'message'      => array('type' => 'mediumtext'),
      'date'         => array('type' => 'datetime'),
      'status_id'    => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('clientarea_messages_posts');
	}
}