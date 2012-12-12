<?php
class Controller_Lead_Table extends Controller_Base 
{

	public function action_index()
	{
		$data['lead_tables'] = Model_Lead_Table::find('all');
		$this->template->title = "Lead_tables";
		$this->template->content = View::forge('lead/table/index', $data);

	}

	public function action_view($id = null)
	{
		$data['lead_table'] = Model_Lead_Table::find($id);

		is_null($id) and Response::redirect('Lead_Table');

		$this->template->title = "Lead_table";
		$this->template->content = View::forge('lead/table/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			
			$config = array(
			    'path' => DOCROOT.DS.'files',
			    'randomize' => true,
			    'ext_whitelist' => array('csv'),
			);
			
			Upload::process($config);
		
			// Get the uploaded file and open it
			if (Upload::is_valid())
			{
				$file = Upload::get_files(0);
				$contents = File::read($file['file'],true);
		
				// create an array of the CSV
				
				$found_duplicates = array();
				$duplicate_check = array();
				$headings_csv = array();
				$file_csv = array();
				$i = 0;
				$duplicate_check_count = 0;
				foreach(explode("\n", $contents) as $line) {
					$item = array();
					if ($i == 0)
					{
						$headings_csv = str_getcsv($line);
					}
					else
					{
						foreach (str_getcsv($line) AS $key => $content)
						{
							$item[$headings_csv[$key]] = $content;
							if (strlen($content) > 6 AND ($headings_csv[$key] == "phone_number" || $headings_csv[$key] == "alt_phone"))
							{
								$duplicate_check[] = $content;
							}
						}
						$file_csv[] = $item;
					}
					
					$duplicate_check_count++;
					if ($duplicate_check_count == 50000)
					{
						// Pull the current duplicates from the diallers to avoid max limit
						$duplicate_temp = \Goautodial\Insert::duplicate_check($duplicate_check);
						
						$found_duplicates = $found_duplicates + $duplicate_temp;
						
						$duplicate_check = array();
						$duplicate_temp = null;
						$duplicate_check_count = 0;
					}
					$i++;
				}
				
				
				// Check for duplicates
				$duplicate_temp = \Goautodial\Insert::duplicate_check($duplicate_check);
				$found_duplicates = $found_duplicates + $duplicate_temp;
				
				foreach ($file_csv AS $lead)
				{
					$phonenumber = (isset($lead['phone_number'])) ? $lead['phone_number'] : '';
					$altphone = (isset($lead['alt_phone'])) ? $lead['alt_phone'] : '';
					
					if (!isset($found_duplicates[$phonenumber]) AND !isset($found_duplicates[$altphone]))
					{
						$lead_table         = Model_Lead_Table::forge(array(
							'phone_number'    => (isset($lead['phone_number'])) ? $lead['phone_number'] : '',
							'title'           => (isset($lead['title'])) ? $lead['title'] : '',
							'first_name'      => (isset($lead['first_name'])) ? $lead['first_name'] : '',
							'middle_initial'  => (isset($lead['middle_initial'])) ? $lead['middle_initial'] : '',
							'last_name'       => (isset($lead['last_name'])) ? $lead['last_name'] : '',
							'address1'        => (isset($lead['address1'])) ? $lead['address1'] : '',
							'address2'        => (isset($lead['address2'])) ? $lead['address2'] : '',
							'address3'        => (isset($lead['address3'])) ? $lead['address3'] : '',
							'city'            => (isset($lead['city'])) ? $lead['city'] : '',
							'state'           => (isset($lead['state'])) ? $lead['state'] : '',
							'province'        => (isset($lead['province'])) ? $lead['province'] : '',
							'postal_code'     => (isset($lead['postal_code'])) ? $lead['postal_code'] : '',
							'country_code'    => (isset($lead['country_code'])) ? $lead['country_code'] : '',
							'gender'          => (isset($lead['gender'])) ? $lead['gender'] : '',
							'date_of_birth'   => (isset($lead['date_of_birth'])) ? $lead['date_of_birth'] : '',
							'alt_phone'       => (isset($lead['alt_phone'])) ? $lead['alt_phone'] : '',
							'email'           => (isset($lead['email'])) ? $lead['email'] : '',
							'security_phrase' => (isset($lead['security_phrase'])) ? $lead['security_phrase'] : '',
							'comments'        => (isset($lead['comments'])) ? $lead['comments'] : '',
						));
						$lead_table->save();
					} 
					else
					{
						$dupe = (isset($found_duplicates[$phonenumber])) ? $found_duplicates[$phonenumber] : $found_duplicates[$altphone];
						
						$lead_dupe = Model_Data_Supplier_Campaign_Lists_Duplicate::forge(array(
							'list_id' => Input::post('list_id'),
							'database_server_id' => 999,
							'duplicate_number' => ($phonenumber <> '') ? $phonenumber : $altphone,
							'dialler' => $dupe['dialler'],
							'lead_id' => ($dupe['dialler'] == 999) ? 999 : $dupe['data']['lead_id'],
						));
						
						$lead_dupe->save();
					}
				}
				
				
				/*
				$val = Model_Lead_Table::validate('create');
			
				if ($val->run())
				{
					$lead_table = Model_Lead_Table::forge(array(
						'phone_number' => Input::post('phone_number'),
						'title' => Input::post('title'),
						'first_name' => Input::post('first_name'),
						'middle_initial' => Input::post('middle_initial'),
						'last_name' => Input::post('last_name'),
						'address1' => Input::post('address1'),
						'address2' => Input::post('address2'),
						'address3' => Input::post('address3'),
						'city' => Input::post('city'),
						'state' => Input::post('state'),
						'province' => Input::post('province'),
						'postal_code' => Input::post('postal_code'),
						'country_code' => Input::post('country_code'),
						'gender' => Input::post('gender'),
						'date_of_birth' => Input::post('date_of_birth'),
						'alt_phone' => Input::post('alt_phone'),
						'email' => Input::post('email'),
						'security_phrase' => Input::post('security_phrase'),
						'comments' => Input::post('comments'),
					));
	
					if ($lead_table and $lead_table->save())
					{
						Session::set_flash('success', 'Added lead_table #'.$lead_table->id.'.');
	
						Response::redirect('lead/table');
					}
	
					else
					{
						Session::set_flash('error', 'Could not save lead_table.');
					}
				}
				else
				{
					Session::set_flash('error', $val->error());
				}
				
				*/
		
		
			}
		
			
		}

		$this->template->title = "Lead_Tables";
		$this->template->content = View::forge('lead/table/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Lead_Table');

		$lead_table = Model_Lead_Table::find($id);

		$val = Model_Lead_Table::validate('edit');

		if ($val->run())
		{
			$lead_table->phone_number = Input::post('phone_number');
			$lead_table->title = Input::post('title');
			$lead_table->first_name = Input::post('first_name');
			$lead_table->middle_initial = Input::post('middle_initial');
			$lead_table->last_name = Input::post('last_name');
			$lead_table->address1 = Input::post('address1');
			$lead_table->address2 = Input::post('address2');
			$lead_table->address3 = Input::post('address3');
			$lead_table->city = Input::post('city');
			$lead_table->state = Input::post('state');
			$lead_table->province = Input::post('province');
			$lead_table->postal_code = Input::post('postal_code');
			$lead_table->country_code = Input::post('country_code');
			$lead_table->gender = Input::post('gender');
			$lead_table->date_of_birth = Input::post('date_of_birth');
			$lead_table->alt_phone = Input::post('alt_phone');
			$lead_table->email = Input::post('email');
			$lead_table->security_phrase = Input::post('security_phrase');
			$lead_table->comments = Input::post('comments');

			if ($lead_table->save())
			{
				Session::set_flash('success', 'Updated lead_table #' . $id);

				Response::redirect('lead/table');
			}

			else
			{
				Session::set_flash('error', 'Could not update lead_table #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$lead_table->phone_number = $val->validated('phone_number');
				$lead_table->title = $val->validated('title');
				$lead_table->first_name = $val->validated('first_name');
				$lead_table->middle_initial = $val->validated('middle_initial');
				$lead_table->last_name = $val->validated('last_name');
				$lead_table->address1 = $val->validated('address1');
				$lead_table->address2 = $val->validated('address2');
				$lead_table->address3 = $val->validated('address3');
				$lead_table->city = $val->validated('city');
				$lead_table->state = $val->validated('state');
				$lead_table->province = $val->validated('province');
				$lead_table->postal_code = $val->validated('postal_code');
				$lead_table->country_code = $val->validated('country_code');
				$lead_table->gender = $val->validated('gender');
				$lead_table->date_of_birth = $val->validated('date_of_birth');
				$lead_table->alt_phone = $val->validated('alt_phone');
				$lead_table->email = $val->validated('email');
				$lead_table->security_phrase = $val->validated('security_phrase');
				$lead_table->comments = $val->validated('comments');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('lead_table', $lead_table, false);
		}

		$this->template->title = "Lead_tables";
		$this->template->content = View::forge('lead/table/edit');

	}

	public function action_delete($id = null)
	{
		if ($lead_table = Model_Lead_Table::find($id))
		{
			$lead_table->delete();

			Session::set_flash('success', 'Deleted lead_table #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete lead_table #'.$id);
		}

		Response::redirect('lead/table');

	}


}