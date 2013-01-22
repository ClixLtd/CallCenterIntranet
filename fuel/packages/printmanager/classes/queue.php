<?php

namespace Printmanager;

class Queue
{
	
	public static function add($filename, $scheduled="0000-00-00 00:00:00", $tray=1, $priority=10)
	{
		$new = Model_Printmanager_Queue::forge();
		
		$new->filename = $filename;
		$new->priority = $priority;
		$new->status = "WAITING";
		$new->scheduled = $scheduled;
		$new->tray_id = $tray;
		
		$new->save();
		
		\Log::write('PRINTMANAGER', 'Added the file '.$filename. ' to the print queue for '.$scheduled);

		
	}
	
	public static function printItem($filename, $printerName="canonsales", $tray="Tray1")
	{
	   date_default_timezone_set('Europe/London');
	   \Log::write('PRINTMANAGER', 'Now printing the file '.$filename. ' on printer named '.$printerName);
		echo exec('lpr -P '.$printerName.' -U intranet -o media='.$tray.' '.$filename);
	}
	
}