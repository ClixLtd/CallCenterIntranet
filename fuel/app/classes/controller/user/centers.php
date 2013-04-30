<?php
class Controller_User_Centers extends Controller_Template 
{

	public function action_index()
	{
		$data['user_centers'] = Model_User_Center::find('all');
		$this->template->title = "User_centers";
		$this->template->content = View::forge('user/centers/index', $data);

	}

	public function action_view($id = null)
	{
		$data['user_center'] = Model_User_Center::find($id);

		is_null($id) and Response::redirect('User_Centers');

		$this->template->title = "User_center";
		$this->template->content = View::forge('user/centers/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_User_Center::validate('create');
			
			if ($val->run())
			{
				$user_center = Model_User_Center::forge(array(
					'user' => Input::post('user'),
					'center' => Input::post('center'),
				));

				if ($user_center and $user_center->save())
				{
					Session::set_flash('success', 'Added user_center #'.$user_center->id.'.');

					Response::redirect('user/centers');
				}

				else
				{
					Session::set_flash('error', 'Could not save user_center.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "User_Centers";
		$this->template->content = View::forge('user/centers/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('User_Centers');

		$user_center = Model_User_Center::find($id);

		$val = Model_User_Center::validate('edit');

		if ($val->run())
		{
			$user_center->user = Input::post('user');
			$user_center->center = Input::post('center');

			if ($user_center->save())
			{
				Session::set_flash('success', 'Updated user_center #' . $id);

				Response::redirect('user/centers');
			}

			else
			{
				Session::set_flash('error', 'Could not update user_center #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$user_center->user = $val->validated('user');
				$user_center->center = $val->validated('center');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('user_center', $user_center, false);
		}

		$this->template->title = "User_centers";
		$this->template->content = View::forge('user/centers/edit');

	}

	public function action_delete($id = null)
	{
		if ($user_center = Model_User_Center::find($id))
		{
			$user_center->delete();

			Session::set_flash('success', 'Deleted user_center #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete user_center #'.$id);
		}

		Response::redirect('user/centers');

	}


}