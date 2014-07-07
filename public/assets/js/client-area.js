var requestList = '';

$(document).ready(function()
{

  //-- 
  //------------
  $('#approvedoc').submit(function(e){
      e.preventDefault();

      if($('#bulk-action').val() == 0) {
        alert('Error : Select an action');
        return;
      }

      $.post('/clientarea/approve', $(this).serialize(), function(data){
        if(data.status != 'success')
          alert('Error : ' + data.message);
        else{
          alert(data.message);
          location.reload();
        }
      },'json').error(function(o,s,m){
        alert('Error : ' + m);
      });
  });


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
    else if(requestList[index]['field'] == 'OverrideAddress')
    {
      var holder = $('<div>');
      var style = {'float':'left','width':'150px','padding-top':'5px'};

      holder.append($('<div>').css(style).text('Street and Number :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[OverrideStreetAndNumber]','value':requestList[index]['new_value']['Street-and-Number']})));
      holder.append($('<div>').css(style).text('Area :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[OverrideArea]','value':requestList[index]['new_value']['Area']})));
      holder.append($('<div>').css(style).text('District :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[OverrideDistrict]','value':requestList[index]['new_value']['District']})));
      holder.append($('<div>').css(style).text('Town :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[OverrideTown]','value':requestList[index]['new_value']['Town']})));
      holder.append($('<div>').css(style).text('County :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[OverrideCounty]','value':requestList[index]['new_value']['County']})));
      holder.append($('<div>').css(style).text('Post Code :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[OverridePostcode]','value':requestList[index]['new_value']['Post-Code']})));

      $('#New-Value').html(holder);
    }
    else if(requestList[index]['field'] == 'PartnerAddress')
    {


      var holder = $('<div>');
      var style = {'float':'left','width':'150px','padding-top':'5px'};



      holder.append($('<div>').css(style).text('Street and Number :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[StreetAndNumber]','value':requestList[index]['new_value']['Street-and-Number']})));
      holder.append($('<div>').css(style).text('Area :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[Area]','value':requestList[index]['new_value']['Area']})));
      holder.append($('<div>').css(style).text('District :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[District]','value':requestList[index]['new_value']['District']})));
      holder.append($('<div>').css(style).text('Town :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[Town]','value':requestList[index]['new_value']['Town']})));
      holder.append($('<div>').css(style).text('County :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[County]','value':requestList[index]['new_value']['County']})));
      holder.append($('<div>').css(style).text('Post Code :'));
      holder.append($('<div>').css(style).html($('<input>').attr({'type':'text','name':'address[Postcode]','value':requestList[index]['new_value']['Post-Code']})));

      $('#New-Value').html(holder);
    }
    else
    {
      $("#New-Value-Input").val();
      $("#New-Value").html('<input type="text" name="New-Value" id="New-Value-Input" value="' + requestList[index]['new_value'] + '" />');
    }

  });

  $("#Add-Client-Submit").click(function()
  {
     // -- Check that the Client ID Exists
     // ----------------------------------
      $.ajax({
          url: '/clientarea/add_client_account/0.json',
          type: 'POST',
          data: $("#AddNewClient").serialize(),
          success: function(data)
          {
              if(data['status'] == 'success')
              {
                  alert('Success : ' + data.message);
                  $('#AddNewClient')[0].reset();
              }
              else
              {
                  alert('Error : ' + data.message);
              }
          },
          error: function(o,s,m)
          {
            alert('Error : Unable to process request , please try again later.');
            console.log(m);
          }

      });
  });

});
//-- end of jquery

function approveRequest()
{
  var clientID      = $("#ClientID").val();
  var requestID     = $("#RequestID").val();
  var field         = $("#Field").val();
  var newValue      = $("#New-Value-Input").val();
  var companyID     = $("#CompanyID").val();
  var addressFields = '';
  
  if(field == 'Address' || field == 'OverrideAddress' || field == 'PartnerAddress')
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