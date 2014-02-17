<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 14/02/14
 * Time: 12:09
 */

 namespace Fuel\Migrations;

 class Alter_clientarea_companies_remove_centre_id
 {
     public function up()
     {
         \DB::query('ALTER TABLE `clientarea_companies` DROP `call_center_id`')->execute();
         \DB::query('ALTER TABLE `clientarea_companies` CHANGE  `id`  `id` INT( 10 ) UNSIGNED NOT NULL')->execute();
     }

     public function down()
     {
         \DB::query('ALTER TABLE  `clientarea_companies` CHANGE  `id`  `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT');
     }
 }