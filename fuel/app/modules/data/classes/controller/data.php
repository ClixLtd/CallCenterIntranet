<?php

namespace Data;

class Controller_Data extends \Controller_Base
{

    public function action_index($supplier_id=null)
    {
        $quickView = array(
            'top5' => \Data\Model_Data::list_all($supplier_id, 'score', 5),
        );
        
        $this->template->title = 'Example Page';
        $this->template->content = "hello";
    }
    
    
    
    /**
     * Lists all Data in the system.
     * 
     * @access public
     * @return void
     */
    public function action_list($supplier_id=null)
    {
        $allData = \Data\Model_Data::list_all($supplier_id, 'id');
        
        $this->template->title = 'Listing all Data';
        $this->template->content = \View::forge('view/list', array(
        	'lists' => $allData,
        ));
    }
    
    
    
    
    public function action_view($data_id=null)
    {
	    if (!is_null($data_id))
	    {
		    $listDetails = \Data\Model_Data::get_stats($data_id);
		    $oneList     = $listDetails[0];
		    
		    $basicStats  = array(
		    	'purchased'  => $oneList['purchased_leads'],
		    	'duplicates' => $oneList['duplicates'],
				'tps'		 => $oneList['tps'],
		    	'dialable'   => $oneList['dialable_leads'],
		    	'contacted'  => $oneList['contacted_leads'],
		    	'referrals'  => $oneList['referrals'],
		    	'packout'    => $oneList['pack_out'],
		    	'packin'     => $oneList['pack_in'],
		    	'paid'       => $oneList['first_payment'],
		    	'listid'     => $oneList['dialler_id'],
		    );
		    
		    $invalidLeads = \Data\Model_Data::get_invalids($data_id);
		    
		    $tpsNumbers = $duplicateNumbers = array();
		    foreach ($invalidLeads as $singleLead)
		    {
			    $leadDetails = unserialize($singleLead['number_data']);
			    
			    if (isset($leadDetails['duplicates']) && count($leadDetails['duplicates']) > 0)
			    {
				    $duplicateNumbers[] = array(
				    	'number' => $leadDetails['duplicates']['number'],
				    	'list_ids' => $leadDetails['duplicates']['list_ids'],
				    );
			    }
			    
			    if (isset($leadDetails['tps']) && count($leadDetails['tps']) > 0)
			    {
				    $tpsNumbers[] = array(
				    	'number' => $leadDetails['duplicates']['number'],
				    );
			    }
			    
		    }
		    
		    print_r($invalidLeads);
		    
	    }
	    else
	    {
		    // List ID has not been given
		    
	    }   
    }
    
    
    
    
    
    public function action_add()
    {
        
        
        
        $this->template->title = 'Add New Data';
        $this->template->content = \View::forge('add/add');
    }


    public function action_startimport()
    {
        
        
        
        $postHeaders = array();
        foreach (\Input::post('headings') as $key => $header)
        {
            if ($header <> 'null')
            {
                $postHeaders[$key] = $header;
            }
        }
    
        $postOptions = array();
        foreach (\Input::post('options') as $key => $header)
        {
        
            switch ($key)
            {
                CASE 'DUPES':
                    $postOptions[] = \Data\Source::DUPES;
                    break;
                CASE 'OPTIN':
                    $postOptions[] = \Data\Source::OPTIN;
                    break;
            }
            
        }
    
        
        $impData = \Data\Source::forge(\Data\Source::CREATE, array(
            'supplier_id' => \Input::post('supplier'),
            'dialler_id' => 12312,
            'headers' => $postHeaders,
            'import_options' => $postOptions,
            'filename' => \Input::post('filename'),
            'cost' => \Input::post('cost'),
        ));
        
        
        $this->template->title = 'Listing all Data';
        $this->template->content = "hello";
    }


    public function action_setoptions()
    {
    
        // Upload config and handling
        $config = array(
            'field' => 'file',
            'path' => DOCROOT.'uploads/data/',
            'randomize' => true,
            'ext_whitelist' => array('csv'),
        );
        
        \Upload::process($config);
        
        if (\Upload::is_valid())
        {
            // save them according to the config
            \Upload::save();
            
            $uploads = \Upload::get_files();
            $dataFilename = $uploads[0]['saved_as'];
            $realFilename = $uploads[0]['filename'];
            
            
            
            if($f = fopen(DOCROOT."uploads/data/".$dataFilename, 'r'))
            {
                $line = fgets($f); // read until first newline
                fclose($f);
            }
            
            $line = trim(preg_replace('/\s+/', ' ', $line));
            
            $fileHeadings = explode(',', str_replace('"', '',$line));
    
    
            // Generate a nice list of headings for the required fields
            $databaseHeadings = array(
                'title' => 'Title',
                'first_name' => 'First Name',
                'middle_initial' => 'Middle Initial',
                'last_name'     => 'Surname',
                'address1'      => 'Address 1',
                'address2'      => 'Address 2',
                'address3'      => 'Address 3',
                'city'          => 'City',
                'state'         => 'State',
                'province'      => 'Province',
                'postal_code'   => 'Post Code',
                'gender'        => 'Gender',
                'phone_number'  => 'Phone Number',
                'alt_phone'     => 'Alternate Phone',
                'email'         => 'E-Mail',
                'date_of_birth' => 'Date of Birth',
                'comments'      => 'Comments',
            );
            
            $headingGuess = array();
            foreach ($fileHeadings as $heading)
            {
                $checkHeading = \Data\Model_Data::heading_suggestion($heading);
                
                if ($checkHeading)
                {
                    $headingGuess[$checkHeading] = $heading;
                }
                
            }

        }
        
        
                
        $this->template->title = 'Set Data Options';
        $this->template->content = \View::forge('add/setoptions', array(
            'dataFilename'  => $dataFilename,
            'realFilename'  => $realFilename,
            'allHeadings'   => $databaseHeadings,
            'fileHeadings'  => $fileHeadings,
            'headingsGuess' => $headingGuess,
        ));
    }

}