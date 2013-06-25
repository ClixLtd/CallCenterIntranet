<?php

namespace Data;

class Source
{
    
    const      LOAD             = 'load';
    const      IMPORT           = 'import';
    const      COPY             = 'copy';
    const      CREATE           = 'create';
    
    const      DUPES            = 'dupes';
    const      TPS              = 'tps';
    const      OPTIN            = 'optin';
    
    public     $id              = null;
    protected  $filename        = null;
    protected  $definitions     = null;
    protected  $importOptions   = null;
    protected  $status          = null;
    protected  $listID          = null;
    
    protected  $purchased_leads = null;
    protected  $duplicates      = null;
    protected  $tps             = null;
    protected  $dialable_leads  = null;
               
    protected  $added_date      = null;
    protected  $import_date     = null;
    protected  $copied_date     = null;
    protected  $completion_date = null;
    
    
    /* Statii
     * 1 - Uploaded
     * 2 - Importing - Importing into intranet tables
     * 3 - Imported  - Completed intranet import, ready to copy
     * 4 - Copying   - Copying into dialler tables
     * 5 - Copied    - Complete copying into dialler tables
     * 6 - Completed - Import process complete
     */
    
    
    
    
    // Helper functions
    private function checkTelephone($number)
    {
        
        return $number;
    }
    
    private function checkEmail($address)
    {
        
        return $address;
    }
    
    private function checkPostcode($postcode)
    {
        
        return $postcode;
    }
    
    private function checkDuplicate($numbers)
    {
        
        $returnNumbers = array();
        $duplicateNumbers = array();
        
        
        foreach ($numbers as $number)
        {
            if ($number > 0)
            {
                // First check the intranet database
                $numberResult = \DB::select('id','data_id')->from('data_holder')->where('data_id', '!=', $this->id)->where_open()
                    ->where('phone_number', $number)
                    ->or_where('alt_phone', $number)
                ->where_close()->execute()->as_array();
                
                if (count($numberResult) > 0)
                {
                    $listIDs = array();
                    foreach ($numberResult as $nr)
                    {
                        $listIDs[] = $nr['data_id'];
                    }
                    
                    $duplicateNumbers = array(
                        'number' => $number,
                        'data_list_ids' => $listIDs,
                    );
                }
                else
                {
                    // As backup, check the dialler database
                    
                    $diallerResult = \DB::select('list_id')->from('vicidial_list')->where('phone_number', $number)->or_where('alt_phone', $number)->execute('dialler')->as_array();
                    
                    if (count($diallerResult) > 0)
                    {
                        $listIDs = array();
                        foreach ($diallerResult as $nr)
                        {
                            $listIDs[] = $nr['list_id'];
                            
                            $duplicateNumbers = array(
                                'number' => $number,
                                'list_ids' => $listIDs,
                            );
                        }
                    }
                    else
                    {
                        // This shouldn't be a duplicate
                        $returnNumbers[] = $number;
                    }
                    
                }
            }
            
        }
        
        sort($returnNumbers);
        
        return array($returnNumbers, $duplicateNumbers);
    }
    
    private function checkTps($numbers)
    {
        $returnNumbers = array();
        $tpsNumbers = array();
        foreach ($numbers as $number)
        {
            if ($number > 0)
            {
                $numberResult = \DB::select('number')->from('tps')->where('number', $number)->execute()->as_array();
                if (count($numberResult) > 0)
                {
                    $tpsNumbers[] = $number;
                }
                else
                {
                    $returnNumbers[] = $number;
                }
            }
        }
        
        sort($returnNumbers);
        
        return array($returnNumbers,$tpsNumbers);
    }
    
    
    
