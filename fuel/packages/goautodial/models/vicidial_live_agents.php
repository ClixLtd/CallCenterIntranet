<?php

	namespace Goautodial;
	
	class Model_Vicidial_Live_Agents extends Orm
	{
	
		protected static $_table_name = 'vicidial_live_agents';
		
		protected static $_primary_key = array('live_agent_id');
		
		
		protected static $_has_one  = array(
		    'lead'              => array(
		        'key_from'         => 'lead_id',
		        'model_to'         => 'Goautodial\Model_Vicidial_List',
		        'key_to'           => 'lead_id',
		    ),
		    'user_details'              => array(
		        'key_from'         => 'user',
		        'model_to'         => 'Goautodial\Model_Vicidial_Users',
		        'key_to'           => 'user',
		    )
		);
		
		
		public static $_properties = array(
			'live_agent_id',
			'user',
			'server_ip',
			'conf_exten',
			'extension',
			'status',
			'lead_id',
			'campaign_id',
			'uniqueid',
			'callerid',
			'channel',
			'random_id',
			'last_call_time',
			'last_call_finish',
			'closer_campaigns',
			'call_server_ip',
			'user_level',
			'comments',
			'campaign_weight',
			'calls_today',
			'external_hangup',
			'external_status',
			'external_pause',
			'external_dial',
			'external_ingroups',
			'external_blended',
			'external_igb_set_user',
			'external_update_fields',
			'external_update_fields_data',
			'external_timer_action',
			'external_timer_action_message',
			'external_timer_action_seconds',
			'agent_log_id',
			'last_state_change',
			'agent_territories',
			'outbound_autodial',
			'manager_ingroup_set',
			'ra_user',
			'ra_extension',
			'external_dtmf',
			'external_transferconf',
			'external_park',
			'external_timer_action_destination',
			'on_hook_ring_time',
			'ring_callerid',
		);
				
			
	}