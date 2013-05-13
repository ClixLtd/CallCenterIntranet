<h2>Editing Survey</h2>
<br>

<?php echo render('survey/_form'); ?>
<p>
	<?php echo Html::anchor('survey/view/'.$survey->id, 'View'); ?> |
	<?php echo Html::anchor('survey', 'Back'); ?></p>
