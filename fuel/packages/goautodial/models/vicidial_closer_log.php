<?php

	namespace Goautodial;
	
	class Model_Vicidial_Closer_Log extends Orm
	{
		protected static $_table_name = 'vicidial_closer_log';
		
		protected static $_primary_key = array('closecallid');
		
		public static $_properties = array(
			'closecallid',
			'lead_id',
			'list_id',
			'campaign_id',
			'call_date',
			'start_epoch',
			'end_epoch',
			'length_in_sec',
			'status',
			'phone_code',
			'phone_number',
			'user',
			'comments',
			'processed',
			'queue_seconds',
			'user_group',
			'xfercallid',
			'term_reason',
			'uniqueid',
			'agent_only',
			'queue_position',
		);
		
		
			
	}