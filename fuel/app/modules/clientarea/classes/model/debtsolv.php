<?php
/**
 * Debtsolv Model - Only used for the API
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;
 
 class Model_Debtsolv extends \Model
 {
   
   public static $clientID = 0;

   public static $database = null;
   protected static $databaseName = null;
   
   protected static $_database = null;
   protected static $_debtsolvDatabase = null;
   protected static $_leadpoolDatabase = null;
   protected static $_companyID = 0;
	
   protected static $_connection = null;

   protected static $_settings;
   
  public static function forge($companyID = 0, $clientID = 0, $settings = '')
  {

    // -- Set the database name
    // ------------------------     
    $Database = Database::connect((int)$companyID);
     
    static::$databaseName = $Database->debtsolvDBName();
    static::$_connection = $Database->connection();

    // -- Set the Client ID
    // --------------------
    static::$clientID = (int)$clientID;
    static::$_companyID = (int)$companyID;

    static::$_settings = unserialize($settings);
  }
   
   /**
    * Find a valid user based on Client ID and Password
    * 
    * @author David Stansfield
    */
   public static function login($clientID = 0, $password = null)
   {
     $result = 0;
     
     if($clientID == 0 || $password == null)
       return false;

     /*
     $result = \DB::query("SELECT Top (1)
                             LEAD_DATA.Client_ID
                           FROM
                             " . static::$databaseName . ".dbo.Client_LeadData AS LEAD_DATA
                           INNER JOIN
                             " . static::$databaseName . ".dbo.Client_Contact AS CONTACT ON LEAD_DATA.Client_ID = CONTACT.ID
                           WHERE
                             LEAD_DATA.Client_ID = " . (int)$clientID . "
                           AND
                             LEAD_DATA.[Password] = HASHBYTES('sha1', '" . str_replace("'", "''", $password) . "')
                           --AND
                           --  CONTACT.[Status] IN (9, 13)
                          ", \DB::SELECT)->execute(static::$_connection)->as_array();
     */
     list($result) = \DB::query("SELECT
                             CLIX_CLIENT_ACCOUNT.id
                             ,CLIX_CLIENT_ACCOUNT.password
                             ,CONTACT.status
                           FROM
                             Clix_Client_Portal.dbo.client_accounts AS CLIX_CLIENT_ACCOUNT
                           INNER JOIN
                             " . static::$databaseName . ".dbo.Client_Contact AS CONTACT ON CLIX_CLIENT_ACCOUNT.client_id = CONTACT.ID
                           WHERE
                             CLIX_CLIENT_ACCOUNT.client_id = :client_id
                           AND
                             CLIX_CLIENT_ACCOUNT.company_id = :company_id;"
                          , \DB::SELECT)->parameters(array(
                              'client_id' => (int)$clientID,
                              'company_id' => static::$_companyID,
                            ))->execute(static::$_connection)->as_array();


     // -- checks given password against the hash 
     // -----------------------------------------
     // salt = $6$rounds=8000$mnwMjNLvHnnUhuP4eX6zi8EvGSru7vWB$
     if(crypt($password, $result['password']) != $result['password'])
        return array('error' => 'Invalid Password and ID Combination.');

     // -- Check for a returned row, then return it
     // -------------------------------------------            
     if(isset($result['id']) && $result['id'] > 0)
     {
        if(!in_array($result['status'], array(12,13)))
          return array('success' => 'OK');
        else
          return array('error' => 'Account has been locked, Please contact us');
     } else {
        return array('error' => 'Account Not Found');
     }

     //-- Catch Other errors
     //---------------------
     return array('error' => 'Unexpected error occurred.');
   }
   
   /**
    * Change Password
    * 
    * @author David Stansfield
    */
   public static function changePassword($data = array())
   {


    /*
     $result = \DB::query("UPDATE Top (1)
                             Clix_Client_Portal.dbo.client_accounts
                           SET
                             [password] = HASHBYTES('sha1', '" . str_replace("'", "''", $data['newPassword']) . "')
                           WHERE
                             client_id = " . static::$clientID . "
                           AND
                             company_id = " . static::$_companyID . "
                           AND
                             [Password] = HASHBYTES('sha1', '" . str_replace("'", "''", $data['currentPassword']) . "')
                          ", \DB::UPDATE)->execute(static::$_connection);
    */ 

    /**
     * Update to use bcrypt lib (crypt function)
     */
    $result = \DB::query(
      "UPDATE Top (1)
        Clix_Client_Portal.dbo.client_accounts
       SET
         [password] = :password
       WHERE
         client_id = :client_id
       AND
         company_id = :company_id
       AND
         [Password] = :current
      ", \DB::UPDATE)->parameters(array(
          'password'  => $data['newPassword'],
          'current' => $data['currentPassword'],
          'client_id' => static::$clientID,
          'company_id' => static::$_companyID,
        ))->execute(static::$_connection);

      \Log::info($data['currentPassword']);

    if($result == 1)
      return true;
    return false;
  }
   
   /**
    * Load up the clients details
    * 
    * @author David Stansfield
    */
   public static function loadClient()
   {
     $result = array();

     list($result) = \DB::query("SELECT Top (1)
                              CC.Title
                             ,CC.Initials
                             ,CC.Forename
                             ,CC.Surname
                             ,CC.DateOfBirth
                             ,CC.email
                             ,CC.MaritalStatus
                             ,CC.Gender
                             ,CC.StreetAndNumber
                             ,CC.Area
                             ,CC.District
                             ,CC.Town
                             ,CC.County
                             ,CC.Postcode
                             ,CC.Tel_Home
                             ,CC.Tel_Work
                             ,CC.Tel_Mobile
                             ,CC.OverrideStreetAndNumber
                             ,CC.OverrideArea
                             ,CC.OverrideDistrict
                             ,CC.OverrideTown
                             ,CC.OverrideCounty
                             ,CC.OverridePostcode
                             ,CP.Title AS [PartnerTitle]
                             ,CP.Forename AS [PartnerForename]
                             ,CP.Surname AS [PartnerSurname]
                             ,CP.StreetAndNumber AS [PartnerStreetAndNumber]
                             ,CP.Area AS [PartnerArea]
                             ,CP.District AS [PartnerDistrict]
                             ,CP.Town AS [PartnerTown]
                             ,CP.County AS [PartnerCounty]
                             ,CP.PostCode AS [PartnerPostCode]
                             ,CP.Tel_Home AS [PartnerTel_Home]
                             ,CP.Tel_Home AS [PartnerTel_Work]
                             ,CP.Tel_Mobile AS [PartnerTel_Mobile]
                             ,CP.Email AS [PartnerEmail]
                           FROM
                             " . static::$databaseName . ".dbo.Client_Contact AS CC
                           INNER JOIN
                             " . static::$databaseName .".dbo.Client_Partner AS CP ON CC.ID = CP.ClientID
                           WHERE
                             ID = :id;"
                          , \DB::select())->param('id', (int)static::$clientID)->execute(static::$_connection)->as_array();
     
     // -- Check results and return
     // ---------------------------                    
     if(isset($result))                   
       return $result;
     return $result;
   }
   
  /**
  * Get paid to date to creditors
  * 
  * @author David Stansfield
  */
  public static function paidToDate()
  {
    $result = 0;
    list($result) = \DB::query(
      "SELECT
    	 SUM(Amount)*1.0/100 AS Paid_to_Date
      FROM
       " . static::$databaseName . ".dbo.Payment_Receipt
      WHERE
        ClientID = :id
      AND
        Date >= :startpoint
      AND
       TransactionType = 1;", \DB::SELECT)->parameters(array(
        'id' => static::$clientID,
        'startpoint' => date('Y-m-d H:i:s', static::$_settings['debtsolv']['startpoint'])
      ))->cached(1800)->execute(static::$_connection)->as_array();
                          
     if(isset($result['Paid_to_Date']))
      return $result['Paid_to_Date'];
     return 0;
   }
   
   /**
    * Returns the sum amount of money paid out to date
    * 
    * @return array
    */
   public static function paidOutToDate()
   {
     $result = 0;
     list($result) = \DB::query("SELECT
                             SUM(PO.Amount) * 1.0 / 100 AS total_out
                           FROM
                             " . static::$databaseName . ".dbo.Payment_Out AS PO
                           --INNER JOIN
                           --  " . static::$databaseName . ".dbo.Finstat_Debt AS FSD ON PO.AccountRef = FSD.AccountReference AND PO.ClientID = FSD.ClientID
                           WHERE
                             PO.ClientID = id;"
                          , \DB::SELECT)->param('id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();
                          
     if(isset($result['total_out']))
       return $result['total_out'];
     return 0;
   }
   
   /**
    * Get total paid to each creditor
    * 
    * @author David Stansfield
    */
   public static function totalPaidToCreditors()
   {
     $result = array();

     $result = \DB::query("SELECT
                            DEBT.ID
                            ,DEBT.[Description]
                            ,(SELECT
                                SUM(Amount) * 1.0 / 100
                              FROM
                                " . static::$databaseName . ".dbo.Payment_Out
                              WHERE
                                AccountRef = DEBT.AccountReference
                            ) AS Paid
                            ,DEBT.AmountOwed * 1.0/100 AS Owed
                            ,DEBT.AccountReference
                            ,HOLDER.[Description] AS Signatory
                            ,CASE
                              WHEN DEBT.status = 5 THEN 'YES'
                              ELSE 'NO'
                            END AS paidoff
                          FROM 
                            " . static::$databaseName . ".dbo.Finstat_Debt AS DEBT
                          INNER JOIN
                            " . static::$databaseName . ".dbo.Type_DebtResponsibility AS HOLDER ON DEBT.ClientResponsible = HOLDER.ID
                          WHERE 
                            DEBT.ClientID = :id;"
                         , \DB::SELECT)->param(':id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();
                         
     return $result;
   }
   
   /**
    * Get the Client's Account Statement
    * 
    * @author David Stansfield
    */
  public static function accountStatement()
  {
    $results = array();
    $results = \DB::query("(
                              SELECT
                                PR.ID
                                ,Amount AS Amount_In
                                ,'' AS Amount_Out
                                ,'' AS Creditor
                                ,[Date]
                                ,TPS.[Description] AS PaymentStatus
                                ,TPM.[Description] AS PaymentMethod
                                ,TPT.[Description] AS PaymentTransaction
                                ,'In' AS Type
                              FROM
                                " . static::$databaseName . ".dbo.Payment_Receipt AS PR
                              LEFT JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Method AS TPM ON PR.PaymentMethod = TPM.ID
                              LEFT JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Transaction AS TPT ON PR.TransactionType = TPT.ID
                              LEFT JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Status AS TPS ON PR.[Status] = TPS.ID
                              WHERE
                                ClientID = :id
                              AND
                                [Date] >= :startpoint
                            )
                            UNION ALL
                            (
                              SELECT
                                PO.ID
                                ,'' AS Amount_In
                                ,Amount AS Amount_Out
                                ,FD.[Description]
                                ,DateSent
                                ,TPS.[Description] AS PaymentStatus
                                ,TPM.[Description] AS PaymentMethod
                                ,'' AS PaymentTransaction
                                ,'Out' AS Type
                              FROM
                                " . static::$databaseName . ".dbo.Payment_Out AS PO
                              INNER JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Method AS TPM ON PO.PaymentMethod = TPM.ID
                              INNER JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Status AS TPS ON PO.[Status] = TPS.ID
                              INNER JOIN
                                " . static::$databaseName . ".dbo.Finstat_Debt AS FD ON PO.DebtID = FD.ID
                              WHERE
                                PO.ClientID = :id
                              AND
                                DateSent >= :startpoint
                              GROUP BY
                                PO.ID
                                ,PO.Amount
                                ,FD.[Description]
                                ,DateSent
                                ,TPS.[Description]
                                ,TPM.[Description]
                            )
                            ORDER BY
                              [Date] DESC
                          ", \DB::SELECT)->parameters(array(
                              'id' => static::$clientID,
                              'startpoint' => date('Y-m-d H:i:s', static::$_settings['debtsolv']['startpoint']),
                            ))->cached(1800)->execute(static::$_connection)->as_array();
                          
     return $results;
   }
   
   /**
    * Get the amount in the Warchest (Holding Account)
    * 
    * @author David Stansfield
    */
   public static function warchest()
   {
     $results = array();
     list($results) = \DB::query("SELECT TOP (1)
                              SUM(Amount) * 1.0 / 100 As warchest_amount
                            FROM
                              " . static::$databaseName . ".dbo.Payment_Warchest
                            WHERE
                              ClientID = :id
                            AND
                              Date >= :startpoint;",
                            \DB::SELECT)->parameters(array(
                              'id' => static::$clientID,
                              'startpoint' => date('Y-m-d H:i:s', static::$_settings['debtsolv']['startpoint'])
                            ))->cached(1800)->execute(static::$_connection)->as_array();
                           
     if(isset($results['warchest_amount']))
       return $results['warchest_amount'];
     return 0;
   }

  /**
  * Get the Client's next standing order date
  *
  * @author David Stansfield
  */
  public static function standingOrderDate()
  {
    $result = array();
    list($result) = \DB::query("SELECT TOP (1)
                                  PAYMENT_SCHEDULE.DateExpected AS next_payment_date
                                  ,PAYMENT_METHOD.[Description] AS payment_method
                                FROM
                                  " . static::$databaseName . ".dbo.Payment_Schedule AS PAYMENT_SCHEDULE
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Type_Payment_Method AS PAYMENT_METHOD ON PAYMENT_METHOD.ID = PAYMENT_SCHEDULE.PaymentMethod
                                WHERE
                                  PAYMENT_SCHEDULE.ClientID = :id
                                AND
                                  PAYMENT_SCHEDULE.DateExpected >= GETDATE()
                                AND
                                  PAYMENT_SCHEDULE.AmountPaid = '0'
                                ORDER BY
                                  PAYMENT_SCHEDULE.SequenceID ASC
                           ", \DB::SELECT)->param('id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();

      if(isset($result))
          return $result;
      return $result;
  }

  /**
   * Client Claims (Handled by 1-Tick)
   *
   * @author David Stansfield
   */
   public static function claims()
   {
         $results = array();
         $results = \DB::query("SELECT
                                  CLIENT_SERVICE.ClientID
                                 ,CLIENT_DEBT.[Description] AS creditor_name
                                 ,CREDITOR.StreetAndNumber + ',' + CREDITOR.Area + ',' + CREDITOR.District + ',' + CREDITOR.Town + ',' + CREDITOR.County AS [address]
                                 ,TYPE_SERVICE.[Description] AS claim_type
                                 ,PROCESSING_STAGE.[Description] AS processing_stage
                                 ,DEBT_STATUS.[Description] AS creditor_status
                                 ,CLIENT_DEBT.AccountReference AS account_reference
                                FROM
                                  " . static::$databaseName . ".dbo.Client_Services AS CLIENT_SERVICE
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Type_Service As TYPE_SERVICE ON CLIENT_SERVICE.ServiceType = TYPE_SERVICE.ID
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.ProcessingStage_Threads AS THREADS ON CLIENT_SERVICE.ThreadID = THREADS.ID
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Type_ProcStage_ThreadStatus AS THREAD_STATUS ON THREADS.[Status] = THREAD_STATUS.ID
                                INNER JOIN
                                  (
                                    SELECT
                                      ClientID
                                     ,StageID
                                     ,ThreadID
                                     ,DateStart
                                     ,ROW_NUMBER() OVER (PARTITION BY ThreadID ORDER BY DateStart DESC) AS StageRow
                                    FROM
                                      " . static::$databaseName . ".dbo.Client_InitialProcessingStages
                                  ) AS CLIENT_STAGE ON CLIENT_SERVICE.ThreadID = CLIENT_STAGE.ThreadID
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Type_IVAProcessingStatus AS PROCESSING_STAGE ON CLIENT_STAGE.StageID = PROCESSING_STAGE.ID AND THREADS.ThreadTypeID = PROCESSING_STAGE.ThreadTypeID
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Finstat_Debt AS CLIENT_DEBT ON CLIENT_SERVICE.ObjectID = CLIENT_DEBT.ID
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Type_Debt_Status AS DEBT_STATUS ON CLIENT_DEBT.[Status] = DEBT_STATUS.ID
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Creditor_Contact AS CREDITOR ON CLIENT_DEBT.CreditorID = CREDITOR.ID
                                WHERE
                                  CLIENT_SERVICE.ClientID = :id
                                AND
                                  CLIENT_SERVICE.ServiceType IN (1, 2, 4)
                                AND
                                  CLIENT_STAGE.StageRow = 1",
                                  \DB::SELECT)->param('id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();

         return $results;
     }

  /**
  * Total Client Fees Paid
  *
  * @author David Stansfield
  */
  public static function totalFeesPaid()
  {
    $results = array();
    list($results) = \DB::query("SELECT TOP (1)
                            SUM(Amount * 1.0) / 100 AS total_fee_amount
                          FROM
                            " . static::$databaseName . ".dbo.Payment_Fee
                          WHERE
                            ClientID = :id
                          AND
                            Date >= :startpoint
                          AND
                            [Status] = 10;",
                        \DB::SELECT)->parameters(array(
                          'id' => static::$clientID,
                          'startpoint' => date('Y-m-d H:i:s', static::$_settings['debtsolv']['startpoint']),
                        ))->cached(1800)->execute(static::$_connection)->as_array();

         if(isset($results['total_fee_amount']))
             return $results['total_fee_amount'];
         return 0;
     }

     /**
      * Total Owed
      */
     public static function totalOwed()
     {
         $results = array();
         $results = \DB::query("SELECT
                                  SUM(EstimatedBalance * 1.0) / 100 AS total_owed
                                FROM
                                  " . static::$databaseName . ".[dbo].[Finstat_Debt]
                                WHERE
                                  ClientID = :id;",
                              \DB::SELECT)->param('id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();

         if(isset($results[0]['total_owed']))
             return $results[0]['total_owed'];
         return 0;
     }

     public static function accountMangerInformation()
     {
         $results = array();
         $results = \DB::query("SELECT TOP (1)
                                  USERS.Undersigned
                                FROM
                                  " . static::$databaseName . ".dbo.Client_LeadData AS LEAD_DATA
                                INNER JOIN
                                  " . static::$databaseName . ".dbo.Users AS USERS ON LEAD_DATA.Administrator = USERS.ID
                                WHERE
                                  LEAD_DATA.Client_ID = " . static::$clientID . "
                               ", \DB::SELECT)->execute(static::$_connection)->as_array();

         if(isset($results[0]['Undersigned']))
             return $results[0]['Undersigned'];
         else
             return '';
     }

     /**
      *
      * 
      */
     public static function helper()
     {
        return static::$_database;
     }

     /**
      * Returns client documents
      * 
      */
     public static function getDocumentList()
     {
        return \DB::query(
          "SELECT
            DOCUMNET.ID
            ,DOCUMNET.DateScanned
            ,DOCUMNET.[Filename]
            ,ISNULL(DOCUMNET.[Description],'N/A') AS [Description]
          FROM
            "  . static::$databaseName . ".dbo.ArchivedDocuments AS DOCUMNET
          WHERE ClientID ='" . static::$clientID . "';"
        )->cached(1800)->execute(static::$_connection)->as_array();
     }

     public static function getCreditorCount()
     {
        $query = 'SELECT
                    (SELECT SUM(EstimatedBalance*1.0)/100 FROM '.static::$databaseName.'.dbo.Finstat_Debt WHERE ClientID = :id) AS totalDebt
                    ,COUNT(ID) AS countCreditors
                  FROM
                    '.static::$databaseName.'.dbo.Finstat_Debt
                  WHERE
                    ClientID = :id
                  AND
                    Status != 5;'; //5 = Paid off

        return \DB::query($query)->param('id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();
     }

     /**
      * Returns a list of letters sent to a creditor for a client
      * 
      * @return array 
      */
    public static function getSentCreditorLetters()
    {
      $query = \DB::query(
        "SELECT
          LETTER.ID
          ,LETTER.DateCreated
          ,LETTER_TYPE.Title
          ,CREDITOR.Name AS Creditor
        FROM
          " . static::$databaseName .".dbo.PrintQueue_StdLetters AS LETTER
        INNER JOIN
          " . static::$databaseName . ".dbo.Type_StdLetter AS LETTER_TYPE ON LETTER.TemplateID = LETTER_TYPE.ID
        INNER JOIN
          " . static::$databaseName . ".dbo.Creditor_Contact AS CREDITOR ON LETTER.CreditorID = CREDITOR.ID
        WHERE
          ClientID = :id
        AND
          CreditorID != 0
        AND
          LETTER.DateCreated >= :startpoint
        ORDER BY
          dateCreated DESC;",
          \DB::SELECT
      );

      return $query->parameters(array(
        'id' => static::$clientID,
        'startpoint' => date('Y-m-d H:i:s', static::$_settings['debtsolv']['startpoint'])
      ))->cached(1800)->execute(static::$_connection)->as_array();
     }

    /**
     * returns data for the MMS dashboard stats
     * 
     * @return array
     */
    public static function getDebtOwedStats()
    {

      $query = \DB::query(
        "SELECT
          pay_data.NormalExpectedPayment*1./100 AS di_amount
          ,(SELECT SUM(EstimatedBalance)*1./100 FROM  " . static::$databaseName . "Finstat_Debt WHERE ClientID = lead_data.Client_ID) AS amount_owed
          ,ISNULL((SELECT TOP (1) CONVERT(VARCHAR,ExpectedResolutionDate, 103) FROM Client_Services WHERE  ClientID = lead_data.Client_ID ORDER BY ExpectedResolutionDate DESC),'Unavailable') AS ResolutionDate
        FROM
        " . static::$databaseName . ".dbo.Client_LeadData AS lead_data
        INNER JOIN
        " . static::$databaseName . ".dbo.Client_PaymentData AS pay_data ON lead_data.Client_ID = pay_data.ClientID
        WHERE
          lead_data.Client_ID = :id",
        \DB::SELECT
      )->param('id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();

      if(!isset($query[0]))
        throw new \Exception('Unable to fetch results.');

      return $query[0];
    }

    /**
     * returns array for the PPI and PBA quick stats
     * 
     * @return array
     */
    public static function getPBAServicesStats()
    {
      $query = \DB::query(
        "SELECT
          (SELECT COUNT(ServiceType) FROM " . static::$databaseName . ".dbo.Client_Services WHERE ClientID = Client.ID AND Client_Services.ServiceType = 1 AND status = 500 ) AS ppi_services
          ,(SELECT COUNT(ServiceType) FROM " . static::$databaseName . ".dbo.Client_Services WHERE ClientID = Client.ID AND Client_Services.ServiceType = 6 AND status = 500 ) AS pba_services
        FROM
          " . static::$databaseName . ".dbo.Client_Contact AS Client
        WHERE
          Client.ID = :id"
      )->param('id', static::$clientID)->cached(1800)->execute(static::$_connection)->as_array();

      if(!isset($query[0]))
        throw new \Exception('Unable to fetch results');

      return $query[0];

    }

 }