<h2>Viewing #<?php echo $survey_question->id; ?></h2>

<p>
	<strong>Survey id:</strong>
	<?php echo $survey_question->survey_id; ?></p>
<p>
	<strong>Question:</strong>
	<?php echo $survey_question->question; ?></p>

<?php echo Html::anchor('survey/question/edit/'.$survey_question->id, 'Edit'); ?> |
<?php echo Html::anchor('survey/question', 'Back'); ?>