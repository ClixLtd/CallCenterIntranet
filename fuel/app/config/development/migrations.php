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
				11 => '013_add_title_to_data_supplier_lists',
				12 => '014_add_name_to_data_users',
				13 => '015_add_call_center_id_to_users',
				14 => '016_add_shortcode_to_call_center',
				15 => '017_create_users_log_logins',
				16 => '018_add_status_to_users_log_login',
				17 => '019_delete_field_login_time_from_users_log_logins',
				18 => '020_add_attempted_login_to_users_log_login',
				19 => '021_add_ip_address_to_users_log_logins',
				20 => '022_create_help_topics',
				21 => '023_create_help_tickets',
				22 => '024_create_news',
				23 => '025_create_debtsolv_transfer_logs',
				24 => '026_create_data_supplier_campaigns',
				25 => '027_create_data_supplier_campaigns_data_suppliers',
				26 => '028_create_data_supplier_campaign_lists',
				27 => '029_create_surnames',
				28 => '030_create_towns',
				29 => '031_add_last_town_to_surnames',
				30 => '032_create_selfgenerations',
				31 => '033_create_proxies',
				32 => '034_add_use_count_to_proxies',
				33 => '035_create_proxy_imports',
				34 => '036_create_adam_messages',
				35 => '037_create_adam_announcements',
				36 => '038_create_data_supplier_campaign_lists_duplicates',
				37 => '039_add_dialler_to_data_supplier_campaign_lists_duplicates',
				38 => '040_add_lead_id_to_data_supplier_campaign_lists_duplicates',
				39 => '041_create_tomorrow_list_stats',
				40 => '042_add_dialler_to_tomorrow_list_stats',
				41 => '043_add_campaign_to_tomorrow_list_stats',
				42 => '044_create_lead_tables',
				43 => '045_create_dialler_campaign_calls',
				44 => '046_create_api_users',
				45 => '047_create_printmanager_printers',
				46 => '048_create_printmanager_trays',
				47 => '049_create_printmanager_queues',
				48 => '050_add_api_key_to_call_centers',
				49 => '051_create_calendar_holidays',
			),
		),
		'module' => 
		array(
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
			),
			'sexyticket' => 
			array(
				0 => '001_create_sexy_ticket_departments',
				1 => '002_create_sexy_ticket_topics',
				2 => '003_create_sexy_ticket_tickets',
				3 => '004_create_sexy_ticket_priorities',
			),
			'messages' => 
			array(
				0 => '001_create_database_messages_message',
				1 => '002_create_database_messages_contact',
				2 => '003_create_database_messages_type_message',
				3 => '004_create_database_messages_viewable_groups',
				4 => '005_create_database_messages_viewable_groups_messages',
			),
		),
		'subpackage' => 
		array(
			'crm_company' => 
			array(
				0 => '001_create_crm_companies',
				1 => '002_create_crm_company_groups',
				2 => '003_alter_crm_companies',
				3 => '004_alter_crm_companies_add_sales_email',
			),
			'crm_creditor' => 
			array(
				0 => '001_create_crm_creditors',
				1 => '002_create_crm_creditors_contact',
			),
			'crm_letter' => 
			array(
				0 => '001_create_crm_letters_pack_letters',
				1 => '002_create_crm_letter_packs',
				2 => '003_create_crm_letter_letters',
				3 => '004_create_crm_letter_letterhead',
			),
			'crm_logs' => 
			array(
				0 => '001_create_crm_client_access_log',
				1 => '002_create_crm_referrals_access_log',
				2 => '003_create_crm_type_access_log',
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
			),
			'crm_product' => 
			array(
				0 => '001_create_crm_products',
				1 => '002_alter_crm_products_added_shortcode',
			),
			'crm_referrals' => 
			array(
				0 => '001_create_crm_referrals',
				1 => '002_create_crm_type_disposition',
				2 => '003_alter_crm_referrals',
				3 => '004_create_crm_introducers',
				4 => '005_alter_crm_referrals_add_introducer_id',
				5 => '006_alter_crm_referrals_add_data',
				6 => '007_create_crm_referrals_callbacks',
				7 => '008_alter_crm_type_disposition',
				8 => '009_alter_crm_referrals_add_consolidation_centre',
				9 => '010_alter_crm_referrals_callbacks_add_centre_id',
				10 => '011_alter_crm_referrals_added_intro_name',
			),
		),
	),
	'folder' => 'migrations/',
	'table' => 'migration',
);
