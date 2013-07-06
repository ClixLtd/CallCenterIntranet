<?php
/**
 * Employee Class
 * 
 * @author David Stansfield
 */
 
 namespace Hr;
 
 class Employee
 {
   private static $_forge;
   
   protected $_empID;
   public $_values = array();
  
   public static function forge($empID = 0)
   {
     if(!self::$_forge)
       self::$_forge = new Employee($empID);
     
     return self::$_forge;
   }
   
   private function __construct($empID)
   {
     if((int)$empID == 0)
       return;
       
     $this->_empID = $empID;
     
     // -- Load the Model Up
     // --------------------
     Model_Employee::forge($empID);
     
     // -- Load the Employee
     // --------------------
     $this->load();
   }
   
   public function __get($what = null)
   {
     if(is_null($what))
       return;
       
     if(array_key_exists($what, $this->_values))
     {
       return $this->_values[$what];
     }
     else
     {
       return false;
     }
   }
   
   public function __set($what = null, $value = '')
   {
     if(is_null($what))
       return;
       
     if(array_key_exists($what, $this->_values))
     {
       $this->_values[$what] = $value;
     }
   }
   
   /**
    * Load Employee Details
    * 
    * @author David Stansfield
    */
   private function load()
   {
     $result = array();
     $result = Model_Employee::loadEmployee();
     
     if(count($result) > 0)
     {
       $this->_values = $result;
     }
   }
   
   /** Return all the data in the values array
    * 
    * @author David Stansfield
    */
   public function getDetails()
   {
     return $this->_values;
   }
   
   public function hasDetails()
   {
     if(isset($this->_values['user_id']) && $this->_values['user_id'] > 0)
       return true;
     else
       return false;
   }
 }
?>