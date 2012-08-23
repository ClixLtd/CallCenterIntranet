<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(

	/**
	 * DB connection, leave null to use default
	 */
	'db_connection' => null,

	/**
	 * DB table name for the user table
	 */
	'table_name' => 'users',

	/**
	 * Choose which columns are selected, must include: username, password, email, last_login,
	 * login_hash, group & profile_fields
	 */
	'table_columns' => array('*'),

	/**
	 * This will allow you to use the group & acl driver for non-logged in users
	 */
	'guest_login' => true,

	/**
	 * Groups as id => array(name => <string>, roles => <array>)
	 */
	'groups' => array(

		 -1   => array('name' => 'Banned', 'roles' => array('banned')),
		 
		 1	  => array('name' => 'Data Supplier', 'roles' => array('dsupplier')),
		 
		 2	  => array('name' => 'Introducer', 'roles' => array('introducer')),
		 
		 5    => array('name' => 'Receptionist', 'roles' => array()),
		 
		 10   => array('name' => 'Telesales', 'roles' => array()),
		 15   => array('name' => 'Consolidator', 'roles' => array()),
		 30   => array('name' => 'Admin', 'roles' => array()),
		 40   => array('name' => 'Legal', 'roles' => array()),
		 
		 
		 
		 65   => array('name' => 'External Support Rep', 'roles' => array('telesales_manager', 'area_manager')),
		 
		 69   => array('name' => 'Telesales Manager', 'roles' => array('telesales_manager')),
		 
		 70   => array('name' => 'Sales Manager', 'roles' => array('telesales_manager')),
		 
		 72   => array('name' => 'Super Sales Manager', 'roles' => array('telesales_manager', 'manager', 'area_manager')),
		 
		 73   => array('name' => 'Manager', 'roles' => array('telesales_manager', 'manager')),
		 
		 75	  => array('name' => 'Area Manager', 'roles' => array('telesales_manager', 'manager', 'area_manager', 'best_solution', 'supplier')),
		 
		 80   => array('name' => 'Director', 'roles' => array('telesales_manager', 'manager', 'area_manager', 'best_solution', 'supplier')),
		 
		 97   => array('name' => 'Dialler Manager', 'roles' => array()),
		 
		 98   => array('name' => 'IT Support', 'roles' => array()),
		 
		 99   => array('name' => 'IT', 'roles' => array()),
		 
		 100  => array('name' => 'Super IT', 'roles' => array('superuser')),

	),

	/**
	 * Roles as name => array(location => rights)
	 */
	'roles' => array(
		 
		 'introducer' => array(
		 	'reports' => array('menu','disposition'),
		 ),
		 
		 'supplier' => array(
		 	'reports' => array('menu','supplier'),
		 ),
		 
		 'best_solution' => array(
		 	'reports' => array('menu','best_solutions')
		 ),
		 
		 'employee' => array(
		 	'support' => array('menu'),
		 ),
		 
		 'telesales_manager' => array(
		 	'reports' => array('menu','disposition'),
		 ),
		 
		 'manager' => array(
		 	'reports' => array(),
		 ),
		 
		 'area_manager' => array(
		 	'reports' => array('all_centers'),
		 ),
		 
		 'superuser' => true,
		 
	),

	/**
	 * Salt for the login hash
	 */
	'login_hash_salt' => 'welcometogregsonandbrookeintranet',

	/**
	 * $_POST key for login username
	 */
	'username_post_key' => 'username',

	/**
	 * $_POST key for login password
	 */
	'password_post_key' => 'password',
);
