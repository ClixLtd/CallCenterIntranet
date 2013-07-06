<?php
/**
 * HR Module
 * 
 * @author David Stansfield
 */
 
 namespace Hr;
 
 class Controller_Hr extends \Controller_BaseHybrid
 {
   public function action_index()
   {
     $this->template->title = 'Home | Human Resources';
     $this->template->content = \View::forge('index');
   }
 }
?>