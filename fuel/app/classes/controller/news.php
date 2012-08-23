<?php
class Controller_News extends Controller_Base 
{

	public function action_index()
	{
		$data['news'] = Model_News::find('all');
		$this->template->title = "News";
		$this->template->content = View::forge('news/index', $data);

	}

	public function action_view($id = null)
	{
		$data['news'] = Model_News::find($id);

		is_null($id) and Response::redirect('News');

		$this->template->title = "News";
		$this->template->content = View::forge('news/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_News::validate('create');
			
			if ($val->run())
			{
				$news = Model_News::forge(array(
					'title' => Input::post('title'),
					'article' => Input::post('article'),
					'call_center_id' => Input::post('call_center_id'),
					'user_id' => Input::post('user_id'),
				));

				if ($news and $news->save())
				{
					Session::set_flash('success', 'Added news #'.$news->id.'.');

					Response::redirect('news');
				}

				else
				{
					Session::set_flash('error', 'Could not save news.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "News";
		$this->template->content = View::forge('news/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('News');

		$news = Model_News::find($id);

		$val = Model_News::validate('edit');

		if ($val->run())
		{
			$news->title = Input::post('title');
			$news->article = Input::post('article');
			$news->call_center_id = Input::post('call_center_id');
			$news->user_id = Input::post('user_id');

			if ($news->save())
			{
				Session::set_flash('success', 'Updated news #' . $id);

				Response::redirect('news');
			}

			else
			{
				Session::set_flash('error', 'Could not update news #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$news->title = $val->validated('title');
				$news->article = $val->validated('article');
				$news->call_center_id = $val->validated('call_center_id');
				$news->user_id = $val->validated('user_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('news', $news, false);
		}

		$this->template->title = "News";
		$this->template->content = View::forge('news/edit');

	}

	public function action_delete($id = null)
	{
		if ($news = Model_News::find($id))
		{
			$news->delete();

			Session::set_flash('success', 'Deleted news #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete news #'.$id);
		}

		Response::redirect('news');

	}


}