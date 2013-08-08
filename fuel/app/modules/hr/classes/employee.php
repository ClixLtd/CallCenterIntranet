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
   
   /**
    * Find out if the employee profile has been completed
    * 
    * @author David Stansfield
    */
   public function profileCompleted()
   {
     if($this->_values['profile_completed'] == 'no')
       return false;
     else
       return true;
   }
   
   /** Return all the data in the values array
    * 
    * @author David Stansfield
    */
   public function getDetails()
   {
     return $this->_values;
   }
   
   /**
    * Return employee's Tax and Pay details
    * 
    * @author David Stansfield
    */
   public function getTaxAndPay()
   {
     $result = array();
     $result = Model_Employee::loadTaxAndPay();
     
     return $result;
   }
   
   /**
    * Return employee's job role and department
    * 
    * @author David Stansfield
    */
   public function getJobRole()
   {
     $result = array();
     $result = Model_Employee::loadJobRole();
     
     return $result;
   }
   
   /**
    * Save the full empoyee profile
    * 
    * @author David Stansfield
    */
   public function saveProfile($data = array())
   {
     if(Model_Employee::saveEmployeeDetails($data) === true)
     {
       $this->changeJobPosition($data['Position-Level']);
       
       // -- Save Tax and Pay if employee is from GBS
       // -------------------------------------------
       if($this->_values['center_id'] == 2)
       {       
         // -- Save Tax and Pay
         // -------------------
         Model_Employee::saveTaxandPay($data);
         
         if($this->profileCompleted() === false)
           Model_Employee::setProfileAsCompleted();
       }
      
       return true;
     }
     else
     {
       return false;
     }
   }
   
   /**
    * Change Job Position
    * 
    * @author David Stansfield
    */
   public function changeJobPosition($positionLevelID = 0)
   {
     Model_Employee::changeJobPosition((int)$positionLevelID);
     
     return true;
   }
 }
?>