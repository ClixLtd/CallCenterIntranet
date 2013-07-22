<?php

namespace Suppliers;

class Controller_Suppliers extends \Controller_BaseHybrid
{
    
    public function action_index()
    {

        $allSuppliers = Model_Suppliers::list_all();

        $this->template->title = 'Example Page';
        $this->template->content = \View::forge('view/list', array(
            'suppliers' => $allSuppliers,
        ));
    }

}