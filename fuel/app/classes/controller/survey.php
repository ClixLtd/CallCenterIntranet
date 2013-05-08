<?php
class Controller_Survey extends Controller_Template 
{

	public function action_index()
	{
		$data['surveys'] = Model_Survey::find('all');
		$this->template->title = "Surveys";
		$this->template->content = View::forge('survey/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Survey');

		if ( ! $data['survey'] = Model_Survey::find($id))
		{
			Session::set_flash('error', 'Could not find survey #'.$id);
			Response::redirect('Survey');
		}

		$this->template->title = "Survey";
		$this->template->content = View::forge('survey/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Survey::validate('create');
			
			if ($val->run())
			{
				$survey = Model_Survey::forge(array(
					'title' => Input::post('title'),
					'description' => Input::post('description'),
					'type' => Input::post('type'),
				));

				if ($survey and $survey->save())
				{
					Session::set_flash('success', 'Added survey #'.$survey->id.'.');

					Response::redirect('survey');
				}

				else
				{
					Session::set_flash('error', 'Could not save survey.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Surveys";
		$this->template->content = View::forge('survey/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Survey');

		if ( ! $survey = Model_Survey::find($id))
		{
			Session::set_flash('error', 'Could not find survey #'.$id);
			Response::redirect('Survey');
		}

		$val = Model_Survey::validate('edit');

		if ($val->run())
		{
			$survey->title = Input::post('title');
			$survey->description = Input::post('description');
			$survey->type = Input::post('type');

			if ($survey->save())
			{
				Session::set_flash('success', 'Updated survey #' . $id);

				Response::redirect('survey');
			}

			else
			{
				Session::set_flash('error', 'Could not update survey #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$survey->title = $val->validated('title');
				$survey->description = $val->validated('description');
				$survey->type = $val->validated('type');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('survey', $survey, false);
		}

		$this->template->title = "Surveys";
		$this->template->content = View::forge('survey/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('Survey');

		if ($survey = Model_Survey::find($id))
		{
			$survey->delete();

			Session::set_flash('success', 'Deleted survey #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete survey #'.$id);
		}

		Response::redirect('survey');

	}


}