<?php

namespace Messaging;

class Controller_Display extends \Templates\Controller_Force
{

    public $_intranetVersion = 1;

    public function action_index()
    {
        $this->template->title = 'Messaging';
        $this->template->content = \View::forge('display');
    }

}