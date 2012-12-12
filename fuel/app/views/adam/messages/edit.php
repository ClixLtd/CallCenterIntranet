<h2>Editing Adam_message</h2>
<br>

<?php echo render('adam/messages/_form'); ?>
<p>
	<?php echo Html::anchor('adam/messages/view/'.$adam_message->id, 'View'); ?> |
	<?php echo Html::anchor('adam/messages', 'Back'); ?></p>
