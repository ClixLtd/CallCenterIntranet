<?php

namespace Fuel\Migrations;

class Alter_clientarea_companies_add_centre_id
{
    public function up()
    {
        \DB::query('ALTER TABLE  `clientarea_companies` ADD  `call_center_id` INT UNSIGNED NOT NULL AFTER  `id`')->execute();
    }

    public function down()
    {
        \DB::query('ALTER TABLE `clientarea_companies` DROP `call_center_id`')->execute();
    }
}