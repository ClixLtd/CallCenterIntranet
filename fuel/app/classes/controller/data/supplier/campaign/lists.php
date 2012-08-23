<?php
class Controller_Data_Supplier_Campaign_Lists extends Controller_Base 
{

	public function action_index()
	{
		$data['data_supplier_campaign_lists'] = Model_Data_Supplier_Campaign_List::find('all');
		$this->template->title = "Data_supplier_campaign_lists";
		$this->template->content = View::forge('data/supplier/campaign/lists/index', $data);

	}

	public function action_view($id = null)
	{
		$data['data_supplier_campaign_list'] = Model_Data_Supplier_Campaign_List::find($id);

		is_null($id) and Response::redirect('Data_Supplier_Campaign_Lists');

		$this->template->title = "Data_supplier_campaign_list";
		$this->template->content = View::forge('data/supplier/campaign/lists/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Data_Supplier_Campaign_List::validate('create');
			
			if ($val->run())
			{
				$data_supplier_campaign_list = Model_Data_Supplier_Campaign_List::forge(array(
					'data_supplier_campaign_id' => Input::post('data_supplier_campaign_id'),
					'list_id' => Input::post('list_id'),
					'database_server_id' => Input::post('database_server_id'),
				));

				if ($data_supplier_campaign_list and $data_supplier_campaign_list->save())
				{
					Session::set_flash('success', 'Added data_supplier_campaign_list #'.$data_supplier_campaign_list->id.'.');

					Response::redirect('data/supplier/campaign/lists');
				}

				else
				{
					Session::set_flash('error', 'Could not save data_supplier_campaign_list.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Data_Supplier_Campaign_Lists";
		$this->template->content = View::forge('data/supplier/campaign/lists/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Data_Supplier_Campaign_Lists');

		$data_supplier_campaign_list = Model_Data_Supplier_Campaign_List::find($id);

		$val = Model_Data_Supplier_Campaign_List::validate('edit');

		if ($val->run())
		{
			$data_supplier_campaign_list->data_supplier_campaign_id = Input::post('data_supplier_campaign_id');
			$data_supplier_campaign_list->list_id = Input::post('list_id');
			$data_supplier_campaign_list->database_server_id = Input::post('database_server_id');

			if ($data_supplier_campaign_list->save())
			{
				Session::set_flash('success', 'Updated data_supplier_campaign_list #' . $id);

				Response::redirect('data/supplier/campaign/lists');
			}

			else
			{
				Session::set_flash('error', 'Could not update data_supplier_campaign_list #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$data_supplier_campaign_list->data_supplier_campaign_id = $val->validated('data_supplier_campaign_id');
				$data_supplier_campaign_list->list_id = $val->validated('list_id');
				$data_supplier_campaign_list->database_server_id = $val->validated('database_server_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('data_supplier_campaign_list', $data_supplier_campaign_list, false);
		}

		$this->template->title = "Data_supplier_campaign_lists";
		$this->template->content = View::forge('data/supplier/campaign/lists/edit');

	}

	public function action_delete($id = null)
	{
		if ($data_supplier_campaign_list = Model_Data_Supplier_Campaign_List::find($id))
		{
			$data_supplier_campaign_list->delete();

			Session::set_flash('success', 'Deleted data_supplier_campaign_list #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete data_supplier_campaign_list #'.$id);
		}

		Response::redirect('data/supplier/campaign/lists');

	}


}