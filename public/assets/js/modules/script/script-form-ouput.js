/* Script Form Ouput JavaScript File */
var repeatCount = 2;

$(document).ready(function()
{  
  $("#Add-Another").click(function(event)
  {
    if(validateForm() === false)
    {
      alert('You need to answer/fill out the required Questions.');
    }
    else
    {
      event.preventDefault();
      var jsonOutput = $("#Script-Form").formParams();
      
      var html = '';
          html += '<tr><td><strong>' + (repeatCount - 1) + '.</strong></td><td colspan="3">';
      
      $.each(jsonOutput.scriptForm[1], function(index, value)
      {      
        if(value.answer instanceof Object)
        {
          html += value.question + ': ';
          
          $.each(value.answer, function(objIndex, objValue)
          {          
            if(objValue)
            {
              if(objIndex == 'select$BoxInput')
              {
                var name = 'select$BoxInput';
                
                objIndex = $("#Question-" + index + " option:selected").text();
              }
              else if(objIndex == 'radio$Input')
              {
                var name = 'radio$Input';
                objIndex = $("#Question-" + index + "-" + objValue).attr('rel');
              }
              
              html += objIndex + '<input type="hidden" name="scriptForm[Repeat][' + repeatCount + '][' + index + '][answer]' + (name ? '[' + name + ']' : '[' + objValue + ']') + '" value="' + objValue + '" /> ';
            }
          });
        }
        else
        {
          html += value.question + ': ' + value.answer + '<input type="hidden" name="scriptForm[Repeat][' + repeatCount + '][' + index + '][answer]" value="' + value.answer + '" />';
        }
      });
      
      html += '<td></tr>';
      
      console.log(jsonOutput);
      
      repeatCount++;
      
      // -- Send it back
      // ---------------
      $('#Script-Form-Table').append(html);
      
      // -- Clear the Master Form
      // ------------------------
      //$(".Master-Input input[type='text']").val('');
      //$(".Master-Input INPUT:checkbox").prop('checked', false);
    }
    
    return false;
  });
  
  $("#Script-Form").submit(function()
  {
    $.ajax({
      url: '/script/ajax/save_form/0.json',
      type: 'post',
      dataType: 'json',
      data: $("#Script-Form").serialize(),
      success: function(data)
      {
        
      }
    });
    
    return false;
  });
  
});

function validateForm()
{
  var errorCount = 0;
  
  $.each($(".Required"), function()
  {
    var elm = '';
    
    if($(this).attr('type'))
    {
      elm = $(this).attr('type');
      
      //$(this).css('background-color', '#ff794b');
      //$(this).css('color', '#fff');
      
      switch(elm)
      {
        case 'checkbox' :
        
        break;
      }
        
      //errorCount++;
    }
    else if($(this).prop('tagName'))
    {
      elm = $(this).prop('tagName');
      
      if($(this).val() == '')
      {
        //$(this).css('background-color', '#ff794b');
        //$(this).css('color', '#fff');
        
        //errorCount++;
      }
    }
  });
  
  if(errorCount > 0)
  {
    return false;
  }
  else
  {
    $(this).css('background-color', '#fff');
    $(this).css('color', '#000');
    
    return true;
  }
}