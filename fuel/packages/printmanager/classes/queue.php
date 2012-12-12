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
	}
	
	public static function printItem($filename, $printerName="canonsales", $tray="Tray1")
	{
		echo exec('lpr -P '.$printerName.' -U intranet -o media='.$tray.' '.$filename);
	}
	
}