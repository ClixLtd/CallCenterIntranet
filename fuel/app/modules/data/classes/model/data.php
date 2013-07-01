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
    
    
    public static function get_stats($data_id=null)
    {
    
	    $dataQuery = \DB::select('*')->from('data')->where('id', $data_id);
	    
	    $queryResults = $dataQuery->cached(300)->execute()->as_array();
	    
	    return (is_array($queryResults) && count($queryResults) > 0) ? $queryResults : null;
	    
    }
    
    public static function get_invalids($data_id=null)
    {
	    $dataQuery = \DB::select('*')->from('data_dialler_copy')->where('data_lead_id', $data_id)->where('dialler_lead_id', 0);
	    
	    $queryResults = $dataQuery->cached(21600)->execute()->as_array();  
	    
	    return (is_array($queryResults) && count($queryResults) > 0) ? $queryResults : null;
	      
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