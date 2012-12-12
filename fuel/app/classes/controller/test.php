<?php

class Controller_Test extends Controller_Base 
{
	
	
	public function action_ppidb()
	{
		
		/*
		Crm\Letter\Letter::forge(12123)
			->writeContent(View::forge('letters/testletter'))
			->writeContent(View::forge('letters/testletter'))
			->setOutputFilename('test.pdf')
			->downloadLetter()
			->create();
		
		*/
		
		Crm\Letter\Pack::forge(6272,null,array(
			array(
				'id' => 1,
				'qty' => 1,
				'tray_id' => 2,
			),
			array(
				'id' => 2,
				'qty' => 3,
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
		))->setOutputFilename('temptest.pdf')->downloadLetter()->create();
			

							
		print "Done!";
	
	}
	
	
	public function action_ppi()
	{
		$this->template->title = "Test";
		$this->template->content = View::forge('test/view');
	}
	
}