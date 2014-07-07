<?php
/**
 * Adds setting column to companies table
 */
namespace Fuel\Migrations;

class Alter_clientarea_companies_add_components
{
    public function up()
    {
        \DB::query("CREATE TABLE IF NOT EXISTS `clientarea_message_attachments` (
                      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                      `message_post_id` int(10) unsigned NOT NULL,
                      `filename` varchar(255) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;")->execute();
    }

    public function down()
    {
        \DB::query("DROP TABLE `clientarea_message_attachments`")->execute();
    }
}