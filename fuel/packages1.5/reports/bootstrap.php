<?php

Autoloader::add_core_namespace('Reports');

Autoloader::add_classes(array(
	
	// Extend the app's normal controllers with our own
	'Reports\\Controller_Report_Template' => __DIR__.'/controller/controller_template.php',
	'Reports\\Controller_Report_Hybrid' => __DIR__.'/controller/controller_hybrid.php',
	'Reports\\Controller_Report_Rest' => __DIR__.'/controller/controller_rest.php',
	
	// Controllers
	'Controller_Reports_Debtsolv_Disposition' => __DIR__.'/controller/debtsolv/disposition.php',
	
	
	'Controller_Reports_Staff_Telesales' => __DIR__.'/controller/staff/telesales.php',
	
	// Models
	
	'Reports\\Model_Reports_Staff_Telesales' => __DIR__.'/model/staff/telesales.php',
	
	// Other Required files
	
));