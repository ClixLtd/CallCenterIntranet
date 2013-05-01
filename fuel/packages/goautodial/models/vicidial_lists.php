<?php

	namespace Goautodial;
	
	class Model_Vicidial_Lists extends Orm
	{
	
		protected static $_table_name = 'vicidial_lists';
		
		protected static $_primary_key = array('list_id');
		
		public static $_properties = array(
			'list_id',
			'list_name',
			'campaign_id',
			'active',
			'list_description',
			'list_changedate'
			'datetime',
			'list_lastcalldate',
			'reset_time',
			'agent_script_override',
			'campaign_cid_override',
			'am_message_exten_override',
			'drop_inbound_group_override',
			'xferconf_a_number',
			'xferconf_b_number',
			'xferconf_c_number',
			'xferconf_d_number',
			'xferconf_e_number',
			'web_form_address',
			'web_form_address_two',
			'script_type_id',
		);
				
			
	}