<?php

class Controller_Projects extends Controller_Base
{

	public function action_index()
	{
		$this->template->title = 'Projects &raquo; Index';
		$this->template->content = View::forge('projects/index');
	}

	public function action_list()
	{
		$this->template->title = 'Projects &raquo; List';
		$this->template->content = View::forge('projects/list');
	}

	public function action_view()
	{
		$this->template->title = 'Projects &raquo; View';
		$this->template->content = View::forge('projects/view');
	}

	public function action_create()
	{
		$this->template->title = 'Projects &raquo; Create';
		$this->template->content = View::forge('projects/create');
	}

	public function action_edit()
	{
		$this->template->title = 'Projects &raquo; Edit';
		$this->template->content = View::forge('projects/edit');
	}

	public function action_request()
	{
		$this->template->title = 'Projects &raquo; Request';
		$this->template->content = View::forge('projects/request');
	}

	public function action_escalate()
	{
		$this->template->title = 'Projects &raquo; Escalate';
		$this->template->content = View::forge('projects/escalate');
	}

}
