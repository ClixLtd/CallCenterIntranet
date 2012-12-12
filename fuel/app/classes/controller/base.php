<?php

	class Controller_Base extends Controller_Template
	{
	
		
		
		public function before()
		{
			parent::before();
			
			\Session::set("current_page", \Uri::string());
			
			$segments = implode(\Uri::segments());
			
			if (Auth::check() || $segments == 'userlogin')
			{
			
				list($driver, $user_id) = Auth::get_user_id();
				
				$this->current_user = Model_User::find($user_id);
			
			} else {
				
				if ($segments != 'userlogin')
				{
					Session::set("lastpage", implode("/",\Uri::segments()));
				}
				
				$this->current_user = null;
				
				Response::redirect('user/login');
				
			}
			
			if ($segments != 'userlogin') {
				View::set_global('group_name', Auth_Group_SimpleGroup::instance()->get_name($this->current_user->group));
				View::set_global('current_user', $this->current_user);
			}
			
			
		}
	
	}