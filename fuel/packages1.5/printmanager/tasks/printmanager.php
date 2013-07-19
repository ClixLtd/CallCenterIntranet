<?php

namespace Fuel\Tasks;

class Printmanager
{

	public static function run()
	{
		
		$getPrintQueue = \Printmanager\Model_Printmanager_Queue::find()->where('scheduled', '<=', date('Y-m-d H:m:s'))->where('status', 'WAITING')->get();
		
		foreach ($getPrintQueue AS $printJob)
		{
			$tray = \Printmanager\Model_Printmanager_Tray::find($printJob->tray_id);
			$printer = \Printmanager\Model_Printmanager_Printer::find($tray->printer_id);
			
			\Printmanager\Queue::printItem($printJob->filename, $printer->printer_reference, $tray->tray_name);
			
			$printJob->status = "IN PROGRESS";
			$printJob->save();
			
		}
		
		
	}

}