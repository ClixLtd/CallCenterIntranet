<?php

namespace Suppliers;

class Model_Suppliers
{

    public static function list_all()
    {
        $allSuppliers = \DB::select('*')->from('suppliers')->order_by('name')->execute()->as_array();

        return $allSuppliers;
    }

}