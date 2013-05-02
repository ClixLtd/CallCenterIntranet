<h2>Viewing #<?php echo $survey->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $survey->title; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $survey->description; ?></p>
<p>
	<strong>Type:</strong>
	<?php echo $survey->type; ?></p>

<?php echo Html::anchor('survey/edit/'.$survey->id, 'Edit'); ?> |
<?php echo Html::anchor('survey', 'Back'); ?>