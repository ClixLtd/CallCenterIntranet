<?php

namespace Users;

class Controller_Create extends \Templates\Controller_Force
{


    
    /**
     * Display form to create a user.
     * 
     * @access public
     * @return void
     */
    public function action_index()
    {
        
        
            
        $_setParameters = array(
        
            'callCenter' => array(
                'ID' => 1,
            ),
            
            'userDetails' => array(
                'firstName' => ucfirst('simon'),
                'lastName' => ucfirst('skinner'),
                'password' => false,
            ),
            
            'permissions' => array(
            
                'goautodial' => array(
                    '1'
                ),
                
                'debtsolv' => false,
                
                'email' => array(
                    1,
                    3,
                ),
            ),
            
        );
    
        
        // We need to create a dialler user
        if ($_setParameters['permissions']['goautodial'] !== false)
        {
            
            $_goautodialDetails = Model_Create_Intranet::forge(
                $_setParameters['callCenter'],
                $_setParameters['userDetails'],
                $_setParameters['permissions']['goautodial']
            );
            
            
            
            print_r($_goautodialDetails);
        }
        
        
        
        
        
        
        $this->template->title = 'Example Page';
        $this->template->content = "hellos";
        
    }
    
    
    
    /**
     * Parse the posted form and create users.
     * 
     * @access public
     * @return void
     */
    public function post_create()
    {

        
        
    }

}