<?php

class Controller_Messages extends Controller_Template
{

	public function action_unread()
	{
		$this->template->title = 'Messages &raquo; Unread';
		$this->template->content = View::forge('messages/unread');
	}

	public function action_view()
	{
		$this->template->title = 'Messages &raquo; View';
		$this->template->content = View::forge('messages/view');
	}

	public function action_send()
	{
		$this->template->title = 'Messages &raquo; Send';
		$this->template->content = View::forge('messages/send');
	}

	public function action_reply()
	{
		$this->template->title = 'Messages &raquo; Reply';
		$this->template->content = View::forge('messages/reply');
	}

}
