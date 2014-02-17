<?php
 namespace Clientarea;
 
 class Json
 {
   public static function output($status = 'success', $message = '', $data = array())
   {
     $output = (object) array('status'  => $status,
                              'message' => $message,
                              'data'    => $data
                             );
                             
     $response = \Request::active()->controller_instance->response;
     
     if(\Input::is_ajax())
     {
       $response->set_header('Content-type', 'application/json');
     }
     
     return $response->body(json_encode($output));
   }
   
   /**
    * Return a simple success message
    * 
    * @author David Stansfield
    * @return output method
    **/
   public static function success($message = '')
   {
     return static::output('success', $message);
   }
 }