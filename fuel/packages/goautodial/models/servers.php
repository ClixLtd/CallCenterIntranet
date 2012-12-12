<?php

	namespace Goautodial;
	
	class Model_Servers extends Orm
	{
		
		protected static $_table_name = 'servers';
		
		protected static $_primary_key = array('server_id');
		
		public static $_properties = array(
			'server_id',
			'server_description',
			'server_ip',
			'active',
			'asterisk_version',
			'ax_vicidial_trunks',
			'telnet_host',
			'telnet_port',
			'ASTmgrUSERNAME',
			'ASTmgrSECRET',
			'ASTmgrUSERNAMEupdate',
			'ASTmgrUSERNAMElisten',
			'ASTmgrUSERNAMEsend',
			'local_gmt',
			'voicemail_dump_exten',
			'answer_transfer_agent',
			'ext_context',
			'sys_perf_log',
			'vd_server_logs',
			'agi_output',
			'vicidial_balance_active',
			'balance_trunks_offlimits',
			'recording_web_link',
			'alt_server_ip',
			'active_asterisk_server',
			'generate_vicidial_conf',
			'rebuild_conf_files',
			'outbound_calls_per_second',
			'sysload',
			'channels_total',
			'cpu_idle_percent',
			'disk_usage',
			'sounds_update',
			'vicidial_recording_limit',
			'carrier_logging_active',
			'vicidial_balance_rank',
			'rebuild_music_on_hold',
			'active_agent_login_server',
			'conf_secret',
			'external_server_ip',
			'custom_dialplan_entry',
			'active_twin_server_ip',
		);
				
			
	}