<?php
/**
 * Client Area Model - Only used for the API
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;
 
 class Model_Intranet extends \Model
 {
   public static $company;
   public static $companyID;
   public static $clientID;
   
   public static function forge($company = null, $clientID = 0)
   {
     static::$company   = $company;
     static::$companyID = static::getCompanyID();
     static::$clientID  = (int)$clientID;
   }
   
   /**
    * Get the Company ID by the Company Alias
    * 
    * @author David Stansfield
    */
    public static function getCompanyID()
    {
      $result = array();
      
      $result = \DB::query("SELECT
                              id
                            FROM
                              clientarea_companies
                            WHERE
                              alias = :company
                            LIMIT 1;",
                            \DB::select())->param('company', static::$company)->execute()->as_array();

      if(isset($result[0]['id']))
        return $result[0]['id'];
      return 0;
    }

    /**
     * Returns the company id and settings for DebtSolve Class
     * 
     * @return array
     */
    public static function initCompany()
    {
      $result = array();

      list($result) = \DB::query(
        "SELECT 
          `id`
          ,`settings`
        FROM
          `clientarea_companies`
        WHERE
          `alias` = :company
        LIMIT 1;", \DB::SELECT)->param('company', static::$company)->cached(3600)->execute()->as_array();

      if(!empty($result))
        return $result;
      return false;
    }

    /**
    * Load up the company config
    * 
    * @author David Stansfield
    */
  public static function loadCompany()
  {
    $result = array();
     
     list($result) = \DB::query("SELECT
                              id
                             ,alias
                             ,company_name
                             ,components
                             ,settings
                             ,active
                           FROM
                             clientarea_companies
                           WHERE
                             alias = :company
                           LIMIT 1
                          ", \DB::select())->param('company', static::$company)->cached(3600)->execute()->as_array();
                          
    if(!empty($result))
      return $result;
    return $result;
  }
   
  /**
  * Change Password request
  * 
  * @author David Stansfield
  */
  public static function saveChangedPassword($data = array())
  {

    list($lastID, $rows) = \DB::query(
      "INSERT INTO
      clientarea_change_password (id, client_id, company_id, current_password, new_password, date, status)
      VALUES
      (NULL, :client_id, :company_id, :current, :new, NOW(), 'PENDING');",
      \DB::INSERT
    )->parameters(array(
      'client_id' => (int)static::$clientID,
      'company_id' => (int)static::$companyID,
      'current' => $data['currentPassword'],
      'new' => $data['newPassword'],
    ))->execute();

    return $lastID;
  }
   
  /**
  * Update the change password log
  * 
  * @author David Stansfield
  */
  public static function updateChangePasswordLog($ID = 0, $status = '')
  {
    \DB::query(
      "UPDATE
        clientarea_change_password
      SET
        status = :status
      WHERE
        id = :id LIMIT 1;",
      \DB::UPDATE
    )->parameters(array('status' => $status, 'id' => $ID))->execute();
   }
   
   /**
    * Get a list of profile changes that haven't been approved yet
    * 
    * @author David Stansfield
    */
    public static function getProfileRequests()
    {
      $result = array();
      
      $result = \DB::query("SELECT
                              field
                              ,id
                              ,new_value
                            FROM
                              clientarea_client_change_profile
                            WHERE
                              client_id = " . static::$clientID . "
                            AND
                              id IN (
                                      SELECT
                                        MAX(id)
                                      FROM
                                        clientarea_client_change_profile
                                      WHERE
                                        date_approved = '0000-00-00 00:00:00'
                                      GROUP BY
                                        field, client_id
                                    )
                           ", \DB::select())->execute()->as_array();
                 
      return $result;
    }
   
   /**
    * Save the Client's Profile Change Request
    * 
    * @author David Stansfield
    */
    public static function saveProfileChangeRequest($data = array())
    {
      $insert = \DB::query("INSERT INTO
                    clientarea_client_change_profile
                  (
                     id
                    ,client_id
                    ,company_id
                    ,field
                    ,old_value
                    ,new_value
                    ,date_requested
                  )
                  VALUES
                  (
                     NULL
                    ," . static::$clientID . "
                    ," . static::$companyID . "
                    ," . \DB::quote($data['inputName']) . "
                    ," . \DB::quote($data['oldValue']) . "
                    ," . \DB::quote($data['newValue']) . "
                    ,NOW()
                  )
                 ", \DB::insert())->execute();

      //DB::Query() returns array first value is the ID, second Value is count
      if($insert[1] > 0)
        return true;
      return false;
    }
   
   /**
    * Write to the Client Area API Log
    * 
    * @author David Stansfield
    */
   public static function writeLog($typeID = 0, $data = '')
   {
     \DB::query("INSERT INTO
                   clientarea_client_access_log
                 (
                    id
                   ,log_type_id
                   ,client_id
                   ,date_time
                   ,data
                 )
                 VALUES
                 (
                    NULL
                   ," . (int)$typeID . "
                   ," . static::$clientID . "
                   ,NOW()
                   ," . \DB::quote($data) . "
                 )
                ", \DB::insert())->execute();
   }
   
   /**
    * Save a new message
    * 
    * @author David Stansfield
    */
    public static function saveNewMessage($subject = '')
    {      
      list($lastID, $rows) = \DB::query(
        "INSERT INTO
          clientarea_messages (id ,client_id ,company_id ,`from` ,subject ,date ,status_id)
        VALUES
          ( NULL,
                                           ," . static::$clientID . "
                                           ," . (int)static::$companyID . "
                                           ,'client'
                                           ," . \DB::quote($subject) . "
                                           ,NOW()
                                           ,1
                                         )
                                        ", \DB::INSERT)->execute();
                                        
      return (int)$lastID;
    }
    
    /**
     * Saves a message post to the message
     * 
     * @author David Stansfield
     */
    public static function saveMessagePost($data = array())
    {
      $result = 0;
      
      list($driver, $user_id) = \Auth::get_user_id();
      
      $result = \DB::query("INSERT INTO
                              clientarea_messages_posts
                            (
                               id
                              ,message_id
                              ,user_id
                              ,`from`
                              ,message
                              ,date
                              ,status_id
                            )
                            VALUES
                            (
                               NULL
                              ," . (int)$data['messageID'] . "
                              ," . (int)$user_id . "
                              ," . \DB::quote($data['from']) . "
                              ," . \DB::quote($data['message']) . "
                              ,NOW()
                              ," . (isset($data['statusID']) ? $data['statusID'] : 1) . "
                            )
                           ", \DB::insert())->execute();
                           
      return $result;
    }
    
    /**
     * Get Inbox Messages
     * 
     * @author David Stansfield
     */
    public static function getInboxMessagesList()
    {
      $results = array();
      /*
      $result = \DB::query("SELECT
                               CM.id
                              ,subject
                              ,DATE_FORMAT(date, '%d-%m-%Y %H:%i') AS date_sent
                              ,(
                                 SELECT
                                   IF(ISNULL(users.name), 'Me', users.name)
                                 FROM
                                   clientarea_messages_posts AS posts
                                 LEFT JOIN
                                   users ON posts.user_id = users.id
                                 WHERE
                                   message_id = CM.id
                                 ORDER BY
                                   posts.id DESC
                                 LIMIT 1
                                   
                               ) AS `from`
                              ,CM.status_id
                              ,(
                                 SELECT
                                   LOWER(description)
                                 FROM
                                   clientarea_messages_posts
                                 LEFT JOIN
                                   clientarea_messages_statuses ON clientarea_messages_posts.status_id = clientarea_messages_statuses.id
                                 WHERE
                                   message_id = CM.id
                                 ORDER BY
                                   clientarea_messages_posts.id DESC
                                 LIMIT 1
                              ) AS icon
                              ,CMS.description
                            FROM
                              clientarea_messages AS CM
                            LEFT JOIN
                               clientarea_messages_statuses AS CMS ON CM.status_id = CMS.id
                            WHERE
                              client_id = " . static::$clientID . "
                            AND
                              (
                                SELECT
                                  COUNT(message_id)
                                FROM
                                  clientarea_messages_posts
                                WHERE
                                  message_id = CM.id
                              ) > 1
                            ORDER BY
                              date DESC
                           ", \DB::SELECT)->execute()->as_array();
      */
      
      $results = \DB::query("SELECT
                               CM.id
                              ,CM.client_id
                              ,CM.company_id
                              ,CMP.id AS post_id
                              ,CM.subject
                              ,IF(CMP.user_id > 0 AND CMP.`from` = 'user', (SELECT name FROM users WHERE id = CMP.user_id), '') AS message_from
                              ,CMP.`from`
                              ,DATE_FORMAT(CMP.date, '%d-%m-%Y %H:%i') AS date_sent
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
                                ,(
                                   SELECT
                                     name
                                   FROM
                                     users AS U
                                   WHERE
                                     user_id = U.id
                                   LIMIT 1
                                 ) AS `from`
                                ,date
                                ,status_id
                                ,(
                                  SELECT
                                    LOWER(CMS_2.description)
                                  FROM
                                    clientarea_messages_posts AS CMP_2
                                  LEFT JOIN
                                    clientarea_messages_statuses AS CMS_2 ON CMP_2.status_id = CMS_2.id
                                  WHERE
                                    CMP_2.message_id = JOIN_CMP.message_id
                                  AND
                                    `from` = 'user'
                                  ORDER BY
                                    CMP_2.id DESC
                                  LIMIT 1
                                ) AS icon
                              FROM
                                clientarea_messages_posts AS JOIN_CMP
                              LEFT JOIN
                                clientarea_messages_statuses AS JOIN_CMS ON JOIN_CMP.status_id = JOIN_CMS.id
                              WHERE
                                `from` != 'client'
                              ORDER BY
                                id DESC
                            ) AS CMP ON (CM.id = CMP.message_id)
                            WHERE
                              CM.client_id = " . static::$clientID . "
                            AND
                              CM.status_id = 1
                            GROUP BY
                              CMP.message_id
                            ORDER BY
                              CMP.date DESC
                           ",\DB::SELECT)->execute()->as_array();
                           
      return $results;
    }
    
    /**
     * Get New Messages
     * 
     * @author David Stansfield
     */
    public static function getNewMessages($limit = 0)
    {
      $results = array();
      $results = \DB::query("SELECT
                                CM.subject
                               ,CMP.date
                             FROM
                               clientarea_messages_posts AS CMP
                             INNER JOIN
                               clientarea_messages AS CM ON CMP.message_id = CM.id
                             WHERE
                               CM.client_id = " . static::$clientID . "
                             AND
                               CMP.status_id = 1
                             AND
                               CMP.`from` = 'user'
                             LIMIT " . (int)$limit . "                           
                            ", \DB::SELECT)->execute()->as_array();
                            
      return $results;
    }
    
    /**
     * Get Sent Messages
     * 
     * @author David Stansfield
     */
    public static function getSentMessagesList()
    {
      $result = array();
      
      $result = \DB::query("SELECT
                               CM.id
                              ,subject
                              ,DATE_FORMAT(date, '%d-%m-%Y %H:%i') AS date_sent
                              ,'----' AS `from`
                              ,status_id
                              ,CMS.description
                              ,LOWER(CMS.description) AS icon
                            FROM
                              clientarea_messages AS CM
                            LEFT JOIN
                               clientarea_messages_statuses AS CMS ON CM.status_id = CMS.id
                            WHERE
                              client_id = " . static::$clientID . "
                            AND
                              `from` = 'client'
                            ORDER BY
                              date DESC
                           ", \DB::SELECT)->execute()->as_array();
                           
      return $result;
    }
    
    public static function getMessagePosts($messageID = 0)
    {
      $results = array();
      
      $results = \DB::query("SELECT
                                CMP.id
                               ,CMP.user_id
                               ,CMP.`from`
                               ,IF(CMP.`from` = 'client', 'Me', U.name) AS poster
                               ,CMP.message
                               ,CMP.date
                               ,CMP.status_id
                             FROM
                               clientarea_messages_posts AS CMP
                             LEFT JOIN
                               clientarea_messages AS CM ON CMP.message_id = CM.id
                             LEFT JOIN
                               users AS U ON CMP.user_id = U.id
                             WHERE
                               CMP.message_id = " . (int)$messageID . "
                             AND
                               CM.client_id = " . static::$clientID . "
                             ORDER BY
                               CMP.date ASC
                            ", \DB::SELECT)->execute()->as_array();
                            
      return $results;
    }
    
    /**
     * Change Message Post status
     * 
     * @author David Stansfield
     */
     public static function changePostStatus($messagePostID = 0, $statusID = 0)
     {
       if($messagePostID == 0 || $statusID == 0)
         return;
         
       $result = 0;
       $result = \DB::query("UPDATE
                               clientarea_messages_posts
                             SET
                               status_id = " . (int)$statusID . "
                             WHERE
                               id = " . (int)$messagePostID . "
                             LIMIT 1
                            ", \DB::UPDATE)->execute();
                            
       if($result > 0)
         return true;
       else
         return false;
     }
     
     public static function setLastPostRead($messageID = 0)
     {
       if($messageID == 0)
         return false;
         
       $result = 0;
       
       $result = \DB::query("UPDATE
                               clientarea_messages_posts
                             SET
                               status_id = 2
                             WHERE
                               message_id = " . (int)$messageID . "
                             AND
                               `from` = 'user'
                             AND
                               status_id != 3
                             ORDER BY
                               id DESC
                             LIMIT 1", \DB::UPDATE)->execute();
                             
       if($result > 0)
         return true;
       else
         return false;
     }
     
     public static function setLastPostReplied($messageID = 0)
     {
       if($messageID == 0)
         return false;
         
       $result = 0;
       
       $result = \DB::query("UPDATE
                               clientarea_messages_posts
                             SET
                               status_id = 3
                             WHERE
                               message_id = " . (int)$messageID . "
                             AND
                               `from` = 'user'
                             ORDER BY
                               id DESC
                             LIMIT 1", \DB::UPDATE)->execute();
                             
       if($result > 0)
         return true;
       else
         return false;
     }
     
     /**
      * Check for new Messages
      * 
      * @author David Stansfield
      */
     public static function checkNewMessages()
     {
       $result = 0;
       
       $result = \DB::query("SELECT
                               COUNT(CMP.id) AS total
                             FROM
                               clientarea_messages_posts AS CMP
                             INNER JOIN
                               clientarea_messages AS CM ON CMP.message_id = CM.id
                             WHERE
                               CM.client_id = " . static::$clientID . "
                             AND
                               CMP.status_id = 1
                             AND
                               CMP.`from` = 'user'                            
                            ", \DB::SELECT)->execute()->as_array();
                            
       if(isset($result[0]['total']))
         return $result[0]['total'];
       else
         return $result;
     }

     /**
      * Notifies the intranet that document has been uploaded
      * 
      * @author James Read
      * @return boolean 
      */
     public static function notifyUploadDocuments($data = array())
     {
        if(empty($data))
          return false;

        $insert = array();
        foreach($data['documents'] as $file)
        {
          $insert[] = '(' . (int)$data['clientID'] . ','. (int)static::$companyID .', ' . \DB::quote($file[1]) . ')';
        }
        $insert = implode(',', $insert);

        $result = \DB::query(
          'INSERT INTO `clientarea_documents` (`client_id`,`company_id`,`filename`) VALUES ' . $insert . ';',
          \DB::INSERT
        )->execute();

        return true;
     }


 }