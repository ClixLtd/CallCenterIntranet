<script>
	var apiKey = "<?php echo $apiKey; ?>";
  var surveyID = "<?php echo $surveyID;?>";
</script>

<form id="SurveyForm">
				
	<input type="hidden" name="agent" value="<?php #echo $gets['agent']; ?>">
	<input type="hidden" name="list" value="<?php #echo $gets['list']; ?>">
	
	<div id="thankYou" class="decisionPopup">
		<h1>Thank You</h1>
		
		<p>This Survey has been received.</p>
	
	</div>
	
	
	<div id="ppiClient" class="decisionPopup">
		<h1>PPI Client</h1>
		
		<p>Please give the following reference to the senior</p>
		
		<h2 id="ppiClientID">182440</h2>
	
	</div>
	
	
	<div id="drClient" class="decisionPopup">
		<h1>Product Recommendation</h1>
		
		<p>These Products have been recommended</p>
		
		<h2 id="drClientID">
      
    </h2>
    <div id="Products"></div>
	</div>
	
	
	<div id="ppiChecker">
	
		<div id="validateSpinner" style="display: none;"><?php echo Asset::img('darkspinner.gif'); ?> Please Wait...</div>
		
		<input type="submit" value="<?php #echo $buttonText;?> Save Survey" id="saveButton" />
	
	</div>

	<div class="container-fluid">
		
		<div class="row-fluid">
			
			<div class="span12 error" id="errorMessage" style="display: none;">
				There has been an error!
			</div>
			
		</div>
		
		
		<div class="row-fluid">
			
			<div class="span12 notice" id="mailMessage" style="display: none;">
				Please ensure you have confirmed the Alternate contact number and the E-Mail address for the client.
			</div>
			
		</div>
		
		<div class="row-fluid">
			
			
			<div class="span12">
				
        <!-- QUESTIONS -->
        
				<?=$surveyForm;?>
				
        <!-- END QUESTIONS -->
			</div>
		
		</div>

	</div>

</form>
