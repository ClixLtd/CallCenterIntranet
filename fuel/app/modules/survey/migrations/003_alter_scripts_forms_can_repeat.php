<?php

namespace Fuel\Migrations;

class Alter_scripts_forms_can_repeat
{
  public function up()
  {
    \DB::query("ALTER TABLE  `scripts_forms` ADD  `repeat` ENUM(  'yes',  'no' ) NOT NULL DEFAULT  'no' AFTER  `name`")->execute();
  }
  
  public function down()
  {
    \DB::query("ALTER TABLE `scripts_forms` DROP `repeat`")->execute();
  }
}