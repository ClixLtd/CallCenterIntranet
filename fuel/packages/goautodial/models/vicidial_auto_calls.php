<?php

	namespace Goautodial;
	
	class Model_Vicidial_Auto_Calls extends Orm
	{
		
		protected static $_table_name = 'vicidial_auto_calls';
		
		protected static $_primary_key = array('auto_call_id');
		
		public static $_properties = array(
			'auto_call_id',
			'server_ip',
			'campaign_id',
			'status',
			'lead_id',
			'uniqueid',
			'callerid',
			'channel',
			'phone_code',
			'phone_number',
			'call_time',
			'call_type',
			'stage',
			'last_update_time',
			'alt_dial',
			'queue_priority',
			'agent_only',
			'agent_grab',
			'queue_priority',
			'agent_only',
			'agent_grab',
			'queue_position',
			'extension',
			'agent_grab_extension',
		);
				
			
	}