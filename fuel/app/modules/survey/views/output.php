<script>
	var apiKey = "<?php echo $apiKey; ?>";
  var surveyID = "<?php echo $surveyID;?>";
  var rebuttalURL = "<?php echo $rebuttalURL;?>";
</script>

<!--
<div id="Rebuttal">
  <iframe width="100%" height="100%" src="<?php echo $rebuttalURL;?>" seamless></iframe>
</div>
-->

<form id="SurveyForm">
	
  <input type="hidden" name="AgentID" value="<?php echo $gets['AgentID']; ?>" />			
	<input type="hidden" name="agent" value="<?php echo $gets['agent']; ?>" />
	<input type="hidden" name="list" value="<?php echo $gets['list']; ?>" />
  <input type="hidden" name="lead_id" value="<?php echo $gets['lead_id'];?>" />
  <input type="hidden" name="ListName" value="<?php echo $gets['ListName'];?>" />
	
	<div id="thankYou" class="decisionPopup">
		<h1>Thank You</h1>
		
		<p><div id="Success-Message"></div></p>
    <p><div id="LeadpoolID"></div></p>
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
