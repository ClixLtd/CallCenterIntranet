<?php

namespace Suppliers;

class Controller_Suppliers extends \Templates\Controller_Force
{
    
    public function action_index()
    {
        print "Test";
        
        
        
        $this->template->title = 'Example Page';
        $this->template->content = "hello";
    }
    
    
    public function action_list()
    {
        print "Test List";
        
        
        
        $this->template->title = 'Example Page';
        $this->template->content = "hello";
    }
    
    
    public function action_create()
    {
        print "Test List";
        
        
        
        $this->template->title = 'Example Page';
        $this->template->content = "hello";
    }
    
    
    public function action_edit()
    {
        print "Test List";
        
        
        
        $this->template->title = 'Example Page';
        $this->template->content = "hello";
    }
    
}