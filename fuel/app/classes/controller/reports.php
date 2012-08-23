<?php

class Controller_Reports extends Controller_BaseHybrid
{


	public function action_best_solutions()
	{
		
		if (Auth::has_access('reports.best_solutions'))
		{
			
			$client_list = GAB\Debtsolv::get_best_solutions_disposition_report()->as_array();
			
			$pack_in_clients = array();
			$packs_in = array();
			foreach ($client_list AS $single_result)
			{
				if ($single_result['Pack In Date'] != 'Dec 30 1899 12:00:00:000AM')
				{
					$pack_ins[] = $single_result;
					
					$total_values['pack_in'] = (isset($total_values['pack_in'])) ? $total_values['pack_in']+$single_result['DI'] : $single_result['DI'];
					
					$pack_in_clients[$single_result['ID']] = $single_result['Pack In Date'];
				}
			}
			
			
			
			$payments = GAB\Debtsolv::get_best_solutions_paid_in_report($pack_in_clients)->as_array();
						
			foreach ($payments AS $payment)
			{
				$total_values['payments'] = (isset($total_values['payments'])) ? $total_values['payments']+$payment['Total Payed'] : $payment['Total Payed'];
			}
			
			
			$client_list_headings = Array();
			$exclude_headings = Array('Pack In Date', 'DatePackSent', 'status');
			if (count($client_list) > 0) {
				$col1 = reset($client_list);
				foreach($col1 AS $column_head => $column_text) {
					if ( !in_array($column_head, $exclude_headings) )
					{
						$client_list_headings[] = $column_head;
					}
				}
			}
			
			$pack_in_headings = Array();
			$exclude_headings = Array('DatePackSent');
			if (count($pack_ins) > 0) {
				$col1 = reset($pack_ins);
				foreach($col1 AS $column_head => $column_text) {
					if ( !in_array($column_head, $exclude_headings) )
					{
						$pack_in_headings[] = $column_head;
					}
				}
			}
			
			$payment_headings = Array();
			$exclude_headings = Array();
			if (count($payments) > 0) {
				$col1 = reset($payments);
				foreach($col1 AS $column_head => $column_text) {
					if ( !in_array($column_head, $exclude_headings) )
					{
						$payment_headings[] = $column_head;
					}
				}
			}
			
			
			$this->template->title = 'Best Solution Report &raquo; ';
			$this->template->content = View::forge('reports/best_solutions', array(
				'all_clients' => array('headings' => $client_list_headings, 'data' => $client_list),
				'pack_ins' => array('headings' => $pack_in_headings, 'data' => $pack_ins),
				'payments' => array('headings' => $payment_headings, 'data' => $payments),
				'total_values' => $total_values,
				'list_title' => 'Best Solutions'
			));
			
		}
		else
		{
			Session::set_flash('fail', 'You do not have access to that section: This has been logged!');
			Response::redirect('/');
		}
		
	}


