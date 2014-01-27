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
    #$this->apiAddress = 'http://109.235.124.18:82/apipost.php';
    $this->apiAddress = 'http://85.199.245.2:82/apipost.php';
    
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
    $this->_values = array_merge_recursive($this->_values, $data);
  }
  
  public function addNewLead()
  {
    // -- Create a new array the matches the Debtsolv API
    // --------------------------------------------------
    $portal_form = array();
    
    $portal_form = $this->_values;
    
    if(count($portal_form) <= 0)
      return 0;
      
    $debtsolvData = array();
    
    $debtsolvData['title']        = isset($portal_form['title']) ? $portal_form['title'] : '';
    $debtsolvData['first_name']   = isset($portal_form['first_name']) ? $portal_form['first_name'] : '';
    $debtsolvData['last_name']    = isset($portal_form['last_name']) ? $portal_form['last_name'] : '';
    $debtsolvData['address1']     = isset($portal_form['address1']) ? $portal_form['address1'] : '';
    $debtsolvData['address2']     = isset($portal_form['address2']) ? $portal_form['address2'] : '';
    $debtsolvData['city']         = isset($portal_form['city']) ? $portal_form['city'] : '';
    $debtsolvData['county']       = isset($portal_form['state']) ? $portal_form['state'] : '';
    $debtsolvData['postal_code']  = isset($portal_form['postal_code']) ? $portal_form['postal_code'] : '';
    $debtsolvData['email']        = isset($portal_form['email']) ? $portal_form['email'] : '';
    $debtsolvData['comments']     = isset($portal_form['comments']) ? $portal_form['comments'] : '';
    
    $debtsolvData['LeadID']       = (int)$portal_form['lead_id'];
    $debtsolvData['LeadRef2']     = \Model_Call_Center::find($portal_form['introducer_id'])->shortcode; // -- Needs to be short code from the company
    
    $debtsolvData['phone_number'] = isset($portal_form['phone_number']) ? $portal_form['phone_number'] : '';
    $debtsolvData['alt_phone']    = isset($portal_form['alt_phone']) ? $portal_form['alt_phone'] : '';
    
    $debtsolvData['AgentID']        = isset($portal_form['AgentID']) ? $portal_form['AgentID'] : '';
    $debtsolvData['AgentFullName']  = isset($portal_form['agent']) ? $portal_form['agent'] : '';#$this->userInfo('name');
    
    $debtsolvData['ListID'] = isset($portal_form['list']) ? $portal_form['list'] : '0'; // -- This needs to be changed to the call centres list in Debtsolv
    $debtsolvData['ListName'] = isset($portal_form['ListName']) ? $portal_form['ListName'] : '';
    
    $this->clientID = $this->send('add_new_lead', $debtsolvData);
    
    // -- Update the call result to referred (900)
    // -------------------------------------------
    if($this->clientID > 0)
    {
      $this->updateCallResult(900);
      
      // -- Test
      #$this->updateCallResult(2040);
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