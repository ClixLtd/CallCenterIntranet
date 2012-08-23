<?php
class Controller_ extends Controller_Template 
{

	public function action_index()
	{
		$data['s'] = Model_::find('all');
		$this->template->title = "S";
		$this->template->content = View::forge('/index', $data);

	}

	public function action_view($id = null)
	{
		$data[''] = Model_::find($id);

		is_null($id) and Response::redirect('');

		$this->template->title = "";
		$this->template->content = View::forge('/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_::validate('create');
			
			if ($val->run())
			{
				$ = Model_::forge(array(
				));

				if ($ and $->save())
				{
					Session::set_flash('success', 'Added  #'.$->id.'.');

					Response::redirect('');
				}

				else
				{
					Session::set_flash('error', 'Could not save .');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "S";
		$this->template->content = View::forge('/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('');

		$ = Model_::find($id);

		$val = Model_::validate('edit');

		if ($val->run())
		{

			if ($->save())
			{
				Session::set_flash('success', 'Updated  #' . $id);

				Response::redirect('');
			}

			else
			{
				Session::set_flash('error', 'Could not update  #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('', $, false);
		}

		$this->template->title = "S";
		$this->template->content = View::forge('/edit');

	}

	public function action_delete($id = null)
	{
		if ($ = Model_::find($id))
		{
			$->delete();

			Session::set_flash('success', 'Deleted  #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete  #'.$id);
		}

		Response::redirect('');

	}


}