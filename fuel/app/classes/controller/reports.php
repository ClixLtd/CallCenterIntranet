<?php

class Controller_Reports extends Controller_BaseHybrid
{

	public function action_dialler_test()
	{
		print count(Goautodial\Live::closers());
	}
	
	
	
	public static function generate_telesales_report()
	{
	   
	    $startDate = strtotime("1st day of this month");
	    $endDate = strtotime("Today");
	   
	    // Get a list of debtsolv_id names for active users
	    $staff = Model_Staff::query()->where('active', 1);
	    $totalStaff = $staff->count();
	    $staff = $staff->get();
	    
	    // Convert the active users into a list ready for the "IN" query
	    $inList = "";
	    $inListCount = 0;
	    foreach ($staff AS $member)
	    {
	        $inListCount++;
    	    $inList .= "'" . $member->dialler_id . "'";
    	    
    	    if ($inListCount < $totalStaff)
    	    {
        	    $inList .= ",";
    	    }
	    }
    	
    	// Select all the required details from Debtsolv.
    	$reportQuery = "SELECT  DR.leadpool_id
                              , DR.short_code
                              , DR.user_login
                              , TCR.[Description]
                              , DR.referral_date
                          FROM Dialler.dbo.referrals AS DR
                          LEFT JOIN LeadPool_DM.dbo.Client_LeadDetails AS CLD ON DR.leadpool_id=CLD.ClientID
                          LEFT JOIN LeadPool_DM.dbo.Campaign_Contacts AS CC ON CLD.ClientID = CC.ClientID
                          LEFT JOIN LeadPool_DM.dbo.Type_ContactResult AS TCR ON CC.ContactResult = TCR.ID
                          WHERE DR.user_login IN (" . $inList . ")
                              AND CONVERT(date, DR.referral_date, 105) >= '" . date('Y-m-d', $startDate) . "'
                              AND CONVERT(date, DR.referral_date, 105) <= '" . date('Y-m-d', $endDate) . "'";
    	
    	
    	// Find all the paid clients for this date range
    	$paymentsQuery = "SELECT  D_CD.ClientID
                                , D_CD.FirstPaymentDate
                                , D_CPD.NormalExpectedPayment AS DI
                                , D_CLD.LeadPoolReference AS LeadpoolID
                                , D_R.user_login
                          FROM [Dialler].[dbo].[client_dates] AS D_CD
                          LEFT JOIN Debtsolv.dbo.Client_PaymentData AS D_CPD ON D_CD.ClientID = D_CPD.ClientID
                          LEFT JOIN Debtsolv.dbo.Client_LeadData AS D_CLD ON D_CD.ClientID = D_CLD.Client_ID
                          LEFT JOIN Dialler.dbo.referrals AS D_R ON D_CLD.LeadPoolReference = D_R.leadpool_id
                          WHERE D_R.user_login IN (" . $inList . ")
                              AND CONVERT(date, D_CD.FirstPaymentDate, 105) >= '" . date('Y-m-d', $startDate) . "'
                              AND CONVERT(date, D_CD.FirstPaymentDate, 105) <= '" . date('Y-m-d', $endDate) . "'";
    	
    	
    	// Loop through the results and create the report
    	$reportResults = DB::query($reportQuery)->cached(60)->execute('debtsolv');
    	$paymentsResults = DB::query($paymentsQuery)->cached(60)->execute('debtsolv');
    	
    	$reportArray = array();
    	foreach ($reportResults AS $result)
    	{
    	    if ( isset($reportArray[$result['user_login']]) )
    	    {
        	    $reportArray[$result['user_login']]['referrals']++;
        	    $reportArray[$result['user_login']]['packOuts'] = ($result['Description'] == "Lead Completed") ? $reportArray[$result['user_login']]['packOuts']+1 : $reportArray[$result['user_login']]['packOuts'];
    	    }
    	    else
    	    {
                $singleResult = array(
                    'referrals' => 1,
                    'packOuts' => ($result['Description'] == "Lead Completed") ? 1 : 0,
                );
                
                $reportArray[$result['user_login']] = $singleResult;
    	    }

    	}
    	
    	
    	// Work out points, conversion rate and P/O bonus
    	
    	foreach ($reportArray AS $key=>$items)
    	{
        	$reportArray[$key]['conversionRate'] = (($items['packOuts'] / $items['referrals']) * 100);
        	$reportArray[$key]['points'] = ($items['packOuts'] * 2) + ($items['referrals']);
        	
        	$reportArray[$key]['commission'] = ($items['packOuts'] * 2.5);
    	}
    	
    	// Finally look through the first payments and create the comissions
    	$paymentArray = array();
    	foreach ($paymentsResults AS $payment)
    	{
    	
    	    $reportArray[$payment['user_login']]['commission'] = (isset($reportArray[$payment['user_login']]['commission'])) ? $reportArray[$payment['user_login']]['commission'] + ($payment['DI']/1000) : ($payment['DI']/1000);
    	
    	}
    	
    	
    	// Last but not least. Create a nice array to return
    	$sendArray = array();
    	foreach ($staff AS $member)
    	{
    	    $sendArray[] = array(
    	       'name'           => $member->first_name . " " . $member->last_name,
    	       'referrals'      => isset($reportArray[$member->dialler_id]['referrals']) ? $reportArray[$member->dialler_id]['referrals'] : 0,
    	       'packouts'       => isset($reportArray[$member->dialler_id]['packOuts']) ? $reportArray[$member->dialler_id]['packOuts'] : 0,
    	       'conversionrate' => isset($reportArray[$member->dialler_id]['conversionRate']) ? $reportArray[$member->dialler_id]['conversionRate'] : 0,
    	       'points'         => isset($reportArray[$member->dialler_id]['points']) ? $reportArray[$member->dialler_id]['points'] : 0,
    	       'commission'     => isset($reportArray[$member->dialler_id]['commission']) ? number_format($reportArray[$member->dialler_id]['commission'], 2) : 0.00,
    	    );
    	}
    	
    	return $sendArray;
    	    	
	}
	
	
	public static function action_telesales_report()
	{
    	
    	$reportArray = Controller_Reports::generate_telesales_report();
    	
    	print_r($reportArray);
    	
	}
	
	
	
