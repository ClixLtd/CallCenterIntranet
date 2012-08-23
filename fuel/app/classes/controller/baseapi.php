<?php

	
	/**
	 * This class extends the standard REST controller to allow auth checks for 
	 * an API style system.
	 * 
	 * @extends Controller_Rest
	 */
	class Controller_BaseApi extends Controller_Hybrid
	{
	
		public function before()
		{
			parent::before();
			
			
			
						
			//View::set_global('group_name', Auth_Group_SimpleGroup::instance()->get_name($this->current_user->group));
			//View::set_global('current_user', $this->current_user);
			
		}
	
	}