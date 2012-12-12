<?php

class Controller_Support extends Controller_BaseHybrid
{
	
	
	
	// AJAX return for all current tickets
	public function get_viewall()
	{
		
	}
	
	// Create the all tickets HTML page	
	public function action_viewall()
	{
		// Check creation
		
		print_r(SexyTicket\Departments::show());
		
	}
	
	
	
	
	
	
		
	
}