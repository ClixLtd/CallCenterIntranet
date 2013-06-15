<?php

namespace Reports;


/**
 * Query class.
 */
class Query
{
    
    const     LOAD                = 'load';
    const     CREATE              = 'create';
    const     RUN                 = 'run';
                                  
    public    $id                 = null;
    protected $query              = null;
    public    $query_hash         = null;
    protected $database_id        = null;
    public    $result             = null;
    protected $request_date       = null;
    protected $completion_date    = null;
    protected $completion_seconds = null;
    protected $status             = null;
    
    
    
    /**
     * Create a new query object.
     * 
     * @access public
     * @param mixed $param1 (default: null)
     * @param mixed $options (default: null)
     * @return void
     */
    public static function forge($param1=null, $query=null, $dbid=null)
    {
        return new static($param1, $query, $dbid);
    }
    
    
    /**
     * What is ran when first loading.
     * 
     * @access public
     * @param mixed $param1 (default: null)
     * @param mixed $options (default: null)
     * @return void
     */
    public function __construct($param1=null, $param2=null, $dbid=null)
    {
        if (is_null($param1))
        {
            throw new \Exception('ERROR');
        }
        else if ($param1==\Reports\Query::RUN)
        {
            $this->id = $param2;
            $this->_load();
            $this->_run();
        }
        else if ($param1==\Reports\Query::LOAD)
        {
            $this->id = $param2;
            $this->_load();
        }
        else if ($param1==\Reports\Query::CREATE && !is_null($param2) && !is_null($dbid))
        {
            $this->query         = $param2;
            $this->query_hash    = sha1($param2);
            $this->database_id   = $dbid;
            $this->request_date  = date("Y-m-d H:i:s");
            $this->status        = 1;
            
            $this->_create();
        }
        else
        {
            throw new \Exception('Parameters not given correctly');
        }
        
        return $this;
    }
    
    /**
     * Load the query into the object.
     * 
     * @access private
     * @param mixed $id
     * @return void
     */
    private function _load()
    {
        // Query the database to get the required results
        $result = \DB::select('*')->from('report_query')->where('id', $this->id)->as_object()->execute();
        
        // Parse results from database into the query object
        $this->query              = $result[0]->query;
        $this->query_hash         = $result[0]->query_hash;
        $this->database_id        = $result[0]->database_id;
        $this->result             = unserialize($result[0]->result);
        $this->request_date       = $result[0]->request_date;
        $this->completion_date    = $result[0]->completion_date;
        $this->completion_seconds = $result[0]->completion_seconds;
        $this->status             = $result[0]->status;
        
        return $this;
    }
    
    
    
    /**
     * create function.
     * 
     * @access protected
     * @return void
     */
    private function _create()
    {
        list($insert_id, $rows_affected) = \DB::insert('report_query')->set(array(
            'query'        => $this->query,
            'query_hash'   => $this->query_hash,
            'database_id'  => $this->database_id,
            'request_date' => $this->request_date,
            'status'       => $this->status,
        ))->execute();
        
        $this->id = $insert_id;
        
        // Query has been created so run the onCreate Method
        $this->onCreate();
    }
    
    
    /**
     * run function.
     * 
     * @access protected
     * @return void
     */
    private function _run()
    {
    
        $done = \DB::update('report_query')->set(array(
            'status' => 2
        ))->where('id', $this->id)->execute();
        
        // Run the required query
        $result = \DB::query($this->query)->execute()->as_array();
        
        // Store the results in the object
        $this->result = $result;
        $currentTimestamp = strtotime("now");
        $requestTimestamp = strtotime($this->request_date);
        $this->completion_seconds = $currentTimestamp - $requestTimestamp;
        $this->completion_date = date("Y-m-d H:i:s", $currentTimestamp);
        
        
        // Update the database with the result and completion information
        $done = \DB::update('report_query')->set(array(
            'result' => serialize($this->result),
            'completion_date' => $this->completion_date,
            'completion_seconds' => $this->completion_seconds,
            'status' => 3
        ))->where('id', $this->id)->execute();
        
        // Run the completed function
        $this->_complete();
        
        return $this;
        
    }
    
    
    private function _complete()
    {
        $this->onComplete();
        return $this;
    }
    
    private function _error()
    {
        $this->onError();
        return $this;
    }
    
    
    /**
     * Has this query now expired?
     * 
     * @access public
     * @return void
     */
    public function isExpired()
    {
        return ($this->status == 4) ? true : false;
    }
    
    
    /**
     * Has this query completed running?
     * 
     * @access public
     * @return void
     */
    public function isComplete()
    {
        return ($this->status == 3) ? true : false;
    }
    
    
    /**
     * Is this query currently running?
     * 
     * @access public
     * @return void
     */
    public function isRunning()
    {
        return ($this->status == 2) ? true : false;
    }
    
    
    /**
     * Is this query waiting to be executed?
     * 
     * @access public
     * @return bool
     */
    public function isWaiting()
    {
        return ($this->status == 1) ? true : false;
    }
    
    
    
    /**
     * Function that is ran when a query is created.
     * 
     * @access protected
     * @return void
     */
    protected function onCreate()
    {


    }
    
    
    /**
     * Function that is ran when a query has finished running.
     * 
     * @access protected
     * @return void
     */
    protected function onComplete()
    {


        
    }
    
    
    protected function onError()
    {


        
    }
    

}