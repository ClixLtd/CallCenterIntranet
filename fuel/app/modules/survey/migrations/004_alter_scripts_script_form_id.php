<?php

namespace Fuel\Migrations;

class Alter_scripts_script_form_id
{
  public function up()
  {
    \DB::query("ALTER TABLE  `scripts` ADD  `script_form_id` INT UNSIGNED NOT NULL AFTER  `script_type_id`")->execute();
  }
  
  public function down()
  {
    \DB::query("ALTER TABLE `scripts` DROP `script_form_id`")->execute();
  }
}