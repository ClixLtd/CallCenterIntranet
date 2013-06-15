<?php
class Controller_Survey_Lead_Suppliers extends Controller_Template 
{

	public function action_index()
	{
		$data['survey_lead_suppliers'] = Model_Survey_Lead_Supplier::find('all');
		$this->template->title = "Survey_lead_suppliers";
		$this->template->content = View::forge('survey/lead/suppliers/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Suppliers');

		if ( ! $data['survey_lead_supplier'] = Model_Survey_Lead_Supplier::find($id))
		{
			Session::set_flash('error', 'Could not find survey_lead_supplier #'.$id);
			Response::redirect('Survey_Lead_Suppliers');
		}

		$this->template->title = "Survey_lead_supplier";
		$this->template->content = View::forge('survey/lead/suppliers/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Survey_Lead_Supplier::validate('create');
			
			if ($val->run())
			{
				$survey_lead_supplier = Model_Survey_Lead_Supplier::forge(array(
					'name' => Input::post('name'),
					'email' => Input::post('email'),
					'key' => Input::post('key'),
				));

				if ($survey_lead_supplier and $survey_lead_supplier->save())
				{
					Session::set_flash('success', 'Added survey_lead_supplier #'.$survey_lead_supplier->id.'.');

					Response::redirect('survey/lead/suppliers');
				}

				else
				{
					Session::set_flash('error', 'Could not save survey_lead_supplier.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Survey_Lead_Suppliers";
		$this->template->content = View::forge('survey/lead/suppliers/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Suppliers');

		if ( ! $survey_lead_supplier = Model_Survey_Lead_Supplier::find($id))
		{
			Session::set_flash('error', 'Could not find survey_lead_supplier #'.$id);
			Response::redirect('Survey_Lead_Suppliers');
		}

		$val = Model_Survey_Lead_Supplier::validate('edit');

		if ($val->run())
		{
			$survey_lead_supplier->name = Input::post('name');
			$survey_lead_supplier->email = Input::post('email');
			$survey_lead_supplier->key = Input::post('key');

			if ($survey_lead_supplier->save())
			{
				Session::set_flash('success', 'Updated survey_lead_supplier #' . $id);

				Response::redirect('survey/lead/suppliers');
			}

			else
			{
				Session::set_flash('error', 'Could not update survey_lead_supplier #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$survey_lead_supplier->name = $val->validated('name');
				$survey_lead_supplier->email = $val->validated('email');
				$survey_lead_supplier->key = $val->validated('key');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('survey_lead_supplier', $survey_lead_supplier, false);
		}

		$this->template->title = "Survey_lead_suppliers";
		$this->template->content = View::forge('survey/lead/suppliers/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Suppliers');

		if ($survey_lead_supplier = Model_Survey_Lead_Supplier::find($id))
		{
			$survey_lead_supplier->delete();

			Session::set_flash('success', 'Deleted survey_lead_supplier #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete survey_lead_supplier #'.$id);
		}

		Response::redirect('survey/lead/suppliers');

	}


}