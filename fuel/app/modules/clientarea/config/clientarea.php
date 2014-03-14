<?php

return array(

    'moneymanagementservices' => array(
        'database' => array(
            'type'       => 'pdo',
            'connection' => array(
                'dsn'       => 'dblib:host=192.168.3.31:1433;dbname=Debtsolv_MMS',
                #'dsn'        => 'sqlsrv:Server=192.168.3.31,1433;Database=LeadPool_MMS',
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

    'expertmoneysolutions' => array(
        'database' => array(
            'type'       => 'pdo',
            'connection' => array(
                'dsn'            => 'dblib:host=192.168.3.11:1433;dbname=Debtsolv_GABFS',
                #'dsn'        => 'sqlsrv:Server=192.168.3.11,1433;Database=LeadPool_DM',
                'username'	 => 'sa',
                'password'	 => 'kC934CEWew2',
                'persistent' => false,
            ),
        ),
        'Identifier'  => '' ,
        'Charset'     => '',
        'profiling'   => true,
        'debtsolv_db' => 'Debtsolv_GABFS',
        'leadpool_db' => 'LeadPool_GABFS'
    ),

    '1-tick' => array(
        'database' => array(
            'type'       => 'pdo',
            'connection' => array(
                'dsn'            => 'dblib:host=192.168.1.100:1334;dbname=Debtsolv',
                #'dsn'        => 'sqlsrv:Server=192.168.1.100,1334;Database=LeadPool_DM',
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

);

/* End of Debtsolv Config */
