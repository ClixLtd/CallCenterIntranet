<?php

namespace Fuel\Migrations;

class create_scripts_tables
{
  public function up()
  {
    // -- [ Scripts Table ]
    // --------------------
    \DBUtil::create_table('scripts', array(
      'id'    => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'script_type_id'       => array('constraint' => 11, 'type' => 'int'),
      'name'                 => array('constraint' => 200, 'type' => 'varchar'),
      'description'          => array('constraint' => 200, 'type' => 'varchar'),
      'script_text'          => array('type' => 'longtext'),
      'active'               => array('constraint' => "'yes','no'", 'type' => 'enum', 'default' => 'yes'),
    ), array('id'));
    
    
    // -- [ Script Type ]
    // ------------------
    \DBUtil::create_table('type_scripts', array(
      'id'    => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'description'       => array('constraint' => 100, 'type' => 'varchar'),
    ), array('id'));
    
      // -- [ Script Type Defaults]
      // --------------------------
      \DB::insert('type_scripts')->set(array('description' => 'Tele Sales'))->execute();
      \DB::insert('type_scripts')->set(array('description' => 'Consolidation'))->execute();     
  }
  
  public function down()
  {
    \DBUtil::drop_table('scripts');
    \DBUtil::drop_table('type_scripts');
  }
}