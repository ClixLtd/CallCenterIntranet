<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

Warning - 10:56:42 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
Warning - 10:56:43 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
Warning - 10:56:46 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
Warning - 10:56:46 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
Warning - 10:56:49 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
Warning - 10:56:50 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
Warning - 10:56:53 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
Warning - 10:59:10 --> Fuel\Core\Fuel::init - The configured locale en is not installed on your system.
Warning - 10:59:12 --> Fuel\Core\Fuel::init - The configured locale en is not installed on your system.
Action - 10:59:39 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 11:00:13 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 11:11:25 --> Del_Spam - Visit to page crm/add_creditor/268/6290 by David Stansfield
Action - 11:11:25 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 11:12:15 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 12:33:34 --> Del_Spam - Visit to page user/logout by David Stansfield
Action - 12:33:50 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Error - 12:33:50 --> 42000 - SQLSTATE[42000]: Syntax error or access violation: 1066 Not unique table/alias: 'PC' with query: "SELECT
    	                        PC.client_id AS 'Client ID',
    	                        CCD.forename AS 'First Name',
    	                        CCD.surname AS 'Last Name',
    	                        PC.account_created AS 'Account Created',
    	                        PC.pack_sent_date AS 'Pack Sent Date'
    	                      FROM
    	                        crm_ppi_clients AS PC
    	                      LEFT JOIN
    	                        crm_client_details AS CCD ON PC.client_id=CCD.id
                            LEFT JOIN
                              crm_ppi_correspondence AS PC ON CPC.id = PC.ppi_client_id
    	                      WHERE
    	                        DATE(pack_returned_date) = '0000-00-00'
    	                      ORDER BY
    	                        PC.pack_sent_date" in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\core\classes\database\pdo\connection.php on line 175
Action - 12:37:29 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 12:39:55 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 12:40:11 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 12:40:19 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Error - 12:40:19 --> Error - SQLSTATE[42S22]: Column not found: 1054 Unknown column 'PC.stage_id' in 'where clause' with query: "SELECT
                              PC.client_id AS 'Client ID',
                              CCD.forename AS 'First Name',
                              CCD.surname AS 'Last Name',
                              PC.account_created AS 'Account Created',
                              PC.pack_sent_date AS 'Pack Sent Date'
                            FROM
                              crm_ppi_clients AS PC
                            LEFT JOIN
                              crm_client_details AS CCD ON PC.client_id=CCD.id
                            WHERE
                              PC.stage_id = (SELECT stage_id FROM crm_ppi_correspondence WHERE ppi_client_id = CPC.id ORDER BY date DESC LIMIT 1) AND PC.stage_id = 2 AND PC.status_id = (SELECT status_id FROM crm_ppi_correspondence WHERE ppi_client_id = CPC.id ORDER BY date DESC LIMIT 1) AND PC.status_id = 2
                            ORDER BY
                              PC.date" in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\core\classes\database\pdo\connection.php on line 175
Action - 12:55:03 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 13:01:40 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 13:01:51 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 13:01:58 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Error - 13:01:58 --> Error - SQLSTATE[42S22]: Column not found: 1054 Unknown column 'PC_CHANGE_TO_CPC.date' in 'order clause' with query: "SELECT
                              DISTINCT
                              PC.client_id AS 'Client ID',
                              CCD.forename AS 'First Name',
                              CCD.surname AS 'Last Name',
                              PC.account_created AS 'Account Created',
                              PC.pack_sent_date AS 'Pack Sent Date'
                            FROM
                              crm_ppi_clients AS PC
                            LEFT JOIN
                              crm_client_details AS CCD ON PC.client_id=CCD.id
                            LEFT JOIN
                              crm_ppi_correspondence AS CPC ON PC.id = CPC.ppi_client_id
                            WHERE
                              CPC.stage_id = (SELECT stage_id FROM crm_ppi_correspondence WHERE ppi_client_id = PC.id ORDER BY date DESC LIMIT 1) AND CPC.stage_id = 2 AND CPC.status_id = (SELECT status_id FROM crm_ppi_correspondence WHERE ppi_client_id = PC.id ORDER BY date DESC LIMIT 1) AND CPC.status_id = 2
                            ORDER BY
                              PC_CHANGE_TO_CPC.date" in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\core\classes\database\pdo\connection.php on line 175
