<?php
/**
 * Script Model - Script Module
 * 
 * @author David Stansfield
 */
 
 namespace Survey;
 
 class Model_Script extends \Model
 {
   public static function loadAllScripts()
   {
     $results = array();
     $results = \DB::query("SELECT
                              SCRIPT.id
                             ,SCRIPT.script_type_id
                             ,TYPE_SCRIPT.description AS type_description
                             ,SCRIPT.name
                             ,SCRIPT.description
                             ,SCRIPT.active
                            FROM
                              scripts AS SCRIPT
                            INNER JOIN
                              type_scripts AS TYPE_SCRIPT ON SCRIPT.script_type_id = TYPE_SCRIPT.id
                            ORDER BY
                              name ASC
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
  
   public static function createUpdateScript(array $data)
   {
     if(count($data) == 0)
       throw new \Exception('Unable to create or update script: No data supplied');
       
     list($id, $rows) = \DB::query("REPLACE INTO
                                      scripts
                                    (
                                       id
                                      ,script_type_id
                                      ,name
                                      ,description
                                      ,script_text
                                      ,active
                                    )
                                    VALUES
                                    (
                                      NULL
                                      ," . (int)$data['script_type_id'] . "
                                      ," . \DB::quote($data['name']) . "
                                      ," . \DB::quote($data['description']) . "
                                      ," . \DB::quote($data['script_text']) . "
                                      ," . \DB::quote($data['active']) . "
                                    )
                                   ", \DB::INSERT)->execute();
                                   
     if(isset($data['offices']) && count($data['offices']) > 0)
     {
       // -- Save the Offices
       // -------------------
       if(isset($data['script_id']))
       {
         $currentOffices = \DB::query("SELECT
                                         office_id
                                       FROM
                                         offices_scripts
                                       WHERE
                                         script_id = " . (int)$data['script_id'] . "
                                      ", \DB::SELECT)->execute()->as_array();
                                      
         
       }
       else
       {
         // -- This is a new one
         // --------------------
         foreach($data['offices'] as $office)
         {
           \DB::query("INSERT INTO
                         offices_scripts
                       (
                         id
                        ,office_id
                        ,script_id
                        ,created_at
                       )
                       VALUES
                       (
                         NULL
                         ," . (int)$office . "
                         ," . (int)$id . "
                         ,NOW()
                       )
                      ", \DB::INSERT)->execute();
         }
       }
     }
     
     return $id;
   }
   
   public static function setScriptFormID($scriptFormID = 0, $scriptID = 0)
   {
     \DB::query("UPDATE
                   scripts
                 SET
                   script_form_id = " . (int)$scriptFormID . "
                 WHERE
                   id = " . (int)$scriptID . "
                 LIMIT 1
                ")->execute();
   }
   
   // -- Get a list of all the Script Types
   // -------------------------------------
   public static function loadScriptTypes()
   {
     $results = array();
     $results = \DB::query("SELECT
                              id
                             ,description
                            FROM
                              type_scripts
                            ORDER BY
                              description ASC
                           ")->execute()->as_array();
                           
     return $results;
   }
 }