<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

Action - 13:03:52 --> Del_Spam - Visit to page calendar/view by Simon Skinner
Error - 13:03:52 --> 8 - Undefined variable: title in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/app/views/template.php on line 7
Error - 13:03:52 --> 8 - Undefined variable: content in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/app/views/template.php on line 233
Debug - 15:05:34 --> Migrate class initialized
Error - 15:05:34 --> 42000 - SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(0) NOT NULL,
	`created_at` int(11) NOT NULL,
	`updated_at` int(11) NOT NULL,
	P' at line 6 with query: "CREATE TABLE IF NOT EXISTS `calendar_holidays` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`date_from` date NOT NULL,
	`date_to` date NOT NULL,
	`authorised` bool(0) NOT NULL,
	`created_at` int(11) NOT NULL,
	`updated_at` int(11) NOT NULL,
	PRIMARY KEY `id` (`id`)
) DEFAULT CHARACTER SET utf8;" in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/core/classes/database/pdo/connection.php on line 175
Debug - 15:07:24 --> Migrate class initialized
