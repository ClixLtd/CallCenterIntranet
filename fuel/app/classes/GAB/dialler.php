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
	
	
	
	
	public static function full_list($list_array)
	{
		$return_array 	= null;
		
		foreach ($list_array AS $dialler_id => $lists) {
		
			$lists_implode = implode("', '", $lists);
			
			$this_result = \DB::query("
			SELECT 
				CONCAT(title, ' ', first_name, ' ', middle_initial, ' ', last_name) AS 'Full Name', status, address1, address2, address3, city, state, province, postal_code, phone_number, alt_phone
			FROM 
				vicidial_list
			WHERE 
				list_id IN ('".$lists_implode."');
			")->cached(900)->execute(static::connection($dialler_id));
			
			foreach ($this_result AS $result)
			{
				$return_array[] = $result;
			}
			
			$connection = null;
			
		}
		
		
		return $return_array;
		
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
				VLi.list_description AS 'List Reference',
				IFNULL(COUNT(CASE WHEN (VLo.status IN ('3RDPAR','BNKRPT','BUSINE','CCJ','CHDB','CREDRA','DECEAS','DIEXCO','DMPLUS','EXISCL','HUNGUP','IVA','NODEBT','NOINDM','NOTAFF','NSTRUG','PPI','SECDBT','WRNAME','CALLBK','CBHOLD','DNC','NI','NP','PPIREF','SALE') ) then VLo.lead_id END),0) AS 'Spoken To',
				IFNULL(COUNT(CASE WHEN (VLo.status<>'NEW') then VLo.lead_id END),0) AS 'Dialled',
				IFNULL(COUNT(CASE WHEN (VLo.status='POSSDC') then VLo.lead_id END),0) AS 'Disconnected',
				IFNULL(COUNT(CASE WHEN (VLo.status='TPS') then VLo.lead_id END),0) AS 'TPS',
				IFNULL(COUNT(CASE WHEN (VLo.status='SALE') then VLo.lead_id END),0) AS 'Referrals',
				IFNULL(COUNT(CASE WHEN (VLo.status IN ('PPI','PPIREF')) then VLo.lead_id END),0) AS 'PPI Referrals',
				count(VLo.lead_id) AS 'Total Leads',
				VLo.list_id AS 'List ID'
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
				
					if ( isset($sorted_by_list[$single_list['List Reference']]) )
					{
						$sorted_by_list[$single_list['List Reference']]['Spoken To'] = $sorted_by_list[$single_list['List Reference']]['Spoken To'] + $single_list['Spoken To'];
						$sorted_by_list[$single_list['List Reference']]['Dialled'] = $sorted_by_list[$single_list['List Reference']]['Dialled'] + $single_list['Dialled'];
						$sorted_by_list[$single_list['List Reference']]['Disconnected'] = $sorted_by_list[$single_list['List Reference']]['Disconnected'] + $single_list['Disconnected'];
						$sorted_by_list[$single_list['List Reference']]['TPS'] = $sorted_by_list[$single_list['List Reference']]['TPS'] + $single_list['TPS'];
						$sorted_by_list[$single_list['List Reference']]['Referrals'] = $sorted_by_list[$single_list['List Reference']]['Referrals'] + $single_list['Referrals'];
						$sorted_by_list[$single_list['List Reference']]['PPI Referrals'] = $sorted_by_list[$single_list['List Reference']]['PPI Referrals'] + $single_list['PPI Referrals'];
						$sorted_by_list[$single_list['List Reference']]['Total Leads'] = $sorted_by_list[$single_list['List Reference']]['Total Leads'] + $single_list['Total Leads'];
					}
					else
					{
						$sorted_by_list[$single_list['List Reference']]['List Reference'] = $single_list['List Reference'];
						$sorted_by_list[$single_list['List Reference']]['Spoken To'] = $single_list['Spoken To'];
						$sorted_by_list[$single_list['List Reference']]['Dialled'] = $single_list['Dialled'];
						$sorted_by_list[$single_list['List Reference']]['Disconnected'] = $single_list['Disconnected'];
						$sorted_by_list[$single_list['List Reference']]['TPS'] = $single_list['TPS'];
						$sorted_by_list[$single_list['List Reference']]['Referrals'] = $single_list['Referrals'];
						$sorted_by_list[$single_list['List Reference']]['PPI Referrals'] = $single_list['PPI Referrals'];
						$sorted_by_list[$single_list['List Reference']]['Total Leads'] = $single_list['Total Leads'];
						$sorted_by_list[$single_list['List Reference']]['List ID'] = $single_list['List ID'];
					}
				}
				
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