<h2>Viewing #<?php echo $survey_lead_log->id; ?></h2>

<p>
	<strong>Referral id:</strong>
	<?php echo $survey_lead_log->referral_id; ?></p>
<p>
	<strong>Batch id:</strong>
	<?php echo $survey_lead_log->batch_id; ?></p>

<?php echo Html::anchor('survey/lead/log/edit/'.$survey_lead_log->id, 'Edit'); ?> |
<?php echo Html::anchor('survey/lead/log', 'Back'); ?>