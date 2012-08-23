<h2>Editing Help_topic</h2>
<br>

<?php echo render('help/topic/_form'); ?>
<p>
	<?php echo Html::anchor('help/topic/view/'.$help_topic->id, 'View'); ?> |
	<?php echo Html::anchor('help/topic', 'Back'); ?></p>
