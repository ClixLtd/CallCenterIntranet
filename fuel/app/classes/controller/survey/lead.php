<?php

class Controller_Survey_Lead extends Controller_Template
{
    
    public function checkAnswer($_question=null, $_required=null, $details=array())
    {
        $required = (is_array($_required)) ? $_required : array($_required);
        
        if (isset($details[$_question]))
        {
            if (in_array($details[$_question]['answer'], $required))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        
    }
    
    
    public function checkLeads()
    {
    }
    
    
    
	public function action_index()
	{
	    
	            $startDate = strtotime('now -48 hours');
	    $endDate = strtotime('now -2 weeks');
	    
	    // Get a list of all responses for this date range
	    $externalReferrals = \DB::query('SELECT * FROM survey_responses WHERE created_at >= '.$startDate.' AND created_at <= '.$endDate.';')->execute();
	    
	    $uniqueDetails = array();
	    foreach ($externalReferrals as $response)
	    {
	        // Add the reference to the list of uniques for the time range
    	    $uniqueDetails[$response['reference']][$response['question_id']] = array(
    	        'answer' => $response['answer_id'],
    	        'extra' => $response['extra'],
    	    );
	    }
	    
	    
	    
	    $ppiLeads = $drLeads = array();
	    foreach ($uniqueDetails as $referral => $referralDetails)
	    {
	           	    
    	    
    	    if ( 
    	           Controller_Survey_Lead::checkAnswer(12, 47, $referralDetails) AND 
    	           Controller_Survey_Lead::checkAnswer(11, array(41,42,43,44,45,46), $referralDetails) AND
    	         ( Controller_Survey_Lead::checkAnswer(8, 31, $referralDetails) || Controller_Survey_Lead::checkAnswer(5, array(11,12,13), $referralDetails) ) AND
    	         ( Controller_Survey_Lead::checkAnswer(4, 8, $referralDetails) || Controller_Survey_Lead::checkAnswer(3, 6, $referralDetails) )
    	       )
    	    {
        	    $drLeads[] = $referral;
    	    } 
    	    
    	    if (
    	           Controller_Survey_Lead::checkAnswer(15, 66, $referralDetails) AND 
    	           Controller_Survey_Lead::checkAnswer(16, 69, $referralDetails) AND
    	           !in_array($referral, $drLeads)
    	       )
    	    {
        	    $ppiLeads[] = $referral;
    	    }

    	    
    	    
	    }
	    
	    // Create a CSV file for the lead type
	    $ppiAllLeads = Array();
	    
	    foreach ($ppiLeads as $lead)
	    {
	        $thisCheck = Model_Survey_Lead_Dialler::query()->where('referral_id', $lead);

    	    if ($thisCheck->count() < 1)
    	    {
        	    
        	    $singleLead = \Model_Crmreferral::find($lead);
        	    
        	    $ppiLeadInsert = array(
                    'lead_id'                 => "",
                    'entry_date'              => date("Y-m-d H:i:s",strtotime($singleLead->referral_date)),
                    'modify_date'             => date("Y-m-d H:i:s",strtotime($singleLead->referral_date)),
                    'status'                  => "NEW",
                    'user'                    => "",
                    'vendor_lead_code'        => "",
                    'source_id'               => "",
                    'list_id'                 => 199999,
                    'gmt_offset_now'          => 0.00,
                    'called_since_last_reset' => "N",
                    'phone_code'              => "9",
                    'phone_number'            => (int)(is_null($singleLead->tel_home)) ? $singleLead->tel_mobile : $singleLead->tel_home,
                    'title'                   => "",
                    'first_name'              => $singleLead->forename,
                    'middle_initial'          => "",
                    'last_name'               => $singleLead->surname,
                    'address1'                => $singleLead->street_and_number,
                    'address2'                => $singleLead->area,
                    'address3'                => $singleLead->district,
                    'city'                    => $singleLead->town,
                    'state'                   => "",
                    'province'                => $singleLead->county,
                    'postal_code'             => $singleLead->post_code,
                    'country_code'            => "UK",
                    'gender'                  => "U",
                    'date_of_birth'           => date('Y-m-d', strtotime($singleLead->date_of_birth)),
                    'alt_phone'               => ((int)$singleLead->tel_mobile == 0) ? "" : (int)$singleLead->tel_mobile,
                    'email'                   => "",
                    'security_phrase'         => "",
                    'comments'                => "!!! SURVEY LEAD !!! - PPI QUALIFIED - Survey Taken on : ".date("jS F Y",strtotime($singleLead->referral_date)),
                    'called_count'            => 0,
                    'last_local_call_time'    => "2009-01-01 00:00:00",
                    'rank'                    => 0,
                    'owner'                   => "",
                    'entry_list_id'           => 0,
                );
        	    
        	    // Add leads directly to the dialler
        	    
                list($insertID, $rowsChanged) = \DB::insert('vicidial_list')->set($ppiLeadInsert)->execute('gabdialler');
                    	    
        	    $ppiAllLeads[] = array(
                    'diallerid' => $insertID,
        	        'forename' => $singleLead->forename,
        	        'surname' => $singleLead->surname,
        	        'address1' => $singleLead->street_and_number,
        	        'address2' => $singleLead->area,
        	        'address3' => $singleLead->district,
        	        'town' => $singleLead->town,
        	        'county' => $singleLead->county,
        	        'postcode' => $singleLead->post_code,
        	        'home' => $singleLead->tel_home,
        	        'mobile' => $singleLead->tel_mobile,
        	        'email' => $singleLead->email,
        	        'dob' => date('d-m-Y', strtotime($singleLead->date_of_birth)),
        	    );
        	    
        	    $leadInsert = new \Model_Survey_Lead_Dialler();
        	    $leadInsert->referral_id = (int)$lead;
        	    $leadInsert->dialler_id = (int)$insertID;
        	    $leadInsert->type = "PPI";
        	    $leadInsert->save();
    	    
    	    }
    	    
	    }
	    
	    $drAllLeads = Array();
	    foreach ($drLeads as $lead)
	    {

    	    $thisCheck = Model_Survey_Lead_Dialler::query()->where('referral_id', $lead);
    	    
    	    if ($thisCheck->count() < 1)
    	    {
        	    
        	    $singleLead = \Model_Crmreferral::find($lead);
    
        	    $drLeadInsert = array(
                    'lead_id'                 => "",
                    'entry_date'              => date("Y-m-d H:i:s",strtotime($singleLead->referral_date)),
                    'modify_date'             => date("Y-m-d H:i:s",strtotime($singleLead->referral_date)),
                    'status'                  => "NEW",
                    'user'                    => "",
                    'vendor_lead_code'        => "",
                    'source_id'               => "",
                    'list_id'                 => 149999,
                    'gmt_offset_now'          => 0.00,
                    'called_since_last_reset' => "N",
                    'phone_code'              => "9",
                    'phone_number'            => (int)(is_null($singleLead->tel_home)) ? $singleLead->tel_mobile : $singleLead->tel_home,
                    'title'                   => "",
                    'first_name'              => $singleLead->forename,
                    'middle_initial'          => "",
                    'last_name'               => $singleLead->surname,
                    'address1'                => $singleLead->street_and_number,
                    'address2'                => $singleLead->area,
                    'address3'                => $singleLead->district,
                    'city'                    => $singleLead->town,
                    'state'                   => "",
                    'province'                => $singleLead->county,
                    'postal_code'             => $singleLead->post_code,
                    'country_code'            => "UK",
                    'gender'                  => "U",
                    'date_of_birth'           => date('Y-m-d', strtotime($singleLead->date_of_birth)),
                    'alt_phone'               => ((int)$singleLead->tel_mobile == 0) ? "" : (int)$singleLead->tel_mobile,
                    'email'                   => "",
                    'security_phrase'         => "",
                    'comments'                => "!!! SURVEY LEAD !!! - DR QUALIFIED - Survey Taken on : ".date("jS F Y",strtotime($singleLead->referral_date)),
                    'called_count'            => 0,
                    'last_local_call_time'    => "2009-01-01 00:00:00",
                    'rank'                    => 0,
                    'owner'                   => "",
                    'entry_list_id'           => 0,
                );
        	    
        	    // Add leads directly to the dialler
        	    
                list($insertID, $rowsChanged) = \DB::insert('vicidial_list')->set($drLeadInsert)->execute('gabdialler');
                
                $drAllLeads[] = array(
                    'diallerid' => $insertID,
        	        'forename' => $singleLead->forename,
        	        'surname' => $singleLead->surname,
        	        'address1' => $singleLead->street_and_number,
        	        'address2' => $singleLead->area,
        	        'address3' => $singleLead->district,
        	        'town' => $singleLead->town,
        	        'county' => $singleLead->county,
        	        'postcode' => $singleLead->post_code,
        	        'home' => $singleLead->tel_home,
        	        'mobile' => $singleLead->tel_mobile,
        	        'email' => $singleLead->email,
        	        'dob' => date('d-m-Y', strtotime($singleLead->date_of_birth)),
        	    );
        	    
        	    $leadInsert = new \Model_Survey_Lead_Dialler();
        	    $leadInsert->referral_id = (int)$lead;
        	    $leadInsert->dialler_id = (int)$insertID;
        	    $leadInsert->type = "DR";
        	    $leadInsert->save();
        	    
    	    }
    	    
	    }



	    
		$this->template->title = 'Survey lead &raquo; Index';
		$this->template->content = View::forge('survey/lead/index');
	}

}
