<?php
class Controller_Statistics extends Controller_Base 
{

    public function action_servers()
    {
        $this->template->title = "View Server Statistics";
		$this->template->content = View::forge('statistics/servers');
    }

}