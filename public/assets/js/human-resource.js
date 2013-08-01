/** Human Resource **/

var currentNPStep = 1;
var newProfileDialogbuttons;

$(document).ready(function()
{
  // -- Select a Department Position
  // -------------------------------
  $("#Department-Select").change(function()
  {    
    changeJobPositionList($(this).val());
  });
  
  // -- Select a Position Level
  // --------------------------
  $("#Department-Position-Select").change(function()
  {
    changeJobPositionLevelList($(this).val());
  });
  
  // -- Load up the details of the posistion level for use in the create profile
  // ---------------------------------------------------------------------------
  $("#Department-Position-Level-Select").change(function()
  {
    var positionID = $("#Department-Position-Select").val();
    var levelID = $(this).val();
    
    $.ajax({
      url: '/hr/ajaxcalls/department_posistion_level_list/' + positionID + '/' + levelID + '.json',
      type: 'json',
      success: function(data)
      {
        if(data['status'] == 'SUCCESS')
        {
          $("#New-Basic-Salary-Input").val(data['results'][0]['basic_salary']);
        }
      }
    });
  })
  
  $(".Edit-Profile").click(function()
  {
    changeCreateNewProfile('start');
    $("#Create-New-Profile-Dialog").dialog("open");
  });
  
  /**********************************
  * Create a new Profile Dialog Box *
  ***********************************/
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
        if(validateCreateNewProfile() == true)
        {
          saveEmployeeProfile();
          $(this).dialog("close"); 
        }
        else
        {
          alert("You haven't completed all required fields.");
          return;
        }
			},
      
			"Cancel": function()
      {
        if(confirm('Are you sure you want to canel editing this profile?') == true)
        {
          $(this).dialog("close"); 
        }
			}
		},
    create: function(event, ui)
    {
      // -- Style the buttons
      // --------------------
      newProfileDialogbuttons = $(event.target).parent().find('.ui-dialog-buttonset').children();
      
      $(newProfileDialogbuttons[1]).css('color', 'blue');
      $(newProfileDialogbuttons[2]).css('margin-left', '30px').css('color', 'green');
      $(newProfileDialogbuttons[3]).css('color', 'red');
      
      if(currentNPStep == 1)
      {
        $(newProfileDialogbuttons[0]).attr("disabled", "disabled");
        $(newProfileDialogbuttons[0]).css('color', 'gray');
      }
      
      // -- Load up the job position and level
      // -------------------------------------
      if(departmentID > 0 && positionID > 0)
      {
        changeJobPositionList(departmentID);
        changeJobPositionLevelList(positionID);
      }
    }
	});
});

/******************************************************
* Show the Steps when creating a new Employee Profile *
******************************************************/
function changeCreateNewProfile(direction)
{
  if(currentNPStep == 1 && direction == 'start')
  {
    $("#NP-Step-1").show();
    currentNPStep = 1;
  }
  
  // -- Increase or Decrease the Step
  // --------------------------------
  if(direction == 'back')
  {
    currentNPStep = (currentNPStep - 1);
  }
  else if(direction == 'next')
  {
    currentNPStep = (currentNPStep + 1);
  }
  
  // -- Show the correct Step
  // ------------------------
  $(".New-Profile-Step").hide();
  $("#NP-Step-" + currentNPStep).show();
  
  // -- Enable or Disable the Back Button
  // ------------------------------------
  if(currentNPStep > 1)
  {
    $(newProfileDialogbuttons[0]).removeAttr("disabled");
    $(newProfileDialogbuttons[0]).css('color', 'blue');
  }
  else
  {
    $(newProfileDialogbuttons[0]).attr("disabled", "disabled");
    $(newProfileDialogbuttons[0]).css('color', 'gray');
  }
  
  // -- Enable or Disable the Next Button
  // ------------------------------------
  if(currentNPStep == 2)
  {
    $(newProfileDialogbuttons[1]).attr("disabled", "disabled");
    $(newProfileDialogbuttons[1]).css('color', 'gray');
  }
  else
  {
    $(newProfileDialogbuttons[1]).removeAttr("disabled");
    $(newProfileDialogbuttons[1]).css('color', 'blue');
  }
}

/***************************************
* Validate the Create New Profile Form *
****************************************/
function validateCreateNewProfile()
{
  requiredFieldsID = [
    "Forename-Input",
    "Surname-Input",
    "Date-of-Birth",
    "Street-and-Number-Input",
    "Town-Input",
    "Post-Code-Input",
    "Department-Select",
    "Department-Position-Select",
    "Department-Position-Level-Select",
    "Tin-Number-Input",
    "PhilHealth-Number-Input",
    "SSS-Number-Input",
  ];
  
  var missing = [];
  
  $.each(requiredFieldsID, function(index, ID)
  {
    var element = $("#" + ID);
    
    if(element.val() == '')
    {
      missing.push(ID);
      element.css('background-color', '#FF8080').css('color', '#FFF');
    }
    
    // -- Validate Date of Birth
    // -------------------------
    if(ID == 'Date-of-Birth')
    {
      var pattern = /^\d{1,2}\-\d{1,2}\-\d{4}$/;
      
      if(!document.getElementById(ID).value.match(pattern))
      {
        missing.push(ID);
        $("#DOB-Error").html('Invalid format must be dd-mm-yyyy');
        element.css('background-color', '#FF8080').css('color', '#FFF');
      }
    }
  });
  
  if(missing.length > 0)
  {
    return false;
  }
  else
  {
    return true;
  }
}

/************************************************
* Create and Save a new profile for an employee *
************************************************/
function saveEmployeeProfile()
{
  $.ajax({
    url: '/hr/ajaxcalls/save_profile/' + empID + '.json',
    type: 'post',
    dataType: 'json',
    data: $("#Employee-New-Profile-Form").serialize(),
    success: function(data)
    {
      if(data['status'] == 'SUCCESS')
      {
        alert('Employee Profile has been saved');
        location.reload();
      }
      else
      {
        alert('Employee Profile could not be saved. Please inform the I.T. Department');
        $("#Create-New-Profile-Dialog").dialog("close");
      }
    }
  });
}

// -- Change the Job Position List depending on the department
// -----------------------------------------------------------
function changeJobPositionList(departmentID)
{
  $.ajax({
    url: '/hr/ajaxcalls/department_position_list/' + departmentID + '.json',
    type: 'post',
    success: function(data)
    {
      if(data['status'] == 'SUCCESS')
      {
        var options = '<option value="-1">-- Select --</option>';
        
        if(data['results'].length > 0)
        {
          $.each(data['results'], function(index, value)
          {
            options += '<option value="' + value['id'] + '"' + (positionID == value['id'] ? ' SELECTED' : false) + '>' + value['job_role'] + '</option>';
          }); 
        }
        
        $("#Department-Position-Select").html(options);
      }
    }
  });
}

// -- Change the Position Level ID depending on the position
// ---------------------------------------------------------
function changeJobPositionLevelList(positionID)
{
  $.ajax({
    url: '/hr/ajaxcalls/department_posistion_level_list/' + positionID + '.json',
    type: 'post',
    success: function(data)
    {
      if(data['status'] == 'SUCCESS')
      {
        var options = '<option value="-1">-- Select --</option>';
        
        if(data['results'].length > 0)
        {
          $.each(data['results'], function(index, value)
          {
            options += '<option value="' + value['id'] + '"' + (positionLevelID == value['id'] ? ' SELECTED' : false) + '>' + value['name'] + '</options>';
          });
        }
        
        $("#Department-Position-Level-Select").html(options);
      }
    }
  });
}