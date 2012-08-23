<?php
class Controller_Call_Center extends Controller_Base 
{

	public function action_index()
	{
		$data['call_centers'] = Model_Call_Center::find('all');
		$this->template->title = "Call_centers";
		$this->template->content = View::forge('call/center/index', $data);

	}

	public function action_view($id = null)
	{
		$data['call_center'] = Model_Call_Center::find($id);

		is_null($id) and Response::redirect('Call_Center');

		$this->template->title = "Call_center";
		$this->template->content = View::forge('call/center/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Call_Center::validate('create');
			
			if ($val->run())
			{
				$call_center = Model_Call_Center::forge(array(
					'title' => Input::post('title'),
					'address' => Input::post('address'),
					'shortcode' => Input::post('shortcode'),
					'phone_number' => Input::post('phone_number'),
				));

				if ($call_center and $call_center->save())
				{
					Session::set_flash('success', 'Added call_center #'.$call_center->id.'.');

					Response::redirect('call/center');
				}

				else
				{
					Session::set_flash('error', 'Could not save call_center.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Call_Centers";
		$this->template->content = View::forge('call/center/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Call_Center');

		$call_center = Model_Call_Center::find($id);

		$val = Model_Call_Center::validate('edit');

		if ($val->run())
		{
			$call_center->title = Input::post('title');
			$call_center->address = Input::post('address');
			$call_center->shortcode = Input::post('shortcode');
			$call_center->phone_number = Input::post('phone_number');

			if ($call_center->save())
			{
				Session::set_flash('success', 'Updated call_center #' . $id);

				Response::redirect('call/center');
			}

			else
			{
				Session::set_flash('error', 'Could not update call_center #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$call_center->title = $val->validated('title');
				$call_center->address = $val->validated('address');
				$call_center->shortcode = $val->validated('shortcode');
				$call_center->phone_number = $val->validated('phone_number');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('call_center', $call_center, false);
		}

		$this->template->title = "Call_centers";
		$this->template->content = View::forge('call/center/edit');

	}

	public function action_delete($id = null)
	{
		if ($call_center = Model_Call_Center::find($id))
		{
			$call_center->delete();

			Session::set_flash('success', 'Deleted call_center #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete call_center #'.$id);
		}

		Response::redirect('call/center');

	}


}