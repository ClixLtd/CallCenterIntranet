<?php

class Controller_Testclass extends Controller_BaseHybrid
{

	public function action_hello()
	{
		$this->template->title = 'Seniors Report &raquo; ';
		
		$this->template->content = View::forge('../../goautodial/views/testview');
	}

}