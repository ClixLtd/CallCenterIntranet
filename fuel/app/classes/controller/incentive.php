<?php

class Controller_incentive extends Controller_BaseApi
{



    // Battle Ships Incentive Starts Here
    // W - Water, no shot taken
    // M - Miss, just water but nice try
    // H - Hit, part of ship hit
    // S - Sink, full ship sunk

    public function doShot($square, $agent)
    {
        $result = \DB::select('ship_id')->from('incentive_battleships_ship_parts')->where('square', $square)->execute()->as_array();

        if (count($result) > 0)
        {
            $shipID = $result[0]['ship_id'];
            // Get Ship Length
            $lengthCheck = \DB::select('length')->from('incentive_battleships_ships')->where('id', $shipID)->execute()->as_array();
            $hitCheck = \DB::select('*')->from('incentive_battleships_ship_parts')->where('ship_id', $shipID)->where('status', 2)->execute()->as_array();


            $shipLength = $lengthCheck[0]['length'];
            $previousHits = count($hitCheck);

            $isSunk = (($previousHits+1) >= $shipLength) ? true : false;

            if (!$isSunk)
            {
                list($a, $b) = \DB::insert('incentive_battleships_turns')->set(array(
                    'user_id' => $agent,
                    'square' => $square,
                    'status' => 2,
                ))->execute();

                $updres = \DB::update('incentive_battleships_ship_parts')->value('status', 2)->where('square', $square)->execute();

                return "H";

            }
            else
            {
                list($a, $b) = \DB::insert('incentive_battleships_turns')->set(array(
                    'user_id' => $agent,
                    'square' => $square,
                    'status' => 3,
                ))->execute();

                $updres = \DB::update('incentive_battleships_ships')->value('status', 1)->where('id', $shipID)->execute();
                $updres = \DB::update('incentive_battleships_ship_parts')->value('status', 3)->where('ship_id', $shipID)->execute();

                return "S";
            }

        }
        else
        {
            list($a, $b) = \DB::insert('incentive_battleships_turns')->set(array(
                'user_id' => $agent,
                'square' => $square,
                'status' => 1,
            ))->execute();
            return "M";
        }

    }


    // Create the Battleships Board with Results
    public function generateBoard()
    {
        $statusConvert = array(
            1 => 'M',
            2 => 'H',
            3 => 'S',
        );

        $board = array();
        $dimensions = array(
            'w' => 20,
            'h' => 20,
        );
        $letters = array();
        for ($j=1; $j <= $dimensions['w']; $j++)
        {
            $letters[$j] = chr( ($j + 64) );
        }

        for ($i=1; $i <= $dimensions['h']; $i++)
        {
            for ($j=1; $j <= $dimensions['w']; $j++)
            {
                $result = \DB::select('status', 'user_id')->from('incentive_battleships_turns')->where('square', $letters[$j].$i)->execute()->as_array();

                $agent = \DB::select('first_name', 'last_name')->from('staffs')->where('network_id', $result[0]['user_id'])->execute()->as_array();

                // Check the database for something in this square
                $board[$i][$letters[$j]] = array(
                    'type' => $statusConvert[$result[0]['status']],
                    'agent' => $agent[0]['first_name'] . " " . $agent[0]['last_name'],
                );
            }
        }

        return $board;
    }



    public function action_displayboard()
    {
        $board = Controller_incentive::generateBoard();

        $agents = \DB::select('first_name', 'last_name', 'network_id')->from('staffs')->where('active', 1)->order_by('first_name')->execute()->as_array();

        $this->template->title = 'Battleships';
        $this->template->content = View::forge('incentive/battleships_board', array(
            'board' => $board,
            'agents' => $agents,
        ));
    }

    public function action_takeShot()
    {

        $square = Input::post('square');
        $agent = Input::post('agent');


        $result = Controller_incentive::doShot($square, $agent);

        switch($result)
        {
            case "M":
                $template = "battleships_miss";
                break;
            case "H":
                $template = "battleships_hit";
                break;
            case "S":
                $template = "battleships_sunk";
                break;

        }

        $this->template->title = 'Battleships';
        $this->template->content = View::forge('incentive/' . $template);

    }



    // Battle Ships Incentive Ends Here








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
                        	Debtsolv.dbo.Client_LeadData AS D_CLD
                        LEFT JOIN
                        	Debtsolv.dbo.Users AS D_URS ON D_CLD.TelesalesAgent = D_URS.ID
                        WHERE
                        	D_CLD.DatePackSent >= '2013-03-01'
                        	AND D_CLD.DatePackSent < '2013-06-01'
                        	AND D_URS.Login IN (".$salesinList.")";

        

        $seniorQuery = "SELECT 
                              D_CLD.Client_ID
                        	, D_URS.Login
                        	, D_CLD.DatePackReceived
                        FROM
                        	Debtsolv.dbo.Client_LeadData AS D_CLD
                        LEFT JOIN
                        	Debtsolv.dbo.Users AS D_URS ON D_CLD.Counsellor = D_URS.ID
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
