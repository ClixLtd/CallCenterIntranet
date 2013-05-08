<?php

class Controller_Sms extends Controller_Rest
{
    public function post_send()
    {
    
        if ( is_null(Input::post('to')) || (string)substr(Input::post('to'), 0, 2) != "07" )
        {
            return $this->response(array(
                'status' => 'FAIL',
                'message' => 'No valid mobile phone number was given. Please correct this and try again.',
            ));
        }
    
        if ( strlen(Input::post('body')) > 612 )
        {
            return $this->response(array(
                'status' => 'FAIL',
                'message' => 'Message was too long, please make sure it is less than 612 characters long.',
            ));
        }
    
        $sms = SMS::forge();
        $sms->to(Input::post('to'));
        $sms->from(Input::post('from'));
        $sms->body(Input::post('body'));
        $sms->send();
        
        return $this->response(array(
            'status' => 'SUCCESS',
            'message' => 'Message has been sent to '. Input::post('to') .'.',
        ));
        
    }	
}