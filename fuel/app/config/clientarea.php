<?php

return array(

  // -- Expert Money Solutions Connection
  // ------------------------------------
   'moneymanagementservices' => array(
        'database' => array(
            'type'       => 'pdo',
            'connection' => array(
                #'dsn'       => 'dblib:host=192.168.3.31:1433;dbname=LeadPool_MMS',
                'dsn'        => 'sqlsrv:Server=192.168.3.31,1433;Database=LeadPool_MMS',
                'username'	 => 'debtsolv',
                'password'	 => '76GerZnu871',
                'persistent' => false,
            ),
        ),
        'Identifier'  => '' ,
        'Charset'     => '',
        'profiling'   => true,
        'debtsolv_db' => 'Debtsolv_MMS',
        'leadpool_db' => 'LeadPool_MMS',
   ),

  'clixmediaREMOVE' => array(
      'database' => array(
          'type'       => 'pdo',
          'connection' => array(
              #'dsn'            => 'dblib:host=192.168.1.100:1334;dbname=Leadpool_DM',
              'dsn'        => 'sqlsrv:Server=192.168.1.100,1334;Database=LeadPool_DM',
              'username'	 => 'superuser',
              'password'	 => 'Rfd32xs12B',
              'persistent' => false,
          ),
      ),
    'Identifier'  => '' ,
    'Charset'     => '',
    'profiling'   => true,
    'debtsolv_db' => 'Debtsolv',
    'leadpool_db' => 'LeadPool_DM'
  ),
    // -- Resolve
    // ----------
    'clixmedia' => array(
        'database' => array(
            'type'       => 'pdo',
            'connection' => array(
                'dsn'            => 'dblib:host=10.150.4.100:1433;dbname=BS_Leadpool_DM',
                #'dsn'        => 'sqlsrv:Server=10.150.4.100,1433;Database=BS_Leadpool_DM',
                'username'	 => 'superuser',
                'password'	 => '6532SaSfcDa34CV',
                'persistent' => false,
            ),
        ),
        'Identifier'  => '' ,
        'Charset'     => '',
        'profiling'   => true,
        'debtsolv_db' => 'BS_Debtsolv_DM',
        'leadpool_db' => 'BS_Leadpool_DM'
    ),
		
);

/* End of Debtsolv Config */
