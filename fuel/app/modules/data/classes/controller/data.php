<?php

namespace Data;

class Controller_Data extends \Controller_BaseHybrid
{

    public function action_index($supplier_id=null)
    {
        $quickView = array(
            'top5' => \Data\Model_Data::list_all($supplier_id, 'score', 5),
        );
        
        $this->template->title = 'Example Page';
        $this->template->content = "hello";
    }


    public function get_softresetlist($listID)
    {
        $updateResult = Model_Data::softResetList($listID);

        return $this->response($updateResult);
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

        $topScore = 0;

        foreach ($allData as $key=>$singleData)
        {
            $allData[$key]['score'] = ($singleData['score'] > 0 ) ? ($singleData['score'] / $singleData['purchased_leads']) : 0;
        }

        foreach ($allData as $singleData)
        {
            if ($singleData['score'] >= $topScore)
            {
                $topScore = $singleData['score'];
            }
        }

        $this->template->title = 'Listing all Data';
        $this->template->content = \View::forge('view/list', array(
        	'lists' => $allData,
            'topScore' => $topScore,
        ));
    }
    
    
    public function action_exportinvalidleads($data_id)
    {
	    
	    $headings = array(
	    	'Dialler ID' => 'dialler_lead_id',
	    	'Title' => 'title',
	    	'First Name' => 'first_name',
	    	'Last Name' => 'last_name',
	    	'Number' => 'phone_number',
	    	'Alt Number' => 'alt_phone',
	    	'Status' => 'number_data',
	    );
	    
	    $headingArray = array();
	    $headingCounts = array();
	    foreach ($headings as $heading=>$dbcolumn)
	    {
		    $headingCounts[] = $dbcolumn;
	    }
	    
	    
	    list($validLeads, $validCount, $filterCount) = \Data\Model_Data::get_leads($data_id, -1);
	    	    
	    $makeArray = array();
	    foreach ($validLeads as $singleLead)
	    {
	    	$singleArray = array();
	    	foreach ($headings as $heading)
	    	{
                if ($heading == 'number_data')
                {
                    $allData = unserialize($singleLead[$heading]);

                    $duplicateIntranetList = $allData['duplicates']['data_list_ids'][0];

                    $diallerListIDQuery = \DB::select('dialler_id')->from('data')->where('id', $duplicateIntranetList)->execute()->as_array();

                    $diallerListID = $diallerListIDQuery[0]['dialler_id'];

                    $singleArray[] = ((int)$diallerListID > 0) ? 'Duplicate from list '.$diallerListID : 'TPS Match'    ;
                }
                else
                {
                    $singleArray[] = $singleLead[$heading];
                }
	    }
	    
	    $makeArray[] = $singleArray;
	    
	}
	
	$data = "";
	foreach ($makeArray as $oneLine)
	{
	    $data .= implode(",", $oneLine)."\n";
	}
	
	//$data = \Format::forge($makeArray)->to_csv();
	    
	$response = new \Response();
	$response->set_header('Content-Type', 'text/csv');
	$response->set_header('Content-Disposition', 'attachment; filename="'.$data_id.'_'.date('Ymd-Hi').'.csv"');
	
	// $response->body($data);
	
	//return $response;
	
	$response->send_headers();
	
	echo $data;
	
	return "";
	
    }
    
    
    public function get_invalidleads($data_id)
    {
	    
	    $headings = array(
	    	'Dialler ID' => 'dialler_lead_id',
	    	'Title' => 'title',
	    	'First Name' => 'first_name',
	    	'Last Name' => 'last_name',
	    	'Number' => 'phone_number',
	    	'Alt Number' => 'alt_phone',
	    	'Status' => 'number_data',
	    );
	    
	    $headingArray = array();
	    $headingCounts = array();
	    foreach ($headings as $heading=>$dbcolumn)
	    {
		    $headingCounts[] = $dbcolumn;
	    }
	    
	    
	    list($validLeads, $validCount, $filterCount) = \Data\Model_Data::get_leads($data_id, \Input::get('iDisplayLength'), \Input::get('iDisplayStart'), $headingCounts[\Input::get('iSortCol_0')], \Input::get('sSortDir_0'), '=', \Input::get('sSearch', null));
	    	    
	    $makeArray = array();
	    foreach ($validLeads as $singleLead)
	    {
	    	$singleArray = array();
	    	foreach ($headings as $heading)
	    	{
                if ($heading == 'number_data')
                {
                    $allData = unserialize($singleLead[$heading]);

                    $duplicateIntranetList = $allData['duplicates']['data_list_ids'][0];

                    $diallerListIDQuery = \DB::select('dialler_id')->from('data')->where('id', $duplicateIntranetList)->execute()->as_array();

                    $diallerListID = $diallerListIDQuery[0]['dialler_id'];

                    $singleArray[] = ((int)$diallerListID > 0) ? 'Duplicate from list '.$diallerListID : 'TPS Match'    ;
                }
                else
                {
                    $singleArray[] = $singleLead[$heading];
                }
	    	}
	    	$makeArray[] = $singleArray;
	    }
	    
	    
	    return $this->response(array(
	    	'iTotalRecords' => $validCount,
	    	'iTotalDisplayRecords' => $filterCount,
	    	'aaSorting' => array(
	    		array(
	    			1,
					'desc',
	    		),
	    	),
	    	'aaData' => $makeArray,
	    	'aoColumns' => $headingArray,
	    ));
	    
    }
    
