<h2>Editing Survey_question</h2>
<br>

<?php echo render('survey/question/_form'); ?>
<p>
	<?php echo Html::anchor('survey/question/view/'.$survey_question->id, 'View'); ?> |
	<?php echo Html::anchor('survey/question', 'Back'); ?></p>
