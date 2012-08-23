<?php
class Controller_Help_Topic extends Controller_Base
{

	public function action_index()
	{
		$data['help_topics'] = Model_Help_Topic::find('all');
		$this->template->title = "Help_topics";
		$this->template->content = View::forge('help/topic/index', $data);

	}

	public function action_view($id = null)
	{
		$data['help_topic'] = Model_Help_Topic::find($id);

		is_null($id) and Response::redirect('Help_Topic');

		$this->template->title = "Help_topic";
		$this->template->content = View::forge('help/topic/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Help_Topic::validate('create');
			
			if ($val->run())
			{
				$help_topic = Model_Help_Topic::forge(array(
					'title' => Input::post('title'),
					'description' => Input::post('description'),
				));

				if ($help_topic and $help_topic->save())
				{
					Session::set_flash('success', 'Added help_topic #'.$help_topic->id.'.');

					Response::redirect('help/topic');
				}

				else
				{
					Session::set_flash('error', 'Could not save help_topic.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Help_Topics";
		$this->template->content = View::forge('help/topic/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Help_Topic');

		$help_topic = Model_Help_Topic::find($id);

		$val = Model_Help_Topic::validate('edit');

		if ($val->run())
		{
			$help_topic->title = Input::post('title');
			$help_topic->description = Input::post('description');

			if ($help_topic->save())
			{
				Session::set_flash('success', 'Updated help_topic #' . $id);

				Response::redirect('help/topic');
			}

			else
			{
				Session::set_flash('error', 'Could not update help_topic #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$help_topic->title = $val->validated('title');
				$help_topic->description = $val->validated('description');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('help_topic', $help_topic, false);
		}

		$this->template->title = "Help_topics";
		$this->template->content = View::forge('help/topic/edit');

	}

	public function action_delete($id = null)
	{
		if ($help_topic = Model_Help_Topic::find($id))
		{
			$help_topic->delete();

			Session::set_flash('success', 'Deleted help_topic #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete help_topic #'.$id);
		}

		Response::redirect('help/topic');

	}


}