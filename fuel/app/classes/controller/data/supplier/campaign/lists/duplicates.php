<?php
class Controller_Data_Supplier_Campaign_Lists_Duplicates extends Controller_Base 
{

	public function action_index()
	{
		$data['data_supplier_campaign_lists_duplicates'] = Model_Data_Supplier_Campaign_Lists_Duplicate::find('all');
		$this->template->title = "Data_supplier_campaign_lists_duplicates";
		$this->template->content = View::forge('data/supplier/campaign/lists/duplicates/index', $data);

	}

	public function action_view($id = null)
	{
		$data['data_supplier_campaign_lists_duplicate'] = Model_Data_Supplier_Campaign_Lists_Duplicate::find($id);

		is_null($id) and Response::redirect('Data_Supplier_Campaign_Lists_Duplicates');

		$this->template->title = "Data_supplier_campaign_lists_duplicate";
		$this->template->content = View::forge('data/supplier/campaign/lists/duplicates/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
		
			$config = array(
			    'path' => DOCROOT.DS.'files',
			    'randomize' => true,
			    'ext_whitelist' => array('txt'),
			);
			
			Upload::process($config);
			
			if (Upload::is_valid())
			{
				$file = Upload::get_files(0);
				$contents = File::read($file['file'],true);
				
					
				foreach(explode("\n", $contents) as $line) {
					
					if (preg_match('/record [0-9]+ BAD- PHONE: ([0-9]+) ROW: \|[0-9]+\| DUP: [0-9] [0-9]+/i', $line, $matches))
					{
						$all_dupes[] = $matches[1];
					}
										
					
				}
				
				
				$dupe_check = \Goautodial\Insert::duplicate_check($all_dupes);
				
				
				foreach ($dupe_check AS $dupe_number => $dupe_details)
				{
					
					$new_duplicate = new Model_Data_Supplier_Campaign_Lists_Duplicate();
					
					$new_duplicate->list_id = Input::post('list_id');
					$new_duplicate->database_server_id = Input::post('database_server_id');
					$new_duplicate->duplicate_number = $dupe_number;
					$new_duplicate->dialler = $dupe_details['dialler'];
					$new_duplicate->lead_id = $dupe_details['data']['lead_id'];

					$new_duplicate->save();
					
				}
				
				
				
			} 
			else 
			{
				print "No Uploads";
			}
			
		}

		$this->template->title = "Data_Supplier_Campaign_Lists_Duplicates";
		$this->template->content = View::forge('data/supplier/campaign/lists/duplicates/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Data_Supplier_Campaign_Lists_Duplicates');

		$data_supplier_campaign_lists_duplicate = Model_Data_Supplier_Campaign_Lists_Duplicate::find($id);

		$val = Model_Data_Supplier_Campaign_Lists_Duplicate::validate('edit');

		if ($val->run())
		{
			$data_supplier_campaign_lists_duplicate->list_id = Input::post('list_id');
			$data_supplier_campaign_lists_duplicate->database_server_id = Input::post('database_server_id');
			$data_supplier_campaign_lists_duplicate->duplicate_number = Input::post('duplicate_number');

			if ($data_supplier_campaign_lists_duplicate->save())
			{
				Session::set_flash('success', 'Updated data_supplier_campaign_lists_duplicate #' . $id);

				Response::redirect('data/supplier/campaign/lists/duplicates');
			}

			else
			{
				Session::set_flash('error', 'Could not update data_supplier_campaign_lists_duplicate #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$data_supplier_campaign_lists_duplicate->list_id = $val->validated('list_id');
				$data_supplier_campaign_lists_duplicate->database_server_id = $val->validated('database_server_id');
				$data_supplier_campaign_lists_duplicate->duplicate_number = $val->validated('duplicate_number');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('data_supplier_campaign_lists_duplicate', $data_supplier_campaign_lists_duplicate, false);
		}

		$this->template->title = "Data_supplier_campaign_lists_duplicates";
		$this->template->content = View::forge('data/supplier/campaign/lists/duplicates/edit');

	}

	public function action_delete($id = null)
	{
		if ($data_supplier_campaign_lists_duplicate = Model_Data_Supplier_Campaign_Lists_Duplicate::find($id))
		{
			$data_supplier_campaign_lists_duplicate->delete();

			Session::set_flash('success', 'Deleted data_supplier_campaign_lists_duplicate #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete data_supplier_campaign_lists_duplicate #'.$id);
		}

		Response::redirect('data/supplier/campaign/lists/duplicates');

	}


}