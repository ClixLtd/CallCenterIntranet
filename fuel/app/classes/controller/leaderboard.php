<?php

class Controller_Leaderboard extends Controller_BaseHybrid
{

    public function action_telesales($center=null)
    {
        
        if (Auth::has_access('reports.all_centers')) {
        	$view_all = TRUE;
    	} else {
        	$view_all = FALSE;
    	}
    	
    	$all_call_centers = Model_Call_Center::find('all');
        
        $this->template->title = 'Telesales Leaderboard';
		$this->template->content = View::forge('leaderboard/telesales', array(
		    'view_all' => $view_all,
		    'all_call_centers' => $all_call_centers,
		    'center' => $center,
			'url' => (!is_null($center)) ? '/reports/get_telesales_report/'.$center.'.json' : '/reports/get_telesales_report.json',
		));	
        
    }

}