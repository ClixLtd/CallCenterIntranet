<?php

namespace sms;

class Controller_Sms extends \Templates\Controller_Force
{
    public $_intranetVersion = 1;

    public function action_index()
    {
        print "HELLO";
        $this->template->title = "SMS System";
        $this->template->content = \View::forge('index');
    }

}