    /**
     * Copys the imported data into the dialler.
     * 
     * @access protected
     * @return void
     */
    protected function _copy()
    {
        switch($this->status)
        {
            case null:
                throw new \Exception('No status could be loaded for this data.');
                break;
            case 1:
                throw new \Exception("This has not yet been imported.");
                break;
            case 2:
                throw new \Exception("This data is currently being imported.");
                break;
            case 4:
                throw new \Exception("This data is currently copying to the dialler.");
                break;
            case 5:
                throw new \Exception("This data has already been copied to the dialler.");
                break;
            case 6:
                throw new \Exception("This data has already been copied to the dialler.");
                break;
        }
        
        // Update the data database so we know we are copying this currently
        \DB::update('data')->set(array(
            'import_status' => 4,
        ))->where('id', $this->id)->execute();
        
        $dateNow = date('Y-m-d H:i:s');
        
        // Get a list of all lead IDs and Numbers from this data set
        $allDataArray = \DB::select('id','phone_number','alt_phone')->from('data_holder')->where('data_id', $this->id)->execute()->as_array();
        
        $allDuplicates = 0;
        $allTps = 0;
        $inserted = 0;
        foreach ($allDataArray as $singleData)
        {
            $telephoneNumbers = array(
                $singleData['phone_number'],
                $singleData['alt_phone'],
            );
            
            $isDuplicate = false;
            $isTps       = false;
            
            $duplicateNumbers = array();
            $tpsNumbers = array();
            
            // Check the numbers for duplicates
            if (count($telephoneNumbers) > 0)
            {
                list($telephoneNumbers,$duplicateNumbers) = $this->checkDuplicate($telephoneNumbers);
                $isDuplicate = (count($telephoneNumbers) > 0) ? false : true;
            }
            
            // Check the Number for TPS
            if (!in_array(\Data\Source::OPTIN, (array)$this->importOptions) && count($telephoneNumbers) > 0)
            {
                list($telephoneNumbers,$tpsNumbers) = $this->checkTps($telephoneNumbers);
                $isTps = (count($telephoneNumbers) > 0) ? false : true;
            }
            
            $dialler_lead_id = 0;
            
            // Insert None Duplicate numbers into the dialler
            if (!$isDuplicate && !$isTps)
            {
                $leadData = \DB::select('*')->from('data_holder')->where('id', $singleData['id'])->execute()->as_array();
                $singleData = $leadData[0];
                
                $diallerDetails = array(
                    'lead_id'                 => null,
                    'entry_date'              => $dateNow,
                    'modify_date'             => $dateNow,
                    'status'                  => 'NEW',
                    'user'                    => '',
                    'vendor_lead_code'        => '',
                    'source_id'               => '',
                    'list_id'                 => $this->listID,
                    'gmt_offset_now'          => '0.00',
                    'called_since_last_reset' => 'N',
                    'phone_code'              => '1',
                    'phone_number'            => $telephoneNumbers[0],
                    'title'                   => $singleData['title'],
                    'first_name'              => $singleData['first_name'],
                    'middle_initial'          => $singleData['middle_initial'],
                    'last_name'               => $singleData['last_name'],
                    'address1'                => $singleData['address1'],
                    'address2'                => $singleData['address2'],
                    'address3'                => $singleData['address3'],
                    'city'                    => $singleData['city'],
                    'state'                   => $singleData['state'],
                    'province'                => $singleData['province'],
                    'postal_code'             => $singleData['postal_code'],
                    'country_code'            => '',
                    'gender'                  => $singleData['gender'],
                    'date_of_birth'           => $singleData['date_of_birth'],
                    'alt_phone'               => isset($telephoneNumbers[1]) ? $telephoneNumbers[1] : '',
                    'email'                   => $singleData['email'],
                    'security_phrase'         => '',
                    'comments'                => $singleData['comments'],
                    'called_count'            => 0,
                    'last_local_call_time'    => '2008-01-01 00:00:00',
                    'rank'                    => 0,
                    'owner'                   => '',
                    'entry_list_id'           => '',
                );
                
                
                list($dialler_lead_id, $rows_affected) = \DB::insert('vicidial_list')->set($diallerDetails)->execute('dialler');
                
                $inserted++;
                
                // If we are in CLI mode then write to CLI every 1000 leads
                if (\Fuel::$is_cli && ($inserted==0 || ($inserted)%1000 == 0) )
                {
                    \Cli::write($inserted . ' leads copied.');
                }
            
            }
            else
            {
                if ($isDuplicate)
                {
                    $allDuplicates++;
                }
                
                if ($isTps)
                {
                    $allTps++;
                }
            }
                
            list($insert_id, $rows_affected) = \DB::insert('data_dialler_copy')->set(array(
                'id'              => 'null',
                'data_lead_id'    => $singleData['id'],
                'dialler_lead_id' => $dialler_lead_id,
                'number_data'     => serialize(array(
                    'duplicates'  => $duplicateNumbers,
                    'tps'         => $tpsNumbers,
                )),
            ))->execute();
            

        }
        
        // If we are in CLI mode then write to CLI every 1000 leads
        if (\Fuel::$is_cli) \Cli::write($inserted . ' leads copied to the dialler.');
        
        // Update the status of this list and add dupes and tps count
        \DB::update('data')->set(array(
            'import_status'  => 5,
            'duplicates'     => $allDuplicates,
            'tps'            => $allTps,
            'dialable_leads' => $inserted,
            'copied_date' => date('Y-m-d H:i:s'),
        ))->where('id', $this->id)->execute();
        
        $this->_complete();
        
    }
    
    
    /**
     * Imports the data from the CSV into the intranet data table.
     * 
     * @access protected
     * @return void
     */
    protected function _import()
    {
        switch($this->status)
        {
            case null:
                throw new \Exception('No status could be loaded for this data.');
                break;
            case 2:
                throw new \Exception("This data is currently being imported.");
                break;
            case 3:
                throw new \Exception("This data has already been imported.");
                break;
            case 4:
                throw new \Exception("This data is currently copying to the dialler.");
                break;
            case 5:
                throw new \Exception("This data has already been copied to the dialler.");
                break;
            case 6:
                throw new \Exception("This data has already been copied to the dialler.");
                break;
        }
        
        // Update the data database so we know we are importing this currently
        \DB::update('data')->set(array(
            'import_status' => 2,
        ))->where('id', $this->id)->execute();
        
        // Convert it to an array
        $allDataArray = \Format::forge(\File::read(DOCROOT."public/uploads/data/".$this->filename, true), 'csv')->to_array();
        
        //print_r($allDataArray);
        
        // Loop through all the data and add it to the intranet
        $dataCount = 0;
        foreach ($allDataArray as $singleData)
        {
            // Set default values for the import
            $setArray = array(
                'id'             => 'null',
                'data_id'        => (int)$this->id,
            );
            
            // Loop through the file headers and process them accordingly
            foreach ($this->definitions as $database => $header)
            {
                if (!is_null($header))
                {
                    $saveValue = $singleData[$header];
                    
                    // For certain values we need to handle them in special ways
                    switch($database)
                    {
                        case 'date_of_birth':
                            $saveValue = date('Y-m-d', strtotime($saveValue));
                            break;
                        case 'postal_code':
                            $saveValue = $this->checkPostcode($saveValue);
                            break;
                        case 'phone_number':
                            $saveValue = $this->checkTelephone($saveValue);
                            break;
                        case 'alt_phone':
                            $saveValue = $this->checkTelephone($saveValue);
                            break;
                        case 'email':
                            $saveValue = $this->checkEmail($saveValue);
                            break;
                    }
                    
                    // Put the finished value into the total array
                    $setArray[$database] = $saveValue;
                }
            }
            
            // Increment to data count and add data to the database
            $dataCount++;
            list($insert_id, $rows_affected) = \DB::insert('data_holder')->set($setArray)->execute();
            
            // If we are in CLI mode then write to CLI every 1000 leads
            if (\Fuel::$is_cli && ($dataCount==0 || ($dataCount)%1000 == 0) )
            {
                \Cli::write($dataCount . ' leads imported.');
            }
            
        }
        
        
        if (\Fuel::$is_cli)
        {
            \Cli::write($dataCount . ' leads imported in total.');
        }
        
        // Update the data table with the data count and new status
        \DB::update('data')->set(array(
            'import_status' => 3,
            'purchased_leads' => $dataCount,
            'import_date' => date('Y-m-d H:i:s'),
        ))->where('id', $this->id)->execute();
        
        
    }
    
