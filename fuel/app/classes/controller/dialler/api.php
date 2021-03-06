<?php

	class Controller_Dialler_Api extends Controller_Rest 
	{
		
		
		
		
		
	public function get_get_telesales_report_period($center=null)
	{
	    
	    if ($center == "ALL")
    	{
        	$center = null;
    	}
	    
	    $startDate = null;
    	$endDate = null;
    	
    	$month = $this->param('month');
    	if ($month == "month")
    	{
        	$startDate = date("Y-m-01");
        	$endDate = date("Y-m-t");
        	
    	}
    	else
    	{
            $startDate = date("Y-m-d");
        	$endDate = date("Y-m-d");
    	}

	
    	$reportArray = Controller_Reports::generate_telesales_report($center, $startDate, $endDate);
    	return $this->response(array(
    	    'titles'     => array(
    	        'Name',
    	        'Referrals',
    	        'Pack Outs',
    	        'Conversion Rate',
    	        'Points',
    	        'Commission',
    	    ),
    	    'report'     => $reportArray['report'],
    	    'centerVals' => $reportArray['centerVals'],
    	));
	}
		
		
		
		
		
		public function get_live_agents($campaign)
		{
			$live_agents = Goautodial\Live::live_agents($campaign);
			
			$this->response($live_agents);
			
		}
		
		public function get_league_table()
		{
			
			$start_date = '2012-09-01';
			$end_date = '2012-09-31';
			
			
			// Get a list of active dialler agents
			$active_agents = Goautodial\Model_Vicidial_Users::find()->where('active', 'Y')->where('user_group', 'AGENTS')->get();
			
			$dialler_agents = array();
			foreach ($active_agents AS $agent)
			{
			
				$all_calls = Goautodial\Model_Vicidial_Log::find()->where('user', $agent->user)->where('call_date', '>', date('Y-m-01').' 00:00:00')->get();
				
				$called_days = array();
				foreach ($all_calls AS $call)
				{
					$date = date('d-m-Y', strtotime($call->call_date));
					
					if (isset($called_days[$date]))
					{
						$called_days[$date]++;
					}
					else
					{
						$called_days[$date] = 1;
					}
				}
				
				print_r($called_days);
				
			
				$dialler_agents[$agent->user] = array(
					'name' => $agent->full_name,
					'referrals' => Goautodial\Model_Vicidial_Log::find()->where('user', $agent->user)->where('status', 'SALE')->where('call_date', '>', date('Y-m-01').' 00:00:00')->count(),
					'pack_outs' => 5,
					'conversion' => 50,
					'productivity' => 1.7,
				);
			}
			
			
			
			
			
			
			$this->response($dialler_agents);
			
		}
		
		
		public function get_wallboard_static($center="GAB")
		{
			
			$campaigns = array(
				'GAB' => array(
					'GAB-1','GAB-LIVE'
				),
				'GBS' => array(
					'DIGOS-1',
				),
				'RESOLVE' => array(
					'BURTON1'
				),
				'INTERNAL' => array(
					'INTERNAL', 'SENIORS', 'GBS-1', 'GAB-3','GAB-1',
				),
			);
			
			$connection = 'gabdialler';
			
			$current_results = GAB\Debtsolv::get_referral_count($center);
		
			$this->response(array(
				'referrals' => $current_results['referrals'],
				'countdown' => 34-$current_results['pack_outs'],
				'conversion' => (Goautodial\Live::answered_calls(array('GAB-1','GAB-LIVE'))==0) ? 0 : number_format((($current_results['referrals'] / Goautodial\Live::answered_calls(array('GAB-1','GAB-LIVE')))*100),2),
				'pack_out_today' => $current_results['pack_outs'],
				'pack_out_percentage' => ($current_results['referrals']==0) ? 0 : number_format((($current_results['pack_outs']/$current_results['referrals'])*100),2),
				'pack_out_value' => number_format($current_results['pack_outs_value'],2),
				'pack_out_average_di' => ($current_results['pack_outs']==0) ? 0 : number_format($current_results['pack_outs_value']/$current_results['pack_outs'],2),
	
				'seniors_available' => count(Goautodial\Live::closers('SENIORS', $connection)),
				'seniors_queue' => count(Goautodial\Live::inbound_queue(null, $connection)),
				
				'gab_live' => array(
					'active' => ( Goautodial\Live::dialable_leads('GAB-LIVE') > 0 ) ? 1 : 0,
					'agents' => 1,
				),
			));
			 
		}
		
		
		public function get_mobile_wallboard()
		{	
		
		    $hq_this_month = GAB\Debtsolv::get_referral_count('GAB', date("01-m-Y"), date("t-m-Y"), 300);
			$hq_this_week = GAB\Debtsolv::get_referral_count('GAB', date("d-m-Y", strtotime("monday this week")), date("d-m-Y"), 300);

		    $pcc_this_month = GAB\Debtsolv::get_referral_count('GBS', date("01-m-Y"), date("t-m-Y"), 300);
			$pcc_this_week = GAB\Debtsolv::get_referral_count('GBS', date("d-m-Y", strtotime("monday this week")), date("d-m-Y"), 300);
		
			$hq_today = GAB\Debtsolv::get_referral_count('GAB');
			$pcc_today = GAB\Debtsolv::get_referral_count('GBS');
			
			$finishTime = array(
			    0 => null,
			    1 => mktime(19,30),
			    2 => mktime(19,30),
			    3 => mktime(19,30),
			    4 => mktime(19,30),
			    5 => mktime(18,00),
			    6 => mktime(16,00),
			);
			
			$startTime = array(
			    0 => null,
			    1 => mktime(10,00),
			    2 => mktime(10,00),
			    3 => mktime(10,00),
			    4 => mktime(10,00),
			    5 => mktime(10,00),
			    6 => mktime(10,00),
			 );
			 
			 // Minutes in today
			 $minutes = (($finishTime[(int)date("w")] - $startTime[(int)date("w")])/60);
			 $minutesSinceStart = ((strtotime("NOW") - $startTime[(int)date("w")])/60);
			 
			 $multiplier = ($minutesSinceStart <= 0) ? 0 : $minutes / $minutesSinceStart;
			 
			 $multiplier = ($multiplier < 1) ? 1 : $multiplier;
			 
			
			$gbsCountQuery = "SELECT COUNT(DISTINCT VDL.user) AS total FROM vicidial_user_log AS VDL LEFT JOIN vicidial_users AS VDU ON VDL.user=VDU.user WHERE VDU.user_group IN ('PREMIER-GBS', 'STANDARD-GBS', 'GBSAGENT', 'GBSSPECIAL') AND DATE(VDL.event_date)=DATE(NOW());";
			
			$gabCountQuery = "SELECT COUNT(DISTINCT VDL.user) AS total FROM vicidial_user_log AS VDL LEFT JOIN vicidial_users AS VDU ON VDL.user=VDU.user WHERE VDU.user_group IN ('PREMIER-GAB', 'STANDARD-GAB', 'GABAGENT') AND DATE(VDL.event_date)=DATE(NOW());";
			

			$gabResults = DB::query($gabCountQuery)->cached(60)->execute('dialler');
			$gbsResults = DB::query($gbsCountQuery)->cached(60)->execute('dialler');

			
			$perPerson = array(
			    'GAB' => (int)$gabResults[0]['total'],
			    'PCC' => (int)$gbsResults[0]['total'],
			);
			
			$this->response(array(
				'HQ' => array(
					'referrals' => $hq_today['referrals'],
					'pack_out' => $hq_today['pack_outs'],
					'pack_out_percentage' => ($hq_today['referrals']==0) ? 0 : number_format((($hq_today['pack_outs']/$hq_today['referrals'])*100),2),
					
					'di' => ($hq_today['pack_outs']==0) ? 0 : number_format($hq_today['pack_outs_value'] / $hq_today['pack_outs'],2),
					'pack_out_percentage' => ($hq_today['referrals']==0) ? 0 : number_format((($hq_today['pack_outs']/$hq_today['referrals'])*100),2),
					'pack_out_value' => number_format($hq_today['pack_outs_value'],2),

                    'agents' => $perPerson['GAB'],
				),
				'PCC' => array(
					'referrals' => $pcc_today['referrals'],
					'pack_out' => $pcc_today['pack_outs'],
					'pack_out_percentage' => ($pcc_today['referrals']==0) ? 0 : number_format((($pcc_today['pack_outs']/$pcc_today['referrals'])*100),2),
					
					'di' => ($pcc_today['pack_outs']==0) ? 0 : number_format($pcc_today['pack_outs_value'] / $pcc_today['pack_outs'],2),
					'pack_out_percentage' => ($pcc_today['referrals']==0) ? 0 : number_format((($pcc_today['pack_outs']/$pcc_today['referrals'])*100),2),
					'pack_out_value' => number_format($pcc_today['pack_outs_value'],2),

                    'agents' => $perPerson['PCC'],
				),
				'COMBINED' => array(
					'referrals' => ($hq_today['referrals'] + $burton_today['referrals'] + $pcc_today['referrals']),
					'pack_out' => ($hq_today['pack_outs'] + $burton_today['pack_outs'] + $pcc_today['pack_outs']),
					'pack_out_percentage' => (($hq_today['referrals'] + $burton_today['referrals'] + $pcc_today['referrals']) < 1) ? 0 : number_format(($hq_today['pack_outs'] + $burton_today['pack_outs'] + $pcc_today['pack_outs']) / ($hq_today['referrals'] + $burton_today['referrals'] + $pcc_today['referrals']),2),


                    'agents' => $perPerson['COMBINED'],
                ),
				
				'HQP' => array(
					'referrals' => number_format(($hq_today['referrals'] / $perPerson['GAB']),2),
					'pack_out' => number_format(($hq_today['pack_outs'] / $perPerson['GAB']),2),
					'pack_out_percentage' => ($hq_today['referrals']==0) ? 0 : number_format((($hq_today['pack_outs']/$hq_today['referrals'])*100),2),
				),
				'PCCP' => array(
					'referrals' => number_format(($pcc_today['referrals'] / $perPerson['PCC']),2),
					'pack_out' => number_format(($pcc_today['pack_outs'] / $perPerson['PCC']),2),
					'pack_out_percentage' => ($pcc_today['referrals']==0) ? 0 : number_format((($pcc_today['pack_outs']/$pcc_today['referrals'])*100),2),
				),	
				'HQPP' => array(
					'referrals' => number_format(($hq_today['referrals'] / $perPerson['GAB'])*$multiplier,2),
					'pack_out' => number_format(($hq_today['pack_outs'] / $perPerson['GAB'])*$multiplier,2),
					'pack_out_percentage' => ($hq_today['referrals']==0) ? 0 : number_format((($hq_today['pack_outs']/$hq_today['referrals'])*100),2),
				),
				'PCCPP' => array(
					'referrals' => number_format(($pcc_today['referrals'] / $perPerson['PCC'])*$multiplier,2),
					'pack_out' => number_format(($pcc_today['pack_outs'] / $perPerson['PCC'])*$multiplier,2),
					'pack_out_percentage' => ($pcc_today['referrals']==0) ? 0 : number_format((($pcc_today['pack_outs']/$pcc_today['referrals'])*100),2),
				),	
				'COMBINEDPP' => array(
					'referrals' => number_format( (($hq_today['referrals'] + $burton_today['referrals'] + $pcc_today['referrals']) / $perPerson['COMBINED'])*$multiplier,2),
					'pack_out' => number_format((($hq_today['pack_outs'] + $burton_today['pack_outs'] + $pcc_today['pack_outs']) / $perPerson['COMBINED'])*$multiplier,2),
					'pack_out_percentage' => (($hq_today['referrals'] + $burton_today['referrals'] + $pcc_today['referrals']) < 1) ? 0 : number_format((($hq_today['pack_outs'] + $burton_today['pack_outs'] + $pcc_today['pack_outs']) / ($hq_today['referrals'] + $burton_today['referrals'] + $pcc_today['referrals'])) / $perPerson['COMBINED'],2),
				),
				
				
				'HQweek' => array(
					'referrals' => $hq_this_week['referrals'],
					'pack_out' => $hq_this_week['pack_outs'],
					'pack_out_percentage' => ($hq_this_week['referrals']==0) ? 0 : number_format((($hq_this_week['pack_outs']/$hq_this_week['referrals'])*100),2),
					
					'di' => ($hq_this_week['pack_outs']==0) ? 0 : number_format($hq_this_week['pack_outs_value'] / $hq_this_week['pack_outs'],2),
					'pack_out_percentage' => ($hq_this_week['referrals']==0) ? 0 : number_format((($hq_this_week['pack_outs']/$hq_this_week['referrals'])*100),2),
					'pack_out_value' => number_format($hq_this_week['pack_outs_value'],2),
				),
				'HQmonth' => array(
					'referrals' => $hq_this_month['referrals'],
					'pack_out' => $hq_this_month['pack_outs'],
					'pack_out_percentage' => ($hq_this_month['referrals']==0) ? 0 : number_format((($hq_this_month['pack_outs']/$hq_this_month['referrals'])*100),2),
					
					'di' => ($hq_this_month['pack_outs']==0) ? 0 : number_format($hq_this_month['pack_outs_value'] / $hq_this_month['pack_outs'],2),
					'pack_out_percentage' => ($hq_this_month['referrals']==0) ? 0 : number_format((($hq_this_month['pack_outs']/$hq_this_month['referrals'])*100),2),
					'pack_out_value' => number_format($hq_this_month['pack_outs_value'],2),
				),


				'PCCweek' => array(
					'referrals' => $pcc_this_week['referrals'],
					'pack_out' => $pcc_this_week['pack_outs'],
					'pack_out_percentage' => ($pcc_this_week['referrals']==0) ? 0 : number_format((($pcc_this_week['pack_outs']/$pcc_this_week['referrals'])*100),2),
					
					'di' => ($pcc_this_week['pack_outs']==0) ? 0 : number_format($pcc_this_week['pack_outs_value'] / $pcc_this_week['pack_outs'],2),
					'pack_out_percentage' => ($pcc_this_week['referrals']==0) ? 0 : number_format((($pcc_this_week['pack_outs']/$pcc_this_week['referrals'])*100),2),
					'pack_out_value' => number_format($pcc_this_week['pack_outs_value'],2),
				),
				'PCCmonth' => array(
					'referrals' => $pcc_this_month['referrals'],
					'pack_out' => $pcc_this_month['pack_outs'],
					'pack_out_percentage' => ($pcc_this_month['referrals']==0) ? 0 : number_format((($pcc_this_month['pack_outs']/$pcc_this_month['referrals'])*100),2),
					
					'di' => ($pcc_this_month['pack_outs']==0) ? 0 : number_format($pcc_this_month['pack_outs_value'] / $pcc_this_month['pack_outs'],2),
					'pack_out_percentage' => ($pcc_this_month['referrals']==0) ? 0 : number_format((($pcc_this_month['pack_outs']/$pcc_this_month['referrals'])*100),2),
					'pack_out_value' => number_format($pcc_this_month['pack_outs_value'],2),
				),
			
			));
			
		}
		
		
		public function get_wallboard_past_stats($center="GAB")
		{
		
			$last_month = GAB\Debtsolv::get_referral_count($center, date("01-m-Y", strtotime("Last Month")), date("t-m-Y", strtotime("Last Month")));
			$this_month = GAB\Debtsolv::get_referral_count($center, date("01-m-Y"), date("t-m-Y"), 3600);
			$this_week = GAB\Debtsolv::get_referral_count($center, date("d-m-Y", strtotime("monday this week")), date("d-m-Y"), 300);
			
			// Return the array
			$this->response(array(
				'last_month' => array(
					'referrals' => $last_month['referrals'],
					'pack_out' => $last_month['pack_outs'],
					'pack_out_percentage' => ($last_month['referrals']==0) ? 0 : number_format((($last_month['pack_outs']/$last_month['referrals'])*100),2),
					'pack_out_value' => number_format($last_month['pack_outs_value'],2),
				),
				'this_month' => array(
					'referrals' => $this_month['referrals'],
					'pack_out' => $this_month['pack_outs'],
					'pack_out_percentage' => ($this_month['referrals']==0) ? 0 : number_format((($this_month['pack_outs']/$this_month['referrals'])*100),2),
					'pack_out_value' => number_format($this_month['pack_outs_value'],2),
				),
				'this_week' => array(
					'referrals' => $this_week['referrals'],
					'pack_out' => $this_week['pack_outs'],
					'pack_out_percentage' => ($this_week['referrals']==0) ? 0 : number_format((($this_week['pack_outs']/$this_week['referrals'])*100),2),
					'pack_out_value' => number_format($this_week['pack_outs_value'],2),
				),
			));
			
		}
		
		
		
	
	}