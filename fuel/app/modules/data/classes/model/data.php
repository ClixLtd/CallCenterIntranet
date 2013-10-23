<?php

namespace Data;

class Model_Data
{
    
    /**
     * Return a list of data in the system.
     * 
     * @access public
     * @static
     * @param mixed $supplier_id (default: null)
     * @return void
     */
    public static function list_all($supplier_id=null, $sort=null, $limit=null, $start=0)
    {
        // Select the required fields from the data table
        $dataQuery = \DB::select('*')->from('data');
        
        // If a supplier ID has been provided only pull data from that supplier
        if (!is_null($supplier_id))
        {
            $dataQuery->where('supplier_id', '=', $supplier_id);
        }
        
        // If we wish to sort by specific field then do so
        if (!is_null($sort))
        {
            $dataQuery->order_by($sort);
        }
        
        // If we want a specific result limit then apply it
        if (!is_null($limit))
        {
            $dataQuery->limit($start, $limit);
        }
        
        // Execute the query and convert to an array
        $queryResults = $dataQuery->cached(300)->execute()->as_array();
        
        // Providing we have results, return them. If not return null
        return (is_array($queryResults) && count($queryResults) > 0) ? $queryResults : null;
    }
    
    public static function get_reset_dates($data_id)
    {
        $softResets = \DB::select('date')->from('data_reset')->where('data_id', $data_id)->where('type', 1)->execute()->as_array();
        $hardResets = \DB::select('date')->from('data_reset')->where('data_id', $data_id)->where('type', 2)->execute()->as_array();

        $allResets = \DB::select('name', 'date', 'user_id')->from('data_reset')
                        ->join('data_reset_type', 'LEFT')->on('data_reset.type', '=', 'data_reset_type.id')->where('data_id', $data_id)->execute()->as_array();

        $allResetsReturn = array();
        foreach ($allResets as $reset)
        {
            $userDetails = \Model_User::find($reset['user_id']);
            $reset['username'] = $userDetails->name;
            $allResetsReturn[] = $reset;
        }

        return array(
            $softResets[0]['date'],
            $hardResets[0]['date'],
            count($softResets),
            count($hardResets),
            $allResetsReturn,
        );

    }

    public static function get_stats($data_id=null)
    {
    
	    $dataQuery = \DB::select('*')->from('data')->where('id', $data_id);
	    
	    $queryResults = $dataQuery->cached(300)->execute()->as_array();
	    
	    return (is_array($queryResults) && count($queryResults) > 0) ? $queryResults : null;
	    
    }
    
    public static function get_invalids($data_id=null)
    {
	    $dataQuery = \DB::select('*')
	    				->from('data_dialler_copy')
	    				->join('data_holder', 'LEFT')->on('data_holder.id', '=', 'data_dialler_copy.data_lead_id')
	    				->where('data_holder.data_id', $data_id)
	    				->where('data_dialler_copy.dialler_lead_id', 0);
	    
	    $queryResults = $dataQuery->cached(21600)->execute()->as_array();  
	    
	    return (is_array($queryResults) && count($queryResults) > 0) ? $queryResults : null;
	      
    }
    
    
    public static function get_leads($data_id=null, $limit=10, $start=0, $sortCol='dialler_lead_id', $sortDirection='asc', $type='<>', $search=null)
    {
    	$countQuery = \DB::select( \DB::expr('COUNT(data_dialler_copy.current_status) AS total') )
	    				->from('data_dialler_copy')
	    				->join('data_holder', 'LEFT')->on('data_holder.id', '=', 'data_dialler_copy.data_lead_id')
	    				->where('data_holder.data_id', $data_id)
	    				->where('data_dialler_copy.dialler_lead_id', $type, 0);
	    				
		$countResults = $countQuery->cached(600)->execute()->as_array();
	    				
	    $dataQuery = \DB::select('*')
	    				->from('data_dialler_copy')
	    				->join('data_holder', 'LEFT')->on('data_holder.id', '=', 'data_dialler_copy.data_lead_id')
	    				->where('data_holder.data_id', $data_id)
	    				->where('data_dialler_copy.dialler_lead_id', $type, 0);
	    
	    if (!is_null($search) && strlen($search) >= 2)
	    {
		    $dataQuery->where_open()
		    	->where('data_dialler_copy.current_status', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.first_name', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.last_name', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.phone_number', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.alt_phone', 'LIKE', '%'.$search.'%')
		    ->where_close();
		    
		    $countQuery->where_open()
		    	->where('data_dialler_copy.current_status', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.first_name', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.last_name', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.phone_number', 'LIKE', '%'.$search.'%')
		    	->or_where('data_holder.alt_phone', 'LIKE', '%'.$search.'%')
		    ->where_close();
		    
		    $smallCount = $countQuery->cached(600)->execute()->as_array();
		    
	    }
	    else
	    {
		    $smallCount = $countResults;
	    }
		
		
		
	    $dataQuery->order_by($sortCol, $sortDirection);
	    
	    if ($limit > 0)
	    {
	    	$dataQuery->limit($limit);
	    }
	    
	    $dataQuery->offset($start);
	    
	    $queryResults = $dataQuery->cached(600)->execute()->as_array();  
	    
	    return array(
	    	$queryResults,
	    	$countResults[0]['total'],
	    	$smallCount[0]['total']
	    );
	      
    }
    
    
    public static function get_statuses($data_id=null)
    {
	    $dataResults = \DB::select('data_dialler_copy.current_status', \DB::expr('COUNT(data_dialler_copy.current_status) AS total'))
	    				  ->from('data_dialler_copy')
	    				  ->join('data_holder', 'LEFT')->on('data_holder.id', '=', 'data_dialler_copy.data_lead_id')
	    				  ->where('data_holder.data_id', $data_id)
	    				  ->where('data_dialler_copy.dialler_lead_id', '<>', 0)
	    				  ->group_by('data_dialler_copy.current_status')
	    				  ->cached(600)->execute()->as_array();  ;
	    
	    $statusCount = array();
	    foreach ($dataResults as $singleResult)
	    {
		    $statusCount[$singleResult['current_status']] = $singleResult['total'];
	    }
	    
	    return $statusCount;
	    
    }

    public static function softResetList($listID)
    {
        $listData = \DB::select('dialler_id')->from('data')->where('id', $listID)->limit(1)->execute()->as_array();

        $results = \DB::update('vicidial_list')->set(array(
            'called_since_last_reset' => 'N',
        ))->where('list_id', $listData[0]['dialler_id'])->execute('dialler');

        list($driver, $user_id) = \Auth::get_user_id();
        list($insert_id, $rows_affected) = \DB::insert('data_reset')->set(array(
            'id' => null,
            'data_id' => $listID,
            'user_id' => $user_id,
            'type' => 1,
            'date' => date('Y-m-d H:i:s'),
        ))->execute();

        return true;
    }


    /**
     * Pull all the current active lists in a campaign
     *
     * @param $campaign
     */
    public static function current_lists($campaign)
    {
        $currentLists = \DB::select('*')->from('vicidial_lists')->where('campaign_id', $campaign)->where('active', 'Y')->execute()->as_array();
        return $currentLists;
    }

    
    /**
     * Check the database for a given heading to see if we can guess the real heading.
     * 
     * @access public
     * @static
     * @param mixed $givenHeading
     * @return void
     */
    public static function heading_suggestion($givenHeading)
    {
        $headings = \DB::select('required_heading')->from('data_headings')->where('given_heading', $givenHeading)->execute()->as_array();
        if (count($headings) < 1)
        {
            return false;
        }
        else
        {
            return $headings[0]['required_heading'];
        }
    }

}
