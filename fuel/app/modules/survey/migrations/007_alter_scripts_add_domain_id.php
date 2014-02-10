<?php

namespace Fuel\Migrations;

class Alter_scripts_add_domain_id
{
  public function up()
  {
    \DB::query("ALTER TABLE  `scripts` ADD  `domain_id` int( 11 ) NOT NULL AFTER  `id`")->execute();
    \DB::query("ALTER TABLE  `scripts_forms` ADD  `domain_id` int( 11 ) NOT NULL AFTER  `id`")->execute();
  }
  
  public function down()
  {
    \DB::query("ALTER TABLE `scripts` DROP `domain_id`")->execute();
    \DB::query("ALTER TABLE `scripts_forms` DROP `domain_id`")->execute();
  }
}