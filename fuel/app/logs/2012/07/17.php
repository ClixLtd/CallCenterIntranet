<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

Error - 2012-07-17 07:51:01 --> 2003 - SQLSTATE[HY000] [2003] Can't connect to MySQL server on '122.54.87.162' (4) in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 87
Error - 2012-07-17 08:04:05 --> 8 - Undefined index: name in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/form/instance.php on line 221
Error - 2012-07-17 08:04:57 --> 8 - Undefined index: name in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/form/instance.php on line 221
Error - 2012-07-17 08:07:58 --> 8 - Trying to get property of non-object in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/app/views/database/query/_form.php on line 42
Error - 2012-07-17 08:07:58 --> 8 - Trying to get property of non-object in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/app/views/database/query/_form.php on line 42
Error - 2012-07-17 08:07:58 --> 8 - Trying to get property of non-object in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/app/views/database/query/_form.php on line 42
Error - 2012-07-17 08:07:58 --> 8 - Undefined index: name in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/form/instance.php on line 221
Error - 2012-07-17 08:08:10 --> 2 - Illegal string offset 'title' in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/app/views/database/query/_form.php on line 42
Error - 2012-07-17 08:08:10 --> 2 - Illegal string offset 'title' in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/app/views/database/query/_form.php on line 42
Error - 2012-07-17 08:08:10 --> 2 - Illegal string offset 'title' in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/app/views/database/query/_form.php on line 42
Error - 2012-07-17 08:08:10 --> 8 - Undefined index: name in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/form/instance.php on line 221
Error - 2012-07-17 08:08:53 --> 8 - Undefined index: name in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/form/instance.php on line 221
Error - 2012-07-17 08:09:11 --> 8 - Undefined index: name in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/form/instance.php on line 221
Error - 2012-07-17 09:13:09 --> 2003 - SQLSTATE[HY000] [2003] Can't connect to MySQL server on '122.54.87.162' (4) in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 87
Error - 2012-07-17 09:41:59 --> Error - SQLSTATE[42S22]: Column not found: 1054 Unknown column 'VL.active' in 'where clause' with query: "SELECT count(lead_id)
FROM vicidial_lists AS VC
LEFT JOIN vicidial_list AS VL ON VL.list_id=VC.list_id
WHERE VL.active='Y' AND VL.campaign_id='BURTON1' AND VL.status='NEW';" in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 167
Error - 2012-07-17 09:43:45 --> Error - SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AS Campaign, count(VL.lead_id) AS Total
FROM vicidial_lists AS VC
LEFT JOIN vi' at line 1 with query: "SELECT VC.campaign_id, AS Campaign, count(VL.lead_id) AS Total
FROM vicidial_lists AS VC
LEFT JOIN vicidial_list AS VL ON VL.list_id=VC.list_id
WHERE VC.active='Y' AND VL.status='NEW'
GROUP BY VC.campaign_id;" in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 167
Error - 2012-07-17 12:16:54 --> 2 - fopen(http://github.com/fuel-packages/fuel-ldap/zipball/master): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/packages/oil/classes/package.php on line 53
Error - 2012-07-17 12:16:56 --> 2 - fopen(http://github.com/axelitus/fuel-ldap/zipball/master): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/packages/oil/classes/package.php on line 53
Error - 2012-07-17 12:17:02 --> 2 - fopen(http://github.com/fuel-packages/fuel-fuel-pkg-ldap/zipball/master): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/packages/oil/classes/package.php on line 53
Error - 2012-07-17 12:17:04 --> 2 - fopen(http://github.com/axelitus/fuel-fuel-pkg-ldap/zipball/master): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/packages/oil/classes/package.php on line 53
Error - 2012-07-17 12:18:27 --> 2 - fopen(http://github.com/fuel-packages/fuel-fuel-pkg-ldap/zipball/master): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/packages/oil/classes/package.php on line 53
Error - 2012-07-17 12:18:32 --> 2 - fopen(http://github.com/fuel-packages/fuel-ldap/zipball/master): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/packages/oil/classes/package.php on line 53
Error - 2012-07-17 12:41:54 --> 2003 - SQLSTATE[HY000] [2003] Can't connect to MySQL server on '109.108.138.82' (4) in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 87
Error - 2012-07-17 12:43:27 --> Error - could not find driver in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 87
Error - 2012-07-17 12:43:28 --> Error - could not find driver in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 87
Error - 2012-07-17 12:44:34 --> Error - could not find driver in /Users/simonskinner/Dropbox/Gregson and Brooke/Websites/intranet/fuel/core/classes/database/pdo/connection.php on line 87
