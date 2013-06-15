var requestList = '';

$(document).ready(function()
{
  /* Approve Change Client Details */
  /* ***************************** */
  $("#Change-Client-Details").dialog({
    autoOpen: false,
    modal: true,
    width: 600,
    title: 'Change Client Details',
    buttons:
    {
      "Approve": function()
      {
        approveRequest();
      },
      
      "Cancel": function()
      {
        requestList = '';
        $("#Old-Value").html('');
        $("#New-Value").html('');
        
        $(this).dialog("close");
      }
    },
    close: function()
    {
      requestList = '';
      $("#Old-Value").html('');
      $("#New-Value").html('');
      
      location.reload(true);
    }
  });
  
  /* Change Details Dialog button */
  /* **************************** */
  $(".Change-Details-Link").click(function()
  {
    var clientID = $(this).attr('rel');
    
    // -- Load the Client
    // ------------------
    $.ajax({
      type: 'post',
      url: '/clientarea/getChangeDetailsList/' + clientID + '/0.json',
      success: function(ouput)
      {        
        if(ouput['status'] == 'success')
        {
          requestList = ouput['data'][clientID];
          $("#ClientID").val(clientID);
          
          var list = '';
          $.each(ouput['data'][clientID], function(index, item)
          {
            list += "<div><input type='radio' name='Request-List-Select' id='Request-Field' rel='" + index + "' class='Request-List-Select' /> " + item['field'] + "</div>";
          });
          
          $("#Field-List").html(list);
        }
        else
        {
          alert('No details found');
          return false;
        }
      }
    });
    
    $("#Change-Client-Details").dialog("open");
  });
  
  $(".Request-List-Select").live('click', function()
  {
    var index = $(this).attr('rel');
    var requestID = requestList[index]['id'];
    
    $("#New-Value-Input").val('');
    
    $("#Old-Value").html(requestList[index]['old_value']);
    
    $("#RequestID").val(requestList[index]['id']);
    $("#Field").val(requestList[index]['field']);
    $("#CompanyID").val(requestList[index]['company_id']);
    
    if(requestList[index]['field'] == 'Address')
    {
      var addressInput = '';
      
      addressInput += "<div style='float:left;width:150px;padding-top:5px;'>Street and Number:</div><div style='float:left;'><input type='text' name='address[StreetAndName]' id='StreetAndName' value='" + requestList[index]['new_value']['Street-and-Number'] + "'/></div>";
      addressInput += "<div style='float:left;width:150px;padding-top:5px;clear:both;'>Area:</div><div style='float:left;'><input type='text' name='address[Area]' id='Area' value='" + requestList[index]['new_value']['Area'] + "'/></div>";
      addressInput += "<div style='float:left;width:150px;padding-top:5px;clear:both;'>District:</div><div style='float:left;'><input type='text' name='address[District]' id='District' value='" + requestList[index]['new_value']['District'] + "'/></div>";
      addressInput += "<div style='float:left;width:150px;padding-top:5px;clear:both;'>Town:</div><div style='float:left;'><input type='text' name='address[Town]' id='Town' value='" + requestList[index]['new_value']['Town'] + "'/></div>";
      addressInput += "<div style='float:left;width:150px;padding-top:5px;clear:both;'>County:</div><div style='float:left;'><input type='text' name='address[County]' id='County' value='" + requestList[index]['new_value']['County'] + "'/></div>";
      addressInput += "<div style='float:left;width:150px;padding-top:5px;clear:both;'>Post Code:</div><div style='float:left;'><input type='text' name='address[Postcode]' id='Post-Code' value='" + requestList[index]['new_value']['Post-Code'] + "'/></div>";
      
      $("#New-Value").html(addressInput);
    }
    else
    {
      $("#New-Value-Input").val();
      $("#New-Value").html('<input type="text" name="New-Value" id="New-Value-Input" value="' + requestList[index]['new_value'] + '" />');
    }
  });
});

function approveRequest()
{
  var clientID      = $("#ClientID").val();
  var requestID     = $("#RequestID").val();
  var field         = $("#Field").val();
  var newValue      = $("#New-Value-Input").val();
  var companyID     = $("#CompanyID").val();
  var addressFields = '';
  
  if(field == 'Address')
  {
    addressFields = $("#Change-Client-Details-Form").serialize();
    newValue = null;
  }
  
  newstuff = {
      client_id: clientID,
      request_id: requestID,
      company_id: companyID,
      field: field,
      new_value: newValue,
    };
  
  $.ajax({
    type: 'post',
    url: '/clientarea/save_client_request/0.json',
    data: $.param(newstuff) + addressFields,
    success: function(ouput)
    {
      if(ouput['status'] == 'success')
      {
        alert('Request has been approved');
      }
      else
      {
        alert('Could not save details. Please use Debtsolv Application to make the change');
      }
    }
  });
}