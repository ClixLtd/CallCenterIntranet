<?php
/**
 * Debtsolv Model - Only used for the API
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;
 
 class Model_Debtsolv extends \Model
 {
   public static $database;
   public static $clientID;
   
   public static function forge($database = null, $clientID = 0)
   {
     // -- Set the database name
     // ------------------------
     if(!is_null($database))
       static::$database = 'debtsolv_clientarea_' . $database;
       
     // -- Set the Client ID
     // --------------------
     static::$clientID = (int)$clientID;
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
     
     $result = \DB::query("SELECT Top (1)
                             Client_ID
                           FROM
                             dbo.Client_LeadData
                           WHERE
                             Client_ID = " . (int)$clientID . "
                           AND
                             [Password] = HASHBYTES('sha1', '" . str_replace("'", "''", $password) . "')
                          ")->execute(static::$database)->as_array();
     
     // -- Check for a returned row, then return it
     // -------------------------------------------            
     if(isset($result[0]['Client_ID']) && $result[0]['Client_ID'] > 0)
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
     $result = \DB::query("UPDATE Top (1)
                             dbo.Client_LeadData
                           SET
                             [Password] = HASHBYTES('sha1', '" . str_replace("'", "''", $data['newPassword']) . "')
                           WHERE
                             Client_ID = " . static::$clientID . "
                           AND
                             [Password] = HASHBYTES('sha1', '" . str_replace("'", "''", $data['currentPassword']) . "')
                          ", \DB::UPDATE)->execute(static::$database);
                          
     if($result > 0)
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
                             ,Postcode
                             ,Tel_Home
                             ,Tel_Work
                             ,Tel_Mobile
                             ,email
                           FROM
                             dbo.Client_Contact
                           WHERE
                             ID = " . (int)static::$clientID . "
                          ", \DB::select())->execute(static::$database)->as_array();
     
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
                           	 Debtsolv_Test.dbo.Payment_Receipt
                           WHERE
                             ClientID = " . static::$clientID . "
                           AND
                             TransactionType = 1                             
                          ", \DB::SELECT)->execute(static::$database)->as_array();
                          
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
                             dbo.Payment_Out AS PO
                           INNER JOIN
                             dbo.Finstat_Debt AS FSD ON PO.AccountRef = FSD.AccountReference
                           WHERE
                             PO.ClientID = " . static::$clientID . "
                          ", \DB::SELECT)->execute(static::$database)->as_array();
                          
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
                                 dbo.Payment_Out
                               WHERE AccountRef = FSD.AccountReference
                             ) AS Paid
                            ,(FSD.AmountOwed * 1.0)/100 AS Owed
                            ,FSD.AccountReference
                          FROM 
                            dbo.Finstat_Debt AS FSD
                          WHERE 
                            FSD.ClientID = " . static::$clientID
                         , \DB::SELECT)->execute(static::$database)->as_array();
                         
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
                                [Debtsolv_Test].[dbo].[Payment_Receipt] AS PR
                              LEFT JOIN
                                [Debtsolv_Test].[dbo].Type_Payment_Method AS TPM ON PR.PaymentMethod = TPM.ID
                              LEFT JOIN
                                Debtsolv_Test.dbo.Type_Payment_Transaction AS TPT ON PR.TransactionType = TPT.ID
                              LEFT JOIN
                                Debtsolv_Test.dbo.Type_Payment_Status AS TPS ON PR.[Status] = TPS.ID
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
                                Debtsolv_Test.dbo.Payment_Out AS PO
                              LEFT JOIN
                                [Debtsolv_Test].[dbo].Type_Payment_Method AS TPM ON PO.PaymentMethod = TPM.ID
                              LEFT JOIN
                                Debtsolv_Test.dbo.Type_Payment_Status AS TPS ON PO.[Status] = TPS.ID
                              LEFT JOIN
                                Debtsolv_Test.dbo.Finstat_Debt AS FD ON PO.AccountRef = FD.AccountReference
                              WHERE
                                PO.ClientID = " . static::$clientID . "
                            )
                            ORDER BY
                              [Date] DESC
                          ", \DB::SELECT)->execute(static::$database)->as_array();
                          
     return $results;
   }
 }