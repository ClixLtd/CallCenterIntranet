<?php

namespace Fuel\Migrations;

class Create_scripts_forms_products
{
  public function up()
  {
    // -- [ Scripts Form Products Table ]
    // ----------------------------------
    \DBUtil::create_table('scripts_forms_products', array(
      'id'                   => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'name'                 => array('constraint' => 200, 'type' => 'varchar'),
      'description'          => array('type' => 'text'),
    ), array('id'));
    
    // -- [ Scripts Forms Questions Products Table ]
    // --------------------
    \DBUtil::create_table('scripts_forms_questions_products', array(
      'id'    => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'question_id'                 => array('constraint' => 11, 'type' => 'int'),
      'product_id'                  => array('constraint' => 11, 'type' => 'int'),
      'positive_value'              => array('constraint' => 100, 'type' => 'varchar'),
      'negative_value'              => array('constraint' => 100, 'type' => 'varchar'),
      'weight'                      => array('constraint' => 11, 'type' => 'int'),
      'priority'                    => array('constraint' => 11, 'type' => 'int'),
    ), array('id'));
    
    // -- [ Scripts Forms Questions Products Table ]
    // --------------------
    \DBUtil::create_table('scripts_forms_responses_products', array(
      'id'                => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'response_log_id'   => array('constraint' => 11, 'type' => 'int'),
      'product_id'        => array('constraint' => 11, 'type' => 'int'),
      'callback'          => array('constraint' => '"yes","no"', 'type' => 'enum', 'default' => 'no'),
    ), array('id'));
    
    \DB::query("ALTER TABLE  `scripts_forms` ADD  `rebuttal_script` VARCHAR( 250 ) NOT NULL AFTER  `repeat`")->execute();
  }
  
  public function down()
  {
    \DBUtil::drop_table('scripts_forms_products');
    \DBUtil::drop_table('scripts_forms_questions_products');
    \DBUtil::drop_table('scripts_forms_responses_products');
    
    \DB::query("ALTER TABLE `scripts_forms` DROP `rebuttal_script`")->execute();
  }
}