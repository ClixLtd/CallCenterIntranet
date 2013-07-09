/** Human Resource **/

var currentNPStep = 0;

$(document).ready(function()
{
  $("#Create-New-Profile").click(function()
  {
    changeCreateNewProfile('start');
    $("#Create-New-Profile-Dialog").dialog("open");
  });
  
  $("#Create-New-Profile-Dialog").dialog({
		autoOpen: false,
		modal: true,
    title: 'Create New Profile',
    width: 1000,
    height: 700,
		buttons:
    {
      "<< Back": function()
      {
        changeCreateNewProfile('back');
			},
      
      "Next >>": function()
      {
        changeCreateNewProfile('next');
			},
      
      "Finish & Save": function()
      {
				$(this).dialog("close");
			},
      
			"Cancel": function()
      {
        if(confirm('Are you sure you want yo canel this new profile?') == true)
        {
          $(this).dialog("close"); 
        }
			}
		},
    create: function(event, ui)
    {
      // -- Style the buttons
      // --------------------
      var buttons = $(event.target).parent().find('.ui-dialog-buttonset').children();
      
      $(buttons[0]).css('color', 'blue');
      $(buttons[1]).css('color', 'blue');
      $(buttons[2]).css('margin-left', '30px').css('color', 'green');
      $(buttons[3]).css('color', 'red');
    }
	});
});

function changeCreateNewProfile(direction)
{
  if(currentNPStep == 0 && direction = 'start')
  {
    $("#NP-Step-1").show();
  }
}