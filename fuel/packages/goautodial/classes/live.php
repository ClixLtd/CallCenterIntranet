<?php

	namespace Goautodial;
	
	class Live
	{
		
		
		public static function dialable_leads($campaign=null)
		{
			$get_campaign_calls = Model_Vicidial_Campaign_Stats::find()->where('campaign_id', $campaign)->get_one();
			return $get_campaign_calls->dialable_leads;
		}
		
		
		public static function live_agents($campaign=null, $show_closers=TRUE)
		{
			date_default_timezone_set('Europe/London');
			$results = array();
			$dialler = null;
			
			if ($campaign == "BURTON1")
			{
				$dialler = "resolvedialler";
			}
			
			$live_agents = Model_Vicidial_Live_Agents::find(null,array(),$dialler);
			
			if (!is_null($campaign))
			{
				if ($campaign == "INTERNAL")
				{
					$live_agents->where('campaign_id', 'IN', array($campaign, "SENIORS", "GAB-1", "OPT-IN", "GBS-1"));
				}
				else
				{
					$live_agents->where('campaign_id', 'IN', array($campaign));
				}
				
			}
			
			if (!$show_closers)
			{
				$live_agents->where('status', '<>', 'CLOSER');
			}
			
			$all_results = $live_agents->order_by('status', 'ASC')->order_by('last_state_change', 'DESC')->get();
			
			
			foreach ($all_results AS $agent)
			{
				// Get the referrals
				
				$all_referrals = Model_Vicidial_Log::find()->where('user', $agent->user_details->user)->where('status', 'SALE')->where('call_date', '>', date('Y-m-d').' 00:00:00')->ORDER_BY("campaign_id");
				
				$allReferrals = \DB::query("SELECT id FROM Dialler.dbo.referrals WHERE product = 'DR' AND user_login = '".$agent->user_details->user."' AND referral_date >= CONVERT(datetime, '".date('Y-d-m')."', 105) ")->cached(30)->execute('debtsolv');
				
				$allPackOuts = \DB::query("SELECT REF.id FROM [Dialler].[dbo].[referrals] AS REF LEFT JOIN LeadPool_DM.dbo.Campaign_Contacts AS CC ON REF.leadpool_id = CC.ClientID LEFT JOIN LeadPool_DM.dbo.Type_ContactResult AS TCR ON CC.ContactResult = TCR.ID WHERE product = 'DR' AND TCR.Description = 'Lead Completed' AND user_login = '".$agent->user_details->user."' AND referral_date >= CONVERT(datetime, '".date('Y-d-m')."', 105) ")->cached(30)->execute('debtsolv');
				
				$results[]                = array(
					'user'                  => array(
						'username' => $agent->user_details->user,
						'full_name' => $agent->user_details->full_name,
						'group' => $agent->user_details->user_group,
						'referrals' => $allReferrals->count(),
						'pack_outs' => $allPackOuts->count(),
					),
					'extension'             => $agent->extension,
					'comments'             => (strlen($agent->comments) > 1) ? $agent->comments : "NONE",
					'status'                => $agent->status,
					'lead'               => ($agent->lead_id>0) ? array(
						'lead_id' => $agent->lead_id,
						'list_id' => $agent->lead->list_id,
						'name' => $agent->lead->first_name . " " . $agent->lead->last_name,
					) : 0,
					'campaign_id'           => $agent->campaign_id,
					'calls_today'           => $agent->calls_today,
					'campaign_id'           => $agent->campaign_id,
					'last_state_change_ago' => ( strtotime("NOW") - strtotime($agent->last_state_change) ),
				);
			}
			
			
			return $results;
			
		}
		
		
		public static function answered_calls($campaigns=null)
		{
			$get_campaign_calls = Model_Vicidial_Campaign_Stats::find();
			
			foreach($campaigns AS $campaign)
			{
				$get_campaign_calls->or_where('campaign_id', $campaign);
			}
			
			$chosen_campaigns = $get_campaign_calls->get();
			
			$count_hold = 0;
			foreach ($chosen_campaigns AS $details)
			{
				$count_hold = $count_hold + $details['answers_today'];
			}
			
			return $count_hold;
			
		}
		
		
		public static function agents_in_campaign($campaign=null)
		{
			$get_agents = Model_Vicidial_Live_Agents::find()->where('campaign_id', $campaign);
			return $get_agents->count();
		}
		
		public static function closers($campaign=null)
		{
			$get_sales = Model_Vicidial_Live_Agents::find()->where('status', 'CLOSER');
			if (!is_null($campaign))
			{
				$get_sales->where('campaign_id',$campaign);
			}
			return $get_sales->get();
		}
		
		
		public static function inbound_queue($campaigns=null)
		{
			
			$get_inbound = Model_Vicidial_Auto_Calls::find()->where('call_type', 'IN')->where('status', 'LIVE')->where('campaign_id', 'IN', array('GABDRSeniors','GBSDRSeniors','RESOLVEDRSeniors'));
	
	
			return $get_inbound->get();
			
		}
		
		
	}