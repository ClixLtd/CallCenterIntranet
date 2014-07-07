<?php
/**
 * Adds setting column to companies table
 */
namespace Fuel\Migrations;

class Alter_clientarea_companies_add_components
{
    public function up()
    {
        \DB::query("ALTER TABLE `clientarea_companies` ADD `settings` TEXT NOT NULL AFTER `components`;")->execute();
    }

    public function down()
    {
        \DB::query('ALTER TABLE `clientarea_companies` DROP `settings`;')->execute();
    }
}