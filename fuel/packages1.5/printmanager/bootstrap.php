<?php

Autoloader::add_core_namespace('Printmanager');

Autoloader::add_classes(array(
	
	// Extend the app's normal controllers with our own
	'Printmanager\\Model_Printmanager_Printer' => __DIR__.'/models/printer.php',
	'Printmanager\\Model_Printmanager_Queue' => __DIR__.'/models/queue.php',
	'Printmanager\\Model_Printmanager_Tray' => __DIR__.'/models/tray.php',
	
	// Classes
	'Printmanager\\Queue' => __DIR__.'/classes/queue.php'
	
));
