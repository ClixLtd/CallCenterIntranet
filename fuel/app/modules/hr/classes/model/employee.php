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
                               U.id
                              ,username
                              ,name
                              ,CALL_CENTER.title AS center
                            FROM
                              users AS U
                            LEFT JOIN
                              call_centers AS CALL_CENTER ON U.call_center_id = CALL_CENTER.id 
                            WHERE
                              call_center_id = 2
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
                              DETAILS.user_id
                             ,forename
                             ,middle_name
                             ,surname
                             ,USER.email
                             ,USER.call_center_id
                             ,CALL_CENTER.title AS center_name
                             ,CALL_CENTER.created_at AS start_date
                           FROM
                             users AS USER
                           LEFT JOIN
                             hr_employee_details AS DETAILS ON USER.id = DETAILS.user_id
                           LEFT JOIN
                             call_centers AS CALL_CENTER ON USER.call_center_id = CALL_CENTER.id 
                           WHERE
                             USER.id = " . (int)static::$empID . "
                           LIMIT 1 
                          ", \DB::SELECT)->execute()->as_array();
     if(isset($result[0]))                   
       return $result[0];
     else
       return $result;
   }
 }
?>