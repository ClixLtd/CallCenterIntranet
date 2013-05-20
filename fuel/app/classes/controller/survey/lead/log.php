<?php
class Controller_Survey_Lead_Log extends Controller_Template 
{

	public function action_index()
	{
		$data['survey_lead_logs'] = Model_Survey_Lead_Log::find('all');
		$this->template->title = "Survey_lead_logs";
		$this->template->content = View::forge('survey/lead/log/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Log');

		if ( ! $data['survey_lead_log'] = Model_Survey_Lead_Log::find($id))
		{
			Session::set_flash('error', 'Could not find survey_lead_log #'.$id);
			Response::redirect('Survey_Lead_Log');
		}

		$this->template->title = "Survey_lead_log";
		$this->template->content = View::forge('survey/lead/log/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Survey_Lead_Log::validate('create');
			
			if ($val->run())
			{
				$survey_lead_log = Model_Survey_Lead_Log::forge(array(
					'referral_id' => Input::post('referral_id'),
					'batch_id' => Input::post('batch_id'),
				));

				if ($survey_lead_log and $survey_lead_log->save())
				{
					Session::set_flash('success', 'Added survey_lead_log #'.$survey_lead_log->id.'.');

					Response::redirect('survey/lead/log');
				}

				else
				{
					Session::set_flash('error', 'Could not save survey_lead_log.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Survey_Lead_Logs";
		$this->template->content = View::forge('survey/lead/log/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Log');

		if ( ! $survey_lead_log = Model_Survey_Lead_Log::find($id))
		{
			Session::set_flash('error', 'Could not find survey_lead_log #'.$id);
			Response::redirect('Survey_Lead_Log');
		}

		$val = Model_Survey_Lead_Log::validate('edit');

		if ($val->run())
		{
			$survey_lead_log->referral_id = Input::post('referral_id');
			$survey_lead_log->batch_id = Input::post('batch_id');

			if ($survey_lead_log->save())
			{
				Session::set_flash('success', 'Updated survey_lead_log #' . $id);

				Response::redirect('survey/lead/log');
			}

			else
			{
				Session::set_flash('error', 'Could not update survey_lead_log #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$survey_lead_log->referral_id = $val->validated('referral_id');
				$survey_lead_log->batch_id = $val->validated('batch_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('survey_lead_log', $survey_lead_log, false);
		}

		$this->template->title = "Survey_lead_logs";
		$this->template->content = View::forge('survey/lead/log/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Survey_Lead_Log');

		if ($survey_lead_log = Model_Survey_Lead_Log::find($id))
		{
			$survey_lead_log->delete();

			Session::set_flash('success', 'Deleted survey_lead_log #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete survey_lead_log #'.$id);
		}

		Response::redirect('survey/lead/log');

	}


}