	public function action_supplier_payouts($campaign_id)
	{
		if (Auth::has_access('reports.supplier'))
		{
		
			$campaign = Model_Data_Supplier_Campaign::find($campaign_id);
					
			$campaign_title = $campaign->title;
			
			$all_lists = array();
			
			foreach($campaign->data_supplier_campaign_lists AS $list)
			{
				$list_data[$list->database_server_id][] = $list->list_id;
				$all_lists[] = $list->list_id;
			}
		
			$payments = GAB\Debtsolv::get_all_paid_in_report($all_lists)->as_array();
			
			$payments_due = array();
			
			$client_array = array();
			foreach ($payments AS $single_payment)
			{
				if (!isset($client_array[$single_payment['ClientID']]))
				{
					$client_array[$single_payment['ClientID']]['DI'] = $single_payment['DI'];
					$client_array[$single_payment['ClientID']]['TotalPayments'] = 0;
					$client_array[$single_payment['ClientID']]['TotalIncome'] = 0;
				}
				
				$client_array[$single_payment['ClientID']]['TotalIncome'] = $client_array[$single_payment['ClientID']]['TotalIncome'] + $single_payment['Payment'];
				$client_array[$single_payment['ClientID']]['TotalPayments']++;
				$client_array[$single_payment['ClientID']]['PaymentLog'][] = $single_payment;
			}
			
			
			// Check for DI Hits
			foreach ($client_array AS $client)
			{
				$DI = $client['DI'];
				if ($client['TotalIncome'] > $DI) {
					
					$firstPaymentMonth = "";
					$secondPaymentMonth = "";
					$runningTotal = 0;
					$calculationFirstHit = FALSE;
					$calculationSecondHit = FALSE;
					foreach ($client['PaymentLog'] AS $payment)
					{
						list($d,$m,$y) = explode('-', $payment['payDay']);
						
						$m = ((int)$d == 20) ? (int)$m+1 : $m;
						
						$y = ((int)$m >= 13) ? (int)$y+1 : $y;
						$m = ((int)$m >= 13) ? 0 + ((int)$m-12) : $m;
												
						$thisDate = mktime(0, 0, 0, $m, $d, $y);
						
					
						$runningTotal = $runningTotal + $payment['Payment'];
						if ($runningTotal >= $DI && !$calculationFirstHit)
						{			
							$firstPaymentMonth = date("F Y", $thisDate);
							$calculationFirstHit = TRUE;
						} 
						else if ($runningTotal >= ($DI*2) && !$calculationSecondHit) 
						{
							$secondPaymentMonth = date("F Y", $thisDate);
							$calculationSecondHit = TRUE;
						}
					}
					
					if ($calculationFirstHit)
					{
						$payments_due[$firstPaymentMonth]['payments'] = (isset($payments_due[$firstPaymentMonth]['payments'])) ? $payments_due[$firstPaymentMonth]['payments'] + ($DI*0.75) : ($DI*0.75);
						$payments_due[$firstPaymentMonth]['totalpayments'] = (isset($payments_due[$firstPaymentMonth]['totalpayments'])) ? $payments_due[$firstPaymentMonth]['totalpayments'] + 1 : 1;
					}
					
					if ($calculationSecondHit)
					{
						$payments_due[$secondPaymentMonth]['totalpayments'] = (isset($payments_due[$secondPaymentMonth]['totalpayments'])) ? $payments_due[$secondPaymentMonth]['totalpayments'] + 1 : 1;
						$payments_due[$secondPaymentMonth]['payments'] = (isset($payments_due[$secondPaymentMonth]['payments'])) ? $payments_due[$secondPaymentMonth]['payments'] + ($DI*0.5) : ($DI*0.5);
					}
				}
			}
			
			$paymentReturn = array();
			$totalPayments = 0;
			foreach ($payments_due AS $key => $PD)
			{
				$paymentReturn[] = array(
					$key,
					$PD['totalpayments'],
					"&pound;".number_format(($PD['payments']/100),2),
					"NO"
				);
				$totalPayments = $totalPayments + $PD['payments'];
			}
						
			$this->response(array(
					"aaData" => $paymentReturn,
					"totalPayments" => "&pound;".number_format(($totalPayments/100),2),
					"aoColumns" => array(
						array(
							"bSortable" => false,
						),
						array(
							"sTitle"    => "Client Payments Received",
							"sType"		=> "string",
							"bSortable" => false,
						),
						array(
							"sTitle"    => "Payouts Due",
							"sType"		=> "string",
							"bSortable" => false,
						),
						array(
							"sTitle"    => "Supplier Paid",
							"sType"		=> "string",
							"bSortable" => false,
						),
					)
				));
				
			} 
			else 
			{
				$this->response(array(
					"error" => "You are not authorised to view this content!"
				));
			}
		
	}

