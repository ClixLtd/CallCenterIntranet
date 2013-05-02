<h2>Viewing #<?php echo $survey_response->id; ?></h2>

<p>
	<strong>Reference:</strong>
	<?php echo $survey_response->reference; ?></p>
<p>
	<strong>Question id:</strong>
	<?php echo $survey_response->question_id; ?></p>
<p>
	<strong>Answer id:</strong>
	<?php echo $survey_response->answer_id; ?></p>
<p>
	<strong>Extra:</strong>
	<?php echo $survey_response->extra; ?></p>

<?php echo Html::anchor('survey/response/edit/'.$survey_response->id, 'Edit'); ?> |
<?php echo Html::anchor('survey/response', 'Back'); ?>