<?php
class Controller_Portal extends Controller_Template 
{
	
	// Set the correct portal template
	public $template = 'template_ppi_portal';
	
	public function action_index($apikey=null)
	{
		$apiCheck = true;
		
		if ($apiCheck === true)
		{
			
		}
		else
		{
			print "API Key is invalid. Please see your administrator";
		}
		
	}
	
	
}