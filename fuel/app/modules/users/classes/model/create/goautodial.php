<?php

namespace Users;


/**
 * Model to handle creation of users on the dialler.
 */
class Model_Create_Goautodial extends Model_Create
{
    
    /**
     * _alias
     * 
     * @var mixed
     * @access protected
     */
    protected $_alias;
    
    
    /**
     * _allExtensions
     * 
     * (default value: array())
     * 
     * @var array
     * @access protected
     */
    protected $_allExtensions = array();
    
    
    /*************************************
     * BEGIN Functions to create details *
     *************************************/

    
    /**
     * user function.
     * 
     * @access protected
     * @return void
     */
    protected function user()
    {
        
        print "Test";
        
        return $this;
    }
    
    
    
    /**
     * extensions function.
     * 
     * @access protected
     * @return void
     */
    protected function extensions()
    {
        
        $_currentExtension = (int)$this->_alias + 10000;
        $_currentIP = '10.1.0.131';
        
        // Basic insert query
        // WIP: We will probably need to add more fields to make this work correctly
        
        /* Temporarily commented out to allow testing while not hooked up to dialler databases
        list($insertID, $rowsChanged) = \DB::insert('phones')->set(array(
            'extension' => $_currentExtension,
            'dialplan_number' => $_currentExtension,
            'voicemail_id' => $_currentExtension,
            'server_ip' => $_currentIP,
            'login' => $_currentExtension,
            'pass' => $this->_password,
            'status' => 'ACTIVE',
            'active' => 'Y',
            'fullname' => $this->_firstName . " " . $this->_lastName,
            'protocol' => 'SIP',
            'local_gmt' => '0.00',
            'conf_secret' => $this->_password,
        ))->execute();
        */
        
        // Add this extension to the list of extensions for this user
        $this->_allExtensions[] = $_currentExtension;
        
        return $this;
    }
    
    
    
    /**
     * Create an extension alias for the user in goautodial.
     * 
     * @access protected
     * @return void
     */
    protected function alias()
    {
        if (count($this->_allExtensions) > 0)
        {
            /* Temporarily commented out to allow testing while not hooked up to dialler databases
            list($insertID, $rowsChanged) = \DB::insert('phones_alias')->set(array(
                'alias_id'    => $this->_alias,
                'alias_name'  => $this->_firstName." ".$this->_lastName,
                'logins_list' => implode(",", $this->_allExtensions),
            ))->execute();
            */
        }
        else
        {
            throw new \Exception('No extensions created. Cannot create alias without extensions');
        }
        
        return $this;
    }
    
    /***********************************
     * END Functions to create details *
     ***********************************/
    
    
    
    /**************************
     * BEGIN Helper functions *
     **************************/
    
    
    /**
     * Check for the next available extension in goautodial.
     * 
     * @access protected
     * @return void
     */
    protected function getNextExtension()
    {
        return 2025;
    }
    
    
    /************************
     * END Helper functions *
     ************************/
    
    
    
    
    
    /******************************************
     * BEGIN Construst and auto run functions *
     ******************************************/
    
    /**
     * Function that is run when the construct is called.
     * 
     * @access public
     * @return void
     */
    public function run()
    {
        // Get next available extension
        $this->_alias = $this->getNextExtension();
        
        // Create the User account
        $this->user();
        
        // Create the extensions for the user
        $this->extensions();
        
        // Create the alias for the users extension
        $this->alias();
        
        return $this;
    }
    
    /****************************************
     * END Construst and auto run functions *
     ****************************************/
    
}