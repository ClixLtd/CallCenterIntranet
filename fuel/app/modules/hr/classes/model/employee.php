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
                             ,position_level_id
                             ,date_of_birth
                             ,building
                             ,street_and_number
                             ,district
                             ,town
                             ,county
                             ,post_code
                             ,telephone_home
                             ,telephone_mobile
                             ,telephone_other
                             ,USER.email
                             ,profile_completed
                           FROM
                             staffs AS STAFF
                           LEFT JOIN
                             call_centers AS CALL_CENTER ON STAFF.center_id = CALL_CENTER.id
                           LEFT JOIN
                             users AS USER ON STAFF.intranet_id = USER.id
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
    * Load up the employee's Tax and Pay Details
    * 
    * @author David Stansfield
    */
   public static function loadTaxAndPay()
   {
     $result = array();
     $result = \DB::query("SELECT
                              tax_code_id
                             ,tin_number
                             ,phil_health_number
                             ,sss_number
                             ,basic_pay_override
                             ,managers_bonus
                             ,time_bonus
                             ,bank
                             ,account_number
                           FROM
                             hr_employee_tax_and_pay
                           WHERE
                             employee_id = " . static::$empID . "
                           LIMIT 1
                          ", \DB::SELECT)->execute()->as_array();
                          
     if(isset($result[0]))
       return $result[0];
     else
       return $result;
   }
   
   /**
    * Load Up Job Role
    * 
    * @author David Stansfield
    */
   public static function loadJobRole()
   {
     $result = array();
     $result = \DB::query("SELECT
                              LEVEL.id AS level_id
                             ,LEVEL.name AS level_name
                             ,POSITION.id AS position_id
                             ,POSITION.job_role AS position_job_role
                             ,DEPARTMENT.id AS department_id
                             ,DEPARTMENT.name AS department_name
                           FROM
                             staffs AS STAFF
                           INNER JOIN
                             hr_department_position_level AS LEVEL ON STAFF.position_level_id = LEVEL.id
                           INNER JOIN
                             hr_department_positions AS POSITION ON LEVEL.position_id = POSITION.id
                           INNER JOIN
                             hr_departments AS DEPARTMENT ON POSITION.department_id = DEPARTMENT.id
                           WHERE
                             STAFF.id = " . static::$empID . "
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
   
   /**
    * Save employee details
    * 
    * @author David Stansfield
    */
   public static function saveEmployeeDetails($data = array())
   {
     if(count($data) == 0)
       return false;
       
     $result = 0;
     $result = \DB::query("UPDATE
                             staffs
                           SET
                              first_name = " . \DB::quote($data['Profile-Forename']) . "
                             ,last_name = " . \DB::quote($data['Profile-Surname']) . "
                             ,date_of_birth = " . \DB::quote(date("Y-m-d", strtotime($data['Profile-Date-of-Birth']))) . "
                             ,building = " . \DB::quote($data['Profile-Building']) . "
                             ,street_and_number = " . \DB::quote($data['Profile-Street-and-Number']) . "
                             ,district = " . \DB::quote($data['Profile-District']) . "
                             ,town = " . \DB::quote($data['Profile-Town']) . "
                             ,county = " . \DB::quote($data['Profile-County']) . "
                             ,post_code = " . \DB::quote($data['Profile-Post-Code']) . "
                             ,telephone_home = " . str_replace(" ", "", $data['Profile-Telephone-Home']) . "
                             ,telephone_mobile = " . str_replace(" ", "", $data['Profile-Telephone-Mobile']) . "
                             ,telephone_other = " . str_replace(" ", "", $data['Profile-Telephone-Other']) . "
                           WHERE
                             id = " . static::$empID . "
                           LIMIT 1
                          ", \DB::UPDATE)->execute();
                                      
     #if($result > 0)
       return true;
     #else
     #  return false;
   }
   
   /**
    * Save Tax and Pay
    * 
    * @author David Stansfield
    */
   public static function saveTaxandPay($data = array())
   {
     if(count($data) == 0)
       return false;
       
     $result = 0;
     $result = \DB::query("REPLACE INTO
                             hr_employee_tax_and_pay
                           (
                              employee_id
                             ,tax_code_id
                             ,tin_number
                             ,phil_health_number
                             ,sss_number
                             ,basic_pay_override
                             ,managers_bonus
                             ,time_bonus
                             ,bank
                             ,account_number
                           )
                           VALUES
                           (
                              " . static::$empID . "
                             ," . (int)$data['Tax-Code'] . "
                             ," . \DB::quote($data['Tin-Number']) . "
                             ," . \DB::quote($data['PhilHealth-Number']) . "
                             ," . \DB::quote($data['SSS-Number']) . "
                             ," . \DB::quote($data['Basic-Salary-Override']) . "
                             ," . \DB::quote($data['Managers-Bonus']) . "
                             ," . \DB::quote($data['Time-Bonus']) . "
                             ," . \DB::quote($data['Bank']) . "
                             ," . \DB::quote($data['Account-Number']) . "
                           )
                          ", \DB::INSERT)->execute();
                          
     return true;
   }
   
   /**
    * Save Job Role
    * 
    * @author David Stansfield
    */
   public static function changeJobPosition($positionLevelID = 0)
   {
     if((int)$positionLevelID == 0)
       return false;
       
     $result = 0;
     $result = \DB::query("UPDATE
                             staffs
                           SET
                             position_level_id = " . (int)$positionLevelID . "
                           WHERE
                             id = " . static::$empID . "
                           LIMIT 1
                          ", \DB::UPDATE)->execute();
                          
     return true;
   }
   
   /**
    * Set profile as completed
    * 
    * @author David Stansfield
    */
   public static function setProfileAsCompleted()
   {
     \DB::query("UPDATE
                   staffs
                 SET
                   profile_completed = 'yes'
                 WHERE
                   id = " . static::$empID . "
                 LIMIT 1
                ", \DB::UPDATE)->execute();
   }
   
   /**
    * Save Employee Tax and Pay
    * 
    * @author David Stansfield
    */
   public static function saveEmployeeTaxandPay($data = array())
   {
     if(count($data) == 0)
       return false;
       
     list($id, $row) = \DB::query("REPLACE INTO
                                     
                                  ");
   }
 }
?>