	public static function generate_league_table()
	{
		
		$league_table_query = "SELECT
		     [leadpool_id]
		    ,ISNULL(CASE
		       WHEN [user_login] <> ''
		       THEN [user_login]
		       ELSE D_U.ShortName COLLATE SQL_Latin1_General_CP1_CI_AS
		     END,'NONE') AS [user_login]
		    ,ISNULL(CASE
			   WHEN [full_name] <> ''
			   THEN [full_name]
			   ELSE D_U.Undersigned COLLATE SQL_Latin1_General_CP1_CI_AS
			 END,'NONE') AS [full_name]
		    ,CASE 
		       WHEN TCR.[Description] = 'Lead Completed'
		       THEN 'YES'
		       ELSE 'NO'
		     END AS pack_out
		  FROM 
			[Dialler].[dbo].[referrals] AS Ref
		  LEFT JOIN
		    LeadPool_DM.dbo.Campaign_Contacts AS CC ON Ref.leadpool_id = CC.ClientID
		  LEFT JOIN
			LeadPool_DM.dbo.Type_ContactResult AS TCR ON CC.ContactResult = TCR.ID
		  LEFT JOIN
		    Debtsolv.dbo.Client_LeadData AS D_CLD ON Ref.leadpool_id = D_CLD.LeadPoolReference
		  LEFT JOIN
			Debtsolv.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
		  WHERE
			[product] = 'DR'
			AND short_code = 'GAB'
			AND referral_date >= CONVERT(datetime, '01-10-2012', 105)
		ORDER BY
			referral_date";
			
		
		$league_table_results = DB::query($league_table_query)->cached(3600)->execute('debtsolv');
		
		$return_results = array();
		foreach ($league_table_results AS $league_table_results_single)
		{
			if (isset($return_results[$league_table_results_single['full_name']]['referrals']))
			{
				$return_results[$league_table_results_single['full_name']]['referrals']++;
			}
			else
			{
				$return_results[$league_table_results_single['full_name']]['referrals'] = 1;
			}
			
			if ($league_table_results_single['pack_out'] == 'YES')
			{
				if (isset($return_results[$league_table_results_single['full_name']]['pack_outs']))
				{
					$return_results[$league_table_results_single['full_name']]['pack_outs']++;
				}
				else
				{
					$return_results[$league_table_results_single['full_name']]['pack_outs'] = 1;
				}
			}
		}
		
		$full_stats = array();
		foreach ($return_results AS $name => $return_results_single)
		{
			$ratio = (isset($return_results_single['pack_outs'])) ? (($return_results_single['pack_outs']/$return_results_single['referrals'])*100) : 0;
			$pack_out_points = (isset($return_results_single['pack_outs'])) ? $return_results_single['pack_outs'] * 5 : 0;
			$productivity = 1;
			$productivity_points = $productivity * 10;
			$total_points = $pack_out_points + $productivity_points;
			
			$full_stats[] = array(
				$name,
				$return_results_single['referrals'],
				(isset($return_results_single['pack_outs'])) ? $return_results_single['pack_outs'] : 0,
				$ratio,
				$productivity,
				$pack_out_points,
				$productivity_points,
				$total_points
			);
		}
		
		
	
		foreach ($full_stats AS $key => $stat)
		{
			$points[$key] = $stat[7];
		}
		
		array_multisort($points, SORT_DESC, $full_stats);
		
		
		
		return $full_stats;
		
	}
	
	public function get_league_table()
	{
	
		
	
		$this->response(array(
			'result' => ($result['success']) ? 'success' : 'FAIL',
			'message' => $result['message'],
		));
	}
	
	public function action_league_table()
	{
		$league_table = Controller_Reports::generate_league_table();
		
		print_r($league_table);
	}
	
	
	
	
	public function action_seniors()
	{
		
		$external_suppliers = array(
			'SO',
			'rjhighfive',
			'sixEleven',
			'GBS',
		);
		
		$internal_suppliers = array(
			'GAB',
			'RESOLVE',
		);
		
		$comission   = array(
			'internal' => array(
				100       => 10,
			),
			'external' => array(
				25        => 5,
				40        => 10,
				100       => 15,
			),
		);
		
		$start_date = "";
		$end_date   = "";
		
		
		
		
		
		
		$this->template->title = 'Seniors Report &raquo; ';
		
		$this->template->content = View::forge('reports/best_solutions');
			
	}
	
	
	

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
			
			
			