    public function get_validleads($data_id)
    {
	    
	    $headings = array(
	    	'Dialler ID' => 'dialler_lead_id',
	    	'Title' => 'title',
	    	'First Name' => 'first_name',
	    	'Last Name' => 'last_name',
	    	'Number' => 'phone_number',
	    	'Alt Number' => 'alt_phone',
	    	'Status' => 'current_status',
	    );
	    
	    $headingArray = array();
	    $headingCounts = array();
	    foreach ($headings as $heading=>$dbcolumn)
	    {
		    $headingCounts[] = $dbcolumn;
	    }
	    
	    
	    list($validLeads, $validCount, $filterCount) = \Data\Model_Data::get_leads($data_id, \Input::get('iDisplayLength'), \Input::get('iDisplayStart'), $headingCounts[\Input::get('iSortCol_0')], \Input::get('sSortDir_0'), '<>', \Input::get('sSearch', null));
	    	    
	    $makeArray = array();
	    foreach ($validLeads as $singleLead)
	    {
	    	$singleArray = array();
	    	foreach ($headings as $heading)
	    	{
		    	$singleArray[] = $singleLead[$heading];
	    	}
	    	$makeArray[] = $singleArray;
	    }
	    
	    
	    return $this->response(array(
	    	'iTotalRecords' => $validCount,
	    	'iTotalDisplayRecords' => $filterCount,
	    	'aaSorting' => array(
	    		array(
	    			1,
					'desc',
	    		),
	    	),
	    	'aaData' => $makeArray,
	    	'aoColumns' => $headingArray,
	    ));
	    
    }
    
    
    public function action_view($data_id=null)
    {
	    if (!is_null($data_id))
	    {
		    $listDetails = \Data\Model_Data::get_stats($data_id);
		    $oneList     = $listDetails[0];
		    
		    $basicStats  = array(
		    	'cost'       => $oneList['cost'],
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
				    	'leadDetails' => $singleLead,
				    	'number'      => $leadDetails['duplicates']['number'],
				    	'list_ids'    => $leadDetails['duplicates']['list_ids'],
				    );
			    }
			    
			    if (isset($leadDetails['tps']) && count($leadDetails['tps']) > 0)
			    {
				    $tpsNumbers[] = array(
				    	'leadDetails' => $singleLead,
				    	'number'      => $leadDetails['tps'][0],
				    );
			    }
			    
		    }
		    
		    $statusPie = \Data\Model_Data::get_statuses($data_id);
		    
		    // Turn the status results into a flot pie chart
		    $pieText = "";
		    foreach ($statusPie as $status=>$total)
		    {
			    $pieText .= '{ label: "'.$status.'",  data: '.$total.'},';
		    }

            list($lastSoftReset, $lastHardReset, $softCount, $hardCount, $allResets) = Model_Data::get_reset_dates($data_id);

		    $this->template->title = 'Statistics for List ' . $data_id;
	        $this->template->content = \View::forge('view/view', array(
	        	'listID' => $data_id,
	        	'basicStats' => $basicStats,
	        	'statuses'   => $pieText,
                'importantDates' => array(
                    'added' => $oneList['added_date'],
                    'lastSoft' => $lastSoftReset,
                    'lastHard' => $lastHardReset,
                    'softCount' => $softCount,
                    'hardCount' => $hardCount,
                    'allResets' => $allResets,
                ),
	        ), false);
		    
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
            'dialler_id' => \Input::post('listid'),
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
        
        $suppliers = \DB::select('id', 'name')->from('suppliers')->execute()->as_array();
                
        $this->template->title = 'Set Data Options';
        $this->template->content = \View::forge('add/setoptions', array(
            'dataFilename'  => $dataFilename,
            'realFilename'  => $realFilename,
            'allHeadings'   => $databaseHeadings,
            'fileHeadings'  => $fileHeadings,
            'headingsGuess' => $headingGuess,
            'suppliers'     => $suppliers,
        ));
    }

}
