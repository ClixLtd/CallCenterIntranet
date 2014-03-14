<?php

return array(

  // -- Money Management Services
  // ----------------------------
  'moneymanagementservices' => array(
    'database' => array(
      'type'       => 'pdo',
      'connection' => array(
      #'dsn'       => 'dblib:host=192.168.3.31:1433;dbname=Debtsolv_MMS',
      'dsn'        => 'sqlsrv:Server=192.168.3.31,1433;Database=Debtsolv_MMS',
      'username'	 => 'debtsolv',
      'password'	 => '76GerZnu871',
      'persistent' => false,
      ),
    ),
    'Identifier'  => '' ,
    'Charset'     => '',
    'profiling'   => true,
    'debtsolv_db' => 'Debtsolv_MMS_HAHA',
    'leadpool_db' => 'Leadpool_MMS_HAA2',
  ),

  // -- Expert Money Solutions Connection
  // ------------------------------------
  'expertmoneysolutions' => array(
    'database' => array(
      'type'       => 'pdo',
      'connection' => array(
      #'dsn'       => 'dblib:host=192.168.3.31:1433;dbname=Debtsolv',
      'dsn'        => 'sqlsrv:Server=192.168.1.100,1334;Database=Debtsolv',
      'username'	 => 'superuser',
      'password'	 => 'Rfd32xs12B',
      'persistent' => false,
      ),
    ),
    'Identifier'  => '' ,
    'Charset'     => '',
    'profiling'   => true,
    'debtsolv_db' => 'Debtsolv',
    'leadpool_db' => 'Leadpool_DM',
  ),
  
  // -- 1-Tick
  // ---------
  '1-tick' => array(
    'database' => array(
      'type'       => 'pdo',
      'connection' => array(
      #'dsn'       => 'dblib:host=192.168.3.31:1433;dbname=Debtsolv',
      'dsn'        => 'sqlsrv:Server=192.168.1.100,1334;Database=Debtsolv',
      'username'	 => 'superuser',
      'password'	 => 'Rfd32xs12B',
      'persistent' => false,
      ),
    ),
    'Identifier'  => '' ,
    'Charset'     => '',
    'profiling'   => true,
    'debtsolv_db' => 'Debtsolv',
    'leadpool_db' => 'Leadpool_DM',
  ),
		
);

/* End of Debtsolv Config */