			/*
			foreach ($payment_headings AS $head)
			{
				print $head.",";
			}
			print "\n";
			
			foreach ($payments AS $client)
			{
				foreach ($client AS $cl)
				{
					print $cl.",";
				}
				print "\n";
			}
			
			*/
			
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
			
			
			$firstPayments = array();
			$secondPayments = array();
			$date_list = array();
			// Check for DI Hits
			foreach ($client_array AS $client)
			{
			
				
				
				$DI = $client['DI'];
				if ($client['TotalIncome'] >= $DI) {
					
					
					$firstPaymentMonth = "";
					$secondPaymentMonth = "";
					$runningTotal = 0;
					$calculationFirstHit = FALSE;
					$calculationSecondHit = FALSE;
					foreach ($client['PaymentLog'] AS $payment)
					{
						list($d,$m,$y) = explode('-', $payment['payDay']);
						
						$m = ((int)$d >= 21) ? (int)$m+1 : $m;
						
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
						
						$firstPayments[$firstPaymentMonth][] = array(
							'ClientID' => $payment['ClientID'],
							'Reference' => $payment['Reference'],
							'ListName' => $payment['Lead Source'],
							'Name' => $payment['Name'],
							'DI' => $payment['DI'],
						);
						
						$date_list[] = $firstPaymentMonth;
						
					}
					
					if ($calculationSecondHit)
					{
						$payments_due[$secondPaymentMonth]['totalpayments'] = (isset($payments_due[$secondPaymentMonth]['totalpayments'])) ? $payments_due[$secondPaymentMonth]['totalpayments'] + 1 : 1;
						$payments_due[$secondPaymentMonth]['payments'] = (isset($payments_due[$secondPaymentMonth]['payments'])) ? $payments_due[$secondPaymentMonth]['payments'] + ($DI*0.5) : ($DI*0.5);
						$secondPayments[$secondPaymentMonth][] = array(
							'ClientID' => $payment['ClientID'],
							'Reference' => $payment['Reference'],
							'ListName' => $payment['Lead Source'],
							'Name' => $payment['Name'],
							'DI' => $payment['DI'],
						);
						
						$date_list[] = $secondPaymentMonth;
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
			
			$paymentDetailsMonthly = array(
				'first' => $firstPayments,
				'second' => $secondPayments,
			);
			
			$date_ls = array();
			foreach (array_unique($date_list) AS $date_l)
			{
				$date_ls[] = $date_l;
			}
			
			
			$this->response(array(
					"aaData" => $paymentReturn,
					"allClientsMonths" => $date_ls,
					"allClientsMonthly" => $paymentDetailsMonthly,
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



	public function list_reports($campaign_id, $action=FALSE)
	{
		
		
		
		
		if (!is_null($campaign_id))
		{
			
			
			if ($action)
			{
				$campaign = Model_Data_Supplier_Campaign::find($campaign_id);
				$all_lists = array();
				
				$all_results = array();							
				foreach($campaign->data_supplier_campaign_lists AS $list)
				{
					foreach (\GAB\Dialler::get_list_stats($list->list_id, $list->database_server_id, array('TPS','POSSDC')) AS $result)
					{
						$all_results[] = $result;
					}
				}
				
				return $all_results;
			}
			
			
			/*
			$this->response(array(
				"aaData" => (array)$stats,
				"sEcho" => 1,
				"iTotalRecords" => count((array)$stats),
				"iTotalDisplayRecords" => count((array)$stats),
				"oLanguage" => array(
					"sProcessing" => "Loading...",
				),
				"aoColumns" => array(
					array(
						"sTitle"    => "Name",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Status",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Address 1",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Address 2",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Address 3",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "City",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Postcode",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Main Number",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Alt Number",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "Called",
						"bSortable" => true,
					),
					array(
						"sTitle"    => "List ID",
						"bSortable" => true,
					),
				)
			));
			*/
		}
		else
		{
			$this->response(array(
            	'status' => 'FAIL',
            ));
		}
		
		
		
	}


	
	public function action_list_reports($campaign_id)
	{
	
		$full_details = Controller_Reports::list_reports($campaign_id, TRUE);
		
		$stats = array();
		
		foreach ($full_details AS $full)
		{
			$stats[] = '"'.implode($full,'","').'"';
		}
	
	
		$response = new Response(implode($stats,"\n"));
		$response->set_header('Content-Type', 'text/csv');
		$response->set_header('Content-Disposition', 'attachment; filename="full_stats_'.$campaign_id.'.csv"');
		$response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
		$response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
		$response->set_header('Pragma', 'no-cache');
	
		return $response;
	}	

	public function get_list_reports($campaign_id)
	{
		Controller_Reports::list_reports($campaign_id);
	}


	
	// Supplier Reporting
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
						
						ksort($list_data);
						
						$stats = GAB\Dialler::list_stats(
							$list_data
						);
						
						
						$conversions = GAB\Dialler::conversion_chart(
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
										
					$this->template->title = 'Supplier Reports &raquo; '.$campaign_title;
					$this->template->content = View::forge('reports/supplier', array('campaign_id' => $campaign_id, 'total_values' => $total_values, 'payment_headings' => $payment_headings, 'payments' => $payments, 'pack_in_headings' => $pack_ins_headings, 'pack_ins' => $pack_ins, 'pack_out_headings' => $pack_outs_headings, 'pack_outs' => $pack_outs, 'list_dispositions_headings' => $referrals_headings, 'list_dispositions' => $referrals, 'list_title'=>$campaign_title, 'list_stats_headings'=>$column_headings, 'list_stats'=>$stats, 'conversions'=>$conversions));
				

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
	
	
	
	
	
	
	public function get_change_resolve_office()
	{
	
		$result = \GAB\Debtsolv::change_center_resolve(
			$this->param('lead'), 
			$this->param('office')
		);
	
		$this->response(array(
			'result' => ($result['success']) ? 'success' : 'FAIL',
			'message' => $result['message'],
		));
	}
	
	
	
	public function get_change_office()
	{
	
		$result = \GAB\Debtsolv::change_center(
			$this->param('lead'), 
			$this->param('office')
		);
	
		$this->response(array(
			'result' => ($result['success']) ? 'success' : 'FAIL',
			'message' => $result['message'],
		));
	}
	
	
	
	
	
	
	public static function generate_disposition_report($center=null, $has_access=TRUE, $all_centers=TRUE, $start_date=null, $end_date=null, $include_no_contacts=FALSE)
	{
		
	
		// Check the logged in user is authorised to view the disposition report
		if ($has_access)
		{
		
			// Check if the user has access to all disposition reports or just their own center
			if ($all_centers) {
				$view_all = TRUE;
			} else {
				$view_all = FALSE;
				list($driver, $user_id) = Auth::get_user_id();
				$this_user = Model_User::find($user_id);
				
				$call_center = Model_Call_Center::find($this_user->call_center_id);
				
				if (is_null($call_center->shortcode)) {
					return(array(
		            	'status' => 'FAIL',
		            	'message' => 'You do not have access to the disposition report.',
		            ));
				} else {
					$center = $call_center->shortcode;
				}				
			}
			
			
			if (!is_null($center) || $view_all)
			{
				
				
				if (is_null($start_date))
				{
					$start_date = date("d-m-Y");
				}
				
				if (!is_null($start_date) && is_null($end_date) ) {
					$end_date = $start_date;
				}
				
				
				$cache_name = $center.$start_date.$end_date;
				
			
				$disposition_duration = "
				(
				(CLD.DateCreated >= CONVERT(datetime, '". $start_date ."', 105) AND CLD.DateCreated <= CONVERT(datetime, '". $end_date ."', 105)+1)
				OR
				(CC.LastContactAttempt >= CONVERT(datetime, '". $start_date ."', 105) AND CC.LastContactAttempt <= CONVERT(datetime, '". $end_date ."', 105)+1)
				) ";
				
				$pack_in_duration = "(D_CLD.DatePackReceived >= CONVERT(datetime, '". $start_date ."', 105) AND D_CLD.DatePackReceived <= CONVERT(datetime, '". $end_date ."', 105)) ";
				
				
				
				$call_center_choice = (!is_null($center)) ? "AND DI_REF.short_code = '".$center."'" : "";
				
				$results1 = DB::query("SELECT CLD.ClientID
				  ,CLD.LeadRef AS 'Dialler Lead ID'
			      ,(CD.Forename + ' ' + CD.Surname) AS Name
			      ,ISNULL(NULLIF(LSO.[Description],'<None>'), DSLSO.[Description]) AS 'Lead Source'
			      ,CASE WHEN
			      	ISNULL(DI_REF.short_code,'<None>') = '<None>'
			       THEN
			       	('<span id='''+CONVERT(varchar,CLD.ClientID)+''' class=''no-office''></span>')
			       ELSE
			       	DI_REF.short_code
			       END AS Office
			      ,CASE
				      		WHEN
				      			DI_REF.full_name = ' '
				      		THEN
				      			'Not ''Ere'
				      		ELSE
				      			ISNULL(DI_REF.full_name,D_U.Undersigned)
				      		END AS 'Telesales Agent',
			      
			      ISNULL((
			        SELECT Top (1)
			          Undersigned
			        FROM
			          Debtsolv.dbo.Users AS D_URS
			        LEFT JOIN
			          Debtsolv.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
			        WHERE
			          D_CLD.LeadPoolReference = CLD.ClientID
			      ),(SELECT Top (1)
			      	  Undersigned
			      	FROM
			      	  Debtsolv.dbo.Users AS DURS
			      	LEFT JOIN
			      	  Leadpool_DM.dbo.CampaignContactAccess AS CCA ON DURS.ID = CCA.UserID
			      	WHERE
			      	  CCA.CampaignContactID = CC.ID
			      	ORDER BY
			      	CCA.AccessDate DESC)) AS 'Consolidator'
			      
			      ,TCR.[Description]
			      ,ISNULL(DI_REF.product,'DR') AS Product
			      ,D_CPD.NormalExpectedPayment / 100 AS DI,
			      (
			      	SELECT Top (1)
			      		ResponseText
			      	FROM
			      		Debtsolv.dbo.Client_CustomQuestionResponses
			      	WHERE
			      		QuestionID = 10001
			      		AND ClientID = D_CLD.Client_ID
			      ) AS 'Delivery',
			      (
			      	SELECT Top (1)
			      		ResponseVal
			      	FROM
			      		Debtsolv.dbo.Client_CustomQuestionResponses
			      	WHERE
			      		QuestionID = 10007
			      		AND ClientID = D_CLD.Client_ID
			      ) AS 'ProductType'
			      ,CONVERT(varchar, CLD.DateCreated, 120) AS 'Referred Date'
			      ,CONVERT(varchar, CC.LastContactAttempt, 120) AS 'Last Contact Date'
			      ,CASE
			         WHEN CC.ContactResult = 700
			           THEN CONVERT(varchar, CC.Appointment, 120)
			         ELSE
			           ''
			       END AS 'Call Back Date'
			       , CC.ContactResult AS ContactResult
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
				Debtsolv.dbo.Type_Lead_Source AS DSLSO ON LBA.LeadSourceID = DSLSO.ID
				
			  LEFT JOIN
			    Debtsolv.dbo.Client_LeadData AS D_CLD ON CLD.ClientID = D_CLD.LeadPoolReference
			  LEFT JOIN
			    Debtsolv.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
			  LEFT JOIN
			    Debtsolv.dbo.Client_PaymentData AS D_CPD ON D_CLD.Client_ID = D_CPD.ClientID
			  LEFT JOIN
			  	Dialler.dbo.referrals AS DI_REF ON CLD.ClientID = DI_REF.leadpool_id
			  WHERE
			    ". $disposition_duration ."
				AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.NormalExpectedPayment <= 0) AND CC.ContactResult = 1500)
			    ". $call_center_choice ."
			    AND ISNULL(DI_REF.product,'DR') = 'DR'
			  ORDER BY
				CLD.LeadRef2
			    ,TCR.[Description]
			    ,Product
			    ,CLD.DateCreated DESC")->cached(300, "disposition.report.".$cache_name."gab",false)->execute('debtsolv');
			    
			    
			    
			    
			    
			    $results2 = DB::query("SELECT CLD.ClientID
				  ,CLD.LeadRef AS 'Dialler Lead ID'
			      ,(CD.Forename + ' ' + CD.Surname) AS Name
			      ,ISNULL(NULLIF(LSO.[Description],'<None>'), DSLSO.[Description]) AS 'Lead Source'
			      ,CASE WHEN
			      	ISNULL(DI_REF.short_code,'<None>') = '<None>'
			       THEN
			       	('<span id='''+CONVERT(varchar,CLD.ClientID)+''' class=''no-office-resolve''></span>')
			       ELSE
			       	DI_REF.short_code
			       END AS Office
			      ,CASE
				      		WHEN
				      			DI_REF.full_name = ' '
				      		THEN
				      			'Not ''Ere'
				      		ELSE
				      			ISNULL(DI_REF.full_name,D_U.Undersigned)
				      		END AS 'Telesales Agent',
			      
			      ISNULL((
			        SELECT Top (1)
			          Undersigned
			        FROM
			          BS_Debtsolv_DM.dbo.Users AS D_URS
			        LEFT JOIN
			          BS_Debtsolv_DM.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
			        WHERE
			          D_CLD.LeadPoolReference = CLD.ClientID
			      ),(SELECT Top (1)
			      	  Undersigned
			      	FROM
			      	  BS_Debtsolv_DM.dbo.Users AS DURS
			      	LEFT JOIN
			      	  BS_Leadpool_DM.dbo.CampaignContactAccess AS CCA ON DURS.ID = CCA.UserID
			      	WHERE
			      	  CCA.CampaignContactID = CC.ID
			      	ORDER BY
			      	CCA.AccessDate DESC)) AS 'Consolidator'
			      
			      ,TCR.[Description]
			      ,ISNULL(DI_REF.product,'DR') AS Product
			      ,D_CPD.NormalExpectedPayment / 100 AS DI,
			      (
			      	SELECT Top (1)
			      		ResponseText
			      	FROM
			      		BS_Debtsolv_DM.dbo.Client_CustomQuestionResponses
			      	WHERE
			      		QuestionID = 10001
			      		AND ClientID = D_CLD.Client_ID
			      ) AS 'Delivery',
			      (
			      	SELECT Top (1)
			      		ResponseVal
			      	FROM
			      		BS_Debtsolv_DM.dbo.Client_CustomQuestionResponses
			      	WHERE
			      		QuestionID = 10007
			      		AND ClientID = D_CLD.Client_ID
			      ) AS 'ProductType'
			      ,CONVERT(varchar, CLD.DateCreated, 120) AS 'Referred Date'
			      ,CONVERT(varchar, CC.LastContactAttempt, 120) AS 'Last Contact Date'
			      ,CASE
			         WHEN CC.ContactResult = 700
			           THEN CONVERT(varchar, CC.Appointment, 120)
			         ELSE
			           ''
			       END AS 'Call Back Date'
			       , CC.ContactResult AS ContactResult
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
				BS_Debtsolv_DM.dbo.Type_Lead_Source AS DSLSO ON LBA.LeadSourceID = DSLSO.ID
				
			  LEFT JOIN
			    BS_Debtsolv_DM.dbo.Client_LeadData AS D_CLD ON CLD.ClientID = D_CLD.LeadPoolReference
			  LEFT JOIN
			    BS_Debtsolv_DM.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
			  LEFT JOIN
			    BS_Debtsolv_DM.dbo.Client_PaymentData AS D_CPD ON D_CLD.Client_ID = D_CPD.ClientID
			  LEFT JOIN
			  	Dialler.dbo.referrals AS DI_REF ON CLD.ClientID = DI_REF.leadpool_id
			  WHERE
			    ". $disposition_duration ."
				AND NOT ((D_CPD.InitialAgreedAmount is null OR D_CPD.NormalExpectedPayment <= 0) AND CC.ContactResult = 1500)
			    ". $call_center_choice ."
			    AND ISNULL(DI_REF.product,'DR') = 'DR'
			  ORDER BY
				CLD.LeadRef2
			    ,TCR.[Description]
			    ,Product
			    ,CLD.DateCreated DESC")->cached(300, "disposition.report.".$cache_name."resolve",false)->execute('debtsolv');
			    
			    
			    $results = array();
			    
			    
			    foreach ($results1 AS $rsult)
			    {
				    $results[] = $rsult;
			    }
			    
			    foreach ($results2 AS $rsult)
			    {
				    $results[] = $rsult;
			    }
			    
				$totals = array(
					'referrals' => array(
						'count' => 0,
						'value' => 0,
					),
					'pack_outs' => array(
						'count' => 0,
						'value' => 0,
					),
					'dr_pack_outs' => array(
						'count' => 0,
						'value' => 0,
					),
					'dmplus_pack_outs' => array(
						'count' => 0,
						'value' => 0,
					),
					'pack_ins' => array(
						'count' => 0,
						'value' => 0,
					),
					'paid' => array(
						'count' => 0,
						'value' => 0,
					),
				);
				$result_parse = array();
				$lost_parse = array();
				$po_result_parse = array();
				foreach ($results AS $result)
				{
					if ($result['Dialler Lead ID'] == 'fab' || $result['Telesales Agent'] == 'FAB Admin' || $result['Consolidator'] == 'FAB Admin')
					{
						// Do Nothing
					}
					else if ( ($result['ContactResult'] == 0 || $result['ContactResult'] == 900 || $result['ContactResult'] == 721) && !$include_no_contacts )
					{
						$lost_parse[] = array(
							$result['ClientID'],
							$result['Dialler Lead ID'],
							$result['Name'],
							$result['Lead Source'],
							$result['Office'],
							$result['Telesales Agent'],
							$result['Consolidator'],
							'<div class="dispositionName">'.$result['Description'].'</div>',
							date("d-m-y H:i:s", strtotime($result['Referred Date'])),
						);
						
					}
					else
					{
						
						if ( strtotime($result['Referred Date']) >= strtotime($start_date . " 00:00:00") && strtotime($result['Referred Date']) <= strtotime($end_date. " 23:59:59") )
						{
						  
						  $pdtype = "";
						  
						  switch ((string)$result['ProductType']) {
						  
						      CASE '0':
						          $pdtype = "DR";
						          break;
						      CASE '1':
						          $pdtype = "DMPLUS";
						          break;
						      CASE '2':
						          $pdtype = "PPI";
						          break;
						      CASE '':
						          $pdtype = "";
						          break;
						  }
						
							$result_parse[] = array(
								$result['ClientID'],
								$result['Dialler Lead ID'],
								$result['Name'],
								$result['Lead Source'],
								$result['Office'],
								$result['Telesales Agent'],
								$result['Consolidator'],
								'<div class="dispositionName">'.$result['Description'].'</div>',
								$result['DI'],
								$result['Delivery'],
								$pdtype,
								date("d-m-y", strtotime($result['Referred Date'])),
								date("d-m-y H:i", strtotime($result['Last Contact Date'])),
								($result['Call Back Date']<>" ") ? date("d-m-y", strtotime($result['Call Back Date'])) : "",
								
							);
							$totals['referrals']['count']++;
							$totals['referrals']['value']=$totals['referrals']['value']+$result['DI'];
						}
					
						
						if ($result['Description'] == "Lead Completed")
						{
    				      
    				      $pdtype = "";
						  
						  switch ((string)$result['ProductType']) {
						  
						      CASE '0':
						          $pdtype = "DR";
						          $totals['dr_pack_outs']['count']++;
						          $totals['dr_pack_outs']['value']=$totals['dr_pack_outs']['value']+$result['DI'];
						          break;
						      CASE '1':
						          $pdtype = "DMPLUS";
						          $totals['dmplus_pack_outs']['count']++;
						          $totals['dmplus_pack_outs']['value']=$totals['dmplus_pack_outs']['value']+$result['DI'];
						          break;
						      CASE '2':
						          $pdtype = "PPI";
						          break;
						      DEFAULT:
						          $pdtype = "";
						          break;
						  }
						
							$po_result_parse[] = array(
								$result['ClientID'],
								$result['Dialler Lead ID'],
								$result['Name'],
								$result['Lead Source'],
								$result['Office'],
								$result['Telesales Agent'],
								$result['Consolidator'],
								$result['DI'],
								$result['Delivery'],
								$pdtype,
								date("d-m-y", strtotime($result['Referred Date'])),
							);
							$totals['pack_outs']['count']++;
							$totals['pack_outs']['value']=$totals['pack_outs']['value']+$result['DI'];
						}
					
					}
					
				}
				
				
				$pack_ins1 = DB::query("SELECT CLD.ClientID AS 'Leadpool ID'
					  ,D_CPD.ClientID AS ClientID
					  ,CLD.LeadRef AS 'Dialler Lead ID'
				      ,(CD.Forename + ' ' + CD.Surname) AS Name
				      ,LSO.[Description] AS 'Lead Source'
				      ,CLD.LeadRef2 AS Office
				      ,TCR.[Description]
				      
				      , CASE
				      		WHEN
				      			DI_REF.full_name = ' '
				      		THEN
				      			'NONE'
				      		ELSE
				      			ISNULL(DI_REF.full_name,D_U.Undersigned)
				      		END AS 'Telesales Agent'
			      
				      ,ISNULL((
				        SELECT Top (1)
				          Undersigned
				        FROM
				          Debtsolv.dbo.Users AS D_URS
				        LEFT JOIN
				          Debtsolv.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
				        WHERE
				          D_CLD.LeadPoolReference = CLD.ClientID
				      ),(SELECT Top (1)
				      	  Undersigned
				      	FROM
				      	  Debtsolv.dbo.Users AS DURS
				      	LEFT JOIN
				      	  Leadpool_DM.dbo.CampaignContactAccess AS CCA ON DURS.ID = CCA.UserID
				      	WHERE
				      	  CCA.CampaignContactID = CC.ID
				      	ORDER BY
				      	CCA.AccessDate DESC)) AS 'Consolidator'
				      
				      ,CASE
				         WHEN D_CPD.InitialAgreedAmount > 0 AND CC.ContactResult = 1500
				            THEN 'DR'
				         WHEN (D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500
				            THEN 'PPI'
				         ELSE
				           ''
				         END AS Product
				      ,D_CPD.NormalExpectedPayment / 100 AS DI
				      ,(
				      	SELECT Top (1)
				      		ResponseVal
				      	FROM
				      		Debtsolv.dbo.Client_CustomQuestionResponses
				      	WHERE
				      		QuestionID = 10001
				      		AND ClientID = D_CLD.Client_ID
				      ) AS 'Delivery'
				      ,CONVERT(varchar, D_CLD.DatePackReceived, 105) AS 'Pack In Date'
				      ,CONVERT(varchar, CLD.DateCreated, 120) AS 'Referred Date'
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
				  	". $pack_in_duration ."
				  	". $call_center_choice ."
				  	AND D_U.Undersigned <> 'FAB Admin'
				  	AND D_CPD.NormalExpectedPayment > 0
				  ORDER BY
					CLD.LeadRef2
				    ,TCR.[Description]
				    ,Product
				    ,CLD.DateCreated DESC")->cached(300)->execute('debtsolv');
				
				
				
				
				
				$pack_ins2 = DB::query("SELECT CLD.ClientID AS 'Leadpool ID'
					  ,D_CPD.ClientID AS ClientID
					  ,CLD.LeadRef AS 'Dialler Lead ID'
				      ,(CD.Forename + ' ' + CD.Surname) AS Name
				      ,LSO.[Description] AS 'Lead Source'
				      ,CLD.LeadRef2 AS Office
				      ,TCR.[Description]
				      
				      , CASE
				      		WHEN
				      			DI_REF.full_name = ' '
				      		THEN
				      			'NONE'
				      		ELSE
				      			ISNULL(DI_REF.full_name,D_U.Undersigned)
				      		END AS 'Telesales Agent'
			      
				      ,ISNULL((
				        SELECT Top (1)
				          Undersigned
				        FROM
				          BS_Debtsolv_DM.dbo.Users AS D_URS
				        LEFT JOIN
				          BS_Debtsolv_DM.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
				        WHERE
				          D_CLD.LeadPoolReference = CLD.ClientID
				      ),(SELECT Top (1)
				      	  Undersigned
				      	FROM
				      	  BS_Debtsolv_DM.dbo.Users AS DURS
				      	LEFT JOIN
				      	  BS_Leadpool_DM.dbo.CampaignContactAccess AS CCA ON DURS.ID = CCA.UserID
				      	WHERE
				      	  CCA.CampaignContactID = CC.ID
				      	ORDER BY
				      	  CCA.AccessDate DESC)) AS 'Consolidator'
				      
				      ,CASE
				         WHEN D_CPD.InitialAgreedAmount > 0 AND CC.ContactResult = 1500
				            THEN 'DR'
				         WHEN (D_CPD.InitialAgreedAmount is null OR D_CPD.InitialAgreedAmount <= 0) AND CC.ContactResult = 1500
				            THEN 'PPI'
				         ELSE
				           ''
				         END AS Product
				      ,D_CPD.NormalExpectedPayment / 100 AS DI
				      ,(
				      	SELECT Top (1)
				      		ResponseText
				      	FROM
				      		BS_Debtsolv_DM.dbo.Client_CustomQuestionResponses
				      	WHERE
				      		QuestionID = 10001
				      		AND ClientID = D_CLD.Client_ID
				      ) AS 'Delivery'
				      ,CONVERT(varchar, D_CLD.DatePackReceived, 105) AS 'Pack In Date'
				      ,CONVERT(varchar, CLD.DateCreated, 120) AS 'Referred Date'
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
				  	". $pack_in_duration ."
				  	". $call_center_choice ."
				  	AND D_U.Undersigned <> 'FAB Admin'
				  	AND D_CPD.NormalExpectedPayment > 0
				  ORDER BY
					CLD.LeadRef2
				    ,TCR.[Description]
				    ,Product
				    ,CLD.DateCreated DESC")->cached(300)->execute('debtsolv');
				
				
				
				
				$pack_ins = array();
				
				foreach ($pack_ins1 AS $pi)
				{
					$pack_ins[] = $pi;
				}
				
				foreach ($pack_ins2 AS $pi)
				{
					$pack_ins[] = $pi;
				}
				
				
				
				
				$all_pack_in = array();
				foreach ($pack_ins AS $pack_in)
				{
					$all_pack_in[] = array(
						$pack_in['ClientID'],
						$pack_in['Dialler Lead ID'],
						$pack_in['Name'],
						$pack_in['Lead Source'],
						$pack_in['Office'],
						$pack_in['Telesales Agent'],
						$pack_in['Consolidator'],
						$pack_in['DI'],
						$pack_in['Delivery'],
						date("d-m-y", strtotime($pack_in['Referred Date'])),
						date("d-m-y", strtotime($pack_in['Pack In Date'])),
					);
					
					$totals['pack_ins']['count']++;
					$totals['pack_ins']['value']=$totals['pack_ins']['value']+$pack_in['DI'];
				}
				
				
				$paid_duration = "(D_CD.FirstPaymentDate >= '". date('Y-m-d', strtotime($start_date)) ."' AND D_CD.FirstPaymentDate <= '". date('Y-m-d', strtotime($end_date)) ."') ";
				
								
				$paid_reports1 = \DB::query("SELECT
                                                D_CD.ClientID
                                              , (CD.Forename + ' ' + CD.Surname) AS Name
                                              , LSO.[Description] AS 'Lead Source'
											  , CLD.LeadRef2 AS Office
											  , CASE
                            				      		WHEN
                            				      			DI_REF.full_name = ' '
                            				      		THEN
                            				      			'NONE'
                            				      		ELSE
                            				      			ISNULL(DI_REF.full_name,D_U.Undersigned)
                            				      		END AS 'Telesales Agent'
                            				      						  ,ISNULL((
                            				        SELECT Top (1)
                            				          Undersigned
                            				        FROM
                            				          Debtsolv.dbo.Users AS D_URS
                            				        LEFT JOIN
                            				          Debtsolv.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
                            				        WHERE
                            				          D_CLD.LeadPoolReference = CLD.ClientID
                            				      ),(SELECT Top (1)
                            				      	  Undersigned
                            				      	FROM
                            				      	  Debtsolv.dbo.Users AS DURS
                            				      	LEFT JOIN
                            				      	  Leadpool_DM.dbo.CampaignContactAccess AS CCA ON DURS.ID = CCA.UserID
                            				      	WHERE
                            				      	  CCA.CampaignContactID = CC.ID
                            				      	ORDER BY
                            				      	  CCA.AccessDate DESC)) AS 'Consolidator'
                                                                          , D_CPD.NormalExpectedPayment/100 AS DI
                                                                          ,(
                            			      	SELECT Top (1)
                            			      		ResponseVal
                            			      	FROM
                            			      		Debtsolv.dbo.Client_CustomQuestionResponses
                            			      	WHERE
                            			      		QuestionID = 10007
                            			      		AND ClientID = D_CLD.Client_ID
                            			      ) AS 'ProductType'
                                              ,CONVERT(varchar, CLD.DateCreated, 120) AS 'Referred Date'
                                              ,CONVERT(varchar, D_CLD.DatePackReceived, 105) AS 'Pack In Date'
                                              , D_CD.FirstPaymentDate
                                            FROM
                                              Dialler.dbo.client_dates AS D_CD
                                            LEFT JOIN
                                              Debtsolv.dbo.Client_PaymentData AS D_CPD ON D_CPD.ClientID=D_CD.ClientID
                                            LEFT JOIN
                                              Debtsolv.dbo.Client_LeadData AS D_CLD ON D_CD.ClientID = D_CLD.Client_ID
                                            LEFT JOIN
                                              Dialler.dbo.referrals AS DI_REF ON D_CLD.LeadPoolReference = DI_REF.leadpool_id
                                            LEFT JOIN
                                              LeadPool_DM.dbo.Client_LeadDetails AS CLD ON CLD.ClientID = D_CLD.LeadPoolReference
                                            LEFT JOIN
                                              LeadPool_DM.dbo.Client_Details AS CD ON D_CLD.LeadPoolReference = CD.ClientID
                                            LEFT JOIN
                                              LeadPool_DM.dbo.LeadBatch AS LBA ON CLD.LeadBatchID = LBA.ID
                                            LEFT JOIN
                                              LeadPool_DM.dbo.Type_Lead_Source AS LSO ON LBA.LeadSourceID = LSO.ID
				  LEFT JOIN
				    LeadPool_DM.dbo.Campaign_Contacts AS CC ON CLD.ClientID = CC.ClientID
				  LEFT JOIN
				    Debtsolv.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
                                            WHERE
                                              " . $paid_duration . "
                                              ". $call_center_choice ."
                                              AND D_CD.Office = 'GAB'
				")->cached(300)->execute('debtsolv');				
				
				
				
				
				$paid_reports2 = \DB::query("SELECT
                                                D_CD.ClientID
                                              , (CD.Forename + ' ' + CD.Surname) AS Name
                                              , LSO.[Description] AS 'Lead Source'
											  , CLD.LeadRef2 AS Office
											  , CASE
                            				      		WHEN
                            				      			DI_REF.full_name = ' '
                            				      		THEN
                            				      			'NONE'
                            				      		ELSE
                            				      			ISNULL(DI_REF.full_name,D_U.Undersigned)
                            				      		END AS 'Telesales Agent'
                            				      						  ,ISNULL((
                            				        SELECT Top (1)
                            				          Undersigned
                            				        FROM
                            				          BS_Debtsolv_DM.dbo.Users AS D_URS
                            				        LEFT JOIN
                            				          BS_Debtsolv_DM.dbo.Client_LeadData AS D_CLD ON D_URS.ID = D_CLD.Counsellor
                            				        WHERE
                            				          D_CLD.LeadPoolReference = CLD.ClientID
                            				      ),(SELECT Top (1)
                            				      	  Undersigned
                            				      	FROM
                            				      	  BS_Debtsolv_DM.dbo.Users AS DURS
                            				      	LEFT JOIN
                            				      	  BS_Leadpool_DM.dbo.CampaignContactAccess AS CCA ON DURS.ID = CCA.UserID
                            				      	WHERE
                            				      	  CCA.CampaignContactID = CC.ID
                            				      	ORDER BY
                            				      	  CCA.AccessDate DESC)) AS 'Consolidator'
                                                                          , D_CPD.NormalExpectedPayment/100 AS DI
                                                                          ,(
                            			      	SELECT Top (1)
                            			      		ResponseVal
                            			      	FROM
                            			      		BS_Debtsolv_DM.dbo.Client_CustomQuestionResponses
                            			      	WHERE
                            			      		QuestionID = 10007
                            			      		AND ClientID = D_CLD.Client_ID
                            			      ) AS 'ProductType'
                                              ,CONVERT(varchar, CLD.DateCreated, 120) AS 'Referred Date'
                                              ,CONVERT(varchar, D_CLD.DatePackReceived, 105) AS 'Pack In Date'
                                              , D_CD.FirstPaymentDate
                                            FROM
                                              Dialler.dbo.client_dates AS D_CD
                                            LEFT JOIN
                                              BS_Debtsolv_DM.dbo.Client_PaymentData AS D_CPD ON D_CD.ClientID=D_CPD.ClientID
                                            LEFT JOIN
                                              BS_Debtsolv_DM.dbo.Client_LeadData AS D_CLD ON D_CLD.Client_ID = D_CD.ClientID
                                            LEFT JOIN
                                              Dialler.dbo.referrals AS DI_REF ON D_CLD.LeadPoolReference = DI_REF.leadpool_id
                                            LEFT JOIN
                                              BS_LeadPool_DM.dbo.Client_LeadDetails AS CLD ON D_CLD.LeadPoolReference = CLD.ClientID
                                            LEFT JOIN
                                              BS_LeadPool_DM.dbo.Client_Details AS CD ON D_CLD.LeadPoolReference = CD.ClientID
                                            LEFT JOIN
                                              BS_LeadPool_DM.dbo.LeadBatch AS LBA ON CLD.LeadBatchID = LBA.ID
                                            LEFT JOIN
                                              BS_LeadPool_DM.dbo.Type_Lead_Source AS LSO ON LBA.LeadSourceID = LSO.ID
				  LEFT JOIN
				    BS_LeadPool_DM.dbo.Campaign_Contacts AS CC ON CLD.ClientID = CC.ClientID
				  LEFT JOIN
				    BS_Debtsolv_DM.dbo.Users AS D_U ON D_CLD.TelesalesAgent = D_U.ID
                                            WHERE
                                              " . $paid_duration . "
                                              ". $call_center_choice ."
                                              AND D_CD.Office = 'RESOLVE'
				")->cached(300)->execute('debtsolv');
				
				
				
				
				
				
				
				$all_paid = array();
				foreach ($paid_reports1 AS $paid)
				{
				
				    $pdtype = "";
						  
    				  switch ((string)$paid['ProductType']) {
    				  
    				      CASE '0':
    				          $pdtype = "DR";
    				          break;
    				      CASE '1':
    				          $pdtype = "DMPLUS";
    				          break;
    				      CASE '2':
    				          $pdtype = "PPI";
    				          break;
    				      CASE '':
    				          $pdtype = "";
    				          break;
    				  }
				
				
				    $all_paid[] = array(
				        $paid['ClientID'],
				        $paid['Name'],
				        $paid['Lead Source'],
				        $paid['Office'],
				        $paid['Telesales Agent'],
				        $paid['Consolidator'],
				        $paid['DI'],
				        $pdtype,
				        date("d-m-y", strtotime($paid['Referred Date'])),
				        date("d-m-y", strtotime($paid['Pack In Date'])),
				        date("d-m-y", strtotime($paid['FirstPaymentDate'])),
				    );
				
    				$totals['paid']['count']++;
					$totals['paid']['value']=$totals['paid']['value']+$paid['DI'];
				}
				
				foreach ($paid_reports2 AS $paid)
				{
				
				    $pdtype = "";
						  
    				  switch ((string)$paid['ProductType']) {
    				  
    				      CASE '0':
    				          $pdtype = "DR";
    				          break;
    				      CASE '1':
    				          $pdtype = "DMPLUS";
    				          break;
    				      CASE '2':
    				          $pdtype = "PPI";
    				          break;
    				      CASE '':
    				          $pdtype = "";
    				          break;
    				  }
				
				
				    $all_paid[] = array(
				        $paid['ClientID'],
				        $paid['Name'],
				        $paid['Lead Source'],
				        $paid['Office'],
				        $paid['Telesales Agent'],
				        $paid['Consolidator'],
				        $paid['DI'],
				        $pdtype,
				        date("d-m-y", strtotime($paid['Referred Date'])),
				        date("d-m-y", strtotime($paid['Pack In Date'])),
				        date("d-m-y", strtotime($paid['FirstPaymentDate'])),
				    );
				
    				$totals['paid']['count']++;
					$totals['paid']['value']=$totals['paid']['value']+$paid['DI'];
				}
				
				
				
				
				// arrange the totals
				
				$totals['referrals']['value'] = number_format($totals['referrals']['value'],2);
				$totals['pack_outs']['value'] = number_format($totals['pack_outs']['value'],2);
				$totals['dr_pack_outs']['value'] = number_format($totals['dr_pack_outs']['value'],2);
				$totals['dmplus_pack_outs']['value'] = number_format($totals['dmplus_pack_outs']['value'],2);
				$totals['pack_ins']['value'] = number_format($totals['pack_ins']['value'],2);
				$totals['paid']['value'] = number_format($totals['paid']['value'],2);
				
				return(array(
	            	'status' => 'SUCCESS',
	            	'totals' => $totals,
	            	//'paid_test' => $paid_results,
	            	
	            	'paid' => array(
	            	    "aaData" => $all_paid,
	            	    "bPaginate" => false,
		            	"bDestroy" => true,
		            	"bProcessing" => true,
		            	"aoColumnDefs" => array(
							array(
								"iDataSort" => 2,
								"asSorting" => array("asc"),
								"aTargets" => array(0),
							),
						),
						"aoColumns" => array(
						    array(
								"sTitle" => "Client ID", 
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Name",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Lead Source",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Office",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Telesales",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Consolidator",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "DI",
								"sType"		=> "numeric",
							),
							array(
								"sTitle"    => "Product",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Referred",
								"sType"		=> "date-uk",
							),
							array(
								"sTitle"    => "Pack In",
								"sType"		=> "date-uk",
							),
							array(
								"sTitle"    => "First Payment",
								"sType"		=> "date-uk",
							),
						),
	            	),
	            	
	            	'no_contacts' => array(
		            	"aaData" => $lost_parse,
		            	"bPaginate" => false,
		            	"bDestroy" => true,
		            	"bProcessing" => true,
						"aoColumnDefs" => array(
							array(
								"iDataSort" => 2,
								"asSorting" => array("asc"),
								"aTargets" => array(0),
							),
						),
						"aoColumns" => array(
							array(
								"sTitle" => "Leadpool ID", 
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Dialler ID",
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Name",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Lead Source",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Office",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Telesales",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Consolidator",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Result",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Referred",
								"sType"		=> "date-uk",
							),
						),
					),
	            	
	            	'referrals' => array(
		            	"aaData" => $result_parse,
		            	"bDestroy" => true,
		            	"bPaginate" => false,
		            	"bProcessing" => true,
						"aoColumnDefs" => array(
							array(
								"iDataSort" => 2,
								"asSorting" => array("asc"),
								"aTargets" => array(0),
							),
						),
						"aoColumns" => array(
							array(
								"sTitle" => "Leadpool ID", 
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Dialler ID",
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Name",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Lead Source",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Office",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Telesales",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Consolidator",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Result",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "DI",
								"sType"		=> "numeric",
							),
							array(
								"sTitle"    => "Delivery",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Product",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Referred",
								"sType"		=> "date-uk",
							),
							array(
								"sTitle"    => "Last Contact",
								"sType"		=> "date-euro",
							),
							array(
								"sTitle"    => "Call Back",
								"sType"		=> "date-uk",
							),
						),
					),
					'pack_ins' => array(
		            	"aaData" => $all_pack_in,
		            	"bDestroy" => true,
		            	"bPaginate" => false,
		            	"bProcessing" => true,
						"aoColumnDefs" => array(
							array(
								"iDataSort" => 2,
								"asSorting" => array("asc"),
								"aTargets" => array(0),
							),
						),
						"aoColumns" => array(
							array(
								"sTitle" => "Debtsolv ID", 
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Dialler ID",
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Name",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Lead Source",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Office",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Telesales",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Consolidator",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "DI",
								"sType"		=> "numeric",
							),
							array(
								"sTitle"    => "Delivery",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Referred",
								"sType"		=> "date-uk",
							),
							array(
								"sTitle"    => "Pack In",
								"sType"		=> "date-uk",
							),
						),
					),
					'pack_outs' => array(
		            	"aaData" => $po_result_parse,
		            	"bDestroy" => true,
		            	"bPaginate" => false,
		            	"bProcessing" => true,
						"aoColumnDefs" => array(
							array(
								"iDataSort" => 2,
								"asSorting" => array("asc"),
								"aTargets" => array(0),
							),
						),
						"aoColumns" => array(
							array(
								"sTitle" => "Leadpool ID", 
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Dialler ID",
								"bSortable" => false,
							),
							array(
								"sTitle"    => "Name",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Lead Source",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Office",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Telesales",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Consolidator",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "DI",
								"sType"		=> "numeric",
							),
							array(
								"sTitle"    => "Delivery",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Product",
								"sType"		=> "string",
							),
							array(
								"sTitle"    => "Referred",
								"sType"		=> "date-uk",
							),
						),
					),
	            ));
				
			}
			
		}
		else
		{
			$this->response(array(
            	'status' => 'FAIL',
            	'message' => 'You do not have access to the disposition report.',
            ));
		}
	}
	
	
	
	
	
	
	public function action_disposition()
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
				$this->response(array(
	            	'status' => 'FAIL',
	            	'message' => 'You do not have access to the disposition report.',
	            ));
			} else {
				$center = $call_center->shortcode;
			}				
		}
	
		
		$start_date = $this->param('startdate');
		$end_date = $this->param('enddate');
		
		$all_call_centers = Model_Call_Center::find('all');
		
		
		
		$report_url = "/reports/dispositions";
		
		$report_url .= (!is_null($center)) ? "/center/".$center : "";
		$report_url .= (!is_null($start_date)) ? "/".$start_date : "";
		$report_url .= (!is_null($end_date)) ? "/".$end_date : "";
		
		$report_url .= ".json";
		
		$this->template->title = 'Reports &raquo; Disposition';
		$this->template->content = View::forge('reports/disposition', array(
			'view_all' => $view_all,
			'all_call_centers' => $all_call_centers,
			'center' => $center,
			'start_date' => $start_date,
			'end_date' => $end_date,
			
			'report_url' => $report_url,
		));

	}
	
	
	// Disposition Report entries go here...
	
	public function get_dispositions()
	{
	
		if ( (strtotime($this->param('enddate')) - strtotime($this->param('startdate'))) > 2678400 )
		{
			$this->response(array(
				'status' => 'FAIL',
				'message' => 'Sorry, you cannot get a disposition report for a larger period than one month!',
			));
		}
		else
		{
	
			$this->response(
				Controller_Reports::generate_disposition_report(
					$this->param('center'),
					Auth::has_access('reports.disposition'), 
					Auth::has_access('reports.all_centers'),
					$this->param('startdate'),
					$this->param('enddate')
				)
			);
		
		}
		
	}
	
	
	public function get_commission()
	{
		
		$start_date = $this->param('startdate');
		$end_date = $this->param('enddate');
		
		$get_paid_details = \GAB\Debtsolv::paid_in_report($start_date, $end_date);
			
		$valids = array();
		foreach ($get_paid_details['valids'] AS $name=>$valid)
		{
			$valids[] = array(
				$name,
				'&pound;'.number_format($valid['External'],2),
				'&pound;'.number_format($valid['Weekly'],2),
				'&pound;'.number_format($valid['Internal'],2),
				'&pound;'.number_format($valid['TotalDue'],2),
			);
		}
		
		$invalids = array();
		foreach ($get_paid_details['invalids'] AS $invalid)
		{
			$invalids[] = array(
				$invalid['Consolidator'],
				$invalid['ClientID'],
				$invalid['Name'],
				$invalid['Office'],
				'&pound;'.number_format(($invalid['DI']/100),2),
				$invalid['TotalPayments'],
				'&pound;'.number_format(($invalid['TotalPaid']/100),2),
			);
		}
		
		$all_clients = array();
		foreach ($get_paid_details['all-clients'] AS $client)
		{
			$all_clients[] = array(
				$client['Consolidator'],
				$client['ClientID'],
				$client['Name'],
				$client['Office'],
				'&pound;'.number_format(($client['DI']/100),2),
				$client['TotalPayments'],
				'&pound;'.number_format(($client['TotalPaid']/100),2),
			);
		}
		
		$this->response(array(
        	'valids' => array(
	        	"aaData" => $valids,
	        	"bDestroy" => true,
	        	"bProcessing" => true,
				"aoColumnDefs" => array(
					array(
						"iDataSort" => 0,
						"asSorting" => array("asc"),
						"aTargets" => array(0),
					),
				),
				"aoColumns" => array(
					array(
						"sTitle" => "Senior Name", 
						"bSortable" => false,
					),
					array(
						"sTitle"    => "External Commission",
						"sType" 	=> "numeric",
					),
					array(
						"sTitle"    => "WK/F Commission",
						"sType"		=> "numeric",
					),
					array(
						"sTitle"    => "Internal Commission",
						"sType"		=> "numeric",
					),
					array(
						"sTitle"    => "Total",
						"sType"		=> "numeric",
					),
				),
			),
			'invalids' => array(
	        	"aaData" => $invalids,
	        	"bDestroy" => true,
	        	"bProcessing" => true,
				"aoColumnDefs" => array(
					array(
						"iDataSort" => 0,
						"asSorting" => array("asc"),
						"aTargets" => array(0),
					),
				),
				"aoColumns" => array(
					array(
						"sTitle"    => "Senior Name",
						"sType"		=> "numeric",
					),
					array(
						"sTitle" => "ClientID", 
						"bSortable" => false,
					),
					array(
						"sTitle" => "Client Name", 
						"bSortable" => false,
					),
					array(
						"sTitle"    => "Office",
						"sType" 	=> "numeric",
					),
					array(
						"sTitle"    => "DI",
						"sType"		=> "numeric",
					),
					array(
						"sTitle"    => "Total Payments",
						"sType"		=> "numeric",
					),
					array(
						"sTitle"    => "Total Paid",
						"sType"		=> "numeric",
					),
				),
			),
			'all-clients' => array(
	        	"aaData" => $all_clients,
	        	"bDestroy" => true,
	        	"bProcessing" => true,
				"aoColumnDefs" => array(
					array(
						"iDataSort" => 0,
						"asSorting" => array("asc"),
						"aTargets" => array(0),
					),
				),
				"aoColumns" => array(
					array(
						"sTitle"    => "Senior Name",
						"sType"		=> "numeric",
					),
					array(
						"sTitle" => "ClientID", 
						"bSortable" => false,
					),
					array(
						"sTitle" => "Client Name", 
						"bSortable" => false,
					),
					array(
						"sTitle"    => "Office",
						"sType" 	=> "numeric",
					),
					array(
						"sTitle"    => "DI",
						"sType"		=> "numeric",
					),
					array(
						"sTitle"    => "Total Payments",
						"sType"		=> "numeric",
					),
					array(
						"sTitle"    => "Total Paid",
						"sType"		=> "numeric",
					),
				),
			),
        ));
		

	}
	
	
	public function action_commission()
	{
		
		$start_date = $this->param('startdate');
		$end_date = $this->param('enddate');
		
		
		$report_url = "/reports/commission";
		
		$report_url .= (!is_null($start_date)) ? "/".$start_date : "";
		$report_url .= (!is_null($end_date)) ? "/".$end_date : "";
		
		$report_url .= ".json";

		
		$this->template->title = 'Reports &raquo; Commission';
		$this->template->content = View::forge('reports/commission', array(
			
			'start_date' => $start_date,
			'end_date' => $end_date,
			'report_url' => $report_url,
		));		
	}
	
	
	

}
