<?php

namespace Survey;

class Controller_Survey extends \Crm\Controller_Crm_SimpleHybrid
{
  public $template = 'template_survey';
  
  public function before()
  {
    parent::before();
  }
  
  public function action_live($apiKey = null, $surveyID = null)
  {
    $apiCheck = \Crm\Portal\Portal_Check::api_key($apiKey);
    
    if($apiCheck === false)
    {
      $this->template->content = \View::forge('invalidkey');
    }
    else
    {
      if((int)$surveyID == 0)
      {
        
      }
      else
      {
        $ScriptForm = new ScriptForms((int)$surveyID);
        
        $this->template->content = \View::forge('output', array(
          'apiKey' => $apiKey,
          'surveyForm' => $ScriptForm->generate(),
        ));
      }
    }
  }
}