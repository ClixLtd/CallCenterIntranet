<?php

namespace PPIApi;

class PPI
{

	public static function check_api_key($key)
	{
		$keyDetails = \Model_Api_User::find()->where('key', $key)->where('status', 'active');
		if ($keyDetails->count() > 0)
		{
			$apiDetails = $keyDetails->get_one();
			$ipAddresses = explode("/", $apiDetails->ip);
			
			if (in_array('0.0.0.0', $ipAddresses))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;	
		}
	}

	public static function client_type($questionArray=null)
	{
		
		return $questionArray;
	
	}

	public static function save()
	{
		return array(
			'SAVED' => 'TRUE',
			'NAME' => 'Simon',
		);
	}

}