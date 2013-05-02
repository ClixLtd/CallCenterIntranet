<h2>Viewing #<?php echo $survey_question_answer->id; ?></h2>

<p>
	<strong>Question id:</strong>
	<?php echo $survey_question_answer->question_id; ?></p>
<p>
	<strong>Answer:</strong>
	<?php echo $survey_question_answer->answer; ?></p>

<?php echo Html::anchor('survey/question/answer/edit/'.$survey_question_answer->id, 'Edit'); ?> |
<?php echo Html::anchor('survey/question/answer', 'Back'); ?>