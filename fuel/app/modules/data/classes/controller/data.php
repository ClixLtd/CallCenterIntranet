<?php

namespace Data;

class Controller_Data extends \Templates\Controller_Force
{

    public function action_index($supplier_id=null)
    {
        $quickView = array(
            'top5' => \Data\Model_Data::list_all($supplier_id, 'score', 5),
        );
        
        $this->template->title = 'Example Page';
        $this->template->content = "hello";
    }
    
    
    
    /**
     * Lists all Data in the system.
     * 
     * @access public
     * @return void
     */
    public function action_list($supplier_id=null)
    {
        $allData = \Data\Model_Data::list_all($supplier_id);
        
        $this->template->title = 'Listing all Data';
        $this->template->content = "hello";
    }

}