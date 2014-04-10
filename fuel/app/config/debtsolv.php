<?php

return array(


	'connection' => array(
                'type'          => 'pdo',
                'connection'    => array(
                #'dsn'          => 'dblib:host=192.168.3.31:1433;dbname=LeadPool_MMS', //production
		        'dsn'           => 'sqlsrv:Server=192.168.3.31,1433;Database=LeadPool_MMS',
                    'username'	 => 'debtsolv',
                    'password'	 => '76GerZnu871',
                    'persistent'     => false,
                ),
                'Identifier'  => '' ,
                'Charset'    => '',
                'profiling' => true,
    ),

/*
	"connection" => array(
		'type'       => 'pdo',
		'connection' => array(
			'dsn'            => 'dblib:host=192.168.1.100:1334;',
		    'username'       => 'superuser',
		    'password'       => 'Rfd32xs12B',
		    'persistent'     => false,
		),
		'Identifier'  => '' ,
		'Charset'    => '',
		'profiling' => true,
	),

*/

	"debtsolv_database" => "Debtsolv_Test",
	"leadpool_database" => "LeadPool_Test",

	"bs_debtsolv_database" => "BS_Debtsolv_Test",
	"bs_leadpool_database" => "BS_LeadPool_Test",

		
);

/* End of Debtsolv Config */
