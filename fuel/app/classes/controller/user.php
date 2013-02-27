<?php

class Controller_User extends Controller_BaseHybrid
{
	
	
	public function action_view()
	{
	
		if (Auth::has_access('user.view')) {
			
		
			$this->template->title = 'View Users &raquo; ';
			$this->template->content = View::forge('user/view');
		}
		else
		{
			Session::set_flash('fail', 'You do not have access to that section: This has been logged!');
			Response::redirect('/');
		}
	}

	public function get_get_view()
	{
	
		if (Auth::has_access('user.view')) {
		
			$users = Model_User::find('all');
			
			$user_parse = array();
			foreach ($users AS $user)
			{
				$user_parse[] = array(
					'<img src="https://secure.gravatar.com/avatar/'.md5(strtolower(trim($user->email))).'?d=mm" alt="Gravatar Image" height="40" width="40">', 
					$user->name, 
					$user->username, 
					Auth_Group_SimpleGroup::instance()->get_name($user->group),
					$user->email, 
					$user->call_center->title,
					(strlen($user->last_login) > 2) ? date("M j, Y g:i A", (int)$user->last_login) : "No previous Login",
				);
				
			}
			
			$this->response(array(
				"aaData" => $user_parse,
				"aoColumnDefs" => array(
					array(
						"iDataSort" => 6,
						"asSorting" => array("desc"),
						"aTargets" => array(0),
					),
				),
				"aoColumns" => array(
					array(
						"mDataProp" => "id", 
						"bSortable" => false,
					),
					array(
						"mDataProp" => "name", 
						"sTitle"    => "Name",
						"sType"		=> "string",
					),
					array(
						"mDataProp" => "username", 
						"sTitle"    => "Username",
						"sType"		=> "string",
					),
					array(
						"mDataProp" => "group", 
						"sTitle"    => "Group",
						"sType"		=> "string",
					),
					array(
						"mDataProp" => "email", 
						"sTitle"    => "E-mail",
						"sType"		=> "string",
					),
					array(
						"mDataProp" => "call_center", 
						"sTitle"    => "Call Center",
						"sType"		=> "string",
					),
					array(
						"mDataProp" => "last_login", 
						"sTitle"    => "Last Login",
						"sType"		=> "date",
					),
				)
			));
		
		}
		else
		{
			$this->response(array(
				"error" => "You are not authorised to view this content!"
			));
		}
				
	}


	public function action_login()
	{
		
		
		
		$login_log = new Model_Users_Log_Login();
		
	
		if (Input::method() == 'POST')
		{
			if (Auth::login(Input::post('username'), Input::post('password')))
			{
				list($driver, $user_id) = Auth::get_user_id();
				$login_log->user_id = $user_id;
				$login_log->status = 1;
				$login_log->login_time = strtotime('NOW');
				$login_log->attempted_login = Input::post('username');
				$login_log->ip_address = $_SERVER['REMOTE_ADDR'];
				$login_log->save();
				
				Response::redirect('/');
			} else {
				
				$query = Model_User::find()->where('username', Input::post('username'));
				if ($query->count() > 0) {
					$attempt = $query->get_one();
					
					$user_id = $attempt->id;
					$login_log->user_id = $user_id;
					$login_log->status = 2;
					$login_log->login_time = strtotime('NOW');
					$login_log->attempted_login = Input::post('username');
					$login_log->ip_address = $_SERVER['REMOTE_ADDR'];
					
					
				} else {
					$user_id = 0;
					$login_log->user_id = $user_id;
					$login_log->status = 2;
					$login_log->login_time = strtotime('NOW');
					$login_log->attempted_login = Input::post('username');
					$login_log->ip_address = $_SERVER['REMOTE_ADDR'];
				}
				
				$login_log->save();
				
				Session::set_flash('fail', 'Invalid Username or Password!');
			}
		}
		
		
		
		return View::forge('welcome/login', array(
			'title' => 'Login'
		));
	}

	public function action_logout()
	{
		$login_log = new Model_Users_Log_Login();
		list($driver, $user_id) = Auth::get_user_id();
		$login_log->user_id = $user_id;
		$login_log->status = 0;
		$login_log->login_time = strtotime('NOW');
		$login_log->attempted_login = '';
		$login_log->ip_address = $_SERVER['REMOTE_ADDR'];
		$login_log->save();

	
		Auth::logout();
		
		Session::set_flash('success', 'You have logged out!');
		
		Response::redirect('/');
		
	}
	
	
	
	
	
	
	// Creating Users
	
	public function action_create()
	{
		
		$user_details   = array(
			'username'	  => null,
			'first_name'  => 'Test',
			'last_name'   => 'Account',
		);
		
		// Create Username unless already set
		if (is_null($user_details['username']))
		{
			$user_details['username'] = substr($user_details['first_name'],0,1).$user_details['last_name'];
		}
	
		$intranet_user  = new MassUser\Intranet;
		$intranet_user->forge($user_details);
		$intranet_user->save();
	}
	
}
