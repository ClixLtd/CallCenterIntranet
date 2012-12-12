<?php


class Controller_Ppi_Api extends PPIApi\Controller_Report_Rest
{
	
	
	/**
	 * Submit function.
	 * Used to submit data to the API. Must be called through POST not GET
	 *
	 * @access public
	 * @return void
	 */
	public function get_submit()
	{
		$this->response(array(
			'status' => 'FAIL',
			'message' => 'You cannot use GET to request this function. You must POST!',
		));
	}
	
	public function post_submit($apikey=null)
	{
		
		if (PPIApi\PPI::check_api_key($apikey))
		{
			
			$allFields = TRUE;
			$missingFields = array();
			$requiredFields = array(
				'title',
				'firstname',
				'lastname',
				'address1',
				'town',
				'county',
			);
			
			// Check and make a list of any missing fields
			foreach ($requiredFields AS $field)
			{
				if (is_null(Input::post($field, null)) || strlen(Input::post($field, null)) <= 1 )
				{
					$allFields = FALSE;
					$missingFields[] = $field;
				}
			}
			
			// If we have everything we need then we do our logic
			if ( $allFields )
			{
				// Get the client type from the given questions
				$clientType = PPIApi\PPI::client_type(array(
					'question1' => Input::post('question1', null),
				));
			
				// If we can decide on a client type
				if (!is_null($clientType))
				{
					$this->response(array(
						'client_type' => $clientType,
					));
				}
				else
				{
					$this->response(array(
						'status' => 'FAIL',
						'message' => 'No client type could be decided. Please complete ALL the given questions.',
					));
				}
			
			}
			else
			{
				$this->response(array(
					'status'         => 'FAIL',
					'code'           => '101',
					'message'        => 'Not all required fields were submitted! Missing fields are ' . implode(", ", $missingFields),
					'missing_fields' => $missingFields,
				));
			}
		}
		else
		{
			// API Key is invalid
			$this->response(array(
				'status'         => 'FAIL',
				'code'           => '100',
				'message'        => 'The API key given is not valid!',
			));
		}
	
	}
	

		
	
	
	
	

	public function action_index()
	{
		$this->response(array(
			'test' => 'Hello',
		));
	}

}