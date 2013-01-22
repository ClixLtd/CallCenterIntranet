<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

Action - 07:29:03 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:29:40 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:30:41 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Error - 07:30:41 --> Error - SQLSTATE[42S22]: Column not found: 1054 Unknown column 'R.id' in 'order clause' with query: "SELECT
							      CPC.referral_id AS 'Referral ID'
							    , CPC.client_id AS 'Client ID'
							  FROM
							    crm_ppi_clients AS CPC
							  WHERE 
							    CPC.pack_returned_date <> '0000-00-00'
							  	AND DATE(CPC.pack_returned_date) >= '2012-12-01' AND DATE(CPC.pack_returned_date) <= '2013-01-15'
							  ORDER BY
							    R.id DESC;" in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/core/classes/database/pdo/connection.php on line 175
Action - 07:31:01 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:31:32 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:31:44 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Error - 07:31:45 --> 8 - Undefined index: packIns in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/packages/crm/subpackage/reports/view/ppi/disposition.php on line 72
Action - 07:32:44 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:34:21 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:37:07 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Error - 07:37:07 --> Error - SQLSTATE[42S22]: Column not found: 1054 Unknown column 'CD.id' in 'on clause' with query: "SELECT
							      CPC.referral_id AS 'Referral ID'
							    , CPC.client_id AS 'Client ID'
							    , CCD.forename AS Forename
							    , CCD.surname AS Surname
							    , CR.introducer_agent_name AS 'Agent Name'
							    , U.name AS 'Consolidator Name'
							    , CPC.pack_sent_date AS 'Pack Out'
							    , CPC.pack_returned_date AS 'Pack In'
							  FROM
							    crm_ppi_clients AS CPC
							  LEFT JOIN
							    crm_client_details AS CCD ON CPC.client_id=CCD.id
							  LEFT JOIN
							    crm_referrals AS CR ON CPC.referral_id=CD.id
							  LEFT JOIN
							    users AS U ON CR.user_id=U.id
							  WHERE 
							    CPC.pack_returned_date <> '0000-00-00'
							  	AND DATE(CPC.pack_returned_date) >= '2012-12-01' AND DATE(CPC.pack_returned_date) <= '2013-01-15'
							  ORDER BY
							    CPC.client_id DESC;" in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/core/classes/database/pdo/connection.php on line 175
Action - 07:37:31 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:39:47 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:40:44 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:41:53 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Error - 07:41:53 --> Error - SQLSTATE[42S22]: Column not found: 1054 Unknown column 'R.introducer_agent_name' in 'field list' with query: "SELECT
							      CPC.referral_id AS 'Referral ID'
							    , CPC.client_id AS 'Client ID'
							    , CCD.forename AS Forename
							    , CCD.surname AS Surname
							    , CC.shortcode AS Introducer
							    , R.introducer_agent_name AS 'Agent Name'
							    , U.name AS 'Consolidator Name'
							    , CCC.shortcode AS 'Consolidator Center'
							    , CPC.pack_sent_date AS 'Pack Out'
							    , CPC.pack_returned_date AS 'Pack In'
							  FROM
							    crm_ppi_clients AS CPC
							  LEFT JOIN
							    crm_client_details AS CCD ON CPC.client_id=CCD.id
							  LEFT JOIN
							    crm_referrals AS CR ON CPC.referral_id=R.id
							  LEFT JOIN 
							    call_centers AS CC ON R.introducer_id=CC.id
							  LEFT JOIN 
							    call_centers AS CCC ON R.consolidation_centre=CCC.id
							  LEFT JOIN
							    users AS U ON CR.user_id=U.id
							  WHERE 
							    CPC.pack_returned_date <> '0000-00-00'
							  	AND DATE(CPC.pack_returned_date) >= '2012-12-01' AND DATE(CPC.pack_returned_date) <= '2013-01-15'
							  	
							  ORDER BY
							    CPC.client_id DESC;" in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/core/classes/database/pdo/connection.php on line 175
Action - 07:42:13 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Error - 07:42:13 --> Error - SQLSTATE[42S22]: Column not found: 1054 Unknown column 'CR.user_id' in 'on clause' with query: "SELECT
							      CPC.referral_id AS 'Referral ID'
							    , CPC.client_id AS 'Client ID'
							    , CCD.forename AS Forename
							    , CCD.surname AS Surname
							    , CC.shortcode AS Introducer
							    , R.introducer_agent_name AS 'Agent Name'
							    , U.name AS 'Consolidator Name'
							    , CCC.shortcode AS 'Consolidator Center'
							    , CPC.pack_sent_date AS 'Pack Out'
							    , CPC.pack_returned_date AS 'Pack In'
							  FROM
							    crm_ppi_clients AS CPC
							  LEFT JOIN
							    crm_client_details AS CCD ON CPC.client_id=CCD.id
							  LEFT JOIN
							    crm_referrals AS R ON CPC.referral_id=R.id
							  LEFT JOIN 
							    call_centers AS CC ON R.introducer_id=CC.id
							  LEFT JOIN 
							    call_centers AS CCC ON R.consolidation_centre=CCC.id
							  LEFT JOIN
							    users AS U ON CR.user_id=U.id
							  WHERE 
							    CPC.pack_returned_date <> '0000-00-00'
							  	AND DATE(CPC.pack_returned_date) >= '2012-12-01' AND DATE(CPC.pack_returned_date) <= '2013-01-15'
							  	
							  ORDER BY
							    CPC.client_id DESC;" in /Volumes/HardDrive/Dropboxs/GregsonAndBrooke/Dropbox/GregsonAndBrooke/Websites/intranet-live/fuel/core/classes/database/pdo/connection.php on line 175
Action - 07:42:40 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:42:53 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:46:33 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:46:40 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:47:38 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:51:08 --> Del_Spam - Visit to page crm/ppi/referrals by Simon Skinner
Action - 07:51:14 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
Action - 07:51:19 --> Del_Spam - Visit to page crm/reports/ppi/disposition by Simon Skinner
