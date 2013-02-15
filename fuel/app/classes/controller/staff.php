<?php
class Controller_Staff extends Controller_Base 
{

	public function action_index()
	{
		$data['staffs'] = Model_Staff::find('all');
		$this->template->title = "Staffs";
		$this->template->content = View::forge('staff/index', $data);

	}

	public function action_view($id = null)
	{
		$data['staff'] = Model_Staff::find($id);

		is_null($id) and Response::redirect('Staff');

		$this->template->title = "Staff";
		$this->template->content = View::forge('staff/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Staff::validate('create');
			
			if ($val->run())
			{
				$staff = Model_Staff::forge(array(
					'first_name' => Input::post('first_name'),
					'last_name' => Input::post('last_name'),
					'intranet_id' => Input::post('intranet_id'),
					'dialler_id' => Input::post('dialler_id'),
					'debtsolv_id' => Input::post('debtsolv_id'),
					'network_id' => Input::post('network_id'),
					'active' => Input::post('active'),
				));

				if ($staff and $staff->save())
				{
					Session::set_flash('success', 'Added staff #'.$staff->id.'.');

					Response::redirect('staff');
				}

				else
				{
					Session::set_flash('error', 'Could not save staff.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Staffs";
		$this->template->content = View::forge('staff/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Staff');

		$staff = Model_Staff::find($id);

		$val = Model_Staff::validate('edit');

		if ($val->run())
		{
			$staff->first_name = Input::post('first_name');
			$staff->last_name = Input::post('last_name');
			$staff->intranet_id = Input::post('intranet_id');
			$staff->dialler_id = Input::post('dialler_id');
			$staff->debtsolv_id = Input::post('debtsolv_id');
			$staff->network_id = Input::post('network_id');
			$staff->active = Input::post('active');

			if ($staff->save())
			{
				Session::set_flash('success', 'Updated staff #' . $id);

				Response::redirect('staff');
			}

			else
			{
				Session::set_flash('error', 'Could not update staff #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$staff->first_name = $val->validated('first_name');
				$staff->last_name = $val->validated('last_name');
				$staff->intranet_id = $val->validated('intranet_id');
				$staff->dialler_id = $val->validated('dialler_id');
				$staff->debtsolv_id = $val->validated('debtsolv_id');
				$staff->network_id = $val->validated('network_id');
				$staff->active = $val->validated('active');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('staff', $staff, false);
		}

		$this->template->title = "Staffs";
		$this->template->content = View::forge('staff/edit');

	}

	public function action_delete($id = null)
	{
		if ($staff = Model_Staff::find($id))
		{
			$staff->delete();

			Session::set_flash('success', 'Deleted staff #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete staff #'.$id);
		}

		Response::redirect('staff');

	}


}