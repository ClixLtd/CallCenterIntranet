<?php

namespace GAB;

class Debtsolv {
	
	// Detbsolv database details to be pulled from the config
	protected static $_debtsolv_database = null;
	protected static $_leadpool_database = null;
	
	protected static $_connection = null;
	
	// Store the shortcode of the call center here
	protected static $_shortcode = null;
	
	
	
	
	public static function _init()
	{
		\Config::load('debtsolv', 'debtsolv');
		
		static::$_debtsolv_database = \Config::get('debtsolv.debtsolv_database', static::$_debtsolv_database);
		static::$_leadpool_database = \Config::get('debtsolv.leadpool_database', static::$_leadpool_database);
		
		static::$_connection = \Database_Connection::instance('Debtsolv', \Config::get('debtsolv.connection', static::$_connection));
		
	}
	
	
	
	
	
	
	
	public static function get_best_solutions_disposition_report($show_only = null)
	{
		
		$results = \DB::query("SELECT 
			 CC.ID
			,CC.FullName
			,CC.Postcode
			,CS.Description AS Status
			,CC.Tel_Home
			,CC.Tel_Mobile
			,PD.InitialAgreedAmount/100 AS DI
			,CLD.DatePackSent
			,CLD.DatePackReceived AS 'Pack In Date'
			FROM BS_DebtSolv_DM.dbo.Client_Contact AS CC
			LEFT JOIN BS_DebtSolv_DM.dbo.Client_LeadData AS CLD ON CC.ID = CLD.Client_ID
			LEFT JOIN BS_DebtSolv_DM.dbo.Client_PaymentData AS PD ON CC.ID = PD.ClientID
			LEFT JOIN BS_DebtSolv_DM.dbo.Type_Client_Status AS CS ON CC.status = CS.ID
			WHERE
				CC.status IN (9,8)
			;")->cached(900)->execute(static::$_connection);
		
		
		return $results;
		
	}
	
	public static function get_best_solutions_paid_in_report($client_id)
	{
		
		$extended_where = '(';
		
		foreach ($client_id AS $id => $date)
		{
			$extended_where .= " (PA.ClientID=".$id." AND PA.TransactionDate >= '".$date."' ) ";
			
			
			end($client_id);
			if ($id != key($client_id))
				$extended_where .= 'OR';
		}
	
		$extended_where .= ')';
	
	
		//$client_ids = (is_array($client_id)) ? implode("', '", $client_id) : $client_id;
		
		$results = \DB::query("SELECT 
				PA.ClientID AS ClientID
				, (CD.Forename + ' ' + CD.Surname) AS Name
				, SUM(AmountIn)/100 AS 'Total Payed'
				, COUNT(AmountIn) AS 'Number of Payments'
				, PA.TransactionDate AS 'Payment Date'
			FROM
				BS_Debtsolv_DM.dbo.Payment_Account AS PA
			LEFT JOIN 
				BS_Debtsolv_DM.dbo.Client_Contact AS CD ON PA.ClientID=CD.ID
			LEFT JOIN
				BS_Debtsolv_DM.dbo.Client_LeadData AS CLD ON PA.ClientID=CLD.Client_ID
			WHERE
				AmountIn > 0 AND
				".$extended_where."
			GROUP BY PA.ClientID, CD.Forename, CD.Surname, PA.TransactionDate;")->cached(900)->execute(static::$_connection);
		
		
		//print_r($results);
		return $results;
		
	}
	
	
	
	
	public static function get_all_paid_in_report($client_id)
	{
		$client_ids = (is_array($client_id)) ? implode("', '", $client_id) : $client_id;
		
		$results = \DB::query("SELECT 
				CLD.LeadPoolReference AS 'Leadpool ID'
				, LSO.Reference
				, PA.ClientID AS ClientID
				, LSO.Description AS 'Lead Source'
				, (CD.Forename + ' ' + CD.Surname) AS Name
				, CONVERT(varchar, PA.TransactionDate, 105) AS payDay
				, CPD.InitialAgreedAmount AS DI
				, PA.AmountIn AS Payment
			FROM
				Debtsolv.dbo.Payment_Account AS PA
			LEFT JOIN 
				Debtsolv.dbo.Client_Contact AS CD ON PA.ClientID=CD.ID
			LEFT JOIN
				Debtsolv.dbo.Client_LeadData AS CLD ON PA.ClientID=CLD.Client_ID
			LEFT JOIN
				Debtsolv.dbo.Client_PaymentData AS CPD ON PA.ClientID=CPD.ClientID
			LEFT JOIN
				LeadPool_DM.dbo.Client_LeadDetails AS CLDe ON CLD.LeadPoolReference=CLDe.ClientID
			LEFT JOIN
				LeadPool_DM.dbo.LeadBatch AS LBA ON CLDe.LeadBatchID = LBA.ID
			LEFT JOIN
				LeadPool_DM.dbo.Type_Lead_Source AS LSO ON LBA.LeadSourceID = LSO.ID
			WHERE
				LSO.Reference IN ('".$client_ids."')
				AND PA.AmountIn > 0
			ORDER BY
				PA.TransactionDate;")->cached(900)->execute(static::$_connection);
		
		return $results;
		
	}
	
	
	/**
	 * Pulls a list of payments from a client ID or list of IDs.
	 * 
	 * @access public
	 * @static
	 * @param mixed $client_id
	 * @return void
	 */
	public static function get_paid_in_report($client_id)
	{
		$client_ids = (is_array($client_id)) ? implode("', '", $client_id) : $client_id;
		
		$results = \DB::query("SELECT 
				CLD.LeadPoolReference AS 'Leadpool ID'
				, LSO.Reference
				, PA.ClientID AS ClientID
				, LSO.Description AS 'Lead Source'
				, (CD.Forename + ' ' + CD.Surname) AS Name
				, SUM(AmountIn)/100 AS 'Total Payments'
				, COUNT(AmountIn) AS 'Number of Payments'
			FROM
				Debtsolv.dbo.Payment_Account AS PA
			LEFT JOIN 
				Debtsolv.dbo.Client_Contact AS CD ON PA.ClientID=CD.ID
			LEFT JOIN
				Debtsolv.dbo.Client_LeadData AS CLD ON PA.ClientID=CLD.Client_ID
			LEFT JOIN
				LeadPool_DM.dbo.Client_LeadDetails AS CLDe ON CLD.LeadPoolReference=CLDe.ClientID
			LEFT JOIN
				LeadPool_DM.dbo.LeadBatch AS LBA ON CLDe.LeadBatchID = LBA.ID
			LEFT JOIN
				LeadPool_DM.dbo.Type_Lead_Source AS LSO ON LBA.LeadSourceID = LSO.ID
			WHERE
				LSO.Reference IN ('".$client_ids."')
				AND PA.AmountIn > 0
			GROUP BY PA.ClientID, CD.Forename, CD.Surname, CLD.LeadPoolReference, LSO.Description, LSO.Reference;")->cached(900)->execute(static::$_connection);
		
		return $results;
		
	}
	
	
	/**
	 * Pulls a disposition report based on a dialler list ID or an array of List IDs.
	 * 
	 * @access public
	 * @static
	 * @param mixed $dialler_list_id
	 * @param mixed $show_only (default: null)
	 * @return void
	 */
	public static function get_dialler_list_disposition_report($dialler_list_id, $show_only = null)
	{
		$list_ids = (is_array($dialler_list_id)) ? implode("', '", $dialler_list_id) : $dialler_list_id;
		
		$results = \DB::query("SELECT CLD.ClientID AS 'Leadpool ID'
		  ,D_CPD.ClientID AS ClientID
	      ,(CD.Forename + ' ' + CD.Surname) AS Name
	      ,LSO.[Description] AS 'Lead Source'
	      ,TCR.[Description]
	      ,CASE
	         WHEN D_CPD.InitialAgreedAmount > 0 AND CC.ContactResult = 1500
	            THEN 'DR'
	         WHEN (D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500
	            THEN 'PPI'
	         ELSE
	           ''
	         END AS Product
	      ,D_CPD.InitialAgreedAmount / 100 AS DI
	      ,CONVERT(varchar, D_CLD.DatePackReceived, 105) AS 'Pack In Date'
	      ,CONVERT(varchar, CLD.DateCreated, 105) AS 'Referred Date'
	      ,CONVERT(varchar, CC.LastContactAttempt, 120) AS 'Last Contact Date'
	      ,CASE
	         WHEN CC.ContactResult = 700
	           THEN CONVERT(varchar, CC.Appointment, 120)
	         ELSE
	           ''
	       END AS 'Call Back Date'
	  FROM
	    LeadPool_DM.dbo.Client_LeadDetails AS CLD
	  LEFT JOIN
	    LeadPool_DM.dbo.Client_Details AS CD ON CLD.ClientID = CD.ClientID
	  LEFT JOIN
	    LeadPool_DM.dbo.Campaign_Contacts AS CC ON CLD.ClientID = CC.ClientID
	  LEFT JOIN
	    LeadPool_DM.dbo.Type_ContactResult AS TCR ON CC.ContactResult = TCR.ID
	  LEFT JOIN
		LeadPool_DM.dbo.LeadBatch AS LBA ON CLD.LeadBatchID = LBA.ID
	  LEFT JOIN
		LeadPool_DM.dbo.Type_Lead_Source AS LSO ON LBA.LeadSourceID = LSO.ID
	  LEFT JOIN
	    Debtsolv.dbo.Client_LeadData AS D_CLD ON CLD.ClientID = D_CLD.LeadPoolReference
	  LEFT JOIN
	    Debtsolv.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
	  LEFT JOIN
	    Debtsolv.dbo.Client_PaymentData AS D_CPD ON D_CLD.Client_ID = D_CPD.ClientID
	  WHERE 
	  	TCR.[Description] NOT IN ('Referred')
	    AND LSO.[Reference] IN ('".$list_ids."')
		AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500)
	  ORDER BY
		CLD.LeadRef2
	    ,TCR.[Description]
	    ,Product
	    ,CLD.DateCreated DESC")->cached(900)->execute(static::$_connection);
		
		
		return $results;
		
	}
	
	
	
	
	
	
	public static function insert_lead_details($lead_id, $list_id, $dialler_id)
	{
		
		// Double check that this clientID hasn't already been added to the leadpool
		$check_client = \DB::query("SELECT count(ClientID) AS total FROM ".static::$_leadpool_database.".dbo.Client_LeadDetails
			WHERE ClientID = ".$lead_id.";
		")->cached(0)->execute(static::$_connection)->as_array();
		
		if ($check_client[0]['total'] > 0)
		{
			return array(
				"created" 	=> FALSE,
				"code"		=> 101,
				"message" 	=> 'Lead already exists.',
			);
		}
		
		
		$lead_batch_id = \DB::query("SELECT Top (1) ID FROM ".static::$_debtsolv_database.".dbo.Type_Lead_Source 
			WHERE Reference = '" . $list_id . "'
		")->cached(0)->execute(static::$_connection)->as_array();
		
		
		if ($lead_batch_id[0]['ID'] <= 0)
		{
			return array(
				"created" 	=> FALSE,
				"code"		=> 102,
				"message" 	=> 'No lead Batch Found.',
			);
		}
		
		
		$result = \DB::query("INSERT INTO ".static::$_leadpool_database.".dbo.Client_LeadDetails
			(ClientID, LeadBatchID, LeadRef, LeadRef2, CaseNotes, LeadNotes)
			VALUES
			(".$lead_id.", ".(int)$lead_batch_id[0]['ID'].", '".$dialler_id."', '".static::$_shortcode."', '','')
		")->cached(0)->execute(static::$_connection);
		
		return array(
				"created" 	=> TRUE,
		);
		
	}
	
	
	
	/**
	 * create_campaign_contact_id function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $lead_id
	 * @param mixed $comments
	 * @return void
	 */
	public static function create_campaign_contact_id($lead_id, $comments)
	{
		// Create Campaign Contact ID
		$campaign_contact_id = \DB::query("INSERT INTO ".static::$_leadpool_database.".dbo.Campaign_Contacts
		(
			ClientID,
			CampaignID,
			Appointment,
			LastContactAttempt,
			ContactResult,
			Note
		)
		VALUES
		(
			".$lead_id.",
			0,
			NULL,
			GETDATE(),
			0,
			'".$comments."'
		);
		")->execute(static::$_connection);
		
		$cc_id = \DB::query("SELECT @@IDENTITY AS lastID")->execute(static::$_connection)->as_array();
		
		if ((int)$cc_id[0]['lastID'] <= 0) {
			// Fail to add the lead
			return array(
				"created" 	=> FALSE,
				"message" 	=> 'Failed to Create Campaign Contact.',
			);
		} else {
			return array(
				"created" 	=> TRUE,
				"id" 		=> (int)$cc_id[0]['lastID'],
			);
		}
	}
	
	
	/**
	 * create_lead function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $title
	 * @param mixed $forename
	 * @param mixed $surname
	 * @param mixed $address
	 * @param mixed $area
	 * @param mixed $town
	 * @param mixed $postcode
	 * @return void
	 */
	public static function create_lead($title, $forename, $surname, $address, $area, $town, $postcode)
	{
		
		// Create the lead in the leadpool
		$new_lead_id = \DB::query("DECLARE @NewLeadID int
			EXEC ".static::$_leadpool_database.".dbo.isp_CreateNewClient_103 
			@Title 				= '".$title."',
			@Initials 			= '',
			@Forename 			= '".$forename."',
			@MiddleNames 		= '',
			@Surname 			= '".$surname."',
			@DateOfBirth 		= NULL,
			@Email 				= '',
			@MaritalStatus 		= '',
			@Gender 			= '',
			@StreetAndNumber 	= '".$address."',
			@Area 				= '".$area."',
			@District	 		= '',
			@Town 				= '".$town."',
			@County 			= '',
			@Country 			= '',
			@Postcode 			= '".$postcode."',
			@ID 				= @NewLeadID OUTPUT
			SELECT NewLeadID 	= @NewLeadID
		", \DB::SELECT)->cached(900)->execute(static::$_connection);
		
		$new_lead_id = 11;
		
		if ($new_lead_id <= 0) {
			// Fail to add the lead
			return array(
				"created" 	=> FALSE,
			);
		} else {
			return array(
				"created" 	=> TRUE,
				"client_id" 	=> $new_lead_id,
			);
		}
		
	}
	
	
	/**
	 * Check for duplcates, returns an array if found including database found in.
	 * 
	 * @access public
	 * @static
	 * @param mixed $client_id
	 * @param mixed $surname
	 * @param mixed $street_number
	 * @param mixed $postcode
	 * @param mixed $telephone
	 * @return void
	 */
	public static function check_for_duplicate($surname, $street_number, $postcode, $telephone)
	{
		$found_array = array();
		
		// Check Detbsolv database for a duplicate
		$result = \DB::query("EXEC ".static::$_debtsolv_database.".dbo.dssp_CheckDuplicateClient_12_4 
			@ClientID 			= 0,
			@Surname 			= '" . $surname . "',
			@StreetAndNumber 	= '" . $street_number . "',
			@Postcode 			= '" . $postcode . "',
			@Telephone 			= '". $telephone . "'
		", \DB::SELECT)->cached(900)->execute(static::$_connection);
		
		if (count($result->as_array()) > 0)
		{
			// Fail the duplicate check 
			return array(
				"found" 	=> TRUE,
				"result"	=> $result,
				"location" 	=> 'debtsolv',
			);
		}
		
		// Check the Leadpool for a duplicate
		$result = \DB::query("EXEC ".static::$_leadpool_database.".dbo.dssp_CheckDuplicateClient_12_4 
			@ClientID 			= 0,
			@Surname 			= '" . $surname . "',
			@StreetAndNumber 	= '" . $street_number . "',
			@Postcode 			= '" . $postcode . "',
			@Telephone 			= '" . $telephone . "'
		", \DB::SELECT)->cached(900)->execute(static::$_connection);
		
		if (count($result->as_array()) > 0)
		{
			// Fail the duplicate check 
			return array(
				"found" 	=> TRUE,
				"result"	=> $result,
				"location" 	=> 'leadpool',
			);
		}
		
		// There are no duplicates
		return array(
			"found" 	=> FALSE,
			"result"	=> 'Success',
			"location"	=> 'leadpool',
		);
		
	}
	
	
	
	/**
	 * Sets the shortcode for the call center.
	 * 
	 * @access public
	 * @static
	 * @param mixed $shortcode
	 * @return void
	 */
	public static function set_shortcode($shortcode)
	{
		static::$_shortcode = $shortcode;
	}
	
	
	public static function create_log($username, $error_code, $error_message, $post)
	{
		
		$log = new \Model_Debtsolv_Transfer_Log();
		$log->shortcode = static::$_shortcode;
		$log->dialler_username = $username;
		$log->error_code = $error_code;
		$log->error_message = $error_message;
		$log->var_dump = serialize($post);
		$log->save();
		
		return TRUE;
		
	}
	
}