<?php

	Autoloader::add_classes(array(
		// Classes
		'MassUser\\Intranet' => __DIR__.'/classes/intranet.php',
		'MassUser\\ActiveDirectory' => __DIR__.'/classes/activedirectory.php',
		'MassUser\\EMail' => __DIR__.'/classes/email.php',
		'MassUser\\Dialler' => __DIR__.'/classes/dialler.php',
		'MassUser\\Debtsolv' => __DIR__.'/classes/debtsolv.php',
		'MassUser\\PBX' => __DIR__.'/classes/pbx.php',
		
		// Objects
		'MassUser\\Objects\\User_Object' => __DIR__.'/classes/objects/user_object.php',
		
		// Models
		
	));