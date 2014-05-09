<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 14/02/14
 * Time: 12:09
 */

namespace Fuel\Migrations;

class Alter_clientarea_companies_add_components
{
    public function up()
    {
        \DB::query('ALTER TABLE `clientarea_companies` ADD `components` TEXT NOT NULL AFTER `company_name`;')->execute();
    }

    public function down()
    {
        \DB::query('ALTER TABLE `clientarea_companies` DROP `components`;')->execute();
    }
}