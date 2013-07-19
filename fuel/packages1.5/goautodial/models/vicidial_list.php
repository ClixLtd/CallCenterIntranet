<?php

	namespace Goautodial;
	
	class Model_Vicidial_List extends Orm
	{
	
		protected static $_table_name = 'vicidial_list';
		
		protected static $_primary_key = array('lead_id');
		
		public static $_properties = array(
			'lead_id',
			'entry_date',
			'modify_date',
			'status',
			'user',
			'vendor_lead_code',
			'source_id',
			'list_id',
			'gmt_offset_now',
			'called_since_last_reset',
			'phone_code',
			'phone_number',
			'title',
			'first_name',
			'middle_initial',
			'last_name',
			'address1',
			'address2',
			'address3',
			'city',
			'state',
			'province',
			'postal_code',
			'country_code',
			'gender',
			'date_of_birth',
			'alt_phone',
			'email',
			'security_phrase',
			'comments',
			'called_count',
			'last_local_call_time',
			'rank',
			'owner',
			'entry_list_id',
		);
				
			
	}