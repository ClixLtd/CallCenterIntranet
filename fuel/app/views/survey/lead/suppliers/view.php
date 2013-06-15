<h2>Viewing #<?php echo $survey_lead_supplier->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $survey_lead_supplier->name; ?></p>
<p>
	<strong>Email:</strong>
	<?php echo $survey_lead_supplier->email; ?></p>
<p>
	<strong>Key:</strong>
	<?php echo $survey_lead_supplier->key; ?></p>

<?php echo Html::anchor('survey/lead/suppliers/edit/'.$survey_lead_supplier->id, 'Edit'); ?> |
<?php echo Html::anchor('survey/lead/suppliers', 'Back'); ?>