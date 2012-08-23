<h2>Viewing #<?php echo $help_topic->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $help_topic->title; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $help_topic->description; ?></p>

<?php echo Html::anchor('help/topic/edit/'.$help_topic->id, 'Edit'); ?> |
<?php echo Html::anchor('help/topic', 'Back'); ?>