<?php
class Controller_Surnames extends Controller_Base
{

	public function action_index()
	{
		$data['surnames'] = Model_Surname::find('all');
		$this->template->title = "Surnames";
		$this->template->content = View::forge('surnames/index', $data);

	}

	public function action_view($id = null)
	{
		$data['surname'] = Model_Surname::find($id);

		is_null($id) and Response::redirect('Surnames');

		$this->template->title = "Surname";
		$this->template->content = View::forge('surnames/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Surname::validate('create');
			
			if ($val->run())
			{
				$surname = Model_Surname::forge(array(
					'surname' => Input::post('surname'),
					'completed' => Input::post('completed'),
				));

				if ($surname and $surname->save())
				{
					Session::set_flash('success', 'Added surname #'.$surname->id.'.');

					Response::redirect('surnames');
				}

				else
				{
					Session::set_flash('error', 'Could not save surname.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Surnames";
		$this->template->content = View::forge('surnames/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Surnames');

		$surname = Model_Surname::find($id);

		$val = Model_Surname::validate('edit');

		if ($val->run())
		{
			$surname->surname = Input::post('surname');
			$surname->completed = Input::post('completed');

			if ($surname->save())
			{
				Session::set_flash('success', 'Updated surname #' . $id);

				Response::redirect('surnames');
			}

			else
			{
				Session::set_flash('error', 'Could not update surname #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$surname->surname = $val->validated('surname');
				$surname->completed = $val->validated('completed');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('surname', $surname, false);
		}

		$this->template->title = "Surnames";
		$this->template->content = View::forge('surnames/edit');

	}

	public function action_delete($id = null)
	{
		if ($surname = Model_Surname::find($id))
		{
			$surname->delete();

			Session::set_flash('success', 'Deleted surname #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete surname #'.$id);
		}

		Response::redirect('surnames');

	}


}