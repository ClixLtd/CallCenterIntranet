<style>
	.invalidForm
	{
		background-image: URL(/assets/img/icons/icon_error.png);
		background-position: 98% center;
		background-repeat: no-repeat;
	}
</style>

<script>

	$(document).ready(function(){
		
		$('input').change(function() {
			$(this).removeClass('invalidForm');
		});
		
		$('#PPIForm').submit(function() {
			// Reset the alert area and form colours.
			$(".ajaxVerify").removeClass('invalidForm');
			$('#errorHolder').html('');
			
			// Do the post of the data
			$.post('https://intranet.gregsonandbrooke.co.uk/ppi/api/submit/vnbb7zw0ifpvh1z267w4.json', 
			$('#PPIForm').serialize(), 
			function(data) {
				if (data['status'] == 'FAIL')
				{
					$('#errorHolder').html('<div id="errorMessage" class="notification error">'+data['message']+'</div>');
					if (data['code'] == '101')
					{
						$.each(data['missing_fields'], function(key, value) {
							$('input[name="'+value+'"]').addClass('invalidForm');
						});
					}
				}
				else
				{
					
				}
				
			});
			
			return false;
		
		});
	
	});

</script>


<div id="errorHolder"></div>

<form id="PPIForm">

<select name="title">
	<option>Mr</option>
	<option>Miss</option>
	<option>Mrs</option>
	<option>Ms</option>
	<option>Dr</option>
</select><br />

<input type="text" class="ajaxVerify" name="firstname"><br />
<input type="text" class="ajaxVerify" name="lastname"><br />
<input type="text" class="ajaxVerify" name="address1"><br />
<input type="text" class="ajaxVerify" name="address2"><br />
<input type="text" class="ajaxVerify" name="address3"><br />
<input type="text" class="ajaxVerify" name="town"><br />
<input type="text" class="ajaxVerify" name="county"><br /><br />

<select name="question1">
	<option value="">--- Please Choose</option>
	<option>Answer One</option>
	<option>Answer Two</option>
	<option>Answer Three</option>
	<option>Answer Four</option>
	<option>Answer Five</option>
</select>



<input type="submit" id="submitPPI">

</form>