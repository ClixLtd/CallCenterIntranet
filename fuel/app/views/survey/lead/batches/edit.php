<h2>Editing Survey_lead_batch</h2>
<br>

<?php echo render('survey/lead/batches/_form'); ?>
<p>
	<?php echo Html::anchor('survey/lead/batches/view/'.$survey_lead_batch->id, 'View'); ?> |
	<?php echo Html::anchor('survey/lead/batches', 'Back'); ?></p>
