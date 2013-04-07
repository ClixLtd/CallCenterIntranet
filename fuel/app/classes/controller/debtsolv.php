<?php

class Controller_Debtsolv extends Controller_Rest
{
	
	
	public function action_import_payments()
	{
    	print "hi";
	}
	
	
	
	
	
	public function action_test_log()
	{
		
		$lead_details = array(
			'title'			=> 'Mr',
			'first_name' 	=> 'Simon',
			'surname'		=> 'Skinner',
			'address'		=> '115 Argosy Avenue',
			'area'			=> 'Layton',
			'town'			=> 'Blackpool',
			'postcode'		=> 'FY37NG',
			'telephone'		=> '7515879426',
			'list_id'		=> '145',
		);
		
		
		$dupe_check = GAB\Debtsolv::check_for_duplicate(
			$lead_details['surname'], 
			$lead_details['address'], 
			$lead_details['postcode'], 
			$lead_details['telephone']
		);
		
		if ( !$dupe_check['found'] || ($dupe_check['found'] && $dupe_check['location']=='leadpool') )
		{
			// No client found in debtsolv or the client was found in leadpool
			// Create the lead
			$lead_creation = GAB\Debtsolv::create_lead(
				$lead_details['title'], 
				$lead_details['first_name'], 
				$lead_details['surname'], 
				$lead_details['address'], 
				$lead_details['area'], 
				$lead_details['town'], 
				$lead_details['postcode']
			);
			
			if ($lead_creation['created'])
			{
				// Lead was created
				
				$campaign_contact = GAB\Debtsolv::create_campaign_contact_id(
					$lead_creation['client_id'], 
					"Test Comment"
				);
				
				if ($campaign_contact['created'])
				{
					$insert_lead_details = GAB\Debtsolv::insert_lead_details(
						$lead_creation['client_id'],
						$lead_details['list_id'],
						"GAB"
					);
					
					print_r($insert_lead_details);
					
				}
				else
				{
					// Campaign Contact was not created
				
					$this->response(
						array(
							'result' 	=> 'fail',
							'code' 		=> 103,
							'message' 	=> "Campaign Contact ID was not created!",
						)
					);
				}
				
				
			}
			else 
			{
				// Lead was not created
				
				$this->response(
					array(
						'result' 	=> 'fail',
						'code' 		=> 102,
						'message' 	=> "Lead was not created!",
					)
				);
				
			}
			
		}
		else
		{
			// Client already in Debtsolv
			$this->response(
				array(
					'result' 	=> 'fail',
					'code' 		=> 101,
					'message' 	=> "This client is already in Debtsolv!",
				)
			);
			
		}
		
			
	}

}
