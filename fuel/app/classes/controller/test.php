<?php

class Controller_Test extends Controller_Base 
{
	
	public function action_report()
	{
	
	    $report = Report\Create::forge(array(
	        'Report1' => array(
	            'reportResults' => array(),
	            'displayType' => 'table',
	            'options' => array(),
	        ),
	    ),3600);
	    	
    	$this->template->title = "Reporting Test";
		$this->template->content = View::forge('test/report', array(
		    'reports' => $report->generate(),
		));
	}
	
	
	public function action_ppidb()
	{
		
		
		
    		$clientID = 6559;
		    $referral_id = 1172;
		    
		    $referralDetails = \DB::query("SELECT data FROM crm_referrals WHERE id='".$referral_id."';", \DB::select())->execute()->as_array();
		    
		    $data = unserialize($referralDetails[0]['data']);
		    
		    
    		Crm\Letter\Pack::forge($clientID,null,array(
    			array(
    				'id' => 1,
    				'qty' => 1,
    				'tray_id' => 2,
    			),
    		))->setOutputFilename('ppi_pack_coverletter_'.$clientID.'.pdf')->printLetter(2, 25)->create();
    		
    		Crm\Letter\Pack::forge($clientID,null,array(
    			array(
    				'id' => 2,
    				'qty' => (count($data['creditors']) > 0) ? count($data['creditors']) : 3,
    				'tray_id' => 1,
    			),
    			array(
    				'id' => 3,
    				'qty' => 1,
    				'tray_id' => 1,
    			),
    			array(
    				'id' => 4,
    				'qty' => 1,
    				'tray_id' => 1,
    			),
    			array(
    				'id' => 5,
    				'qty' => 1,
    				'tray_id' => 1,
    			),
    		))->setOutputFilename('ppi_pack_'.$clientID.'.pdf')->printLetter()->create();
    		
    		//\DB::query("UPDATE crm_ppi_clients SET pack_sent_date='2013-01-07' WHERE client_id=".$clientID.";")->execute();
    		
    									
		print "Done!";
	
	}
	
	
	public function action_ppi()
	{
		$this->template->title = "Test";
		$this->template->content = View::forge('test/view');
	}
	
}