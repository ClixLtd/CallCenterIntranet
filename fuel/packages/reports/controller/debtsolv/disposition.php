<?php


class Controller_Reports_Debtsolv_Disposition extends Reports\Controller_Report_Hybrid
{
	public function action_index()
	{
		$this->template->title = 'Disposition Report &raquo; ';
		
		$this->template->content = View::forge(static::$_viewPath . 'debtsolv/disposition/index.php');
	}
}