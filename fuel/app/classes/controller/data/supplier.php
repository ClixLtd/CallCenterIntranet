<?php
class Controller_Data_Supplier extends Controller_Base 
{

	public function action_index()
	{
		$data['data_suppliers'] = Model_Data_Supplier::find('all');
		$this->template->title = "Data_suppliers";
		$this->template->content = View::forge('data/supplier/index', $data);

	}

	public function action_view($id = null)
	{
		$data['data_supplier'] = Model_Data_Supplier::find($id);

		is_null($id) and Response::redirect('Data_Supplier');

		$this->template->title = "Data_supplier";
		$this->template->content = View::forge('data/supplier/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Data_Supplier::validate('create');
			
			if ($val->run())
			{
				$data_supplier = Model_Data_Supplier::forge(array(
					'company_name' => Input::post('company_name'),
					'contact_name' => Input::post('contact_name'),
					'contact_email' => Input::post('contact_email'),
					'contact_address' => Input::post('contact_address'),
					'web_address' => Input::post('web_address'),
					'telephone' => Input::post('telephone'),
					'mobile' => Input::post('mobile'),
					'fax' => Input::post('fax'),
				));

				if ($data_supplier and $data_supplier->save())
				{
					Session::set_flash('success', 'Added data_supplier #'.$data_supplier->id.'.');

					Response::redirect('data/supplier');
				}

				else
				{
					Session::set_flash('error', 'Could not save data_supplier.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Data_Suppliers";
		$this->template->content = View::forge('data/supplier/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Data_Supplier');

		$data_supplier = Model_Data_Supplier::find($id);

		$val = Model_Data_Supplier::validate('edit');

		if ($val->run())
		{
			$data_supplier->company_name = Input::post('company_name');
			$data_supplier->contact_name = Input::post('contact_name');
			$data_supplier->contact_email = Input::post('contact_email');
			$data_supplier->contact_address = Input::post('contact_address');
			$data_supplier->web_address = Input::post('web_address');
			$data_supplier->telephone = Input::post('telephone');
			$data_supplier->mobile = Input::post('mobile');
			$data_supplier->fax = Input::post('fax');

			if ($data_supplier->save())
			{
				Session::set_flash('success', 'Updated data_supplier #' . $id);

				Response::redirect('data/supplier');
			}

			else
			{
				Session::set_flash('error', 'Could not update data_supplier #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$data_supplier->company_name = $val->validated('company_name');
				$data_supplier->contact_name = $val->validated('contact_name');
				$data_supplier->contact_email = $val->validated('contact_email');
				$data_supplier->contact_address = $val->validated('contact_address');
				$data_supplier->web_address = $val->validated('web_address');
				$data_supplier->telephone = $val->validated('telephone');
				$data_supplier->mobile = $val->validated('mobile');
				$data_supplier->fax = $val->validated('fax');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('data_supplier', $data_supplier, false);
		}

		$this->template->title = "Data_suppliers";
		$this->template->content = View::forge('data/supplier/edit');

	}

	public function action_delete($id = null)
	{
		if ($data_supplier = Model_Data_Supplier::find($id))
		{
			$data_supplier->delete();

			Session::set_flash('success', 'Deleted data_supplier #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete data_supplier #'.$id);
		}

		Response::redirect('data/supplier');

	}


}