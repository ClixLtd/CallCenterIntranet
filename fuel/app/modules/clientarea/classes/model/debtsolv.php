<?php
/**
 * Debtsolv Model - Only used for the API
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;
 
 class Model_Debtsolv extends \Model
 {

   public static $database = null;
   
   protected static $databaseName = null;
   public static $clientID = 0;
   
   protected static $_database = null;
   protected static $_debtsolvDatabase = null;
   protected static $_leadpoolDatabase = null;
   protected static $_companyID = 0;
	
   protected static $_connection = null;
   
   public static function forge($companyID = 0, $clientID = 0)
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
     $result = \DB::query("SELECT
                             CLIX_CLIENT_ACCOUNT.id
                             ,CLIX_CLIENT_ACCOUNT.password
                           FROM
                             Clix_Client_Portal.dbo.client_accounts AS CLIX_CLIENT_ACCOUNT
                           INNER JOIN
                             " . static::$databaseName . ".dbo.Client_Contact AS CONTACT ON CLIX_CLIENT_ACCOUNT.client_id = CONTACT.ID
                           WHERE
                             CLIX_CLIENT_ACCOUNT.client_id = " . (int)$clientID . "
                           AND
                             CLIX_CLIENT_ACCOUNT.company_id = " . static::$_companyID . "
                           --AND
                           --  [Password] = HASHBYTES( 'SHA1', '" . str_replace("'", "''", $password) . "')
                           --AND
                           --  CONTACT.[Status] IN (9, 13)
                          ", \DB::SELECT)->execute(static::$_connection)->as_array();


     // -- checks given password against the hash 
     // -----------------------------------------
     // salt = $6$rounds=8000$mnwMjNLvHnnUhuP4eX6zi8EvGSru7vWB$
     if(crypt($password, $result[0]['password']) != $result[0]['password'])
        return false;

     // -- Check for a returned row, then return it
     // -------------------------------------------            
     if(isset($result[0]['id']) && $result[0]['id'] > 0)
       return true;
     else
       return false;
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
    $result = \DB::query("UPDATE Top (1)
                             Clix_Client_Portal.dbo.client_accounts
                           SET
                             [password] = '" . $data['newPassword'] . "'
                           WHERE
                             client_id = " . static::$clientID . "
                           AND
                             company_id = " . static::$_companyID . "
                           AND
                             [Password] = '" . $data['currentPassword'] . "'
                          ", \DB::UPDATE)->execute(static::$_connection);


     if($result == 1)
       return true;
     else
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

     $result = \DB::query("SELECT Top (1)
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
                             ID = " . (int)static::$clientID . "
                          ", \DB::select())->execute(static::$_connection)->as_array();
     
     // -- Check results and return
     // ---------------------------                    
     if(isset($result[0]))                   
       return $result[0];
     else
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
     $result = \DB::query("SELECT
    	                       SUM(Amount*1.0)/100 AS Paid_to_Date
                           FROM
                           	 " . static::$databaseName . ".dbo.Payment_Receipt
                           WHERE
                             ClientID = " . static::$clientID . "
                           AND
                             TransactionType = 1
                          ", \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();
                          
     if(isset($result[0]['Paid_to_Date']))
       return $result[0]['Paid_to_Date'];
     else
       return 0;
   }
   
   public static function paidOutToDate()
   {
     $result = 0;
     $result = \DB::query("SELECT
                             SUM(PO.Amount * 1.0) / 100 AS total_out
                           FROM
                             " . static::$databaseName . ".dbo.Payment_Out AS PO
                           --INNER JOIN
                           --  " . static::$databaseName . ".dbo.Finstat_Debt AS FSD ON PO.AccountRef = FSD.AccountReference AND PO.ClientID = FSD.ClientID
                           WHERE
                             PO.ClientID = " . static::$clientID . "
                          ", \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();
                          
     if(isset($result[0]['total_out']))
       return $result[0]['total_out'];
     else
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
                             FSD.ID
                            ,FSD.Description
                            ,(
                               SELECT
                                 SUM(Amount * 1.0)/100
                               FROM
                                 " . static::$databaseName . ".dbo.Payment_Out
                               WHERE AccountRef = FSD.AccountReference
                             ) AS Paid
                            ,(FSD.AmountOwed * 1.0)/100 AS Owed
                            ,FSD.AccountReference
                          FROM 
                            " . static::$databaseName . ".dbo.Finstat_Debt AS FSD
                          WHERE 
                            FSD.ClientID = " . static::$clientID
                         , \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();
                         
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
                                 Amount AS Amount_In
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
                                ClientID = " . static::$clientID . "
                            )
                            UNION
                            (
                              SELECT
                                 '' AS Amount_In
                                ,Amount AS Amount_Out
                                ,FD.[Description]
                                ,DateSent
                                ,TPS.[Description] AS PaymentStatus
                                ,TPM.[Description] AS PaymentMethod
                                ,'' AS PaymentTransaction
                                ,'Out' AS Type
                              FROM
                                " . static::$databaseName . ".dbo.Payment_Out AS PO
                              LEFT JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Method AS TPM ON PO.PaymentMethod = TPM.ID
                              LEFT JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Status AS TPS ON PO.[Status] = TPS.ID
                              LEFT JOIN
                                " . static::$databaseName . ".dbo.Finstat_Debt AS FD ON PO.AccountRef = FD.AccountReference AND PO.ClientID = FD.ClientID
                              WHERE
                                PO.ClientID = " . static::$clientID . "
                            )
                            ORDER BY
                              [Date] DESC
                          ", \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();
                          
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
     $results = \DB::query("SELECT TOP (1)
                              SUM(Amount * 1.0) / 100 As warchest_amount
                            FROM
                              " . static::$databaseName . ".dbo.Payment_Warchest
                            WHERE
                              ClientID = " . static::$clientID . "
                           ", \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();
                           
     if(isset($results[0]['warchest_amount']))
       return $results[0]['warchest_amount'];
     else
       return 0;
   }

   /**
    * Get the Client's standing order date
    *
    * @author David Stansfield
    */
    public static function standingOrderDate()
    {
        $result = array();
        $result = \DB::query("SELECT TOP (1)
                                PAYMENT_SCHEDULE.DateExpected AS next_payment_date
                               ,PAYMENT_METHOD.[Description] AS payment_method
                              FROM
                                " . static::$databaseName . ".dbo.Payment_Schedule AS PAYMENT_SCHEDULE
                              INNER JOIN
                                " . static::$databaseName . ".dbo.Type_Payment_Method AS PAYMENT_METHOD ON PAYMENT_METHOD.ID = PAYMENT_SCHEDULE.PaymentMethod
                              WHERE
                                PAYMENT_SCHEDULE.ClientID = " . static::$clientID . "
                              AND
                                PAYMENT_SCHEDULE.DateExpected >= GETDATE()
                              AND
                                PAYMENT_SCHEDULE.AmountPaid = '0'
                              ORDER BY
                                PAYMENT_SCHEDULE.SequenceID ASC
                             ", \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();

        if(isset($result[0]))
            return $result[0];
        else
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
                                WHERE
                                  CLIENT_SERVICE.ClientID = " . static::$clientID . "
                                AND
                                  CLIENT_SERVICE.ServiceType IN (1, 2, 4)
                                AND
                                  CLIENT_STAGE.StageRow = 1
                                ", \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();

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
         $results = \DB::query("SELECT TOP (1)
                                  SUM(Amount * 1.0) / 100 AS total_fee_amount
                                FROM
                                  " . static::$databaseName . ".dbo.Payment_Fee
                                WHERE
                                  ClientID = " . static::$clientID . "
                                AND
                                  [Status] = 10
                               ", \DB::SELECT)->cached(1800)->execute(static::$_connection)->as_array();

         if(isset($results[0]['total_fee_amount']))
             return $results[0]['total_fee_amount'];
         else
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
                                  ClientID = " . static::$clientID . "
                               ", \DB::SELECT)->execute(static::$_connection)->as_array();

         if(isset($results[0]['total_owed']))
             return $results[0]['total_owed'];
         else
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
        )->execute(static::$_connection)->as_array();
     }

     public static function getCreditorCount()
     {
        $query = 'SELECT
                    (SELECT SUM(EstimatedBalance*1.0)/100 FROM '.static::$databaseName.'.dbo.Finstat_Debt WHERE ClientID = '.static::$clientID.') AS totalDebt
                    ,COUNT(*) AS countCreditors
                  FROM
                    '.static::$databaseName.'.dbo.Finstat_Debt
                  WHERE
                    ClientID = '. static::$clientID . '
                  AND
                    EstimatedBalance > 0;';

        return \DB::query($query)->execute(static::$_connection)->as_array();
     }
 }