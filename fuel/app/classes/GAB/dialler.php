<?php

namespace GAB;

class Dialler {


	protected static $_database_connections = array();
	
	
	
	
	
	
	
	// Start functions related to creating the wallboard!
	
	protected static function get_hotkeys($startDate=null, $endDate=null)
	{
		$start_date = (!is_null($startDate)) ? $startDate : mktime(0,0,0,date("m"),date("d"),date("Y"));
		$end_date = (!is_null($endDate)) ? $endDate : $start_date;
	}
	
	
	
	// End functions related to creating the wallboard
	
	
	public static function get_list_stats($list_id, $database_id=null, $status_choices=null)
	{
		
		$database_id = (is_null($database_id)) ? 1 : $database_id;
		
		try
		{
		    $results = \Cache::get(sha1($list_id."_".$database_id."_".implode($status_choices,"_")));
		}
		catch (\CacheNotFoundException $e)
		{
		
			$list_stats = \DB::select(
				'title',
				'first_name',
				'middle_initial',
				'last_name',
				'status',
				'address1',
				'address2',
				'address3',
				'province',
				'postal_code',
				'phone_number',
				'alt_phone',
				'called_count',
				'list_id'
			)->from('vicidial_list')->where('list_id', $list_id);
			
			// Bring back specific status choices if required
			if (!is_null($status_choices))
			{
				$list_stats->where('status', 'IN', $status_choices);
			}
			
			// Pull the results in
			$results = $list_stats->execute(\Goautodial\Orm::$_connection_choices[$database_id]);
			
			\Cache::set(sha1($list_id."_".$database_id."_".implode($status_choices,"_")), $results, 3600);
		
		}
		
		return $results;
		
	}
	
	
	
	
	public static function full_list($list_array)
	{
	
		$return_array 	= null;
		
		foreach ($list_array AS $dialler_id => $lists) {
			
			
			
			$lists_implode = implode("', '", $lists);
			
			$this_result = \DB::query("
			SELECT 
				CONCAT(title, ' ', first_name, ' ', middle_initial, ' ', last_name) AS 'Full Name', status, address1, address2, address3, province, postal_code, phone_number, alt_phone, called_count, list_id
			FROM 
				vicidial_list
			WHERE 
				list_id IN ('".$lists_implode."')
				AND status IN ('TPS','POSSDC')
			ORDER BY
				list_id,
				status;
			")->cached(3600)->execute(static::connection($dialler_id))->as_array();
			
			
			foreach ($this_result AS $result)
			{
			
				$thisArray = array();
				foreach ($result AS $key => $value)
				{
					$thisArray[] = $value;	
				}
				
				$return_array[] = $thisArray;
			}
			
			$connection = null;
			
		}
		
		
		return $return_array;
		
	}
	
	
	
	
	
	
	public static function conversion_chart($list_array)
	{
		
		$return_array 	= null;
		foreach ($list_array AS $dialler_id => $lists) {
			$lists_implode = implode("', '", $lists);
			
			$this_result = \DB::query("
			SELECT
				DATE(call_date) AS 'Date',
				list_id AS 'List',
				IFNULL(COUNT(CASE WHEN status IN ('SALE','DMPLUS') THEN lead_id END),0) AS 'Sales',
				IFNULL(COUNT(CASE WHEN (status IN ('3RDPAR','BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') ) then lead_id END),0) AS 'Answers'
			FROM
				vicidial_log
			WHERE
				list_id IN ('".$lists_implode."')
			GROUP BY
				DATE(call_date),
				list_id
			HAVING
				Answers > 50;
			")->cached(900)->execute(static::connection($dialler_id));
			
			$return_array[$dialler_id] = $this_result->as_array();
			$connection = null;

		}
		
		
		$all_conversions = array();
		
		
		
		
		foreach ($return_array AS $dialler=>$results)
		{
			foreach ($results AS $single)
			{
				if ((int)$single['List'] > 50000)
				{
					$single['List'] = (int)$single['List'] - 50000;
				} 
				else if ((int)$single['List'] > 30000)
				{
					$single['List'] = (int)$single['List'] - 30000;
				}
				
				if ( isset($all_conversions[$single['Date']][$single['List']]['Sales']) )
				{
					$all_conversions[$single['Date']][$single['List']] = array(
						'Sales'    =>  $all_conversions[$single['Date']][$single['List']]['Sales'] + $single['Sales'], 
						'Answers'  =>  $all_conversions[$single['Date']][$single['List']]['Answers'] + $single['Answers'],
					);
				} 
				else 
				{
					$all_conversions[$single['Date']][$single['List']] = array('Sales'=>$single['Sales'], 'Answers'=>$single['Answers']);
				}
				
				
			}
			
		}
		
		$return_conversions = array();
		
		foreach ($all_conversions AS $date=>$details)
		{
			$total_answers = 0;
			$total_sales = 0;
			foreach ($details AS $list=>$details)
			{
				$total_answers = $total_answers + $details['Answers'];
				$total_sales = $total_sales + $details['Sales'];
				
				if ($details['Answers'] > 0)
				{
					$return_conversions[$list][$date] = number_format( (($details['Sales'] / $details['Answers'])*100) , 2);
				}
				else
				{
					$return_conversions[$list][$date]['Conversion'] = 0;
				}
			}
			
			
		}
		
		
		return $return_conversions;
		
	}
	
	
	
	
	
	/**
	 * Query to get common report statistics from a given array of dialler lists IDs.
	 * 
	 * @access public
	 * @static
	 * @param mixed $list_array
	 * @param mixed $sort_by (default: null)
	 * @return void
	 */
	public static function list_stats($list_array, $sort_by=null)
	{
		$return_array 	= null;
		$sorted_by_list = null;
		foreach ($list_array AS $dialler_id => $lists) {
			
			$lists_implode = implode("', '", $lists);
			
			$this_result = \DB::query("
			SELECT 
				VLo.list_id AS 'List ID',
				VLi.list_description AS 'List Reference', 
				IFNULL(COUNT(CASE WHEN (VLo.status IN ('3RDPAR','BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') ) then VLo.lead_id END),0) AS 'Spoken To',
				IFNULL(COUNT(CASE WHEN (VLo.status='POSSDC') then VLo.lead_id END),0) AS 'Disconnected',
				IFNULL(COUNT(CASE WHEN (VLo.status='TPS') then VLo.lead_id END),0) AS 'TPS',
				IFNULL((SELECT count(uniqueid) AS Referrals FROM vicidial_log WHERE list_id=VLo.list_id AND status='SALE'),0) AS 'Referrals',
				IFNULL((SELECT count(uniqueid) AS Referrals FROM vicidial_log WHERE list_id=VLo.list_id AND status IN ('PPI','PPIREF')),0) AS 'PPI Referrals',
				count(VLo.lead_id) - IFNULL(COUNT(CASE WHEN (VLo.status='POSSDC') then VLo.lead_id END),0) - IFNULL(COUNT(CASE WHEN (VLo.status='TPS') then VLo.lead_id END),0) AS 'Dialable Leads'
			FROM 
				vicidial_list AS VLo
			LEFT JOIN
				vicidial_lists AS VLi ON VLo.list_id=VLi.list_id
			WHERE 
				VLo.list_id IN ('".$lists_implode."')
			GROUP BY 
				VLo.list_id
			ORDER BY
				VLo.list_id ASC;
			")->cached(900)->execute(static::connection($dialler_id));
			
			$return_array[$dialler_id] = $this_result->as_array();
			$connection = null;
		}
		
		if (is_null($sort_by)) 
		{
			// Sort by list name and combine
			
			
			foreach ($return_array AS $server => $results) 
			{
				
				foreach ($results AS $single_list)
				{
					
					$dupes = \Model_Data_Supplier_Campaign_Lists_Duplicate::find()->where('database_server_id',$server)->where('list_id',$single_list['List ID']);
					
					if ( isset($sorted_by_list[$single_list['List Reference']]) )
					{
						$sorted_by_list[$single_list['List Reference']]['Spoken To'] = $sorted_by_list[$single_list['List Reference']]['Spoken To'] + $single_list['Spoken To'];
						//$sorted_by_list[$single_list['List Reference']]['Dialled'] = $sorted_by_list[$single_list['List Reference']]['Dialled'] + $single_list['Dialled'];
						$sorted_by_list[$single_list['List Reference']]['Disconnected'] = $sorted_by_list[$single_list['List Reference']]['Disconnected'] + $single_list['Disconnected'];
						$sorted_by_list[$single_list['List Reference']]['TPS'] = $sorted_by_list[$single_list['List Reference']]['TPS'] + $single_list['TPS'];
						$sorted_by_list[$single_list['List Reference']]['Referrals'] = $sorted_by_list[$single_list['List Reference']]['Referrals'] + $single_list['Referrals'];
						$sorted_by_list[$single_list['List Reference']]['PPI Referrals'] = $sorted_by_list[$single_list['List Reference']]['PPI Referrals'] + $single_list['PPI Referrals'];
						$sorted_by_list[$single_list['List Reference']]['Duplicates'] = $sorted_by_list[$single_list['List Reference']]['Duplicates'] + $dupes->count();
						$sorted_by_list[$single_list['List Reference']]['Dialable Leads'] = $sorted_by_list[$single_list['List Reference']]['Dialable Leads'] + $single_list['Dialable Leads'];
					}
					else
					{
						$sorted_by_list[$single_list['List Reference']]['List ID'] = $single_list['List ID'];
						$sorted_by_list[$single_list['List Reference']]['List Reference'] = $single_list['List Reference'];
						$sorted_by_list[$single_list['List Reference']]['Dialable Leads'] = $single_list['Dialable Leads'];
						$sorted_by_list[$single_list['List Reference']]['Spoken To'] = $single_list['Spoken To'];
						$sorted_by_list[$single_list['List Reference']]['Referrals'] = $single_list['Referrals'];
						$sorted_by_list[$single_list['List Reference']]['PPI Referrals'] = $single_list['PPI Referrals'];
						
						//$sorted_by_list[$single_list['List Reference']]['Dialled'] = $single_list['Dialled'];
						$sorted_by_list[$single_list['List Reference']]['Disconnected'] = $single_list['Disconnected'];
						$sorted_by_list[$single_list['List Reference']]['TPS'] = $single_list['TPS'];
						$sorted_by_list[$single_list['List Reference']]['Duplicates'] = $dupes->count();
					}
					
					
					
					
				}
				
			}
			
			foreach ($sorted_by_list AS $list_id => $details)
			{
				$sorted_by_list[$list_id]['Conversion Ratio'] = ((int)$sorted_by_list[$list_id]['Spoken To'] > 0) ? number_format((( $sorted_by_list[$list_id]['Referrals'] / $sorted_by_list[$list_id]['Spoken To'] ) * 100),2)."%" : "0%";
			}
			
				
		}
		
		
		
		
		
		
		return (is_null($sorted_by_list)) ? $return_array : $sorted_by_list;
		
	}
	
	
	
	
	
	
	
	/**
	 * Basic dialler functions
	 */
	
	
	
	/**
	 * Returns a database connection to the required database server from the database server Model.
	 * 
	 * @access public
	 * @static
	 * @param mixed $server_id
	 * @return void
	 */
	public static function connection($server_id)
	{
	
		if (!isset(static::$_database_connections[$server_id])) {
			
			$database_query = \Model_Database_Server::find($server_id);
			
			$config = array(
				'type'       => 'pdo',
				'connection' => array(
					'dsn'            => ( ($database_query->type == 'mysql') ? 'mysql' : 'dblib' ).':host='.$database_query->hostname.( ($database_query->type == 'mysql') ? ';port=' : ':' ).$database_query->port.';dbname=asterisk',
			        'username'       => ($database_query->username == '') ? $database_query->username : $database_query->username,
			        'password'       => ($database_query->password == '') ? $database_query->password : $database_query->password,
			        'persistent'     => false,
				),
				'Identifier'  => '' ,
				'Charset'    => ''
			);
			
			static::$_database_connections[$server_id] = \Database_Connection::instance('runQuery'.$database_query->hostname, $config);
		
		}
		
		return static::$_database_connections[$server_id];
		
	}
	
	
	/**
	 * Initialisation function for the GAB Dialler class.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function _init()
	{
	
		
	
	}


}