	public function action_supplier($campaign_id=null)
	{
		if (Auth::has_access('reports.supplier'))
		{
			// Start Auth If
			
			
			
			if (is_null($campaign_id) && is_null($this->param('listid')) ) {
			
				$data['data_supplier_campaigns'] = Model_Data_Supplier_Campaign::find('all');
				$this->template->title = "Data_supplier_campaigns";
				$this->template->content = View::forge('data/supplier/campaign/index', $data);
			
			}
			else
			{
				
				
				
				
					
					$list_data = array();
					$campaign_title = null;
					$column_headings = null;
					$stats = null;
					
					
					
					if (!is_null($this->param('listid'))) {
						
						$list_data = array(
							'1'=>array(((int)$this->param('listid'))),
							'2'=>array(((int)$this->param('listid'))+30000),
							'3'=>array(((int)$this->param('listid'))+50000),
						);
						
						
					
						$all_lists = array($list_data[1][0],$list_data[2][0],$list_data[3][0]);
											
						$stats = GAB\Dialler::full_list(
							$list_data
						);
					}  else {
						
						
						$campaign = Model_Data_Supplier_Campaign::find($campaign_id);
					
						$campaign_title = $campaign->title;
						
						$all_lists = array();
						
						foreach($campaign->data_supplier_campaign_lists AS $list)
						{
							$list_data[$list->database_server_id][] = $list->list_id;
							$all_lists[] = $list->list_id;
						}
						
						$stats = GAB\Dialler::list_stats(
							$list_data
						);
							
	
					}
				
					
					
					if (is_null($all_lists)) {
						Session::set_flash('fail', 'We currently have no data for that campaign!');
					} else {
							
						$list_dispositions = GAB\Debtsolv::get_dialler_list_disposition_report($all_lists)->as_array();
						
						
						
						// Split Disposition list into referrals and pack outs
						
						$pack_outs = array();
						$pack_ins = array();
						$referrals = array();
						$total_values = array('pack_outs' => 0,
											  'pack_ins' => 0,
											  'payments' => 0);
						$pack_out_clients = array();
						
						foreach ($list_dispositions AS $single_result)
						{
							if ($single_result['Description'] == "Lead Completed")
							{
								$pack_outs[] = $single_result;
								$total_values['pack_outs'] = (isset($total_values['pack_outs'])) ? $total_values['pack_outs']+$single_result['DI'] : $single_result['DI'];
								
								if ($single_result['Pack In Date'] != '30-12-1899')
								{
									$pack_ins[] = $single_result;
									$pack_out_clients[] = $single_result['ClientID'];
									$total_values['pack_ins'] = (isset($total_values['pack_ins'])) ? $total_values['pack_ins']+$single_result['DI'] : $single_result['DI'];
								}
								
							}
							
							$referrals[] = $single_result;
						}
						
						$payments = GAB\Debtsolv::get_paid_in_report($all_lists)->as_array();
						
						foreach ($payments AS $payment)
						{
							$total_values['payments'] = (isset($total_values['payments'])) ? $total_values['payments']+$payment['Total Payments'] : $payment['Total Payments'];
						}
						
						$column_headings = Array();
						if (count($stats) > 0) {
							$col1 = reset($stats);
							foreach($col1 AS $column_head => $column_text) {
								$column_headings[] = $column_head;
							}
						}
						

						
						$referrals_headings = Array();
						$exclude_headings = Array('Pack In Date', 'DI', 'Product');
						if (count($referrals) > 0) {
							$col1 = reset($referrals);
							foreach($col1 AS $column_head => $column_text) {
								if ( !in_array($column_head, $exclude_headings) )
								{
									$referrals_headings[] = $column_head;
								}
							}
						}
						
						$pack_outs_headings = Array();
						$exclude_headings = Array('Pack In Date', 'Referred Date', 'Call Back Date');
						if (count($pack_outs) > 0) {
							$col1 = reset($pack_outs);
							foreach($col1 AS $column_head => $column_text) {
								if ( !in_array($column_head, $exclude_headings) )
								{
									$pack_outs_headings[] = $column_head;
								}
							}
						}
						
						$pack_ins_headings = Array();
						$exclude_headings = Array('Description', 'Referred Date','Last Contact Date', 'Call Back Date');
						if (count($pack_ins) > 0) {
							$col1 = reset($pack_ins);
							foreach($col1 AS $column_head => $column_text) {
								if ( !in_array($column_head, $exclude_headings) )
								{
									$pack_ins_headings[] = $column_head;
								}
							}
						}
						
						
						
						$payment_headings = Array();
						$exclude_headings = Array('Reference');
						if (count($payments) > 0) {
							$col1 = reset($payments);
							foreach($col1 AS $column_head => $column_text) {
								if ( !in_array($column_head, $exclude_headings) )
								{
									$payment_headings[] = $column_head;
								}
							}
						}
		
						
					}
										
					$this->template->title = 'Reports &raquo; ';
					$this->template->content = View::forge('reports/supplier', array('campaign_id' => $campaign_id, 'total_values' => $total_values, 'payment_headings' => $payment_headings, 'payments' => $payments, 'pack_in_headings' => $pack_ins_headings, 'pack_ins' => $pack_ins, 'pack_out_headings' => $pack_outs_headings, 'pack_outs' => $pack_outs, 'list_dispositions_headings' => $referrals_headings, 'list_dispositions' => $referrals, 'list_title'=>$campaign_title, 'list_stats_headings'=>$column_headings, 'list_stats'=>$stats));
				

			// End Given Choices If
			}
		// End Auth If
		}
		else
		{
			Session::set_flash('fail', 'You do not have access to that section: This has been logged!');
			Response::redirect('/');
		}
	}
	
	
	
