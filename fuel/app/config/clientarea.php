<?php

return array(

  // -- Expert Money Solutions Connection
  // ------------------------------------
  'expertmoneysolutions' => array(
    'type'       => 'pdo',
    'connection' => array(
      'dsn'       => 'dblib:host=192.168.3.31:1433;dbname=LeadPool_MMS',
      #'dsn'        => 'sqlsrv:Server=192.168.3.31,1433;Database=LeadPool_MMS',
      'username'	 => 'debtsolv',
      'password'	 => '76GerZnu871',
      'persistent' => false,
      ),
    'Identifier'  => '' ,
    'Charset'     => '',
    'profiling'   => true,
  ),

  // -- Expert Money Solutions Connection
  // ------------------------------------
  'clixmedia' => array(
      'type'       => 'pdo',
      'connection' => array(
          'dsn'       => 'dblib:host=192.168.3.31:1433;dbname=LeadPool_MMS',
          #'dsn'        => 'sqlsrv:Server=192.168.3.31,1433;Database=LeadPool_MMS',
          'username'	 => 'debtsolv',
          'password'	 => '76GerZnu871',
          'persistent' => false,
      ),
      'Identifier'  => '' ,
      'Charset'     => '',
      'profiling'   => true,
  ),
		
);

/* End of Debtsolv Config */
