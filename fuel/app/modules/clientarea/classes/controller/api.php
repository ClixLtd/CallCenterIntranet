<?php
/**
 * Client Area API Controller
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;

 class Controller_Api extends \Controller_BaseApi
 {
   protected $_clientID;
   protected $_company;
   protected $_companyID;
   
   public function before()
   {
     parent::before();
     
     // -- Set the Company
     // ------------------
     $this->_company = \Input::post('company');
     
     // -- Client ID
     // ------------
     $this->_clientID = (int)\Input::post('clientID');
     
     // -- Set the database name and client ID
     // --------------------------------------
     Model_Debtsolv::forge($this->_company, $this->_clientID);
     Model_Intranet::forge($this->_company, $this->_clientID);
   }
   
   public function action_index()
   {      
     return Json::success();
   }
   
   /**
    * Load the company config
    * 
    * @author David Stansfield
    */
   public function post_loadCompany()
   {
     $result = Model_Intranet::loadCompany();
     
     return Json::output('success', '', $result);
   }
   
   /**
    * Check to see if a client exists
    * 
    * @author David Stansfield
    */
   public function post_login()
   {
     // -- Post Data
     // ------------
     $clientID = \Input::post('clientID');
     $password = \Input::post('password');
     
     $data = array();
     
     // -- Find the Client
     // ------------------
     if(Model_Debtsolv::login($clientID, $password) === true)
     {
       // -- Client Found
       // ---------------
       $status = 'success';
       $message = '';
       
       // -- Log it
       // ---------
       \Log::info('Notice', 'Client Logged In ID: ' . $clientID);
       Log::write(1);
     }
     else
     {
       // -- Client Not Found
       // -------------------
       $status = 'failed';
       $message = 'Account not found';
     }
     
     // -- Return the output
     // --------------------
     return Json::output($status, $message);
   }
   
   public function post_logout()
   {
     // -- Log it
     // ---------  
     \Log::info('Notice', 'Client Logged Out ID: ' . (int)$this->_clientID);
     Log::write(2);
     
     return Json::output('success');
   }
   
   /**
    * Return the client's details
    * 
    * @author David Stansfield
    */
   public function post_loadclient()
   {     
     $request = Model_Debtsolv::loadClient();
     
     return Json::output('success', '', $request);
   }
   
   /**
    * Change Password
    * 
    * @author David Stansfield
    */
   public function post_change_password()
   {
     $data = array(
       'currentPassword'  => \Input::post('currentPassword'),
       'newPassword'      => \Input::post('newPassword'),
     );
     
     // -- Save the request to the Intranet first
     // -----------------------------------------
     $ID = 0;
     $ID = Model_Intranet::saveChangedPassword($data);
     
     if($ID > 0)
     {
       // -- If TRUE then make the change in Debtsolv
       // -------------------------------------------
       if(Model_Debtsolv::changePassword($data) === true)
       {
         Model_Intranet::updateChangePasswordLog($ID, 'DONE');
         
         return Json::output('success');
       }
       else
       {
         // -- Error
         // --------
         Model_Intranet::updateChangePasswordLog($ID, 'ACCOUNT NOT FOUND');
         
         return Json::output('failed', 'Your current password was incorrect');
       }
     }
     else
     {
       // -- Return Error
       // ---------------
       return Json::output('failed', 'Unable to change your password at this time');
     }
   }
   
   /**
    * Get a list of profile change request that are awaiting approval
    * 
    * @author David Stansfield
    */
    public function post_profile_change_requests()
    {
      $output = array();
      $outputReturn = array();
      
      $output = Model_Intranet::getProfileRequests();
      
      if(count($output) > 0)
      {
        foreach($output as $key => $value)
        {
          $value['new_value'] = unserialize(urldecode($value['new_value']));
          $outputReturn[$value['field']] = $value;
        }
      }
      
      return Json::output('success', '', $outputReturn);
    }
   
   /**
    * Update Profile Request
    * 
    * @author David Stansfield
    */
    public function post_profile_update()
    {
      $data = array(
        'inputName' => \Input::post('inputName'), 
        'oldValue'  => \Input::post('oldValue'),
        'newValue'  => serialize(\Input::post('newValue')),
      );
      
      Model_Intranet::saveProfileChangeRequest($data);
      
      return Json::output('success', 'Saved');
    }
    
    /**
     * Save a new message
     * 
     * @author David stansfield
     */
    public function post_create_new_message()
    {
      $subject = \Input::post('subject');
      
      $status = '';
      $message = '';
      
      // -- Create the message
      // ---------------------
      $messageID = 0;
      $messageID = Model_Intranet::saveNewMessage($subject);
      
      if($messageID > 0)
      {
        // -- Created the first post
        // -------------------------
        $data = array(
          'messageID' => $messageID,
          'from' => 'client',
          'message' => \Input::post('messageBody'),
        );
        
        $messagePostID = 0;
        $messagePostID = Model_Intranet::saveMessagePost($data);
        
        if($messagePostID > 0)
        {
          $status = 'success';
        }
        else
        {
          $status = 'failed';
          $message = 'Failed to Create Message Post';
        }
      }
      else
      {
        $status = 'failed';
        $message = 'Failed to create Message';
      }
      
      return Json::output($status, $message);
    }
    
    /**
     * Save a new reply message
     * 
     * @author David Stansfield
     */
    public function post_save_reply_message()
    {
      $messageID = \Input::post('messageID');
      
      $data = array(
        'messageID' => $messageID,
        'from' => 'client',
        'message' => \Input::post('message'),
        'statusID' => 1,
      );
      
      $messagePostID = 0;
      $messagePostID = Model_Intranet::saveMessagePost($data);
      
      Model_Intranet::setLastPostReplied($messageID);
      
      $status = '';
      $message = '';
      
      if($messagePostID > 0)
      {
        $status = 'success';
      }
      else
      {
        $status = 'failed';
      }
      
      return Json::output($status, $message);
    }
    
    /**
     * Get a list of messages for the Inbox
     * 
     * @author David Stansfield
     */
     public function post_get_inbox_messages()
     {
       $results = array();
       $results = Model_Intranet::getInboxMessagesList();
       
       return Json::output('success', '', $results);
     }
     
     /**
      * Check for new Messages
      * 
      * @author David Stansfield
      */
     public function post_get_new_messages()
     {
       $limit = \Input::post('limit');
       
       if((int)$limit == 0)
         $limit = 5;
         
       $results = array();
       
       $results = Model_Intranet::getNewMessages((int)$limit);
       
       return Json::output('success', '', $results);
     }
    
    /**
     * Get a list of all sent messages
     * 
     * @author David Stansfield
     */
    public function post_get_sent_messages_list()
    {
      $result = array();
      $result = Model_Intranet::getSentMessagesList();
      
      return Json::output('success', '', $result);
    }
    
    /**
     * Get a list of all posts for a selected message
     * 
     * @author David Stansfield
     */
    public function post_get_message_posts()
    {
      $messageID = 0;
      $messageID = \Input::post('messageID');
      
      $results = array();
      
      $results = Model_Intranet::getMessagePosts($messageID);
      
      // -- Messages have been loaded, so mark them as read
      // --------------------------------------------------
      Model_Intranet::setLastPostRead($messageID);
      
      /*
      foreach($results as $result)
      {
        if($result['status_id'] == 1 || $result['status_id'] == 3)
        {
          if(Model_Intranet::changePostStatus($result['id'], 2))
          {
            \Log::write(4, 'Changed Message Status ID for ID: ' . $result['id']);
          }
        }
      }
      */
      return Json::output('success', '', $results);
    }
    
    /**
     * Check for new Messages
     * 
     * @author David Stansfield
     */
    public function post_check_new_messages()
    {
      $result = array();
      $result = Model_Intranet::checkNewMessages();
      
      return Json::output('success', '', $result);
    }
    
    /**
     * Get total paid to date to creditors
     * 
     * @author David Stansfield
     */
    public function post_get_paid_to_date()
    {
      $result = array();
      $result = Model_Debtsolv::paidToDate();
      
      return Json::output('success', '', $result);
    }
    
    /**
     * Get total paid out
     * 
     * @author David Stansfield
     */
    public function post_get_paid_out_to_date()
    {
      $result = array();
      $result = Model_Debtsolv::paidOutToDate();
      
      return Json::output('success', '', $result);
    }
    
    /** Get the total paid to creditors
     * 
     * @author David Stansfield
     */
    public function post_get_total_paid_to_each_creditor()
    {
      $results = array();
      $results = Model_Debtsolv::totalPaidToCreditors();
      
      return Json::output('success', '', $results);
    }
    
    /**
     * Get the Client's Account Statement
     * 
     * @author David Stansfield
     */
    public function post_get_statement()
    {
      $results = array();
      $results = Model_Debtsolv::accountStatement();
      
      return Json::output('success', '', $results);
    }
 }