<?php

class Controller_Heartbeat extends Controller_BaseApi
{
	
	
	
	
	public function get_single_server_stats($server)
	{
    	
    	date_default_timezone_set('Europe/London');
    	
    	$stats = \Model_Server_Statistic::find()->where('server', $server)->order_by('created_at','DESC')->get_one();
    	
    	$returnArray = unserialize($stats->server_stats);
    	
    	$this->response(array(
    	   'stats' => $returnArray,
    	));
    	
	}
	
	
	
	public function get_server_stats($value)
	{
    	
    	date_default_timezone_set('Europe/London');
		
		$time_limit = $this->param('showtime');
		
    	$servers = array(
    	   'GAB Dialler 1' => 'go.goautodial.org',
    	   'GAB Dialler 2' => 'dialler2.gab.local',
    	   'GAB Dialler 3' => 'dialler1.gab.local',
    	   'GAB Database 1' => 'skywalker.gab.local',
    	   'RESOLVE Dialler 1' => 'dialler1.resolve.local',
    	   'RESOLVE Database 1' => 'database1.resolve.local',
    	);
    	
    	$allStats = array();
    	foreach ($servers AS $serverName => $server)
    	{
        	$stats = \Model_Server_Statistic::find()->where('server', $server);
        	
        	
        	if (!is_null($time_limit))
    		{
    			$time_strings = Array(
    				'10m' => '10 minutes ago',
    				'30m' => '30 minutes ago',
    				'1h' => '1 hour ago',
    				'2h' => '2 hours ago',
    				'6h' => '6 hours ago',
    				'12h' => '12 hours ago',
    				'1d' => '1 day ago',
    				'1w' => '1 week ago',
    			);
    		
    			$stats = $stats->where('created_at', '>=', strtotime(date("Y-m-d H:i:s", strtotime($time_strings[$time_limit]))));
    		}
    		else
    		{
    			$stats = $stats->where('created_at', '>=', strtotime(date("Y-m-d 08:55:00")))->where('created_at', '<=', strtotime(date("Y-m-d 20:05:00")));
    		}
    		
    		$stats = $stats->order_by('created_at','asc')->get();
        	
        	
        	foreach ($stats AS $singleStat)
        	{
        	   $statArray = unserialize($singleStat->server_stats);
        	   
        	   $allStats[$server]['label'] = $serverName;
        	   
        	   if ( isset($statArray[$value]) )
        	   {
        	       $allStats[$server]['data'][] = array( ((int)$singleStat->created_at * 1000), $statArray[$value]);
        	   }
        	   
        	}
        	
        	
    	}
    	
    	$this->response($allStats);
    	
	}
	
	
	
	
	public function submit_ticket($subject=null, $message=null, $department=1, $priority=3)
	{
		date_default_timezone_set('Europe/London');
		
		
		$submitUrl = "http://www.gregsonandbrooke.co.uk/support/open.php";
		
		$openTicket = array(
		  'name'      => 'A.D.A.M.',
		  'email'     => 'a.d.a.m@gregsonandbrooke.co.uk',
		  'phone'     => '01204860900',
		  'phone_ext' => '4000',
		  'topicId'   => $department,
		  'subject'   => $subject,
		  'message'   => $message,
		  'pri'       => $priority,
		);
		
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $submitUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $openTicket);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        \Log::write('SUPPORT', "Support ticket has been submitted with the title '".$subject."'");
		
	}

	// Server Statistics
	public function post_server_stats($server)
	{
    	$new = Model_Server_Statistic::forge();
    	$new->server = $server;
    	$new->server_stats = serialize($_POST);
    	$new->save();
    	
    	
    	if ( (int)$_POST['harddisk'] <= 5 )
    	{
        	$previous_alerts = \Model_Adam_Announcement::find()->where('campaign', $server)->where('alert_type', 'SERVERSPACE15');
				
        	if ($previous_alerts->count() == 0)
        	{
        	   Controller_Heartbeat::submit_ticket("Disk Space Low on " . $server, "Disk space on server " . $server . " is running low. Currently at ". $_POST['harddisk'] . "% Free!", 1, 4);
        	   
        	   $adam_announcement = \Model_Adam_Announcement::forge(array(
					'campaign' => $server,
					'alert_type' => "SERVERSPACE15",
					'remove_date' => date("Y-m-d H:i:s",strtotime("+15 minutes")),
				));
				$adam_announcement->save();
        	}
				
        	
    	} else if ( (int)$_POST['harddisk'] <= 10 )
    	{
        	$previous_alerts = \Model_Adam_Announcement::find()->where('campaign', $server)->where('alert_type', 'SERVERSPACE60');
				
        	if ($previous_alerts->count() == 0)
        	{
        	   Controller_Heartbeat::submit_ticket("Disk Space Low on " . $server, "Disk space on server " . $server . " is running low. Currently at ". $_POST['harddisk'] . "% Free!", 1, 3);
        	   
        	   $adam_announcement = \Model_Adam_Announcement::forge(array(
					'campaign' => $server,
					'alert_type' => "SERVERSPACE60",
					'remove_date' => date("Y-m-d H:i:s",strtotime("+60 minutes")),
				));
				$adam_announcement->save();
        	}
    	}
    	
    	$this->response(
           'SUCCESS'
    	);
    	
	}
	
	
}