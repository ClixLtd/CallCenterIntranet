<?php
class Controller_Adam_Announcements extends Controller_Base 
{

	public function action_index()
	{
		$data['adam_announcements'] = Model_Adam_Announcement::find('all');
		$this->template->title = "Adam_announcements";
		$this->template->content = View::forge('adam/announcements/index', $data);

	}

	public function action_view($id = null)
	{
		$data['adam_announcement'] = Model_Adam_Announcement::find($id);

		is_null($id) and Response::redirect('Adam_Announcements');

		$this->template->title = "Adam_announcement";
		$this->template->content = View::forge('adam/announcements/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Adam_Announcement::validate('create');
			
			if ($val->run())
			{
				$adam_announcement = Model_Adam_Announcement::forge(array(
					'campaign' => Input::post('campaign'),
					'alert_type' => Input::post('alert_type'),
					'remove_date' => Input::post('remove_date'),
				));

				if ($adam_announcement and $adam_announcement->save())
				{
					Session::set_flash('success', 'Added adam_announcement #'.$adam_announcement->id.'.');

					Response::redirect('adam/announcements');
				}

				else
				{
					Session::set_flash('error', 'Could not save adam_announcement.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Adam_Announcements";
		$this->template->content = View::forge('adam/announcements/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Adam_Announcements');

		$adam_announcement = Model_Adam_Announcement::find($id);

		$val = Model_Adam_Announcement::validate('edit');

		if ($val->run())
		{
			$adam_announcement->campaign = Input::post('campaign');
			$adam_announcement->alert_type = Input::post('alert_type');
			$adam_announcement->remove_date = Input::post('remove_date');

			if ($adam_announcement->save())
			{
				Session::set_flash('success', 'Updated adam_announcement #' . $id);

				Response::redirect('adam/announcements');
			}

			else
			{
				Session::set_flash('error', 'Could not update adam_announcement #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$adam_announcement->campaign = $val->validated('campaign');
				$adam_announcement->alert_type = $val->validated('alert_type');
				$adam_announcement->remove_date = $val->validated('remove_date');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('adam_announcement', $adam_announcement, false);
		}

		$this->template->title = "Adam_announcements";
		$this->template->content = View::forge('adam/announcements/edit');

	}

	public function action_delete($id = null)
	{
		if ($adam_announcement = Model_Adam_Announcement::find($id))
		{
			$adam_announcement->delete();

			Session::set_flash('success', 'Deleted adam_announcement #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete adam_announcement #'.$id);
		}

		Response::redirect('adam/announcements');

	}


}