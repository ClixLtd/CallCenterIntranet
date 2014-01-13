<?php
/**
 * Ajax Controller - Script Module
 * 
 * @author David Stansfield
 */
 
 namespace Survey;
 
 class Controller_Ajax extends \Controller_BaseHybrid
 {
   public function post_create_update_script()
   {
     $status = '';
     
     if(Script::createUpdateScript(\Input::post()) === true)
       $status = 'SUCCESS';
     else
       $status = 'FAILED';
     
     $this->response(array(
       'status' => $status,
     ));
   }
   
   public function post_load_all_scripts()
   {
     $results = array();
     $results = Script::loadAllScripts();
     
     $this->response(array(
       'status' => 'SUCCESS',
       'results' => $results,
     )); 
   }
   
   public function post_load_script_form_output($scriptFormID)
   {
     $Script = new ScriptForms((int)$scriptFormID);
     $results = array();
     
     $results = $Script->generateForm();
     
     $this->response(array(
       'status' => 'SUCCESS',
       'results' => $results,
     ));
   }
   
   public function post_save_form()
   {
     print_r(\Input::post());
     
     die();
   }
 }