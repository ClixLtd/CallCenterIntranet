<?php

namespace Fuel\Migrations;

class Alter_scripts_forms_responses_add_answers
{
  public function up()
  {
    \DB::query("ALTER TABLE  `scripts_forms_responses` CHANGE  `reference_group`  `repeat_group` INT UNSIGNED NOT NULL")->execute();
    \DB::query("ALTER TABLE  `scripts_forms_responses` ADD  `answer` TEXT NOT NULL")->execute();
  }
  
  public function down()
  {
    \DB::query("ALTER TABLE  `scripts_forms_responses` CHANGE  `repeat_group`  `reference_group` VARCHAR( 200 ) NOT NULL")->execute();
    \DB::query("ALTER TABLE  `scripts_forms_responses` DROP  `answer`")->execute();
  }
}