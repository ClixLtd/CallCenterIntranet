$(function () {

	$(".companyChoice").click(function() {
		$(".companyChoice").removeClass('selected');
		$(".companyChoice").addClass('deselected');
		
		$(this).addClass('selected');
		
		var companyText = $(this).attr('id');
		
		$("#form_letterhead_company").val(companyText.replace('company',''));
		
	});

});