<?php

	namespace Goautodial;
	
	class Model_Vicidial_Campaigns extends Orm
	{
		protected static $_table_name = 'vicidial_campaigns';
		
		protected static $_primary_key = array('campaign_id');
		
		public static $_properties = array(
			'campaign_id',
			'campaign_name',
			'active',
			'dial_status_a',
			'dial_status_b',
			'dial_status_c',
			'dial_status_d',
			'dial_status_e',
			'lead_order',
			'park_ext',
			'park_file_name',
			'web_form_address',
			'allow_closers',
			'hopper_level',
			'auto_dial_level',
			'next_agent_call',
			'local_call_time',
			'voicemail_ext',
			'dial_timeout',
			'dial_prefix',
			'campaign_cid',
			'campaign_vdad_exten',
			'campaign_rec_exten',
			'campaign_recording',
			'campaign_rec_filename',
			'campaign_script',
			'get_call_launch',
			'am_message_exten',
			'amd_send_to_vmx',
			'xferconf_a_dtmf',
			'xferconf_a_number',
			'xferconf_b_dtmf',
			'xferconf_b_number',
			'alt_number_dialing',
			'scheduled_callbacks',
			'lead_filter_id',
			'drop_call_seconds',
			'drop_action',
			'safe_harbor_exten',
			'display_dialable_count',
			'wrapup_seconds',
			'wrapup_message',
			'closer_campaigns',
			'use_internal_dnc',
			'allcalls_delay',
			'omit_phone_code',
			'dial_method',
			'available_only_ratio_tally',
			'adaptive_dropped_percentage',
			'adaptive_maximum_level',
			'adaptive_latest_server_time',
			'adaptive_intensity',
			'adaptive_dl_diff_target',
			'concurrent_transfers',
			'auto_alt_dial',
			'auto_alt_dial_statuses',
			'agent_pause_codes_active',
			'campaign_description',
			'campaign_changedate',
			'campaign_stats_refresh',
			'campaign_logindate',
			'dial_statuses',
			'disable_alter_custdata',
			'no_hopper_leads_logins',
			'list_order_mix',
			'campaign_allow_inbound',
			'manual_dial_list_id',
			'default_xfer_group',
			'xfer_groups',
			'queue_priority',
			'drop_inbound_group',
			'qc_enabled',
			'qc_statuses',
			'qc_lists',
			'qc_shift_id',
			'qc_get_record_launch',
			'qc_show_recording',
			'qc_web_form_address',
			'qc_script',
			'survey_first_audio_file',
			'survey_dtmf_digits',
			'survey_ni_digit',
			'survey_opt_in_audio_file',
			'survey_ni_audio_file',
			'survey_method',
			'survey_no_response_action',
			'survey_ni_status',
			'survey_response_digit_map',
			'survey_xfer_exten',
			'survey_camp_record_dir',
			'disable_alter_custphone',
			'display_queue_count',
			'manual_dial_filter',
			'agent_clipboard_copy',
			'agent_extended_alt_dial',
			'use_campaign_dnc',
			'three_way_call_cid',
			'three_way_dial_prefix',
			'web_form_target',
			'vtiger_search_category',
			'vtiger_create_call_record',
			'vtiger_create_lead_record',
			'vtiger_screen_login',
			'cpd_amd_action',
			'agent_allow_group_alias',
			'default_group_alias',
			'vtiger_search_dead',
			'vtiger_status_call',
			'survey_third_digit',
			'survey_third_audio_file',
			'survey_third_status',
			'survey_third_exten',
			'survey_fourth_digit',
			'survey_fourth_audio_file',
			'survey_fourth_status',
			'survey_fourth_exten',
			'drop_lockout_time',
			'quick_transfer_button',
			'prepopulate_transfer_preset',
			'drop_rate_group',
			'view_calls_in_queue',
			'view_calls_in_queue_launch',
			'grab_calls_in_queue',
			'call_requeue_button',
			'pause_after_each_call',
			'no_hopper_dialing',
			'agent_dial_owner_only',
			'agent_display_dialable_leads',
			'web_form_address_two',
			'waitforsilence_options',
			'agent_select_territories',
			'campaign_calldate',
			'crm_popup_login',
			'crm_login_address',
			'timer_action',
			'timer_action_message',
			'timer_action_seconds',
			'start_call_url',
			'dispo_call_url',
			'xferconf_c_number',
			'xferconf_d_number',
			'xferconf_e_number',
			'use_custom_cid',
			'scheduled_callbacks_alert',
			'queuemetrics_callstatus_override',
			'extension_appended_cidname',
			'scheduled_callbacks_count',
			'manual_dial_override',
			'blind_monitor_warning',
			'blind_monitor_message',
			'blind_monitor_filename',
			'inbound_queue_no_dial',
			'timer_action_destination',
			'enable_xfer_presets',
			'hide_xfer_number_to_dial',
			'manual_dial_prefix',
			'customer_3way_hangup_logging',
			'customer_3way_hangup_seconds',
			'customer_3way_hangup_action',
			'ivr_park_call',
			'ivr_park_call_agi',
			'manual_preview_dial',
			'realtime_agent_time_stats',
			'use_auto_hopper',
			'auto_hopper_multi',
			'auto_hopper_level',
			'auto_trim_hopper',
			'api_manual_dial',
			'manual_dial_call_time_check',
			'display_leads_count',
			'lead_order_randomize',
			'lead_order_secondary',
			'per_call_notes',
			'my_callback_option',
			'agent_lead_search',
			'agent_lead_search_method',
			'queuemetrics_phone_environment',
			'auto_pause_precall',
			'auto_pause_precall_code',
			'auto_resume_precall',
			'manual_dial_cid',
			'post_phone_time_diff_alert',
		);
				
				
			
	}