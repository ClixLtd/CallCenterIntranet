<?php
class Controller_Selfgeneration extends Controller_Base 
{

	public function action_index()
	{
		$data['selfgenerations'] = Model_Selfgeneration::find('all');
		$this->template->title = "Selfgenerations";
		$this->template->content = View::forge('selfgeneration/index', $data);

	}

	public function action_view($id = null)
	{
		$data['selfgeneration'] = Model_Selfgeneration::find($id);

		is_null($id) and Response::redirect('Selfgeneration');

		$this->template->title = "Selfgeneration";
		$this->template->content = View::forge('selfgeneration/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Selfgeneration::validate('create');
			
			if ($val->run())
			{
				$selfgeneration = Model_Selfgeneration::forge(array(
					'fname' => Input::post('fname'),
					'sname' => Input::post('sname'),
					'add1' => Input::post('add1'),
					'add2' => Input::post('add2'),
					'postcode' => Input::post('postcode'),
					'telephone' => Input::post('telephone'),
				));

				if ($selfgeneration and $selfgeneration->save())
				{
					Session::set_flash('success', 'Added selfgeneration #'.$selfgeneration->id.'.');

					Response::redirect('selfgeneration');
				}

				else
				{
					Session::set_flash('error', 'Could not save selfgeneration.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Selfgenerations";
		$this->template->content = View::forge('selfgeneration/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Selfgeneration');

		$selfgeneration = Model_Selfgeneration::find($id);

		$val = Model_Selfgeneration::validate('edit');

		if ($val->run())
		{
			$selfgeneration->fname = Input::post('fname');
			$selfgeneration->sname = Input::post('sname');
			$selfgeneration->add1 = Input::post('add1');
			$selfgeneration->add2 = Input::post('add2');
			$selfgeneration->postcode = Input::post('postcode');
			$selfgeneration->telephone = Input::post('telephone');

			if ($selfgeneration->save())
			{
				Session::set_flash('success', 'Updated selfgeneration #' . $id);

				Response::redirect('selfgeneration');
			}

			else
			{
				Session::set_flash('error', 'Could not update selfgeneration #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$selfgeneration->fname = $val->validated('fname');
				$selfgeneration->sname = $val->validated('sname');
				$selfgeneration->add1 = $val->validated('add1');
				$selfgeneration->add2 = $val->validated('add2');
				$selfgeneration->postcode = $val->validated('postcode');
				$selfgeneration->telephone = $val->validated('telephone');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('selfgeneration', $selfgeneration, false);
		}

		$this->template->title = "Selfgenerations";
		$this->template->content = View::forge('selfgeneration/edit');

	}

	public function action_delete($id = null)
	{
		if ($selfgeneration = Model_Selfgeneration::find($id))
		{
			$selfgeneration->delete();

			Session::set_flash('success', 'Deleted selfgeneration #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete selfgeneration #'.$id);
		}

		Response::redirect('selfgeneration');

	}


}