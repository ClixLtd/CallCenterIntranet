<?php
/**
 * Client Area - Database Class for connecting to different Debtsolv's
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;
 
 class Database
 {
   private static $_database;
   
   private $_connection = null;
   private $_active = null;
   
   private $_debtsolvDatabase = null;
   private $_leadpoolDatabase = null;
   
   private $_companyID = 0;
   private $_companyAlias = null;
   
   public static function connect($companyID = 0)
   {
     if(!self::$_database)
       self::$_database = new Database((int)$companyID);
     
     return self::$_database;
   }
   
   private function __construct($companyID)
   {
     $this->_companyID = (int)$companyID;
     
     if($this->_companyID > 0)
     {
       $this->_setDebtsolvDatabase();
     }
     else
     {
       throw new \Exception('Invalid Company ID. ID id 0');
     }
   }
   
   private function _setDebtsolvDatabase()
   {
     // -- Get the Alias of the company based on Company ID
     // ---------------------------------------------------
     $result = \DB::query("SELECT
                             alias
                            ,active
                           FROM
                             clientarea_companies
                           WHERE
                             id = " . (int)$this->_companyID . "
                           LIMIT 1                           
                          ", \DB::select())->execute()->as_array();
                          
     if(isset($result[0]['alias']))
     {
       $this->_companyAlias = $result[0]['alias'];
       $this->_active = $result[0]['active'];
       
       \Config::load('clientarea', 'debtsolv');
       
       $this->_debtsolvDatabase = \Config::get('debtsolv.' . $this->_companyAlias . '.debtsolv_db', $this->_debtsolvDatabase);
       $this->_leadpoolDatabase = \Config::get('debtsolv.' . $this->_companyAlias . '.debtsolv_db', $this->_leadpoolDatabase);
       
       $this->_connection = \Database_Connection::instance('Debtsolv', \Config::get('debtsolv.' . $this->_companyAlias . '.database', $this->_connection));
       
       if($this->_connection instanceof \Database_Connection)
         \Log::info('CLIENT AREA: Database connected for for Company ' . $this->_companyAlias);
       else
         \Log::error('CLIENT AREA: Failed to connect to ' . $this->_companyAlias);
     }
     else
     {
       \Log::error('CLIENT AREA: Failed to connect to company ID ' . (int)$this->_companyID);
     }
   }
   
   public function isActive()
   {
     if($this->_active == 'YES')
       return true;
     else
       return false;
   }
   
   public function connection()
   {
     return $this->_connection;
   } 
   
   public function debtsolvDBName()
   {
     return $this->_debtsolvDatabase;
   }
   
   public function leadpoolDBName()
   {
     return $this->_leadpoolDatabase;
   }
 }