Action - 13:02:28 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 13:02:39 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/1 by David Stansfield
Action - 13:02:42 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 13:02:46 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 13:02:53 --> Del_Spam - Visit to page crm/view_client/6278 by David Stansfield
Action - 13:03:02 --> Del_Spam - Visit to page crm/ppi/pack_received/6278 by David Stansfield
Action - 13:03:08 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6278 by David Stansfield
Action - 13:03:08 --> Del_Spam - Visit to page crm/view_client/6278 by David Stansfield
Action - 13:03:18 --> Del_Spam - Visit to page crm/ppi/pack_received/6278 by David Stansfield
Action - 13:03:30 --> Del_Spam - Visit to page crm/view_client/6278 by David Stansfield
Action - 13:03:37 --> Del_Spam - Visit to page crm/ppi/create by David Stansfield
Action - 13:03:46 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 13:03:52 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 13:03:58 --> Del_Spam - Visit to page crm/ppi/pack_received/6290 by David Stansfield
Action - 13:04:08 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6290 by David Stansfield
Action - 13:04:09 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 13:04:23 --> Del_Spam - Visit to page crm/ppi/pack_received/6290 by David Stansfield
Action - 13:04:25 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 13:04:29 --> Del_Spam - Visit to page crm/ppi/pack_received/6290 by David Stansfield
Action - 13:04:31 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6290 by David Stansfield
Action - 13:04:31 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 13:05:04 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 13:05:33 --> Del_Spam - Visit to page crm/ppi/add_correspondence by David Stansfield
Action - 13:05:34 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 13:09:38 --> Del_Spam - Visit to page crm/add_creditor/268/6290 by David Stansfield
Action - 13:09:39 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 13:10:48 --> Del_Spam - Visit to page crm/save_client_information by David Stansfield
Action - 13:10:48 --> Del_Spam - Visit to page crm/view_client/6290 by David Stansfield
Action - 13:11:09 --> Del_Spam - Visit to page crm/reports/ppi/disposition by David Stansfield
Action - 13:53:53 --> Del_Spam - Visit to page crm/reports/ppi/disposition by David Stansfield
Action - 13:55:28 --> Del_Spam - Visit to page crm/ppi/create by David Stansfield
Action - 14:04:48 --> Del_Spam - Visit to page crm/ppi/create_client/0 by David Stansfield
Dispo - 14:04:48 --> Controller_Crm_Ppi::save_current_post() - David Stansfield tried to create a NEW Referral
Dispo - 14:04:48 --> Referrals_model::createReferral() - ["1432",1]
Dispo - 14:04:48 --> Referrals_model::createReferral() - Referral created with the ID of 1432
Dispo - 14:04:48 --> Controller_Crm_Ppi::save_current_post() - David Stansfield created a new client with the ID of 1432
Msg - 14:04:49 --> post_create_client - Create Client: 6665
Dispo - 14:04:49 --> Controller_Crm_Ppi::post_create_client() - David Stansfield created a client from referral ID 1432
PRINTMANAGER - 14:04:50 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/letter/ppi_pack_coverletter_6665.pdf to the print queue for 2013-01-30 20:30:00
PRINTMANAGER - 14:04:52 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/letter/ppi_pack_6665.pdf to the print queue for 2013-01-30 20:30:00
Action - 14:04:52 --> Del_Spam - Visit to page crm/ppi/referral/1432 by David Stansfield
Warning - 14:04:52 --> Crm_Ppi - Consolidator dstansfield tried to access referral 1432 which has been Packed Out as a PPI!
Action - 14:04:52 --> Del_Spam - Visit to page crm/ppi/referrals by David Stansfield
Action - 14:05:07 --> Del_Spam - Visit to page crm/ppi/referral/1432 by David Stansfield
Warning - 14:05:07 --> Crm_Ppi - Consolidator dstansfield tried to access referral 1432 which has been Packed Out as a PPI!
Action - 14:05:07 --> Del_Spam - Visit to page crm/ppi/referrals by David Stansfield
Action - 14:05:42 --> Del_Spam - Visit to page crm/ppi/referral/1432 by David Stansfield
Warning - 14:05:42 --> Crm_Ppi - Consolidator dstansfield tried to access referral 1432 which has been Packed Out as a PPI!
Action - 14:05:42 --> Del_Spam - Visit to page crm/ppi/referrals by David Stansfield
Action - 14:05:56 --> Del_Spam - Visit to page crm/ppi/referrals by David Stansfield
Action - 14:06:04 --> Del_Spam - Visit to page crm/ppi/referral/1432 by David Stansfield
Warning - 14:06:04 --> Crm_Ppi - Consolidator dstansfield tried to access referral 1432 which has been Packed Out as a PPI!
Action - 14:06:04 --> Del_Spam - Visit to page crm/ppi/referrals by David Stansfield
Action - 14:06:25 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 14:06:41 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:09:36 --> Del_Spam - Visit to page crm/add_creditor/1432/6665 by David Stansfield
Action - 14:09:36 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:10:24 --> Del_Spam - Visit to page crm/ppi/pack_received/6665 by David Stansfield
Action - 14:10:43 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6665 by David Stansfield
Error - 14:10:43 --> 8 - Undefined index: TaC in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 87
Error - 14:10:43 --> 8 - Undefined index: Section F in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 93
Action - 14:10:43 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:13:57 --> Del_Spam - Visit to page crm/ppi/pack_received/6665 by David Stansfield
Action - 14:13:59 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:14:16 --> Del_Spam - Visit to page crm/add_note by David Stansfield
Action - 14:14:17 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:16:22 --> Del_Spam - Visit to page crm/save_client_information by David Stansfield
Action - 14:16:22 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:17:51 --> Del_Spam - Visit to page crm/ppi/pack_received/6665 by David Stansfield
Action - 14:17:58 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6665 by David Stansfield
Action - 14:17:58 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:19:07 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 14:19:15 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 14:19:19 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 14:19:29 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/1 by David Stansfield
Action - 14:19:33 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 14:19:38 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 14:19:56 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:21:30 --> Del_Spam - Visit to page crm/ppi/add_correspondence by David Stansfield
Action - 14:21:31 --> Del_Spam - Visit to page crm/view_client/6665 by David Stansfield
Action - 14:21:50 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 14:21:57 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/2 by David Stansfield
Action - 14:22:02 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 14:23:23 --> Del_Spam - Visit to page crm/ppi/stage_statues_list/-1 by David Stansfield
Action - 14:23:26 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 14:26:42 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 15:24:27 --> Del_Spam - Visit to page crm/view_client/6291 by David Stansfield
Action - 15:24:35 --> Del_Spam - Visit to page crm/ppi/pack_received/6291 by David Stansfield
Action - 15:24:42 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6291 by David Stansfield
Error - 15:24:42 --> 8 - Undefined index: Creditor Information in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 77
Error - 15:24:43 --> 8 - Undefined index: LOA in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 94
Error - 15:24:43 --> 8 - Undefined index: TaC in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 111
Error - 15:24:43 --> 8 - Undefined index: Section F in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 127
PRINTMANAGER - 15:24:44 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/letter/ppi_missing_info_pack_300113_6291.pdf to the print queue for 2013-01-30 20:30:00
Action - 15:24:44 --> Del_Spam - Visit to page crm/view_client/6291 by David Stansfield
Action - 15:37:36 --> Del_Spam - Visit to page crm/ppi/pack_received/6291 by David Stansfield
Action - 15:37:38 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6291 by David Stansfield
Action - 15:37:39 --> Del_Spam - Visit to page crm/view_client/6291 by David Stansfield
Action - 15:46:29 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 15:46:36 --> Del_Spam - Visit to page crm/view_client/6292 by David Stansfield
Action - 15:48:00 --> Del_Spam - Visit to page crm/ppi/pack_received/6292 by David Stansfield
Action - 15:48:04 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6292 by David Stansfield
Error - 15:48:04 --> 8 - Undefined index: Creditor Information in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 79
Error - 15:48:04 --> 8 - Undefined index: LOA in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 96
Error - 15:48:04 --> 8 - Undefined index: TaC in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 113
Error - 15:48:04 --> 8 - Undefined index: Section F in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 129
PRINTMANAGER - 15:48:06 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/letter/ppi_missing_info_pack_300113_6292.pdf to the print queue for 2013-01-30 20:30:00
Action - 15:48:06 --> Del_Spam - Visit to page crm/view_client/6292 by David Stansfield
Action - 18:07:37 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 18:07:46 --> Del_Spam - Visit to page crm/view_client/6293 by David Stansfield
Action - 18:08:05 --> Del_Spam - Visit to page crm/ppi/pack_received/6293 by David Stansfield
Action - 18:08:14 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6293 by David Stansfield
Error - 18:08:14 --> 8 - Undefined index: TaC in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 115
Error - 18:08:14 --> 8 - Undefined index: Section F in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 131
PRINTMANAGER - 18:08:16 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/letter/ppi_missing_info_pack_300113_6293.pdf to the print queue for 2013-01-30 20:30:00
PRINTMANAGER - 18:08:16 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/forms/section_f_form.pdf to the print queue for 0000-00-00 00:00:00
Action - 18:08:16 --> Del_Spam - Visit to page crm/view_client/6293 by David Stansfield
Action - 18:13:39 --> Del_Spam - Visit to page crm/reports/ppi/chase by David Stansfield
Action - 18:13:45 --> Del_Spam - Visit to page crm/view_client/6295 by David Stansfield
Error - 18:13:46 --> 8 - Undefined index: -- Unknown Creditor in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\view\view_client.php on line 295
Error - 18:13:46 --> 8 - Undefined index: -- Unknown Creditor in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\view\view_client.php on line 337
Action - 18:14:38 --> Del_Spam - Visit to page crm/ppi/pack_received/6295 by David Stansfield
Action - 18:14:47 --> Del_Spam - Visit to page crm/ppi/pack_in_check/6295 by David Stansfield
Error - 18:14:47 --> 8 - Undefined index: Creditor Information in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 81
Error - 18:14:47 --> 8 - Undefined index: LOA in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 98
Error - 18:14:47 --> 8 - Undefined index: TaC in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 115
Error - 18:14:47 --> 8 - Undefined index: Section F in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\subpackage\ppi\controller\index.php on line 131
PRINTMANAGER - 18:14:48 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/letter/ppi_missing_info_pack_300113_6295.pdf to the print queue for 2013-01-30 20:30:00
PRINTMANAGER - 18:14:48 --> Added the file C:\wwwroot\Gregson-and-Brooke\intranet\public\uploads/crm/forms/section_f_form.pdf to the print queue for 2013-01-30 20:30:00
Action - 18:14:48 --> Del_Spam - Visit to page crm/view_client/6295 by David Stansfield
Error - 18:14:49 --> 8 - Undefined index: -- Unknown Creditor in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\view\view_client.php on line 295
Error - 18:14:49 --> 8 - Undefined index: -- Unknown Creditor in C:\wwwroot\Gregson-and-Brooke\intranet\fuel\packages\crm\view\view_client.php on line 337
