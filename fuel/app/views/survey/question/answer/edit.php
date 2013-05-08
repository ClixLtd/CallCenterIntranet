<h2>Editing Survey_question_answer</h2>
<br>

<?php echo render('survey/question/answer/_form'); ?>
<p>
	<?php echo Html::anchor('survey/question/answer/view/'.$survey_question_answer->id, 'View'); ?> |
	<?php echo Html::anchor('survey/question/answer', 'Back'); ?></p>
