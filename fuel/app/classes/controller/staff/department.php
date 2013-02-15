<?php
class Controller_Staff_Department extends Controller_Base 
{

	public function action_index()
	{
		$data['staff_departments'] = Model_Staff_Department::find('all');
		$this->template->title = "Staff_departments";
		$this->template->content = View::forge('staff/department/index', $data);

	}

	public function action_view($id = null)
	{
		$data['staff_department'] = Model_Staff_Department::find($id);

		is_null($id) and Response::redirect('Staff_Department');

		$this->template->title = "Staff_department";
		$this->template->content = View::forge('staff/department/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Staff_Department::validate('create');
			
			if ($val->run())
			{
				$staff_department = Model_Staff_Department::forge(array(
					'title' => Input::post('title'),
				));

				if ($staff_department and $staff_department->save())
				{
					Session::set_flash('success', 'Added staff_department #'.$staff_department->id.'.');

					Response::redirect('staff/department');
				}

				else
				{
					Session::set_flash('error', 'Could not save staff_department.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Staff_Departments";
		$this->template->content = View::forge('staff/department/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Staff_Department');

		$staff_department = Model_Staff_Department::find($id);

		$val = Model_Staff_Department::validate('edit');

		if ($val->run())
		{
			$staff_department->title = Input::post('title');

			if ($staff_department->save())
			{
				Session::set_flash('success', 'Updated staff_department #' . $id);

				Response::redirect('staff/department');
			}

			else
			{
				Session::set_flash('error', 'Could not update staff_department #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$staff_department->title = $val->validated('title');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('staff_department', $staff_department, false);
		}

		$this->template->title = "Staff_departments";
		$this->template->content = View::forge('staff/department/edit');

	}

	public function action_delete($id = null)
	{
		if ($staff_department = Model_Staff_Department::find($id))
		{
			$staff_department->delete();

			Session::set_flash('success', 'Deleted staff_department #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete staff_department #'.$id);
		}

		Response::redirect('staff/department');

	}


}