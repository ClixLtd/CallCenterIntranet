<?php
	
	namespace PPIApi;
	
	// Extend the required hybrid template	
	class Controller_Report_Hybrid extends \Controller_BaseHybrid
	{
		
		public static $_viewPath;
		
		public function before()
		{
		
			// Make sure we call the parent package before function
			parent::before();
			
			// Load the config file for this package
			\Config::load('ppi-api', true);
			
			// Now set the view directory for this package
			static::$_viewPath = \Config::get('reports.view_directory');
			
		}
		
	}