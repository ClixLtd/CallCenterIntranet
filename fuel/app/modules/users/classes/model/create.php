<?php

namespace Users;

/**
 * Model to be extended to allow creation of users
 */
class Model_Create extends \Model
{
    
    protected $_callCenter;
    protected $_permissions;
    
    
    
    /**
     * choose_username function.
     * 
     * @access protected
     * @return void
     */
    protected function choose_username()
    {
        $this->_username = strtolower(substr($this->_firstName, 0, 1).substr($this->_lastName, 0, 8));
        $this->_usernameDot = strtolower(substr($this->_firstName, 0, 1).".".substr($this->_lastName, 0, 8));
        
        return $this;
    }
    
    
    
    /**
     * forge function.
     * 
     * @access public
     * @static
     * @param mixed $_callCenter (default: null)
     * @param mixed $_userDetails (default: null)
     * @param mixed $_permissions (default: null)
     * @return void
     */
    public static function forge($_callCenter=null, $_userDetails=null, $_permissions=null)
    {
        return new static($_callCenter, $_userDetails, $_permissions);
    }
    
    
    
    /**
     * __construct function.
     * 
     * @access protected
     * @param mixed $_callCenter (default: null)
     * @param mixed $_userDetails (default: null)
     * @param mixed $_permissions (default: null)
     * @return void
     */
    protected function __construct($_callCenter=null, $_userDetails=null, $_permissions=null)
    {
        if (is_null($_callCenter) || is_null($_userDetails) || is_null($_permissions))
        {
            throw new \Exception('Not all the required parameters were provided so we could create a user');
        }
        else
        {
            // Add all the call center details into the class
            $this->_callCenter  = $_callCenter;
            
            // Make sure a password has been set, if not, create one
            $_userDetails['password'] = (!isset($_userDetails['password']) || $_userDetails['password'] === false) ? \Str::random('alnum', 8) : $_userDetails['password'];
            
            // Add all the user details into the class as variables
            foreach ($_userDetails as $key => $value)
            {
                $key = "_".$key;
                $this->$key = $value;
            }
            
            // Add all the user permissions into the class
            $this->_permissions = $_permissions;
            
            // Set the username for this user
            $this->choose_username();
            
            // Run the creation function
            $this->run();
        }
    }


}