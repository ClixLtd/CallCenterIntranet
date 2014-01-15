<?php

class Controller_incentive extends Controller_BaseApi
{



	public function get_trading_places($center=null)
	{

        $userList = array();
        $allstaff = Model_Staff::query()->where( 'active', 1)->where('center_id', 1)->or_where('center_id', 2)->get();
        //print_r($allstaff);
        foreach ($allstaff AS $oneStaff)
        {
            $userList[$oneStaff->debtsolv_id]['points'] = 0;
        }
        
	    // Get a list of debtsolv_id names for active users
	    $salesstaff = Model_Staff::query()->where( 'active', 1)->where('department_id', 1);
	    if (!is_null($center))
	    {
    	    $salesstaff->where('center_id', $call_center->id);
	    }
	    $totalStaff = $salesstaff->count();
	    $salesstaff = $salesstaff->get();
	    
	    // Convert the active users into a list ready for the "IN" query
	    $salesinList = "";
	    $salesinListCount = 0;
	    foreach ($salesstaff AS $salesmember)
	    {
	        $salesinListCount++;
    	    $salesinList .= "'" . $salesmember->debtsolv_id . "'";
    	    
    	    if ($salesinListCount < $totalStaff)
    	    {
        	    $salesinList .= ",";
    	    }
	    }
	    
	    $seniorstaff = Model_Staff::query()->where( 'active', 1)->where('department_id', 2);
	    if (!is_null($center))
	    {
    	    $seniorstaff->where('center_id', $call_center->id);
	    }
	    $totalStaff = $seniorstaff->count();
	    $seniorstaff = $seniorstaff->get();
	    
	    // Convert the active users into a list ready for the "IN" query
	    $seniorinList = "";
	    $seniorinListCount = 0;
	    foreach ($seniorstaff AS $seniormember)
	    {
	        $seniorinListCount++;
    	    $seniorinList .= "'" . $seniormember->debtsolv_id . "'";
    	    
    	    if ($seniorinListCount < $totalStaff)
    	    {
        	    $seniorinList .= ",";
    	    }
	    }
    	



        $salesQuery = "SELECT 
                              D_CLD.Client_ID
                        	, D_URS.Login
                        	, D_CLD.DatePackSent
                        FROM
                        	Debtsolv_MMS.dbo.Client_LeadData AS D_CLD
                        LEFT JOIN
                        	Debtsolv_MMS.dbo.Users AS D_URS ON D_CLD.TelesalesAgent = D_URS.ID
                        WHERE
                        	D_CLD.DatePackSent >= '2013-03-01'
                        	AND D_CLD.DatePackSent < '2013-06-01'
                        	AND D_URS.Login IN (".$salesinList.")";

        

        $seniorQuery = "SELECT 
                              D_CLD.Client_ID
                        	, D_URS.Login
                        	, D_CLD.DatePackReceived
                        FROM
                        	Debtsolv_MMS.dbo.Client_LeadData AS D_CLD
                        LEFT JOIN
                        	Debtsolv_MMS.dbo.Users AS D_URS ON D_CLD.Counsellor = D_URS.ID
                        WHERE
                        	D_CLD.DatePackReceived >= '2013-03-01'
                        	AND D_CLD.DatePackReceived < '2013-06-01'
                        	AND D_URS.Login IN (".$seniorinList.")";

        
        
        $reportResultsSeniors = DB::query($seniorQuery)->cached(60)->execute('debtsolv');
        $reportResultsSales = DB::query($salesQuery)->cached(60)->execute('debtsolv');
        
        
        $point = array(
            'packOut' => 50,
            'packIn' => 25,
        );
        
        foreach ($reportResultsSeniors AS $oneSenior)
        {
            $userList[$oneSenior['Login']]['points'] = (!isset($userList[$oneSenior['Login']]['points'])) ? $point['packIn'] : $userList[$oneSenior['Login']]['points'] + $point['packIn'];
        }
    	
        
        foreach ($reportResultsSales AS $oneSenior)
        {
            $userList[$oneSenior['Login']]['points'] = (!isset($userList[$oneSenior['Login']]['points'])) ? $point['packOut'] : $userList[$oneSenior['Login']]['points'] + $point['packOut'];
        }
        
        
        
        
        arsort($userList);
        
        $pccResults = array();
        $hqResults = array();
        
        foreach ($userList AS $username => $points)
        {
            $salesstaff = Model_Staff::query()->where('debtsolv_id', $username);
            
           
            if ($salesstaff->count() > 0)
            {
                $salesstaff = $salesstaff->get_one();
                
                if ($salesstaff->center_id == 1)
                {
                    $hqResults[] = array(
                        'name' => $salesstaff->first_name . " " . $salesstaff->last_name,
                        'points' => (int)$points['points'],
                    );
                } 
                else if ($salesstaff->center_id == 2)
                {
                    $pccResults[] = array(
                        'name' => $salesstaff->first_name . " " . $salesstaff->last_name,
                        'points' => (int)$points['points'],
                    );
                }

            }
                        
        }
        
    	
    	return $this->response(array(
    	    'pcc'     => $pccResults,
    	    'hq'      => $hqResults,
    	));
    	
	}




}
