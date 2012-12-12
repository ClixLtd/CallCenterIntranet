<?php
class Controller_Proxies extends Controller_Base 
{

	public function action_index()
	{
		$data['proxies'] = Model_Proxy::find('all');
		$this->template->title = "Proxies";
		$this->template->content = View::forge('proxies/index', $data);

	}

	public function action_view($id = null)
	{
		$data['proxy'] = Model_Proxy::find($id);

		is_null($id) and Response::redirect('Proxies');

		$this->template->title = "Proxy";
		$this->template->content = View::forge('proxies/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Proxy::validate('create');
			
			if ($val->run())
			{
				$proxy = Model_Proxy::forge(array(
					'host' => Input::post('host'),
					'port' => Input::post('port'),
					'fail_count' => Input::post('fail_count'),
				));

				if ($proxy and $proxy->save())
				{
					Session::set_flash('success', 'Added proxy #'.$proxy->id.'.');

					Response::redirect('proxies');
				}

				else
				{
					Session::set_flash('error', 'Could not save proxy.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Proxies";
		$this->template->content = View::forge('proxies/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Proxies');

		$proxy = Model_Proxy::find($id);

		$val = Model_Proxy::validate('edit');

		if ($val->run())
		{
			$proxy->host = Input::post('host');
			$proxy->port = Input::post('port');
			$proxy->fail_count = Input::post('fail_count');

			if ($proxy->save())
			{
				Session::set_flash('success', 'Updated proxy #' . $id);

				Response::redirect('proxies');
			}

			else
			{
				Session::set_flash('error', 'Could not update proxy #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$proxy->host = $val->validated('host');
				$proxy->port = $val->validated('port');
				$proxy->fail_count = $val->validated('fail_count');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('proxy', $proxy, false);
		}

		$this->template->title = "Proxies";
		$this->template->content = View::forge('proxies/edit');

	}

	public function action_delete($id = null)
	{
		if ($proxy = Model_Proxy::find($id))
		{
			$proxy->delete();

			Session::set_flash('success', 'Deleted proxy #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete proxy #'.$id);
		}

		Response::redirect('proxies');

	}


}