<h2>Editing Survey_response</h2>
<br>

<?php echo render('survey/response/_form'); ?>
<p>
	<?php echo Html::anchor('survey/response/view/'.$survey_response->id, 'View'); ?> |
	<?php echo Html::anchor('survey/response', 'Back'); ?></p>
