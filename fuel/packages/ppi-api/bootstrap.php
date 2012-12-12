<?php

Autoloader::add_core_namespace('PPIApi');

Autoloader::add_classes(array(
	
	// Extend the app's normal controllers with our own
	'PPIApi\\Controller_Report_Template' => __DIR__.'/controller/controller_template.php',
	'PPIApi\\Controller_Report_Hybrid' => __DIR__.'/controller/controller_hybrid.php',
	'PPIApi\\Controller_Report_Rest' => __DIR__.'/controller/controller_rest.php',
	
	// Controllers
	'Controller_Ppi_Api' => __DIR__.'/controller/ppi/controller_ppi_api.php',
	
	// Models
	
	
	// Other Required files
	
	'PPIApi\\PPI' => __DIR__.'/controller/ppi/ppi.php',
	
));