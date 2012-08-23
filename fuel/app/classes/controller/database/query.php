<?php
class Controller_Database_Query extends Controller_Base 
{

	public function action_index($id = null)
	{	
		
		$all_results = Model_Database_Query::find();
		
		
		if (!is_null($this->param('tag')))
			$all_results->related('database_query_tags')->where('database_query_tags.tag', $this->param('tag'));
		
		if (!is_null($id))
			$all_results->where('database_server_id', $id);
		
		
		
		
		
		$this->template->title = "Database_queries";
		$this->template->content = View::forge('database/query/index', array('database_queries' => $all_results->get(), 'server_id' => $id));

	}

	public function action_view($id = null)
	{
		$data['database_query'] = Model_Database_Query::find($id);

		is_null($id) and Response::redirect('Database_Query');

		$this->template->title = "Database_query";
		$this->template->content = View::forge('database/query/view', $data);

	}

	public function action_create($id = null)
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Database_Query::validate('create');
			
			if ($val->run())
			{
				$database_query = Model_Database_Query::forge(array(
					'title' => Input::post('title'),
					'description' => Input::post('description'),
					'query' => Input::post('query'),
					'cache_time' => Input::post('cache_time'),
					'database_server_id' => Input::post('database_server_id'),
					'database' => Input::post('database'),
					'username' => Input::post('username'),
					'password' => Input::post('password'),
				));

				if ($database_query and $database_query->save())
				{
					Session::set_flash('success', 'Added database_query #'.$database_query->id.'.');

					Response::redirect('database/query');
				}

				else
				{
					Session::set_flash('error', 'Could not save database_query.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
		
		
		$this->template->set_global('server_id', $id, false);
		
		
		$this->template->set_global('database_servers', Arr::assoc_to_keyval(Model_Database_Server::find('all'), 'id', 'title'), false);
		
		$this->template->title = "Database_Queries";
		$this->template->content = View::forge('database/query/create');

	}
	
	
	private function get_database_results($id)
	{
		$database_query = Model_Database_Query::find($id);
		
		$config = array(
			'type'       => 'pdo',
			'connection' => array(
				'dsn'            => ( ($database_query->database_servers->type == 'mysql') ? 'mysql' : 'dblib' ).':host='.$database_query->database_servers->hostname.( ($database_query->database_servers->type == 'mysql') ? ';port=' : ':' ).$database_query->database_servers->port.';dbname='.$database_query->database,
		        'username'       => ($database_query->username == '') ? $database_query->database_servers->username : $database_query->username,
		        'password'       => ($database_query->password == '') ? $database_query->database_servers->password : $database_query->password,
		        'persistent'     => false,
			),
			'Identifier'  => '' ,
			'Charset'    => ''
		);
		
		$remote_connection = Database_Connection::instance('runQuery'.$database_query->database_servers->hostname, $config);
		$results = DB::query($database_query->query)->cached($database_query->cache_time)->execute($remote_connection);

		 return $results->as_array();
	}
	
	
	public function action_run($id = null)	
	{
		$query_details = Model_Database_Query::find($id);
		
		$return_results = $this->get_database_results($id);
		
		if (!is_null($this->param('format'))) {
		
			return new \Response(json_encode($return_results),200,array('Content-type'=>'application/json'));
			
			
		} else {
			
			$column_headings = Array();
			if (count($return_results) > 0) {
				foreach($return_results[0] AS $column_head => $column_text) {
					$column_headings[] = $column_head;
				}
			}
			
			
			$this->template->title = "Database_Queries";
			$this->template->content = View::forge('database/query/run', array(
				'query_details' => $query_details,
				'query_results' => $return_results,
				'query_columns' => $column_headings,
			));
		
		}
		
	}
	
	
	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Database_Query');

		$database_query = Model_Database_Query::find($id);

		$val = Model_Database_Query::validate('edit');

		if ($val->run())
		{
			$database_query->title = Input::post('title');
			$database_query->description = Input::post('description');
			$database_query->query = Input::post('query');
			$database_query->cache_time = Input::post('cache_time');
			$database_query->database_server_id = Input::post('database_server_id');
			$database_query->database = Input::post('database');
			$database_query->username = Input::post('username');
			$database_query->password = Input::post('password');

			if ($database_query->save())
			{
				Session::set_flash('success', 'Updated database_query #' . $id);

				Response::redirect('database/query');
			}

			else
			{
				Session::set_flash('error', 'Could not update database_query #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$database_query->title = $val->validated('title');
				$database_query->description = $val->validated('description');
				$database_query->query = $val->validated('query');
				$database_query->cache_time = $val->validated('cache_time');
				$database_query->database_server_id = $val->validated('database_server_id');
				$database_query->database = $val->validated('database');
				$database_query->username = $val->validated('username');
				$database_query->password = $val->validated('password');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('database_query', $database_query, false);
		}
		
		$this->template->set_global('server_id', null, false);
		
		$this->template->set_global('database_servers', Arr::assoc_to_keyval(Model_Database_Server::find('all'), 'id', 'title'), false);
		
		$this->template->title = "Database_queries";
		$this->template->content = View::forge('database/query/edit');

	}

	public function action_delete($id = null)
	{
		if ($database_query = Model_Database_Query::find($id))
		{
			$database_query->delete();

			Session::set_flash('success', 'Deleted database_query #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete database_query #'.$id);
		}

		Response::redirect('database/query');

	}


}