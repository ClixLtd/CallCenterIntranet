<?php
/**
 * Debtsolv Client Class - Used Only for the Admin Side of the Client Area
 * 
 * @author David Stansfield
 */
 namespace Clientarea;
 
 class Client
 {
   protected $_clientID;
   protected $_companyID;
   protected $_values = array();
  
   public static function forge($clientID = 0, $companyID = 0)
   {
     return new static($clientID, $companyID);
   }
   
   private function __construct($clientID, $companyID)
   {
     $this->_clientID   = $clientID;
     $this->_companyID  = $companyID;
     
     // -- Set the variables for the database
     // -------------------------------------
     Model_ClientArea::forge($companyID, $clientID); 
     #\Log::info('COmpany ID is ' . $companyID);
     $this->load();
   }
   
   public function __get($what)
   {
     if(array_key_exists($what, $this->_values))
     {
       return $this->_values[$what];
     }
   }
   
   private function load()
   {
     $results = array();
     
     $results = Model_ClientArea::loadDsClient();
     
     if(count($results) > 0)
     {
       $this->_values = $results;
     }
   }
   
   public function fullName()
   {
     $name = '';
     
     $name  = (isset($this->_values['Title']) ? $this->_values['Title'] . ' ' : false);
     $name .= (isset($this->_values['Forename']) ? $this->_values['Forename'] . ' ' : false);
     $name .= (isset($this->_values['Surname']) ? $this->_values['Surname'] : false);
     
     return rtrim($name);
   }
 }