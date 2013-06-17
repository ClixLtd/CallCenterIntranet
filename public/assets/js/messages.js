/** Messages Javascript File */

$(document).ready(function()
{
  var box = '';
  
  hidePages();
  
  $("#Message-List").show();
  
  $("#Create-Message-Button").click(function()
  {
    hidePages();
    clearMessageForm();
    
    $("#Create-Message").show();
    
    $(".Input-Required").attr('disabled', 'disabled');
    
    // -- Get a list of companies
    // --------------------------
    $.ajax({
      type: 'post',
      url: '/clientarea/company_list/0.json',
      dataType: 'json',
      success: function(data)
      {
        if(data['status'] == 'success')
        {
          var option = '';
          
          $.each(data['data'], function(index, value)
          {
            option += '<option value="' + value['id'] + '">' + value['company_name'] + '</option>';
          });
          
          $("#Message-CompanyID").append(option);
        }
      }
    });
  });
  
  // -- Validate the Client ID
  // -------------------------
  $("#Message-CompanyID").change(function()
  {
    if($("#Message-To").val() != '')
    {
      $.ajax({
        type: 'post',
        url: '/clientarea/validate_client_id/0.json',
        data:
        {
          clientID: $("#Message-To").val(),
          companyID: $(this).val(),
        },
        success: function(data)
        {
          var validateResult = $("#Validate-Result");
          
          if(data['status'] == 'success')
          {
            validateResult.css("color", "green");
            validateResult.html('Client Found: ' + data['data']['fullName']);
            
            $(".Input-Required").removeAttr('disabled');
          }
          else
          {
            validateResult.css("color", "red");
            validateResult.html('Client Not Found!');
            
            $(".Input-Required").attr('disabled', 'disabled');
          }
        }
      });
    }
    else
    {
      alert('Please enter a client ID above');
    }
  });
  
  $("#Inbox-List-Button").click(function()
  {
    box = 'inbox';
    location.href = '/clientarea/messages/?box=inbox';
  });
  
  $("#Sent-List-Button").click(function()
  {
    box = 'sent';
    location.href = '/clientarea/messages/?box=sent';
  });
  
  $("#Refresh-Message-Button").click(function()
  {
    if(box == '')
    {
      box = 'inbox';
    }
    
    location.href = '/clientarea/messages/?box=' + box;
  });
  
  $("#Send-New-Message").click(function()
  {
    // -- Validate
    // -----------
    var errorMsg = '';
    
    if($("#Message-To").val() == '')
    {
      errorMsg += "Enter the client's Debtsolv ID\n\n";
    }
    
    if($("#Message-Subject").val() == '')
    {
      errorMsg += "Enter a Subject\n\n";
    }
    
    if($("#Message-Body").val() == '')
    {
      errorMsg += "Enter a message";
    }
    
    if(errorMsg == '')
    {
      // -- No errors, so save it
      // ------------------------
      $.ajax({
        type: 'post',
        url: '/clientarea/save_new_message/0.json',
        data: $("#New-Message-Form").serialize(),
        success: function(data)
        {
          if(data['status'] == 'success')
          {
            alert('Message has been sent');
            clearMessageForm();
          }
          else
          {
            alert('Oops..' + data['message']);
          }
        }
      });
    }
    else
    {
      alert(errorMsg);
    }
  });
  
  $("#Cancel-New-Message").click(function()
  {
    if(confirm('Are you really, really sure you want to cancel this message?') == true)
    {
      clearMessageForm();
      hidePages();
      $("#Message-List").show();
    }
    else
    {
      return false;
    }
  });
  
  $(".Message-Row").click(function()
  {
    var messageID = $(this).attr('rel');
    
    $("#MessageID").val(messageID);
    
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/clientarea/read_message/' + messageID + '.json',
      success: function(data)
      {
        if(data['status'] == 'success')
        {
          var html = '';
          var count = 0;
          
          for(var del in data['data']['posts'])
          {
            if(data['data']['posts'].hasOwnProperty(del))
            {
              count++;
            }
          }
          
          var i = 1;
          
          if(count > 1)
          {
            $.each(data['data']['posts'], function(index, value)
            {
              if(i < count - 1)
              {
                html += readMessagePosts(value['id'], value['poster'], value['message'], value['date'], true);
              }
              
              if(i == count - 1)
              {
                html += readMessagePosts(value['id'], value['poster'], value['message'], value['date'], false);
              }
              
              if(i == count)
              {
                $("#Latest-Post-From").html(value['poster']);
                $("#Latest-Post-Date").html(value['date']);
                $("#Latest-Post-Body").html(value['message'].replace(/\n/g, "<br />"));
                
                $("#Last-Post-ID").val(value['id']);
              }
              
              i++;
            });
          }
          else
          {
            $("#Latest-Post-From").html(data['data']['posts'][0]['poster']);
            $("#Latest-Post-Date").html(data['data']['posts'][0]['date']);
            $("#Latest-Post-Body").html(data['data']['posts'][0]['message'].replace(/\n/g, "<br />"));
            
            $("#Last-Post-ID").val(data['data']['posts'][0]['id']);
          }
          
          hidePages();
          
          $("#Message-Posts-List").html(html);
          $("#Read-Message").show();
          
          location.href = '#last';
        }
        else
        {
          alert('Oops.. That message can\'t be opened. Please contact the I.T. Department.');
          return false;
        }
      }
    });
  });
  
  $(".Show-Post-Message").live('click', function()
  {
    if($(this).is(':visiable'))
    {
      $(this).hide();
    }
    else
    {
      $(this).show();
    }
  });
  
  $("#Send-Reply-Button").click(function()
  {
    $("#Reply-Form").show();
    location.href = '#reply';
  });
  
  $("#Close-Message-Button").click(function()
  {
    hidePages();
    $("#Inbox-List-Button").click();
  });
  
  $("#Send-Reply").click(function()
  {
    // -- Validate the reply form
    // --------------------------
    if($("#Reply-Message-Body").val() == '')
    {
      alert('Please type a message before you send it');
      return false;
    }
    
    // -- Save the message
    // -------------------
    var messageID = $("#MessageID").val();
    
    $.ajax({
      type: 'post',
      url: '/clientarea/send_reply/' + messageID + '.json',
      data:
      {
        message: $("#Reply-Message-Body").val(),
        lastPostID: $("#Last-Post-ID").val(),
      },
      success: function(data)
      {
        if(data['status'] == 'success')
        {
          alert("Reply has been sent");
          
          $("#Reply-Message-Body").val('')
          $("#Reply-Form").hide();
        }
        else
        {
          alert("Oops... Your message could not be sent. Please contact I.T.");
        }
      }
    });
  });
  
});

