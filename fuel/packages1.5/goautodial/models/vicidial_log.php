<?php

	namespace Goautodial;
	
	class Model_Vicidial_Log extends Orm
	{
	
		protected static $_table_name = 'vicidial_log';
		
		protected static $_primary_key = array('uniqueid');
		
		public static $_properties = array(
			'uniqueid',
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
			'user_group',
			'term_reason',
			'alt_dial',
		);
		
		
			
	}