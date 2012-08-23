<?php
class Controller_Help_Ticket extends Controller_Base 
{

	public function action_index()
	{
		$data['help_tickets'] = Model_Help_Ticket::find('all');
		$this->template->title = "Help_tickets";
		$this->template->content = View::forge('help/ticket/index', $data);

	}

	public function action_view($id = null)
	{
		$data['help_ticket'] = Model_Help_Ticket::find($id);

		is_null($id) and Response::redirect('Help_Ticket');

		$this->template->title = "Help_ticket";
		$this->template->content = View::forge('help/ticket/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Help_Ticket::validate('create');
			
			if ($val->run())
			{
				$help_ticket = Model_Help_Ticket::forge(array(
					'title' => Input::post('title'),
					'description' => Input::post('description'),
					'priority' => Input::post('priority'),
					'help_topic_id' => Input::post('help_topic_id'),
					'user_id' => Input::post('user_id'),
				));

				if ($help_ticket and $help_ticket->save())
				{
					Session::set_flash('success', 'Added help_ticket #'.$help_ticket->id.'.');

					Response::redirect('help/ticket');
				}

				else
				{
					Session::set_flash('error', 'Could not save help_ticket.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Help_Tickets";
		$this->template->content = View::forge('help/ticket/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Help_Ticket');

		$help_ticket = Model_Help_Ticket::find($id);

		$val = Model_Help_Ticket::validate('edit');

		if ($val->run())
		{
			$help_ticket->title = Input::post('title');
			$help_ticket->description = Input::post('description');
			$help_ticket->priority = Input::post('priority');
			$help_ticket->help_topic_id = Input::post('help_topic_id');
			$help_ticket->user_id = Input::post('user_id');

			if ($help_ticket->save())
			{
				Session::set_flash('success', 'Updated help_ticket #' . $id);

				Response::redirect('help/ticket');
			}

			else
			{
				Session::set_flash('error', 'Could not update help_ticket #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$help_ticket->title = $val->validated('title');
				$help_ticket->description = $val->validated('description');
				$help_ticket->priority = $val->validated('priority');
				$help_ticket->help_topic_id = $val->validated('help_topic_id');
				$help_ticket->user_id = $val->validated('user_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('help_ticket', $help_ticket, false);
		}

		$this->template->title = "Help_tickets";
		$this->template->content = View::forge('help/ticket/edit');

	}

	public function action_delete($id = null)
	{
		if ($help_ticket = Model_Help_Ticket::find($id))
		{
			$help_ticket->delete();

			Session::set_flash('success', 'Deleted help_ticket #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete help_ticket #'.$id);
		}

		Response::redirect('help/ticket');

	}


}