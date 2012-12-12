<?php
class Controller_Adam_Messages extends Controller_BaseHybrid 
{

	public function get_messages()
	{
		
	}


	public function action_index()
	{
		$data['adam_messages'] = Model_Adam_Message::find('all');
		$this->template->title = "Adam_messages";
		$this->template->content = View::forge('adam/messages/index', $data);

	}

	public function action_view($id = null)
	{
		$data['adam_message'] = Model_Adam_Message::find($id);

		is_null($id) and Response::redirect('Adam_Messages');

		$this->template->title = "Adam_message";
		$this->template->content = View::forge('adam/messages/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Adam_Message::validate('create');
			
			if ($val->run())
			{
				$adam_message = Model_Adam_Message::forge(array(
					'message' => Input::post('message'),
				));

				if ($adam_message and $adam_message->save())
				{
					Session::set_flash('success', 'Added adam_message #'.$adam_message->id.'.');

					Response::redirect('adam/messages');
				}

				else
				{
					Session::set_flash('error', 'Could not save adam_message.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Adam_Messages";
		$this->template->content = View::forge('adam/messages/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Adam_Messages');

		$adam_message = Model_Adam_Message::find($id);

		$val = Model_Adam_Message::validate('edit');

		if ($val->run())
		{
			$adam_message->message = Input::post('message');

			if ($adam_message->save())
			{
				Session::set_flash('success', 'Updated adam_message #' . $id);

				Response::redirect('adam/messages');
			}

			else
			{
				Session::set_flash('error', 'Could not update adam_message #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$adam_message->message = $val->validated('message');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('adam_message', $adam_message, false);
		}

		$this->template->title = "Adam_messages";
		$this->template->content = View::forge('adam/messages/edit');

	}

	public function action_delete($id = null)
	{
		if ($adam_message = Model_Adam_Message::find($id))
		{
			$adam_message->delete();

			Session::set_flash('success', 'Deleted adam_message #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete adam_message #'.$id);
		}

		Response::redirect('adam/messages');

	}


}