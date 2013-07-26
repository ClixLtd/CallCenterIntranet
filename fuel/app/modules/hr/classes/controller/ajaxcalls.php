<?php
/**
 * Ajax Calls
 * 
 * @author David Stansfield
 */
 
 namespace Hr;
 
 class Controller_Ajaxcalls extends \Controller_BaseHybrid
 {
   public function action_department_position_list($department_id = 0)
   {
     $results = array();
     $results = Model_Department::loadPositions($department_id);
     
     $this->response(array(
			'status' => 'SUCCESS',
      'results' => $results,
		));
   }
   
   public function action_department_posistion_level_list($positionID = 0, $levelID = 0)
   {
     $results = array();
     $results = Model_Department::loadPositionLevels($positionID, $levelID);
     
     $this->response(array(
			'status' => 'SUCCESS',
      'results' => $results,
		));
   }
   
   public function action_save_profile($empID = 0)
   {
     
   }
 }