<?php
class Controller_Api_Users extends Controller_Base 
{

	public function action_index()
	{
		$data['api_users'] = Model_Api_User::find('all');
		$this->template->title = "Api_users";
		$this->template->content = View::forge('api/users/index', $data);

	}

	public function action_view($id = null)
	{
		$data['api_user'] = Model_Api_User::find($id);

		is_null($id) and Response::redirect('Api_Users');

		$this->template->title = "Api_user";
		$this->template->content = View::forge('api/users/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Api_User::validate('create');
			
			if ($val->run())
			{
				$api_user = Model_Api_User::forge(array(
					'id' => Input::post('id'),
					'key' => Input::post('key'),
					'status' => Input::post('status'),
					'description' => Input::post('description'),
					'ip' => Input::post('ip'),
				));

				if ($api_user and $api_user->save())
				{
					Session::set_flash('success', 'Added api_user #'.$api_user->id.'.');

					Response::redirect('api/users');
				}

				else
				{
					Session::set_flash('error', 'Could not save api_user.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Api_Users";
		$this->template->content = View::forge('api/users/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Api_Users');

		$api_user = Model_Api_User::find($id);

		$val = Model_Api_User::validate('edit');

		if ($val->run())
		{
			$api_user->id = Input::post('id');
			$api_user->key = Input::post('key');
			$api_user->status = Input::post('status');
			$api_user->description = Input::post('description');
			$api_user->ip = Input::post('ip');

			if ($api_user->save())
			{
				Session::set_flash('success', 'Updated api_user #' . $id);

				Response::redirect('api/users');
			}

			else
			{
				Session::set_flash('error', 'Could not update api_user #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$api_user->id = $val->validated('id');
				$api_user->key = $val->validated('key');
				$api_user->status = $val->validated('status');
				$api_user->description = $val->validated('description');
				$api_user->ip = $val->validated('ip');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('api_user', $api_user, false);
		}

		$this->template->title = "Api_users";
		$this->template->content = View::forge('api/users/edit');

	}

	public function action_delete($id = null)
	{
		if ($api_user = Model_Api_User::find($id))
		{
			$api_user->delete();

			Session::set_flash('success', 'Deleted api_user #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete api_user #'.$id);
		}

		Response::redirect('api/users');

	}


}