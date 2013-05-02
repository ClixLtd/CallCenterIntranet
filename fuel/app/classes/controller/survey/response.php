<?php
class Controller_Survey_Response extends Controller_Template 
{

	public function action_index()
	{
		$data['survey_responses'] = Model_Survey_Response::find('all');
		$this->template->title = "Survey_responses";
		$this->template->content = View::forge('survey/response/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Survey_Response');

		if ( ! $data['survey_response'] = Model_Survey_Response::find($id))
		{
			Session::set_flash('error', 'Could not find survey_response #'.$id);
			Response::redirect('Survey_Response');
		}

		$this->template->title = "Survey_response";
		$this->template->content = View::forge('survey/response/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Survey_Response::validate('create');
			
			if ($val->run())
			{
				$survey_response = Model_Survey_Response::forge(array(
					'reference' => Input::post('reference'),
					'question_id' => Input::post('question_id'),
					'answer_id' => Input::post('answer_id'),
					'extra' => Input::post('extra'),
				));

				if ($survey_response and $survey_response->save())
				{
					Session::set_flash('success', 'Added survey_response #'.$survey_response->id.'.');

					Response::redirect('survey/response');
				}

				else
				{
					Session::set_flash('error', 'Could not save survey_response.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Survey_Responses";
		$this->template->content = View::forge('survey/response/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Survey_Response');

		if ( ! $survey_response = Model_Survey_Response::find($id))
		{
			Session::set_flash('error', 'Could not find survey_response #'.$id);
			Response::redirect('Survey_Response');
		}

		$val = Model_Survey_Response::validate('edit');

		if ($val->run())
		{
			$survey_response->reference = Input::post('reference');
			$survey_response->question_id = Input::post('question_id');
			$survey_response->answer_id = Input::post('answer_id');
			$survey_response->extra = Input::post('extra');

			if ($survey_response->save())
			{
				Session::set_flash('success', 'Updated survey_response #' . $id);

				Response::redirect('survey/response');
			}

			else
			{
				Session::set_flash('error', 'Could not update survey_response #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$survey_response->reference = $val->validated('reference');
				$survey_response->question_id = $val->validated('question_id');
				$survey_response->answer_id = $val->validated('answer_id');
				$survey_response->extra = $val->validated('extra');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('survey_response', $survey_response, false);
		}

		$this->template->title = "Survey_responses";
		$this->template->content = View::forge('survey/response/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Survey_Response');

		if ($survey_response = Model_Survey_Response::find($id))
		{
			$survey_response->delete();

			Session::set_flash('success', 'Deleted survey_response #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete survey_response #'.$id);
		}

		Response::redirect('survey/response');

	}


}