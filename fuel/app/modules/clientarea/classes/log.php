<?php
/**
 * Log Class - Client Area
 * 
 * @author David Stansfield
 */
 
 namespace Clientarea;
 
 class Log
 {
   public static function write($typeID = 0, $data = '')
   {
     if($data != '')
       $data = serialize($data);
       
     Model_Intranet::writeLog($typeID, $data);
   }
 }