<?php
namespace Fuel\Migrations;

class Alter_Clientarea_Client_Access_Log
{
    public function up()
    {
        \DB::query('ALTER TABLE  `clientarea_change_password` CHANGE  `current_password`  `current_password` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , CHANGE  `new_password`  `new_password` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL')->execute();
    }

    public function down()
    {
        \DB::query('ALTER TABLE  `clientarea_change_password` 
            CHANGE  `current_password`  `current_password` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
            CHANGE  `new_password`  `new_password` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL'
        )->execute();
    }
}