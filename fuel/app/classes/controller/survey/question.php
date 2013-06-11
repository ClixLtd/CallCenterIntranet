<?php
class Controller_Survey_Question extends Controller_Template 
{

	public function action_index()
	{
		$data['survey_questions'] = Model_Survey_Question::find('all');
		$this->template->title = "Survey_questions";
		$this->template->content = View::forge('survey/question/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Survey_Question');

		if ( ! $data['survey_question'] = Model_Survey_Question::find($id))
		{
			Session::set_flash('error', 'Could not find survey_question #'.$id);
			Response::redirect('Survey_Question');
		}

		$this->template->title = "Survey_question";
		$this->template->content = View::forge('survey/question/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Survey_Question::validate('create');
			
			if ($val->run())
			{
				$survey_question = Model_Survey_Question::forge(array(
					'survey_id' => Input::post('survey_id'),
					'question' => Input::post('question'),
					'order' => Input::post('order'),
				));

				if ($survey_question and $survey_question->save())
				{
					Session::set_flash('success', 'Added survey_question #'.$survey_question->id.'.');

					Response::redirect('survey/question');
				}

				else
				{
					Session::set_flash('error', 'Could not save survey_question.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Survey_Questions";
		$this->template->content = View::forge('survey/question/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Survey_Question');

		if ( ! $survey_question = Model_Survey_Question::find($id))
		{
			Session::set_flash('error', 'Could not find survey_question #'.$id);
			Response::redirect('Survey_Question');
		}

		$val = Model_Survey_Question::validate('edit');

		if ($val->run())
		{
			$survey_question->survey_id = Input::post('survey_id');
			$survey_question->question = Input::post('question');

			if ($survey_question->save())
			{
				Session::set_flash('success', 'Updated survey_question #' . $id);

				Response::redirect('survey/question');
			}

			else
			{
				Session::set_flash('error', 'Could not update survey_question #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$survey_question->survey_id = $val->validated('survey_id');
				$survey_question->question = $val->validated('question');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('survey_question', $survey_question, false);
		}

		$this->template->title = "Survey_questions";
		$this->template->content = View::forge('survey/question/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Survey_Question');

		if ($survey_question = Model_Survey_Question::find($id))
		{
			$survey_question->delete();

			Session::set_flash('success', 'Deleted survey_question #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete survey_question #'.$id);
		}

		Response::redirect('survey/question');

	}


}