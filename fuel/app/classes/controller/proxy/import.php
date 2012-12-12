<?php
class Controller_Proxy_Import extends Controller_Base 
{

	public function action_index()
	{
		$data['proxy_imports'] = Model_Proxy_Import::find('all');
		$this->template->title = "Proxy_imports";
		$this->template->content = View::forge('proxy/import/index', $data);

	}

	public function action_view($id = null)
	{
		$data['proxy_import'] = Model_Proxy_Import::find($id);

		is_null($id) and Response::redirect('Proxy_Import');

		$this->template->title = "Proxy_import";
		$this->template->content = View::forge('proxy/import/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Proxy_Import::validate('create');
			
			if ($val->run())
			{
				$proxy_import = Model_Proxy_Import::forge(array(
					'name' => Input::post('name'),
					'proxylist' => Input::post('proxylist'),
				));

				if ($proxy_import and $proxy_import->save())
				{
					// Run the importer
					
					foreach(explode("\r\n", Input::post('proxylist')) as $line) {
						$proxy_details = explode(':', $line);
						
						$check_proxy = Model_Proxy::find()->where('host', $proxy_details[0])->where('port', $proxy_details[1]);
						
						
						if ($check_proxy->count() < 1)
						{
							$proxy = Model_Proxy::forge(array(
								'host' => $proxy_details[0],
								'port' => $proxy_details[1],
								'fail_count' => 0,
								'use_count' => 0,
							));
							
							$proxy->save();
						}
						else
						{
							/*
							$check_proxy->get_one();
						
							$this_proxy = Model_Proxy::find($check_proxy->id);
							
							$this_proxy->fail_count = 0;
							$this_proxy->save();
							*/
						}
						
					}
					
				
				
					Session::set_flash('success', 'Added proxy_import #'.$proxy_import->id.'.');

					Response::redirect('proxy/import');
				}

				else
				{
					Session::set_flash('error', 'Could not save proxy_import.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Proxy_Imports";
		$this->template->content = View::forge('proxy/import/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Proxy_Import');

		$proxy_import = Model_Proxy_Import::find($id);

		$val = Model_Proxy_Import::validate('edit');

		if ($val->run())
		{
			$proxy_import->name = Input::post('name');
			$proxy_import->proxylist = Input::post('proxylist');

			if ($proxy_import->save())
			{
				Session::set_flash('success', 'Updated proxy_import #' . $id);

				Response::redirect('proxy/import');
			}

			else
			{
				Session::set_flash('error', 'Could not update proxy_import #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$proxy_import->name = $val->validated('name');
				$proxy_import->proxylist = $val->validated('proxylist');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('proxy_import', $proxy_import, false);
		}

		$this->template->title = "Proxy_imports";
		$this->template->content = View::forge('proxy/import/edit');

	}

	public function action_delete($id = null)
	{
		if ($proxy_import = Model_Proxy_Import::find($id))
		{
			$proxy_import->delete();

			Session::set_flash('success', 'Deleted proxy_import #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete proxy_import #'.$id);
		}

		Response::redirect('proxy/import');

	}


}