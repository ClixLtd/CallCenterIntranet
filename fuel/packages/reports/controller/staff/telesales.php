<?php


class Controller_Reports_Staff_Telesales extends Reports\Controller_Report_Hybrid
{
	

	
	public function get_index()
	{
		$report = static::create_report();
	}

	public function action_index()
	{
	
		
	
		$this->template->title = 'Telesales Report &raquo; ';
		
		$this->template->content = View::forge(static::$_viewPath . 'staff/telesales/index.php', array(
			'report' => Reports\Model_Reports_Staff_Telesales::leagueTable(),
		));
	}
	
	
	
	private function create_report()
	{
		return "I am SPARTA!";
	}
	

}