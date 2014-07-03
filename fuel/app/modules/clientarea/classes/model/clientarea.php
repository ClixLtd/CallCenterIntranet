<?php
/**
 * Client Area Model - Used for the Intranet
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;
 
 class Model_ClientArea extends \Model
 {
   public static $clientID;
   public static $companyID;
   public static $debtsolvDatabase;

   protected static $_userCentreID = 0;
   protected static $_database = null;
   protected static $_debtsolvDatabase = null;
   protected static $_leadpoolDatabase = null;
	
   protected static $_connection = null;
   
   public static function forge($companyID = 0, $clientID = 0)
   {
     static::$clientID = $clientID;
     static::$companyID = $companyID;

     // -- Check that the user
     static::$_userCentreID = \Auth::get('call_center_id');

     \Log::info('User 2 center ID is ' . static::$_userCentreID);

     static::$debtsolvDatabase = static::setDatabaseConnection();
   }
   
   /**
    * Get the database name
    * 
    * @author David stansfield
    */
   public static function setDatabaseConnection()
   {
     $Database = Database::connect(static::$_userCentreID);
     
     static::$_connection = $Database->connection();
     static::$_debtsolvDatabase = $Database->debtsolvDBName();
   }
   
  /**
  * Validate Client ID
  * 
  * @author David Stansfield
  */
  public static function validateClientID($clientID = 0)
  {
    $result = 0;

    \Log::info(static::$_debtsolvDatabase);

    list($result) = \DB::query("SELECT TOP (1) 
                                ID
                              FROM
                                " . static::$_debtsolvDatabase . ".dbo.Client_Contact
                              WHERE
                                ID = :id;",
                              \DB::SELECT)->param('id', (int)$clientID)
                                          ->execute(static::$_connection)->as_array();
    return false;

    if(isset($result['ID']) && $result['ID'] == (int)$clientID)
      return true;
    return false;
  }

     /**
      * Check for a valid Client to add
      *
      * @author David Stansfield
      */
     public static function checkClient($clientID = 0)
     {
         // -- Check Debtsolv
         // -----------------

     }

     /**
      * Add a new Client to the Client Area
      *
      * @author David Stansfield
      */
     public static function addClient($clientID = 0, $password = '')
     {
         // -- Check that the Client Exists in Debtsolv
         // -------------------------------------------
         #if(static::validateClientID((int)$clientID) === true)
         #{
            /*
             $result = \DB::query("INSERT INTO
                                     Clix_Client_Portal.dbo.client_accounts
                                   (
                                     client_id
                                    ,company_id
                                    ,status_id
                                    ,[password]
                                    ,created_at
                                   )
                                   VALUES
                                   (
                                     " . (int)$clientID . "
                                    ," . \Auth::get('call_center_id') . "
                                    ,1
                                    ,HASHBYTES('SHA1', '" . $password . "')
                                    ,GETDATE()
                                   )
                                  ", \DB::INSERT)->execute(static::$_connection);
            */
            if(empty($password))
              return false;
            
            /**
            * ======================================
            *   IMPORTANT move salt to better place      
            * ======================================
            */
            $salt = '$6$rounds=8000$mnwMjNLvHnnUhuP4eX6zi8EvGSru7vWB$';

            $result = \DB::query("INSERT INTO
                                     Clix_Client_Portal.dbo.client_accounts
                                   (
                                     client_id
                                    ,company_id
                                    ,status_id
                                    ,[password]
                                    ,created_at
                                   )
                                   VALUES
                                   (
                                     " . (int)$clientID . "
                                    ," . \Auth::get('call_center_id') . "
                                    ,1
                                    ,'" . crypt( $password, $salt ) . "'
                                    ,GETDATE()
                                   )
                                  ", \DB::INSERT)->execute(static::$_connection);

             if($result > 0)
                 return true;
             else
                 return false;


     }

     /**
    * Get a full list of requests for change of details
    * 
    * @author David Stansfield
    */
   public static function getChangeDetailsRequests($clientID = 0)
   {
     $results = array();
     $output = array();
     
     $client = '';
     
     if($clientID > 0)
     {
       $client = "CCCP.client_id = " . (int)$clientID . " AND ";
     }
     
     $results = \DB::query("SELECT
                              CCCP.id
                             ,client_id
                             ,company_id
                             ,field
                             ,old_value
                             ,new_value
                             ,date_requested
                             ,company_name
                            FROM
                              `clientarea_client_change_profile` AS CCCP
                            LEFT JOIN
                              clientarea_companies AS CC ON CCCP.company_id = CC.id
                            WHERE
                              " . $client . "
                              date_approved = '0000-00-00 00:00:00'
                            AND
                              company_id = " . static::$_userCentreID . "
                            AND
                              CCCP.id IN (
                                          SELECT
                                            MAX(id)
                                          FROM
                                            clientarea_client_change_profile
                                          GROUP BY
                                            field, client_id
                                        )
                                ORDER BY
                                  date_requested ASC
                           ", \DB::select())->execute()->as_array();
                           
     if(count($results) > 0)
     {       
       // -- Group the rows by field and client
       // -------------------------------------
       foreach($results as $result)
       {
         $Client = Client::forge($result['client_id'], $result['company_id']);
         
         $result['new_value'] = unserialize($result['new_value']);
         $result['client_name'] = $Client->fullName();
         
         $output[$result['client_id']][] = $result;
         
         unset($Client);
       }
     }
                        
     return $output;
   }
   
   /**
    * Save new Details Request to Debtsolv
    * 
    * @author David Stansfield
    */
   public static function saveNewDetailsRequest($data = array())
   {
     if(count($data) <= 0)
       return false;
    
     $set = '';
     
     if(($data['field'] == 'Address' || $data['field'] == 'OverrideAddress' || $data['field'] == 'PartnerAddress')  && count($data['newAddress']) > 0)
     {       
       foreach($data['newAddress'] as $field => $newValue)
       {
         $set .= $field . " = " . \DB::quote(str_replace("'", "''", trim($newValue))) . ",";
       }
       
       $set = rtrim($set, ",");
     }
     else
     {
       $set = $data['field'] . " = " . \DB::quote(str_replace("'", "''", trim($data['newValue'])));
     }
    
     $result = 0;
     
    // -- Check to update partner table client contact
    //--------------
    if($data['field'] == 'PartnerAddress')
      $query = 'UPDATE TOP(1) %s.dbo.Client_Partner SET %s WHERE ClientID = %d;';
    else
      $query = 'UPDATE TOP(1) %s.dbo.Client_Contact SET %s WHERE ID = %d;';

    $result = \DB::query(sprintf($query, static::$_debtsolvDatabase, $set, static::$clientID), \DB::update())->execute(static::$_connection);

     if($result > 0)
       return true;
     else
       return false;
   }
   
   /**
    * Mark the Change of Details Request as approved
    * 
    * @author David Stansfield
    */
   public static function setDetailRequestApproved($requestID = 0)
   {
     if($requestID == 0)
       return;
       
     list($driver, $user_id) = \Auth::get_user_id();
       
     \DB::query("UPDATE
                    clientarea_client_change_profile
                 SET
                   approved_by = " . (int)$user_id . ",
                   date_approved = NOW()
                 WHERE
                   id = " . (int)$requestID . "
                 AND
                   client_id = " . static::$clientID . "
                 LIMIT 1
                ", \DB::update())->execute();
   }
   
   /**
    * Load up Client from Debtsolv
    * 
    * @author David Stansfield
    */
   public static function loadDsClient()
   {
     $result = array();

     list($result) = \DB::query("SELECT Top (1)
                                  Title
                                 ,Initials
                                 ,Forename
                                 ,Surname
                                 ,DateOfBirth
                                 ,Email
                                 ,MaritalStatus
                                 ,Gender
                                 ,StreetAndNumber
                                 ,Area
                                 ,District
                                 ,Town
                                 ,County
                                 ,PostCode
                                 ,Tel_Home
                                 ,Tel_Work
                                 ,Tel_Mobile
                                 ,email
                               FROM
                                 " . static::$_debtsolvDatabase . ".dbo.Client_Contact
                               WHERE
                                 ID = :id;",
                                \DB::select() )->param('id', (int)static::$clientID )
                                               ->cached(1800)
                                               ->execute(static::$_connection)
                                               ->as_array();
     
     // -- Check results and return
     // ---------------------------                    
     if(isset($result))                   
       return $result;
     return $result;
   }
   
   /**
    * Get a list of all active messages
    * 
    * @author David Stansfield
    */
   public static function getMessagesList()
   {
     $results = array();
     
     $results = \DB::query("SELECT
                               CM.id
                              ,CM.client_id
                              ,CM.company_id
                              ,CMP.id AS post_id
                              ,CM.subject
                              ,IF(CMP.user_id > 0 AND CMP.`from` = 'user', (SELECT name FROM users WHERE id = CMP.user_id), '') AS message_from
                              ,CMP.`from`
                              ,CMP.date
                              ,CMP.status_id
                              ,CMP.icon
                            FROM
                              clientarea_messages AS CM
                            JOIN
                            (
                              SELECT
                                 JOIN_CMP.id
                                ,message_id
                                ,user_id
                                ,`from`
                                ,date
                                ,status_id
                                ,LOWER(JOIN_CMS.description) AS icon
                              FROM
                                clientarea_messages_posts AS JOIN_CMP
                              LEFT JOIN
                                clientarea_messages_statuses AS JOIN_CMS ON JOIN_CMP.status_id = JOIN_CMS.id
                              WHERE
                                `from` != 'user'
                              ORDER BY
                                date DESC
                            ) AS CMP ON (CM.id = CMP.message_id)
                            WHERE
                              CM.company_id = :id
                            AND
                              CM.status_id = 1
                            GROUP BY
                              CMP.message_id
                            ORDER BY
                              CMP.date DESC
                           ", \DB::SELECT)->param('id', \Auth::get('call_center_id'))->execute()->as_array();

     foreach($results as $key => $result)
     {
       $Client = Client::forge($result['client_id'], $result['company_id']);
       
       if($result['from'] == 'client')
       {
         $results[$key]['message_from'] = $Client->fullName();
       }
       
       $results[$key]['client_name'] = $Client->fullName();
       unset($Client);
     }
     
     return $results;
   }
   
   /**
    * Get a list of sent messages
    * 
    * @return array
    */
   public static function getSentMessages()
   {
     $results = array();
     $results = \DB::query("SELECT
                               CM.id
                              ,CM.client_id
                              ,CM.company_id
                              ,subject
                              ,DATE_FORMAT(date, '%d-%m-%Y %H:%i') AS date
                              ,`from`
                              ,status_id
                              ,CMS.description
                              ,LOWER(CMS.description) AS icon
                              ,(
                                SELECT
                                  U.name
                                FROM
                                  clientarea_messages_posts AS CMP
                                LEFT JOIN
                                  users AS U ON CMP.user_id = U.id
                                WHERE
                                  CMP.message_id = CM.id
                                AND
                                  `from` = 'user'
                                ORDER BY
                                  date ASC
                                LIMIT 1
                              ) AS message_from
                            FROM
                              clientarea_messages AS CM
                            LEFT JOIN
                               clientarea_messages_statuses AS CMS ON CM.status_id = CMS.id
                            AND
                              `from` = 'user'
                            AND
                              CM.company_id = " . \Auth::get('call_center_id') . "
                            ORDER BY
                              date DESC
                           ", \DB::SELECT)->execute()->as_array();
                           
     foreach($results as $key => $result)
     {
       $Client = Client::forge($result['client_id'], $result['company_id']);
       
       if($result['from'] == 'user')
       {
         $results[$key]['message_from'] = $Client->fullName();
       }
       
       $results[$key]['client_name'] = $Client->fullName();
       unset($Client);
     }
                           
     return $results;
   }
  

  /**
   * Loads a single message
   * 
   * @param int $messageID - ID of the message to load
   * @return array
   */
   public static function messageDetails($messageID = 0)
   {
     $result = array();
     $result = \DB::query("SELECT
                              client_id
                             ,company_id
                             ,`from`
                             ,subject
                             ,date
                             ,status_id
                           FROM
                             clientarea_messages
                           WHERE
                             id = :id
                           LIMIT 1
                          ", \DB::SELECT)->param('id', (int)$messageID)->execute()->as_array();
                          
     return $result;
   }
   
   public static function readMessage($messageID = 0)
   {
     $results = array();
     
     $results = \DB::query("SELECT
                               CMP.id
                              ,message_id
                              ,user_id
                              ,U.name AS `poster`
                              ,`from`
                              ,message
                              ,date
                              ,status_id
                            FROM
                              clientarea_messages_posts AS CMP
                            LEFT JOIN
                              users AS U ON CMP.user_id = U.id
                            WHERE
                              message_id = :id
                            ORDER BY
                              date ASC
                           ", \DB::SELECT)->param( 'id', (int)$messageID )->execute()->as_array();
                           
     return $results;                   
   }
   
  public static function createNewMessage($data = array())
  {

      //-- Checks that user exists
      //--------------------------
      $check = \DB::query("SELECT
                    ACCOUNT.client_id
                    ,ACCOUNT.company_id
                  FROM
                    Clix_Client_Portal.dbo.client_accounts AS ACCOUNT
                  INNER JOIN
                    " . static::$_debtsolvDatabase . ".dbo.Client_Contact AS CONTACT ON ACCOUNT.client_id = CONTACT.ID
                  WHERE
                    CONTACT.ID = :id;", \DB::SELECT)->param('id', $data['clientID'])->execute(static::$_connection)->as_array();


      if(!isset($check[0]['client_id']))
        throw new \Exception('Unable to find client.');

      // -- Save the message details
      // ---------------------------
      list($lastID, $rows) = \DB::query(
        "INSERT INTO
          clientarea_messages ( id, client_id, company_id, `from`, subject, date, status_id )
        VALUES
          (NULL, :clientID, :companyID, 'user', :subject, NOW(), 1);",
        \DB::INSERT
      )->parameters(array(
        'clientID'  => (int)$check[0]['client_id'],
        'companyID' => (int)$check[0]['company_id'],
        'subject'   => $data['subject'],
      ))->execute();
    

    if($lastID < 1)
      throw new \Exception('Unable to create message');

    $data['messageID'] = $lastID;
    $data['companyID'] = $check[0]['company_id'];
    $data['statusID'] = 1;

    if(static::saveMessagePost($data) === false )
      throw new \Exception('Unable to create message');
    return true;

  }
   
  /**
  * Updates the message status to read
  * 
  * @param int $messageID
  * @return boolean
  */
  public static function setLastPostRead($messageID = 0)
  {
    if($messageID == 0)
      return false; 

    $result = 0;
    $result = \DB::query(
        "UPDATE
           clientarea_messages_posts
         SET
           status_id = 2
         WHERE
           message_id = :id
         AND
           `from` = 'client'
         ORDER BY
           id DESC
         LIMIT 1",
         \DB::UPDATE
    )->param('id', (int)$messageID)->execute();
                           
    if($result > 0)
      return true;
    return false;
  }
  
  /**
  * updates the message status to replied
  * 
  * @param int $messageID
  * @return boolean
  */
  public static function setLastPostReplied($messageID = 0)
  {

    if($messageID == 0)
      return false;   
    $result = 0;
   
    $result = \DB::query(
      "UPDATE
        clientarea_messages_posts
      SET
        status_id = 3
      WHERE
        message_id = :id
      AND
        `from` = 'client'
      ORDER BY
        id DESC LIMIT 1",
      \DB::UPDATE
      )->param('id', (int)$messageID)->execute();
                           
     if($result > 0)
       return true;
    return false;
   }
   

   /**
    * changes a message status 
    * 
    * @param int $postID
    * @param int $statusID
    * @return boolean
    */
   public static function changePostStatus($postID = 0, $statusID = 0)
   {
     if($postID == 0 || $statusID == 0)
      return false;
       
     $result = 0;
     
    $result = \DB::query(
      "UPDATE
         clientarea_messages_posts
       SET
         status_id = :status
       WHERE
         id = :id LIMIT 1", \DB::UPDATE)->parameters(array(
          'status' => (int)$statusID,
          'id' => (int)$postID
    ))->execute();
                          
    if($result > 0)
      return true;
    return false;
    }
   
 /**
  * Create a new message 
  * 
  * @param array $data
  * @return boolean
  */
  public static function saveMessagePost( $data = array(), $files = array() )
  {
    $result = 0;
     
    list($driver, $user_id) = \Auth::get_user_id();
     
    list($result, $uuid) = \DB::query(
    "INSERT INTO
      clientarea_messages_posts (id, message_id, user_id, `from`, message, date, status_id)
    VALUES
      (NULL, :message_id, :user_id, 'user', :message, NOW(), :status_id);",
    \DB::INSERT)->parameters(array(
      'message_id' => (int)$data['messageID'],
      'user_id' => (int)$user_id,
      'message' => $data['message'],
      'status_id' => (int)$data['statusID']
    ))->execute();

    if(!empty($files))
    {
      static::saveMessageAttachments($uuid, $files);
    }
                          
    if($result > 0)
      return true;
    return false;
  }
  
  /**
   *  Saves message attachments to database and FTP
   * 
   * @param $array $files
   * @return boolean
   */
  public static function saveMessageAttachments($msgID, $files)
  {
    var_dump($msgID, $files);

    foreach($files as $file)
    {
      list($lastid, $rows) = \DB::query(
        'INSERT INTO
          `clientarea_message_attachments` (`message_post_id`, `filename`)
        VALUES (:id, :file);', \DB::INSERT
      )->parameters(array(
        'id' => $msgID,
        'file' => $file['saved_as']
      ))->execute();

      //-- ^_^
      if($rows < 1)
        throw new \Exception('balls');

    }

    return true;

  }


   /**
    * Return a list of comapnys
    * 
    * @return
    */
   public static function companyList()
   {
     $results = array();
     
     $results = \DB::query("SELECT
                               id
                              ,alias
                              ,company_name
                              ,active
                            FROM
                              clientarea_companies
                            ORDER BY
                              company_name ASC", \DB::SELECT)->execute()->as_array();
                           
     return $results;
   }

   /**
    * Get list of documents waiting to be approved.
    * 
    */
   public static function getDocuments()
   {
      return \DB::query(sprintf(
        "SELECT
          `DOC`.`id`
          ,`DOC`.`client_id`
          ,`DOC`.`filename`
          ,`DOC`.`created_at`
          ,`DOC_TYPE`.`description` AS `status`
        FROM
          `clientarea_documents` AS `DOC`
        INNER JOIN
          `clientarea_type_documents_status` AS `DOC_TYPE` ON `DOC`.`status` = `DOC_TYPE`.`ID`
        WHERE
          `company_id` = %d
        AND
          `DOC`.`status` != 2", static::$_userCentreID
      ), \DB::SELECT)->execute()->as_array();
   }

   /**
    * 
    * 
    */
   public static function viewDocument($id = null)
   {
      //gets record
      $file = \DB::query(sprintf('SELECT
          `filename`
          ,`alias`
        FROM
          `clientarea_documents` AS `documents`
        INNER JOIN
          `clientarea_companies` AS `company` ON `documents`.`company_id` = `company`.`id`
        WHERE
          `documents`.`id`=%d
        AND
          `status`=1 LIMIT 1;', $id), \DB::SELECT)->execute()->as_array();
      if(empty($file))
        return array('error' => 'Unable to find document.');
      $url = 'ftp://ClientArea:Wvts231ctD6@192.168.1.72/Scanned_Mail/ClientArea/' . $file[0]['alias'] . '/' . $file[0]['filename'];

      //opens stream
      $handle = fopen($url, 'rb');
      if($handle)
      {
        $content = stream_get_contents($handle);
        fclose($handle);

        return array(
          'mime' => 'application/octet-stream',
          'filename' => $file[0]['filename'],
          'content' => $content,
        );
        
      } else {
        return array('error' => 'Unable to open file.');
      }

   }





 }