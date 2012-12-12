<?php
class Controller_Towns extends Controller_Base
{

	public function action_index()
	{
		$data['towns'] = Model_Town::find('all');
		$this->template->title = "Towns";
		$this->template->content = View::forge('towns/index', $data);

	}

	public function action_view($id = null)
	{
		$data['town'] = Model_Town::find($id);

		is_null($id) and Response::redirect('Towns');

		$this->template->title = "Town";
		$this->template->content = View::forge('towns/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Town::validate('create');
			
			if ($val->run())
			{
				$town = Model_Town::forge(array(
					'town' => Input::post('town'),
				));

				if ($town and $town->save())
				{
					Session::set_flash('success', 'Added town #'.$town->id.'.');

					Response::redirect('towns');
				}

				else
				{
					Session::set_flash('error', 'Could not save town.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Towns";
		$this->template->content = View::forge('towns/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Towns');

		$town = Model_Town::find($id);

		$val = Model_Town::validate('edit');

		if ($val->run())
		{
			$town->town = Input::post('town');

			if ($town->save())
			{
				Session::set_flash('success', 'Updated town #' . $id);

				Response::redirect('towns');
			}

			else
			{
				Session::set_flash('error', 'Could not update town #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$town->town = $val->validated('town');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('town', $town, false);
		}

		$this->template->title = "Towns";
		$this->template->content = View::forge('towns/edit');

	}

	public function action_delete($id = null)
	{
		if ($town = Model_Town::find($id))
		{
			$town->delete();

			Session::set_flash('success', 'Deleted town #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete town #'.$id);
		}

		Response::redirect('towns');

	}


}