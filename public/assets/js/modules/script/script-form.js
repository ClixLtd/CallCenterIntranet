/* Script Form. Used for creating webforms */

var formElements = $("#Form-Elements-Table > tbody");
var fieldCount = 1;
var fieldID = 1;

$(document).ready(function()
{
  $("#Add-Input-Button").click(function()
  {
    var errorMsg = '';
    
    if($("#Input-Type-Select").val() == '')
    {
      errorMsg += "- Field Type cannot be empty\n";
    }
    
    if($("#Input-Name").val() == '')
    {
      errorMsg += "- Field Name cannot be empty";
    }
    
    if(errorMsg != '')
    {
      alert(errorMsg);
      return false;
    }
    else
    {
      var fieldTypeID   = $("#Input-Type-Select").val();
      var fieldType     = $('#Input-Type-Select option:selected').attr('rel');
      var fieldTypeName = $('#Input-Type-Select option:selected').text();
      var question      = $("#Input-Name").val();
                
      // -- Check for duplicates
      // -----------------------
      if($("#Row-" + fieldID).length > 0)
      {
        alert('Field already exists');
        return false;
      }
      else
      {
        var isRequired = '';
        
        if($("#Required").val() == 'yes')
        {
          isRequired = ' checked="checked"';
        }
        
        var html = '<tr id="Row-' + fieldID + '">';
            html += '<td>' + question + '<input type="hidden" name="form[fields][' + fieldID + '][question]" value="' + question + '" /></td>';
            html += '<td>' + fieldTypeName + '<input type="hidden" name="form[fields][' + fieldID + '][fieldType]" value="' + fieldTypeID + '" /></td>';
            
        var values = '';
        
        switch(fieldType)
        {
          case 'checkbox' :
          case 'radio' :
          case 'select' :
            values += '<div id="group-' + fieldID + '">';
            
            values += '<div style="margin:10px">';
            values += '<div class="row-fluid">';
            values += '<div class="span3">Answer:</div>';
            values += '<div class="span3">';
            values += '<input type="hidden" name="Option-Count-' + fieldID + '" id="Option-Count-' + fieldID + '" value="1" />';
            values += '<input type="text" name="form[fields][' + fieldID + '][options][1][value]" class="input-small" /></div>';
            values += '</div>';
            values += '</div>';
            
            values += '</div>'
            values += '<br /><div><button type="button" class="btn" id="Add-Another-Value-Button" rel="' + fieldID + '">Add Another Answer</button></div>';
          break;
        }
        
        html += '</td>';
        html += '<td>' + values + '</td>';
        html += '<td><label for="Required-' + fieldID + '"><input type="checkbox" name="form[fields][' + fieldID + '][required]" ' + isRequired + ' /> Required</label></td>';
        html += '<td><button type="button" class="btn btn-primary" id="Remove-Row" rel="' + fieldID + '"><i class="icon-remove"></i></button></td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td><b>Select Product</b></td>';
        
        var products = '';
        
        products += '<div class="row-fluid">'
          products += '<input type="hidden" name="Product-Count-' + fieldID + '" id="Product-Count-' + fieldID + '" value="1" />'
          products += '<div id="product-group-' + fieldID + '">';
          
            products += '<div class="row-fluid">';
              products += '<div class="span4">'
                products += '<select name="form[fields][' + fieldID + '][products][1][product]">';
                  products += loadProductsSelectList();
                products += '</select>';
              products += '</div>';
              products += '<div class="span2">Positive Value</div>';
              products += '<div class="span3"><input type="text" name="form[fields][' + fieldID + '][products][1][positive]" class="input-small" /></div>';
            products += '</div>';
            
            products += '<div class="row-fluid">';
              products += '<div class="span4"></div>';
              products += '<div class="span2">Negative Value</div>';
              products += '<div class="span3"><input type="text" name="form[fields][' + fieldID + '][products][1][negative]" class="input-small" /></div>';
            products += '</div>';
            
            products += '<div class="row-fluid">';
              products += '<div class="span4"></div>';
              products += '<div class="span2">Priority</div>';
              products += '<div class="span3"><input type="text" name="form[fields][' + fieldID + '][products][1][priority]" class="input-small" /></div>';
            products += '</div><hr />';
          
          products += '</div>'
          products += '<div class="row-fluid">';
            products += '<div class="span12"><button type="button" class="btn" id="Add-Another-Product-Button" rel="' + fieldID + '">Add Another Product</button></div>';
          products += '</div>';
        products += '</div>';
        
        
        html += '<td colspan="4">' + products + '</td>'
        
        html += '</tr>';
        
        formElements.append(html);
      }
      
      fieldID++;
    }
    
    return false;
  });
   
  $("#Form-Elements-Table > tbody").on('click', 'button', function()
  {
    var ID = $(this).attr('id');
    var fieldID = $(this).attr('rel');
    var countField = parseInt($("#Option-Count-" + fieldID).val(), 10) + parseInt(1, 10);
    
    if(ID == 'Add-Another-Value-Button')
    {
      var html = '';
          html += '<div style="margin:10px">';
          html += '<div class="row-fluid">';
          html += '<div class="span3">Answer:</div>';
          html += '<div class="span3"><input type="text" name="form[fields][' + fieldID + '][options][' + countField + '][value]" class="input-small" /></div>';
          html += '</div>';
          html += '</div>';
        
      $("#group-" + fieldID).append(html);
      $("#Option-Count-" + fieldID).val(countField);
    
    }
    else if(ID == 'Add-Another-Product-Button')
    {
      var productCount = parseInt($("#Product-Count-" + fieldID).val(), 10) + parseInt(1, 10);
      var products = '';
      
      products += '<div class="row-fluid">';
        products += '<div class="span4">'
          products += '<select name="form[fields][' + fieldID + '][products][' + productCount + '][product]">';
            products += loadProductsSelectList();
          products += '</select>';
        products += '</div>';
        products += '<div class="span2">Positive Value</div>';
        products += '<div class="span3"><input type="text" name="form[fields][' + fieldID + '][products][' + productCount + '][positive]" class="input-small" /></div>';
      products += '</div>';
      
      products += '<div class="row-fluid">';
        products += '<div class="span4"></div>';
        products += '<div class="span2">Negative Value</div>';
        products += '<div class="span3"><input type="text" name="form[fields][' + fieldID + '][products][' + productCount + '][negative]" class="input-small" /></div>';
      products += '</div>';
      
      products += '<div class="row-fluid">';
        products += '<div class="span4"></div>';
        products += '<div class="span2">Priority</div>';
        products += '<div class="span3"><input type="text" name="form[fields][' + fieldID + '][products][' + productCount + '][priority]" class="input-small" /></div>';
      products += '</div><hr />';
      
      $("#product-group-" + fieldID).append(products);
      $("#Product-Count-" + fieldID).val(productCount);
    }
    else if(ID == 'Remove-Row')
    {
      $("#Row-" + fieldID).remove();
    }
    
    return false;
  });
});

function loadProductsSelectList()
{
  var output = '';
  
  $.ajax({
    url: '/survey/ajax/load_products/0.json',
    type: 'post',
    dataType: 'json',
    async: false,
    success: function(data)
    {
      if(data['status'] == 'SUCCESS')
      {
        if(data['results'].length > 0)
        {
          $.each(data['results'], function(index, value)
          {
            output += '<option value="' + value['id'] + '">' + value['name'] + '</option>';
          });
        }
      }
    }
  });
  
  return output;
}