<?php

	namespace Goautodial;
	
	class Wallboard
	{
		
		
		
		public static function test()
		{
			$get_sales = Model_Vicidial_List::find()->where('status', 'SALE')->where('list_id', '145')->limit(10,10)->get();
			
			
			foreach ($get_sales AS $sale)
			{
				foreach($sale->logs AS $log)
				{
					print $log->phone_number;
				}
			}
			
		}
		
	}