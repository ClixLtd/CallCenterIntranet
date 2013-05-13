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
	
	
	
	public static function change_center($ds_lead_id, $new_center)
	{
		$success = FALSE;
		$message = "";
		
		// Check lead exists in Leadpool
		$leadpool = \DB::query("
			SELECT
				  ClientID
				, LeadBatchID
				, LeadRef
				, LeadRef2
				, CONVERT(datetime, DateCreated, 120) AS DateCreated
			FROM
				Leadpool_DM.dbo.Client_LeadDetails
			WHERE
				ClientID = ".$ds_lead_id."
		")->cached(0)->execute(static::$_connection);
		
		// Change LeadRef2
		
		if ($leadpool->count() > 0)
		{
			\DB::query("UPDATE Leadpool_DM.dbo.Client_LeadDetails SET LeadRef2='".$new_center."' WHERE ClientID=".$ds_lead_id)->execute(static::$_connection);
			
			$referral_table = \DB::query("
				SELECT
					  id
					, list_id
					, lead_id
					, leadpool_id
					, list_name
					, short_code
					, user_login
					, full_name
					, referral_date
					, product
				FROM
					Dialler.dbo.referrals
				WHERE
					leadpool_id = ".$ds_lead_id."
			")->execute(static::$_connection);
			
			$our_referral = $leadpool->as_array();
			
			$success = TRUE;
			$message = "";
			
			if ($referral_table->count() > 0)
			{
				// Update the entry
				\DB::query("UPDATE Dialler.dbo.referrals SET short_code='".$new_center."', referral_date='".$our_referral[0]['DateCreated']."' WHERE leadpool_id = ".$ds_lead_id."")->execute(static::$_connection);
			}
			else
			{
				// Create a new entry
				\DB::query("INSERT INTO Dialler.dbo.referrals
					( list_id
					,lead_id
					,leadpool_id
					,list_name
					,short_code
					,user_login
					,full_name
					,referral_date
					,product)
					VALUES
					( ''
					, ''
					, " . $ds_lead_id . "
					, ''
					, '" . $new_center . "'
					, ''
					, ''
					, '".$our_referral[0]['DateCreated']."'
					, 'DR')")->execute(static::$_connection);
			}
			
			\Cache::delete_all("disposition.report/");
			
		}
		else
		{
			$success = FALSE;
			$message = "Leadpool ID not found!";
		}
		
		return array(
			"success" => $success,
			"message" => $message,
		);
		
	}
	
	
	
	
		public static function change_center_resolve($ds_lead_id, $new_center)
	{
		$success = FALSE;
		$message = "";
		
		// Check lead exists in Leadpool
		$leadpool = \DB::query("
			SELECT
				  ClientID
				, LeadBatchID
				, LeadRef
				, LeadRef2
				, CONVERT(datetime, DateCreated, 120) AS DateCreated
			FROM
				BS_Leadpool_DM.dbo.Client_LeadDetails
			WHERE
				ClientID = ".$ds_lead_id."
		")->cached(0)->execute(static::$_connection);
		
		// Change LeadRef2
		
		if ($leadpool->count() > 0)
		{
			\DB::query("UPDATE BS_Leadpool_DM.dbo.Client_LeadDetails SET LeadRef2='".$new_center."' WHERE ClientID=".$ds_lead_id)->execute(static::$_connection);
			
			$referral_table = \DB::query("
				SELECT
					  id
					, list_id
					, lead_id
					, leadpool_id
					, list_name
					, short_code
					, user_login
					, full_name
					, referral_date
					, product
				FROM
					Dialler.dbo.referrals
				WHERE
					leadpool_id = ".$ds_lead_id."
			")->execute(static::$_connection);
			
			$our_referral = $leadpool->as_array();
			
			$success = TRUE;
			$message = "";
			
			if ($referral_table->count() > 0)
			{
				// Update the entry
				\DB::query("UPDATE Dialler.dbo.referrals SET short_code='".$new_center."', referral_date='".$our_referral[0]['DateCreated']."' WHERE leadpool_id = ".$ds_lead_id."")->execute(static::$_connection);
			}
			else
			{
				// Create a new entry
				\DB::query("INSERT INTO Dialler.dbo.referrals
					( list_id
					,lead_id
					,leadpool_id
					,list_name
					,short_code
					,user_login
					,full_name
					,referral_date
					,product)
					VALUES
					( ''
					, ''
					, " . $ds_lead_id . "
					, ''
					, '" . $new_center . "'
					, ''
					, ''
					, '".$our_referral[0]['DateCreated']."'
					, 'DR')")->execute(static::$_connection);
			}
			
			\Cache::delete_all("disposition.report/");
			
		}
		else
		{
			$success = FALSE;
			$message = "Leadpool ID not found!";
		}
		
		return array(
			"success" => $success,
			"message" => $message,
		);
		
	}

	
	
	
	
	
	
	// Start New Debtsolv Referral table functions
	
	public static function get_referrals($centers=null, $start_date=null, $end_date=null, $cache=0)
	{
		$date_where = (!is_null($start_date) AND !is_null($end_date)) 
			? "(referral_date >= CONVERT(datetime, '".$start_date."', 105) AND referral_date <= CONVERT(datetime, '".$end_date."', 105) ) "
			: "referral_date >= DATEADD(DAY,DATEDIFF(day,0,GetDate()),0)";
		
		if (!is_null($centers))
		{
			$center_where = (is_array($centers)) ? "AND short_code IN ('".implode("','", $centers)."')" : "AND short_code='".$centers."'";
		}
		else
		{
			$center_where = "";
		}
		
		
		$results = \DB::query("
			SELECT
				list_id,
				lead_id,
				leadpool_id,
				list_name,
				short_code,
				user_login,
				full_name,
				referral_date
			FROM
				Dialler.dbo.referrals
			WHERE
				" . $date_where . "
				" . $center_where . ";
		")->cached($cache)->execute(static::$_connection);
		
		
		return $results;
	}
	
	
	
	
	
	// End New Debtsolv Referral table functions
	
	
	
	
	
	
	
	
	
	// Today's Stats
	
	public static function paid_in($start_date=null, $end_date=null)
	{
		$date_where = (!is_null($start_date) AND !is_null($end_date)) 
			? "(Date >= CONVERT(datetime, '".$start_date."', 105) AND Date <= CONVERT(datetime, '".$end_date."', 105) ) "
			: "Date = DATEADD(DAY,DATEDIFF(day,0,GetDate()),0)";

		$results = \DB::query("
			SELECT
				count(AmountIn) AS paid,
				(SUM(AmountIn)/100) AS payments
			FROM
				Debtsolv.dbo.Payment_Account AS PA
			WHERE
				".$date_where.";
		")->cached(600)->execute(static::$_connection);
		
		
		return array(
			'paid' => $results[0]['paid'],
			'total' => $results[0]['payments'],
		);


	}
	
	
	public static function paid_in_report($start_date=null, $end_date=null)
	{
		$date_where = (!is_null($start_date) AND !is_null($end_date)) 
			? "(Date >= CONVERT(datetime, '".$start_date."', 105) AND Date <= CONVERT(datetime, '".$end_date."', 105) ) "
			: "(Date >= CONVERT(datetime, '".date("t-m-Y", strtotime('last month'))."', 105) AND Date <= CONVERT(datetime, '".((int)date("t", strtotime('this month'))-1)."-".date("m-Y", strtotime('this month'))."', 105) ) ";


		$results = \DB::query("
			SELECT
				  PA.ClientID
				, (CD.Forename + ' ' + CD.Surname) AS Name
				, ISNULL(LCLD.LeadRef2,'NONE') AS Office
				, DCPD.NormalExpectedPayment AS DI
				, (SELECT COUNT(AmountIn) FROM Debtsolv.dbo.Payment_Account WHERE AmountIn > 0 AND ClientID=PA.ClientID) AS TotalPayments
				, (SELECT SUM(AmountIn) FROM Debtsolv.dbo.Payment_Account WHERE AmountIn > 0 AND ClientID=PA.ClientID) AS TotalPaid
				, (
			        SELECT Top (1)
			          Undersigned
			        FROM
			          Debtsolv.dbo.Users AS D_URS
			        LEFT JOIN
			          Debtsolv.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
			        WHERE
			          D_CLD.LeadPoolReference = LCLD.ClientID
			      ) AS 'Consolidator'
			FROM
				Debtsolv.dbo.Payment_Account AS PA
			LEFT JOIN
				Debtsolv.dbo.Client_PaymentData AS DCPD ON PA.ClientID=DCPD.ClientID
			LEFT JOIN
				Debtsolv.dbo.Client_LeadData AS DCLD ON PA.ClientID=DCLD.Client_ID
			LEFT JOIN 
				Leadpool_DM.dbo.Client_LeadDetails AS LCLD ON DCLD.LeadPoolReference=LCLD.ClientID
			LEFT JOIN
				LeadPool_DM.dbo.Client_Details AS CD ON LCLD.ClientID = CD.ClientID
			WHERE
				".$date_where."
				AND PA.AmountIn > 0
		")->cached(3600)->execute(static::$_connection);
		
		
		// Dedupe all the data and only add to the list if they have reached their DI
		$all_clients = array();
		$client_list = array();
		$invalid_clients = array();
		foreach ($results AS $result)
		{
			if ($result['Consolidator'] <> "FAB Admin")
			{
				if ($result['TotalPaid'] == $result['DI'])
				{
					$client_list[] = $result;
				}
				
				
				if ((int)$result['DI'] > 0 AND $result['Office']<>'NONE' AND $result['Office']<>' ')
				{
					// Check that the 
					if ($result['TotalPaid'] == $result['DI'])
					{
						$all_clients[$result['ClientID']] = $result;
					} 
					else if ($result['TotalPaid'] > $result['DI'])
					{
						// Client has already reached their DI, but when?
						// Check database and find out
						$quickCheck = \DB::query("SELECT Date,AmountIn FROM Debtsolv.dbo.Payment_Account WHERE AmountIn > 0 AND ClientID=".$result['ClientID']." ORDER BY Date ASC")->cached(3600)->execute(static::$_connection);
						$running_total = 0;
						$first_pay_date = null;
						foreach ($quickCheck AS $check)
						{
							if (is_null($first_pay_date))
							{
								$running_total = $running_total + $check['AmountIn'];
								if ($running_total >= $result['DI'])
								{
									$first_pay_date = $check['Date'];
								}
							}
						}
						
						if (strtotime($first_pay_date) >= strtotime($start_date) AND strtotime($first_pay_date) <= strtotime($end_date) AND !isset($all_clients[$result['ClientID']]))
						{
							$all_clients[$result['ClientID']] = $result;
							$client_list[] = $result;
						}
						
						
					}
				}
				else
				{
					if ($result['TotalPaid'] == $result['DI'] || $result['DI'] == 0)
					{
						$invalid_clients[] = $result;
					}
				}
			}
		}
		
		// Group the data by Consolidator
		$consolidator_clients = array();
		foreach ($all_clients AS $client)
		{
		
			$consolidator_clients[$client['Consolidator']]['TotalDue'] = (isset($consolidator_clients[$client['Consolidator']]['TotalDue'])) ? $consolidator_clients[$client['Consolidator']]['TotalDue'] : 0;
			$consolidator_clients[$client['Consolidator']]['Weekly'] = (isset($consolidator_clients[$client['Consolidator']]['Weekly'])) ? $consolidator_clients[$client['Consolidator']]['Weekly'] : 0;
			$consolidator_clients[$client['Consolidator']]['Internal'] = (isset($consolidator_clients[$client['Consolidator']]['Internal'])) ? $consolidator_clients[$client['Consolidator']]['Internal'] : 0;
			$consolidator_clients[$client['Consolidator']]['External'] = (isset($consolidator_clients[$client['Consolidator']]['External'])) ? $consolidator_clients[$client['Consolidator']]['External'] : 0;
			
			
			
			
			
			
			
			
			
			// If the comission is based on a weekly payment
			if ($client['TotalPayments'] > 1)
			{
				$client['DuePayment'] = ($client['DI']*0.1);
				
				$consolidator_clients[$client['Consolidator']]['Clients']['Weekly'][] = $client;
				
				$consolidator_clients[$client['Consolidator']]['Weekly'] = (isset($consolidator_clients[$client['Consolidator']]['Weekly'])) ? $consolidator_clients[$client['Consolidator']]['Weekly'] + number_format($client['DuePayment']/100,2,'.','') : number_format($client['DuePayment']/100,2,'.','');
			}
			else
			{
				// If the comission is internal
				if (in_array($client['Office'], array( 'GAB', 'RESOLVE' )))
				{
					$client['DuePayment'] = ($client['DI']*0.1);
					
					$consolidator_clients[$client['Consolidator']]['Clients']['Internal'][] = $client;
					
					$consolidator_clients[$client['Consolidator']]['Internal'] = (isset($consolidator_clients[$client['Consolidator']]['Internal'])) ? $consolidator_clients[$client['Consolidator']]['Internal'] + number_format($client['DuePayment']/100,2,'.','') : number_format($client['DuePayment']/100,2,'.','');
				}
				else if (in_array($client['Office'], array( 'GBS', 'RJ5', 'SO', 'SixEleven' )))
				{
					$client['DuePayment'] = ($client['DI']*0.1);
					
					$consolidator_clients[$client['Consolidator']]['Clients']['External'][] = $client;
					
					$consolidator_clients[$client['Consolidator']]['External'] = (isset($consolidator_clients[$client['Consolidator']]['External'])) ? $consolidator_clients[$client['Consolidator']]['External'] + number_format($client['DuePayment']/100,2,'.','') : number_format($client['DuePayment']/100,2,'.','');
				}
				else
				{
					$client['DuePayment'] = 0;
					
					print_r($client);
				}
				
			}
		
			
			$consolidator_clients[$client['Consolidator']]['TotalDue'] = (isset($consolidator_clients[$client['Consolidator']]['TotalDue'])) ? $consolidator_clients[$client['Consolidator']]['TotalDue'] + number_format($client['DuePayment']/100,2,'.','') : number_format($client['DuePayment']/100,2,'.','');
			
			
			//$consolidator_clients[$client['Consolidator']][] = $client;
			
		}
		
		
		
		
		return array(
			'valids'   => $consolidator_clients,
			'invalids' => $invalid_clients,
			'all-clients' => $client_list,
		);


	}
	
	
	
	
	
	
	
	
	public static function get_referral_count($center=null, $start_date=null, $end_date=null, $cache=null)
	{
	
		if (!is_null($center))
		{
			if ($center == "INTERNAL")
			{
				$center_query = "AND DI_REF.short_code IN ('GAB','GBS')";
			}
			else if ($center == "GAB")
			{
				$center_query = "AND DI_REF.short_code IN ('GAB','1TICK')";
			}
			else if ($center == "GBS")
			{
				$center_query = "AND DI_REF.short_code IN ('GBS','1TICK-GBS')";
			}
			else
			{
				$center_query = "AND DI_REF.short_code = '".$center."'";
			}
		}
		else
		{
			$center_query = "";
		}
	
	
		$date_where = (!is_null($start_date) AND !is_null($end_date)) 
			? "(
				(CLD.DateCreated >= CONVERT(datetime, '". $start_date ."', 105) AND CLD.DateCreated <= CONVERT(datetime, '". $end_date ."', 105)+1)
				OR
				(CC.LastContactAttempt >= CONVERT(datetime, '". $start_date ."', 105) AND CC.LastContactAttempt <= CONVERT(datetime, '". $end_date ."', 105)+1)
			) "
			: "(CLD.DateCreated >= DATEADD(day, DATEDIFF(day, 0, GetDate()), 0) OR CC.LastContactAttempt >= DATEADD(day, DATEDIFF(day, 0, GetDate()), 0))";
			
		
		if (!is_null($cache))
		{
			$data_cache = $cache;
		}
		else
		{
			$data_cache = (!is_null($start_date) AND !is_null($end_date)) ? 60 : 60;
		}
			
		$results1 = \DB::query("SELECT CLD.ClientID
		  ,CLD.LeadRef AS 'Dialler Lead ID'
	      ,(CD.Forename + ' ' + CD.Surname) AS Name
	      ,LSO.[Description] AS 'Lead Source'
	      ,CLD.LeadRef2 AS Office
	      ,D_U.Undersigned AS 'Telesales Agent',
	      (
	        SELECT Top (1)
	          Undersigned
	        FROM
	          Debtsolv.dbo.Users AS D_URS
	        LEFT JOIN
	          Debtsolv.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
	        WHERE
	          D_CLD.LeadPoolReference = CLD.ClientID
	      ) AS 'Consolidator'
	      ,TCR.[Description]
	      ,CASE
	         WHEN D_CPD.InitialAgreedAmount > 0 AND CC.ContactResult = 1500
	            THEN 'DR'
	         WHEN (D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500
	            THEN 'PPI'
	         ELSE
	           ''
	         END AS Product
	      ,D_CPD.InitialAgreedAmount / 100 AS DI,
	      (
	      	SELECT Top (1)
	      		ResponseText
	      	FROM
	      		Debtsolv.dbo.Client_CustomQuestionResponses
	      	WHERE
	      		QuestionID = 1
	      		AND ClientID = D_CLD.Client_ID
	      ) AS 'Delivery'
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
	  LEFT JOIN
	  	Dialler.dbo.referrals AS DI_REF ON CLD.ClientID = DI_REF.leadpool_id
	  WHERE
	    ".$date_where."
		AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500)
		AND TCR.Description <> 'Referred'
	    ".$center_query."
	    AND ISNULL(DI_REF.product,'DR') = 'DR'
	  ORDER BY
		CLD.LeadRef2
	    ,TCR.[Description]
	    ,Product
	    ,CLD.DateCreated DESC")->cached($data_cache)->execute(static::$_connection);
	    
	    
	    $results2 = \DB::query("SELECT CLD.ClientID
		  ,CLD.LeadRef AS 'Dialler Lead ID'
	      ,(CD.Forename + ' ' + CD.Surname) AS Name
	      ,LSO.[Description] AS 'Lead Source'
	      ,CLD.LeadRef2 AS Office
	      ,D_U.Undersigned AS 'Telesales Agent',
	      (
	        SELECT Top (1)
	          Undersigned
	        FROM
	          BS_Debtsolv_DM.dbo.Users AS D_URS
	        LEFT JOIN
	          BS_Debtsolv_DM.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
	        WHERE
	          D_CLD.LeadPoolReference = CLD.ClientID
	      ) AS 'Consolidator'
	      ,TCR.[Description]
	      ,CASE
	         WHEN D_CPD.InitialAgreedAmount > 0 AND CC.ContactResult = 1500
	            THEN 'DR'
	         WHEN (D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500
	            THEN 'PPI'
	         ELSE
	           ''
	         END AS Product
	      ,D_CPD.InitialAgreedAmount / 100 AS DI,
	      (
	      	SELECT Top (1)
	      		ResponseText
	      	FROM
	      		BS_Debtsolv_DM.dbo.Client_CustomQuestionResponses
	      	WHERE
	      		QuestionID = 1
	      		AND ClientID = D_CLD.Client_ID
	      ) AS 'Delivery',
	      (
	      	SELECT Top (1)
	      		ResponseText
	      	FROM
	      		BS_Debtsolv_DM.dbo.Client_CustomQuestionResponses
	      	WHERE
	      		QuestionID = 10007
	      		AND ClientID = D_CLD.Client_ID
	      ) AS 'MyProduct'
	      ,CONVERT(varchar, CLD.DateCreated, 105) AS 'Referred Date'
	      ,CONVERT(varchar, CC.LastContactAttempt, 120) AS 'Last Contact Date'
	      ,CASE
	         WHEN CC.ContactResult = 700
	           THEN CONVERT(varchar, CC.Appointment, 120)
	         ELSE
	           ''
	       END AS 'Call Back Date'
	  FROM
	    BS_LeadPool_DM.dbo.Client_LeadDetails AS CLD
	  LEFT JOIN
	    BS_LeadPool_DM.dbo.Client_Details AS CD ON CLD.ClientID = CD.ClientID
	  LEFT JOIN
	    BS_LeadPool_DM.dbo.Campaign_Contacts AS CC ON CLD.ClientID = CC.ClientID
	  LEFT JOIN
	    BS_LeadPool_DM.dbo.Type_ContactResult AS TCR ON CC.ContactResult = TCR.ID
	  LEFT JOIN
		BS_LeadPool_DM.dbo.LeadBatch AS LBA ON CLD.LeadBatchID = LBA.ID
	  LEFT JOIN
		BS_LeadPool_DM.dbo.Type_Lead_Source AS LSO ON LBA.LeadSourceID = LSO.ID
	  LEFT JOIN
	    BS_Debtsolv_DM.dbo.Client_LeadData AS D_CLD ON CLD.ClientID = D_CLD.LeadPoolReference
	  LEFT JOIN
	    BS_Debtsolv_DM.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
	  LEFT JOIN
	    BS_Debtsolv_DM.dbo.Client_PaymentData AS D_CPD ON D_CLD.Client_ID = D_CPD.ClientID
	  LEFT JOIN
	  	Dialler.dbo.referrals AS DI_REF ON CLD.ClientID = DI_REF.leadpool_id
	  WHERE
	    ".$date_where."
		AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500)
		AND TCR.Description <> 'Referred'
	    ".$center_query."
	    AND ISNULL(DI_REF.product,'DR') = 'DR'
	  ORDER BY
		CLD.LeadRef2
	    ,TCR.[Description]
	    ,Product
	    ,CLD.DateCreated DESC")->cached($data_cache)->execute(static::$_connection);
	    
	    $results = array();
	    
	    foreach ($results1 AS $rsult)
	    {
		    $results[] = $rsult;
	    }
	    
	    foreach ($results2 AS $rsult)
	    {
		    $results[] = $rsult;
	    }
	    
	    
	    
	    $return_array = array(
	    	'referrals' => 0,
	    	'pack_outs' => 0,
	    	'pack_outs_value' => 0,
	    );
	    
	    
	    if (!is_null($start_date) AND !is_null($end_date))
	    {
	    	$return_array = array(
	    		'referrals' => 0,
	    		'pack_outs' => 0,
	    		'pack_outs_value' => 0,
	    	);
		    foreach ($results AS $result)
		    {
			    if ($result['Description']=='Lead Completed' AND (int)$result['DI'] > 10)
			    {
			    	$return_array['pack_outs']++;
			    	$return_array['pack_outs_value'] = $return_array['pack_outs_value'] + $result['DI'];
			    }
			    
			    if ((int)$result['MyProduct'] <> 2)
			    {
    			    $return_array['referrals']++;
			    }
			    
			   
		    }
	    }
	    else
	    {
	    	$return_array = array(
		    	'referrals' => 0,
		    	'pack_outs' => 0,
		    	'pack_outs_value' => 0,
		    	'pack_outs_previous' => 0,
		    	'pack_outs_previous_value' => 0,
		    );
		    foreach ($results AS $result)
		    {
			    if ($result['Description']=='Lead Completed')
			    {
			    	if ($result['Referred Date'] == date("d-m-Y"))
			    	{
				    	$return_array['pack_outs']++;
				    	$return_array['pack_outs_value'] = $return_array['pack_outs_value'] + $result['DI'];
				    }
				    else
				    {
					    $return_array['pack_outs_previous']++;
				    	$return_array['pack_outs_previous_value'] = $return_array['pack_outs_value'] + $result['DI'];
				    }
			    }
			    
			    if ($result['Referred Date'] == date("d-m-Y"))
			    {
			    	$return_array['referrals']++;
			    }
		    }
	    }
	    
	    
	    
	    return $return_array;
	    
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
				, PD.InitialAgreedAmount/100 AS DI
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
			LEFT JOIN
				DebtSolv.dbo.Client_PaymentData AS PD ON PA.ClientID = PD.ClientID
			WHERE
				LSO.Reference IN ('".$client_ids."')
				AND PA.AmountIn > 0
			GROUP BY PA.ClientID, CD.Forename, CD.Surname, CLD.LeadPoolReference, LSO.Description, LSO.Reference, PD.InitialAgreedAmount;")->cached(900)->execute(static::$_connection);
		
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
	      LSO.[Reference] IN ('".$list_ids."')
		AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500)
	  ORDER BY
		CLD.LeadRef2
	    ,TCR.[Description]
	    ,Product
	    ,CLD.DateCreated DESC")->cached(900)->execute(static::$_connection);
		
		
		
		
		return $results;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// Save To Debtsolv functions go down here!
	
	
	
	
	
	
	
	
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