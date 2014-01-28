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
          'rebuttalURL' => $ScriptForm->getRebuttalURL(),
          'surveyForm' => $ScriptForm->generate(),
          'gets' => array(
	  			    'agent' => \Input::post('agent', null),
              'AgentID' => \Input::post('AgentID', null),
	  			    'list' => \Input::post('list_id', null),
              'lead_id' => \Input::post('lead_id', null),
              'ListName' => \Input::post('ListName', null),
            ),
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
      $centerDetails = \Model_Call_Center::query()->where('api_key', $apiKey)->get_one();
      
      $Debtsolv = new Debtsolv();
      $Debtsolv->data(\Input::get());
      $Debtsolv->data(array('introducer_id' => $centerDetails->id));
      
      $leadpoolID = 0;
      $leadpoolID = $Debtsolv->addNewLead();
      
      if((int)$leadpoolID > 0)
      {
        $responseLogID = 0;
        $responseLogID = ScriptForms::saveFormData($leadpoolID, 0, 0, 1, $surveyID, \Input::get('scriptForm'));
        
        $Survey = new ScriptForms($surveyID);
        
        // -- Save the Survey Results
        // --------------------------
        #if(ScriptForms::saveFormData($leadpoolID, 0, 0, 0, $surveyID, \Input::get('scriptForm')) === true)
        // -- Save the Product Recommendations
        // -----------------------------------
        $Survey->saveResponseProducts((int)$responseLogID);
        
        if($responseLogID > 0)
        {
          // -- All Saved and Done. Now send an email
          // ----------------------------------------
          $callCentre = \Model_Call_Center::query()->where('api_key', $apiKey)->get_one();
          
          $Email = \Email::forge();
          
          $Email->from('noreply@moneymanagementservices.co.uk', 'Money Management Services');
          $Email->to('d.stansfield@clix.co.uk');
          $Email->subject($leadpoolID . ' - New Survey Result');
          $Email->html_body(\View::forge('email', array(
            'leadDetails' => \Input::get(),
            'leadpoolID' => $leadpoolID,
            'recommendedProducts' => $Survey->getProductsRecomendations((int)$responseLogID),
            'scriptForm' => ScriptForms::loadResponse($leadpoolID, 0, 1),
            'centre' => $callCentre->title,
            'agent' => \Input::get('agent'),
            'pitchScript' => \Input::get('surveyName'),
          )));
          
          $Email->send();
          
          /*
          try
          {
            $Email->send();
          }
          catch(\EmailSendingFailedException $e)
          {
            $this->response(array(
    				  'status' => 'SUCCESS',
    				  'message' => 'Survey Saved (Failed to send email)',
              'results' => $Survey->getProductsRecomendations((int)$responseLogID),
              'leadpoolID' => $leadpoolID,
    			  ));
          }
          */
          $this->response(array(
    				'status' => 'SUCCESS',
    				'message' => 'This Survey has been received.',
            'results' => $Survey->getProductsRecomendations((int)$responseLogID),
            'leadpoolID' => $leadpoolID,
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