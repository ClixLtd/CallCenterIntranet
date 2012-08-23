<?php
class Controller_Data_Supplier_Campaign extends Controller_Base 
{

	public function action_index()
	{
		$data['data_supplier_campaigns'] = Model_Data_Supplier_Campaign::find('all');
		$this->template->title = "Data_supplier_campaigns";
		$this->template->content = View::forge('data/supplier/campaign/index', $data);

	}

	public function action_view($id = null)
	{
		$data['data_supplier_campaign'] = Model_Data_Supplier_Campaign::find($id);

		is_null($id) and Response::redirect('Data_Supplier_Campaign');

		$this->template->title = "Data_supplier_campaign";
		$this->template->content = View::forge('data/supplier/campaign/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Data_Supplier_Campaign::validate('create');
			
			if ($val->run())
			{
				$data_supplier_campaign = Model_Data_Supplier_Campaign::forge(array(
					'data_supplier_id' => Input::post('data_supplier_id'),
					'title' => Input::post('title'),
					'description' => Input::post('description'),
				));

				if ($data_supplier_campaign and $data_supplier_campaign->save())
				{
					Session::set_flash('success', 'Added data_supplier_campaign #'.$data_supplier_campaign->id.'.');

					Response::redirect('data/supplier/campaign');
				}

				else
				{
					Session::set_flash('error', 'Could not save data_supplier_campaign.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Data_Supplier_Campaigns";
		$this->template->content = View::forge('data/supplier/campaign/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Data_Supplier_Campaign');

		$data_supplier_campaign = Model_Data_Supplier_Campaign::find($id);

		$val = Model_Data_Supplier_Campaign::validate('edit');

		if ($val->run())
		{
			$data_supplier_campaign->data_supplier_id = Input::post('data_supplier_id');
			$data_supplier_campaign->title = Input::post('title');
			$data_supplier_campaign->description = Input::post('description');

			if ($data_supplier_campaign->save())
			{
				Session::set_flash('success', 'Updated data_supplier_campaign #' . $id);

				Response::redirect('data/supplier/campaign');
			}

			else
			{
				Session::set_flash('error', 'Could not update data_supplier_campaign #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$data_supplier_campaign->data_supplier_id = $val->validated('data_supplier_id');
				$data_supplier_campaign->title = $val->validated('title');
				$data_supplier_campaign->description = $val->validated('description');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('data_supplier_campaign', $data_supplier_campaign, false);
		}

		$this->template->title = "Data_supplier_campaigns";
		$this->template->content = View::forge('data/supplier/campaign/edit');

	}

	public function action_delete($id = null)
	{
		if ($data_supplier_campaign = Model_Data_Supplier_Campaign::find($id))
		{
			$data_supplier_campaign->delete();

			Session::set_flash('success', 'Deleted data_supplier_campaign #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete data_supplier_campaign #'.$id);
		}

		Response::redirect('data/supplier/campaign');

	}


}