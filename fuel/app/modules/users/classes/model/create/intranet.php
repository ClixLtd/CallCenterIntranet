<?php

namespace Users;


/**
 * Model_Create_Intranet class.
 * 
 * @extends Model_Create
 */
class Model_Create_Intranet extends Model_Create
{
    
    
    /**
     * _intranetID
     * 
     * @var mixed
     * @access protected
     */
    protected $_intranetID;
    
    
    /**
     * Function to facilitate creating an intranet user.
     * 
     * @access protected
     * @return void
     */
    protected function create_user()
    {
        // Create the user with auth
        /* commented out till database is hooked up
        $givenID = \Auth::create_user($this->_username, $this->_password, $this->_usernameDot."@gabgroup.co.uk", 1, array(
            'firstname' => $this->_firstName,
            'lastname' => $this->_lastName,
        ));
        */
        
        $this->_intranetID = (isset($givenID)) ? $givenID : false;
        
        return $this;
    }
    
    /**
     * Function that is run when the construct is called.
     * 
     * @access public
     * @return void
     */
    public function run()
    {
        $this->create_user();
    }
    
}