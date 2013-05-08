<?php
use Orm\Model;

class Model_Crmreferral extends Model
{
    protected static $_table_name = 'crm_referrals';

	protected static $_properties = array(
		'id',
		'user_id',
		'introducer_id',
		'introducer_agent_name',
		'company_id',
		'product_id',
		'dialler_lead_id',
		'dialler_list_id',
		'dialler_list_name',
		'referral_date',
		'disposition_id',
		'title',
		'forename',
		'surname',
		'street_and_number',
		'area',
		'district',
		'town',
		'county',
		'country_id',
		'post_code',
		'date_of_birth',
		'tel_home',
		'tel_work',
		'tel_mobile',
		'email',
		'notes',
		'data',
		'consolidation_centre',
	);

}
