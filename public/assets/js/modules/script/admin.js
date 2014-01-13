/* Script Admin javaScript File */

var ajaxURL = '/survey/ajax';

$(document).ready(function()
{
  /*
  //letterContent = $('#revisionEditArea').html();
  $('#revisionEditArea').attr('contentEditable',true);
  $('#revisionEditArea').addClass('areaIsEditable');
  letterInstance = CKEDITOR.inline('revisionEditArea');
  */
  
  $("#Add-New-Script-Button").click(function()
  {
    if($("#Create-Script-Box").is(":visible"))
    {
      $("#Create-Script-Box").hide();
    }
    else
    {
      $("#Create-Script-Box").show();
    }
  });
  
  // -- Create Script
  // ----------------
  /*
  $(".form-wizard-2").formwizard(
  { 
		formPluginEnabled: true,
		validationEnabled: true,
		focusFirstInput : false,
		disableUIStyles:true,
		validationOptions: {
			errorElement:'span',
			errorClass: 'help-block error',
			errorPlacement:function(error, element){
				element.parents('.controls').append(error);
			},
			highlight: function(label) {
				$(label).closest('.control-group').removeClass('error success').addClass('error');
			},
			success: function(label) {
				label.addClass('valid').closest('.control-group').removeClass('error success').addClass('success');
			}
		},
		formOptions:
    {
      url: ajaxURL + '/create_update_script/0.json',
      type: 'post',
      dataType: 'json',
      data: $(this).serialize(),
      success: function(data)
      {
        if(data['status'] == 'SUCCESS')
        {
          alert('Script has been saved');
          location.reload(true);
        }
        else
        {
          alert('Error has occured:');
        }
      },
      error: function()
      {
        alert('Failed to save script');
      }
    }
	});
  */
  
  // -- Save the Survey
  // ------------------
  $("#Save-Survey").click(function()
  {
    $.ajax({
      url: ajaxURL + '/create_update_script/0.json',
      type: 'post',
      dataType: 'json',
      data: $("#Create-Script-Form").serialize(),
      success: function(data)
      {
        if(data['status'] == 'SUCCESS')
        {
          alert('Script has been saved');
          location.reload(true);
        }
        else
        {
          console.log('Error has occured:');
        }
      },
      error: function()
      {
        console.log('Failed to save script');
      }
    });
  });
  
});

// -- Load all the Scripts
// -----------------------
function loadAllScripts()
{
  var table = $("#Scripts-Table > tbody");
  var html = '';
        
  $.ajax({
    url: ajaxURL + '/load_all_scripts/0.json',
    type: 'post',
    dataType: 'json',
    success: function(data)
    {
      if(data['status'] == 'SUCCESS')
      {
        
        if(data['results'].length > 0)
        {
          $.each(data['results'], function(index, value)
          {
            html += '<tr><td>' + value['name'] + '</td><td>' + value['type_description'] + '</td><td></td><td>' + value['active'] + '</td></tr>';
          });
        }
        else
        {
          html += '<tr><td colspan="4">No Scripts have been found<td></tr>';
        }
        
        table.html(html);
      }
    },
    error: function()
    {
      html += '<tr><td colspan="4">Error loading scripts<td></tr>';
      table.html(html);
    }
  });
}