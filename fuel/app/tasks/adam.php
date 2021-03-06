<?php

	namespace Fuel\Tasks;
	
	class Adam
	{

		
		public static $casual_introductions = array(
			'Hiya. ',
			'¡Hola amigos! ',
			'Good day! ',
			'Hello. ',
			'Hi friend. ',
		);
		
		public static $moderate_introductions = array(
			'You may want to see this. ',
			'Oh deary me. ',
			'Yo, so, check it. ',
			'Amber alert. ',
			'Watch out. ',
		);
		
		public static $emergency_introductions = array(
			'WARNING!! ',
			'READ THIS NOW!! ',
			'HOLY CRAP!! ',
			'RED ALERT !! ',
			'EMERGENCY!! ',
		);
		
		public static $good_morning_messages = array(
			"Good Morning! I'm here and ready for work!",
			"No need to fear, Adam is here!",
			"I hope you slept well, I did! Now I'm back at work, managing the dialler again!",
			"Another day arrives! Work, work, work!",
			"Good morning friend - wait - what the hell am I doing up this early?",
		);
		
		public static $good_evening_messages = array(
			"I hope you enjoy your evening. This is Adam, signing off!",
			"Great day, even greater evening, good night!",
			"The end of another working day! I wonder what the next will hold in store for me! See you soon!",
			"What shoud I do this evening? Suggestions in an e-mail please! Good night!",
		);
		
		
		
		public function checkLeads()
		{
    		\Controller_Survey_Lead::checkLeads();
		}
		
		
		public function testMail()
		{
    		$email = \Email::forge();
			
			$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
			
			$email->to(array(
			    's.skinner@expertmoneysolutions.co.uk' => 'Simon Skinner',
			));
			
	
			$email->priority(\Email::P_HIGH);
			
			$email->subject('Recent No Contacts');
			
			$email->html_body("Testing, Oh Yeah");
									
			$email->send();


			Adam::submit_ticket("Incorrect DI Value", "I have found a client in Debtsolv with a DI value of £0. The Client ID is ");

		}
		
		public function run()
		{
		
		    for ($i = 100; $i <= 299; $i++) {
    		    $todayPayments = \DB::query("INSERT INTO `asterisk`.`vicidial_conferences` (`conf_exten`, `server_ip`, `extension`, `leave_3way`, `leave_3way_datetime`) VALUES ('8600".$i."', '10.1.0.101', NULL, '0', NULL)")->execute('gabdialler');
			}
		
		    for ($i = 300; $i <= 499; $i++) {
    		    $todayPayments = \DB::query("INSERT INTO `asterisk`.`vicidial_conferences` (`conf_exten`, `server_ip`, `extension`, `leave_3way`, `leave_3way_datetime`) VALUES ('8600".$i."', '192.168.5.2', NULL, '0', NULL)")->execute('gabdialler');
			}
		
		
		    for ($i = 500; $i <= 699; $i++) {
    		    $todayPayments = \DB::query("INSERT INTO `asterisk`.`vicidial_conferences` (`conf_exten`, `server_ip`, `extension`, `leave_3way`, `leave_3way_datetime`) VALUES ('8600".$i."', '10.1.0.131', NULL, '0', NULL)")->execute('gabdialler');
			}
			
			
		    for ($i = 700; $i <= 899; $i++) {
    		    $todayPayments = \DB::query("INSERT INTO `asterisk`.`vicidial_conferences` (`conf_exten`, `server_ip`, `extension`, `leave_3way`, `leave_3way_datetime`) VALUES ('8600".$i."', '10.1.0.132', NULL, '0', NULL)")->execute('gabdialler');
			}
			
			
		}
		
		
		
		public function submit_ticket($subject=null, $message=null, $department=1, $priority=3)
		{
    		date_default_timezone_set('Europe/London');
    		
    		
    		$submitUrl = "http://support.expertmoneysolutions.co.uk/open.php";
    		
    		$openTicket = array(
    		  'name'      => 'A.D.A.M.',
    		  'email'     => 'a.d.a.m@expertmoneysolutions.co.uk',
    		  'phone'     => '01204860900',
    		  'phone_ext' => '4000',
    		  'topicId'   => $department,
    		  'subject'   => $subject,
    		  'message'   => $message,
    		  'priorityId'       => $priority,
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
		
		
		public function daily_stats()
		{
		
			$gab_day_stats = @\Controller_Reports::generate_disposition_report('GAB',TRUE,TRUE,null,null, TRUE);
			$pcc_day_stats = @\Controller_Reports::generate_disposition_report('GBS',TRUE,TRUE,null,null, TRUE);
			$burton_day_stats = @\Controller_Reports::generate_disposition_report('RESOLVE',TRUE,TRUE,null,null, TRUE);
			
			
			$all_day_stats = @\Controller_Reports::generate_disposition_report(null,TRUE,TRUE,null,null, TRUE);
			
			
			
			
			$day_stats = array(
				'referrals' => array(
					'total' => ($all_day_stats['totals']['referrals']['count']),
				),
				'pack_out' => array(
					'total' => ($all_day_stats['totals']['pack_outs']['count']),
					'value' => number_format((float)str_replace(",","",$all_day_stats['totals']['pack_outs']['value']),2),
				),
				'pack_in' => array(
					'total' => ($all_day_stats['totals']['pack_ins']['count']),
					'value' => number_format((float)str_replace(",","",$all_day_stats['totals']['pack_ins']['value']),2),
				),
				'paid' => array(
					'total' => ($all_day_stats['totals']['paid']['count']),
					'value' => number_format((float)str_replace(",","",$all_day_stats['totals']['paid']['value']),2),
				),
			);

						
			/*
			
			
			$day_stats = array(
				'referrals' => array(
					'total' => ($gab_day_stats['totals']['referrals']['count']+$pcc_day_stats['totals']['referrals']['count']+$burton_day_stats['totals']['referrals']['count']),
				),
				'pack_out' => array(
					'total' => ($gab_day_stats['totals']['pack_outs']['count']+$pcc_day_stats['totals']['pack_outs']['count']+$burton_day_stats['totals']['pack_outs']['count']),
					'value' => number_format(((float)str_replace(",","",$gab_day_stats['totals']['pack_outs']['value'])+(float)str_replace(",","",$pcc_day_stats['totals']['pack_outs']['value'])+(float)str_replace(",","",$burton_day_stats['totals']['pack_outs']['value'])),2),
				),
				'pack_in' => array(
					'total' => ($gab_day_stats['totals']['pack_ins']['count']+$pcc_day_stats['totals']['pack_ins']['count']+$burton_day_stats['totals']['pack_ins']['count']),
					'value' => number_format(((float)str_replace(",","",$gab_day_stats['totals']['pack_ins']['value'])+(float)str_replace(",","",$pcc_day_stats['totals']['pack_ins']['value'])+(float)str_replace(",","",$burton_day_stats['totals']['pack_ins']['value'])),2),
				),
				'paid' => array(
					'total' => "?",
					'value' => "?",
				),
			);
			
			*/
			
			
			if ($day_stats['referrals']['total'] > 0)
			{
				
				
				$send_string1  = "Stats for ".date("d/m/Y")."\n";
				$send_string1 .= ($gab_day_stats['totals']['referrals']['count'] + $pcc_day_stats['totals']['referrals']['count'] > 0) ? ($gab_day_stats['totals']['referrals']['count']+$pcc_day_stats['totals']['referrals']['count'])." Internal, ".($gab_day_stats['totals']['pack_outs']['count']+$pcc_day_stats['totals']['pack_outs']['count'])." pack out.\n" : "";
				//$send_string1 .= ($pcc_day_stats['totals']['referrals']['count'] > 0) ? $pcc_day_stats['totals']['referrals']['count']." PCC, ".$pcc_day_stats['totals']['pack_outs']['count']." pack out.\n" : "";
				$send_string1 .= ($burton_day_stats['totals']['referrals']['count'] > 0) ? $burton_day_stats['totals']['referrals']['count']." Burton, ".$burton_day_stats['totals']['pack_outs']['count']." pack out.\n" : "";
				
				$send_string1 .= ($all_day_stats['totals']['referrals']['count'] > 0) ? ($all_day_stats['totals']['referrals']['count'] - ($burton_day_stats['totals']['referrals']['count']+$gab_day_stats['totals']['referrals']['count']+$pcc_day_stats['totals']['referrals']['count']))." External, ".($all_day_stats['totals']['pack_outs']['count'] - ($burton_day_stats['totals']['pack_outs']['count']+$gab_day_stats['totals']['pack_outs']['count']+$pcc_day_stats['totals']['pack_outs']['count']))." pack out." : "";
				
				
				$send_string2 = $day_stats['pack_out']['total']." pack out £".$day_stats['pack_out']['value']."\n".$day_stats['pack_in']['total']." pack in £".$day_stats['pack_in']['value']."\n".$day_stats['paid']['total']." paid £".$day_stats['paid']['value']."\nEnjoy your evening! :)";
				
				Adam::send_push_message($send_string1);
				Adam::send_push_message($send_string2);
				
				print $send_string1."\n";
				print $send_string2;
			
			}
		}
		
		
		public function sorry_message()
		{
    		Adam::send_push_message("This is just a test message for adam!");
		}
		
		
		public function get_tomorrow_list_stats($campaign=null, $dialler=null)
		{
			date_default_timezone_set('Europe/London');
			
			$tomorrow = (((int)date("N", strtotime("today"))));
			
			$two_weeks_ago = ((date("Y-m-d", strtotime("-4 weeks -1 day"))));

			
			if (!is_null($campaign))
			{
				$makeQuery = "SELECT
					VDLO.list_id
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 9 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 9 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 9 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_9
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 10 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 10 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 10 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_10
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 11 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 11 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 11 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_11
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 12 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 12 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 12 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_12
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 13 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 13 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 13 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_13
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 14 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 14 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 14 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_14
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 15 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 15 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 15 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_15
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 16 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 16 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 16 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_16
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 17 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 17 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 17 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_17
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 18 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 18 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 18 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_18
					, CASE WHEN COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 19 THEN lead_id END ) >= 25 THEN IFNULL(( ( IFNULL(COUNT( CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 19 AND VDLO.status = 'SALE' THEN VDLO.lead_id END),0) / IFNULL( COUNT(CASE WHEN WEEKDAY(VDLO.call_date) = ".$tomorrow." AND HOUR(VDLO.call_date) = 19 AND VDLO.status IN ('3RDPAR', 'BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') THEN VDLO.lead_id END) ,0) ) * 100 ) ,0) ELSE 1 END AS sales_19
					FROM
						vicidial_lists AS VDL
					LEFT JOIN
						vicidial_log AS VDLO ON VDL.list_id=VDLO.list_id
					WHERE
						VDL.campaign_id = '".$campaign."'
						AND VDL.list_id NOT IN (998,990)
						AND DATE(VDLO.call_date) >= '".$two_weeks_ago."'
					GROUP BY
						list_id
					;";

								
				
				$daily_stats = \DB::query($makeQuery)->cached(120)->execute($dialler);
				
				// Delete previous stats from the database
				$delete_stats = \Model_Tomorrow_List_Stat::query()->where('dialler', $dialler)->where('campaign',$campaign)->get_one();
				
				if ($delete_stats)
				{
					$delete_stats->delete();
				}
				
				
				// Store details in the database for quick checking
				$store_stats = new \Model_Tomorrow_List_Stat();
				$store_stats->day_check = $tomorrow;
				$store_stats->dialler = $dialler;
				$store_stats->campaign = $campaign;
				$store_stats->content = serialize($daily_stats->as_array());
				$store_stats->save();
				

			}
			
			
		}
		
		
		
		
		
		public function test($total=1)
		{
			ob_end_flush();
			
			$mtime = microtime(); 
			$mtime = explode(" ",$mtime); 
			$mtime = $mtime[1] + $mtime[0]; 
			$starttime = $mtime; 
   
			$duplicate_details = array();
			$count = 0;
			
			$details = \Model_Data_Supplier_Campaign_Lists_Duplicate::query()->where('dialler',0)->limit($total)->get();
			
			$leads = array();
			$id_reference = array();
			foreach ($details AS $lead)
			{
				$leads[] = $lead->duplicate_number;
				$id_reference[$lead->duplicate_number] = $lead->id;
			}
			
			
			print_r($id_reference);
			
			$duplicate_details = \Goautodial\Insert::duplicate_check($leads);
			
			foreach ($duplicate_details AS $number => $dupe)
			{
				$lead = \Model_Data_Supplier_Campaign_Lists_Duplicate::find($id_reference[$number]);
				$lead->dialler = $dupe['dialler'];
				$lead->lead_id = $dupe['data']['lead_id'];
				$lead->save();
				$count++;
			}			
			
			print $count . " duplicates found.\n";
			@ob_flush();
			
			
			
			$mtime = microtime(); 
			$mtime = explode(" ",$mtime); 
			$mtime = $mtime[1] + $mtime[0]; 
			$endtime = $mtime; 
			$totaltime = ($endtime - $starttime); 
			echo "It took ".$totaltime." seconds to track ".$count." duplicates.\n\n"; 
			
		}
		
		
		public function send_push_message($message)
		{
			$payload = array(
				'aps' => array(
					'alert' => $message,
					'sound' => 'default',
				),
				'android' => array(
                    'alert' => $message,
                ),
			);
			
			$session = curl_init('https://go.urbanairship.com/api/push/broadcast/'); 
			curl_setopt($session, CURLOPT_USERPWD, 'GpZjIhawQzKqPls_0tkVWg:NjFiOL2sR56rZNYPTVPrKg'); 
			curl_setopt($session, CURLOPT_POST, True); 
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($payload)); 
			curl_setopt($session, CURLOPT_HEADER, False); 
			curl_setopt($session, CURLOPT_RETURNTRANSFER, True); 
			curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); 
			$content = curl_exec($session); 
			
		}
		
		
		public function check_campaign_rate($campaign_id)
		{
			$campaign = \Goautodial\Model_Vicidial_Campaigns::find($campaign_id);
			
			print($campaign->auto_dial_level);
		}
		
		
		public function lol()
		{
			
			$get_paid_details = \GAB\Debtsolv::change_center('1170344','GAB');
			
			print_r($get_paid_details);
			
		}
		
		public function monday_morning_tasks()
		{
			Adam::move_telesales_staff();
		}

        // These are tasks to be run at 8am every morning.
        public function daily_morning_tasks()
        {
            // -- Run staff late report
            // ------------------------
            @Adam::staff_late_report();
        }
		
		public function daily_tasks()
		{
			date_default_timezone_set('Europe/London');
			
			// No longer daily
			//@Adam::move_telesales_staff();
      
      @Adam::daily_dialler_report();

      // -- Terminated and Suspended Clients
      // -----------------------------------
      @Adam::terminated_suspended_clients_report();
      
      // -- Spark E Report for Sahil to Accounts
      // ---------------------------------------
      @Adam::sahilPaymentReport();
      
			@Adam::daily_stats();
			
			// Run List stat checker
			#@Adam::get_tomorrow_list_stats("GAB-1", "gabdialler");
			#@Adam::get_tomorrow_list_stats("GBS-1", "gabdialler");
			#@Adam::get_tomorrow_list_stats("OPT-IN", "gabdialler");
			#@Adam::get_tomorrow_list_stats("BURTON1", "resolvedialler");
			#@Adam::get_tomorrow_list_stats("SMS-1", "resolvedialler");
		}
		
		/**
		 * Tasks for the dialler to be ran every minute.
		 * 
		 * @access public
		 * @return void
		 */
		public function one_minute_tasks()
		{
			date_default_timezone_set('Europe/London');
			ob_end_flush();
			
			
			Adam::remove_announcements();
			
			
			$get_work_hours = Adam::in_work_hours();
			if ( is_null($get_work_hours) )
			{
				
				
				/*
				$current_date_time = strtotime("NOW");
				if ( $current_date_time >= ((int)$get_work_hours['start']) && $current_date_time <= ((int)$get_work_hours['start']+90) )
				{
					$previous_alerts = \Model_Adam_Announcement::query()->where('campaign', 'NULL')->where('alert_type', 'GOOD-MORNING');
					
					if ($previous_alerts->count() == 0)
					{
						Adam::send_push_message(static::$good_morning_messages[rand(0,count(static::$good_morning_messages)-1)]);
						
						$adam_announcement = \Model_Adam_Announcement::forge(array(
							'campaign' => "NULL",
							'alert_type' => "GOOD-MORNING",
							'remove_date' => date("Y-m-d H:i:s",strtotime("+5 minutes")),
						));
						$adam_announcement->save();
					}
				} 
				else if ( $current_date_time >= ((int)$get_work_hours['end']-90) && $current_date_time <= ((int)$get_work_hours['end']) )
				{
					$previous_alerts = \Model_Adam_Announcement::query()->where('campaign', 'NULL')->where('alert_type', 'GOOD-EVENING');
					
					if ($previous_alerts->count() == 0)
					{
						Adam::send_push_message(static::$good_evening_messages[rand(0,count(static::$good_evening_messages)-1)]);
						
						$adam_announcement = \Model_Adam_Announcement::forge(array(
							'campaign' => "NULL",
							'alert_type' => "GOOD-EVENING",
							'remove_date' => date("Y-m-d H:i:s",strtotime("+5 minutes")),
						));
						$adam_announcement->save();
					}
				}
				*/
				
				
				$minute_message = "";
				
				
				//$minute_message .= @Adam::guess_dial_rate('PREMIER', TRUE)."\n";
				//$minute_message .= @Adam::guess_dial_rate('STANDARD', TRUE)."\n";
				
				//$minute_message .= @Adam::guess_dial_rate('GBS-1', TRUE)."\n";
				//$minute_message .= @Adam::guess_dial_rate('GAB-3', TRUE)."\n";
				
				//$minute_message .= @Adam::guess_dial_rate('GAB-1', TRUE)."\n";
				//$minute_message .= @Adam::guess_dial_rate('GAB2013', TRUE)."\n";
				//$minute_message .= @Adam::guess_dial_rate('OPT-IN', TRUE)."\n";
				//$minute_message .= @Adam::guess_dial_rate('INTERNAL', TRUE)."\n";
				
				
				
				//@Adam::check_dialable_leads('PREMIER');
				//@Adam::check_dialable_leads('STANDARD');
				
				//@Adam::check_dialable_leads('GBS-1');
				//@Adam::check_dialable_leads('GAB-3');
				
				//@Adam::check_dialable_leads('GAB-1');
				//@Adam::check_dialable_leads('OPT-IN');
				//@Adam::check_dialable_leads('GBS2013');
				//@Adam::check_dialable_leads('INTERNAL');
				
				
				/*
				
				//$minute_message .= @Adam::guess_dial_rate('BURTON1', TRUE, "resolvedialler")."\n";
				//@Adam::check_dialable_leads('BURTON1', "resolvedialler");
				
				//$minute_message .= @Adam::guess_dial_rate('SMS-1', TRUE, "resolvedialler")."\n";
				//@Adam::check_dialable_leads('SMS-1', "resolvedialler");
				*/
				
				
				
				/* gipltd
				
				$minute_message .= @Adam::gipltd_guess_dial_rate('UKCam', TRUE, "gipltd")."\n";
				$minute_message .= @Adam::gipltd_guess_dial_rate('Training', TRUE, "gipltd")."\n";
				$minute_message .= @Adam::gipltd_guess_dial_rate('INSURANC', TRUE, "gipltd")."\n";
				$minute_message .= @Adam::gipltd_guess_dial_rate('Inbound', TRUE, "gipltd")."\n";
				$minute_message .= @Adam::gipltd_guess_dial_rate('clixtest', TRUE, "gipltd")."\n";
				
				
				*/
				
				
				// Monitor the External diallers
				//$minute_message .= @Adam::guess_dial_rate('UK', TRUE, "rj5")."\n";
				//@Adam::check_dialable_leads('UK', "rj5");
				
				// Monitor the PCC dialler
				//$minute_message .= @Adam::guess_dial_rate('DIGOS-1', TRUE, "pccdialler")."\n";
				//@Adam::check_dialable_leads('DIGOS-1', "pccdialler");
				//
				
				$adam_message = \Model_Adam_Message::forge(array(
						'message' => $minute_message,
					));
				$adam_message->save();
			
				
			
			}
			else
			{
				print "\nWe don't appear to be at work right now!\n\n";
			}
			
			
			//@Adam::log_minute_stats('INTERNAL');
			//@Adam::log_minute_stats('GAB-1');
			@Adam::log_minute_stats('GBS-1');
			//@Adam::log_minute_stats('OPT-IN');
			@Adam::log_minute_stats('GAB-3');
			//@Adam::log_minute_stats('GAB-LIVE');
			//@Adam::log_minute_stats('BURTON1', TRUE, "resolvedialler");
			//@Adam::log_minute_stats('SMS-1', TRUE, "resolvedialler");
			//@Adam::log_minute_stats('UK', TRUE, "rj5");
				
			
			/* gipltd
			@Adam::gipltd_log_minute_stats('UKCam');
			@Adam::gipltd_log_minute_stats('Training');
			@Adam::gipltd_log_minute_stats('INSURANC');
			@Adam::gipltd_log_minute_stats('Inbound');
			@Adam::gipltd_log_minute_stats('clixtest');
			*/
			
		}
		
		
		
		
		public function quickUpdate()
{
    for ($i = 1; $i <= 28; $i++) {
        \Cli::write('Checking 2014-01-'.$i);
        Adam::get_first_payment_date('2014-01-'.$i);
    }
}
		
		public function five_minute_tasks()
		{
		
		
		    \Controller_Survey_Lead::checkLeads();
			
			Adam::check_no_contacts();
			
			Adam::get_first_payment_date();
			
			// Adam::get_first_payment_date(null, 'RESOLVE');
			
			
		}
		
		
		public function hourly_tasks()
		{
			date_default_timezone_set('Europe/London');
			
			$message = "";
			
			//$message .= @Adam::pick_best_lists("GAB-1", "gabdialler");
			
			//$message .= @Adam::pick_best_lists("GBS-1", "gabdialler");
			
			//$message .= @Adam::pick_best_lists("BURTON1", "resolvedialler");
			
			if ($message <> "")
			{
				// Everything looks ok now so we will stop sending the message
				Adam::send_push_message($message);
			}
			
			
			print $message;
      
      // -- Senior Transfer Log
      // ----------------------
      @Adam::senior_transfer_log_report();			
		}
		
		
		public function pick_best_lists($campaign=null, $dialler=null)
		{
			// Make sure we are using the correct time zone
			date_default_timezone_set('Europe/London');
			
			// Check we are actually in work hours
			$get_work_hours = Adam::in_work_hours();
			if ( !is_null($get_work_hours) )
			{

				// Get the current hour so we can find the correct conversion ratio
				$hour_column = "sales_".(int)date('H');
				//$hour_column = "sales_9";
				
				// Pull in the stats for the day from the database and loop through them to find all the details for this hour
				$today_stats = \Model_Tomorrow_List_Stat::query()->where('dialler', $dialler)->where('campaign',$campaign)->get_one();
				$list_data = unserialize($today_stats->content);
				$list_ids = array();
				$create_lists = array();
				
				foreach ($list_data AS $list)
				{
					if ($list['list_id']<>"")
					{
						$create_lists[$list['list_id']] = $list[$hour_column];
						$list_ids[] = $list['list_id'];
					}
				}
				
				// Sort the array by conversion ratio
				arsort($create_lists);
				
				
				$campaign_details = \Goautodial\Model_Vicidial_Campaigns::find(null,array(),$dialler)->where('campaign_id', $campaign)->get_one();
				
				$status_array_first = explode(" ",str_replace("-","",$campaign_details->dial_statuses));
				
				foreach($status_array_first AS $status_one)
				{
					if ($status_one <> '')
					{
						$status_array[] = $status_one;
					}
				}
				
				
				// Find out how many dialable leads are left in each campaign
				$get_diallable_leads = \DB::query("SELECT 
	list_id,
	count(*) AS dialable
FROM 
	vicidial_list 
WHERE 
	called_since_last_reset='N' 
	AND status IN('".implode("', '", $status_array)."') 
	AND list_id IN('".implode("', '", $list_ids)."') 
	AND ( (status IN ('3RDPAR','CHDB','DIEXCO','HUNGUP','IVA','NODEBT','NOTAFF','SECDBT','WRNAME','NI','NOINDM')) AND ( ((status IN ('3RDPAR')) and (DATEDIFF(NOW(),last_local_call_time) >= 1)) OR ((status IN ('CHDB','HANGUP')) and (DATEDIFF(NOW(),last_local_call_time) >= 14)) OR ((status IN ('DIEXCO','NOTAFF','WRNAME','NOINDM')) and (DATEDIFF(NOW(),last_local_call_time) >= 28)) OR ((status IN ('IVA','SECDBT','NI')) and (DATEDIFF(NOW(),last_local_call_time) >= 100)) ) OR (status NOT IN ('3RDPAR','CHDB','DIEXCO','HUNGUP','IVA','NODEBT','NOTAFF','SECDBT','WRNAME','NI','BNKRPT','DECEAS','EXISCL','NOINDM','PPI','PSSDDR','DNC','DNCL','ALLRDY','SALE','PPIREF','PPI','POSSDC')) ) AND called_count < 11 
 	AND ( ( (status IN('DROP','XDROP')) and (last_local_call_time < CONCAT(DATE_ADD(NOW(), INTERVAL -259200 SECOND),' ',CURTIME()) ) ) or (status NOT IN('DROP','XDROP')) ) GROUP BY list_id;")->execute($dialler);
				
				
				// Create and populate an array showing all dialable leads for reference later
				$dialable_leads = array();
				foreach ($get_diallable_leads AS $dialable)
				{
					$dialable_leads[$dialable['list_id']] = $dialable['dialable'];
				}
								
				//print_r($dialable_leads);
								
				// Create a temporary array showing with all the lists in order
				$new_lists = array();
				foreach ($create_lists AS $id=>$val)
				{
					$new_lists[] = $id;
				}
				
				$campaign_stats = \Goautodial\Model_Vicidial_Campaign_Stats::find(null,array(),$dialler)->where('campaign_id', $campaign)->get_one();
				$calls = ((int)$campaign_stats->calls_halfhour*1.3)*2;
				
				if ($calls < 8000)
				{
					$calls = 8000;
				}
				
				// Count how many leads are available and make sure there are over a default amount
				$current_leads = 0;
				$required_leads = ((int)date('H') > 9) ? $calls : 10000;
				$turn_on_lists = array();
				while ($current_leads < $required_leads)
				{
					$list_id = array_shift($new_lists);
					$turn_on_lists[] = $list_id;
					$current_leads = (!isset($dialable_leads[$list_id])) ? $current_leads+0 : $current_leads + $dialable_leads[$list_id];
				}
				
				// Deactivate old lists and activate the new lists
				$remove_all_lists = \DB::query("UPDATE vicidial_lists SET active='N' WHERE campaign_id='".$campaign."';")->execute($dialler);
				$add_new_lists = \DB::query("UPDATE vicidial_lists SET active='Y' WHERE list_id IN ('".implode("', '", $turn_on_lists)."');")->execute($dialler);
				
				// Send a message via A.D.A.M - This should be a temporary measure
				$alert_message = count($turn_on_lists) . " lists turned on in " . $campaign . ". ";
				
				//print_r($turn_on_lists);
				
				//Adam::send_push_message($alert_message);
			
				return $alert_message;
			
			}
			else
			{
				print "not at work!";
			}
						
		}
		
		
		public function check_no_contacts($center=null)
		{
		
			date_default_timezone_set('Europe/London');
		
			$start_date = date("m/d/Y H:i:s", strtotime("5 minutes ago"));
			$end_date = date("m/d/Y H:i:s");
		
			$disposition_duration = "(
			(CLD.DateCreated >= CONVERT(datetime, '". $start_date ."', 120) AND CLD.DateCreated <= CONVERT(datetime, '". $end_date ."', 120)+1)) ";
			
			$pack_in_duration = "(D_CLD.DatePackReceived >= CONVERT(datetime, '". $start_date ."', 120) AND D_CLD.DatePackReceived <= CONVERT(datetime, '". $end_date ."', 120)) ";
			
			$call_center_choice = (!is_null($center)) ? "AND CLD.LeadRef2 = '".$center."'" : "";
			
			$results = \DB::query("SELECT CLD.ClientID
				  ,CLD.LeadRef AS 'Dialler Lead ID'
			      ,(CD.Forename + ' ' + CD.Surname) AS Name
			      ,ISNULL(NULLIF(LSO.[Description],'<None>'), DSLSO.[Description]) AS 'Lead Source'
			      ,CLD.LeadRef2 AS Office
			      ,ISNULL(DI_REF.full_name,D_U.Undersigned) AS 'Telesales Agent',
			      
			      ISNULL((
			        SELECT Top (1)
			          Undersigned
			        FROM
			          Debtsolv_MMS.dbo.Users AS D_URS
			        LEFT JOIN
			          Debtsolv_MMS.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
			        WHERE
			          D_CLD.LeadPoolReference = CLD.ClientID
			      ),(SELECT Top (1)
			      	  Undersigned
			      	FROM
			      	  Debtsolv_MMS.dbo.Users AS DURS
			      	LEFT JOIN
			      	  Leadpool_MMS.dbo.CampaignContactAccess AS CCA ON DURS.ID = CCA.UserID
			      	WHERE
			      	  CCA.CampaignContactID = CC.ID
			      	ORDER BY
			      	CCA.AccessDate DESC)) AS 'Consolidator'
			      
			      ,TCR.[Description]
			      ,CASE
			         WHEN D_CPD.InitialAgreedAmount > 0 AND CC.ContactResult = 1500
			            THEN 'DR'
			         WHEN (D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500
			            THEN 'PPI'
			         ELSE
			           ''
			         END AS Product
			      ,D_CPD.InitialAgreedAmount / 100 AS DI,
			      (
			      	SELECT Top (1)
			      		ResponseText
			      	FROM
			      		Debtsolv_MMS.dbo.Client_CustomQuestionResponses
			      	WHERE
			      		QuestionID = 1
			      		AND ClientID = D_CLD.Client_ID
			      ) AS 'Delivery'
			      ,CONVERT(varchar, CLD.DateCreated, 120) AS 'Referred Date'
			      ,CONVERT(varchar, CC.LastContactAttempt, 120) AS 'Last Contact Date'
			      ,CASE
			         WHEN CC.ContactResult = 700
			           THEN CONVERT(varchar, CC.Appointment, 120)
			         ELSE
			           ''
			       END AS 'Call Back Date'
			       , CC.ContactResult AS ContactResult
			  FROM
			    Leadpool_MMS.dbo.Client_LeadDetails AS CLD
			  LEFT JOIN
			    Leadpool_MMS.dbo.Client_Details AS CD ON CLD.ClientID = CD.ClientID
			  LEFT JOIN
			    Leadpool_MMS.dbo.Campaign_Contacts AS CC ON CLD.ClientID = CC.ClientID
			  LEFT JOIN
			    Leadpool_MMS.dbo.Type_ContactResult AS TCR ON CC.ContactResult = TCR.ID
			  LEFT JOIN
				Leadpool_MMS.dbo.LeadBatch AS LBA ON CLD.LeadBatchID = LBA.ID
			  LEFT JOIN
				Leadpool_MMS.dbo.Type_Lead_Source AS LSO ON LBA.LeadSourceID = LSO.ID
			  
			  LEFT JOIN
				Debtsolv_MMS.dbo.Type_Lead_Source AS DSLSO ON LBA.LeadSourceID = DSLSO.ID
				
			  LEFT JOIN
			    Debtsolv_MMS.dbo.Client_LeadData AS D_CLD ON CLD.ClientID = D_CLD.LeadPoolReference
			  LEFT JOIN
			    Debtsolv_MMS.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
			  LEFT JOIN
			    Debtsolv_MMS.dbo.Client_PaymentData AS D_CPD ON D_CLD.Client_ID = D_CPD.ClientID
			  LEFT JOIN
			  	Dialler.dbo.referrals AS DI_REF ON CLD.ClientID = DI_REF.leadpool_id
			  WHERE
			    ". $disposition_duration ."
				AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500)
				AND ( CC.ContactResult = 0 OR CC.ContactResult = 721 OR CC.ContactResult = 900)
			    ". $call_center_choice ."
			  ORDER BY
				CLD.LeadRef2
			    ,TCR.[Description]
			    ,Product
			    ,CLD.DateCreated DESC")->cached(30)->execute('debtsolv');
			
			
			$alerts             = array(
				'referred'        => 0,
				'no-contact'      => 0,
				'failed-transfer' => 0,
			);
			foreach ($results AS $result)
			{
				if ($result['ContactResult'] == 0)
				{
					$alerts['no-contact']++;
				} 
				else if ($result['ContactResult'] == 721)
				{
					$alerts['failed-transfer']++;
				}
				else if ($result['ContactResult'] == 900)
				{
					$alerts['referred']++;
				}
			}
			
			if ( ($alerts['no-contact']+$alerts['failed-transfer']+$alerts['referred']) > 0 )
			{
			
				$write_text = "In 5 minutes there have been...\n";
				
				if ($alerts['no-contact'] > 0)
				{
					$write_text .= "No Contacts: " . $alerts['no-contact'] . "\n";
				}
				if ($alerts['failed-transfer'] > 0)
				{
					$write_text .= "Failed Transfers: " . $alerts['failed-transfer'] . "\n";
				}
				if ($alerts['referred'] > 0)
				{
					$write_text .= "Referred Status: " . $alerts['referred'] . "\n";
				}
				
				
				Adam::send_push_message($write_text);
				
				
				// E-Mail Out these details...
				
				$email = \Email::forge();
			
				$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
				
				$email->to(array(
					'l.davenport@expertmoneysolutions.co.uk'  => 'Laura Davenport',				));
				
				$email->bcc(array(
					'support@expertmoneysolutions.co.uk'      => 'EMS Support',
				));
				
				$email->priority(\Email::P_HIGH);
				
				$email->subject('Recent No Contacts');
				
				$email->html_body(\View::forge('emails/nocontacts/no-contact', array(
					'email_data' => $results->as_array(),
				)));

				
				$email->alt_body('Hi.
	
'.$write_text.'
For full details please see the Disposition Report.

Regards
Gregson and Brooke.');
				
				$email->send();
				
				
				
				
				
				// Now do the same for individial centers
				
				$all_centers  = array(
					'RJ5'       => array(
						'rjhigh5mylene@gmail.com' => 'Mylene',
						'rjhighfive.coo@gmail.com',
					),
					'SixEleven' => array(
						'cheryb@sixelevencenter.com' => 'Cherry',
						'allenm@sixelevencenter.com',
						
					),
					'SO'        => array(
						'vineet.verma@simplyoutbound.com',
						'grace.caalim@simplyoutbound.com',
						'hannah.tondo@fusionbposervices.com',
					),
					'GBS'        => array(
						'reports@gbs.com.ph',
					),
				);
				
				foreach ($all_centers AS $short_code => $emails)
				{
					$all_center_results = array();
					foreach ($results AS $result)
					{
						if ($result['Office'] == $short_code)
						{
							$all_center_results[] = $result;
						}
												
					}
					
					if (count($all_center_results) > 0)
					{
					
						$email = \Email::forge();
			
						$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
						
						$email->to($emails);
						
						$email->bcc(array(
							'support@expertmoneysolutions.co.uk'      => 'EMS Support',
						));
				
						$email->priority(\Email::P_HIGH);
						
						$email->subject('Recent No Contacts');
						
						$email->html_body(\View::forge('emails/nocontacts/no-contact', array(
							'email_data' => $all_center_results,
						)));
												
						$email->send();
					
					}					


				}
				
				
			}
			
			
		}
		
		
		
		public function check_dialable_leads($campaign_id, $dialler=null)
		{
			date_default_timezone_set('Europe/London');
			
			$dialler = (is_null($dialler)) ? "gabdialler" : $dialler;
			
			$campaign_stats = \Goautodial\Model_Vicidial_Campaign_Stats::find($campaign_id, array(), $dialler);
			
			if ($campaign_stats->dialable_leads < $campaign_stats->calls_fivemin)
			{
			
				$previous_alerts = \Model_Adam_Announcement::query()->where('campaign', $campaign_id)->where('alert_type', 'LEADS5');
				
				if ($previous_alerts->count() == 0)
				{
				    $sendMessage = static::$emergency_introductions[rand(0,count(static::$emergency_introductions)-1)]."There are less than 5 minutes worth of leads left in the ".$campaign_id." campaign on ".$dialler.". ".$message;
					//$message = @Adam::pick_best_lists($campaign_id, $dialler);
					Adam::send_push_message($sendMessage);
					Adam::submit_ticket("LEADS ALERT - ".$dialler, $sendMessage, 10, 5);
					
					
					$adam_announcement = \Model_Adam_Announcement::forge(array(
						'campaign' => $campaign_id,
						'alert_type' => "LEADS5",
						'remove_date' => date("Y-m-d H:i:s",strtotime("+5 minutes")),
					));
					$adam_announcement->save();
				}
				
				
			} 
			else if ($campaign_stats->dialable_leads < ($campaign_stats->calls_fivemin*3))
			{
			
				$previous_alerts = \Model_Adam_Announcement::query()->where('campaign', $campaign_id)->where('alert_type', 'LEADS15');
				
				if ($previous_alerts->count() == 0)
				{
				    $sendMessage = static::$moderate_introductions[rand(0,count(static::$moderate_introductions)-1)]."There are less than 15 minutes worth of leads left in the ".$campaign_id." campaign on ".$dialler.". ".$message;
					//$message = @Adam::pick_best_lists($campaign_id, $dialler);
					Adam::send_push_message($sendMessage);
					Adam::submit_ticket("LEADS WARNING - ".$dialler, $sendMessage, 10, 4);
					
					$adam_announcement = \Model_Adam_Announcement::forge(array(
						'campaign' => $campaign_id,
						'alert_type' => "LEADS15",
						'remove_date' => date("Y-m-d H:i:s",strtotime("+15 minutes")),
					));
					$adam_announcement->save();
				}
				
				
			} 
			else if ($campaign_stats->dialable_leads < $campaign_stats->calls_halfhour)
			{
			
				$previous_alerts = \Model_Adam_Announcement::query()->where('campaign', $campaign_id)->where('alert_type', 'LEADS30');
				
				if ($previous_alerts->count() == 0)
				{
				    $sendMessage = static::$casual_introductions[rand(0,count(static::$casual_introductions)-1)]."There are less than 30 minutes worth of leads left in the ".$campaign_id." campaign on ".$dialler.". ".$message;
					//$message = @Adam::pick_best_lists($campaign_id, $dialler);
					Adam::send_push_message($sendMessage);
					Adam::submit_ticket("LEADS ALERT - ".$dialler, $sendMessage, 10, 3);
					
					$adam_announcement = \Model_Adam_Announcement::forge(array(
						'campaign' => $campaign_id,
						'alert_type' => "LEADS30",
						'remove_date' => date("Y-m-d H:i:s",strtotime("+30 minutes")),
					));
					$adam_announcement->save();
				}
				
				
			}
		
		
			
		
			
		}
		
		public function remove_announcements()
		{
			date_default_timezone_set('Europe/London');
			
			$removable = \Model_Adam_Announcement::query()->where('remove_date', '<', date('Y-m-d H:i:s'))->get();
			
			foreach ($removable AS $remove)
			{
				$remove->delete();
			}
			
			
		}
		
		
		
		/**
		 * Check if the offices are currently open or not.
		 * 
		 * @access public
		 * @return void
		 */
		public function in_work_hours()
		{
			date_default_timezone_set('Europe/London');
			
			$open = FALSE;
			$current_date_time = strtotime("NOW");
			
			// Check for specific day events from the database
			
			
			
			// If there is nothing specific in the database then we default to standard working hours
			$time_checks = array(
				1 => array(
					'start' => mktime(9,30,0),
					'end' => mktime(20,0,0),
				),
				2 => array(
					'start' => mktime(9,30,0),
					'end' => mktime(20,0,0),
				),
				3 => array(
					'start' => mktime(9,30,0),
					'end' => mktime(20,0,0),
				),
				4 => array(
					'start' => mktime(9,30,0),
					'end' => mktime(20,0,0),
				),
				5 => array(
					'start' => mktime(9,30,0),
					'end' => mktime(18,0,0),
				),
				6 => array(
					'start' => mktime(10,00,0),
					'end' => mktime(16,0,0),
				),
				7 => FALSE,
			);
			
			
			
			$current_schedule = $time_checks[(int)date("N")];
						
			if ( $current_date_time >= $current_schedule['start'] && $current_date_time < $current_schedule['end'] )
			{
				$open = TRUE;
			}
			
			//return (!$open) ? null : $current_schedule;
			
			return null;
						
		}
		
		
		
		
		
		
		public function log_minute_stats($campaign_id, $set_dialler=FALSE, $connection=null)
		{
			
			date_default_timezone_set('Europe/London');
			
			$connection = (is_null($connection)) ? "gabdialler" : $connection;
			
			$campaign_stats = \Goautodial\Model_Vicidial_Campaign_Stats::find(null,array(),$connection)->where('campaign_id', $campaign_id)->get_one();
			
			
			$delete_early = \DB::query('DELETE FROM dialler_campaign_calls WHERE campaign="'+$campaign_id+'" DATE(date) < "'+date("Y-m-d H:i-s", strtotime("1 week ago"))+'";');

			$add_current = \Model_Dialler_Campaign_Call::forge(array(
				'campaign' => $campaign_id,
				'calls_made' => (int)$campaign_stats->calls_onemin,
				'calls_answered' => (int)$campaign_stats->answers_onemin,
				'date' => date("Y-m-d H:i-s")
			));
			
			$add_current->save();
			
			
		}
		
		
		
		//gipltd
		public function gipltd_log_minute_stats($campaign_id, $set_dialler=FALSE, $connection=null)
		{
			
			date_default_timezone_set('Europe/London');
			
			$connection = (is_null($connection)) ? "gipltd" : $connection;
			
			$campaign_stats = \Goautodial\Model_Vicidial_Campaign_Stats_Gipltd::find(null,array(),$connection)->where('campaign_id', $campaign_id)->get_one();
			
			
			$delete_early = \DB::query('DELETE FROM dialler_campaign_calls WHERE campaign="'."GIPLTD_".$campaign_id.'" DATE(date) < "'+date("Y-m-d H:i-s", strtotime("1 week ago"))+'";');

			$add_current = \Model_Dialler_Campaign_Call::forge(array(
				'campaign' => "GIPLTD_".$campaign_id,
				'calls_made' => (int)$campaign_stats->calls_onemin,
				'calls_answered' => (int)$campaign_stats->answers_onemin,
				'date' => date("Y-m-d H:i-s")
			));
			
			$add_current->save();
			
			
		}
		
		
		
		
		public function guess_dial_rate($campaign_id, $set_dialler=FALSE, $connection=null)
		{
		
			print "\n";
			
			$calls = 0;
			$answers = 0;
			$drops = 0;
			
			
			// Get the current stats for this campaign from the dialler
			$campaign_stats = \Goautodial\Model_Vicidial_Campaign_Stats::find(null,array(),$connection)->where('campaign_id', $campaign_id)->get_one();
			
			// Check that the campaign has actually been making calls
			if ($campaign_stats->calls_onemin > 0)
			{
				// Find an average of the calls, answers and drops that our campaign has had over the last 30, 15 and 1 minute(s)
				$calls = ((((int)$campaign_stats->calls_halfhour/2) + ((int)$campaign_stats->calls_fivemin*3) + ((int)$campaign_stats->calls_onemin*15))/3);
				$answers = ((((int)$campaign_stats->answers_halfhour/2) + ((int)$campaign_stats->answers_fivemin*3) + ((int)$campaign_stats->answers_onemin*15))/3);
				$drops = ((((int)$campaign_stats->drops_halfhour/2) + ((int)$campaign_stats->drops_fivemin*3) + ((int)$campaign_stats->drops_onemin*15))/3);
				
				// Work out the best dial rate to keep up the averages above without dropping calls
				$dial_rate = (((int)$answers+(int)$drops) == 0) ? FALSE : ((int)$calls/((int)$answers+(int)$drops));
				
				// Find the drop rate this campaign is running at for the the duration of the day
				$drop_rate = ($campaign_stats->answers_today == 0) ? 0 : ( ( $campaign_stats->drops_today / $campaign_stats->answers_today ) * 100 );
				
				
				
				if ($dial_rate == 0)
				{
					$dial_rate = 1;
				}
				
				// Reduce the dial rate based on the current drop rate to try and bring us under the limit quicker.
				if ($drop_rate > 3)
				{
					$dial_rate = ($dial_rate * 0.2);
				}
				else if ($drop_rate >= 2)
				{
					$dial_rate = ($dial_rate * 0.7);
				} 
				else if ($drop_rate < 2)
				{
					$dial_rate = ($dial_rate * 2);
				}
				
				$campaign_stats->differential_onemin . "\n";
				$required_channels = ($dial_rate*($campaign_stats->differential_onemin*1.8));
				
				
				$channels = 1000;
				
				if ($required_channels > $channels)
				{
					$dial_rate = $channels/($campaign_stats->differential_onemin*1.8);
				}

				$campaign = \Goautodial\Model_Vicidial_Campaigns::find($campaign_id,array(),$connection);
				
				$campaign->auto_dial_level = number_format(($dial_rate < 1) ? 1 : $dial_rate,3,'.','');
				$campaign->save();
				
				print $message = $campaign_id . " Dial rate set to: " . number_format($dial_rate,3,'.','');
	
				print "\nCalls: ".($calls*2)." Answers: ".($answers*2). " Drops: ".($drops*2)."\n";
				
			}
			else
			{
			
				if ($campaign_stats->agents_average_onemin > 0)
				{
					$campaign = \Goautodial\Model_Vicidial_Campaigns::find($campaign_id,array(),$connection);
				
					$campaign->auto_dial_level = number_format(1,3,'.','');
					$campaign->save();
					
					print $message = $campaign_id . " set to 1.";
					print "\n";
				}
				else
				{
					print $message = "No agents in " . $campaign_id;
					print "\n";
				}
			}
			
			
			@ob_flush();
			
			return $message;
			
		}
		
		
		
		
		
		
		// gipltd
		public function gipltd_guess_dial_rate($campaign_id, $set_dialler=FALSE, $connection=null)
		{
		
			print "\n";
			
			$calls = 0;
			$answers = 0;
			$drops = 0;
			
			
			// Get the current stats for this campaign from the dialler
			$campaign_stats = \Goautodial\Model_Vicidial_Campaign_Stats_Gipltd::find(null,array(),$connection)->where('campaign_id', $campaign_id)->get_one();
			
			// Check that the campaign has actually been making calls
			if ($campaign_stats->calls_onemin > 0)
			{
				// Find an average of the calls, answers and drops that our campaign has had over the last 30, 15 and 1 minute(s)
				$calls = ((((int)$campaign_stats->calls_halfhour/2) + ((int)$campaign_stats->calls_fivemin*3) + ((int)$campaign_stats->calls_onemin*15))/3);
				$answers = ((((int)$campaign_stats->answers_halfhour/2) + ((int)$campaign_stats->answers_fivemin*3) + ((int)$campaign_stats->answers_onemin*15))/3);
				$drops = ((((int)$campaign_stats->drops_halfhour/2) + ((int)$campaign_stats->drops_fivemin*3) + ((int)$campaign_stats->drops_onemin*15))/3);
				
				// Work out the best dial rate to keep up the averages above without dropping calls
				$dial_rate = (((int)$answers+(int)$drops) == 0) ? FALSE : ((int)$calls/((int)$answers+(int)$drops));
				
				// Find the drop rate this campaign is running at for the the duration of the day
				$drop_rate = ($campaign_stats->answers_today == 0) ? 0 : ( ( $campaign_stats->drops_today / $campaign_stats->answers_today ) * 100 );
				
				
				
				if ($dial_rate == 0)
				{
					$dial_rate = 0.5;
				}
				
				// Reduce the dial rate based on the current drop rate to try and bring us under the limit quicker.
				if ($drop_rate > 4)
				{
					$dial_rate = ($dial_rate * 0.5);
				}
				else if ($drop_rate >= 3)
				{
					$dial_rate = ($dial_rate * 0.7);
				} 
				else if ($drop_rate < 2)
				{
					$dial_rate = ($dial_rate * 2.5);
				}
				
				$campaign_stats->differential_onemin . "\n";
				$required_channels = ($dial_rate*($campaign_stats->differential_onemin*1.8));
				
				
				$channels = ($connection=="rj5") ? 96 : 250;
				
				if ($required_channels > $channels)
				{
					$dial_rate = $channels/($campaign_stats->differential_onemin*1.8);
				}

				$campaign = \Goautodial\Model_Vicidial_Campaigns_Gipltd::find($campaign_id,array(),$connection);
				
				$campaign->auto_dial_level = number_format($dial_rate,3,'.','');
				$campaign->save();
				
				print $message = $campaign_id . " Dial rate set to: " . number_format($dial_rate,3,'.','');
	
				print "\nCalls: ".($calls*2)." Answers: ".($answers*2). " Drops: ".($drops*2)."\n";
				
			}
			else
			{
			
				if ($campaign_stats->agents_average_onemin > 0)
				{
					$campaign = \Goautodial\Model_Vicidial_Campaigns_Gipltd::find($campaign_id,array(),$connection);
				
					$campaign->auto_dial_level = number_format(1,3,'.','');
					$campaign->save();
					
					print $message = $campaign_id . " set to 1.";
					print "\n";
				}
				else
				{
					print $message = "No agents in " . $campaign_id;
					print "\n";
				}
			}
			
			
			@ob_flush();
			
			return $message;
			
		}
		
		
		
		
		public function set_campaign_rate($campaign_id, $dial_rate)
		{
			$campaign = \Goautodial\Model_Vicidial_Campaigns::find($campaign_id);
			
			$campaign->auto_dial_level = $dial_rate;
			
			$campaign->save();
		}
		
		
		
		
		
		
		
		
		public function get_first_payment_date($date=null, $office='GAB')
		{
		
    		$debtsolv = ($office == "GAB") ? "Debtsolv_MMS.dbo" : "BS_Debtsolv_DM.dbo";
				    
		    $chosenDate = (is_null($date)) ? date('Y-m-d') : date('Y-m-d', strtotime($date));
    		// Find a list of all payments from today that do not already have a first payment
    		$todayPayments = \DB::query("   SELECT 
                                                D_PA.ClientID
                                              , D_CPD.NormalExpectedPayment AS DI
                                              , (SELECT SUM(AmountIn) FROM ".$debtsolv.".Payment_Account WHERE ClientID = D_PA.ClientID) AS TotalPaid
                                            FROM 
                                              ".$debtsolv.".Payment_Account AS D_PA
                                            LEFT JOIN
                                              Dialler.dbo.client_dates AS D_CD ON D_CD.ClientID = D_PA.ClientID
                                            LEFT JOIN
                                              ".$debtsolv.".Client_PaymentData AS D_CPD ON D_CPD.ClientID = D_PA.ClientID
                                            WHERE
                                              D_PA.AmountIn > 0
                                              AND ISNULL(D_CD.FirstPaymentDate, '') = ''
                                              AND ISNULL(D_CD.Office, '') <> '" . $office . "'
                                            ORDER BY
                                              D_PA.TransactionDate DESC")->execute('debtsolv');
                                              
                                       
    		
    		// Loop through all payments and check if a first payment has been made
    		foreach ($todayPayments AS $paymentDetails)
    		{
			\Cli::write('Checking Client: ' . $paymentDetails['ClientID']);

        		if ($paymentDetails['TotalPaid'] >= $paymentDetails['DI'])
        		{
            		
            		// If a first payment has been made add the date to the first payment list
            		
            		$clientID = $paymentDetails['ClientID'];
            		$di = $paymentDetails['DI'];
            		
            		$totalPayments = \DB::query("   SELECT
                                                        D_PA.AmountIn AS Paid
                                                      , D_PA.Date
                                                    FROM
                                                      ".$debtsolv.".Payment_Account AS D_PA
                                                    WHERE 
                                                      D_PA.ClientID = " . $clientID . "
                                                      AND D_PA.AmountIn > 0
                                                    ORDER BY
                                                      D_PA.Date ASC")->execute('debtsolv');
            		
            		if ($di == 0)
            		{
                		// Commented out ticket system as we shouldn't need it!
                		//Adam::submit_ticket("Incorrect DI Value", "I have found a client in Debtsolv with a DI value of £0. The Client ID is " . $clientID);
            		}
            		else
            		{
                		$firstPaymentDate = null;
                		$runningTotal = 0;
                		foreach ($totalPayments AS $payment)
                		{
                    		$runningTotal = $runningTotal + $payment['Paid'];
                    		if ($runningTotal >= $di AND is_null($firstPaymentDate))
                    		{
                        		$firstPaymentDate = date('Y-m-d', strtotime($payment['Date']));
                    		}
                		}
                		
                		
                		
                		
                		// Send an e-mail to the group announcing the first payment!
                		
                		
                		$email = \Email::forge();
			
        				$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
        				
        				$email->to(array(
        					'firstpayments@expertmoneysolutions.co.uk'  => 'First Payments List',
        				));
        				
        				
        				$email->priority(\Email::P_HIGH);
        				
        				$email->subject('New First Payment');
        				
        				$email->html_body(\View::forge('emails/firstpayment/first-payment', array(
        					'email_data' => array(
        					   'clientID' => $clientID,
        					   'di' => "£" . number_format(($di/100),2),
        					   'office' => $office,
        					),
        				)));
        				
        				$email->send();
        				
                		// Print to console
                		
                		\Cli::write("Client ID " . $clientID . " first DI of £" . number_format(($di/100),2) . " paid on " . $firstPaymentDate . "\n");

                		$result = @\DB::query("INSERT INTO Dialler.dbo.client_dates (ClientID, FirstPaymentDate, Office) VALUES (".$clientID.", '".$firstPaymentDate."', '".$office."')")->execute('debtsolv');
                		
                		
            		}
            		
        		}
        		else
        		{
            		// Client hasn't quite made a first payment yet
        		}
        		
        		
        		
    		}
    		
    		
            /*
            
            DELETE [Dialler].[dbo].[client_dates] 
            FROM [Dialler].[dbo].[client_dates]
            LEFT OUTER JOIN (
               SELECT MIN(id) as id, ClientID, FirstPaymentDate, Office
               FROM [Dialler].[dbo].[client_dates] 
               GROUP BY ClientID, FirstPaymentDate, Office
            ) as KeepRows ON
               [Dialler].[dbo].[client_dates].id = KeepRows.id
            WHERE
               KeepRows.id IS NULL
               
            */
    		
    		
        		\Log::write('ADAM', "First Payment Table updated");
    		
		}
    
    public function senior_transfer_log_report()
    {
      $results = array();
      $results = @\DB::query("SELECT
                               LST.lead_id
                              ,office
                              ,lead_source
                              ,tele_agent
                              ,senior_username
                              ,DATE_FORMAT(transfered_date_time, '%H:%i') AS transfered_date_time
                              ,IF(completed_date_time = '0000-00-00 00:00:00', 'Not Clicked Saved', DATE_FORMAT(completed_date_time, '%H:%i')) AS completed_date_time
                              ,leadpool_id
                              ,VL.list_id
                              ,IF(error_message != '', 'YES','NO') AS 'has_error'
                              ,error_message
                              ,LSTS.description
                              FROM
                                gab_log_senior_transfer AS LST
                              LEFT JOIN
                                gab_log_senior_transfer_status AS LSTS ON LST.status = LSTS.ID
                              LEFT JOIN
                                vicidial_list AS VL ON LST.lead_id = VL.lead_id
                              WHERE
                                transfered_date_time >= NOW() - INTERVAL 1 HOUR
                              ORDER BY
                                transfered_date_time ASC
                             ")->execute('gabdialler')->as_array();
                             
      if(count($results) <= 0)
        return;
        
      $itReport = array();
                           
      foreach($results as $key => $result)
      {
        if($result['has_error'] == 'YES')
        {
          $itReport[] = $results[$key];
        }
      }
      
      // -- Send Main Transfer Report by email
      // -------------------------------------
      $email = \Email::forge();
      
      $email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
        				
      $email->to(array(
        					'senior-transfers@expertmoneysolutions.co.uk'  => 'Senior Transfer Report',
        				));
                
      $email->subject('Senior Transfer Report ' . date("d-m-Y") . ' ' . (date("H") - 1));
      
      $email->html_body(\View::forge('emails/seniortransfers/senior-transfers', array(
              					'results' => $results,
              					)
              				));
                      
      $email->send();
      
      unset($email);
      
      // -- If there were any with errors, then send them to I.T.
      // --------------------------------------------------------
      if(count($itReport) > 0)
      {
        $email = \Email::forge();
        
        $email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
        
        $email->to(array(
        					'it@expertmoneysolutions.co.uk'  => 'Senior Transfer Error Report',
        				));
                
        $email->subject('Senior Transfer Error Report ' . date("d-m-Y") . ' ' . (date("H") - 1));
        
        $email->html_body(\View::forge('emails/seniortransfers/senior-transfers-errors', array(
              					'results' => $itReport,
              					)
              				));
                      
        $email->send();
      }
    }
				
		
		
		
		
		
		
		
		
		
		
		
		public function moveTeleSalesYear()
		{
		    /*
		    \Cli::write("Starting January\n");
		    for ($i = 1; $i <= 31; $i++)
		    {
    		    $checkDay = mktime(0,0,0,1,$i,2013);
    		    Adam::move_telesales_staff(date("jS F Y", $checkDay));
    		    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }
            
            \Cli::write("\nStarting Feburary\n");
		    for ($i = 1; $i <= 28; $i++)
		    {
    		    $checkDay = mktime(0,0,0,2,$i,2013);
    		    Adam::move_telesales_staff(date("jS F Y", $checkDay));
    		    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }
            
            \Cli::write("\nStarting March\n");
		    for ($i = 1; $i <= 31; $i++)
		    {
    		    $checkDay = mktime(0,0,0,3,$i,2013);
    		    Adam::move_telesales_staff(date("jS F Y", $checkDay));
    		    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }
            */
            \Cli::write("\nStarting April\n");
		    for ($i = 1; $i <= 30; $i++)
		    {
    		    $checkDay = mktime(0,0,0,4,$i,2013);
    		    Adam::move_telesales_staff(date("jS F Y", $checkDay));
    		    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }
            
            \Cli::write("\nStarting May\n");
		    for ($i = 1; $i <= 30; $i++)
		    {
    		    $checkDay = mktime(0,0,0,5,$i,2013);
    		    Adam::move_telesales_staff(date("jS F Y", $checkDay));
    		    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }

 \Cli::write("\nStarting June\n");
                    for ($i = 1; $i <= 30; $i++)
                    {
                    $checkDay = mktime(0,0,0,6,$i,2013);
                    Adam::move_telesales_staff(date("jS F Y", $checkDay));
                    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }

 \Cli::write("\nStarting July\n");
                    for ($i = 1; $i <= 31; $i++)
                    {
                    $checkDay = mktime(0,0,0,7,$i,2013);
                    Adam::move_telesales_staff(date("jS F Y", $checkDay));
                    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }

 \Cli::write("\nStarting August\n");
                    for ($i = 1; $i <= 31; $i++)
                    {
                    $checkDay = mktime(0,0,0,8,$i,2013);
                    Adam::move_telesales_staff(date("jS F Y", $checkDay));
                    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }

 \Cli::write("\nStarting September\n");
                    for ($i = 1; $i <= 30; $i++)
                    {
                    $checkDay = mktime(0,0,0,9,$i,2013);
                    Adam::move_telesales_staff(date("jS F Y", $checkDay));
                    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }

 \Cli::write("\nStarting October\n");
                    for ($i = 1; $i <= 31; $i++)
                    {
                    $checkDay = mktime(0,0,0,10,$i,2013);
                    Adam::move_telesales_staff(date("jS F Y", $checkDay));
                    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }

 \Cli::write("\nStarting November\n");
                    for ($i = 1; $i <= 20; $i++)
                    {
                    $checkDay = mktime(0,0,0,11,$i,2013);
                    Adam::move_telesales_staff(date("jS F Y", $checkDay));
                    \Cli::write(date("jS F Y", $checkDay)." Done\n");
            }





    		
		}
		
		
		/**
		 * Function to move telesales staff based on performance.
		 * 
		 * @access public
		 * @return void
		 */
		public function move_telesales_staff($chosenDay=null)
		{
			print "Running";
		    // Work out days are required
		    $chosenDate = (is_null($chosenDay)) ? strtotime(date('o-\\WW'))  : strtotime($chosenDay);
		    $earlyDate  = (is_null($chosenDay)) ? strtotime(date("jS F Y", $chosenDate) . ' -7 days') : strtotime($chosenDay . ' -7 days');
		    
		    // How many Bolton staff
            $premierPercent   = 20;
            // Number of agents promoted / demoted daily
            $promotionCount   = 3;
            
            // Providing the day is not a weekend we run the script
		    if ((int)date("N", $chosenDate) < 6)
		    {
                
                // Get list of top staff
                $staffListRequestSecondary = \Controller_Reports::generate_telesales_report(null, date("Y-m-d",$chosenDate), date("Y-m-d",$chosenDate));
                
                // Get list of details over the past 7 days for extra checking purposes
                $staffListRequest = \Controller_Reports::generate_telesales_report(null, date("Y-m-d", $earlyDate), date("Y-m-d",$chosenDate));
                
                
		        // Number of staff required for the premier campaign
                $requiredPremier = ceil((count($staffListRequest['report']) * ($premierPercent/100)));
 
                // Create a list of user IDs so we can easily pull the keys required from the main array
                // First one is for the daily results
                $staffDiallerList = array();
        		$staffList = $staffListRequest['report'];
                foreach ($staffList as $key => $single)
                {
                    $staffDiallerList[$single['dialler_id']] = $key;
                }
                
                // Second is for the 7 day results
                $staffSecondDiallerList = array();
        		$staffSecondList = $staffListRequestSecondary['report'];
                foreach ($staffSecondList as $key => $single)
                {
                    $staffSecondDiallerList[$single['dialler_id']] = $key;
                }
                
                $premierAll = array();
                $standardAll = array();
                
                // Get PREMIER-GBS
                $premierGBS = \DB::query("SELECT user FROM vicidial_users WHERE user_group='PREMIER-GBS';")->cached(0)->execute('gabdialler');
                foreach ($premierGBS as $single) $premierAll[] = array('user' => $single['user'], 'center' => 'GBS');
                
                // Get PREMIER-GBS
                //$premierRESOLVEPART = \DB::query("SELECT user FROM vicidial_users WHERE user_group='PREMIER-RESOLVEPART';")->cached(0)->execute('gabdialler');
                //foreach ($premierRESOLVEPART as $single) $premierAll[] = array('user' => $single['user'], 'center' => 'RESOLVEPART');
                
                // Get PREMIER-GBS
                //$premierRESOLVE = \DB::query("SELECT user FROM vicidial_users WHERE user_group='PREMIER-RESOLVE';")->cached(0)->execute('gabdialler');
                //foreach ($premierRESOLVE as $single) $premierAll[] = array('user' => $single['user'], 'center' => 'RESOLVE');
                
                // Get PREMIER-GAB
                $premierGAB = \DB::query("SELECT user FROM vicidial_users WHERE user_group='PREMIER-GAB';")->cached(0)->execute('gabdialler');
                foreach ($premierGAB as $single) $premierAll[] = array('user' => $single['user'], 'center' => 'GAB');
                
                // Get STANDARD-GBS
                $standardGBS = \DB::query("SELECT user FROM vicidial_users WHERE user_group='STANDARD-GBS';")->cached(0)->execute('gabdialler');
                foreach ($standardGBS as $single) $standardAll[] = array('user' => $single['user'], 'center' => 'GBS');
                
                // Get STANDARD-GAB
                //$standardRESOLVEPART = \DB::query("SELECT user FROM vicidial_users WHERE user_group='STANDARD-RESOLVEPART';")->cached(0)->execute('gabdialler');
                //foreach ($standardRESOLVEPART as $single) $standardAll[] = array('user' => $single['user'], 'center' => 'RESOLVEPART');
                
                // Get STANDARD-GAB
                //$standardRESOLVE = \DB::query("SELECT user FROM vicidial_users WHERE user_group='STANDARD-RESOLVE';")->cached(0)->execute('gabdialler');
                //foreach ($standardRESOLVE as $single) $standardAll[] = array('user' => $single['user'], 'center' => 'RESOLVE');
                
                // Get STANDARD-GAB
                $standardGAB = \DB::query("SELECT user FROM vicidial_users WHERE user_group='STANDARD-GAB';")->cached(0)->execute('gabdialler');
                foreach ($standardGAB as $single) $standardAll[] = array('user' => $single['user'], 'center' => 'GAB');
                
                // Add scores to premier users
                $premierAllWithScores = array();
                $premierCount = 0;
                foreach ($premierAll as $single)
                {
                    if (isset($staffDiallerList[$single['user']])) 
                    {
                        $premierAllWithScores[$premierCount] = $staffList[$staffDiallerList[$single['user']]];
                        $premierAllWithScores[$premierCount]['backup'] = $staffSecondList[$staffSecondDiallerList[$single['user']]]['points'];
                        $premierAllWithScores[$premierCount]['center'] = $single['center'];
                    }
                    else
                    {
                        \DB::query("UPDATE vicidial_users SET user_group='STANDARD-".$single['center']."' WHERE user='".$single['user']."';")->execute('gabdialler');
                    }
                    $premierCount++;
                    
                }
                // Sort premier users by daily points and weekly points as a backup
                $premierAllWithScores = \Arr::multisort($premierAllWithScores, array(
                    'points' => SORT_ASC,
                ), true);
                
                
                // Add scores to standard users
                $standardAllWithScores = array();
                $standardCount = 0;
                foreach ($standardAll as $single)
                {
                    if (isset($staffDiallerList[$single['user']])) 
                    {
                        $standardAllWithScores[$standardCount] = $staffList[$staffDiallerList[$single['user']]];
                        $standardAllWithScores[$standardCount]['backup'] = $staffSecondList[$staffSecondDiallerList[$single['user']]]['points'];
                        $standardAllWithScores[$standardCount]['center'] = $single['center'];
                    }
                    else
                    {
                        \DB::query("UPDATE vicidial_users SET user_group='STANDARD-".$single['center']."' WHERE user='".$single['user']."';")->execute('gabdialler');
                    }
                    $standardCount++;
                }
                // Sort standard users by daily points and weekly points as a backup
                $standardAllWithScores = \Arr::multisort($standardAllWithScores, array(
                    'points' => SORT_DESC,
                ), true);
                
                
                
                
                // Work out Demotions
                $totalInPremierATM = count($premierAllWithScores);
                $demotionsToStandard = array();
                for ($i = 0; $i <= (($promotionCount-1)+($totalInPremierATM-$requiredPremier)); $i++)
                {
                    if (isset($premierAllWithScores[$i]))
                    {
                        $demotionsToStandard[] = $premierAllWithScores[$i];
                        unset($premierAllWithScores[$i]);
                    }
                }
                // Work out Promotions
                $promotionsToPremier = array();
                for ($i = 0; $i <= ($promotionCount-1); $i++)
                {
                    $promotionsToPremier[] = $standardAllWithScores[$i];
                    unset($standardAllWithScores[$i]);
                }
                
                
                // Generate new User group lists
                $newPremierList = array_merge(array_reverse($premierAllWithScores), $promotionsToPremier);
                $newStandardList = array_merge($demotionsToStandard, $standardAllWithScores);
                
                
                // Update the dialler with the new groups
                foreach ($newPremierList as $single)
                {
                    \DB::query("UPDATE vicidial_users SET user_group='PREMIER-".$single['center']."' WHERE user='".$single['dialler_id']."';")->execute('gabdialler');
                }
                
                foreach ($newStandardList as $single)
                {
                    \DB::query("UPDATE vicidial_users SET user_group='STANDARD-".$single['center']."' WHERE user='".$single['dialler_id']."';")->execute('gabdialler');
                }
                
                
        		// E-Mail Managers with new campaign lists
        		$email = \Email::forge();
    			
        		$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
        		
        		$email->to(array(
        			'telesalesleaders@expertmoneysolutions.co.uk'  => 'Telesales Group Updates',
        		));
        		
        		$email->priority(\Email::P_HIGH);
        		
        		$email->subject('Dialler Staff Ranking Update');
        		
        		$email->html_body(\View::forge('emails/dialler/ranking', array(
        			'top'    => \Arr::multisort($newPremierList, array('points' => SORT_DESC, 'backup' => SORT_DESC,), true),
        			'bottom' => \Arr::multisort($newStandardList, array('points' => SORT_DESC, 'backup' => SORT_DESC,), true),
        			'promotions' => $promotionsToPremier,
        			'demotions' => $demotionsToStandard,
        			'chosendate' => $earlyDate,
        			'chosenenddate' => $chosenDate,
        		)));
        		
        		$email->send();
    		
    		}
    		
		}
		
		
		
		
		
		public function transfer_leads()
		{
    		ini_set('memory_limit', '-1');
    		
    		$limit = 10000;
    		
    		
    		$count = \DB::select(\DB::expr('COUNT(lead_id) as count'))->from('vicidial_list_copy')->execute('resolvedialler');
    		$result_arr = $count->current();
    		$counter = $result_arr['count'];
    		
    		$pages = ceil($counter/$limit);
    		
    		\Cli::write("Total Leads to Import:  ".$counter);
    		
    		
    		for ($i = 1; $i <= $pages; $i++) {
    		
        		$results = \DB::select('*')->from('vicidial_list_copy')->limit($limit)->execute('resolvedialler')->as_array();
        		
        		foreach ($results as $singleLead)
        		{
            		$leadInsert = array(
                        'lead_id'                 => "",
                        'entry_date'              => $singleLead['entry_date'],
                        'modify_date'             => $singleLead['modify_date'],
                        'status'                  => $singleLead['status'],
                        'user'                    => $singleLead['user'],
                        'vendor_lead_code'        => $singleLead['vendor_lead_code'],
                        'source_id'               => $singleLead['source_id'],
                        'list_id'                 => $singleLead['list_id'],
                        'gmt_offset_now'          => $singleLead['gmt_offset_now'],
                        'called_since_last_reset' => $singleLead['called_since_last_reset'],
                        'phone_code'              => $singleLead['phone_code'],
                        'phone_number'            => $singleLead['phone_number'],
                        'title'                   => $singleLead['title'],
                        'first_name'              => $singleLead['first_name'],
                        'middle_initial'          => $singleLead['middle_initial'],
                        'last_name'               => $singleLead['last_name'],
                        'address1'                => $singleLead['address1'],
                        'address2'                => $singleLead['address2'],
                        'address3'                => $singleLead['address3'],
                        'city'                    => $singleLead['city'],
                        'state'                   => $singleLead['state'],
                        'province'                => $singleLead['province'],
                        'postal_code'             => $singleLead['postal_code'],
                        'country_code'            => $singleLead['country_code'],
                        'gender'                  => $singleLead['gender'],
                        'date_of_birth'           => $singleLead['date_of_birth'],
                        'alt_phone'               => $singleLead['alt_phone'],
                        'email'                   => $singleLead['email'],
                        'security_phrase'         => $singleLead['security_phrase'],
                        'comments'                => $singleLead['comments'],
                        'called_count'            => $singleLead['called_count'],
                        'last_local_call_time'    => $singleLead['last_local_call_time'],
                        'rank'                    => $singleLead['rank'],
                        'owner'                   => $singleLead['owner'],
                        'entry_list_id'           => $singleLead['entry_list_id'],
                    );
                    
                    // Add leads directly to the dialler
                    
                    
                    list($insertID, $rowsChanged) = \DB::insert('vicidial_list')->set($leadInsert)->execute('gabdialler');
                    
    
                    \DB::update('vicidial_callbacks_copy')->set(array('lead_id'=>$insertID))->where('lead_id', $singleLead['lead_id'])->execute('resolvedialler');
                    
                    
                    \DB::delete('vicidial_list_copy')->where('lead_id', $singleLead['lead_id'])->execute('resolvedialler');
                    
                    
                    \Cli::write("New Lead ".$insertID." added.");
                    
                    
                    
            		
        		}
    		
    		}
    		

                
		}
		
		
		
		
		
		
		public function tps_check($list=0, $percentAlert=1)
		{
		    ini_set('memory_limit', '-1');
		    $startTime = strtotime("NOW");
		    $tpsIDList = array();
    		$numberQuery = \DB::select('lead_id', 'phone_number', 'alt_phone')->from('vicidial_list');
    		
    		if ($list > 0)
    		{
        		$numberQuery->where('list_id', $list);
    		}
    		
    		$numberQuery->where('status', 'NOT IN', array(
    		    'TPS',
    		    'DNC',
    		    'DNCL',
    		    'EXISCL',
    		    'SALE',
    		    'PPI',
    		    'PPICLM',
    		    'PPICOM',
    		    'DMPLUS',
    		    'DR',
    		))->where('security_phrase', '!=', 'Y');
    		
    		$numbersToCheck = $numberQuery->execute('gabdialler');
    		
    		$tpsMatchCount = 0;
    		
    		$alertPercent = $percentAlert;
    		$alertNumber = floor(count($numbersToCheck)*($alertPercent/100));
    		\Cli::write('Total Numbers to Check: '.count($numbersToCheck));
    		
    		$i = 0;
    		$j = 0;
    		$p = 0;
    		
    		$tpsCount = 0;
    		
    		$temptps = 0;
    		$tempok = 0;
    		foreach ($numbersToCheck as $lead)
    		{
    		    $i++;
    		    $j++;
        		$tpsCheckQuery = \DB::select('number')->from('tps');
        		
        		if (strlen($lead['phone_number']) > 6)
        		{
            		$tpsCheckQuery->where('number', $lead['phone_number']);
        		}
        		
        		if (strlen($lead['phone_number']) > 6 && strlen($lead['alt_phone']) > 6)
        		{
        		    $tpsCheckQuery->or_where('number', $lead['alt_phone']);
        		}
        		
        		if (strlen($lead['phone_number']) < 6 && strlen($lead['alt_phone']) > 6)
        		{
        		    $tpsCheckQuery->where('number', $lead['alt_phone']);
        		}
        		
        		if (strlen($lead['phone_number']) > 6 || strlen($lead['alt_phone']) > 6)
        		{
            		$tpsCheck = $tpsCheckQuery->execute();
        		}
        		
        		if (count($tpsCheck) > 0)
        		{
        		    $tpsMatchCount++;
            		$tpsIDList[] = $lead['lead_id'];
            		$temptps++;
            		// \Cli::write(\Cli::color('TPS Match on Lead ID: '.$lead['lead_id'], 'red'));
        		}
        		else
        		{
            		$tempok++;
        		}
        		
        		if ($i==$alertNumber)
        		{
        		    $endTime = strtotime("NOW");
        		    
        		    $perLead = (($endTime-$startTime)/$j);
        		    $remaining = count($numbersToCheck) - $j;
        		    $remainingTime = number_format(($remaining*$perLead)/60,2);
        		    
        		    
            		if (count($tpsIDList) > 0)
            		{
                		$result = \DB::update('vicidial_list')->set(array('status'=>'TPS'))->where('lead_id', 'IN', $tpsIDList)->execute('gabdialler');
                		$tpsIDList = array();
            		}
        		    
        		    $p = $p+$alertPercent;
            		\Cli::write($j.' numbers checked (~'.$p.'%) - OK: '.$tempok.' TPS:'.$temptps.' Remaining: '.$remainingTime.' minutes.');
            		$i=0;
            		$temptps = 0;
            		$tempok = 0;
        		}
        		
    		}
    		
    		if (count($tpsIDList) > 0)
    		{
        		$result = \DB::update('vicidial_list')->set(array('status'=>'TPS'))->where('lead_id', 'IN', $tpsIDList)->execute('gabdialler');
        		$tpsIDList = array();
    		}
    		
    		$endTime = strtotime("NOW");
    		
    		$perLead = ($tpsMatchCount>0) ? (($endTime-$startTime)/$tpsMatchCount) : 0;
    		
    		\Cli::write('Total Numbers to Check: '.count($numbersToCheck));
    		\Cli::write('Total TPS matches: '.$tpsMatchCount);
    		\Cli::write('Time taken: '.($endTime-$startTime)." seconds");
    		\Cli::write('Time per lead: '. $perLead ." seconds");
    		
		}
    
    /**
     * Find out who has been late - Taken from the dialler
     * 
     * @author David Stansfield
     */
    public function staff_late_report()
    {
      // -- Settings
      // -----------
      $breakTime = '900';
      $lunchTime = '3600';
      
      $totalMonToThurs = '5400';
      $totalFri = '5400'; #Old Time 4500
      
      $date = date("Y-m-d", strtotime("-1 day", time()));
      $startDateTime = date("Y-m-d 00:00:01", strtotime("-1 day", time()));
      $endDateTime = date("Y-m-d 23:59:59", strtotime("-1 day", time()));
      
      $hqGroup = array(
        'PREMIER-GAB',
        'STANDARD-GAB',
        'GAB',
        'GABAGENT',
        'GABSENIOR',
        'GABPPISNR',
      );
      /*
      $resolveGroup = array(
        'PREMIER-RESOLVE',
        'PREMIER-RESOLVEPART',
        'STANDARD-RESOLVE',
        'STANDARD-RESOLVEPART',
        'RESOLVE',
      );
      */
      $hqEmailDetails = array(
        'to' => array('dialler-lateness-report@moneymanagementservices.co.uk',
                     ),
        'subject' => 'Bolton: Staff Break/Lunch Late Report',
        'results' => array(),
      );
      /*
      $resolveEmailDetails = array(
        'to' => array('d.stansfield@expertmoneysolutions.co.uk',
                      'l.baker@resolvemm.co.uk',
                      'mark@resolvemm.co.uk',
                      'a.brooke@expertmoneysolutions.co.uk',
                      'i.patterson@expertmoneysolutions.co.uk',
                      'g.gregson@expertmoneysolutions.co.uk',
                      'l.davenport@expertmoneysolutions.co.uk',
                      's.jayne@expertmoneysolutions.co.uk',
                     ),
        'subject' => 'Resolve: Staff Break/Lunch Late Report',
        'results' => array(),
      );
      */
      
      // -- Get the Results
      // ------------------
      $results = array();
      $results = \DB::query("SELECT
                              	VAL.user
                                 ,VU.full_name
                                 ,VAL.user_group
                                 ,SUM(pause_sec) AS total_sec_time
                                 ,SEC_TO_TIME(SUM(pause_sec)) AS total_break_time
                                 ,SEC_TO_TIME(SUM(pause_sec) - IF(DAYNAME('" . $date . "') = 'Friday', " . $totalFri . ", " . $totalMonToThurs . ")) AS time_diff
                                 ,SUM(IF(`sub_status` = 'Break', 1, 0)) AS total_breaks_taken
                                 ,SUM(IF(`sub_status` = 'Lunch', 1, 0)) AS total_lunch_taken
                               FROM
                                 vicidial_agent_log AS VAL
                               LEFT JOIN
                                 vicidial_users AS VU ON VAL.user = VU.user
                               WHERE
                                 event_time >= '" . $startDateTime . "'
                               AND
                                 event_time <= '" . $endDateTime . "'
                               AND
                                 sub_status IN ('Break', 'Lunch')
                               AND
                                 pause_sec > 0
                               GROUP BY
                                 VAL.user
                               HAVING
                                 time_diff >= 60
                               ORDER BY
                                 time_diff DESC
                            ", \DB::SELECT)->execute('gabdialler')->as_array();
                               
      if(count($results) <= 0)
        return false;
        
      // -- Get a break down of eack late staff member
      // ---------------------------------------------
      foreach($results as $key => $result)
      {
        $breakDownResults = array();
        $breakDownResults = \DB::query("SELECT
                                           sub_status
                                          ,pause_sec
                                          ,SEC_TO_TIME(pause_sec) AS total_break_time
                                          ,IF(sub_status = 'Lunch' AND pause_sec > " . (int)$lunchTime . ", 'YES', IF(sub_status = 'Break' AND pause_sec > " . (int)$breakTime . ", 'YES', 'NO')) AS is_late
                                          ,SEC_TO_TIME(IF(sub_status = 'Lunch' AND pause_sec > " . (int)$lunchTime . ", pause_sec - " . (int)$lunchTime . ", IF(sub_status = 'Break' AND pause_sec > " . (int)$breakTime . ", pause_sec - " . (int)$breakTime . ", ''))) AS time_diff
                                        FROM
                                          vicidial_agent_log
                                        WHERE
                                          user = " . \DB::quote($result['user']) . "
                                        AND
                                          sub_status IN ('Break', 'Lunch')
                                        AND
                                          event_time >= '" . $startDateTime . "'
                                        AND
                                          event_time <= '" . $endDateTime . "'
                                        AND
                                          pause_sec > 0
                                        ORDER BY
                                          time_diff DESC
                                       ", \DB::SELECT)->execute('gabdialler')->as_array();
             
        // -- Add it to the user results
        // -----------------------------                          
        $results[$key]['breakDown'] = $breakDownResults;
        unset($breakDownResults);
        
        // -- Filter out the users into the Office Groups
        // ----------------------------------------------
        if(in_array($result['user_group'], $hqGroup))
        {
          // -- HQ Group
          // -----------
          $hqEmailDetails['results'][] = $results[$key];
        }
        /*
        else if(in_array($result['user_group'], $resolveGroup))
        {
          // -- Resolve Group
          // ----------------
          $resolveEmailDetails['results'][] = $results[$key];
        }
        */
      }
      
      // -- Send the emails out to the sales managers
      // --------------------------------------------
      
      // -- HQ Email
      // -----------
      if(count($hqEmailDetails['results']) > 0)
      {
        $email = \Email::forge();
        $email->from('noreply@moneymanagementservices.co.uk', 'Money Management Services');
      
        $email->to($hqEmailDetails['to']);
                
        $email->subject($hqEmailDetails['subject'] . ' ' . $date);
        
        $email->html_body(\View::forge('emails/latestaff/late-staff', array(
              					'results' => $hqEmailDetails['results'],
              					)
              				));
                      
        $email->send();
      }
      
      unset($email);
      
      // -- Resolve Email
      // ----------------
      /*
      if(count($resolveEmailDetails['results']) > 0)
      {
        $email = \Email::forge();
        $email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
      
        $email->to($resolveEmailDetails['to']);
                
        $email->subject($resolveEmailDetails['subject'] . ' ' . $date);
        
        $email->html_body(\View::forge('emails/latestaff/late-staff', array(
              					'results' => $resolveEmailDetails['results'],
              					)
              				));
                      
        $email->send();
      }
      */
    }
    
    /**
     * Terminated and Suspended Clients Report
     * 
     * @author David Stansfield
     */
    public function terminated_suspended_clients_report()
    {
      $offices = array(
        '1-Tick' => array('connection' => 'debtsolv_1tick',
                          'database' => 'Debtsolv',
                          'to' => array('bolton-client-status-report@expertmoneysolutions.co.uk')
                          #'to' => array('d.stansfield@clix.co.uk')
                         ),

        'Expert Money Solutions' => array('connection' => 'debtsolv_gabfs',
                                          'database' => 'Debtsolv_GABFS',
                                          'to' => array('bolton-client-status-report@expertmoneysolutions.co.uk')
                                          #'to' => array('d.stansfield@clix.co.uk')
                                         ),

        'Money Management Solutions' => array('connection' => 'debtsolv',
                                              'database' => 'Debtsolv_MMS',
                                              'to' => array('bolton-client-status-report@expertmoneysolutions.co.uk')
                                              #'to' => array('d.stansfield@clix.co.uk')
                                     ),

      );

      foreach($offices as $office => $officeData)
      {
        $officeResults = array();
        $officeResults = \DB::query("SELECT
                                       PROCESSING_LOG.ClientID
                                      ,CLIENT_CONTACT.Title
                                      ,CLIENT_CONTACT.Forename
                                      ,CLIENT_CONTACT.Surname
                                      ,CLIENT_STATUS.Description AS ClientStatus
                                      ,USERS.Undersigned AS 'CreatedBy'
                                      ,PROCESSING_LOG.ProcessingStatus
                                      ,CASE
                                         WHEN PROCESSING_LOG.ProcessingStatus = 2100 THEN 'Terminated'
                                         WHEN PROCESSING_LOG.ProcessingStatus = 550 THEN 'Suspended'
                                       END AS ProcessLogStatus
                                      ,CASE
                                         WHEN
                                           CLIENT_LEAD.DatePackReceived >= CLIENT_LEAD.DateAgreed
                                           THEN 'Yes'
                                         ELSE
                                           'No'
                                       END AS PackReturned
                                      ,PROCESSING_LOG.DateUpdated AS 'ProcessDate'
                                      ,CORRESPONDENCE.DateCreated AS 'CorrespondenceCreated'
                                      ,CORRESPONDENCE.CorrespondenceType
                                      ,CORRESPONDENCE.title AS 'CorresspondenceTitle'
                                      ,CORRESPONDENCE.Description AS 'CorrespondenceDescription'
                                      ,(
                                         SELECT TOP 1
                                           COUNT(ClientID)
                                         FROM
                                           " . $officeData['database'] . ".dbo.Client_Correspondence
                                         WHERE
                                           ClientID = PROCESSING_LOG.ClientID       
                                         AND
                                           [Type] = 27
                                       ) AS TotalCallsToClient
                                      ,CLIENT_LEAD.DateAgreed
                                      ,PAYMENT_DATA.InitialAgreedAmount / 100 AS AgreedDI
                                      ,DATEDIFF(month, CLIENT_LEAD.DateAgreed, PROCESSING_LOG.DateUpdated) -
                                         CASE
                                           WHEN
                                             DATEPART(day, CLIENT_LEAD.DateAgreed) > DATEPART(DAY, PROCESSING_LOG.DateUpdated)
                                           THEN
                                             1
                                           ELSE
                                             0
                                         END AS MonthsOnPlan
                                      ,CASE
                                         WHEN
                                           exists
                                           (
                                             SELECT Top (1)
                                               FirstPaymentDate
                                             FROM
                                               Dialler.dbo.client_dates
                                             WHERE
                                               ClientID = PROCESSING_LOG.ClientID
                                           )
                                         THEN
                                           'Yes'
                                         ELSE
                                           'No'
                                         END AS FirstPaymentMade
                                      ,(
                                         SELECT TOP (1)
                                           [Date]
                                         FROM
                                           " . $officeData['database'] . ".dbo.Payment_Receipt
                                         WHERE
                                           ClientID = PROCESSING_LOG.ClientID
                                         ORDER BY
                                           ID DESC
                                       ) AS LastPaymentMade
                                    FROM
                                      " . $officeData['database'] . ".dbo.log_ProcessingStatusUpdates AS PROCESSING_LOG
                                    LEFT JOIN
                                      " . $officeData['database'] . ".dbo.Users AS USERS ON PROCESSING_LOG.UserID = USERS.ID
                                    LEFT JOIN
                                      " . $officeData['database'] . ".dbo.Client_Contact AS CLIENT_CONTACT ON PROCESSING_LOG.ClientID = CLIENT_CONTACT.ID
                                    LEFT JOIN
                                      " . $officeData['database'] . ".dbo.Type_Client_Status AS CLIENT_STATUS ON CLIENT_CONTACT.Status = CLIENT_STATUS.ID
                                    LEFT JOIN
                                      " . $officeData['database'] . ".dbo.Client_LeadData AS CLIENT_LEAD ON PROCESSING_LOG.ClientID = CLIENT_LEAD.Client_ID
                                    LEFT JOIN
                                      " . $officeData['database'] . ".dbo.Client_PaymentData AS PAYMENT_DATA ON PROCESSING_LOG.ClientID = PAYMENT_DATA.ClientID
                                    LEFT JOIN
                                      " . $officeData['database'] . ".dbo.Client_Alert AS ALERT ON PROCESSING_LOG.ClientID = ALERT.ClientID
                                    LEFT JOIN
                                      (
                                        SELECT
                                           ClientID
                                          ,CreatedBy
                                          ,TC.Description AS CorrespondenceType
                                          ,title
                                          ,CC.[Description]
                                          ,DateCreated
                                          ,ROW_NUMBER() OVER (PARTITION BY ClientID ORDER BY CASE WHEN [Type] = 55 THEN 1 ELSE 0 END DESC, DateCreated DESC) AS RowN
                                        FROM
                                          " . $officeData['database'] . ".dbo.Client_Correspondence AS CC
                                        LEFT JOIN
                                          " . $officeData['database'] . ".dbo.Type_Correspondence  AS TC ON CC.[Type] = TC.ID
                                      ) AS CORRESPONDENCE
                                      ON PROCESSING_LOG.ClientID = CORRESPONDENCE.ClientID AND PROCESSING_LOG.UserID = CORRESPONDENCE.CreatedBy  
                                    LEFT JOIN
                                    (
                                      SELECT
                                    	 ClientID
                                    	,DateUpdated AS LogUpdate
                                    	,ProcessingStatus AS [Status]
                                    	,ROW_NUMBER() OVER (PARTITION BY ClientID ORDER BY DateUpdated DESC) AS LogRow
                                      FROM
                                    	" . $officeData['database'] . ".dbo.log_ProcessingStatusUpdates
                                    ) AS LogRows ON LogRows.ClientID = PROCESSING_LOG.ClientID AND LogRows.LogUpdate = PROCESSING_LOG.DateUpdated
                                    WHERE
                                      DateUpdated >= DATEADD(day, DATEDIFF(day, 0, GetDate()), 0)
                                    AND
                                      PROCESSING_LOG.ProcessingStatus IN (2100, 550)
                                    AND
                                      LogRow = 1
                                    AND
                                      CORRESPONDENCE.RowN = 1
                                    AND
                                      ALERT.[Message] NOT LIKE '%PPI ONLY%'
                                    ORDER BY
                                       PROCESSING_LOG.ProcessingStatus
                                      ,FirstPaymentMade
                                      ,CORRESPONDENCE.DateCreated ASC
                            ", \DB::SELECT)->execute($officeData['connection'])->as_array();
                            
        if(count($officeResults) > 0)
        {
          $results = array();
          
          // -- Process the results
          // ----------------------
          $results['Office'] = $office;
          $results['status'] = Adam::processClientStatus($officeResults);
          
          unset($officeResults);
          
          // -- Send email out
          // -----------------
          $email = \Email::forge();
          $email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
    
          $email->to($officeData['to']);
              
          $email->subject($office . ': Terminated and Suspended Clients' . ' ' . date("d-m-Y"));
      
          $email->html_body(\View::forge('emails/clientstatus/terminated-suspended', array('clients' => $results,)
            				       ));
                    
          $email->send();
        
          unset($results);
          unset($email);
        }
      }
      
      // -- Log the task as completed
      // ----------------------------
      \Log::info("Task :: terminated_suspended_clients_report | Status :: Completed");
    }
    
    /**
     * Daily Dialler Report for Gary
     * 
     * @author David Stansfield
     */
    public function daily_dialler_report()
    {
      $results = array();
      $results = \DB::query("SELECT
                               LOG.user
                              ,USER.full_name AS agent_name
                              ,COUNT(LOG.uniqueid) AS dials
                              ,SUM(IF(STATUS.human_answered = 'Y', 1, 0)) AS connections
                              ,SUM(IF(STATUS.human_answered = 'N', 1, 0)) AS none_connections
                              ,SUM(IF(length_in_sec > 30 AND STATUS.human_answered = 'Y', 1, 0)) AS pitched_to
                              ,SUM(IF(LOG.comments = 'AUTO', 1, 0)) AS auto_calls
                              ,SUM(IF(LOG.comments = 'MANUAL', 1, 0)) AS manual_calls
                              ,SUM(IF(status = 'SALE', 1, 0)) AS sales
                             FROM
                               vicidial_log AS LOG
                             LEFT JOIN
                               vicidial_users AS USER USING(user)
                             INNER JOIN
                               vicidial_statuses AS STATUS USING(status)
                             WHERE
                               DATE(LOG.call_date) = CURDATE()
                             AND
                               USER.user_group LIKE '%GAB%'
                             GROUP BY
                               LOG.user
                            ", \DB::SELECT)->execute('gabdialler')->as_array();
                            
      // -- Send email out
      // -----------------
      if(count($results) > 0)
      {
          $email = \Email::forge();
          $email->from('noreply@expertmoneysolutions.co.uk', 'Dialler: MMS');

          $email->to(array('d.stansfield@clix.co.uk', 's.skinner@clix.co.uk', 'a.brooke@gregsonandbrooke.co.uk'));
          #gary@gabfs.co.uk
          #$email->to(array('d.stansfield@clix.co.uk'));

          $email->subject('Dialler Call Stats for' . ' ' . date("d-m-Y"));

          $email->html_body(\View::forge('emails/dialler/agentcallstats', array('results' => $results,)
          ));

          $email->send();
          unset($email);
      }

      unset($results);
    }
    
    /**
     * Filters the client statues into arrays
     * 
     * @author David Stansfield
     */
    public function processClientStatus($officeData = array())
    {
      if(!is_array($officeData))
        return;
        
      $newData = array();
        
      foreach($officeData as $key => $data)
      {
        switch($data['ProcessingStatus'])
        {
          case '2100' :
            // -- Terminated Clients
            // ---------------------
            $newData['Terminated'][] = $officeData[$key];
          break;
          case '550' :
            // -- Suspended Clients
            // --------------------
            $newData['Suspended'][] = $officeData[$key];
          break;
        }
      }
      
      return $newData;
    }
		
		
		
		
		
		public function checkLists()
		{
			
			$gabLists      = \DB::select('ID','Reference')->from('Leadpool_MMS.dbo.Type_Lead_Source')->order_by('ID')->execute('debtsolv');
			$gabListsDM    = \DB::select('ID')->from('Debtsolv_MMS.dbo.Type_Lead_Source')->order_by('ID')->execute('debtsolv');
			$gabListsBat   = \DB::select('ID')->from('Leadpool_MMS.dbo.LeadBatch')->order_by('ID')->execute('debtsolv');
			
			
			//$resolveLists  = \DB::select('ID','Reference')->from('BS_Leadpool_MMS.dbo.Type_Lead_Source')->order_by('ID')->execute('debtsolv');
			//$resolveListsDM    = \DB::select('ID')->from('BS_Debtsolv_DM.dbo.Type_Lead_Source')->order_by('ID')->execute('debtsolv');
			//$resolveListsBat   = \DB::select('ID')->from('BS_Leadpool_MMS.dbo.LeadBatch')->order_by('ID')->execute('debtsolv');
			
			$gabAll = $resolveAll = array();
			foreach ($gabLists as $one)
			{
				$gabAll[] = $one['Reference'];
			}
//			foreach ($resolveLists as $one)
//			{
//				$resolveAll[] = $one['Reference'];
//			}
			
			$diallerLists  = \DB::select('list_id')->from('vicidial_lists')->execute('dialler');
			
			$gabMissing = $resolveMissing = array();
			foreach ($diallerLists as $oneList)
			{
				if (!in_array($oneList['list_id'], $gabAll))
				{
					$gabMissing[] = $oneList['list_id'];
				}
				if (!in_array($oneList['list_id'], $resolveAll))
				{
					$resolveMissing[] = $oneList['list_id'];
				}
			}
			
			$lastGab    = $gabLists[count($gabLists)-1]['ID'];
			$lastGabBat = $gabListsBat[count($gabListsBat)-1]['ID'];
			$lastGabDM  = $gabListsDM[count($gabListsDM)-1]['ID'];

			foreach ($gabMissing as $missing)
			{
				$lastGab++;
				$lastGabBat++;
				$lastGabDM++;
				
				$listDetails  = \DB::select('list_description')->from('vicidial_lists')->where('list_id', $missing)->execute('dialler');
				
				list($leadSourceID, $rows_affected) = \DB::insert('Leadpool_MMS.dbo.Type_Lead_Source')->set(array(
				 	'ID'             => $lastGab,
					'Description'    => $listDetails[0]['list_description'],
					'Reference'      => $missing,
					'Status'         => 1,
					'ScoreValue'     => 0,
					'CategoryID'     => 0,
					'IntroducerID'   => 42,
				))->execute('debtsolv');
				
				
				list($leadSourceID, $rows_affected) = \DB::insert('Debtsolv_MMS.dbo.Type_Lead_Source')->set(array(
				 	'ID'             => $lastGabDM,
					'Alias'          => $listDetails[0]['list_description'],
					'Reference'      => $missing,
					'Status'         => 1,
					'Description'    => $listDetails[0]['list_description'],
					'[Group]'          => 0,
					'IntroducerID'   => 42,
					'CostPerLead'    => 0,
					'BrandID'        => 0,
				))->execute('debtsolv');
				
				
				list($dialler_lead_id, $rows_affected) = \DB::insert('Leadpool_MMS.dbo.LeadBatch')->set(array(
					'Description'    => $listDetails[0]['list_description'],
					'Filename'       => '',
					'LeadSourceID'   => $lastGab,
					'ImportMethodID' => 0,
					'ImportNotes'    => '',
					'ActionTakenID'  => 0,
					'ScoreValue'     => 0,
				))->execute('debtsolv');
				
				
			}
			
			
/*			
			
			$lastRes    = $resolveLists[count($resolveLists)-1]['ID'];
			$lastResBat = $resolveListsBat[count($resolveListsBat)-1]['ID'];
			$lastResDM  = $resolveListsDM[count($resolveListsDM)-1]['ID'];

			foreach ($resolveMissing as $missing)
			{
				$lastRes++;
				$lastResBat++;
				$lastResDM++;
				
				$listDetails  = \DB::select('list_description')->from('vicidial_lists')->where('list_id', $missing)->execute('dialler');
				
				list($leadSourceID, $rows_affected) = \DB::insert('BS_Leadpool_MMS.dbo.Type_Lead_Source')->set(array(
				 	'ID'             => $lastRes,
					'Description'    => $listDetails[0]['list_description'],
					'Reference'      => $missing,
					'Status'         => 1,
					'ScoreValue'     => 0,
					'CategoryID'     => 0,
					'IntroducerID'   => 2003,
				))->execute('debtsolv');
				
				
				list($leadSourceID, $rows_affected) = \DB::insert('BS_Debtsolv_DM.dbo.Type_Lead_Source')->set(array(
				 	'ID'             => $lastResDM,
					'Alias'          => $listDetails[0]['list_description'],
					'Reference'      => $missing,
					'Status'         => 1,
					'Description'    => $listDetails[0]['list_description'],
					'[Group]'          => 0,
					'IntroducerID'   => 2003,
					'CostPerLead'    => 0,
					'BrandID'        => 0,
				))->execute('debtsolv');
				
				
				list($dialler_lead_id, $rows_affected) = \DB::insert('BS_Leadpool_MMS.dbo.LeadBatch')->set(array(
					'Description'    => $listDetails[0]['list_description'],
					'Filename'       => '',
					'LeadSourceID'   => $lastRes,
					'ImportMethodID' => 0,
					'ImportNotes'    => '',
					'ActionTakenID'  => 0,
					'ScoreValue'     => 0,
				))->execute('debtsolv');
				
				
			}
			
*/			
			
			/*			
			
			$email = \Email::forge();
			
			$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
      
			$email->to(array("s.skinner@clix.co.uk","j.bedward@clix.co.uk","d.stansfield@clix.co.uk"));
                
			$email->subject("Lists Missing from GAB Debtsolv");
        
			$email->html_body("The following lists are missing from the GAB Debtsolv<br /><br />".implode("<br />", $gabMissing));
                      
			$email->send();
			*/

			
			/*
			
			
			
			$email = \Email::forge();
			
			$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
      
			$email->to("it@expertmoneysolutions.co.uk");
                
			$email->subject("Lists Missing from Resolve Debtsolv");
        
			$email->html_body("The following lists are missing from the Resolve Debtsolv<br /><br />".implode("<br />", $resolveMissing));
                      
			$email->send();
			*/
	
	
		}
    
    /**
     * Daily and monthy report
     * 
     * @author David Stansfield
     */
    public function sahilPaymentReport()
    {
      // --------------------
      // -- Pack-In Report --
      // --------------------
      $introducerID = 53;
      $packOutValue = 100;
      $date = date("d-m-Y");
      $emailTo = "sparke-reports@gabfs.co.uk";
      
      $results = array();
      $results = \DB::query("SELECT
                                LEAD_DATA.Client_ID
                               ,INTRODUCER.Name
                               ,CONVERT(VARCHAR, LEAD_DATA.DatePackReceived, 103) AS PackReceived
                               ," . $packOutValue . " AS Payment
                             FROM
                               Debtsolv_MMS.dbo.Client_LeadData AS LEAD_DATA
                             INNER JOIN
                               Debtsolv_MMS.dbo.Type_Lead_Source AS LEAD_SOURCE ON LEAD_DATA.SourceID = LEAD_SOURCE.ID
                             INNER JOIN
                               Debtsolv_MMS.dbo.Lead_Introducers AS INTRODUCER ON LEAD_SOURCE.IntroducerID = INTRODUCER.ID
                             WHERE
                               LEAD_SOURCE.IntroducerID = " . (int)$introducerID . "
                             AND
                               LEAD_DATA.DatePackReceived >= DATEADD(day, DATEDIFF(day, 0, GetDate()), 0);
                            ", \DB::SELECT)->execute('debtsolv')->as_array();
                            
      $email = \Email::forge();
      
      $email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
  
      $email->to($emailTo);
            
      $email->subject('Sahil Pack-In Payment Report' . ' - ' . $date);
    
      $email->html_body(\View::forge('emails/sparke/pack-in-report', array('clients' => $results,
                                                                           'date' => $date,
                                                                                      )
          				       ));
                  
      $email->send();
      
      unset($results);
      
      // -------------------------------
      // -- Monthly SO Payment Report --
      // -------------------------------
      
      // -- Check to see if today is the first day of the month
      // ------------------------------------------------------
      if(date("d-m-Y") != date("01-m-Y"))
        return;
        
      $results = array();
      $results = \DB::query("WITH TEMP_PAYMENT_TABLE AS
                              (
                              SELECT
                                 DI_PAYMENTS_TABLE.ID
                                ,ClientID
                                ,[Date]
                                ,DIPayments
                                ,DIPaymentNumber
                                ,DIPayment
                              FROM
                              (
                              SELECT
                                 PAYMENT_IN.ID
                                ,PAYMENT_IN.ClientID
                                ,PAYMENT_IN.[Date]
                                ,Amount
                                ,ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment),0), 0) AS DIPayments
                                ,CASE
                                   WHEN ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment), 0), 0) >= 1 AND RANK() OVER (PARTITION BY PAYMENT_IN.ClientID ORDER BY PAYMENT_IN.ClientID, PAYMENT_IN.ID) = 1 THEN 1    
                                   WHEN ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment), 0), 0) >= 2 AND RANK() OVER (PARTITION BY PAYMENT_IN.ClientID ORDER BY PAYMENT_IN.ClientID, PAYMENT_IN.ID) = 2 THEN 2		     
                                   WHEN ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment), 0), 0) >= 3 AND RANK() OVER (PARTITION BY PAYMENT_IN.ClientID ORDER BY PAYMENT_IN.ClientID, PAYMENT_IN.ID) = 3 THEN 3
                                   WHEN ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment), 0), 0) = 1 THEN 1
                                   WHEN ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment), 0), 0) = 2 THEN 2
                                   WHEN ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment), 0), 0) = 3 THEN 3
                                 END AS DIPaymentNumber     
                                ,ROW_NUMBER() OVER (PARTITION BY PAYMENT_IN.ClientID, FLOOR(ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment),0), 0)) ORDER BY PAYMENT_IN.ID) AS Row
                                ,RANK() OVER (PARTITION BY PAYMENT_IN.ClientID ORDER BY PAYMENT_IN.ClientID, PAYMENT_IN.ID) AS RowN
                                ,PAYMENT_DATA.DIPayment
                              FROM
                                Debtsolv_MMS.dbo.Payment_In AS PAYMENT_IN
                              INNER JOIN
                                (
                                  SELECT
                                     ClientID
                                    ,CASE
                                       WHEN InitialAgreedAmount > NormalExpectedPayment THEN NormalExpectedPayment ELSE InitialAgreedAmount
                                     END AS DIPayment
                                  FROM
                                    Debtsolv_MMS.dbo.Client_PaymentData
                                ) AS PAYMENT_DATA ON PAYMENT_IN.ClientID = PAYMENT_DATA.ClientID
                              INNER JOIN
                                (
                                  SELECT
                                     ID
                                    ,ClientID
                                    ,[Date]
                                    ,FLOOR(SUM(Amount)) AS RunningTotal
                                  FROM
                                    Debtsolv_MMS.dbo.Payment_In AS P1
                                  GROUP BY
                                     ClientID
                                    ,[Date]
                                    ,ID
                                ) AS DTABLE_PAYMENT_IN ON PAYMENT_IN.ClientID = DTABLE_PAYMENT_IN.ClientID
                              WHERE
                                DTABLE_PAYMENT_IN.[Date] <= PAYMENT_IN.[Date]
                              GROUP BY
                                 PAYMENT_IN.ID
                                ,PAYMENT_IN.ClientID
                                ,PAYMENT_IN.[Date]
                                ,Amount
                                ,PAYMENT_DATA.DIPayment
                              HAVING
                                ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment),0), 0) <= 5
                              AND
                                ISNULL((SUM(RunningTotal)) / NULLIF((PAYMENT_DATA.DIPayment),0), 0) > 0
                              ) AS DI_PAYMENTS_TABLE
                              INNER JOIN
                                Debtsolv_MMS.dbo.Client_LeadData AS LEAD_DATA ON DI_Payments_Table.ClientID = LEAD_DATA.Client_ID
                              INNER JOIN
                                Debtsolv_MMS.dbo.Type_Lead_Source AS LEAD_SOURCE ON LEAD_DATA.SourceID = LEAD_SOURCE.ID
                              INNER JOIN
                                Debtsolv_MMS.dbo.Lead_Introducers AS INTRODUCERS ON LEAD_SOURCE.IntroducerID = INTRODUCERS.ID
                              WHERE
                                INTRODUCERS.ID = " . (int)$introducerID . "
                              AND
                                DI_PAYMENTS_TABLE.Row = 1
                              AND
                                DI_PAYMENTS_TABLE.DIPayments > 0
                              AND
                                DI_PAYMENTS_TABLE.DIPaymentNumber IS NOT NULL
                              )
                              
                              /** ***************************************** **/
                              /** Pull Out the Information we need by Month **/
                              /** ***************************************** **/
                              SELECT
                                 TEMP_TABLE.ClientID
                                ,TABLE1.[Date] AS FirstPaymentDate
                                ,TABLE2.[Date] AS SecondPaymentDate
                              --  ,TABLE3.[Date] AS ThirdPaymentDate
                                ,CONVERT(VARCHAR, CONVERT(MONEY, TEMP_TABLE.DIPayment / 100), 1) AS UsedDI
                                ,CONVERT(VARCHAR, CONVERT(MONEY, PAYMENT_DATA.InitialAgreedAmount / 100), 1) AS 'AgreedDI'
                                ,CONVERT(VARCHAR, CONVERT(MONEY, PAYMENT_DATA.NormalExpectedPayment / 100), 1) AS 'NormalExpectedDI'
                                ,PAYMENT_METHOD.[Description] AS PaymentMethod
                                ,CONVERT(VARCHAR, CONVERT(MONEY, ((TEMP_TABLE.DIPayment * 2) - 10000) / 100), 1) AS PaymentToMake
                              FROM
                                TEMP_PAYMENT_TABLE AS TEMP_TABLE
                              LEFT JOIN
                                TEMP_PAYMENT_TABLE AS TABLE1 ON TEMP_TABLE.ClientID = TABLE1.ClientID AND TABLE1.DIPaymentNumber = 1
                              LEFT JOIN
                                TEMP_PAYMENT_TABLE AS TABLE2 ON TEMP_TABLE.ClientID = TABLE2.ClientID AND TABLE2.DIPaymentNumber = 2
                              --LEFT JOIN
                              --  TEMP_PAYMENT_TABLE AS TABLE3 ON TEMP_TABLE.ClientID = TABLE3.ClientID AND TABLE3.DIPaymentNumber = 3
                              INNER JOIN
                                Debtsolv_MMS.dbo.Client_PaymentData AS PAYMENT_DATA ON TEMP_TABLE.ClientID = PAYMENT_DATA.ClientID
                              INNER JOIN
                                Debtsolv_MMS.dbo.Type_Payment_Method AS PAYMENT_METHOD ON PAYMENT_DATA.PaymentMethod = PAYMENT_METHOD.ID
                              WHERE
                              (
                                  YEAR(TABLE1.[Date]) = YEAR(GETDATE())
                                AND
                                  MONTH(TABLE1.[Date]) = MONTH(GETDATE()) - 1
                                AND
                                  PAYMENT_DATA.PaymentMethod = 3
                                OR
                                  YEAR(TABLE2.[Date]) = YEAR(GETDATE())
                                AND
                                  MONTH(TABLE2.[Date]) = MONTH(GETDATE()) - 1
                                AND
                                  PAYMENT_DATA.PaymentMethod = 11
                              )
                              GROUP BY
                                 TEMP_TABLE.ClientID
                                ,TABLE1.[Date]
                                ,TABLE2.[Date]
                              --  ,TABLE3.[Date]
                                ,TEMP_TABLE.DIPayment
                                ,PAYMENT_DATA.InitialAgreedAmount
                                ,PAYMENT_DATA.NormalExpectedPayment
                                ,PAYMENT_DATA.PaymentMethod
                                ,PAYMENT_METHOD.[Description]
                              ORDER BY
                                 PAYMENT_DATA.PaymentMethod
                                ,PaymentToMake ASC
                            ", \DB::SELECT)->execute('debtsolv')->as_array();
                            
      // -- Get Totals
      // -------------
      $totalDI = 0;
      $totalToPayOut = 0;
      
      if(count($results) > 0)
      {
        foreach($results as $clients)
        {
          if($clients['UsedDI'] > 0)
            $totalDI += $clients['UsedDI'];
            
          if($clients['PaymentToMake'] > 0)
            $totalToPayOut += $clients['PaymentToMake'];
        }
      }
                            
      $month = date("F", strtotime("-1 Month", time()));
                            
      $email = \Email::forge();
      
      $email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
  
      $email->to($emailTo);
            
      $email->subject('Sahil Monthly Payment Report' . ' - ' . $month);
    
      $email->html_body(\View::forge('emails/sparke/monthly-payment-report', array('clients' => $results,
                                                                                   'month' => $month,
                                                                                   'totalDI' => $totalDI,
                                                                                   'totalToPayOut' => $totalToPayOut,
                                                                                  )
          				       ));
                  
      $email->send();
      
      unset($results);
    }
		
	}
