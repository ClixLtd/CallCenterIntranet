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
				8 => '009_alter_clientarea_companies_add_centre_id',
				9 => '010_alter_clientarea_companies_remove_centre_id',
				10 => '011_alter_clientarea_companies_add_components',
			),
			'survey' => 
			array(
				0 => '001_create_scripts_tables',
				1 => '002_create_scripts_forms_tables',
				2 => '003_alter_scripts_forms_can_repeat',
				3 => '004_alter_scripts_script_form_id',
				4 => '005_alter_scripts_forms_responses_add_answers',
				5 => '006_create_scripts_forms_reponses_log',
				6 => '007_alter_scripts_add_domain_id',
				7 => '008_create_scripts_forms_products',
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
