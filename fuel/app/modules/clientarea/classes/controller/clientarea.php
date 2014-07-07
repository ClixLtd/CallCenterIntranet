<?php
/**
 * Client Area API Controller
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;

 class Controller_Clientarea extends \Controller_BaseHybrid
 {
   public function before()
   {
       parent::before();
       Model_ClientArea::forge();
   }

   public function action_index()
   {
     $this->template->title = 'Index | Client Area';
     $this->template->content = \View::forge('index');
   }

   public function action_clientaccounts()
   {
       $this->template->title = 'Client Accounts';
       $this->template->content = \View::forge('client_accounts');
   }
   
   public function action_client_change_details()
   {
     $data = array();
     $data['requestList'] = array();
     
     $data['requestList'] = Model_ClientArea::getChangeDetailsRequests();
     
     $this->template->title = 'Client Change of Details | Client Area';
     $this->template->content = \View::forge('client_change_details', $data);
   }
   
   public function action_messages()
   {
     $data = array();
     
     $data['messagesList'] = array();
     
     if(isset($_GET['box']))
     {
       switch($_GET['box'])
       {
         case 'inbox' :
           $data['messagesList'] = Model_ClientArea::getMessagesList();
         break;
         case 'sent' :
           $data['messagesList'] = Model_ClientArea::getSentMessages();
         break;
       }
     }
     
     $this->template->title = 'Client Area | Messages';
     $this->template->content = \View::forge('messages', $data);
   }
    
   public function action_documents()
   {
      $data = array();
      $data['documents'] = Model_ClientArea::getDocuments();

      $this->template->title = "Client Documents";
      $this->template->content = \View::forge('documents', $data);
   }

   public function action_document_view($id = null){
      $this->template = '';

      $result = Model_ClientArea::viewDocument($id);

      if(isset($result['error']))
      {
        echo 'Error : '. $result['error'];
      }
      else
      {
        header("Content-Disposition: attachment; filename=" . urlencode($result['filename'])); 
        header('Content-Type: application/octet-stream');
        echo $result['content'];
      }

   }

   // ------------------------------------------------\\
   // -- Ajax Calls ----------------------------------\\
   // ------------------------------------------------\\
  public function post_approve()
  {
    $action = \Input::post('action');
    $document = \Input::post('document');

    try
    {
      if(!in_array($action, [1, 2, 3]))
        throw new \Exception('invalid action selected');

      if(is_null($document))
        throw new \Exception('No documents are selected');


      list($driver, $uuid) = \Auth::get_user_id();

      //puts all document id into string
      $update = array();
      foreach($document as $item)
        $update[] = $item;
      $update = implode(', ', $update);

      //Updates database
      $row = \DB::query(
        sprintf('UPDATE `clientarea_documents` SET `actioned_by`=%1$d, `status`=%2$d, `updated_at`=NOW() WHERE `id` IN (' . $update . ');', $uuid, $action),
        \DB::UPDATE
      )->execute();

      if($row == 0)
        throw new \Exception('Unable to approve documents');

      return $this->response(array(
        'status' => 'success',
        'message' => 'Documents have been approved',
        'data' => [],
      ));

    }
    catch(\Exception $e)
    {
      $this->response(array(
        'status' => 'failed',
        'message' => $e->getMessage(),
        'data' => array()
      ));
    }
  }

  public function post_add_client_account()
  {
    $clientID = \Input::post('ClientID');
    $password = \Input::post('Password');
    $confirm = \Input::post('Confirm_Password');

    // -- Check that the Client Exists and hasn't already got an account
    // -----------------------------------------------------------------


    // -- Add the Client
    // -----------------
    try 
    {
      if(empty($password) || empty($confirm))
        throw new \Exception('password cannot be empty.');

      if($password != $confirm)
        throw new \Exception('Passwords do not match.');

      if(Model_ClientArea::addClient((int)$clientID, $password) !== true)
        throw new \Exception('Failed to add new client.');

      //success
      $this->response(array(
        'status'  => 'success',
        'message' => 'Client has been added.',
        'data'    => array()
      ));

    } 
    catch(\Exception $e) //failed
    {
      $this->response(array(
        'status' => 'failed',
        'message' => $e->getMessage(),
        'data' => array(),
      ));
    }
   }
   
   public function post_getChangeDetailsList($clientID)
   {
     $result = array();
     $result = Model_ClientArea::getChangeDetailsRequests((int)$clientID);
     
     $this->response(array(
        'status' => 'success',
        'message' => '',
        'data' => $result,
     ));
   }
   
   /**
    * 
    */
   public function post_save_client_request()
   {
     // -- Get Post Data
     // ---------------- 
     $clientID  = \Input::post('client_id');
     $companyID = \Input::post('company_id');
     $field     = str_replace("-", "_", \Input::post('field'));
     $newValue  = \Input::post('new_value');
     $requestID = \Input::post('request_id');
     $address = array();
     $newAddress = array();
     $address   = \Input::post('address');
     
     $message = '';
    
     // -- This list is check against the posted field. For security
     // ------------------------------------------------------------
     $fieldsList = array('Title',
                         'Forename',
                         'Surname',
                         'Address',
                         'StreetAndNumber',
                         'Area',
                         'District',
                         'Town',
                         'County',
                         'Postcode',
                         'Tel_Home',
                         'Tel_Work',
                         'Tel_Mobile',
                         'Email',
                         'Date_Of_Birth',
                         'OverrideAddress',
                         'OverrideStreetAndNumber',
                         'OverrideArea',
                         'OverrideDistrict',
                         'OverrideTown', 
                         'OverrideCounty',
                         'OverridePostcode',
                         'PartnerAddress',
                         'PartnerStreetAndNumber',
                         'PartnerArea',
                         'PartnerDistrict',
                         'PartnerTown', 
                         'PartnerCounty',
                         'PartnerPostcode',
                    );

     // -- Check for a valid field
     // --------------------------                  
     if(in_array($field, $fieldsList))
     {
       if($field == 'Date_Of_Birth')
       {
         $field = 'DateOfBirth';
         $newValue = date("Y-m-d 00:00:00", strtotime($newValue));
       }
       
       if($field == 'Address' || $field == 'OverrideAddress' || $field == 'PartnerAddress')
       {
         if(count($address) > 0)
         {
           foreach($address as $name => $value)
           {
             if(in_array($name, $fieldsList))
             {
               $newAddress[$name] = $value;
             }
           }
         }
       }

       // -- Title is in the allowed array list
       // -------------------------------------
       $data = array('newValue'   => $newValue,
                     'field'      => $field,
                     'newAddress' => $newAddress,
                    );
     
       // -- Setup the Database
       //----------------------
       Model_ClientArea::forge((int)$companyID, (int)$clientID);
       
       // -- Save request into Debtsolv
       // -----------------------------
       if(Model_ClientArea::saveNewDetailsRequest($data))
       {
         // -- Debtsolv has been updated. Now mark the request as approved in the Intranet
         // ------------------------------------------------------------------------------
         Model_ClientArea::setDetailRequestApproved($requestID);
         
         $status = 'success';
       }
       else
       {
         $status = 'failed';
       }
     }
     else
     {
       $status = 'failed';
       $message = 'Field not in list';
     }   
    
     $this->response(array(
        'status' => $status,
        'message' => $message,
        'data' => $newAddress,
     ));
   }
   
   public function post_read_message($messageID = 0)
   {
     $results = array();
     $results['posts'] = array();
     $results['posts'] = Model_ClientArea::readMessage($messageID);
     
     if(count($results['posts']) > 0)
     {
       Model_ClientArea::setLastPostRead($messageID);
      
       // -- Get Message details
       // ----------------------
       $results['message_details'] = Model_ClientArea::messageDetails($messageID);
       $Client = Client::forge((int)$results['message_details'][0]['client_id'], (int)$results['message_details'][0]['company_id']);
       
       foreach($results['posts'] as $key => $post)
       {
         if($post['from'] == 'client')
         {
           $results['posts'][$key]['poster'] = $Client->fullName();
         }
       }
     }
     
     $this->response(array(
       'status' => 'success',
       'message' => '',
       'data' => $results,
     ));
   }
   
  public function post_save_new_message()
  {
    $status = '';
    $message = '';
    
    $data = array(
      'clientID' => \Input::post('Message-To'),
      'subject'  => \Input::post('Message-Subject'),
      'message'  => \Input::post('Message-Body'),
    );

    try{

      Model_ClientArea::createNewMessage($data);

      $this->response(array(
        'success' => 'Message has been sent'
      ));

    } catch(\Exception $e) {
      $this->response(array(
        'error' => array(
          'message' => $e->getMessage(),
          'code'  => $e->getCode(),
          'type' => 'Exception',
        )
      ));
    }
  }
   
  public function post_send_reply()
  {
    $data = array(
     'messageID'  => \Input::post('MessageID'),
     'message'    => \Input::post('Reply-Message-Body'),
     'from'       => 'user',
     'statusID'   => 1,
    );

    $lastPostID = \Input::post('lastPostID');
    //throw new \Exception('err');

    // -- Make last post status ID = 3, Reply
    // --------------------------------------
    if(!Model_ClientArea::setLastPostReplied( \Input::post('MessageID') ))
      throw new \Exception('Changing Status ID of last message failed');

    \Upload::process();
    \Upload::save();
    if(!Model_ClientArea::saveMessagePost( $data, \Upload::get_files() ) )
      throw new \Exception('Saving New Post Failed');

    return $this->response(true);
     
    //$messageBody = \Input::post('message');
  }
   
   public function post_company_list()
   {
     $results = array();
     
     $results = Model_ClientArea::companyList();
     
     $status = '';
     
     if(count($results) > 0)
       $status = 'success';
     else
       $status = 'failed';
       
     $this->response(array(
       'status' => $status,
       'message' => '',
       'data' => $results,
     ));
   }
   
   public function post_validate_client_id()
   {
     $clientID = (int)\Input::post('clientID');
     $companyID = (int)\Input::post('companyID');
     
     Model_ClientArea::forge($companyID, $clientID);
     
     $data = array();
     
     if(Model_ClientArea::validateClientID() === true)
     {
       $Client = Client::forge($clientID, $companyID);
       
       $data = array(
         'fullName' => $Client->fullName(),
       );
       
       $status = 'success';
     }
     else
       $status = 'failed';
    
     $this->response(array(
       'status' => $status,
       'message' => '',
       'data' => $data,
     ));
   }
 }  