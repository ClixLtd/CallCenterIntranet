<?php
/**
 * Department Model
 * 
 * @author David Stansfield
 */
 
 namespace Hr;
 
 class Model_Department extends \Model
 {
   protected static $departmentID;
   
   public static function forge($departmentID = 0)
   {
     static::$departmentID = (int)$departmentID;
   }
   
   /**
    * Load Up the Departments. Can show Departments that belong to a perticular centre
    * 
    * @author David Stansfield
    */
   public static function loadDepartments($center = 0)
   {
     $where = '';
     
     if((int)$center > 0)
       $where = "WHERE center_id = " . (int)$center;
    
     $results = array();
     $results = \DB::query("SELECT
                               id
                              ,name
                            FROM
                              hr_departments
                            " . $where . "
                            ORDER BY
                              name ASC
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
   
   /**
    * Load Up all the Positions within a chosen Department
    * 
    * @author David Stansfield
    */
   public static function loadPositions($departmentID = 0)
   {
     $results = array();
     $results = \DB::query("SELECT
                               id
                              ,job_role
                            FROM
                              hr_department_positions
                            WHERE
                              department_id = " . (int)$departmentID . "
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
   
   /**
    * Load Up all the Positions Levels on a selected Position
    * 
    * @author David Stansfield
    */
   public static function loadPositionLevels($positionID = 0, $levelID = 0)
   {
     $results = array();
     $results = \DB::query("SELECT
                               id
                              ,name
                              ,basic_salary
                            FROM
                              hr_department_position_level
                            WHERE
                              position_id = " . (int)$positionID . "
                            " . ((int)$levelID > 0 ? 'AND id = ' . (int)$levelID : false) . "
                            ORDER BY
                              name ASC
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
 }
?>