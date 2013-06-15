<h2>Viewing #<?php echo $survey_lead_batch->id; ?></h2>

<p>
	<strong>Supplier id:</strong>
	<?php echo $survey_lead_batch->supplier_id; ?></p>
<p>
	<strong>Date added:</strong>
	<?php echo $survey_lead_batch->date_added; ?></p>
<p>
	<strong>Filename:</strong>
	<?php echo $survey_lead_batch->filename; ?></p>
<p>
	<strong>Collected:</strong>
	<?php echo $survey_lead_batch->collected; ?></p>
<p>
	<strong>Date collected:</strong>
	<?php echo $survey_lead_batch->date_collected; ?></p>

<?php echo Html::anchor('survey/lead/batches/edit/'.$survey_lead_batch->id, 'Edit'); ?> |
<?php echo Html::anchor('survey/lead/batches', 'Back'); ?>