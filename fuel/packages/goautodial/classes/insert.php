<?php

	namespace Goautodial;
	
	class Insert
	{
		
		
		public static function duplicate_check($phone_number=null)
		{
			
			if (is_null($phone_number))
			{
				throw new \Exception('No lead details to check');
			}
			else
			{
				$matched_details = null;
				
				foreach (Orm::$_connection_choices AS $key => $dialler)
				{
					$check_result = \DB::select()->from("vicidial_list")->where('phone_number', 'IN', $phone_number)->execute($dialler)->as_array();
				
					foreach ($check_result AS $result)
					{
						$matched_details[$result['phone_number']]['dialler'] = $key;
						$matched_details[$result['phone_number']]['data'] = $result;
					}
					
					$check_result = \DB::select()->from("vicidial_list")->where('alt_phone', 'IN', $phone_number)->execute($dialler)->as_array();
				
					foreach ($check_result AS $result)
					{
						$matched_details[$result['alt_phone']]['dialler'] = $key;
						$matched_details[$result['alt_phone']]['data'] = $result;
					}
				
				}
				
				
				$check_result = \DB::select()->from("lead_tables")->where('phone_number', 'IN', $phone_number)->execute()->as_array();
				
				foreach ($check_result AS $result)
				{
					$matched_details[$result['phone_number']]['dialler'] = 999;
					$matched_details[$result['phone_number']]['data'] = $result;
				}
				
				$check_result = \DB::select()->from("lead_tables")->where('alt_phone', 'IN', $phone_number)->execute()->as_array();
				
				foreach ($check_result AS $result)
				{
					$matched_details[$result['alt_phone']]['dialler'] = 999;
					$matched_details[$result['alt_phone']]['data'] = $result;
				}
				
				
				return $matched_details;
				
			}
						
		}
		
		
	}