    public function complete()
    {
        $this->_complete();
    }
    
    protected function _complete()
    {
        $this->_load();
        
        // E-Mail Managers with new campaign lists
		$email = \Email::forge();
		
		$email->from('noreply@expertmoneysolutions.co.uk', 'Expert Money Solutions');
		
		$email->to(array(
			's.skinner@expertmoneysolutions.co.uk'  => 'Data Updates',
		));
		
		$email->priority(\Email::P_HIGH);
		
		$email->subject('New Data Set Imported');
		
		$email->html_body(\View::forge('emails/importcomplete', array(
		    'supplierName' => "Simon Skinner",
		    'addedDate' => date("d/m/Y", strtotime($this->added_date)),
		    'listID' => $this->listID,
		    'leadsPurchased' => $this->purchased_leads,
		    'duplicates' => $this->duplicates,
		    'tps' => $this->tps,
		    'dialableLeads' => $this->dialable_leads,
		    'dataID' => $this->id,
		)));
		
		$email->send();
    
        
        \DB::update('data')->set(array(
            'import_status' => 6,
            'completion_date' => date('Y-m-d H:i:s'),
        ))->where('id', $this->id)->execute();
    }
    
    
    
    /**
     * Create a new data source.
     * 
     * @access protected
     * @return void
     */
    protected function _create($details)
    {
        list($insert_id, $rows_affected) = \DB::insert('data')->set(array(
            'id'             => 'null',
            'supplier_id'    => $details['supplier_id'],
            'dialler_id'     => $details['dialler_id'],
            'import_status'  => 1,
            'headers'        => serialize($details['headers']),
            'import_options' => serialize($details['import_options']),
            'filename'       => $details['filename'],
            'cost'           => $details['cost'],
            'added_date'     => date('Y-m-d H:i:s'),
        ))->execute();
        
        $this->id = $insert_id;
    }
    
    
    /**
     * Load data for the given ID.
     * 
     * @access protected
     * @return void
     */
    protected function _load()
    {
        $result = \DB::select('*')->from('data')->where('id', $this->id)->as_object()->execute();
        
        if (count($result) < 1)
        {
            throw new \Exception("No database entry for data set with the ID : ".$this->id);
        }
        
        $this->filename        = $result[0]->filename;
        $this->status          = $result[0]->import_status;
        $this->listID          = $result[0]->dialler_id;
        $this->definitions     = (@unserialize(trim($result[0]->headers)) !== false) ? unserialize(trim($result[0]->headers)) : null;
        $this->importOptions   = (@unserialize(trim($result[0]->import_options)) !== false) ? unserialize(trim($result[0]->import_options)) : null;
        
        // Load the required stats
        
        $this->purchased_leads = $result[0]->purchased_leads;
        $this->duplicates      = $result[0]->duplicates;
        $this->tps             = $result[0]->tps;
        $this->dialable_leads  = $result[0]->dialable_leads;
        
        
        // Load the required dates
        $this->added_date      = $result[0]->added_date;
        $this->import_date     = $result[0]->import_date;
        $this->copied_date     = $result[0]->copied_date;
        $this->completion_date = $result[0]->completion_date;
        
        
        return $this;
        
    }
    
    
    /***********************
     * Construct Variables */
    
    public static function forge($function=null, $id=null)
    {
        return new static($function, $id);
    }
    
    public function __construct($function=null, $id=null)
    {
        
	    ini_set('memory_limit','-1');
	    
        if (is_null($function) || is_null($id))
        {
            throw new \Exception("Run function or data ID not specified.");
        }
        
        // Put the id of tha data into the object
        $this->id = $id;
        
        // Run the requested functions
        if ($function == \Data\Source::LOAD)
        {
            $this->_load();
        }
        else if ($function == \Data\Source::IMPORT)
        {
            $this->_load();
            $this->_import();
        }
        else if ($function == \Data\Source::COPY)
        {
            $this->_load();
            $this->_copy();
        }
        else if ($function == \Data\Source::CREATE)
        {
            $this->_create($id);
            $this->_load();
        }
        
    }
    
    
}