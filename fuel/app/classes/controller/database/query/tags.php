<?php
class Controller_Database_Query_Tags extends Controller_Base 
{

	public function action_index()
	{
		$data['database_query_tags'] = Model_Database_Query_Tag::find('all');
		$this->template->title = "Database_query_tags";
		$this->template->content = View::forge('database/query/tags/index', $data);

	}

	public function action_view($id = null)
	{
		$data['database_query_tag'] = Model_Database_Query_Tag::find($id);

		is_null($id) and Response::redirect('Database_Query_Tags');

		$this->template->title = "Database_query_tag";
		$this->template->content = View::forge('database/query/tags/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Database_Query_Tag::validate('create');
			
			if ($val->run())
			{
				$database_query_tag = Model_Database_Query_Tag::forge(array(
					'database_query_id' => Input::post('database_query_id'),
					'tag' => Input::post('tag'),
				));

				if ($database_query_tag and $database_query_tag->save())
				{
					Session::set_flash('success', 'Added database_query_tag #'.$database_query_tag->id.'.');

					Response::redirect('database/query/tags');
				}

				else
				{
					Session::set_flash('error', 'Could not save database_query_tag.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Database_Query_Tags";
		$this->template->content = View::forge('database/query/tags/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Database_Query_Tags');

		$database_query_tag = Model_Database_Query_Tag::find($id);

		$val = Model_Database_Query_Tag::validate('edit');

		if ($val->run())
		{
			$database_query_tag->database_query_id = Input::post('database_query_id');
			$database_query_tag->tag = Input::post('tag');

			if ($database_query_tag->save())
			{
				Session::set_flash('success', 'Updated database_query_tag #' . $id);

				Response::redirect('database/query/tags');
			}

			else
			{
				Session::set_flash('error', 'Could not update database_query_tag #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$database_query_tag->database_query_id = $val->validated('database_query_id');
				$database_query_tag->tag = $val->validated('tag');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('database_query_tag', $database_query_tag, false);
		}

		$this->template->title = "Database_query_tags";
		$this->template->content = View::forge('database/query/tags/edit');

	}

	public function action_delete($id = null)
	{
		if ($database_query_tag = Model_Database_Query_Tag::find($id))
		{
			$database_query_tag->delete();

			Session::set_flash('success', 'Deleted database_query_tag #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete database_query_tag #'.$id);
		}

		Response::redirect('database/query/tags');

	}


}