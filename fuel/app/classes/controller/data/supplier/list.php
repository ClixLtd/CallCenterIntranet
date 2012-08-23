<?php
class Controller_Data_Supplier_List extends Controller_Base 
{

	public function action_index()
	{
		$data['data_supplier_lists'] = Model_Data_Supplier_List::find('all');
		$this->template->title = "Data_supplier_lists";
		$this->template->content = View::forge('data/supplier/list/index', $data);

	}

	public function action_view($id = null)
	{
		$data['data_supplier_list'] = Model_Data_Supplier_List::find($id);

		is_null($id) and Response::redirect('Data_Supplier_List');

		$this->template->title = "Data_supplier_list";
		$this->template->content = View::forge('data/supplier/list/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Data_Supplier_List::validate('create');
			
			if ($val->run())
			{
				$data_supplier_list = Model_Data_Supplier_List::forge(array(
					'data_supplier_id' => Input::post('data_supplier_id'),
					'title' => Input::post('title'),
					'datafile' => Input::post('datafile'),
					'cost' => Input::post('cost'),
					'total_leads' => Input::post('total_leads'),
				));

				if ($data_supplier_list and $data_supplier_list->save())
				{
					Session::set_flash('success', 'Added data_supplier_list #'.$data_supplier_list->id.'.');

					Response::redirect('data/supplier/list');
				}

				else
				{
					Session::set_flash('error', 'Could not save data_supplier_list.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
		
		$this->template->set_global('data_suppliers', Arr::assoc_to_keyval(Model_Data_supplier::find('all'),'id','company_name'), false);
		
		$this->template->title = "Data_Supplier_Lists";
		$this->template->content = View::forge('data/supplier/list/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Data_Supplier_List');

		$data_supplier_list = Model_Data_Supplier_List::find($id);

		$val = Model_Data_Supplier_List::validate('edit');

		if ($val->run())
		{
			$data_supplier_list->data_supplier_id = Input::post('data_supplier_id');
			$data_supplier_list->title = Input::post('title');
			$data_supplier_list->datafile = Input::post('datafile');
			$data_supplier_list->cost = Input::post('cost');
			$data_supplier_list->total_leads = Input::post('total_leads');

			if ($data_supplier_list->save())
			{
				Session::set_flash('success', 'Updated data_supplier_list #' . $id);

				Response::redirect('data/supplier/list');
			}

			else
			{
				Session::set_flash('error', 'Could not update data_supplier_list #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$data_supplier_list->data_supplier_id = $val->validated('data_supplier_id');
				$data_supplier_list->title = $val->validated('title');
				$data_supplier_list->datafile = $val->validated('datafile');
				$data_supplier_list->cost = $val->validated('cost');
				$data_supplier_list->total_leads = $val->validated('total_leads');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('data_supplier_list', $data_supplier_list, false);
		}

		$this->template->set_global('data_suppliers', Arr::assoc_to_keyval(Model_Data_supplier::find('all'),'id','company_name'), false);
		
		$this->template->title = "Data_supplier_lists";
		$this->template->content = View::forge('data/supplier/list/edit');

	}

	public function action_delete($id = null)
	{
		if ($data_supplier_list = Model_Data_Supplier_List::find($id))
		{
			$data_supplier_list->delete();

			Session::set_flash('success', 'Deleted data_supplier_list #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete data_supplier_list #'.$id);
		}

		Response::redirect('data/supplier/list');

	}


}