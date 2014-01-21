<?php
// ----------------------------
// -- Debtsolv Class for API --
// ----------------------------

namespace Survey;

class Debtsolv
{
  protected $apiKey;
  protected $apiAddress;
  protected $_values = array();
  
  public $clientID = 0; // -- Debtsolv Client ID
  
  public function __construct($referralID = 0)
  {    
    // -- Set the variables up
    // -----------------------
    $this->apiKey = 'KJAH8qw';
    $this->apiAddress = 'http://109.235.124.18:82/apipost.php';
    
    // -- Set the Model
    // ----------------
    #\Referrals_callback_model::forge((int)$referralID);
  }
  
  private function send($function = null, $data = array())
  {
    // -- Send the referral to Debtsolv to create a client
    // ---------------------------------------------------
    if(count($data) <= 0 || $function == null)
      return 0;
            
    // -- Create CURL Request
    // ----------------------
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $this->apiAddress);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt($ch, CURLOPT_POST, true);
  
    $dataSend['value'] = json_encode(array('key' => $this->apiKey,
  		                                     'function' => $function,
  																		     'data' => json_encode($data)
  																		    ));
  
  	curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSend);
  	$output = curl_exec($ch);
  	curl_close($ch);
  	
  	$jsonOutput = json_decode($output, true);
  	
  	if(count($jsonOutput) > 0)
  	  return $jsonOutput;
    else
  	  return $output;
  }
  
  public function data($data = array())
  {
    $this->_values = $data;
  }
  
  public function addNewLead()
  {
    // -- Create a new array the matches the Debtsolv API
    // --------------------------------------------------
    $data = array();
    
    $data = $this->_values;
    
    if(count($data) <= 0)
      return;
      
    $debtsolvData = array();
    
    $debtsolvData['title']        = $data['title'];
    $debtsolvData['first_name']   = $data['forename'];
    $debtsolvData['last_name']    = $data['surname'];
    $debtsolvData['address1']     = $data['street_and_number'];
    $debtsolvData['address2']     = $data['area'];
    $debtsolvData['city']         = $data['town'];
    $debtsolvData['county']       = $data['county'];
    $debtsolvData['postal_code']  = $data['post_code'];
    $debtsolvData['email']        = $data['email'];
    $debtsolvData['comments']     = $data['notes'];
    
    $debtsolvData['LeadID'] = 0;
    $debtsolvData['LeadRef2']     = \Model_Call_Center::find($data['introducer_id'])->shortcode; // -- Needs to be short code from the company
    
    $debtsolvData['phone_number'] = $data['tel_home'];
    $debtsolvData['alt_phone']    = $data['tel_mobile'];
    
    $debtsolvData['AgentID']        = '';#$this->userInfo('username');
    $debtsolvData['AgentFullName']  = $data['agent'];#$this->userInfo('name');
    
    $debtsolvData['ListID'] = $data['list']; // -- This needs to be changed to the call centres list in Debtsolv
    
    $this->clientID = $this->send('add_new_lead', $debtsolvData);
    
    // -- Update the call result to referred (900)
    // -------------------------------------------
    if($this->clientID > 0)
    {
      $this->updateCallResult(900);
    }
    
    $this->_values['debtsolvLeadID'] = $this->clientID;
    
    return $this->clientID;
  }
  
  
  
  public function sendForDRConsolidation()
  {
	  $emailData = array();
	  
	  $emailData['debtsolvLeadID']    = $this->_values['debtsolvLeadID'];
	  
	  parent::sendForConsolidation($emailData);
	  
  }
  
  
  private function updateCallResult($callResult = 0)
  {
    // -- Change the Call Result
    // -------------------------
    $data = array('ClientID' => $this->clientID,
                  'ContactResult' => (int)$callResult
                 );
                 
    $this->send('Update_call_result', $data);
  }
}