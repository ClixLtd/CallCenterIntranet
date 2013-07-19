<?php
	
	namespace Reports;
	
	// Extend the required hybrid template	
	class Controller_Report_Template extends \Controller_Base
	{
		
		public static $_viewPath;
		
		public function before()
		{
		
			// Make sure we call the parent package before function
			parent::before();
			
			// Load the config file for this package
			\Config::load('reports', true);
			
			// Now set the view directory for this package
			static::$_viewPath = \Config::get('reports.view_directory');
			
			
			
		}
		
	}