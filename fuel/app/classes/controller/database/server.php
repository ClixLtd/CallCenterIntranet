<?php
class Controller_Database_Server extends Controller_Base 
{

	public function action_index()
	{
		$data['database_servers'] = Model_Database_Server::find('all');
		$this->template->title = "Database_servers";
		$this->template->content = View::forge('database/server/index', $data);

	}

	public function action_view($id = null)
	{
		$data['database_server'] = Model_Database_Server::find($id);

		is_null($id) and Response::redirect('Database_Server');

		$this->template->title = "Database_server";
		$this->template->content = View::forge('database/server/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Database_Server::validate('create');
			
			if ($val->run())
			{
				$database_server = Model_Database_Server::forge(array(
					'title' => Input::post('title'),
					'type' => Input::post('type'),
					'hostname' => Input::post('hostname'),
					'username' => Input::post('username'),
					'port' => Input::post('port'),
					'password' => Input::post('password'),
				));

				if ($database_server and $database_server->save())
				{
					Session::set_flash('success', 'Added database_server #'.$database_server->id.'.');

					Response::redirect('database/server');
				}

				else
				{
					Session::set_flash('error', 'Could not save database_server.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Database_Servers";
		$this->template->content = View::forge('database/server/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Database_Server');

		$database_server = Model_Database_Server::find($id);

		$val = Model_Database_Server::validate('edit');

		if ($val->run())
		{
			$database_server->title = Input::post('title');
			$database_server->type = Input::post('type');
			$database_server->hostname = Input::post('hostname');
			$database_server->port = Input::post('port');
			$database_server->username = Input::post('username');
			$database_server->password = Input::post('password');

			if ($database_server->save())
			{
				Session::set_flash('success', 'Updated database_server #' . $id);

				Response::redirect('database/server');
			}

			else
			{
				Session::set_flash('error', 'Could not update database_server #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$database_server->title = $val->validated('title');
				$database_server->type = $val->validated('type');
				$database_server->hostname = $val->validated('hostname');
				$database_server->port = $val->validated('port');
				$database_server->username = $val->validated('username');
				$database_server->password = $val->validated('password');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('database_server', $database_server, false);
		}

		$this->template->title = "Database_servers";
		$this->template->content = View::forge('database/server/edit');

	}

	public function action_delete($id = null)
	{
		if ($database_server = Model_Database_Server::find($id))
		{
			$database_server->delete();

			Session::set_flash('success', 'Deleted database_server #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete database_server #'.$id);
		}

		Response::redirect('database/server');

	}


}