<script type="text/javascript" src="http://focus.clix.dev/assets/js/modules/script/jquery.formparams.min.js"></script>
<script type="text/javascript" src="http://focus.clix.dev/assets/js/modules/script/script-form-ouput.js"></script>

<div class="row-fluid">
  <div class="span12">
    <h2><?=$form['name'];?></h2>
  </div>
</div>

<div class="row-fluid" style="margin-bottom: 35px;">
  <div class="span12">
  <?php
  if(isset($form['questions']))
  {
    ?>
    <form action="#" method="POST" id="Script-Form">
      <div class="row-fluid">
        <div class="span12">
          <?php
          $row = 0;
          foreach($form['questions'] as $question)
          {
            ?>              
            <div class="row-fluid onequestion" id="form-q<?=$question['id'];?>" style="padding: 5px; border-bottom: 2px dotted #0090d2;">
              <div class="span7"><?=$question['question'];?></div>
              <div class="span4" id="Input-<?=$question['id'];?>">
                <input type="hidden" name="Group-Ref" value="1" />
                <input type="hidden" name="scriptForm[1][<?=$question['id'];?>][question]" value="<?=$question['question'];?>" />
                <?php
                $field = '';
                
                switch($question['field_type'])
                {
                  case 'text' :
                    $field .= '<input type="text" name="scriptForm[1][' . $question['id'] . '][answer]" class="Master-Input ' . ($question['required'] == 'yes' ? 'Required' : false) . '" id="Question-' . $question['id'] . '" />';
                  break;
                  case 'textarea' :
                    $field .= '<textarea name="scriptForm[1][' . $question['id'] . '][answer]" class="Master-Input ' . ($question['required'] == 'yes' ? 'Required' : false) . '" id="Question-' . $question['id'] . '"></textarea>';
                  break;
                  case 'checkbox' :
                    if(isset($question['options']) && count($question) > 0)
                    {
                      foreach($question['options'] as $option)
                      {
                        $field .= '<label for="Question-' . $question['id'] . '-' . $option['id'] . '"><input type="checkbox" name="scriptForm[1][' . $question['id'] . '][answer][' . $option['option_name'] . ']" value="' . $option['id'] . '" class="Master-Input ' . ($question['required'] == 'yes' ? 'Required' : false) . '" id="Question-' . $question['id'] . '" /> ' . $option['option_name'] . '</label>';
                      }
                    }
                  break;
                  case 'radio' :
                    if(isset($question['options']) && count($question) > 0)
                    {
                      foreach($question['options'] as $option)
                      {
                        $field .= '<label for="Question-' . $question['id'] . '-' . $option['id'] . '"><input type="radio" name="scriptForm[1][' . $question['id'] . '][answer][radio$Input]" rel="' . $option['option_name'] . '" value="' . $option['id'] . '" id="Question-' . $question['id'] . '-' . $option['id'] . '" class="Master-Input ' . ($question['required'] == 'yes' ? 'Required' : false) . '" /> ' . $option['option_name'] . '</label><br />';
                      }
                    }
                  break;
                  case 'select' :
                    $field = '<select name="scriptForm[1][' . $question['id'] . '][answer][select$BoxInput]" id="Question-' . $question['id'] . '" class="Master-Input ' . ($question['required'] == 'yes' ? 'Required' : false) . '">';
                    $field .= '<option value="-1">-- Select --</option>';
                    
                    if(isset($question['options']) && count($question) > 0)
                    {
                      foreach($question['options'] as $option)
                      {
                        $field .= '<option value="' . $option['id'] . '">' . $option['option_name'] .'</option>';
                      }
                    }
                    
                    $field .= '</select>';
                  break;
                }
                
                echo $field;
                unset($field);
                ?>
              </div>
            </div>
            <?php
          }
          
          if($form['repeat'] == 'no')
          {
            ?>
            <div class="span12" style="margin-top: 35px; padding-top: 15px; border-top: 1px dotted #039BED; text-align: right;">
              <button type="button" id="Add-Another">Add Another</button>
            </div>
            <?php
          }
          ?>
          
          
        </div>
      </div>
      
      
    </form>
    <?php
  }
  else
  {
    ?>
    <h1>Invalid Survey</h1>
    <?php
  }
  ?>
  </div>
</div>