<?php
class Controller_Survey_Lead_Batches extends Controller_Template 
{

	public function action_index()
	{
		$data['survey_lead_batches'] = Model_Survey_Lead_Batch::find('all');
		$this->template->title = "Survey_lead_batches";
		$this->template->content = View::forge('survey/lead/batches/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Batches');

		if ( ! $data['survey_lead_batch'] = Model_Survey_Lead_Batch::find($id))
		{
			Session::set_flash('error', 'Could not find survey_lead_batch #'.$id);
			Response::redirect('Survey_Lead_Batches');
		}

		$this->template->title = "Survey_lead_batch";
		$this->template->content = View::forge('survey/lead/batches/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Survey_Lead_Batch::validate('create');
			
			if ($val->run())
			{
				$survey_lead_batch = Model_Survey_Lead_Batch::forge(array(
					'supplier_id' => Input::post('supplier_id'),
					'date_added' => Input::post('date_added'),
					'filename' => Input::post('filename'),
					'collected' => Input::post('collected'),
					'date_collected' => Input::post('date_collected'),
				));

				if ($survey_lead_batch and $survey_lead_batch->save())
				{
					Session::set_flash('success', 'Added survey_lead_batch #'.$survey_lead_batch->id.'.');

					Response::redirect('survey/lead/batches');
				}

				else
				{
					Session::set_flash('error', 'Could not save survey_lead_batch.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Survey_Lead_Batches";
		$this->template->content = View::forge('survey/lead/batches/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Batches');

		if ( ! $survey_lead_batch = Model_Survey_Lead_Batch::find($id))
		{
			Session::set_flash('error', 'Could not find survey_lead_batch #'.$id);
			Response::redirect('Survey_Lead_Batches');
		}

		$val = Model_Survey_Lead_Batch::validate('edit');

		if ($val->run())
		{
			$survey_lead_batch->supplier_id = Input::post('supplier_id');
			$survey_lead_batch->date_added = Input::post('date_added');
			$survey_lead_batch->filename = Input::post('filename');
			$survey_lead_batch->collected = Input::post('collected');
			$survey_lead_batch->date_collected = Input::post('date_collected');

			if ($survey_lead_batch->save())
			{
				Session::set_flash('success', 'Updated survey_lead_batch #' . $id);

				Response::redirect('survey/lead/batches');
			}

			else
			{
				Session::set_flash('error', 'Could not update survey_lead_batch #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$survey_lead_batch->supplier_id = $val->validated('supplier_id');
				$survey_lead_batch->date_added = $val->validated('date_added');
				$survey_lead_batch->filename = $val->validated('filename');
				$survey_lead_batch->collected = $val->validated('collected');
				$survey_lead_batch->date_collected = $val->validated('date_collected');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('survey_lead_batch', $survey_lead_batch, false);
		}

		$this->template->title = "Survey_lead_batches";
		$this->template->content = View::forge('survey/lead/batches/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Batches');

		if ($survey_lead_batch = Model_Survey_Lead_Batch::find($id))
		{
			$survey_lead_batch->delete();

			Session::set_flash('success', 'Deleted survey_lead_batch #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete survey_lead_batch #'.$id);
		}

		Response::redirect('survey/lead/batches');

	}


}