function hidePages()
{
  $("#Message-List").hide();
  $("#Create-Message").hide();
  $("#Read-Message").hide();
  $("#Reply-Form").hide();
}

function readMessagePosts(messageID, name, message, date, hide)
{
  var display = 'none';
  
  if(hide == false)
  {
    display = 'block';
  }
  
  var html = [
  
    '<div class="Message-Post">',
    '<article class="full-block clearfix">',
      '<section>',
        '<article class="full-block">',
  				'<header onclick="javascript:showHidePost(' + messageID + ');">',
  					'<h2>Message</h2>',
  				'</header>',
          '<section id="Post-' + messageID + '" style="display:' + display + ';">',
            '<table>',
              '<tr>',
                '<th width="150">From:</th>',
                '<td style="text-align:left;">' + name + '</td>',
              '</tr>',
              '<tr>',
                '<th>Date:</th>',
                '<td style="text-align:left;">' + date + '</td>',
              '</tr>',
              '<tr>',
                '<th>Message:</th>',
                '<td style="text-align:left;">' + message.replace(/\n/g, "<br />") + '</td>',
              '</tr>',
            '</table>',
          '</section>',
        '</article>',
      '</section>',
    '</article>',
  '</div>',
  
  ].join('');
  
  return html;
}

function showHidePost(postID)
{
  var post = $("#Post-" + postID);
  
  if(post.is(':visible'))
  {
    post.hide();
  }
  else
  {
    post.show();
  }
}

function clearMessageForm()
{
  $("#New-Message-Form input[type='text'], textarea, select").val('');
  $("#Validate-Result").html('');
}