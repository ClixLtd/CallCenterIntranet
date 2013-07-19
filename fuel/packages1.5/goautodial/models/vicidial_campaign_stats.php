<?php

	namespace Goautodial;
	
	class Model_Vicidial_Campaign_Stats extends Orm
	{
		
		protected static $_table_name = 'vicidial_campaign_stats';
		
		protected static $_primary_key = array('campaign_id');
		
		public static $_properties = array(
			'campaign_id',
			'update_time',
			'dialable_leads',
			'calls_today',
			'answers_today',
			'drops_today',
			'drops_today_pct',
			'drops_answers_today_pct',
			'calls_hour',
			'answers_hour',
			'drops_hour',
			'drops_hour_pct',
			'calls_halfhour',
			'answers_halfhour',
			'drops_halfhour',
			'drops_halfhour_pct',
			'calls_fivemin',
			'answers_fivemin',
			'drops_fivemin',
			'drops_fivemin_pct',
			'calls_onemin',
			'answers_onemin',
			'drops_onemin',
			'drops_onemin_pct',
			'differential_onemin',
			'agents_average_onemin',
			'balance_trunk_fill',
			'status_category_1',
			'status_category_count_1',
			'status_category_2',
			'status_category_count_2',
			'status_category_3',
			'status_category_count_3',
			'status_category_4',
			'status_category_count_4',
			'hold_sec_stat_one',
			'hold_sec_stat_two',
			'agent_non_pause_sec',
			'hold_sec_answer_calls',
			'hold_sec_drop_calls',
			'hold_sec_queue_calls',
			'agent_calls_today',
			'agent_wait_today',
			'agent_custtalk_today',
			'agent_acw_today',
			'agent_pause_today',		 	 	 	 	 	 	
		);
				
			
	}