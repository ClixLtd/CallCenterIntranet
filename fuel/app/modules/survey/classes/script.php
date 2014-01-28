<?php
/**
 * Script Class - Script Module
 * 
 * @author David Stansfield
 */
 
 namespace Survey;
 
 class Script
 {
  
   // -- Load all Scripts
   // -------------------
   public static function loadAllScripts()
   {
     $results = array();
     $results = Model_Script::loadAllScripts();
     
     return $results;
   }
   
   // -- Static Methods
   // -----------------
   public static function createUpdateScript(array $data)
   {
     $scriptID = 0;
     $scriptFormID = 0;
     #$scriptID = Model_Script::createUpdateScript($data);
     
     if(isset($data['form']['fields']) && count($data['form']['fields']) > 0)
     {
       $scriptFormID = ScriptForms::createForm($data['form']);
       
       #Model_Script::setScriptFormID($scriptFormID, $scriptID);
     }
     
     if($scriptFormID > 0)
       return true;
     else
       return false;
   }
   
   // -- Load Script Types
   // --------------------
   public static function loadScriptTypes()
   {
     $results = array();
     $results = Model_Script::loadScriptTypes();
     
     return $results;
   }
 }