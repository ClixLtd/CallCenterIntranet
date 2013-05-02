<?php
class Controller_Survey_Question_Answer extends Controller_Template 
{

	public function action_index()
	{
		$data['survey_question_answers'] = Model_Survey_Question_Answer::find('all');
		$this->template->title = "Survey_question_answers";
		$this->template->content = View::forge('survey/question/answer/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Survey_Question_Answer');

		if ( ! $data['survey_question_answer'] = Model_Survey_Question_Answer::find($id))
		{
			Session::set_flash('error', 'Could not find survey_question_answer #'.$id);
			Response::redirect('Survey_Question_Answer');
		}

		$this->template->title = "Survey_question_answer";
		$this->template->content = View::forge('survey/question/answer/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Survey_Question_Answer::validate('create');
			
			if ($val->run())
			{
				$survey_question_answer = Model_Survey_Question_Answer::forge(array(
					'question_id' => Input::post('question_id'),
					'answer' => Input::post('answer'),
				));

				if ($survey_question_answer and $survey_question_answer->save())
				{
					Session::set_flash('success', 'Added survey_question_answer #'.$survey_question_answer->id.'.');

					Response::redirect('survey/question/answer');
				}

				else
				{
					Session::set_flash('error', 'Could not save survey_question_answer.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Survey_Question_Answers";
		$this->template->content = View::forge('survey/question/answer/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Survey_Question_Answer');

		if ( ! $survey_question_answer = Model_Survey_Question_Answer::find($id))
		{
			Session::set_flash('error', 'Could not find survey_question_answer #'.$id);
			Response::redirect('Survey_Question_Answer');
		}

		$val = Model_Survey_Question_Answer::validate('edit');

		if ($val->run())
		{
			$survey_question_answer->question_id = Input::post('question_id');
			$survey_question_answer->answer = Input::post('answer');

			if ($survey_question_answer->save())
			{
				Session::set_flash('success', 'Updated survey_question_answer #' . $id);

				Response::redirect('survey/question/answer');
			}

			else
			{
				Session::set_flash('error', 'Could not update survey_question_answer #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$survey_question_answer->question_id = $val->validated('question_id');
				$survey_question_answer->answer = $val->validated('answer');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('survey_question_answer', $survey_question_answer, false);
		}

		$this->template->title = "Survey_question_answers";
		$this->template->content = View::forge('survey/question/answer/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Survey_Question_Answer');

		if ($survey_question_answer = Model_Survey_Question_Answer::find($id))
		{
			$survey_question_answer->delete();

			Session::set_flash('success', 'Deleted survey_question_answer #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete survey_question_answer #'.$id);
		}

		Response::redirect('survey/question/answer');

	}


}