	/**
	 * Disposition Report.
	 * 
	 * @access public
	 * @return void
	 */
	public function action_disposition()
	{	
		
		if (Auth::has_access('reports.disposition'))
		{
			
			if (Auth::has_access('reports.all_centers')) {
				$center = $this->param('center');
				$view_all = TRUE;
			} else {
				$view_all = FALSE;
				list($driver, $user_id) = Auth::get_user_id();
				$this_user = Model_User::find($user_id);
				
				$call_center = Model_Call_Center::find($this_user->call_center_id);
				
				if (is_null($call_center->shortcode)) {
					Session::set_flash('fail', 'You do not have access to that section: This has been logged!');
			
					Response::redirect('/');
				} else {
					$center = $call_center->shortcode;
				}
				
			}
			
			$all_call_centers = Model_Call_Center::find('all');
			
			$start_date = $this->param('startdate');
			$end_date = $this->param('enddate');
			
			if (!is_null($start_date) && is_null($end_date) ) {
				$end_date = $start_date;
			}
			
			if (!is_null($start_date) && !is_null($end_date)) {
				$disposition_duration = "
				(
				(CLD.DateCreated >= CONVERT(datetime, '". $start_date ."', 105) AND CLD.DateCreated <= CONVERT(datetime, '". $end_date ."', 105)+1)
				OR
				(CC.LastContactAttempt >= CONVERT(datetime, '". $start_date ."', 105) AND CC.LastContactAttempt <= CONVERT(datetime, '". $end_date ."', 105)+1)
				) ";
			} else {
				$disposition_duration = "(CLD.DateCreated >= DATEADD(day, DATEDIFF(day, 0, GetDate()), 0) OR CC.LastContactAttempt >= DATEADD(day, DATEDIFF(day, 0, GetDate()), 0)) ";
			}
			
			$call_center_choice = (!is_null($center)) ? "AND CLD.LeadRef2 = '".$center."'" : "";
			
			$results = DB::query("SELECT CLD.ClientID
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
	  WHERE
	    ". $disposition_duration ."
		AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500)
		AND TCR.Description <> 'Referred'
	    ". $call_center_choice ."
	  ORDER BY
		CLD.LeadRef2
	    ,TCR.[Description]
	    ,Product
	    ,CLD.DateCreated DESC")->cached(900)->execute('debtsolv');
			
			$column_headings = Array();
			
			$return_results = $results->as_array();
			
			// Generate charts
			$pie_dispositions = array();
			$pie_lead_source = array();
			$pie_consolidator = array();
			$pie_telesales = array();
			foreach ($return_results AS $result) {
			
				$description = $result['Description'];
				if ($description == "Lead Completed") {
					if ($result['Product'] == "DR") {
						$description .= " - DR";
					} else {
						$description .= " - PPI";
					}
				}
				
				$lead_source = $result['Lead Source'];
				$consolidator = $result['Consolidator'];
				$telesales = $result['Telesales Agent'];
				
				$pie_dispositions[$description] = (isset($pie_dispositions[$description])) ? $pie_dispositions[$description]+1 : 1;
				$pie_lead_source[$lead_source] = (isset($pie_lead_source[$lead_source])) ? $pie_lead_source[$lead_source]+1 : 1;
				
				if ($consolidator != "") 
					$pie_consolidator[$consolidator] = (isset($pie_consolidator[$consolidator])) ? $pie_consolidator[$consolidator]+1 : 1;
					
				if ($telesales != "") 
					$pie_telesales[$telesales] = (isset($pie_telesales[$telesales])) ? $pie_telesales[$telesales]+1 : 1;
	
				
			}
			
					
			
			
			if (count($return_results) > 0) {
				foreach($return_results[0] AS $column_head => $column_text) {
					$column_headings[] = $column_head;
				}
			}
			
			$this->template->title = 'Reports &raquo; Disposition';
			$this->template->content = View::forge('reports/disposition', array('all_call_centers' => $all_call_centers, 'view_all' => $view_all, 'pie_telesales' => $pie_telesales, 'pie_consolidators' => $pie_consolidator, 'pie_lead_sources' => $pie_lead_source, 'pie_dispositions' => $pie_dispositions, 'query_columns' => $column_headings, 'query_results' => $return_results, 'start_date' => $this->param('startdate'), 'end_date' => $this->param('enddate'), 'center' => $this->param('center')));
			
		} else {
			
			Session::set_flash('fail', 'You do not have access to that section: This has been logged!');
			
			Response::redirect('/');
			
		}
		
	}

}
