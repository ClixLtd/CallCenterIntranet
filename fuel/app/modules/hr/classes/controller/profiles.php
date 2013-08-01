<?php
/**
 * Staff Profiles
 * 
 * @author David Stansfield
 */
 
 namespace Hr;
 
 class Controller_Profiles extends \Controller_BaseHybrid
 {
   /**
    * Staff Profiles
    * 
    * @author David Stansfield
    */
   public function action_index()
   {
     // -- Get a list of staff
     // ----------------------
     $staffList = array();
     $staffList = Model_Employee::listStaff();
    
     $this->template->title = 'Staff List | Human Resources';
     $this->template->content = \View::forge('profiles/index', array(
       'staffList' => $staffList,
     ));
   }
   
   /**
    * View Staff Profile
    * 
    * @author David Stansfield
    */
    public function action_view($empID = 0)
    {
      if((int)$empID == 0)
        return;
      
      $Employee = Employee::forge($empID);
      
      // -- Create a new Profile Data
      // ----------------------------
      $departmentsList = array();
      $departmentsList = Model_Department::loadDepartments((int)$Employee->center_id);
      $taxCodes = Model_Employee::loadTaxCodes();
      
      $this->template->title = 'View Profile | Human Resources';
      $this->template->content = \View::forge('profiles/view_profile',
                                               array('empID' => (int)$empID,
                                                     'employeeDeatils' => $Employee->getDetails(),
                                                     'taxAndPay' => $Employee->getTaxAndPay(),
                                                     'jobRole' => $Employee->getJobRole(),
                                                     'profileCompleted' => $Employee->profileCompleted(),
                                                     'departmentsList' => $departmentsList,
                                                     'taxCodes' => $taxCodes,
                                                    )
                                             );
    }
 }
?>