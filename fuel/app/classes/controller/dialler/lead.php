<?php

class Controller_Dialler_Lead extends Controller_Base
{

	public function action_index()
	{
		$leadCount = DB::query('select count(id) AS count FROM dialler_all_numbers;')->execute();
		$actualCount = (int)$leadCount[0]['count'];
		
		$this->template->title = 'Dialler lead &raquo; Index';
		$this->template->content = View::forge('dialler/lead/index', array(
			'total_leads' => number_format( (int)$actualCount, 0),
		));
	}

	public function action_view($id)
	{
		$dialler_lead = Model_Dialler_All_Number::find($id);
	
		$this->template->title = 'Dialler lead &raquo; View';
		$this->template->content = View::forge('dialler/lead/view', array(
			'dialler_lead' => $dialler_lead,
			'previous_record' => ($id-1),
			'next_record' => ($id+1),
		));
	}

	public function action_check_duplicate()
	{
		
	}

	public function action_add()
	{
		$this->template->title = 'Dialler lead &raquo; Add';
		$this->template->content = View::forge('dialler/lead/add');
	}

}
