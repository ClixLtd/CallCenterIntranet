<?php
class Controller_Dialler_Lists extends Controller_Base 
{

	public function action_index()
	{
		$data['dialler_lists'] = Model_Dialler_List::find('all');
		$this->template->title = "Dialler_lists";
		$this->template->content = View::forge('dialler/lists/index', $data);

	}

	public function action_view($id = null)
	{
		$data['dialler_list'] = Model_Dialler_List::find($id);

		is_null($id) and Response::redirect('Dialler_Lists');

		$this->template->title = "Dialler_list";
		$this->template->content = View::forge('dialler/lists/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Dialler_List::validate('create');
			
			if ($val->run())
			{
				$dialler_list = Model_Dialler_List::forge(array(
					'list_name' => Input::post('list_name'),
					'list_description' => Input::post('list_description'),
				));

				if ($dialler_list and $dialler_list->save())
				{
					Session::set_flash('success', 'Added dialler_list #'.$dialler_list->id.'.');

					Response::redirect('dialler/lists');
				}

				else
				{
					Session::set_flash('error', 'Could not save dialler_list.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Dialler_Lists";
		$this->template->content = View::forge('dialler/lists/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Dialler_Lists');

		$dialler_list = Model_Dialler_List::find($id);

		$val = Model_Dialler_List::validate('edit');

		if ($val->run())
		{
			$dialler_list->list_name = Input::post('list_name');
			$dialler_list->list_description = Input::post('list_description');

			if ($dialler_list->save())
			{
				Session::set_flash('success', 'Updated dialler_list #' . $id);

				Response::redirect('dialler/lists');
			}

			else
			{
				Session::set_flash('error', 'Could not update dialler_list #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$dialler_list->list_name = $val->validated('list_name');
				$dialler_list->list_description = $val->validated('list_description');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('dialler_list', $dialler_list, false);
		}

		$this->template->title = "Dialler_lists";
		$this->template->content = View::forge('dialler/lists/edit');

	}

	public function action_delete($id = null)
	{
		if ($dialler_list = Model_Dialler_List::find($id))
		{
			$dialler_list->delete();

			Session::set_flash('success', 'Deleted dialler_list #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete dialler_list #'.$id);
		}

		Response::redirect('dialler/lists');

	}


}