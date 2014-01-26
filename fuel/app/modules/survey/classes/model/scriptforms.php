<?php
/**
 * Script Form Model - Script Module
 * 
 * @author David Stansfield
 */
 
 namespace Survey;
 
 class Model_ScriptForms extends \Model
 {
   protected static $_scriptFormID;
  
   public static function forge($scriptFormID = 0)
   {
     static::$_scriptFormID = $scriptFormID;
   }
  
   public static function scriptFormData()
   {
     $result = array();
     
     // -- Get the Script Form Information
     // ----------------------------------
     $form = \DB::query("SELECT
                             id
                            ,name
                            ,`repeat`
                           FROM
                             scripts_forms
                           WHERE
                             id = " . static::$_scriptFormID . "
                           LIMIT 1
                          ", \DB::SELECT)->execute()->as_array();
                                        
     if(isset($form[0]))
     {
       $result = $form[0];
       
       unset($form);
       
       // -- Get the questions
       // --------------------
       $result['questions'] = \DB::query("SELECT
                                            QUESTIONS.id
                                           ,QUESTIONS.script_form_id
                                           ,QUESTIONS.question
                                           ,QUESTIONS.type_field_id
                                           ,TYPE_FIELDS.type AS field_type
                                           ,QUESTIONS.required
                                          FROM
                                            scripts_forms_questions AS QUESTIONS
                                          INNER JOIN
                                            type_scripts_forms_fields AS TYPE_FIELDS ON QUESTIONS.type_field_id = TYPE_FIELDS.id
                                          WHERE
                                            QUESTIONS.script_form_id = " . static::$_scriptFormID . "
                                         ", \DB::SELECT)->execute()->as_array();
                                                       
       // -- No get all the answers for the questions  is any
       // ---------------------------------------------------
       foreach($result['questions'] as $key => $question)
       {
         $answers = \DB::query("SELECT
                                  id
                                 ,script_forms_question_id
                                 ,option_name
                                 ,option_value
                                FROM
                                  scripts_forms_answers
                                WHERE
                                  script_forms_question_id = " . (int)$question['id'] . "
                               ", \DB::SELECT)->execute()->as_array();
                               
         if(isset($answers[0]))
         {
           $result['questions'][$key]['options'] = $answers;
         }
       }
     }
    
     return $result;
   }
   
   /**
    * Load a select response from either a referral ID, or client ID, with Type
    * 
    * @author David Stansfield
    * @param referralID int, clientID int, type int
    * @return array
    */
   public static function loadResponse($referralID = 0, $clientID = 0, $typeID = 0)
   {
     if($referralID == 0 && $clientID == 0)
       throw new \Exception('Script Form Model: Referral ID and Client ID are 0');
       
     $where = '';
     
     if($referralID > 0)
       $where = 'referral_id = ' . (int)$referralID;
     else if($clientID > 0)
       $where = 'client_id = ' . (int)$clientID;
       
     $results = \DB::query("SELECT
                              RESPONSE.repeat_group
                             ,QUESTION.question
                             ,RESPONSE.answer
                            FROM
                              scripts_forms_responses AS RESPONSE
                            INNER JOIN
                              scripts_forms_questions AS QUESTION ON RESPONSE.script_forms_question_id = QUESTION.id
                            WHERE
                              RESPONSE.response_log_id = (
                                                           SELECT
                                                             id
                                                           FROM
                                                             scripts_forms_responses_log
                                                           WHERE
                                                             " . $where . "
                                                           " . ((int)$typeID > 0 ?  " AND script_type_id = " . $typeID : false) . "
                                                           ORDER BY
                                                             created_at DESC
                                                           LIMIT 1
                                                         )                                            
                          ", \DB::SELECT)->execute()->as_array();
                          
     $form = array();
                          
     if(count($results) > 0)
     {
       foreach($results as $result)
       {
         $form[$result['repeat_group']][] = $result;
       }
     }
                          
     return $form;
   }
  
   public static function createScriptForm(array $data)
   {
     list($scriptFormID, $rows) = \DB::query("INSERT INTO
                                                scripts_forms
                                              (
                                                id
                                               ,name
                                               ,`repeat`
                                               ,`active`
                                               ,rebuttal_script
                                               ,created_at
                                              )
                                              VALUES
                                              (
                                                NULL
                                               ," . \DB::quote($data['name']) . "
                                               ," . \DB::quote($data['repeat']) . "
                                               ,''
                                               ,'yes'
                                               ," . time() . "
                                              )
                                             ")->execute();
                                         
     if((int)$scriptFormID == 0)
       return false;
                                         
     if(isset($data['fields']) && count($data['fields']) > 0)
     {
       foreach($data['fields'] as $field)
       {
         // -- Save the questions
         // ---------------------
         list($questionID, $rows) = \DB::query("INSERT INTO
                                                  scripts_forms_questions
                                                (
                                                  id
                                                 ,script_form_id
                                                 ,question
                                                 ,type_field_id
                                                 ,required
                                                )
                                                VALUES
                                                (
                                                  NULL
                                                 ," . (int)$scriptFormID . "
                                                 ," . \DB::quote($field['question']) . "
                                                 ," . (int)$field['fieldType'] . "
                                                 ," . \DB::quote((isset($field['required']) && $field['required'] == 'on' ? 'yes' : 'no')) . "
                                                )
                                               ", \DB::INSERT)->execute();
         
         // -- Save the Option Answers if any have been added
         // -------------------------------------------------             
         if(isset($field['options']) && count($field['options']) > 0)
         {
           foreach($field['options'] as $option)
           {
             list($answerID, $rows) = \DB::query("INSERT INTO
                                                  scripts_forms_answers
                                                (
                                                  id
                                                 ,script_forms_question_id
                                                 ,option_name
                                                 ,option_value
                                                )
                                                VALUES
                                                (
                                                  NULL
                                                 ," . (int)$questionID . "
                                                 ," . \DB::quote($option['value']) . "
                                                 ," . \DB::quote($option['value']) . "
                                                )
                                               ", \DB::INSERT)->execute();
           }
         }
         
         // -- Save Product Information
         // ---------------------------
         if(isset($field['products']) && count($field['products']) > 0)
         {
           #print_r($field['products']);
           #die();
           
           foreach($field['products'] as $product)
           {
             list($questionProductID,) = \DB::query("INSERT INTO
                                                     scripts_forms_questions_products
                                                   (
                                                     id
                                                    ,question_id
                                                    ,product_id
                                                    ,positive_value
                                                    ,negative_value
                                                    ,weight
                                                    ,priority
                                                   )
                                                   VALUES
                                                   (
                                                     NULL
                                                    ," . (int)$questionID . "
                                                    ," . (int)$product['product'] . "
                                                    ," . \DB::quote($product['positive']) . "
                                                    ," . \DB::quote($product['negative']) . "
                                                    ,0
                                                    ," . (int)$product['priority'] . "
                                                   )
                                                  ", \DB::INSERT)->execute();
           }
         }
       }
     }
     
     return $scriptFormID;
   }
   
   public static function nameExists($name = '')
   {
     if($name == '')
       throw new \Exception('Script Form Model: Cannot check name, value is empty');
       
     $result = \DB::query("SELECT
                             id
                           FROM
                             scripts_forms
                           WHERE
                             name = " . \DB::quote($name) . "
                           LIMIT 1
                          ")->execute()->as_array();
                          
     if(isset($result['id']))
       return true;
     else
       return false;
   }
   
   public static function loadScriptFormTypes()
   {
     $results = array();
     $results = \DB::query("SELECT
                              id
                             ,description
                             ,type
                             ,ajax_call
                            FROM
                              type_scripts_forms_fields
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
   
   public static function loadScriptForms()
   {
     $results = array();
     $results = \DB::query("SELECT
                              id
                             ,name
                             ,`repeat`
                             ,active
                             ,created_at
                            FROM
                              scripts_forms
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
   
   public static function saveScriptForm($referralID, $clientID, $userID = 0, $scriptTypeID = 0, $scriptFormID = 0, array $data)
   {
     // -- Save the Response to the Response Log
     // ----------------------------------------
     list($responseLogID, $rows) = \DB::query("INSERT INTO
                                                 scripts_forms_responses_log
                                               (
                                                 id
                                                ,referral_id
                                                ,client_id
                                                ,script_type_id
                                                ,user_id
                                                ,created_at
                                               )
                                               VALUES
                                               (
                                                 NULL
                                                ," . (int)$referralID . "
                                                ," . (int)$clientID . "
                                                ," . (int)$scriptTypeID . "
                                                ," . (int)$userID . "
                                                ," . time() . "
                                               )
                                              ")->execute();
    
     $questionData = array();
     
     $questionData['response_log_id'] = (int)$responseLogID;
     $questionData['script_forms_id'] = (int)$scriptFormID;
     $questionData['reference'] = 1;
     
     $saved = false;
     
     foreach($data as $key => $answers)
     {
       if($key == '1')
       {
         foreach($answers as $questionID => $answerItem)
         {
           $questionData['script_forms_question_id'] = (int)$questionID;
           $questionData['repeat_group'] = 0;
           
           if(isset($answerItem['answer']) && is_array($answerItem['answer']))
           {
             foreach($answerItem['answer'] as $answer)
             {
               $questionData['script_forms_answer_id'] = $answer;
               $answerValue = \DB::query("SELECT
                                            option_name
                                          FROM
                                            scripts_forms_answers
                                          WHERE
                                            id = " . (int)$answer . "
                                          LIMIT 1 
                                         ", \DB::SELECT)->execute()->as_array();
                                         
               if(isset($answerValue[0]['option_name']))
                 $questionData['answer'] = $answerValue[0]['option_name'];
               else
                 $questionData['answer'] = '';
               
               // -- Save to DB
               // -------------
               if(static::saveFormAnswer($questionData) === true)
                 $saved = true;
               else
                 $saved = false;
             }
           }
           else
           {
             $questionData['script_forms_answer_id'] = 0;
             
             if(isset($answerItem['answer']))
             {
               $questionData['answer'] = $answerItem['answer'];
             }
             else
             {
               $questionData['answer'] = '';
             }
             
             if(static::saveFormAnswer($questionData) === true)
                 $saved = true;
               else
                 $saved = false;
           }
         }
       }
       if($key == 'Repeat')
       {
         foreach($answers as $group => $answerGroup)
         {
           $questionData['repeat_group'] = $group;
           
           foreach($answerGroup as $questionID => $answerItem)
           {
             $questionData['script_forms_question_id'] = (int)$questionID;
             
             if(is_array($answerItem['answer']))
             {
               foreach($answerItem['answer'] as $answer)
               {
                 $questionData['script_forms_answer_id'] = $answer;
                 $answerValue = \DB::query("SELECT
                                              option_name
                                            FROM
                                              scripts_forms_answers
                                            WHERE
                                              id = " . (int)$answer . "
                                            LIMIT 1
                                           ", \DB::SELECT)->execute()->as_array();
                                           
                 $questionData['answer'] = $answerValue[0]['option_name'];
                 
                 // -- Save to DB
                 // -------------
                 if(static::saveFormAnswer($questionData) === true)
                 $saved = true;
               else
                 $saved = false;
               }
             }
             else
             {
               $questionData['script_forms_answer_id'] = 0;
               $questionData['answer'] = $answerItem['answer'];
               
               if(static::saveFormAnswer($questionData) === true)
                 $saved = true;
               else
                 $saved = false;
             }
           }
         }
       }
     }
     
     return (int)$responseLogID;
   }
   
   private static function saveFormAnswer(array $data)
   {
     list($id,) = \DB::query("INSERT INTO
                               scripts_forms_responses
                             (
                               id
                              ,response_log_id
                              ,script_forms_id
                              ,script_forms_question_id
                              ,script_forms_answer_id
                              ,repeat_group
                              ,answer
                             )
                             VALUES
                             (
                               NULL
                              ," . (int)$data['response_log_id'] . "
                              ," . (int)$data['script_forms_id'] . "
                              ," . (int)$data['script_forms_question_id'] . "
                              ," . (int)$data['script_forms_answer_id'] . "
                              ," . (int)$data['repeat_group'] . "
                              ," . \DB::quote($data['answer']) . "
                             )
                            ", \DB::INSERT)->execute();
                            
     if((int)$id > 0)
       return true;
     else
       return false;
   }
   
   public static function loadProducts()
   {
     $reuslts = array();
     $results = \DB::query("SELECT
                              id
                             ,name
                             ,description
                            FROM
                              scripts_forms_products
                            ORDER BY
                              name ASC
                           ", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }
   
   public static function loadProductsRecomendations($logID = 0)
   {       
     // -- Get a list of unique products for each question
     // --------------------------------------------------
     $products = array();
     $products = \DB::query("SELECT
                               product_id
                              ,name AS product_name
                              ,SUM(priority) AS score
                              ,COUNT(product_id) AS total_products
                             FROM
                             (
                             SELECT
                               QUESTIONS.product_id
                              ,PRODUCTS.name
                              ,QUESTIONS.priority
                             FROM
                               scripts_forms_responses AS RESPONSE
                             INNER JOIN
                               scripts_forms_questions_products AS QUESTIONS ON RESPONSE.answer = QUESTIONS.positive_value AND RESPONSE.script_forms_question_id = QUESTIONS.question_id
                             INNER JOIN
                               scripts_forms_products AS PRODUCTS ON QUESTIONS.product_id = PRODUCTS.id
                             WHERE
                               RESPONSE.response_log_id = " . (int)$logID . "
                             AND
                               RESPONSE.script_forms_question_id IN (SELECT id FROM scripts_forms_questions WHERE script_form_id = " . static::$_scriptFormID . ")
                             GROUP BY
                               RESPONSE.script_forms_question_id
                             ) AS DATA_TABLE
                             GROUP BY
                               product_id
                             ORDER BY
                               score ASC
                              ,total_products DESC
                            ", \DB::SELECT)->execute()->as_array();
                            
     return $products;
   }
   
   public static function saveResponseProducts($logID = 0)
   {
     $data = array();
     $data = static::loadProductsRecomendations($logID);
     
     if(count($data) == 0)
       return;
       
     foreach($data as $value)
     {
       list($id,) = \DB::query("INSERT INTO
                                scripts_forms_responses_products
                              (
                                id
                               ,response_log_id
                               ,product_id
                               ,callback
                              )
                              VALUES
                              (
                                NULL
                               ," . (int)$logID . "
                               ," . (int)$value['product_id'] . "
                               ,'no'
                              )
                             ", \DB::INSERT)->execute();
     }
   }
   
   public static function loadRebuttalURL()
   {
     $result = array();
     $result = \DB::query("SELECT
                             rebuttal_script
                           FROM
                             scripts_forms
                           WHERE
                             id = " . static::$_scriptFormID . "
                           LIMIT 1
                          ", \DB::SELECT)->execute()->as_array();
                          
     if(isset($result[0]['rebuttal_script']))
       return $result[0]['rebuttal_script'];
     else
       return '';
   }
 }