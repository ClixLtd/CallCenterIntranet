<?php

namespace Reports;

class Controller_Sales extends \Templates\Controller_Force
{

	public function action_index()
	{
	
	    //$testModel = Model_Sales_Disposition::test();
	    
	    /*

	    if (\Reports\Query::forge(\Reports\Query::LOAD, 3)->isComplete())
	    {
    	    print_r('complete');
	    }
  
	    */
	    
	    // Load the required data module
	    if (!\Module::loaded('data') && \Module::exists('data')) \Module::load('data'); else throw new \Exception("Data Module not found!");
	    
	    $impData = \Data\Import::forge(\Data\Import::COPY, 1);
	
		$this->template->title = 'Example Page';
        $this->template->content = "hello";
	}

}