<?php

namespace Fuel\Tasks;

class Data
{
    
    const       SIMULLISTS      = 3;




	public static function run()
	{
	    
	    // Check if we are over the copy or import limit
	    if (!Data::canAct())
	    {
	        // Too many copying or importing to continue so stop
	        throw new \Exception('Too many lists copying or importing to start more.');
	    }
	    else
	    {
    	    // Find the next data list that still needs to be imported
            $readyToImport = \DB::select('id', 'import_status')->from('data')->where('import_status', 'IN', array(1,3))->order_by('added_date', 'ASC')->limit(1)->execute()->as_array();
            
            if (count($readyToImport) > 0)
            {
                $data = $readyToImport[0];
                
                switch($data['import_status'])
                {
                    case 1:
                        Data::_import($data['id']);
                        break;
                    case 3:
                        Data::_copy($data['id']);
                        break;
                }

            }
            else
            {
                throw new \Exception('No lists left to import or copy.');
            }
            
	    }
        
    }
    
    
    public static function canAct()
    {
        // How many lists can be copied at once
        $currentCopyCount = \DB::select('id')->from('data')->where('import_status', 'IN', array(2, 4))->execute()->as_array();
	    
	    // Check if we are over the copy or import limit
	    if (count($currentCopyCount) > Data::SIMULLISTS)
	    {
	        // Too many copying or importing to continue so stop
	        returnfalse;
	    }
	    else
	    {
    	    return true;
	    }
    }
    
    
    
    public static function _copy($data_id=null)
    {
        \Data\Source::forge(\Data\Source::COPY, $data_id);
    }
    
    public static function _import($data_id=null)
    {
        \Data\Source::forge(\Data\Source::IMPORT, $data_id);
    }

}
