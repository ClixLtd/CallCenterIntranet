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
				8 => '014_add_name_to_data_users',
				9 => '015_add_call_center_id_to_users',
				10 => '016_add_shortcode_to_call_center',
				11 => '017_create_users_log_logins',
				12 => '018_add_status_to_users_log_login',
				13 => '020_add_attempted_login_to_users_log_login',
				14 => '021_add_ip_address_to_users_log_logins',
				15 => '022_create_help_topics',
				16 => '023_create_help_tickets',
				17 => '024_create_news',
				18 => '025_create_debtsolv_transfer_logs',
				19 => '026_create_data_supplier_campaigns',
				20 => '027_create_data_supplier_campaigns_data_suppliers',
				21 => '028_create_data_supplier_campaign_lists',
				22 => '029_create_surnames',
				23 => '030_create_towns',
				24 => '031_add_last_town_to_surnames',
				25 => '032_create_selfgenerations',
				26 => '033_create_proxies',
				27 => '034_add_use_count_to_proxies',
				28 => '035_create_proxy_imports',
				29 => '036_create_adam_messages',
				30 => '037_create_adam_announcements',
				31 => '038_create_data_supplier_campaign_lists_duplicates',
				32 => '039_add_dialler_to_data_supplier_campaign_lists_duplicates',
				33 => '040_add_lead_id_to_data_supplier_campaign_lists_duplicates',
				34 => '041_create_tomorrow_list_stats',
				35 => '042_add_dialler_to_tomorrow_list_stats',
				36 => '043_add_campaign_to_tomorrow_list_stats',
				37 => '044_create_lead_tables',
				38 => '045_create_dialler_campaign_calls',
				39 => '046_create_api_users',
				40 => '047_create_printmanager_printers',
				41 => '048_create_printmanager_trays',
				42 => '049_create_printmanager_queues',
				43 => '050_add_api_key_to_call_centers',
				44 => '051_create_server_statistics',
				45 => '052_create_staffs',
				46 => '053_create_staff_departments',
				47 => '054_add_center_id_to_staff',
				48 => '055_add_department_id_to_staff',
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
				5 => '006_create_database_messages_contact_message_read',
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
