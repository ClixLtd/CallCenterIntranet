<?php

	namespace Goautodial;
	
	class Orm extends \Orm\Model
	{
		
		
		
		
		protected static $_connection = 'gabdialler';
		
		public static $_connection_choices = array(
			1 => 'gabdialler',
			2 => 'resolvedialler',
			4 => 'rj5',
		);
		
		
		public static function find($id = null, array $options = array(), $dialler=null)
		{
			if (!is_null($dialler))
			{
				self::$_connection = $dialler;
			}
			
			
			return parent::find($id, $options);
			
		}
			
	}