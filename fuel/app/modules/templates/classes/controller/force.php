<?php 

namespace Templates;

class Controller_Force extends \Controller_Hybrid
{

    public $template = "templates/layout";

    public function before()
    {
        /*
        if (\Auth::check())
        {
            parent::before();
        }
        else
        {
            \Response::redirect('auth/login');
        }
        */
        
        parent::before(); // Remove when login implemented
    }

}