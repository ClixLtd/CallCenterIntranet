<?php
/**
 * Employees Model
 * 
 * @author David Stansfield
 */
 
 namespace Hr;
 
 class Model_Employee extends \Model
 {
   protected static $empID = 0;
   
   public static function forge($empID = 0)
   {
     if($empID <= 0)
       return;
       
     static::$empID = $empID;
   }
  
   public static function listStaff()
   {
     $results = array();
     $results = \DB::query("SELECT
                               STAFF.id
                              ,CONCAT(first_name, ' ', last_name) AS name
                              ,CALL_CENTER.title AS center
                            FROM
                              staffs AS STAFF
                            LEFT JOIN
                              call_centers AS CALL_CENTER ON STAFF.center_id = CALL_CENTER.id 
                            WHERE
                              center_id = 2
                            ORDER BY
                              name ASC
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
   
   /**
    * Load up basic information on the employee
    * 
    * @author David Stansfield
    */
   public static function loadEmployee()
   {
     $result = array();
     $result = \DB::query("SELECT
                              STAFF.id
                             ,first_name
                             ,last_name
                             ,center_id
                             ,CALL_CENTER.title AS center_name
                             ,STAFF.created_at AS start_date
                           FROM
                             staffs AS STAFF
                           LEFT JOIN
                             call_centers AS CALL_CENTER ON STAFF.center_id = CALL_CENTER.id 
                           WHERE
                             STAFF.id = " . (int)static::$empID . "
                           LIMIT 1
                          ", \DB::SELECT)->execute()->as_array();
     if(isset($result[0]))                   
       return $result[0];
     else
       return $result;
   }
   
   /**
    * Load Up the Tax Codes
    * 
    * @author David Stansfield
    */
   public static function loadTaxCodes()
   {
     $results = array();
     $results = \DB::query("SELECT
                               id
                              ,code
                            FROM
                              hr_type_tax_codes
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
 }
?>