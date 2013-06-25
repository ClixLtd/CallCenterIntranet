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
        $allData = \Data\Model_Data::list_all($supplier_id);
        
        print_r($allData);
        
        $this->template->title = 'Listing all Data';
        $this->template->content = "hello";
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
                'last_name' => 'Surname',
                'address1' => 'Address 1',
                'address2' => 'Address 2',
                'address3' => 'Address 3',
                'city' => 'City',
                'state' => 'State',
                'province' => 'Province',
                'postal_code' => 'Post Code',
                'gender' => 'Gender',
                'phone_number' => 'Phone Number',
                'alt_phone' => 'Alternate Phone',
                'email' => 'E-Mail',
                'date_of_birth' => 'Date of Birth',
                'comments' => 'Comments',
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
            'dataFilename' => $dataFilename,
            'allHeadings' => $databaseHeadings,
            'fileHeadings' => $fileHeadings,
            'headingsGuess' => $headingGuess,
        ));
    }

}