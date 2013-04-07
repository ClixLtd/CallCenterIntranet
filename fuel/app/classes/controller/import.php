<?php

class Controller_Import extends Controller_BaseHybrid
{

    public function post_parse_payments()
    {
    
        $config = array(
            'path' => DOCROOT.'uploads/csv',
            'randomize' => true,
            'ext_whitelist' => array('csv'),
        );
        
        Upload::process($config);
        
        
        if (Upload::is_valid())
        {
            //Upload::save();
            $file = Upload::get_files();
            
            
            $uploaded_file = $file[0]['file'];
    
            Package::load("excel");
            $excel = PHPExcel_IOFactory::createReader('CSV')
                ->setDelimiter(',')
                ->setEnclosure('"')
                ->setLineEnding("\n")
                ->setSheetIndex(0)
                ->load($uploaded_file);
                
                
                
            $objWorksheet       = $excel->setActiveSheetIndex(0);
            $highestRow         = $objWorksheet->getHighestRow();
            $highestColumn      = $objWorksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
         
            //read from file
            for ($row = 1; $row <= $highestRow; ++$row)
            {
                $file_data = array();
                for ($col = 0; $col <= $highestColumnIndex; ++$col)
                {  
                    $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue(); 
                    $file_data[$col]=trim($value);
                }
                $result[] = $file_data;
            }
            
            
            print_r($result);
            
        }
        else
        {
            print "Invalid uploads";
        }

    }

    public function action_payments()
    {
        
        
        $this->template->title = 'Importing Payments';
        
		$this->template->content = View::forge('import/payments');	
    }

}