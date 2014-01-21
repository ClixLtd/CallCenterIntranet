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
          'surveyID' => $surveyID,
          'surveyForm' => $ScriptForm->generate(),
        ));
      }
    }
  }
  
  public function get_save($apiKey, $surveyID = 0)
  {
    // -- Check API Key
    // ----------------
    $apiCheck = \Crm\Portal\Portal_Check::api_key($apiKey);
    
    if ($apiCheck === false)
		{
			$this->response(array(
				'status' => 'FAIL',
				'message' => 'Invalid API Key has been used, please contact your IT support!',
			));
		}
    else if((int)$surveyID == 0)
    {
      $this->response(array(
				'status' => 'FAIL',
				'message' => 'Invalid Survey ID, please contact your IT support!',
			));
    }
    else
    {
      // -- Save the Lead Details
      // ------------------------
      $Debtsolv = new Debtsolv();
      $Debtsolv->data(\Input::get());
      
      $leadpoolID = 1;
      #$leadpoolID = $Debtsolv->addNewLead();
      
      if((int)$leadpoolID > 0)
      {
        $responseLogID = 0;
        $responseLogID = ScriptForms::saveFormData($leadpoolID, 0, 0, 0, $surveyID, \Input::get('scriptForm'));
        
        $Survey = new ScriptForms($surveyID);
        
        // -- Save the Survey Results
        // --------------------------
        #if(ScriptForms::saveFormData($leadpoolID, 0, 0, 0, $surveyID, \Input::get('scriptForm')) === true)
        if($responseLogID > 0)
        {
          $this->response(array(
    				'status' => 'SUCCESS',
    				'message' => 'Survey Saved',
            'results' => $Survey->getProductsRecomendations((int)$responseLogID),
    			));
        }
        else
        {
          $this->response(array(
    				'status' => 'FAIL',
    				'message' => 'Failed to save survey results. Debtsolv Lead ID is ' . $leadpoolID,
    			));
        }
      }
      else
      {
        $this->response(array(
  				'status' => 'FAIL',
  				'message' => 'Failed to save to Debtsolv',
  			));
      }
    }
  }
}