<?php

	Autoloader::add_classes(array(
		// Classes
		'Goautodial\\Wallboard' => __DIR__.'/classes/wallboard.php',
		'Goautodial\\Live' => __DIR__.'/classes/live.php',
		'Goautodial\\Orm' => __DIR__.'/classes/orm.php',
		'Goautodial\\Insert' => __DIR__.'/classes/insert.php',
		
		
		
		
		'Controller_Testclass' => __DIR__.'/classes/testclass.php',
		
		
		// Models
		'Goautodial\\Model_Vicidial_List' => __DIR__.'/models/vicidial_list.php',
		'Goautodial\\Model_Vicidial_Log' => __DIR__.'/models/vicidial_log.php',
		'Goautodial\\Model_Vicidial_Live_Agents' => __DIR__.'/models/vicidial_live_agents.php',
		'Goautodial\\Model_Vicidial_Auto_Calls' => __DIR__.'/models/vicidial_auto_calls.php',
		'Goautodial\\Model_Vicidial_Campaign_Stats' => __DIR__.'/models/vicidial_campaign_stats.php',
		'Goautodial\\Model_Vicidial_Campaign_Stats_Gipltd' => __DIR__.'/models/vicidial_campaign_stats_gipltd.php',
		'Goautodial\\Model_Vicidial_Closer_Log' => __DIR__.'/models/vicidial_closer_log.php',
		'Goautodial\\Model_Vicidial_Campaigns' => __DIR__.'/models/vicidial_campaigns.php',
		'Goautodial\\Model_Vicidial_Campaigns_Gipltd' => __DIR__.'/models/vicidial_campaigns_gipltd.php',
		'Goautodial\\Model_Vicidial_Users' => __DIR__.'/models/vicidial_users.php',
	));