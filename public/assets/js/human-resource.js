/** Human Resource **/

$(document).ready(function()
{
  $("#Create-New-Profile").click(function()
  {
    $("#Create-New-Profile-Dialog").dialog("open");
  });
  
  $("#Create-New-Profile-Dialog").dialog({
		autoOpen: false,
		modal: true,
    title: 'Create New Profile',
    width: 700,
    height: 550,
		buttons:
    {
      "Finish & Save": function()
      {
				$(this).dialog("close");
			},
      
			"Cancel": function()
      {
				$(this).dialog("close");
			}
		}
	});
});