<?php
return array(
	'version' => 
	array(
		'app' => 
		array(
			'default' => 
			array(
				0 => '001_create_dialler_all_numbers',
				1 => '002_create_dialler_all_logs',
				2 => '003_create_s',
				3 => '004_create_dialler_campaigns',
				4 => '005_create_call_centers',
				5 => '006_create_database_servers',
				6 => '007_create_database_queries',
				7 => '008_create_database_query_tags',
				8 => '009_create_dialler_lists',
				9 => '010_create_data_suppliers',
				10 => '011_create_data_supplier_lists',
				11 => '014_add_name_to_data_users',
				12 => '015_add_call_center_id_to_users',
				13 => '016_add_shortcode_to_call_center',
				14 => '017_create_users_log_logins',
				15 => '018_add_status_to_users_log_login',
				16 => '020_add_attempted_login_to_users_log_login',
				17 => '021_add_ip_address_to_users_log_logins',
				18 => '022_create_help_topics',
				19 => '023_create_help_tickets',
				20 => '024_create_news',
				21 => '025_create_debtsolv_transfer_logs',
				22 => '026_create_data_supplier_campaigns',
				23 => '027_create_data_supplier_campaigns_data_suppliers',
				24 => '028_create_data_supplier_campaign_lists',
				25 => '029_create_surnames',
				26 => '030_create_towns',
				27 => '031_add_last_town_to_surnames',
				28 => '032_create_selfgenerations',
				29 => '033_create_proxies',
				30 => '034_add_use_count_to_proxies',
				31 => '035_create_proxy_imports',
				32 => '036_create_adam_messages',
				33 => '037_create_adam_announcements',
				34 => '038_create_data_supplier_campaign_lists_duplicates',
				35 => '039_add_dialler_to_data_supplier_campaign_lists_duplicates',
				36 => '040_add_lead_id_to_data_supplier_campaign_lists_duplicates',
				37 => '041_create_tomorrow_list_stats',
				38 => '042_add_dialler_to_tomorrow_list_stats',
				39 => '043_add_campaign_to_tomorrow_list_stats',
				40 => '044_create_lead_tables',
				41 => '045_create_dialler_campaign_calls',
				42 => '046_create_api_users',
				43 => '047_create_printmanager_printers',
				44 => '048_create_printmanager_trays',
				45 => '049_create_printmanager_queues',
				46 => '050_add_api_key_to_call_centers',
				47 => '051_create_server_statistics',
				48 => '052_create_staffs',
				49 => '053_create_staff_departments',
				50 => '054_add_center_id_to_staff',
				51 => '055_add_department_id_to_staff',
				52 => '056_create_telesales_report_values',
				53 => '057_add_pack_out_commission_to_telesales_report_values',
				54 => '058_add_pack_out_bonus_to_telesales_report_values',
				55 => '059_add_payment_percentage_to_telesales_report_values',
				56 => '060_create_dialler_current_agents',
				57 => '061_create_user_centers',
				58 => '062_create_surveys',
				59 => '063_create_survey_questions',
				60 => '064_create_survey_question_answers',
				61 => '065_create_survey_responses',
				62 => '066_add_required_to_survey_questions',
				63 => '067_add_survey_to_call_centers',
				64 => '068_create_survey_lead_batches',
				65 => '069_create_survey_lead_suppliers',
				66 => '070_create_survey_lead_logs',
				67 => '071_create_survey_lead_diallers',
				68 => '072_add_order_to_survey_questions',
				69 => '073_create_incentive_battleships_ships',
				70 => '074_create_incentive_battleships_ship_parts',
				71 => '075_create_incentive_battleships_turns',
			),
		),
		'module' => 
		array(
			'data' => 
			array(
				0 => '001_create_data',
				1 => '002_create_data_reset',
				2 => '003_create_data_reset_type',
				3 => '004_create_data_holder',
				4 => '005_create_data_dialler_copy',
				5 => '006_add_dates_to_data',
				6 => '007_create_data_headings',
				7 => '008_add_current_status_to_data_dialler_copy',
				8 => '009_add_score_to_data',
			),
			'suppliers' => 
			array(
				0 => '001_create_suppliers',
			),
			'clientarea' => 
			array(
				0 => '001_create_clientarea_change_password',
				1 => '002_create_clientarea_client_access_log',
				2 => '003_create_clientarea_client_change_profile',
				3 => '004_create_clientarea_companies',
				4 => '005_create_clientarea_messages',
				5 => '006_create_clientarea_messages_posts',
				6 => '007_create_clientarea_messages_statuses',
				7 => '008_create_clientarea_type_access_log_type',
			),
		),
		'package' => 
		array(
			'crm' => 
			array(
				0 => '001_create_crm_client_details',
				1 => '002_create_crm_client_access_log',
				2 => '003_create_crm_type_client_status',
				3 => '004_create_crm_type_countries',
				4 => '005_create_crm_client_products',
				5 => '006_drop_crm_client_access_log',
				6 => '007_alter_crm_client_details_add_created',
				7 => '008_create_crm_client_partner_details',
				8 => '009_alter_crm_client_partner_detailsautoid',
				9 => '010_create_crm_post_codes_list',
			),
			'sms' => 
			array(
				0 => '001_create_sms_logs',
			),
		),
		'subpackage' => 
		array(
			'crm_invoice' => 
			array(
				0 => '001_create_crm_invoices',
				1 => '002_alter_crm_invoices_addvat',
			),
			'crm_ppi' => 
			array(
				0 => '001_create_crm_ppi_claims',
				1 => '002_create_crm_ppi_clients',
				2 => '003_create_crm_ppi_correspondence',
				3 => '004_create_crm_ppi_refund',
				4 => '005_create_crm_type_ppi_claim_stage',
				5 => '006_create_crm_type_ppi_claim_status',
				6 => '007_create_crm_type_ppi_refund_method',
				7 => '008_alter_crm_ppi_clients_add_packs',
				8 => '009_alter_crm_ppi_claims_add_account_info',
				9 => '010_alter_crm_type_ppi_claim_status_change_name',
				10 => '011_alter_crm_ppi_correspondence_addfields',
				11 => '012_alter_crm_ppi_clients_packout_fields',
				12 => '013_alter_crm_ppi_correspondence_changenotes',
				13 => '014_alter_crm_ppi_claims_addedsignatory',
				14 => '015_alter_crm_ppi_clients_addpartner',
				15 => '016_alter_crm_ppi_claims_invoice_id',
				16 => '017_alter_crm_ppi_claims_change_ac',
				17 => '018_alter_crm_ppi_refund_removecols',
				18 => '019_create_crm_type_debt',
				19 => '020_alter_crm_ppi_claims_debttype',
				20 => '021_alter_crm_ppi_refund_invoiceid',
			),
		),
	),
	'folder' => 'migrations/',
	'table' => 'migration',
);
