<?php
/**
 * Admin Controller - Script Module
 * 
 * @author David Stansfield
 */
 
 namespace Survey;
 
 class Controller_Admin extends \Controller_BaseHybrid
 {
   public function before()
   {
     parent::before();
   }
   
   public function action_index()
   {
     $this->template->title = "Script Admin";
     $this->template->content = \View::forge('admin/index');
   }
   
   public function action_scripts()
   {
     $this->template->title = "Scripts | Script Admin";
     $this->template->content = \View::forge('admin/scripts', array(
       'scriptTypes' => Script::loadScriptTypes(),
       #'offices' => \User\Office::loadAllOffices(),
       'scriptForms' => ScriptForms::loadScriptForms(),
       'scriptFormTypes' => ScriptForms::loadScriptFormTypes(),
     ));
   }
   
   public function action_preview_script_form()
   {
     $Script = new ScriptForms(2);
    
     $this->template->title = "Scripts | Preview Script Form";
     $this->template->content = \View::forge('admin/script_form_preview', array(
       'form' => $Script->generate(),
     ));
   }
 }