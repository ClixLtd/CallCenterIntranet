<?php

namespace Fuel\Migrations;

class Create_scripts_forms_tables
{
  public function up()
  {
    // -- [ Scripts Forms Table ]
    // --------------------------
    \DBUtil::create_table('scripts_forms', array(
      'id'            => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'name'          => array('constraint' => 200, 'type' => 'varchar'),
      'active'        => array('constraint' => "'yes','no'", 'type' => 'enum', 'default' => 'yes'),
      'created_at'    => array('constraint' => 11, 'type' => 'int'),
    ), array('id'));
    
    
    // -- [ Script Form Questions ]
    // ----------------------------
    \DBUtil::create_table('scripts_forms_questions', array(
      'id'              => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'script_form_id'  => array('constraint' => 11, 'type' => 'int'),
      'question'        => array('constraint' => 200, 'type' => 'varchar'),
      'type_field_id'         => array('constraint' => 11, 'type' => 'int'),
      'required'        => array('constraint' => "'yes','no'", 'type' => 'enum', 'default' => 'yes'),
    ), array('id'));
    
    
    // -- [ Script Form Types ]
    // ------------------------
    \DBUtil::create_table('type_scripts_forms_fields', array(
      'id'           => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'description'  => array('constraint' => 100, 'type' => 'varchar'),
      'type'         => array('constraint' => 50, 'type' => 'varchar'),
      'ajax_call'    => array('constraint' => 300, 'type' => 'varchar'),
    ), array('id'));    
    
      // -- [ Script Type Defaults]
      // --------------------------
      \DB::insert('type_scripts_forms_fields')->set(array('description' => 'Textbox', 'type' => 'text'))->execute();
      \DB::insert('type_scripts_forms_fields')->set(array('description' => 'Textarea', 'type' => 'textarea'))->execute();
      \DB::insert('type_scripts_forms_fields')->set(array('description' => 'Checkboxes', 'type' => 'checkbox'))->execute();
      \DB::insert('type_scripts_forms_fields')->set(array('description' => 'Radio Buttons', 'type' => 'radio'))->execute();
      \DB::insert('type_scripts_forms_fields')->set(array('description' => 'Select Menu', 'type' => 'select'))->execute();
      
      
    // -- [ Script Form Answers ]
    // --------------------------
    \DBUtil::create_table('scripts_forms_answers', array(
      'id'                        => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'script_forms_question_id'  => array('constraint' => 11, 'type' => 'int'),
      'option_name'               => array('constraint' => 200, 'type' => 'varchar'),
      'option_value'              => array('constraint' => 200, 'type' => 'varchar'),
    ), array('id'));
    
    
    // -- [ Script Form Responses ]
    // ----------------------------
    \DBUtil::create_table('scripts_forms_responses', array(
      'id'                        => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
      'script_forms_id'           => array('constraint' => 11, 'type' => 'int'),
      'script_forms_question_id'  => array('constraint' => 11, 'type' => 'int'),
      'script_forms_answer_id'    => array('constraint' => 11, 'type' => 'int'),
      'reference_group'           => array('constraint' => 200, 'type' => 'varchar'),
      'reference'                 => array('constraint' => 200, 'type' => 'varchar'),
    ), array('id'));
  }
  
  public function down()
  {
    \DBUtil::drop_table('scripts_forms');
    \DBUtil::drop_table('scripts_forms_questions');
    \DBUtil::drop_table('type_scripts_forms_fields');
    \DBUtil::drop_table('scripts_forms_answers');
    \DBUtil::drop_table('scripts_forms_answers');
  }
}