<?php

namespace Fuel\Migrations;

class Create_scripts_forms_reponses_log
{
  public function up()
  {
    \DBUtil::create_table('scripts_forms_responses_log', array(
      'id'             => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'referral_id'    => array('constraint' => 11, 'type' => 'int'),
      'client_id'      => array('constraint' => 11, 'type' => 'int'),
      'script_type_id' => array('constraint' => 11, 'type' => 'int'),
      'user_id'        => array('constraint' => 11, 'type' => 'int'),
      'created_at'     => array('constraint' => 11, 'type' => 'int'),
    ), array('id'));
    
    // -- Change the referrence field on the scripts_forms_responses
    // -------------------------------------------------------------
    \DB::query("ALTER TABLE `scripts_forms_responses` DROP `reference`")->execute();
    \DB::query("ALTER TABLE  `scripts_forms_responses` ADD  `response_log_id` INT UNSIGNED NOT NULL AFTER  `id` ,ADD INDEX (  `response_log_id` )")->execute();
  }
  
  public function down()
  {
    \DBUtil::drop_table('scripts_forms');
    \DB::query("ALTER TABLE  `scripts_forms_responses` ADD  `reference` VARCHAR( 200 ) NOT NULL AFTER  `repeat_group`")->execute();
  }
}