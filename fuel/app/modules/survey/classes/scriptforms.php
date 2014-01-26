<?php
/**
 * Script Forms Class - Script Module
 * 
 * @author David Stansfield
 */
 
 namespace Survey;
 
 class ScriptForms
 {
   protected $_scriptFormID;
   
   public function __construct($scriptFormID = 0)
   {
     if((int)$scriptFormID == 0)
       throw new \Exception('Script Form Class: Script Form ID is 0');
       
     Model_ScriptForms::forge($scriptFormID);
     
     $this->_scriptFormID = (int)$scriptFormID;
   }
   
   public function generate()
   {
     $result = array();
     $result = Model_ScriptForms::scriptFormData();
     
     $output = '';
     $output = \View::forge('Survey::script_form_ouput', array(
       'form' => $result,
     ));
     
     return $output;
   }
   
   public function getRebuttalURL()
   {
     return Model_ScriptForms::loadRebuttalURL();
   }
   
   public function scriptFormData()
   {
     return Model_ScriptForms::scriptFormData();     
   }
   
   public function getProductsRecomendations($logID = 0)
   {       
     // -- Get a list of unique products for each question
     // --------------------------------------------------
     $products = array();
     $products = Model_ScriptForms::loadProductsRecomendations((int)$logID);
                            
     return $products;
   }
   
   public function saveResponseProducts($logID = 0)
   {
     Model_ScriptForms::saveResponseProducts((int)$logID);
     
     return;
   }
   
   // **********************
   // *** Static Classes ***
   // **********************
   
   public static function saveFormData($referralID = 0, $clientID = 0, $userID = 0, $scriptTypeID = 0, $scriptFormsID = 0, array $data)
   {     
     if(count($data) == 0)
       return false;
       
     /*
     if(Model_ScriptForms::saveScriptForm($referralID, $clientID, $userID, $scriptTypeID, $scriptFormsID, $data))
       return true;
     else
       return false;
     */
     $responseLogID = 0;
     $responseLogID = Model_ScriptForms::saveScriptForm($referralID, $clientID, $userID, $scriptTypeID, $scriptFormsID, $data);
     
     return $responseLogID;
   }
   
   public static function createForm(array $data)
   {
     if(count($data) == 0)
       throw new \Exception('Script Forms Class: Cannot create form, data array is empty');
       
     // -- Process the form before we save it
     // -------------------------------------
     $dataProcessed = array();
     
     $dataProcessed['name']       = $data['script_name'];
     $dataProcessed['repeat']     = isset($data['can_repeat']) ? ($data['can_repeat'] == 'yes' ? 'yes' : 'no') : 'no';
     $dataProcessed['fields']     = $data['fields'];
     
     unset($data);
     
     $result = array();
     $scriptFormID = 0;
     
     // -- Check to see if the Name exists
     // ----------------------------------
     if(Model_ScriptForms::nameExists($dataProcessed['name']) === true)
     {
       // -- Name found
       // -------------
     }
     else
     {
       // -- Name not found
       // -----------------
       $scriptFormID = Model_ScriptForms::createScriptForm($dataProcessed);
     }
     
     return $scriptFormID;
   }
   
   public static function loadScriptFormTypes()
   {
     $results = array();
     $results = Model_ScriptForms::loadScriptFormTypes();
     
     return $results;
   }
   
   public static function loadScriptForms()
   {
     $results = array();
     $results = Model_ScriptForms::loadScriptForms();
     
     return $results;
   }
   
   public static function loadResponse($referralID = 0, $clientID = 0, $typeID = 0)
   {
     $result = array();
     $result = Model_ScriptForms::loadResponse($referralID, $clientID, $typeID);
     
     return $result;    
   }
   
   public static function loadProducts()
   {
     $results = array();
     $results = Model_ScriptForms::loadProducts();
     
     return $results;
   }
 }